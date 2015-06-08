    
<div  class="paddingtop6" >
    
 <div id="GroupBanner" class="collapse in">
  
     <div class="alert alert-error" id="GroupBannerError" style="display: none"></div>
     
<div  class="groupbanner positionrelative editicondiv" >    
  
    <div class="edit_iconbg tooltiplink cursor" data-original-title="<?php echo Yii::t('translation','Upload_1044_200_dimensions'); ?>" rel="tooltip" data-placement="bottom">
        <div id='GameBannerImage' ></div>
          <div id="GameBannerImage_Edit" style="<?php if(isset($gameDetails) && count($gameDetails)>0){ echo 'display: none'; }else{ echo 'display: none' ;}?>">
        <i  id="updateGameBanner" class="fa fa-floppy-o editable_icons editable_icons_big" onclick="EditGameDescription('GameBannerImage','<?php echo $gameId; ?>')"></i>
        <i  id="updateGameBanner" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor" onclick="cancelGameBannerOrIconUpload('<?php   echo $gameDetails['GameBannerImage']; ?>','GameBannerImage')"></i>
        </div>          

        <div id="updateAndCancelBannerUploadButtons" style="display: none">
        <i  id="updateGroupBanner" class="fa fa-floppy-o editable_icons editable_icons_big" ></i>
        <i  id="updateGroupBanner" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor" ></i>
        </div>
    </div>
    <div ><ul class="qq-upload-list" id="uploadlist"></ul></div>

<img style="max-width:100%" src="<?php if(isset($gameDetails) && count($gameDetails)>0){echo $gameDetails['GameBannerImage'];}else{ echo "/images/system/game_banner.jpg"; } ?>"  id="GameBannerPreview"/>
</div>
    
</div>
     <div id="GameSpinLoader" style="position:relative;"></div>
     <div class="control-group controlerror"  >
    
    <div id="GameBannerImage_error" name="Question"  class="errorMessage marginbottom10 error"  style="display:none"></div>
  </div>

  <?php
             $form = $this->beginWidget('CActiveForm', array(
                'id' => 'gamecreation-form',
                'enableClientValidation' => true,
              //  'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),

                'htmlOptions' => array(
                    'style' => 'margin: 0px; accept-charset=UTF-8',
                ),
             ));
            ?>
     <?php echo $form->hiddenField($newGameModel, 'BrandLogo'); ?>

    <div id="groupProfileDiv" class="row-fluid padding8top" >
        <div class="span12">
     <div class="span6">
     <div class="padding8top">
         
          <div class="alert alert-error" id="GroupLogoError" style="display: none"></div>
          <div class="grouplogo positionrelative editicondiv">

             <div id="editGroupName" class="control-group controlerror">
               
                  <div class="editable" style="padding: 0px;">
                      
                      <div id="GameName"   class="e_descriptiontext gameplaceholder " placeholder="<?php echo Yii::t('translation','GameName'); ?>"  <?php if(isset($gameDetails) && count($gameDetails)>0){ ?> onclick="ShowGameEditButtonArea('GameName','<?php echo $gameId; ?>')"  <?php }  ?> contentEditable="true" ><?php if(isset($gameDetails) && count($gameDetails)>0){echo $gameDetails['GameName'];} ?></div>
                      
                  </div>
                  
                   <div  class="alignright padding5" style="display:none;" id="GameName_Edit"> 
                      <i id="updateGameName" class="fa fa-floppy-o editable_icons editable_icons_big" onclick="EditGameDescription('GameName','<?php echo $gameId; ?>')" ></i>
                      <i id="closeEditGameName" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor"  onclick="HideGameEditButtonArea('GameName','<?php echo $gameDetails['GameName'];?>')"></i>
                   </div>
                <div id="GameName_error" name="Question"  class="errorMessage marginbottom10 error"  style="display:none"></div>  
                

              </div>
              
    
  </div>


          </div>
          
          
          
          
          
         <div id="profile" class="collapse in">
             
             
         </div>
     </div>
        
        <div class="span6">
            <div class="" id="profile">

              <!--     <div id="groupDescription"  class="groupabout"><div class="e_descriptiontext" id="descriptioToshow">description</div>
                   </div>-->
              <div id="groupDescriptionTotal" style="display:none;padding: 5px"     class="groupabout"><div class="e_descriptiontext" id="descriptioToshow"><?php echo Yii::t('translation','gamedescription'); ?></div>

              </div>


              <div id="editGroupDescription" class="positionrelative editicondiv control-group controlerror">
                  
                  <div class="editable" style="padding: 8px;">
                      <div id="GameDescription"   class="e_descriptiontext Gamedescriptionplaceholder "  <?php if(isset($gameDetails) && count($gameDetails)>0){ ?> onclick="ShowGameEditButtonArea('GameDescription','<?php echo $gameId; ?>')"  <?php }  ?> contentEditable="true"  ><?php if(isset($gameDetails) && count($gameDetails)>0){echo $gameDetails['GameDescription'];} ?></div>
                      
                  </div>
                  <div  class="alignright padding5" style="display:none;" id="GameDescription_Edit"> 
                      <i id="updateGameDescription" class="fa fa-floppy-o editable_icons editable_icons_big" onclick="EditGameDescription('GameDescription','<?php echo $gameId; ?>')"></i>
                      <i id="closeEditGameDescription" class="fa fa-times-circle editable_icons editable_icons_big darkgreycolor" onclick="HideGameEditButtonArea('GameDescription','<?php echo $gameDetails['GameDescription'];?>')" ></i></div>
                    <div id="GameDescription_error" name="Question"  class="errorMessage Gamemargintop10 error"  style="display:none;"></div>
              </div>
              <div id="GameDescription_error"  style="display:none"></div>
          </div>
        </div>
        </div>
     </div>
     
    <div class="row-fluid">
            <div class="span12">
                <!-- Banner settings -->
                <div class="span4">
                <span><?php echo Yii::t("translation","Game_Sponsor_settings"); ?></span>
                </div>
                <div class="span2" >
                    <input type="checkbox" id="sponsorsettings" data-on-label="Off" data-off-label="On" />
                    
                </div>
                <!-- Analytics settings -->
                <div class="span4">
                    <span><?php echo Yii::t("translation","Game_Social_actions"); ?></span>
                </div>
                <div class="span2" >
                    <input type="checkbox" id="gamesocialactionssettings" data-on-label="On" data-off-label="Off" />
                   
                </div>
            </div>
            
        </div>
     
     <div class="row-fluid padding-bottom15" id="brandrelateddiv">
            <div class="span12">
                <div class="span6 positionrelative">
                    <?php echo $form->hiddenField($newGameModel,'BrandName'); ?>
                    <select name="GameBrandName" id="gameBrandName" class="span12 styled" >
                    <option value=""><?php echo Yii::t("translation","Game_Brand_Select"); ?></option>
                    <?php if(isset($gameSponsors) && sizeof($gameSponsors) > 0){
                        foreach($gameSponsors as $rw){?>
                    <option value="<?php echo $rw->BrandName; ?>" data-url="<?php echo $rw->BrandLogo; ?>"><?php echo $rw->BrandName; ?></option>                                      
                        <?php } }?>
                    <option value="other">Other</option>
                </select>
                
                <div class="control-group controlerror"> 
                    <?php echo $form->error($newGameModel, 'BrandName'); ?>
                </div>
                </div>
                <div class="span6 positionrelative" id="othervalue" style="display:none;">
                <?php echo $form->textField($newGameModel, 'OtherValue', array('maxlength' => 50, 'class' => 'span12 notallowed_other',"placeholder"=>"Other value")); ?> 
                <div class="control-group controlerror">
                      <?php echo $form->error($newGameModel, 'OtherValue'); ?>
                 </div>
                          
                </div>
                


            </div>
        </div>
     <div class="row-fluid"  id="brandlogorelateddiv">
        <div class="span6">
                    <div class="pull-left">
                        <div  style="display: table;"id="uploadfile" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','SponsorLogo'); ?>"></div>
                    </div>
                    <div style="padding-left: 30px;display: none" id="brandimagelogodiv">
                        <div style="" class="preview pull-left">
         
                        <ul >
                            <li class="">
                                <img alt="" src="" id="brandPreview">
                            </li>
                        </ul>

                   </div>        
                    </div>
                    <div class="control-group controlerror"  >

                        <div id="BrandImage_error" class="errorMessage marginbottom10 error"  style="display:none"></div>
                        <?php echo $form->error($newGameModel, 'BrandLogo'); ?>
                    </div>            
                    
                    <div id="appendlist"><ul class="qq-upload-list" id="uploadlist"></ul></div>
                </div> 
     </div>
     
     
     </div>
    

 <div class="row-fluid groupseperator">
     <div class="span12 paddingtop10 border-bottom">
         <div class="span6"><h2 class="pagetitle"><?php if(isset($gameDetails) && count($gameDetails)>0){ echo Yii::t('translation','Edit_Game_Questions');}else{echo Yii::t('translation','New_Game_Questions');} ?> </h2></div>
        <div class="span6" style="padding:5px 10px 0 0;" ><button type="button" style=" <?php if(isset($gameDetails) && count($gameDetails)>0){ echo 'display:none';}else{echo 'dosplay:block';} ?> " data-original-title="<?php echo Yii::t('translation','Add Onemore Question'); ?>" rel="tooltip" data-placement="bottom" class="newQuestionsbutton pull-right"  onclick="addOneMoreQuestion()"></button></div>
         </div>
          
     
     </div>
 <div class="alert-error" style="list-style: none;" id="custom_error">
            
            </div>
    <div class="alert alert-success" id="sucmsgForGame" style='padding-top: 5px;display: none'></div> 
    <div class=" alert-error" id="errormsgForGame" style='padding-top: 5px;display: none'></div> 
 
    
