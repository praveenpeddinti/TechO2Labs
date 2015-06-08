

      
<h2 class="pagetitle positionrelative searchfiltericon"><?php echo Yii::t('translation','User_Settings'); ?> </h2>  
                 
        

<div class="accordion " style="padding-top:20px" id="accordion2">
<div class="accordion-group customaccordion-group">
<div class="accordion-heading customaccordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
Profile Details
</a>
</div>
<div id="collapseOne" class="accordion-body collapse in">
<div class="accordion-inner customaccordion-inner">
    
     <div class="custaccrodianouterdiv">
          <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'userregistration-form',
                            'method'=>'post',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                                'validateOnChange' => true,
                            ),
                            'htmlOptions' => array('enctype' => 'multipart/form-data','class'=>'marginzero'),
                                ));
                        ?>
                   
     <div id="registrationSpinLoader"></div>
                      <div class="alert-error" id="errmsg" style='padding-top: 5px;text-align:center;display:none;'> 
                        
                      </div>
                       <div class="alert-success" id="sucmsg" style='padding-top: 5px;text-align:center;display:none;'>                          
                       </div>
        <?php if($countryRequest==1){ ?>
        <div role="alert" class="alert alert-warning" >
            <?php echo $message; ?>
        </div>
        <?php }else if($countryRequest==2){ ?>
        <div role="alert" class="alert alert-danger" >
            <?php echo $message; ?>
        </div>
        <?php } ?>
   <div class="regdiv reim_regdiv">

                <div class="row-fluid padding-bottom10">
                <div class="span6">
                
                    <label><?php echo Yii::t('translation','User_Register_Firstname'); ?></label>
                      <div class="control-group controlerror marginbottom10">
                      <?php echo $form->textField($UserRegistrationForm, 'firstName', array("id" => "UserRegistrationForm_firstName", 'maxlength' => '50', 'class' => 'span12 textfield')); ?>
                  
                     <?php echo $form->error($UserRegistrationForm,'firstName'); ?>
                     
                    </div>
                </div>
                <div class="span6">
                      
                        <label><?php echo Yii::t('translation','User_Register_Lastname'); ?></label>
                         <div class="control-group controlerror marginbottom10">
                        <?php echo $form->textField($UserRegistrationForm, 'lastName', array("id" => "UserRegistrationForm_lastName", 'maxlength' => '50', 'class' => 'span12 textfield')); ?>
                        
                            <?php echo $form->error($UserRegistrationForm,'lastName'); ?>
                     </div>
                </div>
                
                  </div>
                    
                    <div class="row-fluid padding-bottom10">
                    <div class="span6">
                    
                    <label><?php echo Yii::t('translation','User_Register_Company'); ?></label>
                    <div class="control-group controlerror marginbottom10">
                    <?php echo $form->textField($UserRegistrationForm, 'companyName', array("id" => "UserRegistrationForm_companyName", 'maxlength' => '50', 'class' => 'span12 textfield')); ?>
                        <?php echo $form->error($UserRegistrationForm,'companyName'); ?>
                    </div>
                </div>
                 <div class="span6">
                    
                        <label><?php echo Yii::t('translation','User_Register_Email'); ?></label>

                         <div class="control-group controlerror marginbottom10">

                         <?php echo $form->textField($UserRegistrationForm, 'email', array("id" => "UserRegistrationForm_email",'autocomplete'=>'off', 'maxlength' => '30','data-original-title'=>'This will be your Username to access the network','rel'=>'tooltip', 'data-placement'=>'bottom', 'lass'=>'tooltiplink', 'class' => 'tooltiplink span12 textfield')); ?>

                       
                             <?php echo $form->error($UserRegistrationForm,'email'); ?>
                     </div>
                </div>
               </div>
              <div class="row-fluid padding-bottom10">

                <div class="span6 divrelative" id="registartion_country">
                 
                    <label><?php echo Yii::t('translation','User_Register_Country'); ?></label>
                      <?php   echo $form->dropDownList($UserRegistrationForm, 'country',CHtml::listData(Countries::model()->findAll(),'Id','Name'), array(
                        'class'=>"styled span12 textfield",
                        'empty'=>"Please Select country",  
                        'ajax' => array(
                                        'type' => 'POST',
                                        'url'=>$this->createUrl('user/dynamicstates'),   
                                        'update' => '#UserSettingsForm_state',                        
                                        'data'=>array('country'=>'js:this.value','requestFrom'=>'settings'), 
                                        'success'=> 'function(data) {
                                            if (data.indexOf("<option") !=-1){
                                             $("#dynamicstates").show();
                                             $("#dynamicstatetextbox").hide();
                                              $("#dynamicstatetextbox").html("");
                                                 $("#UserSettingsForm_state").empty();
                                                  $("#registartion_state").find("span").text("Please Select state");
                                                        $("#UserSettingsForm_state").append(data);
                                                        $("#UserSettingsForm_state").trigger("liszt:updated");

                                        }else{
                                             $("#dynamicstates").hide();
                                            $("#dynamicstatetextbox").show();
                                            $("#dynamicstatetextbox").html();
                                            $("#dynamicstatetextbox").html(data);
                                        }


                                                                } ',

                        )));
                      ?>
                   
                    
                        <div class="control-group controlerror marginbottom10">
                                   <?php echo $form->error($UserRegistrationForm,'country'); ?>
                     </div>
                   </div>
                     <div class="span6 divrelative" id="registartion_state" >
                     <label><?php echo Yii::t('translation','User_Register_State'); ?></label>
                     <div id="dynamicstates" style="<?php echo $countryId==1?'display:block':'display:none'  ?>">
                     <?php
                        echo $form->dropDownlist($UserRegistrationForm, 'state',CHtml::listData(State::model()->findAllByAttributes(array("CountryId"=>$UserRegistrationForm->country)),'State','State'),array('selected'=>$stateId),array(
                        'class'=>"styled span12 textfield",
                        'empty'=>"Please Select state",
                            ));
                        ?>
  
                     </div>
                     <div id="dynamicstatetextbox" style="<?php echo $countryId==1?'display:none':'display:block'  ?>">
                       <?php if($countryId!=1){?>
                         
                          <?php echo $form->textField($UserRegistrationForm, 'state', array( 'maxlength' => '50', 'class' => 'span12 textfield')); ?>
                        
                       <?php }?>
                     </div>
                        <div class="control-group controlerror marginbottom10">
                            <?php echo $form->error($UserRegistrationForm,'state'); ?>
                     </div>

                </div>
                </div>
                <div class="row-fluid padding-bottom10">
               <div class="span6 divrelative">
                   
                    <label><?php echo Yii::t('translation','User_Register_City'); ?></label>
                      <div class="control-group controlerror marginbottom10"  >
                         <?php echo $form->textField($UserRegistrationForm, 'city', array("id" => "UserRegistrationForm_city", 'maxlength' => '50', 'class' => 'span12 textfield')); ?>
                             <?php echo $form->error($UserRegistrationForm,'city'); ?>
                          </div>
                </div>
                
                    <div class="span6">
                     
                    <label><?php echo Yii::t('translation','User_Register_Zip'); ?></label>
                     <div class="control-group controlerror marginbottom10"> 
                        <?php echo $form->textField($UserRegistrationForm, 'zip', array("id" => "UserRegistrationForm_zip", 'maxlength' => '10', 'class' => 'span12 textfield')); ?>
                      
                            <?php echo $form->error($UserRegistrationForm,'zip'); ?>
                    </div>
                </div>

                </div>
       
              <div class="row-fluid padding-bottom10">
            <div class="span6">

                    <label><?php echo Yii::t('subspecialty', 'User_Register_Are_You_Specialist'); ?></label>

                    <div class="lineheight25 pull-left radiobutton ">
                        <div class="control-group controlerror marginbottom20 " >
                            <?php echo $form->radioButtonList($UserRegistrationForm, 'IsSpecialist', array('1' => 'Yes', '2' => 'No'), array('uncheckValue' => null, 'separator' => '&nbsp; &nbsp; &nbsp;', 'class' => 'styled'), array("id" => "UserRegistrationForm_IsSpecialist"));
                            ?>
                            <div class="control-group controlerror marginbottom20 " >
                                <?php echo $form->error($UserRegistrationForm, 'IsSpecialist'); ?>
                            </div>
                        </div>
                    </div>


                </div>
       </div>
       <div id="npiMainDiv" style="<?php if(!isset($UserRegistrationForm->IsSpecialist) || $UserRegistrationForm->IsSpecialist==2) echo 'display:none'?>">
           <div class="row-fluid padding-bottom10">
           <div id="npinumberDiv" >
                    <div class="span6">
                   
                        
                      <div>

                            <label><?php echo Yii::t('translation', 'User_Register_NPI_Number'); ?></label>
                            <div class="control-group controlerror marginbottom10"> 
                                <?php echo $form->textField($UserRegistrationForm, 'NPINumber', array("id" => "UserSettingsForm_NPINumber", 'maxlength' => '15','class' => 'span12 textfield')); ?>

                                <?php echo $form->error($UserRegistrationForm, 'NPINumber'); ?>
                            </div>
                        </div>  
                        
   
                    

                </div>
                </div>
       </div>
        <div class="row-fluid padding-bottom10">
        <div class="span6">

                    

                    <div class="lineheight25 pull-left radiobutton ">
                        <div class="control-group controlerror marginbottom20 " >
                            <input type="checkbox" id="UserSettingsForm_haveNPINumberDiv" class="styled" <?php if(isset($UserRegistrationForm->HavingNPINumber) && $UserRegistrationForm->HavingNPINumber==0 ) echo "checked"?>/>
                        </div>
                    </div>
                      <label><?php echo Yii::t('translation', 'User_Register_Donot_Have_NPINumber'); ?></label>
                     <?php echo $form->hiddenField($UserRegistrationForm, 'HavingNPINumber',array("value" => "1")); ?>
                  
 </div>
        </div> <div class="row-fluid padding-bottom10">
          <div class="span6">
                <div id="statelicensenumber" style="<?php if($UserRegistrationForm->HavingNPINumber==1 || $UserRegistrationForm->HavingNPINumber== null) echo 'display:none'?>">

                            <label><?php echo Yii::t('translation', 'User_Register_State_License_Number'); ?></label>
                            <div class="control-group controlerror marginbottom10"> 
                                <?php echo $form->textField($UserRegistrationForm, 'StateLicenseNumber', array("id" => "UserSettingsForm_StateLicenseNumber",'maxlength' => '15', 'class' => 'span12 textfield')); ?>

                                <?php echo $form->error($UserRegistrationForm, 'StateLicenseNumber'); ?>
                            </div>
                        </div>
            </div>
   </div>
       </div>
       <div class="row-fluid" style="<?php if(!isset($UserRegistrationForm->IsSpecialist) || $UserRegistrationForm->IsSpecialist==1) echo 'display:none'?>" id="studentOrresidentDiv">
        
            <div class="span12">
                <div class="span6">

                    <label><?php echo Yii::t('subspecialty', 'User_Register_Are_You_StudentOrResident'); ?></label>

                    <div class="lineheight25 pull-left radiobutton ">
                        <div class="control-group controlerror marginbottom20 " >
                            <?php echo $form->radioButtonList($UserRegistrationForm, 'IsStudentOrResident', array('1' => 'Yes', '2' => 'No'), array('uncheckValue' => null, 'separator' => '&nbsp; &nbsp; &nbsp;', 'class' => 'styled'), array("id" => "UserRegistrationForm_IsStudentOrResident"));
                            ?>
                            <div class="control-group controlerror marginbottom20 " >
                                <?php echo $form->error($UserRegistrationForm, 'IsStudentOrResident'); ?>
                            </div>
                        </div>
                    </div>


                </div>
                 </div>
                 
      
            <div class="row-fluid" >
         <div class="span12" >
                        <div class="span6" id="studentEmailDiv" style="<?php if($UserRegistrationForm->IsStudentOrResident==2) echo 'display:none'?>">

                    <label><?php echo Yii::t('subspecialty', 'User_Register_StudentOrResidentEmail'); ?></label>

                    <div class="control-group controlerror marginbottom10" >


                        <?php echo $form->textField($UserRegistrationForm, 'StudentOrResidentEmail', array("id" => "UserRegistrationForm_StudentOrResidentEmail", 'maxlength' => '45', 'class' => 'span12 pwd', 'autocomplete' => 'off')); ?>
