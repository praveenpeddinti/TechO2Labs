<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Powered by Skipta technology, PharmacistSociety.com is the social network for verified Pharmacists to communicate and collaborate.</title>
        <meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;"/>
        <meta name="description" content="<?php echo Yii::app()->params['NetworkName']; ?>.com is powered by Skipta technology. PharmacistSociety.com is a verified medical specialist community to enhance real-time collaboration and communication among Pharmacists">
        <meta http-equiv="X-Frame-Options" content="deny">
        <meta name="author" content="">
<!--        <meta name="keywords" content="">
        <meta name="keywords" content="Social network for Pharmacists, pharmacy, dispense medications, community pharmacist, infusion pharmacist, hospital pharmacist, pharmacist jobs, pharmacist career, medical social networking site, skipta network, verified social networks, medical social networks, professional communication, social collaboration, pharmacist network, pharmacy group, pharmacist discussion, news for pharmacists, safe social">
       -->
       <meta name="Keywords" content="<?php echo Yii::app()->params['SeoContent']; ?>">

        <meta name="author" content="">
        <meta name="revisit-after" content="15 days">
        <META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/favicon.ico" type="image/x-icon">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-skiptaNeo_layout.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-skiptaNeo_page.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-skiptatheme.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/<?php echo Yii::app()->params['ThemeName']; ?>" rel="stylesheet" type="text/css" media="screen" />


        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.selectbox.css" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.minnew.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/icon-effect.css" rel="stylesheet" type="text/css" media="screen">	
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/settings.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/preloader.css" rel="stylesheet" type="text/css" media="screen">
        




        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/fonts.css" rel="stylesheet" type="text/css" media="screen" />
        <style type="text/css">.dropdown-backdrop {position:absolute;}</style>
        <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"> </script>
        <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>

        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mousewheel.js"></script>  
        <script type="text/javascript" src="<?php echo YII::app()->getBaseUrl() ?>/js/jquery.jscrollpane.custom.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/timezone.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/responsive-plugins.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/responsive-scripts.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.selectbox-0.2.js"></script>
        <script src="js/modernizr.custom.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.localscroll-1.2.7-min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.scrollTo.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.nicescroll.min.js" type="text/javascript"></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.themepunch.revolution.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.themepunch.plugins.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.appear.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/toucheffects.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modals.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/parallax.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/count.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/scripts.js" type="text/javascript"></script>
        <?php include 'translationVariables.php'; ?>
        <!--PRELOADER - add your images and text to preload here -->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/royal_preloader.min.js"></script>
        <script type="text/javascript">