<div class="panel-group" id="accordion" >
 
 <div id="gameform_question_div_sub"  class="draggable"> 
<div class="panel panel-default section1">
    <button   data-original-title="<?php echo Yii::t('translation','Delete'); ?>" rel="tooltip" data-placement="bottom" class="close plus minus pull-right gameactionsright" data-dismiss="alert"   onclick="closeNewQuestion('0')" type="button"> <i class="fadelete" >X</i> </button>
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse"  name="collapsQuestionId"  class="questionClass" id="collapse_0" data-parent="#accordion" href="#collapse1">
          <?php echo Yii::t('translation','Question'); ?> 1
        </a>
      </h4>
    </div>
            
          <div id="collapse1" class="panel-collapse  in collapse">
      <div class="panel-body">
 <div id="gameform_question_div" >   
<div class="" >
 
    
    <div class="alert-error" style="display: none;" id="CorrectAnswer_0"></div>
    <div class="alert-error" style="display: none;" id="UniqueOption_0"></div>
    

    <div class="row-fluid">
        <div class="span11" style="margin:auto;float:none">
<div class="row-fluid padding8top">
<div class="span12">
    <div class="span8">
         <label id="label_0"  name="QuestionLabel" ><?php echo Yii::t('translation','Question'); ?> </label>
    </div>
    <div class="span4">
<!--        <div class="pull-right gameactionsright"><i class="fadelete">X</i></div>-->
        
    </div>
</div>
    <div class="row-fluid ">
  <div class="control-group controlerror" id="GameQuestion_0" >
    <input type="text" id="GameQuestion_0"  name="g_question"   class="span12 textfield " value=""  maxlength="500" >
    <div id="GameQuestion_0_error" name="Question"  class="errorMessage marginbottom10 error"  style="display:none"></div>
  </div>
 </div>             
</div>
<div class="row-fluid padding8top">
<div class="span12">
 <label ><?php echo Yii::t('translation','Disclaimer'); ?></label>
  <div class="control-group controlerror">
      
  <div id="editable_0" class="inputor editablediv" contentEditable="true"  style="max-height:500px;" ></div>  
  <div id="GameQuestion_editable_0" name="Question"  class="errorMessage marginbottom10 error"  style="display:none"></div>
<!--<textarea class="span12 textfield"  id="GameQuestion_editable_0"  name="g_question_disclaimer" cols="" placeholder="explanation..." rows=""></textarea> -->
  </div>
  </div>             
</div>

<div class="row-fluid padding8top">
<div class="span12">
    <div class="span6">
        <div class="positionrelative ">
            <div class="positionabsolutediv ">
                <label > <?php echo Yii::t('translation','Correct_Answer'); ?></label>
            </div>
            <div class="marginleft110">&nbsp;</div>
        </div>
    </div>
    <div class="span6">
        <div class="positionrelative ">
            <div class="positionabsolutediv ">
                <label > <?php echo Yii::t('translation','Correct_Answer'); ?></label>
            </div>
            <div class="marginleft110">&nbsp;</div>
        </div>
    </div>
 </div>             
</div>
<div class="row-fluid padding8top">
<div class="span12">
    <div class="span6">
        <div class="positionrelative ">
            <div class="positionabsolutediv  alignright positionabsolutedivradio positionabsolutedivradio44 radioalignment">
                <div class="control-group">
                    <input  id="g_CorrectAnswer"  class="styled"  name="g_CorrectAnswer_0" type="radio" value="A" >
                </div>
            </div>
            <div class="marginleft110 marginleft50">
                <label > <?php echo Yii::t('translation','Choice'); ?> 1</label>
                <div class="control-group controlerror " id="GameQuestion_optionA_0">
                    
                    <input type="text"   id="g_optionA_0"  name="g_optionA" data-choice="choice1" class="span12 textfield" maxlength="500" > 
                    <div id="GameQuestion_optionA_0_error" name="Choice-1"  data-ename="Choice 1"  class="errorMessage marginbottom10 error" style="display:none"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="positionrelative ">
            <div class="positionabsolutediv  alignright positionabsolutedivradio positionabsolutedivradio44 radioalignment">
                <div class="control-group">
                    <input id="g_CorrectAnswer"  class="styled"  name="g_CorrectAnswer_0"  type="radio" value="B">
                </div>
            </div>
            <div class="marginleft110 marginleft50">
                <label > <?php echo Yii::t('translation','Choice'); ?> 2</label>
                <div class="control-group controlerror " id="GameQuestion_optionB_0">
                     
                    <input type="text"  id="g_optionB_0" data-choice="choice2" name="g_optionB" class="span12 textfield" maxlength="500" > 
                    <div id="GameQuestion_optionB_0_error" name="Choice-2"  data-ename="Choice 2"   class="errorMessage marginbottom10 error"  style="display:none"></div>
                </div>
            </div>
        </div>
    </div>
 </div>             
</div>
<div class="row-fluid padding8top">
<div class="span12">
    <div class="span6">
        <div class="positionrelative ">
            <div class="marginleft110 marginleft50">
                <div class="control-group">
                    <label > <?php echo Yii::t('translation','Choice'); ?> 1 <?php echo Yii::t('translation','Explanation'); ?></label>
                    <textarea class="span12 textfield" id="g_optionA_explanation"  name="g_optionA_explanation" cols="" rows=""></textarea>
                </diV>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="positionrelative ">
            <div class="marginleft110 marginleft50">
                <div class="control-group">
                    <label > <?php echo Yii::t('translation','Choice'); ?> 2 <?php echo Yii::t('translation','Explanation'); ?></label>
                    <textarea class="span12 textfield" id="g_optionB_explanation"  name="g_optionB_explanation" cols=""   rows=""></textarea>
                </div>

            </div>
        </div>
    </div>
 </div>             
