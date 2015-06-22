<div class="alert alert-error" id="errmsgForSurveySchedule" style='display: none'></div>
<div class="alert alert-success" id="sucmsgForSurveySchedule" style='display: none'></div> 

<div class="padding10">    
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'schedulesurvey-form',
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
    
    
    <div id="surveyScheduleSpinner"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="span4">
                <div style="padding-right: 16px" id="dpd1" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                    <label><?php echo Yii::t('translation', 'EventPost_Start_lable'); ?></label>
                    <?php echo $form->textField($scheduleForm, 'StartDate', array('maxlength' => '20', 'class' => 'textfield span11 ', 'readonly' => "true")); ?>    
                    <span class="add-on">
                        <i class="fa fa-calendar"></i>
                    </span>

                    <div class="control-group controlerror"> 
                        <?php echo $form->error($scheduleForm, 'StartDate'); ?>
                    </div>

                </div>
            </div>
            <div class="span4">
                <div id="dpd2" style="padding-right: 16px" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                    <label><?php echo Yii::t('translation', 'EventPost_Enddate_lable'); ?></label>
                    <?php echo $form->textField($scheduleForm, 'EndDate', array('maxlength' => '20', 'class' => 'textfield span11', 'readonly' => "true")); ?>    
                    <span class="add-on">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($scheduleForm, 'EndDate'); ?>
                    </div>

                </div>

            </div>
            
        </div>

    </div>
    
   
   
        
    
    
    
    
    <div class="padding8top" style="padding-bottom: 0">        
        <div class="groupcreationbuttonstyle">
            <div class="row-fluid">
                
                <div class="span12 alignright"> <?php
//        echo CHtml::ajaxSubmitButton('Schedule', array('game/saveScheduleGame'), array(
//            'type' => 'POST',
//            'dataType' => 'json',
//            'error' => 'function(error){
//                                        }',
//            'beforeSend' => 'function(){                                                   
//                                scrollPleaseWait("gameScheduleSpinner","schedulegame-form");}',
//            'complete' => 'function(){
//                                                    }',
//            'success' => 'function(data,status,xhr) { gameScheduleHandler(data,status,xhr);}'), array('type' => 'submit', 'id' => 'newGameId', 'class' => 'btn')
//        );
        ?>
                    <?php 
                         echo CHtml::button('Save',array("id"=>"scheduleSurvey",'class' => 'btn')); 
                          echo "&nbsp;";
                         echo CHtml::resetButton('Cancel', array("id" => 'ScheduleSurveyReset', 'class' => 'btn btn_gray'," data-dismiss"=>"modal")); ?>
                </div>
            </div>



        </div>
    </div>
    <?php $this->endWidget(); ?>

    
</div>