<!--                         <img src="images/icons/helpicon.png" onclick="openpopup()" >-->


                        <div  class="control-group controlerror marginbottom20 " ></div>
                        <?php echo $form->error($UserRegistrationForm, 'StudentOrResidentEmail'); ?>
                    </div>
                </div>
              <div class="span6" id="aboutMeDiv" style="<?php if($UserRegistrationForm->IsStudentOrResident==1) echo 'display:none'?>">

                    <label><?php echo Yii::t('subspecialty', 'User_Register_aboutMe'); ?></label>

                    <div class="control-group controlerror marginbottom10" >


                        <?php echo $form->textArea($UserRegistrationForm, 'aboutMe', array("id" => "UserRegistrationForm_aboutMe", 'maxlength' => '500', 'class' => 'span12 pwd', 'autocomplete' => 'off')); ?>
<!--                         <img src="images/icons/helpicon.png" onclick="openpopup()" >-->


                        <div  class="control-group controlerror marginbottom20 " ></div>
                        <?php echo $form->error($UserRegistrationForm, 'aboutMe'); ?>
                    </div>
                </div>
               </div>
          </div>
            </div>
                    <div class="headerbuttonpopup" style="padding-top: 10px">
                       <?php
                                            echo CHtml::ajaxSubmitButton('Update', array('user/updateusersettings'),array(
                                                    'type'=>'POST',
                                                'dataType' => 'json',
                                                'error'=>'function(error){
                                                   
                                                   }',
                                                'beforeSend' => 'function(){
                                                     scrollPleaseWait("registrationSpinLoader","userregistration-form");
                                                     $("#UserRegistrationForm_referenceUserId").val(referenceUserId);
                                                     
                                                }',
                                                'complete' => 'function(){
                                                     
                                                    }',
                                                'success' => 'function(data,status,xhr) {  registercallback(data);}'),
                                                    array('type' => 'submit','id' => 'userregistration','class'=>'btn btn-2 btn-2a pull-right')
                                                    );
                                        ?>
                                   </div>

                                
      </div>
    <?php $this->endWidget(); ?>