</div>
<div class="dottedsplitter"><img src="/images/system/spacer.png"/></div>
<div class="row-fluid padding8top">
<div class="span12">
    <div class="span6">
        <div class="positionrelative ">
            <div class="positionabsolutediv  alignright positionabsolutedivradio positionabsolutedivradio44 radioalignment">
                <div class="control-group">
                    <input id="g_CorrectAnswer" class="styled" name="g_CorrectAnswer_0"  type="radio" value="C" >
                </div>
            </div>
            <div class="marginleft110 marginleft50">
                <label > <?php echo Yii::t('translation','Choice'); ?> 3</label>
                <div class=" " id="GameQuestion_optionC_0" >
                     
                    <input type="text"  id="g_optionC_0"  name="g_optionC" class="span12 textfield" maxlength="500" > 
<!--                    <div id="GameQuestion_optionC_0_error" name="Choice-3"  class="errorMessage marginbottom10 error"  style="display:none"></div>-->
                </div>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="positionrelative ">
            <div class="positionabsolutediv  alignright positionabsolutedivradio positionabsolutedivradio44 radioalignment">
                <div class="control-group">
                    <input id="g_CorrectAnswer"  class="styled"  name="g_CorrectAnswer_0"  type="radio" value="D">
                </div>
            </div>
            <div class="marginleft110 marginleft50">
                 <label > <?php echo Yii::t('translation','Choice'); ?> 4</label>
                <div class=" " id="GameQuestion_optionD_0">
                    
                    <input type="text" id="g_optionD_0"  name="g_optionD"  class="span12 textfield"  maxlength="500" > 
<!--                    <div id="GameQuestion_optionD_0_error" name="Choice-4"  class="errorMessage marginbottom10 error"  style="display:none"></div>-->
                </div>
            </div>
        </div>
    </div>
 </div>             
</div>
<div class="row-fluid padding8top">
    <div class="span12">
        <div class="span6">
            <div class="positionrelative ">
                <div class="marginleft110 marginleft50">
                    <div class="control-group">
                        <label > <?php echo Yii::t('translation','Choice'); ?> 3 <?php echo Yii::t('translation','Explanation'); ?></label>
                        <textarea class="span12 textfield" id="g_optionC_explanation"  name="g_optionC_explanation" cols=""  rows=""></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="positionrelative ">
                <div class="marginleft110 marginleft50">
                    <div class="control-group">
                        <label > <?php echo Yii::t('translation','Choice'); ?> 4 <?php echo Yii::t('translation','Explanation'); ?></label>
                        <textarea class="span12 textfield" id="g_optionD_explanation"  name="g_optionD_explanation" cols=""   rows=""></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>             
</div>

<div class="row-fluid padding8top">
<div class="span12">

    <div class="span6">
        <div class="span2">
        <label><?php echo Yii::t('translation','Upload_Image_OR_Video'); ?></label>
        <div id='GameQuestionImage_0' ></div>
        </div>
        <div class="span3">
        <div id="QuestionPreviewdiv_0" class="preview" style="display:none;" >

            <img  class="qpreview" id="QuestionPreview_0"  name="" src=""/>
        </div>
        </div>
        <div ><ul class="qq-upload-list" id="uploadlist_0"></ul></div>
        <div class="control-group controlerror " id="GameQuestion_optionD_0">
        <div id="GameQuestionImage_0_error"  class="errorMessage marginbottom10 error"  style="display:none"></div>
        
    </div>
    </div>
<!--    <div class="span6">
        <div class="span3">
        <label>Points</label>
         <div class="control-group controlerror" id="GameQuestion_points_0">
             <input type="text" id="g_points_0" onkeypress="return isNumberKey(event)"  name="g_points" class="span4 textfield" maxlength="2" /> 
             <div id="GameQuestion_points_0_error" name="Points" class="errorMessage marginbottom10 error"  style="display:none"></div>
         </div>
    </div>
    </div>-->
<div class="span6">
            <div class="positionrelative ">
                <div class="marginleft110 marginleft50">
                    <div class="control-group">
                       <label><?php echo Yii::t('translation','Points'); ?></label>
                       <div class="control-group controlerror" id="GameQuestion_points_0">
                       <input type="text" id="g_points_0" onkeypress="return isNumberKey(event)"  name="g_points" class="span4 textfield" maxlength="2" /> 
                   <div id="GameQuestion_points_0_error" name="Points" class="errorMessage marginbottom10 error"  style="display:none"></div> 
                       </div>
                   </div>
                </div>
            </div>
        </div>

</div>
    
</div>
<div class="row-fluid padding8top">
<div class="span12">

</div>
</div>
</div>
     </div> 
    </div>
    </div>
    </div>
</div>
 </div>
               
                
               </div>
  
</div>
<!--<div class="row-fluid padding8top">
<div class="span12 alignright padding10 bggrey">
<input type="submit" value="Save" data-toggle="dropdown" name="commit" id="addGroup" class="btn "> <input type="submit" value="Save and Close" data-toggle="dropdown" name="commit" id="addGroup" class="btn "> <input type="submit" value="Cancel" data-toggle="dropdown" name="commit" id="addGroup" class="btn btn_gray ">
</div>
</div>-->
<?php echo $form->hiddenField($newGameModel, 'GameBannerImage', array('class' => 'span12')); ?>
<?php   echo $form->hiddenField($newGameModel,'GameId',array('value'=>"$gameId")); ?>
<?php echo $form->hiddenField($newGameModel, 'GameName', array('class' => 'span12')); ?>
<?php echo $form->hiddenField($newGameModel, 'GameDescription', array('class' => 'span12')); ?>
 <?php   echo $form->hiddenField($newGameModel,'Questions',array('value'=>"")); ?>
<?php   echo $form->hiddenField($newGameModel,'QuestionArtifacts',array('value'=>"")); ?>
<?php   echo $form->hiddenField($newGameModel,'Iscreated',array('value'=>"")); ?>
<?php   echo $form->hiddenField($newGameModel,'QusetionCount',array('value'=>"")); ?>
<?php   echo $form->hiddenField($newGameModel,'IsSponsors'); ?>
<?php   echo $form->hiddenField($newGameModel,'IsEnableSocialActions'); ?>

<?php 
if(empty($gameId)){
    $button=Yii::t('translation', 'Save');
}else{
   $button=Yii::t('translation', 'Update'); 
}


?>
<span id="gamespinner" class="positionrelative"></span>
    <div class="row-fluid padding8top" id="GameBUttonArea" style="display:block;">
              <div class="span12 alignright padding10 bggrey">
<!--                                                <input type="button" class="btn btn-success  btn-large btn-block r_login" onclick="clicksub()"/>-->
                    <?php echo CHtml::Button($button, array('onclick' => 'saveGameForm();', 'class' => 'btn', 'id' => 'GameFormButtonId')); ?> 
                  
                    <?php echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'gameResetId','onclick' => 'CancelGameCreation();',  'class'=>'btn btn_gray'));  ?>

                </div>	
            </div>	
            <?php $this->endWidget(); ?> 
    
    
  </div>




<script language="JavaScript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.min.js"></script>


<script type="text/javascript">
$("[rel=tooltip]").tooltip();
$("#gameBrandName").change(function(){
        var val = $(this).val();
        $("#GameCreationForm_BrandName").val(val);       
        if(val == ""){
            $("#brandimagelogodiv").hide();
             $("#GameCreationForm_BrandLogo").val('');
             $("#brandPreview").attr("src","");
        }
        if( val == "other"){
           $("#othervalue").show();           
           $("#GameCreationForm_BrandLogo").val("")           
           $("#brandPreview").attr("src","<?php echo Yii::app()->params['ServerURL'];?>/images/system/games.png");
       }else{
           <?php foreach($gameSponsors as $rw){?> 
                if((val == '<?php echo $rw->BrandName;?>')){
                    $("#brandlogorelateddiv,#brandimagelogodiv").show();
                    $("#brandPreview").attr("src",'<?php echo Yii::app()->params['ServerURL'].$rw->BrandLogo;?>');
                    $("#GameCreationForm_BrandLogo").val('<?php echo $rw->BrandLogo;?>');
                }
            <?php } ?>
           $("#othervalue").hide();
           
       }        
    });

