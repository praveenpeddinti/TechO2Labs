      

<span id="loginSpinner"></span>
    <div class="row-fluid">
                <div class="span12">
                    
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
        'method'=>'post',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
                'validatOnChange'=>true,
      //      'afterValidate'=>'js:clearMessage',

	),
    'htmlOptions'=>array(
        
         'style'=>'margin: 0px; accept-charset=UTF-8','enctype' => 'multipart/form-data','class'=>'marginzero'
    )
)); ?>
                <div class="span5">
                    	
   
                    <div class="control-group controlerror">
                 <?php echo $form->textField($model,'email',array("placeholder"=>Yii::t('translation','username'), 'maxlength' => 40, 'class' => 'span12 email')); ?>        
                   <?php echo $form->error($model,'email'); ?>
                    
                    <?php echo $form->error($model, 'error'); ?> 
                    </div>              
  
                </div>
                <div class="span5"> 
                        <div class="control-group controlerror">
                    <?php echo $form->passwordField($model,'password',array("placeholder"=>Yii::t('translation','password'), 'maxlength' => 40, 'class' => 'span12 pwd')); ?>        
                  <?php echo $form->error($model,'password'); ?>
                        </div>  
                
                   <?php echo $form->hiddenField($model,'rememberMe',array('value'=>0)); ?>        
                </div>
                    
                <div class="span2"> 
                     <?php
                                            echo CHtml::ajaxSubmitButton('Login', array('site/login'),array(
                                                    'type'=>'POST',
                                                'dataType' => 'json',
                                                'error'=>'function(error){
                                                 
                                                   }',
                                                'beforeSend' => 'function(){
                                                
                                                 

                                            if ($("#rememberMe_login").is(":checked")) {

                                            $("#LoginForm_rememberMe").val(1);
                                            }


                                                }',
                                                'complete' => 'function(){
                                                     
                                                    }',
                                                
                                                
                                                
                                                'success' => 'function(data,status,xhr) { logincallback(data,status,xhr);}'),
                                                    array('type' => 'submit','id' => 'login-form','class'=>'btn pull-right')
                                                    );
                                        ?>
                                                   
                   <?php //echo CHtml::submitButton('Login',array('class'=>'btn pull-right')); ?>
                                                   
                </div>
                    <?php $this->endWidget(); ?>
                </div>
                </div>
     <div class="row-fluid">
                <div class="span12 headerlink" >
                 <ul role="navigation" class="nav">
                    <li class="pull-left">
                        <input type="checkbox" id="rememberMe_login" name="rememberMe_login" class="styled" checked>
         
<b>Remember me</b>
</li>
 

<script type="text/javascript">
    if(navigator.appName=="Microsoft Internet Explorer"){
    $("#LoginForm_email").css( "width","160px" );
     $("#LoginForm_pword").css( "width","160px" );
    }
 $('input[type=text]').focus(function(){      
     if(navigator.appName=="Microsoft Internet Explorer"){
        $(this).css( "background","#fff");
        $(this).css( "padding-left","5px" );
        $(this).css( "width","160px" )
     }
  clearerrormessage(this);
});
$('input[type=password]').focus(function(){
    if(navigator.appName=="Microsoft Internet Explorer"){
        $(this).css( "background","#fff" );
        $(this).css( "padding-left","5px" );
        $(this).css( "width","160px" )
     }
   clearerrormessage(this);
});

if(navigator.appName=="Microsoft Internet Explorer"){
$('input[type=text]').focusout(function(){ 
 if($("#LoginForm_email").val()==''){
     $(this).css( "background","");
        $(this).css( "padding-left","" );
 }
 
});
$('input[type=password]').focusout(function(){ 
 if($("#LoginForm_pword").val()==''){
     $(this).css( "background","");
       $(this).css( "padding-left","" );
 }
 
});
}
  $(document).ready(function(){
        var error=$('#login-form').find('.errorMessage');        
        $.each(error, function(key, val) {         
       
                $("#"+val.id).fadeOut(5000);
            
        });         
        })
        
    </script>