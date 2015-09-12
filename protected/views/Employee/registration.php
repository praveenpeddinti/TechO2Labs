


<?php
$desigArr = array();
$cntryArr = array();
$gnderArr = array();
$first_name_arr = array('placeholder' => "Enter firstname", 'autocomplete' => "off");
$middle_name_arr = array('placeholder' => "Enter middlename", 'autocomplete' => "off");
$last_name_arr = array('placeholder' => "Enter lastname", 'autocomplete' => "off");
$email_address_arr = array('placeholder' => "Enter email address", 'autocomplete' => "off");
$phone_arr = array('placeholder' => "Enter mobile number", 'autocomplete' => "off");
$reg_password_arr = array('placeholder' => "Enter password", 'autocomplete' => "off");
$reg_confirm_password_arr = array('placeholder' => "Confirm password", 'autocomplete' => "off");
$address_arr = array('rows' => 3, 'cols' => 50, 'placeholder' => "Enter your address", 'autocomplete' => "off");

//Designations Array

if (isset($designationsList) && count($designationsList) > 0) {
    $desigArr = array('-1' => '--Select Designation--');
    foreach ($designationsList as $dl) {
        $desigArr[$dl['designation_id']] = $dl['designation_name'];
    }
}

//Country Array

if (isset($countriesList) && count($countriesList) > 0) {
    $cntryArr = array('-1' => '--Select Country--');
    foreach ($countriesList as $cl) {
        $cntryArr[$cl['country_id']] = $cl['country_name'];
    }
}

//Gender Array
if (isset($gendersList) && count($gendersList) > 0) {
    foreach ($gendersList as $gl) {
        $gnderArr[$gl['gender_sign']] = $gl['gender_type'];
    }
}
?>

<!--Display Session Flash Messages Section Start-->

<?php if (Yii::app()->user->hasFlash('registrationSuccess')) { ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('registrationSuccess'); ?>
    </div>

<?php } ?>

<?php if (Yii::app()->user->hasFlash('registrationFail')) { ?>

    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('registrationFail'); ?>
    </div>

<?php } ?>

<?php if (Yii::app()->user->hasFlash('registrationOops')) { ?>

    <div class="flash-notice">
        <?php echo Yii::app()->user->getFlash('registrationOops'); ?>
    </div>

<?php } ?>

<!--Display Session Flash Messages Section End-->