$("#sponsorsettings,#gamesocialactionssettings").bootstrapSwitch();
$('#sponsorsettings').on('switch-change', function(e, data) {           
               var switchedValue = data.value ? 1 : 0;    
               //brandrelateddiv
               
               if (switchedValue == 1) {
                   $("#brandrelateddiv,#brandlogorelateddiv").hide();
                   $("#GameCreationForm_IsSponsors").val(0);
                   $('label[for=sponsorsettings]').text("On");
               } else {                   
                   $("#brandrelateddiv,#brandlogorelateddiv").show();
                   $("#GameCreationForm_IsSponsors").val(1);
                   $('label[for=sponsorsettings]').text('Off');
               }
//               var scrollTp = $(window).scrollTop();
//                scrollTp = Number(scrollTp);                
//                $("#surveyviewspinner").css("top",scrollTp);                
                
         });
         $('#gamesocialactionssettings').on('switch-change', function(e, data) {           
               var switchedValue = data.value ? 1 : 0;               
               if (switchedValue == 1) {
                   $("#GameCreationForm_IsEnableSocialActions").val(1);
                   $('label[for=gamesocialactionssettings]').text("Off");
               } else {
                   $("#GameCreationForm_IsEnableSocialActions").val(0);
                   $('label[for=gamesocialactionssettings]').text('On');
               }
               
//               var scrollTp = $(window).scrollTop();
//                scrollTp = Number(scrollTp);                
//                $("#surveyviewspinner").css("top",scrollTp);                
//                
         });
         <?php if(!empty($gameId)){ ?>
             <?php if($gameDetails->IsSponsored == 1){  ?>
                $('#sponsorsettings').bootstrapSwitch('setState', false);
                $('label[for=sponsorsettings]').text("Off");
            $("#brandimagelogodiv").show();
            $('#brandPreview').attr('src', $("#GameCreationForm_BrandLogo").val());
            <?php }else{ ?>
                $('#sponsorsettings').bootstrapSwitch('setState', true);
                $('label[for=sponsorsettings]').text("On");
                $("#brandrelateddiv,#brandlogorelateddiv").hide();

            <?php } ?>
                
                
                <?php if($gameDetails->IsEnableSocialActions == 1){  ?>
                       
                    $('#gamesocialactionssettings').bootstrapSwitch('setState', true);
                    $('label[for=gamesocialactionssettings]').text("Off");
                <?php }else{ ?>
                    $('#gamesocialactionssettings').bootstrapSwitch('setState', false);
                    $('label[for=gamesocialactionssettings]').text("On");

            <?php } ?>
                $('#gameBrandName').val('<?php echo $gameDetails->BrandName;?>');
            
         <?php }  ?>
         
<?php if(empty($gameId)){ ?>    
 Custom.init();
 $("#GameCreationForm_IsSponsors").val(1);
 $("#GameCreationForm_IsEnableSocialActions").val(0)
 $('#sponsorsettings').bootstrapSwitch('setState', false);
         $('label[for=sponsorsettings]').text("Off");
         $('#gamesocialactionssettings').bootstrapSwitch('setState', false);
         $('label[for=gamesocialactionssettings]').text("On");
<?php } ?>

    $('input[type=text]').live('keyup', function() { 
        
        if($(this).val()!=""){
            
            clearerrormessage(this);
        }else{
            adderrormessage(this);
        }

}) ;

var content_id = 'GameName';
var max=50;
//binding keyup/down events on the contenteditable div
$('#'+content_id).keyup(function(){ check_charcount(content_id, max); });
$('#'+content_id).keydown(function(){ check_charcount(content_id, max); });

function check_charcount(content_id, max)
{   
    if($('#'+content_id).text().length > max)
    {
        $('#'+content_id).text($('#'+content_id).text().substring(0, max));
    }
}
        //
    $('.editablediv').bind('paste', function (event) {
     
 var EditDivId=$(this).attr('id');
 var $this = $(this); //save reference to element for use laster
 setTimeout(function(){ //break the callstack to let the event finish
     var strippedText = strip_tags($this.html(),'<p><pre><span><i><b>');
   strippedText=strippedText.replace(/\s+/g, ' ');
 $this.html(strippedText) ;
 $this.find('*').removeAttr('style');
 var result = $('#'+EditDivId);
    result.focus();
    placeCaretAtEnd( document.getElementById(EditDivId) );

},0); 
    }); 
    
     $("#GameName").bind('paste', function (event) {
      
 var $this = $(this); //save reference to element for use laster
 setTimeout(function(){ //break the callstack to let the event finish
     var strippedText = strip_tags($this.html(),'<p><pre><span><i><b>');
    
 $this.html(strippedText) ;
 $this.find('*').removeAttr('style');
 var result = $('#GameName');
    result.focus();
    placeCaretAtEnd( document.getElementById("GameName") );

},0); 
    });
         $("#GameDescription").bind('paste', function (event) {
      
 var $this = $(this); //save reference to element for use laster
 setTimeout(function(){ //break the callstack to let the event finish
     var strippedText = strip_tags($this.html(),'<p><pre><span><i><b>');
    
 $this.html(strippedText) ;
 $this.find('*').removeAttr('style');
 var result = $('#GameDescription');
    result.focus();
    placeCaretAtEnd( document.getElementById("GameDescription") );

},0); 
    });
        
 $('.editablediv').live('click', function() { 
        
   $(this).focus();
            
           
}) ;
        
        
        


function clearerrormessage(obj)
{    
    
$('#'+obj.id).siblings('div').fadeOut(2000);
$('#'+obj.id).parent('div').addClass('success');
$('#'+obj.id).parent('div').removeClass('error');

}
function adderrormessage(obj)
{    
    var name= $('#'+obj.id).siblings('div').attr('data-ename');
         $('#'+obj.id).siblings('div').html("<?php echo Yii::t('translation','please_enter'); ?> "+name);
         $('#'+obj.id).siblings('div').show();
        //    $('#'+obj.id).siblings('div').fadeOut(2000);
        $('#'+obj.id).parent('div').addClass('error');
        $('#'+obj.id).parent('div').removeClass('success');
 
}


 $('.draggable').sortable({
            connectWith: '.questionClass',
            handle: 'a',
            cursor: 'move',
//            placeholder: 'placeholder',
//            forcePlaceholderSize: true,
            opacity: 1.8,

        });



    var GameID='<?php echo $gameId?>';
   
    if(GameID!=""){
         var g_correctAnswer=1;
       $('#GameCreationForm_Iscreated').val('1');
         $('#GameName').removeClass("gameplaceholder");
         $('#GameDescription').removeClass("Gamedescriptionplaceholder");
        getGamedetails(GameID);
         
        
    }else{
         var g_correctAnswer=1;
         $('#GameCreationForm_Iscreated').val('0');
    }
    
    // $( ".draggable" ).sortable();
    
    
    $('#editable_0').freshereditor({editable_selector: '#editable_0', excludes: ['removeFormat', 'insertheading4']});
    $('#editable_0').freshereditor("edit", true);
    $("#editor-toolbar-editable_0").addClass('editorbackground');
    $("#editor-toolbar-editable_0").show();
    $('#editable_0').css("min-height", "50px");
    $('#editable_0').click(function()
    {
        $(this).removeClass("Discemilarplaceholder");
        $(this).focus();
    });

    var QuestionArtifacts=new Array()
    var g_groupPicture = '';
       var extensions ='"jpg","jpeg","gif","png","tiff","tif","TIF"';
     var Questionextensions='"jpg","jpeg","gif","mov","mp4","mp3","avi","png","tiff","mov","flv","tif","TIF"';
  initializeFileUploader('GameBannerImage', '/game/UploadGameBannerImage', '10*1024*1024', extensions, 1,'GameBannerImage' ,'',GameBannerPreviewImage,displayErrorForBannerAndQuestion,"uploadlist",false);
  initializeFileUploader('GameQuestionImage_0', '/game/UploadGameBannerImage', '10*1024*1024', Questionextensions,1, 'GameQuestionImage_0' ,'0',GameQuestionPreviewImage,displayErrorForBannerAndQuestion,"uploadlist_0",false);
  initializeFileUploader('uploadfile', '/game/UploadGameBannerImage', '10*1024*1024', extensions, 1, 'BrandImage', '', BrandPreviewImage, displayErrorForBannerAndQuestion, "appendlist");
 
    $("#GameName").keyup(function()
    { 

        $('#GameName').focus();
        if($.trim($('#GameName').text()).length>0){
           $(this).removeClass("gameplaceholder");
           $('#GameName_error').html("");
              $('#GameName_error').hide();
            return false;
         }else{
              $(this).addClass("gameplaceholder");
              $('#GameName_error').html("<?php echo Yii::t('translation','please_enter_GameName'); ?>");
              $('#GameName_error').show();
              //$('#GameName_error').fadeOut(7000); 
         }
        return false;
    });
  
    $("#GameDescription").keyup(function()
    { 
       
         if($.trim($('#GameDescription').text()).length>0){
            $(this).removeClass("Gamedescriptionplaceholder");
            $('#GameDescription_error').html("");
              $('#GameDescription_error').hide();
            return false;
         }else{
              $(this).addClass("Gamedescriptionplaceholder");
              $('#GameDescription_error').html("<?php echo Yii::t('translation','please_enter_GameDescription'); ?>");
              $('#GameDescription_error').show();
         }
    });
  
  
  