</div>
</div>
</div>
</div>
<div class="accordion-group customaccordion-group">
<div class="accordion-heading customaccordion-heading">
<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
<?php echo Yii::t('translation','User_ChangePassword'); ?>
</a>
</div>
<div id="collapseTwo" class="accordion-body collapse">
<div class="accordion-inner customaccordion-inner">
    <div class="custaccrodianouterdiv">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'changepassword-form',
    'method' => 'post',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'marginzero'),
        ));
?>
                  
         <div id="changepassSpinLoader"></div>
                      <div class="alert-error" id="passerrmsg" style='padding-top: 5px;text-align:center;display:none;'> 
                        
                      </div>
                       <div class="alert-success" id="passsucmsg" style='padding-top: 5px;text-align:center;display:none;'></div>
<div class="regdiv reim_regdiv"> 
        <div class="row-fluid">
         <div class="span6">

            <label><?php echo Yii::t('translation', 'User_Current_Password'); ?></label>

            <div class="control-group controlerror marginbottom10" >


                <?php echo $form->passwordField($ChangePasswordForm, 'password', array("id" => "UserRegistrationForm_password", 'maxlength' => '30', 'class' => 'span12 pwd', 'autocomplete' => 'off')); ?>
<!--                         <img src="images/icons/helpicon.png" onclick="openpopup()" >-->


                <div id="pwderror" class="errorMessage" style="display:none" ></div>
                <?php echo $form->error($ChangePasswordForm, 'password'); ?>
            </div>
        </div>
            </div>
            <div class="row-fluid">
        <div class="span6">

            <label><?php echo Yii::t('translation', 'User_New_Password'); ?>
            <div class="tooltip-options pull-right"  style="margin-bottom:3px">
    <i data-toggle="tooltip" title="<div class=repwddiv> Your password must adhere to the following rules: <ol ><li type=numbers> It cannot contain your first name.</li><li> It cannot contain your email address.</li><li>  It cannot contain the domain name of this network.</li><li>  It has to contain at least one special character, one lowercase letter, one numeric and one capital letter.</li><li>  It has to be at least 8 characters long.</li></ol></div>"   data-placement="left" class="fa fa-question  helpicon helprelative tooltiplink" data-id=""></i>

