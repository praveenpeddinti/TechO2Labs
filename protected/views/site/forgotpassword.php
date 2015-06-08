   <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'forgot-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'style' => 'margin: 0px; accept-charset=UTF-8',
        ),
    ));
    ?>
<div class="headerpoptitle"><?php echo Yii::t('translation', 'Password_Recovery');?></div>
<div id="forgotpwSpinLoader"></div>
<div class="signdiv">
 
    <div class="headerdisclaimer"><?php echo Yii::t('translation', 'Password_Recovery_Text');?></div>
    

    <div class="alert-error" id="errmsgForForgot" style='display: none'>                          </div>
    <div class="alert-success" id="sucmsgForForgot" style='display: none'></div> 
      <div class="control-group controlerror">
 <?php echo $form->labelEx($this->forgotModel, Yii::t('translation', 'email')); ?>
    <?php echo $form->textField($this->forgotModel, 'email', array('maxlength' => 40, 'class' => 'span12 email', 'id' => 'ForgotForm_email')); ?>
  
       
        
        <?php echo $form->error($this->forgotModel, 'email'); ?>
    </div>
    <div class="headerbuttonpopup h_center padding8top">
        <?php
        echo CHtml::ajaxSubmitButton('Recover Password', array('site/forgot'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'error' => 'function(error){
                                        }',
            'beforeSend' => 'function(){                                                   
                        scrollPleaseWait("forgotpwSpinLoader","forgot-form");                         }',
            'complete' => 'function(){
                                                    }',
            'success' => 'function(data,status,xhr) { forgotPwHandler(data,status,xhr);}'), array('type' => 'submit', 'id' => 'forgotBtnId', 'class' => 'btn btn-2 btn-2a pull-right')
        );
        ?>
    </div>
    <?php echo CHtml::resetButton(Yii::t('translation', 'Clear'), array("id" => 'forgotReset', "style" => "display:none")); ?>
    
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
     $('#ForgotForm_email').focus(function(){
    clearerrormessage(this);
});


    </script>