function GameBannerPreviewImage(id, fileName, responseJSON, type)
{
    
    var data = eval(responseJSON);
    $('#GameCreationForm_GameBannerImage').val(data.filename);
    $('#GameBannerPreview').attr('src', data.filepath);
    //$('#GameBannerImage_Edit').show();

}
function displayErrorForBannerAndQuestion(message,type){
     
    
     
     //GameQuestionImage_0_error
     
     $('#'+type+'_error').html(message);
    // $('#'+type+'_error').css("padding-top:20px;");
     $('#'+type+'_error').show();
     $('#'+type+'_error').fadeOut(6000)
     
//     if(type=='GroupLogo'){
//        $('#GroupLogoError').html(message);
//        $('#GroupLogoError').css("padding-top:20px;");
//        $('#GroupLogoError').show();
//        $('#GroupLogoError').fadeOut(6000)
//     }else if(type=='GroupLogoInPreferences'){
//         $('#GroupLogoErrorInPreferences').html(message);
//        $('#GroupLogoErrorInPreferences').css("padding-top:20px;");
//        $('#GroupLogoErrorInPreferences').show();
//        $('#GroupLogoErrorInPreferences').fadeOut(6000)
//     } else{
//        $('#GroupBannerError').html(message);
//        $('#GroupLogoError').css("padding-top:20px;");
//        $('#GroupBannerError').show();
//        $('#GroupBannerError').fadeOut(6000)
//     }  
}
function GameQuestionPreviewImage(id, fileName, responseJSON, type)
{

    var data = eval(responseJSON);
    var Qusetiondiv = type.split("_");
    
    var QuestionId=Qusetiondiv[Qusetiondiv.length-1];
 
    $('#QuestionPreviewdiv_'+QuestionId).show();
    var filetype=responseJSON['extension'];
    var image = getImageIconByType(filetype);
    if(image==""){
            image=responseJSON['filepath'];
       }
    

    $('#QuestionPreview_'+QuestionId).attr('src', image);
    $('#QuestionPreview_'+QuestionId).attr('name', data.filename);

}


function addOneMoreQuestion(){

     var data="";
      var URL = "/game/AddNewQuestion?Id=" + g_correctAnswer;
      
      $( ".panel-collapse" ).each(function(key,index) {
          
       $( this ).removeClass('in') });
        
     ajaxRequest(URL,data,function(data){renderPostDetailPageHandler(data)},"html");

    }

