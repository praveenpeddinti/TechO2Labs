  <div class="padding10">
			
                 <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'schedulegame-form',
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
                        <div id="gameScheduleSpinner"></div>
                <div class="alert alert-error" id="errmsgForGameSchedule" style='display: none'></div>
                <div class="alert alert-success" id="sucmsgForGameSchedule" style='display: none'></div> 
             
                
                 
                
             
               <div class="row-fluid">
                        <div class="span12">
                             <div class="span6">
                             <div id="dpd1" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                  <label><?php echo Yii::t('translation', 'EventPost_Start_lable'); ?></label>
                  <?php echo $form->textField($scheduleForm, 'StartDate', array('maxlength' => '20', 'class' => 'textfield span8', 'readonly' => "true")); ?>    
                  <span class="add-on">
                      <i class="fa fa-calendar"></i>
                  </span>

                  <div class="control-group controlerror"> 
                      <?php echo $form->error($scheduleForm, 'StartDate'); ?>
                  </div>

              </div>
                 </div>
                             <div class="span6">
                  <div id="dpd2" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                      <label><?php echo Yii::t('translation', 'EventPost_Enddate_lable'); ?></label>
                      <?php echo $form->textField($scheduleForm, 'EndDate', array('maxlength' => '20', 'class' => 'textfield span8 ', 'readonly' => "true")); ?>    
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
                
             <div  id="snippet_main" style="display:none; padding-top: 10px;padding-bottom:10px;" ></div>
             <div class="row-fluid"  id="">
                 <div class="span12 ">
                     <div class="span6 ">
                           <div class="row-fluid" >
                        <div class="span12 checkboxlabel"> 
                   <?php echo $form->checkBox($scheduleForm,'ShowDisclaimer',array('class' => 'styled'))?>
                        <?php echo Yii::t('translation','Show_Disclaimer'); ?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($scheduleForm, 'ShowDisclaimer'); ?>
                        </div> </div> </div>
                    <div class="row-fluid" >
                        <div class="span12 checkboxlabel">
                    
                   <?php echo $form->checkBox($scheduleForm,'ShowThankYou',array('class' => 'styled'))?>
                           <?php echo Yii::t('translation','Show_Thank_You_Message'); ?>  
                    <div class="control-group controlerror">
                            <?php echo $form->error($scheduleForm, 'ShowThankYou'); ?>
                        </div>
                    </div>
                 </div>
                         
                     </div>
                     <div class="span6 ">
                         <div class="aligncenter"><img id="groupIconPreviewId" name="ScheduleGameForm[ThankYouArtifact]"  src="" alt="" /></div>
                         
                     </div>

                 
                </div>
                
                 
                </div>
             <div class="row-fluid  ">
                    <div class="span12">

                       <?php echo $form->labelEx($scheduleForm, Yii::t('translation', 'ThankYouMessage')); ?>
                        <?php echo $form->textField($scheduleForm, 'ThankYouMessage', array("placeholder" => Yii::t('translation', ''), 'maxlength' => 100, 'class' => 'span12 textfield')); ?> 
                        <div class="control-group controlerror">
                            <?php echo $form->error($scheduleForm, 'ThankYouMessage'); ?>
                        </div>
                    </div>
                </div>
            <div class="alert alert-error" id="GroupLogoError" style="display: none"></div>
            <div id="updateAndCancelGroupIconUploadButtons" style="display: none">
             </div>
            <div class="padding8top">
           <?php echo $form->hiddenField($scheduleForm, 'ThankYouArtifact',array('class'=>'')); ?>  
            <?php echo $form->hiddenField($scheduleForm, 'GameName',array('class'=>'')); ?>      
                 <?php echo $form->hiddenField($scheduleForm, 'StreamId',array('class'=>'')); ?>      
                <div class="groupcreationbuttonstyle">
                    <div class="row-fluid">
                        <div class="span4">
                          <div id="GroupLogo" class="uploadicon"><img src="/images/system/spacer.png"></div>
                          
                        </div>
                        <ul class="qq-upload-list" id="uploadlistSchedule"></ul>
                        <div class="span8 alignright"> <?php
//                        echo CHtml::ajaxSubmitButton(Yii::t('translation','Schedule'), array('game/saveScheduleGame'), array(
//                            'type' => 'POST',
//                            'dataType' => 'json',
//                            'error' => 'function(error){
//                                        }',
//                            'beforeSend' => 'function(){                                                   
//                                scrollPleaseWait("gameScheduleSpinner","schedulegame-form");}',
//                            'complete' => 'function(){
//                                                    }',
//                            'success' => 'function(data,status,xhr) { gameScheduleHandler(data,status,xhr);}'), array('type' => 'submit', 'id' => 'newGameId', 'class' => 'btn')
//                        );
                        
                        echo CHtml::Button(Yii::t('translation','Schedule'),array('id' => 'newGameId', 'class' => 'btn'));
                        ?>
                         
                        <?php echo CHtml::Button(Yii::t('translation', 'Cancel'), array("id" => 'ScheduleGameReset', 'class' => 'btn btn_gray','onclick'=>'closeGameScheduleDiv("'. $scheduleForm->GameName.'","'. $scheduleForm->StreamId.'")')); ?>
                        </div>
                    </div>
                    
                       

                </div>
                 </div>
            <?php $this->endWidget(); ?>
          
            </div>
   <script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    Custom.init();
    $(document).ready(function(){
        loadEvents();
    });
     
     $("#newGameId").live("click",function(){
         var data = $("#schedulegame-form").serialize();
         $.ajax({
        dataType: "json",
        type: "POST",
        url: "/game/saveScheduleGame",
        async: true,
        data: data,
        success: function(data) {  
            gameScheduleHandler(data);
            
        },
        error: function(data) {     
         // console.log("in error Common method--"+data.toSource());
//alert("in error Common method--"+data.toSource());
        }
         
        
    });
     });
    <?php if (Yii::app()->session['IsAdmin'] == 1) { ?>
          var extensions ='"jpg","jpeg","gif","png","tiff","tif","TIF"';
   initializeFileUploader('GroupLogo', '/game/UploadThankYouImage', '10*1024*1024', extensions,1, 'GroupLogo' ,'',GameDLPreviewImage,displayErrorForBannerAndLogo,"uploadlistSchedule");
            <?php }?> 
                function loadEvents(){    
     var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

 

    var checkin = $('#dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if ((ev.date.valueOf() > checkout.date.valueOf()) || checkout.date.valueOf()!="") {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 0);
            checkout.setValue(newDate);
        }
        checkin.hide();
        $('#dpd2')[0].focus();
    }).data('datepicker');
    
    var checkout = $('#dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');

}
    </script>
