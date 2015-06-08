<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <title> <?php  echo Yii::t('translation', 'ProjectTitle');?></title>
        <meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;"/>
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/images/system/favicon.png">
            <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/favicon.ico" type="image/x-icon">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-skiptaNeo_layout.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-skiptaNeo_page.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-skiptatheme.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/fonts.css" rel="stylesheet" type="text/css" media="screen" />
        <style type="text/css">.dropdown-backdrop {position:absolute;}</style>
    <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"> </script>
    <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
    <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/fonts.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" />



        <script>
            // tooltip demo
            $('.tooltiplink').tooltip({
            })
        </script>
  <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom-form-elements.js"></script>

        <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>



        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/html5.js" type="text/javascript"></script>
           <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" rel="stylesheet">
        <![endif]-->
        <!-- Fav and touch icons -->


        <script>
        // tooltip demo
        $('.tooltiplink').tooltip({
        })
        $(document).ready(function(){
    // IE7 or IE8 Placeholder don't remove
   if($.browser.msie){
        $('input[placeholder]').each(function(){
        var input = $(this);
        $(input).val(input.attr('placeholder'));
        $(input).focus(function(){
        if (input.val() == input.attr('placeholder')) {
        input.val('');
        }
        });
        $(input).blur(function(){
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
        input.val(input.attr('placeholder'));
        }
        });
        });
  }; 
});
        </script>
  </head>
  <body>
    
<?php echo $content;?>
     
 <?php include 'footer.php'; ?>
     
    
    </body>  
</html>
