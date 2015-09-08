<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'defaultController' => 'Techo2Employee',
    'name' => 'Techo2 - HRM',
    // preloading 'log' component
    'preload' => array('log'),
    'language' =>'en',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.mysql.*',
        'application.models.formModels.*',
        'application.components.*',
        'application.service.*',
        'application.controllers.*',
    ),
    'modules' => array(
    // uncomment the following to enable the Gii tool
    /*
      'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'Enter Your Password Here',
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('127.0.0.1','::1'),
      ),
     */
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
             'showScriptName'=>false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        
        // Database Configurations
        'db' => require(dirname(__FILE__) . '/database.php'),
        
        
        //Unexpected Errors Like Unknow Controller Or Methods
        'errorHandler' => array(
            'errorAction' => 'Techo2Employee/Error',
        ),
        
        
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'trace, info, error, warning, vardump',
                ),
                
//                array(
//                    'class' => 'CFileLogRoute',
//                    'levels' => 'error,warning',
//                    'categories' => "application",
//                    'logFile' => 'error.log' . date('d-m-y'),
//               ),
//                
//                 array(
//                    'class'=>'ext.LogDb',
//                    'autoCreateLogTable'=>true,
//                    'connectionID'=>'db',
//                    'enabled'=>true,
//                    'levels'=>'error',//You can replace trace,info,warning,error
//                ),
                
                
             //uncomment the following to show log messages on web pages
             /* array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    
    
    // application-level parameters that can be accessed
    'params' => array(
      //  'widgetLables' => require(dirname(__FILE__) . '/WidgetLabels.php'),
       // 'pageTitles' => require(dirname(__FILE__) . '/PageTitles.php'),
       // 'errorMessages' => require(dirname(__FILE__) . '/ErrorMessages.php'),
      //  'successMessages' => require(dirname(__FILE__) . '/SuccessMessages.php'),
       // 'infoMessages' => require(dirname(__FILE__) . '/InfoMessages.php'),
    ),
);
