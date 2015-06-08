<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'userregistration-form',
    'method' => 'post',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'marginzero'),
        ));
?>
<?php echo $form->hiddenField($this->UserRegistrationForm, 'referenceUserId'); ?> 


<div class="headerpoptitle"><?php echo Yii::t('translation', 'User_Register_Heading'); ?></div>

<div id="registrationSpinLoader"></div>
<div class="alert-error" id="errmsg" style='padding-top: 5px;text-align:center;display:none;'> 

</div>
<div class="alert-success" id="sucmsg" style='padding-top: 5px;text-align:center;display:none;'>                          </div>
<!--               <form style="margin: 0px" accept-charset="UTF-8" action="/sessions" method="post">-->

<div class="regdiv">
    <div class="scroll">
        <div class="row-fluid">
            <div class="span12">
                <div class="span4">

                    <label><?php echo Yii::t('translation', 'User_Register_Firstname'); ?></label>
                    <div class="control-group controlerror marginbottom10">
                        <?php echo $form->textField($this->UserRegistrationForm, 'firstName', array("id" => "UserRegistrationForm_firstName", 'maxlength' => '50', 'class' => 'span12 textfield')); ?>

                        <?php echo $form->error($this->UserRegistrationForm, 'firstName'); ?>

                    </div>
                </div>
                <div class="span4">

                    <label><?php echo Yii::t('translation', 'User_Register_Lastname'); ?></label>
                    <div class="control-group controlerror marginbottom10">
                        <?php echo $form->textField($this->UserRegistrationForm, 'lastName', array("id" => "UserRegistrationForm_lastName", 'maxlength' => '50', 'class' => 'span12 textfield')); ?>

                        <?php echo $form->error($this->UserRegistrationForm, 'lastName'); ?>
                    </div>
                </div>
                <div class="span4 divrelative">

                    <label><?php echo Yii::t('translation', 'User_Register_Company'); ?></label>
                    <div class="control-group controlerror marginbottom10">
                        <?php echo $form->textField($this->UserRegistrationForm, 'companyName', array("id" => "UserRegistrationForm_companyName", 'maxlength' => '50', 'class' => 'span12 textfield')); ?>
                        <?php echo $form->error($this->UserRegistrationForm, 'companyName'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">

                <div class="span6 divrelative" id="registartion_country">

                    <label><?php echo Yii::t('translation', 'User_Register_Country'); ?></label>
                    <?php
                    echo $form->dropDownList($this->UserRegistrationForm, 'country', CHtml::listData(Countries::model()->findAll(), 'Id', 'Name'), array(
                        'class' => "styled span12 textfield",
                        'empty' => "Please Select country",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('site/dynamicstates'),
                            'update' => '#UserRegistrationForm_state',
                            'data' => array('country' => 'js:this.value',),
                            'success' => 'function(data) {
                                            if (data.indexOf("<option") !=-1){
                                             $("#dynamicstates").show();
                                             $("#dynamicstatetextbox").hide();
                                              $("#dynamicstatetextbox").html("");
                                                 $("#UserRegistrationForm_state").empty();
                                                  $("#registartion_state").find("span").text("Please Select state");
                                                        $("#UserRegistrationForm_state").append(data);
                                                        $("#UserRegistrationForm_state").trigger("liszt:updated");

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
                        <?php echo $form->error($this->UserRegistrationForm, 'country'); ?>
                    </div>
                </div>
                <div class="span6 divrelative" id="registartion_state" >
                    <label><?php echo Yii::t('translation', 'User_Register_State'); ?></label>
                    <div id="dynamicstates">
                        <?php
                        echo $form->dropDownlist($this->UserRegistrationForm, 'state', array(), array(
                            'class' => "styled span12 textfield",
                            'empty' => "Please Select state",
                        ));
                        ?>     
                    </div>
                    <div id="dynamicstatetextbox" style="display:none">

                    </div>
                    <div class="control-group controlerror marginbottom10">
                        <?php echo $form->error($this->UserRegistrationForm, 'state'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="span6 divrelative">

                    <label><?php echo Yii::t('translation', 'User_Register_City'); ?></label>
                    <div class="control-group controlerror marginbottom10"  >
                        <?php echo $form->textField($this->UserRegistrationForm, 'city', array("id" => "UserRegistrationForm_city", 'maxlength' => '50', 'class' => 'span12 textfield')); ?>
                        <?php echo $form->error($this->UserRegistrationForm, 'city'); ?>
                    </div>
                </div>

                <div class="span6">

                    <label><?php echo Yii::t('translation', 'User_Register_Zip'); ?></label>
                    <div class="control-group controlerror marginbottom10"> 
                        <?php echo $form->textField($this->UserRegistrationForm, 'zip', array("id" => "UserRegistrationForm_zip", 'maxlength' => '10', 'class' => 'span12 textfield')); ?>

                        <?php echo $form->error($this->UserRegistrationForm, 'zip'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">

                <div class="span4">

                    <label><?php echo Yii::t('translation', 'User_Register_Email'); ?></label>

                    <div class="control-group controlerror marginbottom10">

                        <?php echo $form->textField($this->UserRegistrationForm, 'email', array("id" => "UserRegistrationForm_email", 'autocomplete' => 'off', 'maxlength' => '50', 'data-original-title' => 'This will be your Username to access the network', 'rel' => 'tooltip', 'data-placement' => 'bottom', 'lass' => 'tooltiplink', 'class' => 'tooltiplink span12 textfield')); ?>


                        <?php echo $form->error($this->UserRegistrationForm, 'email'); ?>
                    </div>
                </div>
                <div class="span4">

                    <label><?php echo Yii::t('translation', 'User_Register_Password'); ?></label>

                    <div class="control-group controlerror marginbottom10" >


                        <?php echo $form->passwordField($this->UserRegistrationForm, 'pass', array("id" => "UserRegistrationForm_pass", 'maxlength' => '30', 'class' => 'span12 pwd', 'autocomplete' => 'off')); ?>
<!--                         <img src="images/icons/helpicon.png" onclick="openpopup()" >-->


                        <div id="pwderror" class="errorMessage" style="display:none" ></div>
                        <?php echo $form->error($this->UserRegistrationForm, 'pass'); ?>
                    </div>
                </div>
                <div class="span4">

                    <label><?php echo Yii::t('translation', 'User_Register_ConfirmPassword'); ?></label>

                    <div class="control-group controlerror marginbottom10">

                        <?php echo $form->passwordField($this->UserRegistrationForm, 'confirmpass', array("id" => "UserRegistrationForm_confirmpass", 'maxlength' => '30', 'class' => 'span12 pwd', 'autocomplete' => 'off')); ?>


                        <?php echo $form->error($this->UserRegistrationForm, 'confirmpass'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="span6">

                    <label><?php echo Yii::t('subspecialty', 'User_Register_PharmacistSociety_Are_You_Pharmacist'); ?></label>

                    <div class="lineheight25 pull-left radiobutton ">
                        <div class="control-group controlerror marginbottom20 " >
                            <?php echo $form->radioButtonList($this->UserRegistrationForm, 'isPharmacist', array('1' => 'Yes', '0' => 'No'), array('uncheckValue' => null, 'separator' => '&nbsp; &nbsp; &nbsp;', 'class' => 'styled'), array('uncheckValue' => null, 'onchange' => 'displayPharmacist(this)'), array("id" => "UserRegistrationForm_isPharmacist"));
                            ?>
                            <div class="control-group controlerror marginbottom20 " >
                                <?php echo $form->error($this->UserRegistrationForm, 'isPharmacist'); ?>
                            </div>
                        </div>
                    </div>


                </div>
                 <?php if(!empty($this->subSpe) && sizeof($this->subSpe)>0){?>
                <div class="span6 divrelative" id="registration_primary">
                    
                    <label><?php echo Yii::t('subspecialty', 'User_Register_PharmacistSociety_What_Is_Your_Primary_Affiliation'); ?></label>
                    <div class="control-group controlerror marginbottom10"> 
                       <?php
                        echo $form->dropDownlist($this->UserRegistrationForm, 'PrimaryAffiliation',$this->subSpe , array(
                             'class'=>'styled span12 textfield'
                        ));
                        ?>
                        <?php echo $form->error($this->UserRegistrationForm, 'PrimaryAffiliation'); ?>
                    </div>


                 </div><?php }?>
            </div>

        </div>

        <div class="row-fluid" >
            <div class="span12" id="npinumberDiv">


                <div class="span6" >
                    <div id="customfields">
                        
                      <div >

                            <label><?php echo Yii::t('subspecialty', 'User_Register_PharmacistSociety_NPI_Number'); ?></label>
                            <div class="control-group controlerror marginbottom10"> 
                                <?php echo $form->textField($this->UserRegistrationForm, 'NPINumber', array("id" => "UserRegistrationForm_NPINumber", 'maxlength' => '15','class' => 'span12 textfield')); ?>

                                <?php echo $form->error($this->UserRegistrationForm, 'NPINumber'); ?>
                            </div>
                        </div>  
                        
   
                      </div>

                </div>
               
                <div class="span6">

                    <div id="otheraffiliation" style="display:none">

                        <label><?php echo Yii::t('subspecialty', 'User_Register_PharmacistSociety_Other_Affiliation'); ?></label>
                        <div class="control-group controlerror marginbottom10"> 
                            <?php echo $form->textField($this->UserRegistrationForm, 'OtherAffiliation', array("id" => "UserRegistrationForm_OtherAffiliation", 'maxlength' => '50', 'class' => 'span12 textfield')); ?>

                            <?php echo $form->error($this->UserRegistrationForm, 'OtherAffiliation'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid" id="havingNPIDiv">
            <div class="span12">
                  <div class="span6">

                    

                    <div class="lineheight25 pull-left radiobutton ">
                        <div class="control-group controlerror marginbottom20 " >
                            <input type="checkbox" id="UserRegistrationForm_haveNPINumberDiv" class="styled"/>
                        </div>
                    </div>
                      <label><?php echo Yii::t('subspecialty', 'User_Register_PharmacistSociety_Donot_Have_NPINumber'); ?></label>
                     <?php echo $form->hiddenField($this->UserRegistrationForm, 'HavingNPINumber',array("value" => "1")); ?>
                  

                </div>
            </div></div>
            <div class="span6">
                <div id="statelicensenumber" style="display: none">

                            <label><?php echo Yii::t('subspecialty', 'User_Register_SurgeonNation_State_License_Number'); ?></label>
                            <div class="control-group controlerror marginbottom10"> 
                                <?php echo $form->textField($this->UserRegistrationForm, 'StateLicenseNumber', array("id" => "UserRegistrationForm_StateLicenseNumber",'maxlength' => '15', 'class' => 'span12 textfield')); ?>

                                <?php echo $form->error($this->UserRegistrationForm, 'StateLicenseNumber'); ?>
                            </div>
                        </div>
            </div>
        </div>
       <div class="disclaimer">
            <?php echo Yii::t('translation', 'User_Register_Iagree'); ?> <a class="cursor" onclick="openFooterTabs('/common/termsOfServices');"><?php echo Yii::t('translation', 'User_Register_Terms'); ?></a>  <a class="cursor" onclick="openFooterTabs('/common/privacyPolicy');"><?php echo Yii::t('translation', 'User_Register_Pricy_Policy'); ?></a>    <?php echo Yii::t('translation', 'User_Register_Email_Alerts'); ?> </div>
    </div>
    <div class="headerbuttonpopup" style="padding-top: 10px"><div class="pull-left padding8top lineheight25"> 
            <div class="control-group controlerror marginbottom10"> 
                <?php echo $form->checkBox($this->UserRegistrationForm, 'termsandconditions', array('class' => 'styled')) ?>
                <?php echo Yii::t('translation', 'User_Register_IAgree_Check_Box'); ?>

                <?php echo $form->error($this->UserRegistrationForm, 'termsandconditions'); ?>
            </div> 

        </div>
        <?php
        echo CHtml::ajaxSubmitButton('Register', array('site/register'), array(
            'type' => 'POST',
            'dataType' => 'json',
            'error' => 'function(error){
                                                   
                                                   }',
            'beforeSend' => 'function(){
                                                     scrollPleaseWait("registrationSpinLoader","userregistration-form");
                                                     $("#UserRegistrationForm_referenceUserId").val(referenceUserId);
                                                }',
            'complete' => 'function(){
                                                     
                                                    }',
            'success' => 'function(data,status,xhr) { registercallback(data,status,xhr);}'), array('type' => 'submit', 'id' => 'userregistration', 'class' => 'btn btn-2 btn-2a pull-right')
        );
        ?>
    </div>


</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">
    $(function() {
        $("#UserRegistrationForm_referenceUserId").val(referenceUserId);
       // $('#customfields').closest('.row-fluid').hide();
    });
    $('input[type=text]').focus(function() {
        clearerrormessage(this);
    });
    $('input[type=password]').focus(function() {
        clearerrormessage(this);
    });
    $(document).ready(function() {
         $('#havingNPIDiv .checkbox').live('click', function() { 
        if ($("#UserRegistrationForm_haveNPINumberDiv").is(":checked")) {
          $("#UserRegistrationForm_HavingNPINumber").val("0");
          $("#statelicensenumber").show();
          $("#UserRegistrationForm_NPINumber").val("");
          
           $("#npinumberDiv").hide();
        $("#UserRegistrationForm_NPINumber").attr("disabled", "disabled"); 
       }else{
        $("#UserRegistrationForm_HavingNPINumber").val("1");
        $("#statelicensenumber").hide();
        $("#UserRegistrationForm_StateLicenseNumber").val("");
         $("#UserRegistrationForm_NPINumber").removeAttr("disabled"); 
           $("#npinumberDiv").show();
       }
        });
        $(".scroll").jScrollPane({autoReinitialise: true, autoReinitialiseDelay: 200, stickToBottom: false, mouseWheelSpeed: 50});
//        $('#UserRegistrationForm_isPharmacist').live('click', function() {
//            $('#customfields').closest('.row-fluid').show();
//            var radios = document.getElementsByTagName('input');
//
//            for (var i = 0; i < radios.length; i++) {
//                if (radios[i].type === 'radio' && radios[i].checked) {
//                    // get value, set checked flag or do whatever you need to
//                    current_value = radios[i].value;
//                    if (current_value == "1") {
//                        $('#customfields').show();
//                        $('#statelicensenumber').show();
//                    } else {
//                        $('#customfields').show();
//                        $('#statelicensenumber').hide();
//                    }
//                }
//            }
//        });
        $('#UserRegistrationForm_PrimaryAffiliation').bind('change', function() { 
      if($('#UserRegistrationForm_PrimaryAffiliation').val() =="Other"){
      $('#customfields').show();
       document.getElementById('otheraffiliation').style.display='block';
    }else{
        
        document.getElementById('otheraffiliation').style.display='none';
    }
      
    });
    })

    function displayPrimary(obj) {

$('#customfields').closest('.row-fluid').show();
        if (obj.value == "Other") {
            $('#customfields').show();
            document.getElementById('otheraffiliation').style.display = 'block';
        } else {

            document.getElementById('otheraffiliation').style.display = 'none';
        }
    }


    function checkpass(obj) {
        var pwd = obj.value;
        var firstname = $('#UserRegistrationForm_firstName').val();
        var lastname = $('#UserRegistrationForm_lastName').val();
        var queryString = "password=" + pwd + "&firstname=" + firstname + "&lastname=" + lastname + "&id=" + obj.id;
        ajaxRequest("/site/checkpw", queryString, passcheckHandler);
    }


    function passcheckHandler(data) {

        if (data.status == 'success') {

            $("#pwderror").hide();
        } else {

            // var lengthvalue=data.error.length;
            $("#pwderror").text(data.message);
            $("#pwderror").show();

        }
    }

    function openpopup() {

        $('#PasswordPolicies').modal('show');
    }
       

</script>
