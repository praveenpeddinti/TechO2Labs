<?php

/**
 * DocCommand class file.
 *
 * @author Moin Hussain
 * @usage Updating User Handler in TinyUserCollection server version
 *  @version 1.0
 */
class RestartAMQPCommand extends CConsoleCommand {

    public function run($args) {
        $this->restartAMQP();
        $this->restartProxyNode();
    }

    function restartAMQP() {
        try{
        $networkName = Yii::app()->params['WebrootPath'];
        $networkName = explode("/", $networkName);
        $networkName = $networkName[5];
        $ququeName = substr($networkName, 1);
        $firstChar = substr($networkName, 0, 1);
        $ququeName = "[" . $firstChar . "]" . $ququeName;
        $x = exec("ps aux | grep '$ququeName/protected/yiic.php amqp activities' | awk '{print $2}' ");
        if (trim($x) == "") {
            $logname = date("Y-m-d-H-i").'activities';
            $f1 = "/data/logs/amqp/" . $networkName;
            if (!file_exists($f1)) {
                mkdir($f1, 0755, true);
            }

            shell_exec("touch /data/logs/amqp/".$networkName."/".$logname.".log");
            chdir('/usr/share/nginx/www/' . $networkName . '/protected');
            echo shell_exec("nohup php /usr/share/nginx/www/" . $networkName . "/protected/yiic.php  amqp activities   > /data/logs/amqp/".$networkName."/" .$logname.".log &");
        }
         else {
            echo "AMQP activities Running";
        }
            $x = exec("ps aux | grep '$ququeName/protected/yiic.php amqp achievements' | awk '{print $2}' ");
        if (trim($x) == "") {
            $logname = date("Y-m-d-H-i").'achievements';
            $f1 = "/data/logs/amqp/" . $networkName;
            if (!file_exists($f1)) {
                mkdir($f1, 0755, true);
            }

            shell_exec("touch /data/logs/amqp/".$networkName."/".$logname.".log");
            chdir('/usr/share/nginx/www/' . $networkName . '/protected');
            echo shell_exec("nohup php /usr/share/nginx/www/" . $networkName . "/protected/yiic.php  amqp achievements   > /data/logs/amqp/".$networkName."/" .$logname.".log &");
      
        }
         else {
            echo "AMQP achievements Running";
        }
         $x = exec("ps aux | grep '$ququeName/protected/yiic.php amqp geolocation' | awk '{print $2}' ");
          if (trim($x) == "") {
            $logname = date("Y-m-d-H-i").'geolocation';
            $f1 = "/data/logs/amqp/" . $networkName;
            if (!file_exists($f1)) {
                mkdir($f1, 0755, true);
            }

            shell_exec("touch /data/logs/amqp/".$networkName."/".$logname.".log");
            chdir('/usr/share/nginx/www/' . $networkName . '/protected');
            echo shell_exec("nohup php /usr/share/nginx/www/" . $networkName . "/protected/yiic.php  amqp geolocation   > /data/logs/amqp/".$networkName."/" .$logname.".log &");
      
        }
            
            
        else {
            echo "AMQP  geolocation Running";
        }
        } catch (Exception $ex) {
            Yii::log("RestartAMQPCommand:restartAMQP::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }

    function restartProxyNode() {
        try{
        $networkName = Yii::app()->params['WebrootPath'];
        $networkName = explode("/", $networkName);
        $networkName = $networkName[5];
        $ququeName = substr($networkName, 1);
        $firstChar = substr($networkName, 0, 1);
        $ququeName = "[" . $firstChar . "]" . $ququeName;
        $x = exec("ps aux | grep '/opt/softwares/node/$ququeName/proxyNode.js' | awk '{print $2}' ");
        if (trim($x) == "") {
            $date = date("Y-m-d-H-i");;
            
            shell_exec("touch /data/logs/node/".$networkName."/ProxyNode/".$date . ".log");
            chdir('/opt/softwares/node/' . $networkName . '/');
            echo shell_exec("nohup /usr/local/bin/node /opt/softwares/node/" . $networkName . "/proxyNode.js  > /data/logs/node/" . $networkName . "/ProxyNode/" . $date . ".log &");
        }
        else{
            echo "Proxy Node Running";
        }
        } catch (Exception $ex) {
            Yii::log("RestartAMQPCommand:restartProxyNode::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    
    

}
