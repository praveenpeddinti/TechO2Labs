<?php
defined('DEPLOYMENT_MODE') || define('DEPLOYMENT_MODE','DEVELOPMENT');
// change the following paths if necessary
$yiic=dirname(__FILE__).'/../../yii/framework/yiic.php';
$config=dirname(__FILE__).'/config/console.php';

require_once($yiic);