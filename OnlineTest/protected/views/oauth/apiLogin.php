        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/oauth-skiptaNeo.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/oauth-skiptatheme.css" />
          <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/<?php echo Yii::app()->params['ThemeName']; ?>" rel="stylesheet" type="text/css" media="screen" />
<div class="api_login_width" style="margin:auto">
  <header>
      
	<div class="container containeraouth" >
    	<div class="row-fluid">
        	<div class="span12">
            	<div class="span4">
                  <a href="#"><img src="<?php echo Yii::app()->params['Logo']; ?>" alt="logo" class="logo"></a>                </div>
              <div class="span8">
                
            </div>
            </div>
        </div>
     </div>
</header>
<!-- END HERE -->

<?php

if($isValidClient=="false"){?>
<div style=" background: none repeat scroll 0 0 #EFD4D2;border-color: #E4BAB6; margin:10px; padding:10px">
    <p style="color: #333333;text-align: center"> oops !! Client is not Valid </p>
</div> 
<?php }else{
?>


<section>
<div class="container omargin-top20 containeraouth" >

<div class="row-fluid">
<div class="span12">
<div class="span7">
<div class="borderright">
<div class="aouthpaddignright30">
    <div class="aouthtitle" style="line-height:25px;font-family: 'exo_2.0light'">Authorize <span style="font-family: 'exo_2.0bold';font-weight:normal"> <?php echo substr($consumerObj->Title, 1) ?> </span>to use your account?</div>
<div class="aouthlisttitle">This application <b>will be able to:</b></div>
<div>
<ul><li>
    Access your profile.</li>
    
    </ul>



</div>
<div class="aouthpaddignleft20">
<div class="aouthloginarea">
   <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
        'method'=>'post',
	'enableClientValidation'=>TRUE,
	'clientOptions'=>array(
		'validateOnSubmit'=>TRUE,
                'validatOnChange'=>TRUE,
        'afterValidate'=>'js:fadeMessage',

	),
    'htmlOptions'=>array(
        
         'style'=>'margin: 0px; accept-charset=UTF-8','enctype' => 'multipart/form-data','class'=>'marginzero'
    )
)); ?>
    <div class="row-fluid">
                <div class="span12">
                    	
   
                    <div class="control-group controlerror">
                 <?php echo $form->textField($model,'email',array("placeholder"=>Yii::t('translation','userName'), 'maxlength' => 40, 'class' => 'span12 email')); ?>        
                   <?php echo $form->error($model,'email'); ?>
                    
                    <?php echo $form->error($model, 'error'); ?> 
                    </div>              
  
                </div></div>
    <div class="row-fluid">
                <div class="span12"> 
                        <div class="control-group controlerror">
                    <?php echo $form->passwordField($model,'pword',array("placeholder"=>Yii::t('translation','password'), 'maxlength' => 40, 'class' => 'span12 pwd')); ?>        
                  <?php echo $form->error($model,'pword'); ?>
                        </div>  </div>
    </div>
    <?php if($mobile==0){?>
    <div ><div class="pull-left "> 
                            <div class="control-group ">    <?php      echo $form->checkBox($model,'rememberMe', array('class'=>'styled','value'=>0));   ?>Remember me </div> 
                            </div>
                                                        </div>
    <?php }?>

    <div class="alignright clearboth">

        <?php
        echo CHtml::submitButton('Authorize',  array('name'=>'submit','id' => 'login-form', 'class' => 'btn')
        );
        ?>
 <?php if($mobile==0){?>
        <?php echo CHtml::submitButton('Cancel', array('name'=>'cancel','class' => 'btn',"id"=>'login-cancel')); ?>
     <?php }?>
    </div>  
 
             
                    <?php $this->endWidget(); ?>
    
    

</div>
</div>
<div>
<div class="aouthlisttitle aouthpaddingtop20">This application <b>will not be able to:</b></div>
<ul><li>
    Access your <?php echo Yii::app()->params['NetworkName']; ?> Conversations.
    </li><li>
    See your <?php echo Yii::app()->params['NetworkName']; ?>  password.
</li></ul>

</div>
</div>
</div></div>
<div class="span5">
<div class=" bggrey">
    <div class="appinfo" style="background: none repeat scroll 0 0 #FFFFFF;padding: 10px;">
        <div class="applogo"><img src="<?php echo  $consumerObj->Picture ?>"></div>
<div class="apptitle"  style="font-size:16px"><?php echo  $consumerObj->Title ?></div>
    <div class="aboutapp">
        <span style="padding:5px 0 5px 0">By SKIPTA</span>
<span style="padding:5px 0 5px 0"><?php echo  $consumerObj->DomainName ?></span>
<span style="padding:5px 0 5px 0"><?php echo  $consumerObj->Description ?></span>
    </div>
</div>

</div>

</div>
</div>
</div>
</div>

</section>
<?php }?>

<!-- FOOTER END HERE -->
</div>
        
        <script type="text/javascript">
             function fadeMessage()
            {
                 $(".errorMessage").fadeOut(4000);
			$('div.control-group').removeClass('error');
		 return true;
                
            }

                $(document).ready(function(){
                document.onreadystatechange = function () {
                  if(document.readyState === "complete"){
                    fadeMessage()
                  }
                }
                });
                         Custom.init();
            </script>
