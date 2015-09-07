
<title>
    <?php
    $commonTitle = Yii::app()->params['pageTitles']['commonTitle'];
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>

</title>

<?php
echo "<br/>";
$desigArr = array();
$gnderArr = array();
$cntryArr = array();
$stateArr = array();



$first_name_arr = array('placeholder' => "Enter firstname", 'value' => isset($profileData['employee_firstname']) ? $profileData['employee_firstname'] : 'NA', 'autocomplete' => "off");
//$hidden_first_name_arr = array('value'=>isset($profileData['employee_firstname']) ? $profileData['employee_firstname'] :'NA');

$middle_name_arr = array('placeholder' => "Enter middlename", 'value' => isset($profileData['employee_middlename']) ? $profileData['employee_middlename'] : 'NA', 'autocomplete' => "off");
//$hidden_middle_name_arr = array('value'=>isset($profileData['employee_middlename']) ? $profileData['employee_middlename'] :'NA');

$last_name_arr = array('placeholder' => "Enter lastname", 'value' => isset($profileData['employee_lastname']) ? $profileData['employee_lastname'] : 'NA', 'autocomplete' => "off");
//$hidden_last_name_arr = array('value'=>isset($profileData['employee_lastname']) ? $profileData['employee_lastname'] :'NA');

//$email_address_arr = array('placeholder' => "Enter email address", 'value' => isset($profileData['employee_email']) ? $profileData['employee_email'] : 'NA', 'readonly' => 'readonly', 'autocomplete' => "off");
$email_address_arr = array('placeholder' => "Enter email address", 'value' => isset($profileData['employee_email']) ? $profileData['employee_email'] : 'NA', 'autocomplete' => "off");

//$phone_arr = array('placeholder' => "Enter mobile number", 'value' => isset($profileData['employee_phone']) ? $profileData['employee_phone'] : 'NA', 'readonly' => 'readonly', 'autocomplete' => "off");
$phone_arr = array('placeholder' => "Enter mobile number", 'value' => isset($profileData['employee_phone']) ? $profileData['employee_phone'] : 'NA', 'autocomplete' => "off");

$code_arr = array('value' => isset($profileData['employee_code']) ? $profileData['employee_code'] : 'NA', 'readonly' => 'readonly');




$address_arr = array('rows' => 3, 'cols' => 50, 'placeholder' => "Enter your address", 'value' => isset($profileData['employee_address']) ? $profileData['employee_address'] : 'NA', 'autocomplete' => "off");
//$hidden_address_arr = array('value'=>isset($profileData['employee_address']) ? $profileData['employee_address'] :'NA');
//Designations Array
if (isset($designationsList) && count($designationsList) > 0) {
    $desigArr = array('-1' => '--Select Designation--');
    foreach ($designationsList as $dl) {
        $desigArr[$dl['designation_id']] = $dl['designation_name'];
    }
}


//Gender Array
if (isset($gendersList) && count($gendersList) > 0) {
    foreach ($gendersList as $gl) {
        $gnderArr[$gl['gender_sign']] = $gl['gender_type'];
    }
}

//Country Array

if (isset($countriesList) && count($countriesList) > 0) {
    $cntryArr = array('-1' => '--Select Country--');
    foreach ($countriesList as $cl) {
        $cntryArr[$cl['country_id']] = $cl['country_name'];
    }
}

//State Array

if (isset($statesList) && count($statesList) > 0) {
    $stateArr = array('-1' => '--Select State--');
    foreach ($statesList as $sl) {
        $stateArr[$sl['state_id']] = $sl['state_name'];
    }
}
?>

<!--Display Session Flash Messages Section Start-->

<?php if (Yii::app()->user->hasFlash('updateSuccess')) { ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('updateSuccess'); ?>
    </div>

<?php } ?>

<?php if (Yii::app()->user->hasFlash('noChange')) { ?>

    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('noChange'); ?>
    </div>

<?php } ?>

