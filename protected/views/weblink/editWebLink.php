<div class="row-fluid">
        <div class="span12">
             <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'editweblink-form',
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
            <?php echo $form->hiddenField($webLinkForm,"LinkGroup"); ?>
              <div id="WebLinkSpinner"></div>
                <div class="alert alert-error" id="errmsgForWL" style='display: none'></div>
                <div class="alert alert-success" id="sucmsgForWL" style='display: none'></div> 
                <div class="row-fluid  ">
                <div class="span12">

                    <label><?php echo Yii::t('translation', 'Web_Title');?></label>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($webLinkForm, 'Title', array('maxlength' => 100, 'class' => 'span12 textfield' )); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($webLinkForm, 'Title'); ?>
                    </div>                    
                </div>
                </div>
                 <div class="row-fluid  ">
                <div class="span12">

                    <?php echo $form->labelEx($webLinkForm, Yii::t('translation', 'Web_Link')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($webLinkForm, 'WebLink', array('maxlength' => 300, 'class' => 'span12 textfield','onkeyup'=>"clearWebSnippet();getWebLinksnippet(event,this);" )); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($webLinkForm, 'WebLink'); ?>
                    </div>
                    <div  id="snippet_main" style="display:none; padding-top: 10px;padding-bottom:10px;" >
           
      </div> 
                </div>
            
               
            </div>
                <div class="stream_content">
              <?php if(isset($webLink['WebUrl'])){    ?>
                           <div id="EWS">
                                <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;clear:both;">
                                    <div class="Snippet_div" >
                                        <a href="<?php echo $webLink['WebUrl']; ?>" target="_blank">
                                            <?php if ($webLink['WebImage'] != "") { ?>
                                                <span  class=" pull-left img_single e_img" style="width:100px;" ><img src="<?php echo $webLink['WebImage']; ?>"></span>
                                            <?php } ?>  </a>   
                                        <div class="media-body">                                   

                                            <label style="padding-left: 10px" class="websnipheading"><?php echo $webLink['WebTitle'] ?></label>

                                            <a class="websniplink" href="<?php echo $webLink['WebUrl']; ?>" target="_blank"> <?php echo $webLink['WebUrl'] ?></a>
                                            <p><?php echo $webLink['WebDescription'] ?></p>

                                        </div>

                                    </div>
                                </div>
                          </div>
                           <?php  }?> 
                    
                    
                </div>
                  <div class="row-fluid  ">
                      <div class="span12">
                          <?php echo $form->labelEx($webLinkForm, Yii::t('translation', 'WLDescription')); ?>
                          <div class="chat_profileareasearch" ><?php echo $form->textArea($webLinkForm, 'Description', array( 'maxlength' => 200,'rows'=>"5",'class' => 'span12 textfield')); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($webLinkForm, 'Description'); ?>
                    </div>
                      </div>
                      </div>
                 <div class="row-fluid  ">
                     <div class="span12">
                         <div class="span6">
                              <?php echo $form->labelEx($webLinkForm, Yii::t('translation', 'Link_Group')); ?>
                                                              
                                 <select name="editlinkgroupname"  id="editlinkgroupname"  class="span12">                                  
                                     <option value="0">Please choose </option>
                                  <?php if(sizeof($linkGroups) > 0){
                                      foreach($linkGroups as $rw){?>
                                  <option value="<?php echo $rw->id; ?>"><?php echo $rw->LinkGroupName; ?></option>                                      
                                      <?php } }?>
                                  <option value="other">Other</option>
                              </select>
                             
                         </div>
                          <div class="span6" id="othervalue" style="display:none;">
                              <?php echo $form->labelEx($webLinkForm, Yii::t('translation', 'Other_Link_Group')); ?>
                              <div class="chat_profileareasearch" >
                                        <?php echo $form->textField($webLinkForm, 'OtherValue', array('maxlength' => 50, 'class' => 'span12 textfield')); ?> 
                              </div>
                              <div class="control-group controlerror">
                                    <?php echo $form->error($webLinkForm, 'OtherValue'); ?>
                               </div>
                          </div>
                         <div class="span6" id="StatusSpan" >

                        <?php echo $form->labelEx($webLinkForm, Yii::t('translation', 'Status')); ?>
                    <div class="chat_profileareasearch" >
                        <?php
                        echo $form->dropDownlist($webLinkForm, 'Status', array('1' => 'Active', '0' => 'InActive'), array(
                            'class' => "span12",                                                        
                            'id'=>'Status'
                        ));
                        ?>   
                    </div>                    
                </div>
                     </div>
                
                </div> 
               
               
                 <div class="groupcreationbuttonstyle alignright">
      <?php echo $form->hiddenField($webLinkForm, 'id',array('class'=>'')); ?>
                <?php
                echo CHtml::ajaxSubmitButton('Update', array('/Weblink/createWebLink'), array(
                    'type' => 'POST',
                    'dataType' => 'json',
                    'error' => 'function(error){
                                        }',
                    'beforeSend' => 'function(){  
                                scrollPleaseWait("WebLinkSpinner","editweblink-form"); }',
                    'complete' => 'function(){
                                                    }',
                    'success' => 'function(data,status,xhr) { editWebLinkHandler(data);}'), array('type' => 'submit', 'id' => 'newWebLink', 'class' => 'btn')
                );
                ?>
            <?php echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'NewWebLinkReset', 'class' => 'btn btn_gray', 'onclick' => 'cancelEdit()')); ?>

            </div>
<?php $this->endWidget(); ?>
</div>    
</div>
<script>
    
    
    
    $("#editlinkgroupname").change(function(){       
       var val = $(this).val();
       $("#WebLinkForm_LinkGroup").val(val);
       
       if( val === "other"){
           $("#othervalue").show();
       }else{
           $("#othervalue").hide();
       }       
    });
  </script>  