<div id="enrollmentFormDiv">
    <div class="alert alert-error" id="errmsg" style='display: none'></div>
    <div class="alert alert-success" id="sucmsg" style='text-align:center;display:none;'></div>
        <div class="form-inline"  >
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'testtaker-form',
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
            <input type="hidden" id="editUserId" value="<?php echo $data['UserId'];?>"/>
                <div id="reg_error" class="alert-error"></div> 
            <div class="form-group loginform" >
            <div class="row-fluid">
                <div class="span12">
                    <div class="span6">
                          <label class="usernamelbl" for="userName" >First Name</label>
                    <?php echo $form->textField($takerForm, 'FirstName', array('id' => 'TestTakerForm_FirstName', 'readonly'=>true, 'value'=>$data['FirstName'], 'maxlength' => 50, 'class' => 'span12')); ?>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($takerForm, 'FirstName'); ?>
                    </div>
                    </div>
                    <div class="span6">
                        <label class="usernamelbl" for="userName" >Last Name</label>
                    <?php echo $form->textField($takerForm, 'LastName', array('id' => 'TestTakerForm_LastName', 'readonly'=>true, 'value'=>$data['LastName'], 'maxlength' => 50, 'class' => 'span12')); ?>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($takerForm, 'LastName'); ?>
                    </div>
                    </div>
                </div>
                </div>
                 </div>
            
            <div class="form-group loginform" >
                  <div class="row-fluid">
                    <div class="span12">
                    <div class="span12">
                        <label class="usernamelbl" for="userName" >Email</label>
                    <?php echo $form->textField($takerForm, 'Email', array('id' => 'TestTakerForm_Email', 'value'=>$data['Email'], 'maxlength' => 50, 'class' => 'span12')); ?>
                    <div class="control-group controlerror">  
                        <?php echo $form->error($takerForm, 'Email'); ?>
                    </div>
                    </div>
                   
                </div>
                  </div>
                  </div>
                 <div class="form-group loginform" >
                     <div class="row-fluid">
                    <div class="span12">
                    <div class="span6">
                        <label class="usernamelbl" for="userName" >Phone</label>
                    <?php echo $form->textField($takerForm, 'Phone', array('id' => 'TestTakerForm_Phone', 'value'=>$data['Phone'], 'maxlength' => 10, 'class' => 'span12','onkeypress' => "return isNumberKey(event)")); ?>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($takerForm, 'Phone'); ?>
                    </div>
                    </div>
                    <div class="span6">
                        <label class="usernamelbl" for="userName" >Qualification</label>
                        <?php echo $form->dropdownlist($takerForm, 'Qualification', array('' => 'Select', 'MCA' => 'MCA', 'MBA' => 'MBA', 'B.Tech' => 'B.Tech', 'MS' => 'MS'),array('options' => '','readonly'=>'true', 'options' => array($data['Qualification']=> array('selected' => 'selected'))), array('id' => 'TestTakerForm_Qualification')); ?>
                        <div class="control-group controlerror"> 
                            <?php echo $form->error($takerForm, 'Qualification'); ?>
                        </div>
                    </div>
                </div>
                </div>                   
                </div>
        <div  class="row-fluid">
            <div class="span12" style="padding:5px;text-align:right">
                <?php echo CHtml::Button('Update', array('onclick' => 'editUserForm()', 'class' => 'btn btn-warning','id'=>'editButtonId')); ?> 
                
            </div>	
        </div>
            <?php $this->endWidget(); ?> 
            </div>
    </div>
<script type="text/javascript">
    Custom.init();
function editUserForm(){
        $("#editButtonId").val("Please wait...");
        var data=$("#testtaker-form").serialize();
        var editUserId = $("#editUserId").val();
        
        $.ajax({
            type: 'POST',
            dataType:'json',
            url: "/admin/editUserForId?eId="+editUserId,
            data:data,
            success:editFormHandler,
            error: function(data) { // if error occured
                console.log("Error occured.please try again");
            }
        });
    }
    
    function editFormHandler(data){ 
        $("#editButtonId").val("Update");
        if(data.status=='success'){
            $("#sucmsg").css("display", "block");
            $("#sucmsg").html("User details is successfully updated.").fadeOut(6000,"linear",function(){
                getUsermanagementDetails(0, '', '');
            });
        }else if(data.status=='failed'){
            $("#errmsg").css("display", "block");
            $("#errmsg").html("User already exist with these Email or Phone.").fadeOut(6000,"linear",function(){
                getUsermanagementDetails(0, '', '');
            });
        }else{
            var lengthvalue = data.error.length;            
            var error = [];
            if (typeof (data.error) == 'string') {
                var error = eval("(" + data.error.toString() + ")");
            } else {
                var error = eval(data.error);
            }
            $.each(error, function(key, val) {                
                    if ($("#" + key + "_em_")) {
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(6000);
                        $("#" + key).parent().addClass('error');
                    }
            });
        }   
    }
    </script>