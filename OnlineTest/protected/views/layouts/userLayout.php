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

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <!-- -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" media="screen" />
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/customswitch.css"/>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-onlinetest.css" rel="stylesheet" type="text/css" />
        
        
        
        
                <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>
                
                <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-switch.min.js"></script>
                <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/customwidgets.js"></script>
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
                <!-- -->
</head>

<body>
    
    <!-- new -->
    <section class="login_bg" style="clear:both; height:370px; "> </section >
<section style="clear:both;" >
    <div class="container"  >
        <div class="customLoginform customLoginformwidth positionlogin " style=" padding-bottom:50px; margin-bottom:120px; " >
            <div class="customLoginbg marginlr0">
                <!--<div class=" pagetitlebg marginlr0 paddingbottom8 pagetitleloginbg" >
                    <div class="section_pagetitle_padding padgetitle">
                        <h4 class="padding-left12">Login</h4>
                        <p>Register here to start Online Test</p>
                    </div>
                </div> --> 
                <?php echo $content; ?>
                <!--<div class="row">
                    <div class="col-xs-12 ">
                        <div class="reg_area">
                        <?php //    include_once(getcwd() . "/protected/views/site/login.php"); ?>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>  
    </div>  
</section>
   
    <!--- new end -->
    
    
    
<?php //include 'footer.php' ?>


<!-- animation script start -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="js/jquery-1.11.3.js"></script>
    <script src="js/bootstrap.min.js"></script>-->
    <script type="text/javascript">
   
	$( document ).ready(function() {
	$("#username").val("");
});
	
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
	
	bindFocusEventsforInputs("div.loginform");
		
	
		function bindFocusEventsforInputs(className){
		
		$(className).find("input[type=text],input[type=password] ").focusin(function(){
			var $this = $(this);			
			var value=$.trim($this.val());
			var rightu = "0px";			
			var labelclassName = $this.siblings().attr("class");
		
			if(value != "")
			{
				$("."+labelclassName).attr("style","left:0px;color:#075067;font-size:13px;top:5px");
			}else{
					
				$("."+labelclassName).hide().css("left","-80px").css("top","5px").show();
				$("."+labelclassName).animate({ "left":"0px","top":"5px" }, "speed" ).css('color', '#075067').css('font-size', '13px');

				
				
			}
	}).focusout(function(){
			var $this = $(this);			
			var value=$.trim($this.val());
			var rightu = "35px";				
			var labelclassName = $this.siblings().attr("class");
			if(value != "")
			{
				$("."+labelclassName).attr("style","left:0px;color:#075067;font-size:13px;top:5px");
			}else{
				$("."+labelclassName).attr("style","left:10px;color:#075067;font-size:13px;top:5px");				
				$("."+labelclassName).animate({ "left":"10px","top":rightu }, "slow" ).css('color', '#ccc').css('font-size', '13px');
				
			}
		});	
	}
    </script>
<!-- animation script end -->
</body>
</html>