function renderPostDetailPageHandler(html){ 

   $("#gameform_question_div_sub").append(html);
    
   $('#GameQuestionImage_').attr("id", 'GameQuestionImage_'+g_correctAnswer);
   $('#uploadlist_').attr("id", 'uploadlist_'+g_correctAnswer);
   initializeFileUploader('GameQuestionImage_'+g_correctAnswer, '/game/UploadGameBannerImage', '10*1024*1024', Questionextensions,1, 'GameQuestionImage_'+g_correctAnswer ,g_correctAnswer,GameQuestionPreviewImage,displayErrorForBannerAndQuestion,"uploadlist_"+g_correctAnswer);
   $('#QuestionPreviewdiv_').attr("id", 'QuestionPreviewdiv_'+g_correctAnswer);
   $('#QuestionPreview_').attr("id", 'QuestionPreview_'+g_correctAnswer);
Custom.clear();
      g_correctAnswer=g_correctAnswer+1;
      
    //  Custom.init();
      if(g_correctAnswer >0){
         
         $('#GameBUttonArea').show();
      }
//      if(g_correctAnswer>2){
//        var id=g_correctAnswer-1;
//        
////          $('.titleView').click(function () {
////            //  $('#collapseOne, #collapseMain').collapse('hide');
////            //});
////            //
////            //$('.fullStubView').click(function () {
////            //  $('#collapseOne, #collapseMain').collapse('show');
////            //});
////      
////           // $("#Question_"+id).collapse('hide');
////      }
////      
//      }
$("[rel=tooltip]").tooltip();
}  
    
 function saveGameForm(){
         
    $( ".questionClass" ).each(function(key,index) {
      
       $(this).removeClass('alert-error');
     
   });
         
        var form = document.getElementById('gamecreation-form');
                var g_question = document.getElementsByName('g_question');
                var g_question_disclaimer = document.getElementsByName('g_question_disclaimer');
                var g_optionA = document.getElementsByName('g_optionA');
                var g_optionA_explanation = document.getElementsByName('g_optionA_explanation');
                var g_optionB = document.getElementsByName('g_optionB');
                var g_optionB_explanation = document.getElementsByName('g_optionB_explanation');
                var g_optionC = document.getElementsByName('g_optionC');
                var g_optionC_explanation = document.getElementsByName('g_optionC_explanation');
                var g_optionD = document.getElementsByName('g_optionD');
                var g_optionD_explanation = document.getElementsByName('g_optionD_explanation');
                var g_points = document.getElementsByName('g_points');
                var g_image = document.getElementsByName('preview');
                

                var $imgs = $('img.qpreview'),
                    images = [];

                $imgs.each(function () {
                    images.push($(this).attr('name'));
                });

                  var   Answer = new Array();
                  var   CorrectAnswer = new Array();
                
                var Question_description=new Array();
                
                
                for (var i = 0; i <=g_correctAnswer; i++) {  
                     
                      var g_answer = document.getElementsByName('g_CorrectAnswer_'+i);
                      for (var j = 0; j < g_answer.length; j++) {  
                          
                          if (g_answer[j].checked) {
                               
                                CorrectAnswer.push(g_answer[j].value);
                               // alert(Answer[j]);
                                 break;
                            }
                          
                      }
                      
                }
                
                
                 for (var i = 0; i <=g_correctAnswer; i++) {  
                   
                     if ( $('#editable_'+i ).length >0) {
                     
                          Question_description.push('editable_'+i);
                          
                      }
                }

                var count = 0;

                //for(var item in elements){
               // var div="<div class='alert-model fade in' id='error_remove_div' style='position: relative'><button  class='close' data-dismiss='alert' type='button'>x</button>";
                 var div="<div class='alert-model fade in' id='error_remove_div' style='position: relative'>";
                $("#custom_error").html('');
                $("#custom_error").append(div);
                var k=0;
                var QuestionImages=$('#GameCreationForm_QuestionArtifacts').val();
                

                

                   
                   if($('#GameName').text()==""){
                        k++;
                       
                      $('#GameName_error').html("<?php echo Yii::t('translation','please_enter_GameName'); ?>");
                        $('#GameName_error').show();
                        $('#GameName_error').fadeOut(9000); 
                   }
                   if($('#GameDescription').text()==""){
                        k++;
                       $('#GameDescription_error').addClass('Gamemargintop10');
                        $('#GameDescription_error').html("<?php echo Yii::t('translation','please_enter_GameDescription'); ?>");
                        $('#GameDescription_error').show();
                        $('#GameDescription_error').fadeOut(9000); 
                   }
                   
                   if($('#GameBannerPreview').attr('src')=="/images/system/game_banner.jpg"){
                        k++;
                      // $('#GameBannerImage_error').addClass('Gamemargintop10');
                        $('#GameBannerImage_error').html("<?php echo Yii::t('translation','please_upload_GamebannerImage'); ?>");
                        $('#GameBannerImage_error').show();
                        $('#GameBannerImage_error').fadeOut(9000); 
                   }
                   
                   if($("#GameCreationForm_IsSponsors").val() == 1){
                       if($("#GameCreationForm_BrandLogo").val() == "" || $("#GameCreationForm_BrandName").val() == ""){ 
                            k++;                         
                        }
                        if($("#GameCreationForm_BrandName").val() == "other" && $("#GameCreationForm_OtherValue").val() == ""){
                            k++;
                        }                        
                        if($("#GameCreationForm_BrandLogo").val() == ""){
                            $('#GameCreationForm_BrandLogo_em_').html("<?php echo Yii::t('translation','Err_Brand_logo'); ?>");
                            $('#GameCreationForm_BrandLogo_em_').show();
                            $('#GameCreationForm_BrandLogo_em_').fadeOut(9000); 
                        }else{
                            $('#GameCreationForm_BrandLogo_em_').html("").hide();
                        }
                        
                        if($("#GameCreationForm_BrandName").val() == ""){
                            $('#GameCreationForm_BrandName_em_').html("<?php echo Yii::t('translation','Err_Brand_name'); ?>");
                            $('#GameCreationForm_BrandName_em_').show();
                            $('#GameCreationForm_BrandName_em_').fadeOut(9000); 
                        }else{
                            $('#GameCreationForm_BrandName_em_').html("").hide();
                        }
                        
                        if($("#GameCreationForm_BrandName").val() == "other" && $("#GameCreationForm_OtherValue").val() == ""){
                            $('#GameCreationForm_OtherValue_em_').html("<?php echo Yii::t('translation','Err_Brand_other'); ?>");
                            $('#GameCreationForm_OtherValue_em_').show();
                            $('#GameCreationForm_OtherValue_em_').fadeOut(9000); 
                        }else{
                            $('#GameCreationForm_OtherValue_em_').html("").hide();
                        }
                   }     
                   
                if(g_question.length>0){
                     $('#errormsgForGame').hide();
                for(var i=0;i<g_question.length;i++){
                    var Q=0;
                     var   Answer = new Array();
                   
                var OptionsArray=new Array();
                    //g_question.item(i).parentNode.className="control-group";
                    var QuestionID=g_question.item(i).parentNode.id;
                    var QusetionIdDiv = QuestionID.split("_");
                    var SelectedQuestionId=QusetionIdDiv[QusetionIdDiv.length-1];
                  
                    if(g_question.item(i).value=="")
                    {k++;
                        Q++;
                        
                        var id= g_question.item(i).parentNode.id;
                        $('#'+id+'_error').html("<?php echo Yii::t('translation','please_Enter_Question'); ?>");
                        $('#'+id+'_error').show();
                        $('#'+id+'_error').fadeOut(7000);
                        //$("#"+g_question.item(i).parent().addClass('error');
                      }
                      
                      
                    if(g_optionA.item(i).value=="")
                    {k++;
                        Q++;
                        g_optionA.item(i).parentNode.className=g_optionA.item(i).parentNode.className+" error";
                        //$("#error_remove_div").append("<li>Please Enter Choice-1 of Question :" + (i+1)+"</li>");
                        var id= g_optionA.item(i).parentNode.id;
                        $('#'+id+'_error').html("<?php echo Yii::t('translation','please_enter'); ?> <?php echo Yii::t('translation','Choice'); ?> 1");
                        $('#'+id+'_error').show();
                        $('#'+id+'_error').fadeOut(7000);
                         
                         
                         
                    }else{
                        OptionsArray.push(g_optionA.item(i).value);
                    }
                    if(g_optionB.item(i).value=="")
                    {k++;
                         Q++;
                        g_optionB.item(i).parentNode.className=g_optionB.item(i).parentNode.className+" error";
                        //$("#error_remove_div").append("<li>Please Enter Choice-2 of Question :" + (i+1)+"</li>");
                        var id= g_optionB.item(i).parentNode.id;
                        $('#'+id+'_error').html("<?php echo Yii::t('translation','please_enter'); ?> <?php echo Yii::t('translation','Choice'); ?> 2 ");
                        $('#'+id+'_error').show();
                        $('#'+id+'_error').fadeOut(7000);
                        
                    }else{
                        OptionsArray.push(g_optionB.item(i).value);
                    }
                     if(g_optionC.item(i).value!="")
                    {
                         OptionsArray.push(g_optionC.item(i).value);
                    }
                     if(g_optionD.item(i).value!="")
                    {
                         OptionsArray.push(g_optionD.item(i).value);
                    }
                  
                  var check=checkIfArrayIsUnique(OptionsArray);
                  
                  if(check==false){
                      k++;
                       Q++;
                     
                      $('#UniqueOption_'+SelectedQuestionId).html("<?php echo Yii::t('translation','please_select_Unique_Choice'); ?>");
                      $('#UniqueOption_'+SelectedQuestionId).show();
                      $('#UniqueOption_'+SelectedQuestionId).fadeOut(7000);
                  }
                    if(g_points.item(i).value=="")
                    {k++;
                         Q++;
                        //g_optionD.item(i).parentNode.className=g_optionD.item(i).parentNode.className+" error";
                       // $("#error_remove_div").append("<li>Please Enter Choice-4 of Question :" + (i+1)+"</li>");
                        var id=  g_points.item(i).parentNode.id;
                        $('#'+id+'_error').html("<?php echo Yii::t('translation','please_enter_Points'); ?>");
                        $('#'+id+'_error').show();
                        $('#'+id+'_error').fadeOut(7000);
                    }
                    
                    
                    
                    var g_answer = document.getElementsByName('g_CorrectAnswer_'+SelectedQuestionId);
                      for (var j = 0; j < g_answer.length; j++) {  
                         
                          if (g_answer[j].checked) {
                               
                                Answer.push(g_answer[j].value);
                               
                                 break;
                            }
                          
                      }
                     
                   
                    if(Answer.length==0){
                        k++;
                         Q++;
                        
                        $('#CorrectAnswer_'+SelectedQuestionId).html("<?php echo Yii::t('translation','please_select_Correct_Answer'); ?>");
                        $('#CorrectAnswer_'+SelectedQuestionId).show();
                        $('#CorrectAnswer_'+SelectedQuestionId).fadeOut(7000);
                        
                    }else{
                         
                        if(Answer['0']=="C"){
                            
                            if(g_optionC.item(i).value=="" ){
                                k++;
                                Q++;
                                 $('#CorrectAnswer_'+SelectedQuestionId).html("<?php echo Yii::t('translation','please_select_Correct_Answer'); ?>");
                                 $('#CorrectAnswer_'+SelectedQuestionId).show();
                                 $('#CorrectAnswer_'+SelectedQuestionId).fadeOut(7000);
                            }
                        }else if(Answer['0']=="D"){
                           
                           if(g_optionD.item(i).value==""){
                                k++;
                                Q++;
                                 $('#CorrectAnswer_'+SelectedQuestionId).html("<?php echo Yii::t('translation','please_select_Correct_Answer'); ?>");
                                 $('#CorrectAnswer_'+SelectedQuestionId).show();
                                 $('#CorrectAnswer_'+SelectedQuestionId).fadeOut(7000);
                            }
                        }
                         
                    }
                    

                   var text= $.trim($('#editable_'+SelectedQuestionId).text())

//                 
//                    if($.trim($('#'+Question_description[i]).text())=="")
//                    {
//                        
//                        k++;
//                         Q++;
//                      
//                        $('#GameQuestion_'+Question_description[i]).html("<?php echo Yii::t('translation','please_enter_Question_Disclaimer'); ?>");
//                        $('#GameQuestion_'+Question_description[i]).show();
//                        $('#GameQuestion_'+Question_description[i]).fadeOut(7000);
//                        
//                       //  $("#error_remove_div").append("<li>Please Enter Question Disclaimer for Question :" + (i+1)+"</li>");
//                    }

                 
//                    if($.trim($('#editable_'+SelectedQuestionId).text())=="")
//                    {
//                        
//                        k++;
//                         Q++;
//                    
//                        $('#GameQuestion_editable_'+SelectedQuestionId).html("<?php echo Yii::t('translation','please_enter_Question_Disclaimer'); ?>");
//                        $('#GameQuestion_editable_'+SelectedQuestionId).show();
//                        $('#GameQuestion_editable_'+SelectedQuestionId).fadeOut(7000);
//                        
//                       //  $("#error_remove_div").append("<li>Please Enter Question Disclaimer for Question :" + (i+1)+"</li>");
//                    }

                    
                    if(Q>0){
                       
                        if(GameID!=""){
                              $('#collapse_'+SelectedQuestionId).addClass('alert-error');
                        }else{
                          $('#collapse_'+SelectedQuestionId).addClass('alert-error');
                        }
                         
                    }else{
                        if(GameID!=""){
                              $('#collapse_'+SelectedQuestionId).removeClass('alert-error');
                       }else{
                         $('#collapse_'+SelectedQuestionId).removeClass('alert-error');
                       }
                      // $('#collapse_'+i).removeClass('alert-error');
                    }

                }
               } else{
                   k++;
                   g_question.length
                   $('#errormsgForGame').html("<?php echo Yii::t('translation','please_select_one_Question'); ?>");
                   $('#errormsgForGame').show();
                   $('#errormsgForGame').fadeOut(7000);
               }
               
               
                
                $("#custom_error").append('</div>');
                
                if(k>0){
                    
                   // $("#custom_error").show(); 
                  
                    return;
                }else{

                $( ".questionClass" ).each(function(key,index) {
                    
                        $(this).removeClass('alert-error');
             
                });

                    var Garray=new Array()

                    for(var i=0;i<g_question.length;i++){
                        var question=new Object()

                        question.question=g_question.item(i).value;
                       
                        var Qusetionid = g_question.item(i).id.split("_");
                        if(Qusetionid.length > 1){
                             question.questionId=""; 
                        }else{
                           question.questionId=g_question.item(i).id; 
                        }
                       
                        
                        question.optionA=g_optionA.item(i).value;
                        question.optionA_disclaimer=g_optionA_explanation.item(i).value;
                        question.optionB=g_optionB.item(i).value;
                        question.optionB_disclaimer=g_optionB_explanation.item(i).value;
                        question.optionC=g_optionC.item(i).value;
                        question.optionC_disclaimer=g_optionC_explanation.item(i).value;
                        question.optionD=g_optionD.item(i).value;
                        question.optionD_disclaimer=g_optionD_explanation.item(i).value;
                        question.points=g_points.item(i).value;

                        question.image= images[i];

                        question.answer=CorrectAnswer[Qusetionid[1]];
                        question.position=i;
                        question.question_disclaimer=$('#'+Question_description[i]).html();
                         
                       // Garray[i]=JSON.stringify(question);
                         Garray[i]=question;

                    }
                    
                    // $('#GameCreationForm_QusetionCount').val(g_question.length);
                     
                    $('#GameCreationForm_Questions').val(JSON.stringify(Garray));

                }

                  $('#GameCreationForm_GameName').val($.trim($('#GameName').text()));
                   $('#GameCreationForm_GameDescription').val($.trim($('#GameDescription').text()));
                   if($('#GameCreationForm_GameBannerImage').val()==""){
                        $('#GameCreationForm_GameBannerImage').val( $('#GameBannerPreview').attr('src'));
                   }
                   
               
           var data=$("#gamecreation-form").serialize();
           scrollPleaseWait("gamespinner");
           
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("/game/newgameCreation"); ?>',
                    data:data,
                    success:saveGameFormHandler,
                    error: function(data) { // if error occured
                       // alert("Error occured.please try again==="+data.toSource());
                        // alert(data.toSource());
                    },

                    dataType:'json'
                });      
