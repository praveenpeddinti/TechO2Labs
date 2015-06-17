      

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
                        <div class="lusername" style="display:table"><?php echo $form->textField($this->model,'email',array("placeholder"=>Yii::t('translation','userName'), 'maxlength' => 40, 'class' => 'span12 email')); ?>        
                            </div>
                   <?php echo $form->error($this->model,'email'); ?>
                    
                    <?php //echo $form->error($this->model, 'error'); ?> 
                    </div>              
  
                </div>
                <div class="span5"> 
                        <div class="control-group controlerror">
                    <div class="lpassword" style="display:table;"><?php echo $form->passwordField($this->model,'pword',array("placeholder"=>Yii::t('translation','password'), 'maxlength' => 40, 'class' => 'span12 pwd')); ?>        
                    </div>
                  <?php echo $form->error($this->model,'pword'); ?>
                        </div>  
                
                   <?php echo $form->hiddenField($this->model,'rememberMe',array('value'=>1)); ?>        
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
                                                    array('type' => 'submit','class'=>'btn btnlogin pull-right')
                                                    );
                                        ?>
                                                   
                   <?php //echo CHtml::submitButton('Login',array('class'=>'btn pull-right')); ?>
                                                   
                </div>
                    <?php $this->endWidget(); ?>
                </div>
                </div>
 
      
 

<script type="text/javascript">
   
         function logincallback(data, txtstatus, xhr) {
            
        var data = eval(data);
        if (data.status == 'success') {
            
          
                    window.location = '/users';
                    
            }
   
         else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {

                if (msg == "You have entered wrong password") { 
                    $("#LoginForm_pword_em_").text(msg);
                    $("#LoginForm_pword_em_").show();
                    $("#LoginForm_pword_em_").fadeOut(5000);
                    $("#LoginForm_pword_em_").parent().addClass('error');
                } else {
                    $("#LoginForm_email_em_").text(msg);
                    $("#LoginForm_email_em_").show();
                    $("#LoginForm_email_em_").fadeOut(5000);
                    $("#LoginForm_email_em_").parent().addClass('error');
                }

           } else {

                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {
                    var error = eval(data.error);
                }


                $.each(error, function(key, val) {

                    if ($("#" + key + "_em_")) {
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(5000);
                        $("#" + key).parent().addClass('error');
                    }

                });
            }
        }
    }
    

    
 sessionStorage.clear();
    </script>