</div>
            </label>

            <div class="control-group controlerror marginbottom10" >


                <?php echo $form->passwordField($ChangePasswordForm, 'newPassword', array("id" => "UserRegistrationForm_New_password", 'maxlength' => '30', 'class' => 'span12 pwd', 'autocomplete' => 'off')); ?>
<!--                         <img src="images/icons/helpicon.png" onclick="openpopup()" >-->


                <div id="pwderror" class="errorMessage" style="display:none" ></div>
                <?php echo $form->error($ChangePasswordForm, 'newPassword'); ?>
            </div>
        </div>
       
        <div class="span6">

            <label><?php echo Yii::t('translation', 'User_New_Confirm_Password'); ?></label>

            <div class="control-group controlerror marginbottom10">

                <?php echo $form->passwordField($ChangePasswordForm, 'confirmNewPassword', array("id" => "UserRegistrationForm_confirmpassword", 'maxlength' => '30', 'class' => 'span12 pwd', 'autocomplete' => 'off')); ?>


                <?php echo $form->error($ChangePasswordForm, 'confirmNewPassword'); ?>
            </div>
        </div>
         
            <div class="headerbuttonpopup" style="padding-top: 10px">
                       <?php
                                            echo CHtml::ajaxSubmitButton('Change Password', array('user/changepassword'),array(
                                                    'type'=>'POST',
                                                'dataType' => 'json',
                                                'error'=>'function(error){
                                                   
                                                   }',
                                                'beforeSend' => 'function(){
                                                   scrollPleaseWait("changepassSpinLoader","changepassword-form");
                                                 
                                                }',
                                                'complete' => 'function(){
                                                     
                                                    }',
                                                'success' => 'function(data,status,xhr) {  changepasswordcallback(data);}'),
                                                    array('type' => 'submit','id' => 'ForgotPassword_id','class'=>'btn btn-2 btn-2a pull-right')
                                                    );
                                        ?>
                                   </div>
            
 
            
        </div>

        </div>         
 <?php $this->endWidget(); ?>