//            <![CDATA[
            var images = {
                parallax1: 'images/system/slider1.jpg'
			  
            };

            Royal_Preloader.config({
                mode:           'logo', // 'number', "text, logo"
                text:           'MedialDirectorsForum',
                images:         images,
                timeout:        10,
                showInfo:       false,
                showPercentage: true,
                opacity:        1,
                background:     ['#fff'], 
                logo:           'images/system/logo1.png'
            });
            //]]>
         //  alert(document.URL);
        var exceptArray = ["Invite"];
         if(document.URL != '<?php echo Yii::app()->params["ServerURL"]."/site"?>'){
             var url = document.URL;
             url =url.split('?');
             url =url[0].split('/');
            if(exceptArray.indexOf(url[3])==-1){
                 document.cookie="r_u="+document.URL;  
             } 
         }


        </script>

        <script language="javascript" type="text/javascript" src="/nodeserver/"></script>  
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jwplayer/jwplayer.js"></script>
        <script type="text/javascript">jwplayer.key="N5rHDC1elorgiqDb/VdbUadp/aRvTnNwLEQFlQ=="</script>
        

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/html5.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/css3-mediaqueries.js"></script>
           <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" rel="stylesheet">
        <![endif]-->
        <!--[if lt IE 10]>
     <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie_placeholder.css" rel="stylesheet">
    <![endif]-->  
        <script type="text/javascript">
         if(navigator.userAgent.indexOf("Safari") != -1 ) 
            {
                var fileref=document.createElement("link")
                fileref.setAttribute("rel", "stylesheet")
                fileref.setAttribute("type", "text/css")
                fileref.setAttribute("href", "<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-safaristyles.css")
                if (typeof fileref!="undefined")
                document.getElementsByTagName("head")[0].appendChild(fileref)
            }
        </script>
       <script type="text/javascript">
      
            $(document).ready(function(){
                if(!detectDevices()){                   
                    $("[rel=tooltip]").tooltip();
                }
                if(location.search!="" && getParameterByName('fromNetwork')!="")
            {
                document.cookie="providerLink="+getParameterByName('providerLink');
                document.cookie="fromNetwork="+getParameterByName('fromNetwork');
              // alert(getParameterByName('fromNetwork')); 
               $("#"+getParameterByName('fromNetwork')).click();
               // window.location.href=decodeURIComponent(getParameterByName('url'));
            }
        
            });

              
            function detectDevices() {
                var isMobile = {
                    Android: function() {
                        return navigator.userAgent.match(/Android/i);
                    },
                    BlackBerry: function() {
                        return navigator.userAgent.match(/BlackBerry/i);
                    },
                    iOS: function() {
                        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                    },
                    Opera: function() {
                        return navigator.userAgent.match(/Opera Mini/i);
                    },
                    Windows: function() {
                        return navigator.userAgent.match(/IEMobile/i);
                    },
                    any: function() {
                        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                    }
                };
                if (isMobile.any()) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>
    </head>
    <body data-spy="scroll" data-target=".navbar" class="royal_loader">
    <header id="Home">
            <div class="navbar">
                <div class="container">
                    <div class=" row-fluid">
                        <div class="span12">
                            <div class="span2" id="logo">
                                <a href="#top"><img src="/images/system/logo.png" alt="" class="navbar-brand" /></a>
                            </div>
                            <div class="span10">
                                <div class="pull-right mobilerightclear loginarea" id="loginarea">

                                    <?php include_once(getcwd() . "/protected/views/site/login.php"); ?>
                                    <li class="dropdown pull-left" id="registrationdropdown">
                                        <a id="drop3" data-toggle="dropdown" class="tooltiplink headeranchor" lass="tooltiplink" data-placement="bottom" rel="tooltip" href="#" data-original-title="Register" >New Member Registration</a>
                                        <div class="dropdown-menu regwidth" >
                                            <?php include_once(getcwd() . "/protected/views/site/registrationform.php"); ?>
                                        </div>
                                    </li> <li class="dropdown pull-left" id="forgotPasasworddropdown">
                                        <a id="drop2" data-toggle="dropdown" class="tooltiplink headeranchor " lass="tooltiplink" data-placement="bottom" rel="tooltip" href="#" data-original-title="Forgot Password" >Forgot Password?</a>

                                        <div class="dropdown-menu signinwidth " >
                                            <?php include_once(getcwd() . "/protected/views/site/forgotpassword.php"); ?>

                                        </div>
                                    </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="">
            <div class=" row-fluid  menubat">
                <div class="span12">
                     <!-- Logo -->
                       <div class=" centered" id="mainNav">
                         <!-- Collapse -->
                        <!-- MENU -->
                       
                
                        <ul class="nav navbar-nav sf-menu">
<!--                        <li style="display:none;"><a href="#Section-5">About</a></li>-->
                        <li><a href="#about">About</a></li>
                        <li><a href="#Section-2">Features</a></li>
                         <?php if(Yii::app()->params['IsMobileAppexist']=='ON'){?>
                         <li><a href="#mobile">Mobile</a></li>
                        <?php }?>
			<li><a href="#Section-3">Contact</a></li>
                        </ul><!-- //MENU -->
                    </div>
                    <!-- Collapse end -->
                 </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
               
           if(document.cookie.indexOf("Hds_user") != -1){ 
               var HdsUserKey=getCookie('Hds_user');
               $('#registrationdropdown a').attr('href','<?php echo Yii::app()->params['ServerURL']; ?>/Invite?UK='+HdsUserKey);
               $('#drop3').attr('data-toggle',' ');
           }
    </script>
</header>
       
        
    


