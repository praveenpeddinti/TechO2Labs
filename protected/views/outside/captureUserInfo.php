<div class=" newgrouppopupdivtop"> 
    <h2 class="pagetitle positionrelative searchfiltericon"><?php echo Yii::t('translation','User_Info'); ?></h2>
    <?php
    $userinfomsg = Yii::t('translation','User_capture_Information');
    $userinfomsg = str_replace("{survey_title}","\"<u>".$surveyTitle."</u>\"",$userinfomsg);
    ?>
    <h4 class=" positionrelative searchfiltericon alert alert-info" style="font-family:'exo_2.0medium'; font-size: 14px;"><?php echo $userinfomsg; ?></h4>
    <h4 class=" positionrelative searchfiltericon" style="font-family:'exo_2.0medium'; font-size: 14px;"><?php echo Yii::t('translation','User_Info_Disclaimer'); ?></h4>
    
    <div class=" p_card">
        <div class="p_icon">
         
      
                        <div class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3 noBackGrUp">
                            
                            <div class="positionrelative editicondiv editicondivProfileImage no_border skiptaiconinner ">
                                
                                <div class="edit_iconbg" style="display: none;">
                                    <div id="UserProfileImage"></div>


                                    
                                </div>
<!--                                <img id="profileImagePreviewId" src="<?php  //echo $profileDetails->ProfilePicture ?>" alt="" />-->
                               <img id="profileImagePreviewId" src="<?php echo $profilePic; ?>"  alt="" />
                            </div>
                
                            
                        </div>    

            </div>
        <div class="pagetitle profiletitle paddingzero lineheight20 positionrelative  editProfileDisplayName paddingTL10 paddingT10" id="profileFirstName"><?php  echo $displayName ?> </div>
        
        </div>
    
    