</div>
</div>
</div>
    
    
    
    
</div>
                    
                 <?php if(Yii::app()->params['IsMultipleSegment'] && Yii::app()->params['IsMultipleSegment']==1){ ?>   
   <div class="accordion-group customaccordion-group">
<div class="accordion-heading customaccordion-heading">
<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">

<?php echo Yii::t('translation', 'Languages'); ?>

</a>
</div>
<div id="collapseFour" class="accordion-body collapse">
<div class="accordion-inner customaccordion-inner">
    <div class="custaccrodianouterdiv">
<div id="LanguagesDiv">
      <div class="padding8top" id="LanguageChangeDiv">
        
    </div>
</div>
                    
    </div>
</div>
</div>
 </div>
                <?php } ?>
      <?php include 'customsettings.php'; ?>             
</div> 
  





<script type="text/javascript">
Custom.init();


$(document).ready(function(){
          $('#UserSettingsForm_IsSpecialist').live('click', function() { 
             $('#studentEmailDiv').closest('.row-fluid').hide();
             $('input[name="UserSettingsForm[IsStudentOrResident]"]').prop('checked', false);
            var selectedVal = "";
              var selected = $("input[type='radio'][name='UserSettingsForm[IsSpecialist]']:checked");
              if (selected.length > 0) {
                  selectedVal = selected.val();

             if (selectedVal == "1") {
                           $('#npiMainDiv').show();
                           $("#studentOrresidentDiv").hide();
                          // $('input[name="UserSettingsForm[IsStudentOrResident]"]').prop('checked', false);
                          
              } else {
                           $('#npiMainDiv').hide();
                           $("#studentOrresidentDiv").show();

               }
           }

        });
      $('#UserSettingsForm_IsStudentOrResident').live('click', function() {
            var selectedVal = "";
             $('#studentEmailDiv').closest('.row-fluid').show();
              var selected = $("input[type='radio'][name='UserSettingsForm[IsStudentOrResident]']:checked");
              if (selected.length > 0) {
                  selectedVal = selected.val();

             if (selectedVal == "1") {
                 $("#studentEmailDiv").show();
                   $("#aboutMeDiv").hide();
              } else {
                 $("#studentEmailDiv").hide();
                 $("#aboutMeDiv").show();

               }
           }

        });
        
        
      
         if("<?php echo $UserRegistrationForm->IsSpecialist ?>" == "" || "<?php echo $UserRegistrationForm->IsSpecialist ?>" == 1){
        $('input[name="UserSettingsForm[IsStudentOrResident]"]').prop('checked', false);
    }
    if("<?php echo $UserRegistrationForm->HavingNPINumber ?>" == 0 && "<?php echo $UserRegistrationForm->HavingNPINumber ?>" != ''){
         $("#UserSettingsForm_NPINumber").attr("disabled", "disabled");
          $("#UserSettingsForm_HavingNPINumber").val("0");
            $("#npinumberDiv").hide();
    }
             $('.checkbox').live('click', function() {
        if ($("#UserSettingsForm_haveNPINumberDiv").is(":checked")) {
          $("#UserSettingsForm_HavingNPINumber").val("0");
          $("#statelicensenumber").show();
         // $("#UserSettingsForm_NPINumber").val("");
        $("#UserSettingsForm_NPINumber").attr("disabled", "disabled"); 
         $("#npinumberDiv").hide();
       }else{
        $("#UserSettingsForm_HavingNPINumber").val("1");
        $("#statelicensenumber").hide();
        //$("#UserSettingsForm_StateLicenseNumber").val("");
         $("#UserSettingsForm_NPINumber").removeAttr("disabled"); 
          $("#npinumberDiv").show();
       }
        });
    ajaxRequest('/user/getLanguages', "",getLanguagesHandler,"html");
});
function getLanguagesHandler(data){
    $("#LanguageChangeDiv").html(data);
}
function changeSegment(){
    
         var data = $("#PreferenceForm-form").serialize();
       // alert("****"+data.toSource());
         ajaxRequest('/user/requestForChangeCountry', data,changeSegmentHandler ,"json")
}
$('input[type=text]').focus(function(){
   clearerrormessage(this);
});
$('input[type=password]').focus(function(){
   clearerrormessage(this);
});

 $(function () { $(".tooltip-options i").tooltip({html : true });});