//         
 }   
  function checkIfArrayIsUnique(myArray) 
{
    
    var i;
            var len = myArray.length;
            var outputArray = [];
            var temp = {};

            for (i = 0; i < len; i++) {
                temp[myArray[i]] = 0;
            }
            for (i in temp) {
                outputArray.push(i);
            }
    
    if(myArray.length==outputArray.length){
        
        return true;
        
     }else{
         
         return false;
         
      }
        
    
    
//    for (var i = 0; i < myArray.length; i++) 
//    {
//        if (myArray.indexOf(myArray[i]) !== myArray.lastIndexOf(myArray[i])) { 
//            return false; 
//        } 
//    } 
    return true;   // this means not unique
}  
  function saveGameFormHandler(data){
scrollPleaseWaitClose("gamespinner");
            if(data.status=="success"){
            
                //$("#reg_error").removeClass();
                 $('#sucmsgForGame').show();
                 if(data.message!=""){
                      $("#sucmsgForGame").html("<?php echo Yii::t('translation','Game_updated_successfully'); ?>");
                       window.location='/game/index';
                     
                 }else{
                   
                     $("#sucmsgForGame").html("<?php echo Yii::t('translation','Game_created_successfully'); ?>");
                    window.location='/game/index';
                 }
                
                   $('#sucmsgForGame').fadeOut(3000);
                
                $("#gameform_question_div_sub").append("");
                $("#gameform_question_div_sub").html("");
                $("#gameform_question_div").html("");
//               var data="";
                g_correctAnswer=0;
                $('#GameCreationForm_GameName').val("");
                $('#GameCreationForm_GameDescription').val("");
                $('#GameName').html("");
                $('#GameDescription').html("");
                $('#GameBannerPreview').attr('src','/images/system/game_banner.jpg');
                $('#GameCreationForm_GameDescription').val($.trim($('#GameDescription').text()));
                $('#GameBannerImage_Edit').hide();
                $('#GameName').addClass("gameplaceholder");
                $('#GameDescription').addClass("Gamedescriptionplaceholder");
                var URL = "/game/AddNewQuestion?Id=" + g_correctAnswer;
                ajaxRequest(URL,data,function(data){renderPostDetailPageHandler(data)},"html");
//                getEmployerLiteracy(0,g_filterValue,$("#searchTextId").val());
            }else{
               
               
               $('#errormsgForGame').show();
               $("#errormsgForGame").html(data.error);
               $('#errormsgForGame').fadeOut(7000);
               
               
            }
                    

            
        }  
    
 function getGamedetails(gameId){
     
     var URL = "/game/Editgame?GameId=" + gameId;
     // var queryString = "";  
    // ajaxRequest(URL,queryString,renderGameEditPageHandler);
     
     var data="";
    //var URL = "/game/AddNewQuestion?GameId=" + gameId;
     ajaxRequest(URL,data,function(data){renderGameEditPageHandler(data)},"html");
     
  }
  
  function renderGameEditPageHandler(html){
       $('#gameform_question_div_sub').html('');
       $("#gameform_question_div_sub").append(html);
       $('#GameQuestionImage_').attr("id", 'GameQuestionImage_'+g_correctAnswer);
   initializeFileUploader('GameQuestionImage_'+g_correctAnswer, '/game/UploadGameBannerImage', '10*1024*1024', Questionextensions,1, 'GameQuestionImage_'+g_correctAnswer ,g_correctAnswer,GameQuestionPreviewImage,displayErrorForBannerAndQuestion);
   $('#QuestionPreviewdiv_').attr("id", 'QuestionPreviewdiv_'+g_correctAnswer);
   $('#QuestionPreview_').attr("id", 'QuestionPreview_'+g_correctAnswer);

    g_correctAnswer=g_correctAnswer+1;
    
    if(g_correctAnswer >0){
         
         $('#GameBUttonArea').show();
      }
                             
        }
        
   function ShowGameEditButtonArea(gameField){
       
       // $('#'+gameField+'_Edit').show();
       
       
   }
    function HideGameEditButtonArea(gameField,Fieldvalue){
       
       // $('#'+gameField+'_Edit').hide();
 
        $('#'+gameField).html(Fieldvalue);
      
       // alert('#'+gameField+'_Edit');
        $('#'+gameField+'_Edit').hide();
       
       
   }
        
        
  function EditGameDescription(gameField,gameId){
      var fieldName=gameField;
     var Fieldvalue=$.trim($('#'+gameField).text());
     
     if(gameField=='GameBannerImage'){
         
        Fieldvalue= $('#GameBannerPreview').attr('src');
         
        }
     
     if(gameId!=""){
         
          var queryString = "&gameId=" + gameId + "&gameFiled=" + gameField+ "&Filedvalue=" + Fieldvalue;
            ajaxRequest("/game/UpdateGameFields", queryString,function(data) {
                EditGameDescriptionHandler(data, fieldName);
                  
            });
         
        }
       
      
    }
        
  function EditGameDescriptionHandler(data,fieldName){
//      alert("in handler");
          // alert(data.toSource());
      // $('#'+fieldName).hide();
     
     // $('#'+fieldName).show();
      
  }
        
  function hideAllQuestion(){
      
      
      $.each(data, function(i, value) {
      if (i == g_correctAnswer-1) {
            return false;
      }
      // Use this value
});

      
     //  $("#Question_"+id).collapse('hide');
      
    }
    
    
    
    
 function cancelGameBannerOrIconUpload(originalImage,id){
     
      
     $('#GameCreationForm_GameBannerImage').val(originalImage);
    $('#GameBannerPreview').attr('src', originalImage);
     
     
 }
 
 
 function closeNewQuestion(QuestionId){
     
    // g_correctAnswer=g_correctAnswer-1
     if(g_correctAnswer==0){
         
         //$('#GameBUttonArea').hide();
      }
      var question_label = document.getElementsByName('QuestionLabel');
    
      if(document.getElementsByName('g_question').length==1){
       
          g_correctAnswer=0;
        }

//        var question_label = document.getElementsByName('QuestionLabel');
//        var j=0;
//         for(var i=0;i< question_label.length;i++){
//           
//            if(QuestionId==i){
//                
//            }else{
//                
//             j++;   
//            }
//            
//            $('#label_'+id).text('Question  '+j);
//            
//           // $('.panel-heading a').html('QUESTION'+j); 
//
//        }
//        var collaps_question_label = document.getElementsByName('collapsQuestionId');
//        var l=0;
//       
//         for(var s=0;s<= collaps_question_label.length;s++){
//              var h=s+1;
//              var divId=collaps_question_label.item(s).id;
//              alert(divId);
//              
//                $('#collapse_'+s).text('Question  '+j);
//            
//              ('#'+divId).attr('id','collapse_'+s);
//              
//              
//            if(QuestionId==s){
//               // alert("equal");
//            }else{
//                
////             l++;   
//              //$('#collapse_'+k).text('Question  '+l);
//             
//            // alert(collaps_question_label.item(s).text);
//            alert(collaps_question_label.item(s).text);
//             collaps_question_label.item(s).text='Question  '+h;
//             alert(h+"h valuee");
//              alert("afterr"+collaps_question_label.item(s).text);
//            }
//             l++;  
//        }
  }
  
  
  function CancelGameCreation(){
      
     window.location='/game/index';
      var gamemode=$('#GameFormButtonId').val();
//      if(gamemode=='Update'){
//          
//           window.location='/game/index';
//      }
   
//    $("#gameform_question_div_sub").append("");
//    $("#gameform_question_div_sub").html("");
//    $("#gameform_question_div").html("");
//    g_correctAnswer=0;
//     $("#error_remove_div").html("");
//    $('#GameCreationForm_GameName').val("");
//    $('#GameCreationForm_GameDescription').val("");
//    $('#GameName').html("");
//    $('#GameDescription').html("");
//    $('#GameBannerPreview').attr('src','/images/system/game_banner.jpg');
//    $('#GameCreationForm_GameDescription').val($.trim($('#GameDescription').text()));
//       window.location='/game/index';
  //  var URL = "/game/AddNewQuestion?Id=" + g_correctAnswer;
  //  var data="";
   // ajaxRequest(URL,data,function(data){renderPostDetailPageHandler(data)},"html");    

      
  }
  
  

