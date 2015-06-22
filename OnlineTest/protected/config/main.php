<?php 

include_once 'variables.php';
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => NAME,
    'defaultController' => 'redirect',

     'preload'=>array('log'),
    'language' => 'en',
    // autoloading model and component classes
    'import' => array(
        'ext.YiiMongoDbSuite.*',
        'ext.restfullyii.components.*',
        'ext.YiiConditionalValidator.*',
        'application.models.*',
        'application.components.*',
        'application.models.mongo.*',
        'application.components.*',
        'application.service.*',
        'application.models.mysql.*',
        'application.models.datamigration.*',
        'ext.yii-mail.YiiMailMessage',
        'application.renderscript.*',
        'application.models.mysql.*',
        'application.models.beans.*',
        'application.extensions.EAjaxUpload.*',
        'application.extensions.YiiTagCloud',
        'application.extensions.oauth.*',
        'ext.GoogleAnalytics.*',
        'application.vendors.*',
        'application.vendors.phpexcel.PHPExcel',
        'application.vendors.phpexcel.MPDF56',
        'ext.yiiexcel.*',
        'ext.yiireport.*',
          'ext.JGoogleAPI.*',
    ),
    'modules' => array(
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'site' => array('/site/index', 'caseSensitive' => false),
                'stream' => array('marketresearchwall', 'caseSensitive' => false),             
               '/site/index' => array('/site/index', 'caseSensitive' => false),
                '/' => array('/site/register', 'caseSensitive' => false),
                'users' => array('admin/userManagement', 'caseSensitive' => false),               
                
                'newmarketresearch' => array('/extendedSurvey/index', 'caseSensitive' => false),
                'marketresearchwall' => array('/extendedSurvey/surveyDashboard', 'caseSensitive' => false),
                'testpaper' => array('/testPaper/surveyDashboard', 'caseSensitive' => false),
                'newtestpaper' => array('/testPaper/index', 'caseSensitive' => false),
                'marketresearchview/[0-9]*/<var:[^\/]*>*' => array('/outside/index', 'caseSensitive' => false),
                
                 '<controller:[^\/]+>/managesurvey/[a-zA-Z0-9_]*/' => array('/extendedSurvey/manageSurvey'),
               
               
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'mongodb' => array(
            'class' => 'EMongoDB',

            'connectionString' => 'mongodb://'.DBIPMONGO.':27017',
            'dbName' => DBNAMEMONGO,

            'fsyncFlag' => true,
            'safeFlag' => true,
            'useCursor' => false
        ),
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host='.DBIPMYSQL.';dbname='.DBNAME,
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => DBPASSWORD,
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
         
            'errorAction' => 'common/error',
        ),
        'log' => array(
    'class' => 'CLogRouter',
    'routes' => array(
        array(
            'class' => 'CFileLogRoute',
                    'levels' => 'error',
                    'categories' => 'system.*',
        ),
        array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error,warning',
                    'categories' => "application",
                    'logFile' => 'error.log' . date('d-m-y'),
        ),
         array(
                    'class'=>'ext.LogDb',
                    'autoCreateLogTable'=>true,
                    'connectionID'=>'db',
                    'enabled'=>true,
                    'levels'=>'error',//You can replace trace,info,warning,error
                ),
    ),
),
        /*
         * amqp object creation. 
         */
        'amqp' => array(
            'class' => 'application.extensions.amqp.amqp',
        ),
        'simpleImage' => array(
            'class' => 'application.extensions.simpleImage.CSimpleImage',
        ),
        'config' => array
            (
            'class' => 'ext.FileConfig',
            'configFile' => dirname(__FILE__) . '/SkiptaNeoConfig.php',
        ),
        'ePdf' => array(
            'class' => 'ext.yii-pdf.EYiiPdf',
            'params' => array(
                'mpdf' => array(
                    'librarySourcePath' => 'application.vendors.mpdf.*',
                    'constants' => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                /* 'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                  'mode'              => '', //  This parameter specifies the mode of the new document.
                  'format'            => 'A4', // format A4, A5, ...
                  'default_font_size' => 0, // Sets the default document font size in points (pt)
                  'default_font'      => '', // Sets the default font-family for the new document.
                  'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                  'mgr'               => 15, // margin_right
                  'mgt'               => 16, // margin_top
                  'mgb'               => 16, // margin_bottom
                  'mgh'               => 9, // margin_header
                  'mgf'               => 9, // margin_footer
                  'orientation'       => 'P', // landscape or portrait orientation
                  ) */
                ),
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendors.html2pdf.*',
                    'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
                /* 'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                  'orientation' => 'P', // landscape or portrait orientation
                  'format'      => 'A4', // format A4, A5, ...
                  'language'    => 'en', // language: fr, en, it ...
                  'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                  'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                  'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                  ) */
                )
            ),
        ),'sendgrid'=>array(
            'class' => 'ext.sendgrid.SendGrid',
            'sg_user'=>  SendGrid_UserName,
            'sg_api_key'=>SendGrid_Password, 
        ),
  'JGoogleAPI' => array(
            'class' => 'ext.JGoogleAPI.JGoogleAPI',
            //Default authentication type to be used by the extension
            'defaultAuthenticationType'=>'serviceAPI',
 
            //Account type Authentication data
            'serviceAPI' => array(
                'clientId' => '427102878877-annusjifk6qvpkoautsrqbpln8akv4fq.apps.googleusercontent.com',
                'clientEmail' => '427102878877-annusjifk6qvpkoautsrqbpln8akv4fq@developer.gserviceaccount.com',
                'keyFilePath' => '/usr/share/nginx/www/'.NETWORKNAME.'/protected/extensions/JGoogleAPI/Skipta-7368a438d952.p12',
            ),
           
            //Scopes needed to access the API data defined by authentication type
            'scopes' => array(
                'serviceAPI' => array(
                    'drive' => array(
                        'https://www.googleapis.com/auth/analytics.readonly',
                    ),
                ),
                'webappAPI' => array(
                    'drive' => array(
                        'https://www.googleapis.com/auth/analytics.readonly',
                    ),
                ),
            ),
            //Use objects when retriving data from api if true or an array if false
            'useObjects'=>true,
        ),
     
    ),
    'params' => require(dirname(__FILE__) . '/SkiptaNeoConfig.php'),
);