function checkpassword(obj){
    var pwd=obj.value;
    var firstname= $('#UserRegistrationForm_firstName').val();
     var lastname= $('#UserRegistrationForm_lastName').val();
     var queryString = "password="+pwd+"&firstname="+firstname+"&lastname="+lastname+"&id="+obj.id;
     ajaxRequest("/site/checkpassword", queryString, passwordcheckHandler); 
}


function passwordcheckHandler(data){

    if(data.status=='success'){
       
      $("#pwderror").hide();  
    }else{

      // var lengthvalue=data.error.length;
        $("#pwderror").text(data.message); 
            $("#pwderror").show();  
 
           }
} 

function updatePassword(){

     var oldPass= $('#UserRegistrationForm_password').val();
     var newPass= $('#UserRegistrationForm_New_password').val();
     var newConPass= $('#UserRegistrationForm_confirmpassword').val();
     var queryString = "password="+oldPass+"&newPassword="+newPass+"&newConfirmPassword="+newConPass;
  
     ajaxRequest("/user/changepassword", queryString, updatePasswordHandler); 
}


function updatePasswordHandler(data){

    if(data.status=='success'){
       
      $("#pwderror").hide();  
    }else{

      // var lengthvalue=data.error.length;
        $("#pwderror").text(data.message); 
            $("#pwderror").show();  
 
           }
}

 function registercallback(data) {
     scrollPleaseWaitClose('registrationSpinLoader');
        var data = eval(data);
        if (data.status == 'success') {
            var msg = data.data;
            $("#sucmsg").html(msg);
            $("#sucmsg").css("display", "block");
            $("#errmsg").css("display", "none");

            $("#sucmsg").fadeOut(5000,function(){
            }); 
           
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
    
    function changepasswordcallback(data) {
        scrollPleaseWaitClose('changepassSpinLoader');
        var data = eval(data);
        if (data.status == 'success') {
            var msg = data.data;
            $("#passsucmsg").html(msg);
            $("#passsucmsg").css("display", "block");
            $("#passerrmsg").css("display", "none");
            $("#changepassword-form")[0].reset();
            $("#passsucmsg").fadeOut(5000,function(){

            }); 

        } else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {

                $("#passerrmsg").html(msg);
                $("#passerrmsg").css("display", "block");
                $("#passsucmsg").css("display", "none");
                $("#passerrmsg").fadeOut(5000);

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
    
    function updatesettingscallback(data) {
        scrollPleaseWaitClose('customSpinLoader');
        var data = eval(data);
        if (data.status == 'success') {
            var msg = data.data;
            $("#customsucmsg").html(msg);
            $("#customsucmsg").css("display", "block");
            $("#customerrmsg").css("display", "none");
            $("#customsucmsg").fadeOut(5000,function(){

            }); 

        } else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {

                $("#customerrmsg").html(msg);
                $("#customerrmsg").css("display", "block");
                $("#customerrmsg").css("display", "none");
                $("#customerrmsg").fadeOut(5000);

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
