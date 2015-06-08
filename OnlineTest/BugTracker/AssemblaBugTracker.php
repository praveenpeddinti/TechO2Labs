
<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'SkiptaNeo2013!');
define('DB', 'SkiptaNeoDB');

define('ASSEMBLA_KEY', '06a8de0f65872e91365d');
define('ASSEMBLA_SECRET', 'dc2744a50180061f4f424bd1ecd59d56578cc5b9');
define('ASSEMBLA_SPACE', 'skipta-neo');
define('MILESTONE_ID', '7833283');
define('ASSEMBLA_URL', 'https://api.assembla.com/v1/spaces/skipta-neo/tickets/');

require_once('assembla.class');


try {
// Connecting, selecting database
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die('Could not connect: ' . mysql_error());
//echo 'Connected successfully';
    mysql_select_db(DB) or die('Could not select database');

// Performing SQL query

    $query = 'SELECT * FROM YIIAssemblaConf where Id=1';

    $res = mysql_query($query);
    $LogId = mysql_fetch_object($res)->YiiLogId;


    $query = 'SELECT * FROM YiiLog where id> ' . $LogId . ' and title is not null';
    // $query = "SELECT * FROM YiiLog where title='Exception in postController:actionStream'";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());
    $data = array();
    while ($line1 = mysql_fetch_array($result)) {
        array_push($data, $line1);
    }


    foreach ($data as $line) {

        $title = stripslashes($line['title']);
        $message = stripslashes($line['message']);
       $message = $line['logtime'].": ".$message;
        $selectTicketQuery = "select * from YiiAssemblaTicket where title like '%" . mysql_real_escape_string($title) . "%' order by Id desc limit 1 ";
        // error_log($selectTicketQuery);
        $selectTicketQueryRes = mysql_query($selectTicketQuery); //"select * from YiiAssemblaTicket where message like '%testtttreddytttttttttttt in /opt/lampp/htdocs/CoActive/protected/components/Controller.php (47)%' order by Id desc limit 1") or die('88888888888888888888888');

        $T_Obj = mysql_fetch_object($selectTicketQueryRes);

        if (isset($T_Obj->message)) {
            try {
                echo "----ticket is going to be updated-------\n";

                $ticket_number = $T_Obj->TicketNumber;
                $assemblaObj = new Assembla();
                $response = $assemblaObj->getTicket($ticket_number);
                $jsonDecodeObject = json_decode($response);
                $status = $jsonDecodeObject->status;
                if ($status != "New" || $status != "Re-opened") {
                    /* To update the status of the ticket */
                    $status = 'Re-opened';
                    $response = $assemblaObj->statusUpdate($ticket_number, $status);
                }

                $oldDescription = $jsonDecodeObject->description;
                $newDescription = $oldDescription . "\n \n" . ($T_Obj->NoOfOccurance + 1) . ") " . $message;
                $newDescription = preg_replace("/[\n\r]/", "\\n", $newDescription);
                 $newDescription = str_replace('"',"'",$newDescription);
                $myAssemblaPlugin = new MyAssemblaPlugin();
                $myAssemblaPlugin->updateDescription($newDescription, $ticket_number);
                $myAssemblaPlugin->updateCustomField("Number Of Occurences", $T_Obj->NoOfOccurance + 1, $ticket_number);

                $updateTicketNumber = "update YiiAssemblaTicket set NoOfOccurance=NoOfOccurance+1,message='" . mysql_real_escape_string($newDescription) . "' where title like '%" . mysql_real_escape_string($title) . "%'";
                 $result = mysql_query($updateTicketNumber);
                if (!$result) {
                    echo " excepiton occured while updating into YiiAssemblaTicket";
                }
            } catch (Exception $e) {
                error_log(" excepiton occured while update  ticket into assembla");
            }
        } else {

            echo "----ticket is going to be created-------\n";
            try {
                $title = $line['title'];
                $descritpion = $line['message'];
                $descritpion = str_replace('"',"'",$descritpion);
                $priority = 'normal';
                $estimate = 'none';
                //$custom_fields	= array('xxxx'=>'00000');
                $milestone_id = MILESTONE_ID;
                $A = new Assembla();
                $response = $A->createTicket($title, "1) " . $descritpion, $priority, $estimate, $milestone_id);
                $jsonDecodeObject = json_decode($response);
                $message = trim(preg_replace('/\s+/', ' ', $line['message']));
                $insertQuery = "insert into YiiAssemblaTicket (level,category,logtime,IP_User,user_name,request_URL,title,message,TicketId,TicketType,TicketNumber,NoOfOccurance) values('" . $line['level'] . "','" . $line['category'] . "','" . $line['logtime'] . "','" . $line['IP_User'] . "','" . $line['user_name'] . "','" . $line['request_URL'] . "','" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($message) . "',$jsonDecodeObject->id,'NEW',$jsonDecodeObject->number,1)";
                //  error_log($insertQuery);
                $result = mysql_query($insertQuery);
                if (!$result) {
                    echo " excepiton occured while inserted into YiiAssemblaTicket";
                }
            } catch (Exception $e) {
                echo " excepiton occured while inserted  or created ticket into assembla";
            }
        }


        $query = "update YIIAssemblaConf  set YiiLogId=" . $line['id'] . "   where Id=1";
        $result = mysql_query($query);
    }

    mysql_close($link);
} catch (Exception $e) {

    error_log(" excepiton occured while process automation  error log system");
}
/*
 * Moin Hussain
 * Class to perform update operations on Assembla
 */

class MyAssemblaPlugin {

    function updateDescription($description, $ticketNumber) {
        system('curl -i -X PUT -H "X-Api-Key: ' . ASSEMBLA_KEY . '" -H "X-Api-Secret: ' . ASSEMBLA_SECRET . '" -H "Content-type: application/json" -d \'{"ticket":{"description":"' . $description . '"}}\' ' . ASSEMBLA_URL . '' . $ticketNumber . '.json');
    }

    function updateCustomField($field, $value, $ticketNumber) {
        system('curl -i -X PUT -H "X-Api-Key: ' . ASSEMBLA_KEY . '" -H "X-Api-Secret: ' . ASSEMBLA_SECRET . '" -H "Content-type: application/json" -d \'{"ticket":{"custom_fields":{"' . $field . '":"' . $value . '"}}}\' ' . ASSEMBLA_URL . '' . $ticketNumber . '.json');
    }

}

?>