function isNumberKey(evt)
{
   
       var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function displayErrorMessage(key,val){
    $("#"+key+"_em_").text(val);                                                   
    $("#"+key+"_em_").show(); 
    $("#"+key+"_em_").fadeOut(7000);
    $("#"+key).parent().addClass('error');
}
    
    function restrictGameLength(){
        var gameNameText = $('#GameName').text();                 
        var mxlen = 10;  
  
        if(gameNameText.length> mxlen)  
         {  var res = gameNameText.substring(0, 10);
             $('#GameName').html(res);                 
           return false;  
          }  
        else  
       {  
       return true;     
        }  

    }
 
    
  // $(".questionClass").live('click',function(){
       
//       var cid= $(this).attr('id');
//       alert(cid);
//       var Collapsdiv = cid.split("_");
//    
//    var CollapsId=Collapsdiv[Collapsdiv.length-1];
//       $( ".panel-collapse" ).each(function(key,index) {
////          
//       $(this).removeClass('in'); 
//   });
//   var ApsId=parseInt(CollapsId) + 1;
//    alert(ApsId);
//    $('#collapse'+ApsId).addClass('in');
//    alert("after addd");
    
  //  }); 
    
//    $(".panel-collapse").live('click',function(){
//       alert("rrrrrr");
//       var id= $(this).id;
//       alert("iddddddddd"+id);
//       $( ".panel-collapse" ).each(function(key,index) {
//          
//       $(this).removeClass('in') });
//   
//    $('#'+id).addClass('in');
//   
//      questionClass 
//   });  

function BrandPreviewImage(id, fileName, responseJSON, type)
    {
        var data = eval(responseJSON);
       $('#GameCreationForm_BrandLogo').val(data.filename);
       $("#brandimagelogodiv").attr("style","padding-left:30px;");
        $('#brandPreview').attr('src', data.filepath);


    }
    
    $("#GameCreationForm_OtherValue").keyup(function()
    { 

        $('#GameCreationForm_OtherValue').focus();
        if($.trim($('#GameCreationForm_OtherValue').val()) != ""){           
           $('#GameCreationForm_OtherValue_em_').html("").hide();             
            return false;
         }else{
              //$(this).addClass("gameplaceholder");
              $('#GameCreationForm_OtherValue_em_').html("<?php echo Yii::t('translation','Err_Brand_other'); ?>");
              $('#GameCreationForm_OtherValue_em_').show();
              //$('#GameName_error').fadeOut(7000); 
         }
        return false;
    });
</script>