 <?php

/*
 * Developer Sagar Pathapelli
 * on 11th May 2015
 * @usage : used for zio rest calls
 */

class RestNeoNetworkController extends CController {
    
    private $format = 'json';
    
    public function filters()
    {
            return array();
    }

    public function actionStatus() {
        try {
            $input = file_get_contents("php://input");
            error_log("==========================".$input);
            $data = json_decode($input);
            $access_key=$data->AccessKey;
            $community_id=$data->Community_ID;
            $this->_checkAuth($access_key,$community_id);
            $status = strtolower($data->Status);
            $reason = strtolower($data->Reason);
            try {
                $result="error";
                $userObj= User::model()->getUserByType($data->Email, "Email");
                if($userObj!="noUser"){
                    if($reason=="bounce"){
                        $result = ServiceFactory::getSkiptaUserServiceInstance()->updateUserStatus($userObj->UserId, 2);//suspend
                    }else{
                        $result = ServiceFactory::getSkiptaUserServiceInstance()->disableDigest($userObj->UserId);
                    }
                }
                if ($result=="success") {
                    $this->_sendResponse(200, "Success");
                } else {
                    $this->_sendResponse(200, "0 rows effected");
                }
            } catch (Exception $e) {
                $this->_sendResponse($e->getCode(), $e->getMessage());
            }
        } catch (Exception $ex) {
            
        }
    }
   
    /**
     * Sends the API response 
     * 
     * @param int $status 
     * @param string $body 
     * @param string $content_type 
     * @access private
     * @return void
     */
    private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
       
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch($status)
            {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
                default :
                    $message = $body;
            }
            $body='{"Status":"'.$status.'","Message":"'.$message.'"}';
            echo $body;
            exit;
        
    } // }}}            
    // {{{ _getStatusCodeMessage
    /**
     * Gets the message for a status code
     * 
     * @param mixed $status 
     * @access private
     * @return string
     */
    private function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }
    /**
     * Checks if a request is authorized
     * 
     * @access private
     * @return void
     */
    private function _checkAuth($access_key,$community_id)
    {
        if($access_key=='' || $community_id=='') {
            $this->_sendResponse(401);
        }
        else
        {
            if(!($access_key==Yii::app()->params['AccessKey'] && $community_id==Yii::app()->params['NetWorkId'])) {
                $this->_sendResponse(401);
            } 
        }
    } 
    
    /**
     * Returns the json or xml encoded array
     * 
     * @param mixed $model 
     * @param mixed $array Data to be encoded
     * @access private
     * @return void
     */
    private function _getObjectEncoded($model, $array)
    {
        if(isset($_GET['format']))
            $this->format = $_GET['format'];

        if($this->format=='json')
        {
            return CJSON::encode($array);
        }
        elseif($this->format=='xml')
        {
            $result = '<?xml version="1.0">';
            $result .= "\n<$model>\n";
            foreach($array as $key=>$value)
                $result .= "    <$key>".utf8_encode($value)."</$key>\n"; 
            $result .= '</'.$model.'>';
            return $result;
        }
        else
        {
            return;
        }
    }
}

?>
