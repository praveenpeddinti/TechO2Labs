<div class="col-wrap "><!-- style col-shadow/ col-gray/ testimonial/-->
	<div class="container padding-bottom10 ">
           <div>
                           
                                    <?php
                                    $form = $this->beginWidget('CActiveForm', array(
                                        'id' => 'contactus-form',
                                        'enableClientValidation' => true,
                                        'enableAjaxValidation' => false,
                                        'clientOptions' => array(
                                            'validateOnSubmit' => true,
                                        ),
                                        //'action'=>Yii::app()->createUrl('//user/forgot'),
                                        'htmlOptions' => array(
                                            'style' => 'margin: 0px; accept-charset=UTF-8',
                                        ),
                                    ));
                                    ?>
                            <div id="contactUsSpinner"></div>
                                <div class="signdiv contactus_div">
                                    <div class="alert-error" id="errmsgForContactUs" style='display: none'></div>
                                    <div class="alert-success" id="sucmsgForContactUs" style='display: none'></div>          
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="span6">
                                               <?php echo $form->labelEx($contactForm, Yii::t('translation', 'User_Register_Firstname')); ?>
                                            <?php echo $form->textField($contactForm, 'FirstName', array("placeholder" => '', 'maxlength' => 40, 'class' => 'styled span12 textfield')); ?>
                                            <div class="control-group controlerror">
                                            <?php echo $form->error($contactForm, 'FirstName'); ?>
                                            </div> 
                                            </div>
                                            <div class="span6">
                                                <?php echo $form->labelEx($contactForm, Yii::t('translation', 'User_Register_Lastname')); ?>
                                             <?php echo $form->textField($contactForm, 'LastName', array("placeholder" => '', 'maxlength' => 40, 'class' => 'styled span12 textfield')); ?>  
                                             
                                            <div class="control-group controlerror">
                                                <?php echo $form->error($contactForm, 'LastName'); ?>
                                            </div> 
                                            </div>
                                            </div>
                                         </div>
                                            <div class="row-fluid">
                                        <div class="span12">
                                         
                                        <div class="span6">
                                             <?php echo $form->labelEx($contactForm, Yii::t('translation', 'Occupation')); ?>
                                             <?php echo $form->textField($contactForm, 'Occupation', array("placeholder" => '',  'class' => 'styled span12 textfield')); ?>  
                                             
                                            <div class="control-group controlerror">
                                                <?php echo $form->error($contactForm, 'Occupation'); ?>
                                            </div>
                                            </div>
                                            <div class="span6">
                                            <?php echo $form->labelEx($contactForm, Yii::t('translation', 'Email')); ?>
                                             <?php echo $form->textField($contactForm, 'ContactUserEmail', array("placeholder" => '',  'class' => 'styled span12 textfield')); ?>  
                                             
                                            <div class="control-group controlerror">
                                                <?php echo $form->error($contactForm, 'ContactUserEmail'); ?>
                                            </div>
                                            </div>
                                          </div> 
                                            </div>
                                    <div class="row-fluid">
                                                
                                                 <div class="span12">
                                                <?php echo $form->labelEx($contactForm, Yii::t('translation', 'Address')); ?>
                                             <?php echo $form->textArea($contactForm, 'Address', array("placeholder" => '',  'class' => 'styled span12 textfield')); ?>  
                                             
                                            <div class="control-group controlerror">
                                                <?php echo $form->error($contactForm, 'Address'); ?>
                                            </div>
                                            
                                            
                                            
                                            <?php echo $form->labelEx($contactForm, Yii::t('translation', 'Message')); ?>
                                             <?php echo $form->textArea($contactForm, 'UserComment', array("placeholder" => '',  'class' => 'styled span12 textfield')); ?>  
                                             
                                            <div class="control-group controlerror">
                                                <?php echo $form->error($contactForm, 'UserComment'); ?>
                                            </div>
                                           
                                            
                                        </div>
                                    </div>
                                   
                                    <div class="headerbuttonpopup h_center padding8top pull-right">
                                        <?php
                                        echo CHtml::ajaxSubmitButton('Send Message', array('/site/sendContactUs'), array(
                                            'type' => 'POST',
                                            'dataType' => 'json',
                                            'error' => 'function(error){
                                        }',
                                            'beforeSend' => 'function(){   scrollPleaseWait("contactUsSpinner","contactus-form");  
                                                }',
                                            'complete' => 'function(){
                                                    }',
                                            'success' => 'function(data,status,xhr) {contactUsHandler(data,status,xhr);}'), array('type' => 'submit', 'id' => 'contactUsId', 'class' => 'btn ')
                                        );
                                        ?>
                                        <?php echo CHtml::resetButton(Yii::t('translation', 'Clear'), array("id" => 'contactUsReset', 'class' => 'btn btn_gray','onclick'=>'clearContactUs')); ?>
                                    </div>
                                   

                                </div>
                                <?php $this->endWidget(); ?>
                            
                        </div>	
	</div>
</div>