<?php
    
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'userinfo-form',
                            'method'=>'post',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                                'validateOnChange' => true,
                            ),
                            //'htmlOptions' => array('enctype' => 'multipart/form-data','class'=>'marginzero'),
                                ));
                        ?>
                    
       <?php echo $form->hiddenField($UserInfo,"SurveyId"); ?>
        <?php echo $form->hiddenField($UserInfo,"ScheduleId"); ?>
                     
               
                  
         <div id="registrationSpinLoader"></div>
                      <div class="alert-error" id="errmsg" style='padding-top: 5px;text-align:center;display:none;'> 
                        
                      </div>
                       <div class="alert-success" id="sucmsg" style='padding-top: 5px;text-align:center;display:none;'>                          </div>

                
                <div class="regdiv">
                    
                <div class="row-fluid">
                <div class="span12">
                <div class="span4 ">                
                    <label><?php echo Yii::t('translation','User_Register_Firstname'); ?></label>
                      
                      <?php echo $form->textField($UserInfo, 'FirstName', array('maxlength' => '50', 'class' => 'span12 textfield')); ?>
                  <div class="control-group controlerror marginbottom10">
                     <?php echo $form->error($UserInfo,'FirstName'); ?>
                     
                    </div>
                </div>
                   
                <div class="span4">
                      
                        <label><?php echo Yii::t('translation','User_Register_Lastname'); ?></label>
                         
                        <?php echo $form->textField($UserInfo, 'LastName', array('maxlength' => '50', 'class' => 'span12 textfield')); ?>
                        <div class="control-group controlerror marginbottom10">
                            <?php echo $form->error($UserInfo,'LastName'); ?>
                     </div>
                </div>
                   
                    
                </div>
                </div>
                         
              <div class="row-fluid">
                <div class="span12">
                     <div class="span4">
                        <label><?php echo Yii::t('translation','User_Specialty'); ?></label>
                    
                    <?php echo $form->textField($UserInfo, 'MedicalSpecialty', array('maxlength' => '50', 'class' => 'span12 textfield')); ?>
                        <div class="control-group controlerror marginbottom10">
                        <?php echo $form->error($UserInfo,'MedicalSpecialty'); ?>
                    </div>
                    </div>
                <div class="span4">
                    
                    <label><?php echo Yii::t('translation','User_Credential'); ?></label>
                    
                    <?php echo $form->textField($UserInfo, 'Credential', array('maxlength' => '50', 'class' => 'span12 textfield')); ?>
                       <div class="control-group controlerror marginbottom10"> <?php echo $form->error($UserInfo,'Credential'); ?>
                    </div>
                </div>
                    
                    
                     
                </div>
                </div>
                        <div class="row-fluid">
                <div class="span12">
                <div class="span4">
                    
                    <label><?php echo Yii::t('translation','User_Address1'); ?></label>
                    
                    <?php echo $form->textField($UserInfo, 'Address1', array('maxlength' => '50', 'class' => 'span12 textfield')); ?>
                    <div class="control-group controlerror marginbottom10"><?php echo $form->error($UserInfo,'Address1'); ?>
                    </div>
                </div>
                    
                    <div class="span4">
                        <label><?php echo Yii::t('translation','User_Address2'); ?></label>
                        
                        <?php echo $form->textField($UserInfo, 'Address2', array('maxlength' => '50', 'class' => 'span12 textfield')); ?>
                        <div class="control-group controlerror marginbottom10"><?php echo $form->error($UserInfo,'Address2'); ?>
                        </div>
                    </div>
                    
                   
                     
                </div>
                </div>
                        <div class="row-fluid">
                            <div class="span12">
                                 <div class="span4"> 
                                    <label><?php echo Yii::t('translation','User_City'); ?></label>
                                    
                                    <?php echo $form->textField($UserInfo, 'City', array('maxlength' => '50', 'class' => 'span12 textfield')); ?>
                                        <div class="control-group controlerror marginbottom10"><?php echo $form->error($UserInfo,'City'); ?>
                                    </div>
                                </div>
                                
                                <div class="span4 positionrelative" >
                                    <label><?php echo Yii::t('translation','User_Register_State'); ?></label>
                                    
                                    <?php   echo $form->dropDownlist($UserInfo, 'State', CHtml::listData(State::model()->findAll(),'State','State'),array(
                                    'class'=>"styled span12 textfield",
                                    'empty'=>"Please Select state",
                                    )); 
                                          ?>   
                                    
                                    
                                       <div class="control-group controlerror marginbottom10">
                                           <?php echo $form->error($UserInfo,'State'); ?>
                                    </div>                                     
                               </div> 
                                 </div>
                </div>
                        <div class="row-fluid">
                            <div class="span12">
                                
                                <div class="span4">
                                    <label><?php echo Yii::t('translation','User_Zip'); ?></label>
                                    
                                    <?php echo $form->textField($UserInfo, 'Zip', array('maxlength' => '8', 'class' => 'span12 textfield')); ?>
                                        <div class="control-group controlerror marginbottom10"><?php echo $form->error($UserInfo,'Zip'); ?>
                                    </div>
                                </div>
                                <div class="span4">
                                    <label><?php echo Yii::t('translation','User_Phone'); ?></label>
                                    
                                    <?php echo $form->textField($UserInfo, 'Phone', array('maxlength' => '20', 'class' => 'span12 textfield')); ?>
                                       <div class="control-group controlerror marginbottom10"> <?php echo $form->error($UserInfo,'Phone'); ?>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                       
                
                
                    <div class="row-fluid" id="npinumber" >
                        <div class="span12">
                        <div class="span4" >
                                 <label><?php echo Yii::t('translation','User_NPInumber'); ?></label>

                                 <?php echo $form->textField($UserInfo, 'NPINumber', array('maxlength' => '10', 'class' => 'span12 textfield npinumbersf')); ?>
                                     <div class="control-group controlerror marginbottom10"><?php echo $form->error($UserInfo,'NPINumber'); ?>
                                 </div>
                         </div>

                        </div>
                         </div>
                    <div class="row-fluid">
                <div class="span12">
                    <div class="span5">
                  
                        

                       <div class="lineheight25 pull-left radiobutton ">
                           
                            <div class="control-group controlerror marginbottom20 " id="npistatusdiv">
                                <input type="checkbox" id="npistatus_checkbox" class="styled" <?php if($UserInfo->HavingNPINumber==0) echo "checked"?>/>
                                <label class="marginbottom10"><?php echo  Yii::t('translation', 'User_Register_Donot_Have_NPINumber'); ?></label>
                                <?php echo $form->hiddenField($UserInfo,'HavingNPINumber',array("value"=>1)); ?>
                         
                               
                            <div class="control-group controlerror marginbottom20 " >

                            <?php echo $form->error($UserInfo,'HavingNPINumber'); ?>
                           
                       </div>
                       
                       
                       
                    </div>
                </div>
                    </div>
                    
                    
                
                </div>
                    
                </div>

                        <div id="npinumber_div" style="<?php if($UserInfo->HavingNPINumber==1) echo 'display:none'?>">
                            <input type="hidden" name="MarketResearchFollowUpForm[LicensedStates]" id="MarketResearchFollowUpForm_LicensedStates" value="<?php echo $licState; ?>"/>                                    
                            <input type="hidden" name="MarketResearchFollowUpForm[LicensedNumbers]" id="MarketResearchFollowUpForm_LicensedNumbers" value="<?php echo $stateLicNumber ?>"/>                                    
                        <div  class="row-fluid">
                            <div class="span12">
                                <div class="span4 positionrelative">
                                    <input type="hidden" name="MarketResearchFollowUpForm[LicensedState][1]" id="MarketResearchFollowUpForm_LicensedStates_1" value="<?php echo $licState; ?>"/>                                    
                                    <label><?php echo Yii::t('translation','User_LicensedState'); ?></label>
                                    <?php   echo $form->dropDownlist($UserInfo, 'LicensedState', CHtml::listData(State::model()->findAll(),'id','State'),array(
                                    'class'=>"styled span12 textfield licstates",
                                    'empty'=>"Please Select state"
                                    ),array("data-id"=>1)); 
                                          ?> 
                                     <div class="control-group controlerror marginbottom20 " >
                                    <div style="display:none" id="MarketResearchFollowUpForm_LicensedStates_1_em_" class="errorMessage"  ></div>
                                </div>
                                     </div>
                                <div class="span4">
                                    <input type="hidden" name="MarketResearchFollowUpForm[LicensedNumber][1]" id="MarketResearchFollowUpForm_LicensedNumber_1" value="<?php echo $stateLicNumber ?>"/>
                                    <label><?php echo Yii::t('translation','User_LicensedNumber'); ?></label>
                                    
                                    <?php echo $form->textField($UserInfo, 'LicensedNumber', array('maxlength' => '8', 'class' => 'span12 textfield licnumber','onblur'=>"insertText(this.id);","data-id"=>"1","value"=>$stateLicNumber)); ?>
                                        <div class="control-group controlerror marginbottom10"><div style="display:none" id="MarketResearchFollowUpForm_LicensedNumber_1_em_" class="errorMessage"  ></div>
                                    </div>
                                    
                                </div>
                                <div class="span4 headeraddbuttonarea " style="padding-top:22px;"><img id="addmorel" class="surveyaddbutton tooltiplink cursor" rel="tooltip"  data-original-title="Add more Licensed states" src="/images/system/spacer.png" /></div>
                            </div>
                        </div> 
                            </div>
                    
                    
                    
                    
                    
                        <div  class="row-fluid" >
                            <div class="span12"> 
                                <div class="span4">
                                    <label><?php echo Yii::t('translation','User_FederalTxId_SSN'); ?></label>
                                    
                                    <?php echo $form->textField($UserInfo, 'FederalTaxIdOrSSN', array('maxlength' => '9', 'class' => 'span12 textfield')); ?>
                                       <div class="control-group controlerror marginbottom10"> <?php echo $form->error($UserInfo,'FederalTaxIdOrSSN'); ?>
                                    </div>
                                </div>
                                    
                            </div>
                            </div>
               
            
                    <div class="headerbuttonpopup" style="padding-top: 10px">
                        <input type="button" value="Save"  id ='userregistration' class='btn btn-2 btn-2a pull-right' />

                                   </div>

                                
      </div>
                
               <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    $("#userview_Bannerprofile").hide();
    $("#selectMarketResearchFollowUpForm[LicensedState]").html('<?php echo $licState; ?>');
    $("#MarketResearchFollowUpForm_LicensedState").val('<?php echo $licState; ?>');
    $(document).ready(function(){
       Custom.init();
       if("<?php echo $UserInfo->HavingNPINumber ?>" == 0){
         $("#MarketResearchFollowUpForm_NPINumber").attr("disabled", "disabled");
          $("#MarketResearchFollowUpForm_HavingNPINumber").val("0");
            $("#npinumber").hide();
    }
       
       $("#npistatusdiv span.checkbox").live("click",function(){
          var $this = $(this);
          var isChecked = 0;
          if($this.attr("style") == "background-position: 0px -50px;"){
              isChecked = 0;
              $("#npinumber").hide();
              $("#npinumber_div").show();
          }else{
              isChecked = 1;
              $("#npinumber").show()
               $("#MarketResearchFollowUpForm_NPINumber").removeAttr("disabled");
               $("#npinumber_div").hide();
          }
          $("#MarketResearchFollowUpForm_HavingNPINumber").val(isChecked);
          
       });
       
    });
    var licstr = "";
    var liid = 0;
    var licId = 0;
    var statestr = "";
    var sttid = 0;
    function insertText(id){
//        var $this = $("#"+id);
//        licId = $this.attr("data-id");
//        if(liid == 0){
//            licstr = $this.val();
//            liid = $this.attr("data-id");
//        }else if(licId != liid){
//            licstr = licstr + ","+ $this.val();
//        }else if(licId == liid){
//            licstr = $this.val();
//        }
        $(".licnumber").each(function(){
            var $this = $(this);
            if(licstr == ""){
                licstr = $this.val();
            }else{
                licstr = licstr + ","+ $this.val();
            }
        });
        $("#MarketResearchFollowUpForm_LicensedNumbers").val(licstr);
        licstr = "";
    }
    $("#userregistration").bind("click",function(){
        $(this).attr("disabled",true);
        var data = $("#userinfo-form").serialize();     
        $.ajax({
            type: 'POST',
            url: '/outside/captureUserInfo',
            data: data,
            async:true,
            success: function(data) {
                $(this).attr("disabled",false);
                 captureUserInfoHandler(data);
            },
            error: function(data) { // if error occured
                
            },
            dataType: 'json'
        });
    });
    var tot = 1;
    $("#addmorel").bind("click",function(){
        var URL = "/outside/renderStates";
        
        
        $(".npinumbersf").each(function(){
            tot++;
            
        });
        var queryString = "tot="+tot;
        ajaxRequest(URL, queryString, function(data) {
                               renderStatesHandler(data)
                           }, "html"); 
    });
    $(".deleteoption").live("click",function(){
        var $this = $(this);
        var idva = $this.attr("data-value");
        $("#options_"+idva).remove();
        $(".licstates").each(function(){
            var $this = $(this);
            if(statestr == ""){
                statestr = $this.val();
            }else{
                statestr = statestr+","+$this.val();
            }
        }); 
        $("#MarketResearchFollowUpForm_LicensedStates").val(statestr);
     
        statestr = "";
        $(".licnumber").each(function(){
            var $this = $(this);
            if(licstr == ""){
                licstr = $this.val();
            }else{
                licstr = licstr + ","+ $this.val();
            }
        });
        $("#MarketResearchFollowUpForm_LicensedNumbers").val(licstr);
        licstr = "";
    });
    function renderStatesHandler(html){
        $("#npinumber_div").append(html);
        Custom.init();
    }
    
    $(".licstates").live('change',function(){        
        $(".licstates").each(function(){
            var $this = $(this);
            if(statestr == ""){
                statestr = $this.val();
            }else{
                statestr = statestr+","+$this.val();
            }
        }); 
        $("#MarketResearchFollowUpForm_LicensedStates").val(statestr);
        statestr = "";
    });
function captureUserInfoHandler(data){
     scrollPleaseWaitClose('registrationSpinLoader');
        var data = eval(data);
        $("#userregistration").removeAttr("disabled");
        if (data.status == 'success') {
           window.location.href = document.URL;
           
            //$("form").serialize()
        } else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {

                $("#errmsg").html(msg);
                $("#errmsg").css("display", "block");
                $("#sucmsg").css("display", "none");
                $("#errmsg").fadeOut(5000);

            } else {

                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {
                    var error = eval(data.error);
                }


                $.each(error, function(key, val) {

                    if ($("#" + key + "_em_")) {

                        // alert(key);
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(5000);
                        $("#" + key).parent().addClass('error');
                    }

                });
            }
        }
}
</script>