<?php if (Yii::app()->user->hasFlash('Oops')) { ?>

    <div class="flash-notice">
        <?php echo Yii::app()->user->getFlash('Oops'); ?>
    </div>

<?php } ?>

<!--Display Session Flash Messages Section End-->


<div class="col xs-12 col-sm-6 col-md-6 form-box">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'edit-profile-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="form-top">
        <div class="form-top-left"><h1 style="color:#FFFFFF">Edit Profile</h1></div>

    </div>
    <div class="form-bottom">



        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <?php
                    echo $form->labelEx($editEmpProfile, 'techo2_Emp_Firstname');
                    echo $form->textField($editEmpProfile, 'techo2_Emp_Firstname', $first_name_arr);

                    echo $form->error($editEmpProfile, 'techo2_Emp_Firstname');
                    ?>

                    <input type="hidden" name="hidden_first_name" id="hidden_first_name" value="<?php echo isset($profileData['employee_firstname']) ? $profileData['employee_firstname'] : 'NA'; ?>"/>
                    <input type="hidden" name="hidden_middle_name" id="hidden_middle_name" value="<?php echo isset($profileData['employee_middlename']) ? $profileData['employee_middlename'] : 'NA'; ?>"/>
                    <input type="hidden" name="hidden_last_name" id="hidden_last_name" value="<?php echo isset($profileData['employee_lastname']) ? $profileData['employee_lastname'] : 'NA'; ?>"/>
                    <input type="hidden" name="hidden_email" id="hidden_email" value="<?php echo isset($profileData['employee_email']) ? $profileData['employee_email'] : 'NA'; ?>"/>
                    <input type="hidden" name="hidden_phone" id="hidden_phone" value="<?php echo isset($profileData['employee_phone']) ? $profileData['employee_phone'] : 'NA'; ?>"/>
                    <input type="hidden" name="hidden_address" id="hidden_address" value="<?php echo isset($profileData['employee_address']) ? $profileData['employee_address'] : 'NA'; ?>"/>
                    <input type="hidden" name="hidden_designation" id="hidden_designation" value="<?php echo isset($profileData['designation_id']) ? $profileData['designation_id'] : '-1'; ?>"/>
                    <input type="hidden" name="hidden_gender" id="hidden_gender" value="<?php echo isset($profileData['gender_type']) ? $profileData['gender_type'] : '-1'; ?>"/>
                    <input type="hidden" name="hidden_state" id="hidden_state" value="<?php echo isset($profileData['employee_state']) ? $profileData['employee_state'] : '-1'; ?>"/>
                    <input type="hidden" name="hidden_dob" id="hidden_dob" value="<?php echo isset($profileData['employee_dob']) ? $profileData['employee_dob'] : NULL; ?>"/>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($editEmpProfile, 'techo2_Emp_Middlename'); ?>
                    <?php echo $form->textField($editEmpProfile, 'techo2_Emp_Middlename', $middle_name_arr); ?>
                    <?php echo $form->error($editEmpProfile, 'techo2_Emp_Middlename'); ?>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($editEmpProfile, 'techo2_Emp_Lastname'); ?>
                    <?php echo $form->textField($editEmpProfile, 'techo2_Emp_Lastname', $last_name_arr); ?>
                    <?php echo $form->error($editEmpProfile, 'techo2_Emp_Lastname'); ?>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($editEmpProfile, 'techo2_Emp_Email'); ?>
                    <?php echo $form->textField($editEmpProfile, 'techo2_Emp_Email', $email_address_arr); ?>
                    <?php echo $form->error($editEmpProfile, 'techo2_Emp_Email'); ?>
                </div>
                <?php if (Yii::app()->user->hasFlash('invalidEmail')) { ?>

                    <div class="flash-success">
                        <?php echo Yii::app()->user->getFlash('invalidEmail'); ?>
                    </div>

                <?php } ?>


            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($editEmpProfile, 'techo2_Emp_Phone'); ?>
                    <?php echo $form->textField($editEmpProfile, 'techo2_Emp_Phone', $phone_arr); ?>
                    <?php echo $form->error($editEmpProfile, 'techo2_Emp_Phone'); ?>
                </div>
                 <?php if (Yii::app()->user->hasFlash('invalidPhone')) { ?>

                    <div class="flash-success">
                        <?php echo Yii::app()->user->getFlash('invalidPhone'); ?>
                    </div>

                <?php } ?>
            </div>

            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($editEmpProfile, 'techo2_Emp_Code'); ?>
                    <?php echo $form->textField($editEmpProfile, 'techo2_Emp_Code', $code_arr); ?>
                    <?php echo $form->error($editEmpProfile, 'techo2_Emp_Code'); ?>
                </div>
            </div>

        </div>

        <!--Designation Section Start-->
        <div class="form-group desig">
            <?php
            echo $form->labelEx($editEmpProfile, 'techo2_Emp_Designation');
            echo $form->dropDownList($editEmpProfile, 'techo2_Emp_Designation', $desigArr);
            echo $form->error($editEmpProfile, 'techo2_Emp_Designation');
            ?>


        </div>
        <!--Designation Section End-->


        <!--Gender Section Start-->
        <?php
        echo $form->labelEx($editEmpProfile, 'techo2_Emp_Gender');
        echo "<br/>";
        echo $form->radioButtonList($editEmpProfile, 'techo2_Emp_Gender', $gnderArr);
        echo $form->error($editEmpProfile, 'techo2_Emp_Gender');
        ?>
        <!--Gender Section End-->


        <!--Country Section Start-->
        <div class="form-group desig">

            <?php
            echo $form->labelEx($editEmpProfile, 'techo2_Emp_Country');
            echo $form->dropDownList($editEmpProfile, 'techo2_Emp_Country', $cntryArr, array(
                'ajax' => array(
                    'type' => 'POST',
                    'url' => Yii::app()->createUrl('Techo2Employee/GetStateList'),
                    'success' => 'function(data){ $("#EditEmployeeProfileForm_techo2_Emp_State").html(data)}',
                    'update' => '#EditEmployeeProfileForm_techo2_Emp_State',
                    'beforeSend' => 'function(){}',
                    'data' => array('techo2_Emp_Country' => 'js:this.value'),
                ))
            );
            echo $form->error($editEmpProfile, 'techo2_Emp_Country');
            ?>

        </div>
        <!--Country Section End-->

        <!--State Section Start-->
        <div class="form-group desig">

            <?php
            echo $form->labelEx($editEmpProfile, 'techo2_Emp_State');
            echo $form->dropDownList($editEmpProfile, 'techo2_Emp_State', $stateArr);
            echo $form->error($editEmpProfile, 'techo2_Emp_State');
            ?>

        </div>
        <!--State Section End-->

        <div class="row">
            <div class="col xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <?php
