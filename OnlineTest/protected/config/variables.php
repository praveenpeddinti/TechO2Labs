<?php

if(DEPLOYMENT_MODE=='DEVELOPMENT'){
defined('DBNAME') || define('DBNAME','TO2_OnlineTest');
defined('DBPASSWORD') || define('DBPASSWORD','SkiptaNeo2013!');
defined('DBNAMEMONGO') || define('DBNAMEMONGO','TO2_OnlineTest');
defined('NAME') || define('NAME','Techo2 Online Test');
defined('DBIPMYSQL') || define('DBIPMYSQL','localhost');
defined('DBIPMONGO') || define('DBIPMONGO','127.0.0.1');
define('SendGrid_UserName','skipta');
define('SendGrid_Password','four1234');
}
if(DEPLOYMENT_MODE=='SANDBOX'){
defined('DBNAME') || define('DBNAME','Trinity');
defined('DBPASSWORD') || define('DBPASSWORD','Trinity');
defined('NAME') || define('NAME','Trinity');
defined('DBIPMYSQL') || define('DBIPMYSQL','localhost');
defined('DBIPMONGO') || define('DBIPMONGO','127.0.0.1');
define('SendGrid_UserName','');
define('SendGrid_Password','');
}
if(DEPLOYMENT_MODE=='PRODUCTION'){
defined('DBNAME') || define('DBNAME','TO2_OnlineTest');
defined('DBPASSWORD') || define('DBPASSWORD','SkiptaNeo2013!');
defined('DBNAMEMONGO') || define('DBNAMEMONGO','TO2_OnlineTest');
defined('NAME') || define('NAME','Techo2 Online Test');
defined('DBIPMYSQL') || define('DBIPMYSQL','localhost');
defined('DBIPMONGO') || define('DBIPMONGO','127.0.0.1');
define('SendGrid_UserName','skipta');
define('SendGrid_Password','four1234');
}