<div class="col xs-12 col-sm-6 col-md-6 form-box">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="form-top">
        <div class="form-top-left"><h1 style="color:#FFFFFF">New Registration</h1></div>

    </div>
    <div class="form-bottom">



        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Firstname'); ?>
                    <?php echo $form->textField($employeeRegModelForm, 'techo2_Emp_Firstname', $first_name_arr); ?>
                    <?php echo $form->error($employeeRegModelForm, 'techo2_Emp_Firstname'); ?>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Middlename'); ?>
                    <?php echo $form->textField($employeeRegModelForm, 'techo2_Emp_Middlename', $middle_name_arr); ?>
                    <?php echo $form->error($employeeRegModelForm, 'techo2_Emp_Middlename'); ?>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Lastname'); ?>
                    <?php echo $form->textField($employeeRegModelForm, 'techo2_Emp_Lastname', $last_name_arr); ?>
                    <?php echo $form->error($employeeRegModelForm, 'techo2_Emp_Lastname'); ?>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Email'); ?>
                    <?php echo $form->textField($employeeRegModelForm, 'techo2_Emp_Email', $email_address_arr); ?>
                    <?php echo $form->error($employeeRegModelForm, 'techo2_Emp_Email'); ?>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Phone'); ?>
                    <?php echo $form->textField($employeeRegModelForm, 'techo2_Emp_Phone', $phone_arr); ?>
                    <?php echo $form->error($employeeRegModelForm, 'techo2_Emp_Phone'); ?>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Password'); ?>
                    <?php echo $form->passwordField($employeeRegModelForm, 'techo2_Emp_Password', $reg_password_arr); ?>
                    <?php echo $form->error($employeeRegModelForm, 'techo2_Emp_Password'); ?>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <?php echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_ConfirmPassword'); ?>
                    <?php echo $form->passwordField($employeeRegModelForm, 'techo2_Emp_ConfirmPassword', $reg_confirm_password_arr); ?>
                    <?php echo $form->error($employeeRegModelForm, 'techo2_Emp_ConfirmPassword'); ?>
                </div>

            </div>
        </div>


        <!--Designation Section Start-->
        <div class="form-group desig">
            <?php
            echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Designation');
            echo $form->dropDownList($employeeRegModelForm, 'techo2_Emp_Designation', $desigArr);
            echo $form->error($employeeRegModelForm, 'techo2_Emp_Designation');
            ?>


        </div>
        <!--Designation Section End-->

        <!--Country Section Start-->
        <div class="form-group desig">

            <?php
            echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Country');
            echo $form->dropDownList($employeeRegModelForm,'techo2_Emp_Country', $cntryArr,
                    array(
               'ajax' => array(
                    'type' => 'POST',
                    'url' => Yii::app()->createUrl('Techo2Employee/GetStateList'), 
                    'success' => 'function(data){ $("#EmployeeRegModelForm_techo2_Emp_State").html(data)}',
                    'update' => '#EmployeeRegModelForm_techo2_Emp_State',
                    'beforeSend' => 'function(){}',
                    'data' => array('techo2_Emp_Country' => 'js:this.value'),
            ))
            );
            echo $form->error($employeeRegModelForm, 'techo2_Emp_Country');
            ?>

        </div>
        <!--Country Section End-->

        <!--State Section Start-->
        <div class="form-group desig">

            <?php
            echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_State');
            echo $form->dropDownList($employeeRegModelForm, 'techo2_Emp_State',array(),array('prompt'=>'--Select--'));
            echo $form->error($employeeRegModelForm, 'techo2_Emp_State');
            ?>

        </div>
        <!--State Section End-->

        <!--Gender Section Start-->
        <?php
        echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Gender');
        echo "<br/>";
        echo $form->radioButtonList($employeeRegModelForm, 'techo2_Emp_Gender', $gnderArr);
        echo $form->error($employeeRegModelForm, 'techo2_Emp_Gender');
        ?>
        <!--Gender Section End-->

        <div class="row">
            <div class="col xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <?php
                    //M -> It is for Sep, Aug
                    //m -> It is for month number feb-2, Jan - 1
                    //MM -> It is for September, August
                    //dd-mm-yy or yy-mm-dd
                    echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Dob');
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $employeeRegModelForm,
                        'attribute' => 'techo2_Emp_Dob',
                        'options' => array(
                            'dateFormat' => 'dd/M/yy',
                            'showAnim' => 'fold',
                            'debug' => true,
                            'datepickerOptions' => array('changeMonth' => true, 'changeYear' => true),
                        ),
                        'htmlOptions' => array('readonly' => true,'style' => 'height:40px;'),
                    ));
                    echo $form->error($employeeRegModelForm, 'techo2_Emp_Dob');
                    ?>
                </div>
            </div>
        </div>



        <div class="form-group add">
            <?php
            echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Address');
            echo $form->textArea($employeeRegModelForm, "techo2_Emp_Address", $address_arr);
            echo $form->error($employeeRegModelForm, 'techo2_Emp_Address');
            ?>
        </div>


        <div class="form-group">
            <label>
                <?php
                echo $form->checkBox($employeeRegModelForm, 'techo2_Terms_Conditions') . '&nbsp;';
                echo $form->label($employeeRegModelForm, 'techo2_Terms_Conditions');
                echo $form->error($employeeRegModelForm, 'techo2_Terms_Conditions');
                ?>

            </label>
            <?php echo CHtml::submitButton('Submit'); ?>
        </div>


    </div>
    <?php $this->endWidget(); ?>
</div>