//M -> It is for Sep, Aug
//m -> It is for month number feb-2, Jan - 1
//MM -> It is for September, August
//dd-mm-yy or yy-mm-dd
                    echo $form->labelEx($editEmpProfile, 'techo2_Emp_Dob');
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $editEmpProfile,
                        'attribute' => 'techo2_Emp_Dob',
                        'options' => array(
                            'dateFormat' => 'dd/M/yy',
                            'showAnim' => 'fold',
                            'debug' => true,
                            'datepickerOptions' => array('changeMonth' => true, 'changeYear' => true),
                        ),
                        'htmlOptions' => array('readonly' => true, 'style' => 'height:40px;'),
                    ));
                    echo $form->error($editEmpProfile, 'techo2_Emp_Dob');
                    ?>
                </div>
            </div>
        </div>


        <div class="form-group add">
            <?php
            echo $form->labelEx($editEmpProfile, 'techo2_Emp_Address');
            echo $form->textArea($editEmpProfile, "techo2_Emp_Address", $address_arr);
            echo $form->error($editEmpProfile, 'techo2_Emp_Address');
            ?>
        </div>


        <div class="form-group">

            <?php echo CHtml::submitButton('Update'); ?>
        </div>


    </div>
    <?php $this->endWidget(); ?>
</div>





