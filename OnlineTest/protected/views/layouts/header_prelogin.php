<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo Yii::t('translation', 'ProjectTitle'); ?></title>
        <!-- -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" media="screen" />
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/customswitch.css"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-onlinetest.css" rel="stylesheet" type="text/css" />
        
        
        
        
                <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-switch.min.js"></script>
                <script type="text/javascript">                    
                    $(document).ready(function(){
                            /* Get browser */
                            $.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());

                            /* Detect Chrome */
                            if($.browser.chrome){

                            /* Do something for Chrome at this point */
                            /* Finally, if it is Chrome then jQuery thinks it's
                            Safari so we have to tell it isn't */
                            $.browser.safari = false;
                            } 

                            /* Detect Safari */
                            if($.browser.safari){
                            /* Do something for Safari */
                                var fileref=document.createElement("link")
                                fileref.setAttribute("rel", "stylesheet")
                                fileref.setAttribute("type", "text/css")
                                fileref.setAttribute("href", "<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-safaristyles.css")
                                if (typeof fileref!="undefined")
                                document.getElementsByTagName("head")[0].appendChild(fileref)
                            }

                        });
         
        </script>
                <!-- -->
</head>