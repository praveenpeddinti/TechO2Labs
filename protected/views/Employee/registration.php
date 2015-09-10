
<?php
$desigArr = array();
$cntryArr = array();
$gnderArr = array();
$first_name_arr = array('placeholder' => "Enter firstname", 'class' => 'form-control','autocomplete' => "off");
$middle_name_arr = array('placeholder' => "Enter middlename", 'class' => 'form-control','autocomplete' => "off");
$last_name_arr = array('placeholder' => "Enter lastname",'class' => 'form-control', 'autocomplete' => "off");
$email_address_arr = array('placeholder' => "Enter email address",'class' => 'form-control', 'autocomplete' => "off");
$phone_arr = array('placeholder' => "Enter mobile number", 'class' => 'form-control','autocomplete' => "off");
$reg_password_arr = array('placeholder' => "Enter password",'class' => 'form-control', 'autocomplete' => "off");
$reg_confirm_password_arr = array('placeholder' => "Confirm password",'class' => 'form-control', 'autocomplete' => "off");
$address_arr = array('rows' => 3, 'cols' => 50, 'placeholder' => "Enter your address",'class' => 'form-control', 'autocomplete' => "off");

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


<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
            <div class="modal-header" style="background-color: #f0ad4e;">
			<button type="button" class="close" data-dismiss="modal">
                         <span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h3 class="modal-title" style="color: #fff" id="lineModalLabel">Please Register</h3>
		</div>
		<div class="modal-body">
                    
                    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>			
        <!-- content goes here -->
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
        <div class="col-xs-6">
        <div class="form-group desig">
            <?php
            echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Designation');
            echo $form->dropDownList($employeeRegModelForm, 'techo2_Emp_Designation', $desigArr);
            echo $form->error($employeeRegModelForm, 'techo2_Emp_Designation');
            ?>
        </div>


        </div>
        
        <div class="col-xs-6">
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
        </div>
        
        
          <div class="form-group desig">

            <?php
            echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_State');
            echo $form->dropDownList($employeeRegModelForm, 'techo2_Emp_State',array(),array('prompt'=>'--Select--'));
            echo $form->error($employeeRegModelForm, 'techo2_Emp_State');
            ?>

        </div>
        
        <?php
        echo $form->labelEx($employeeRegModelForm, 'techo2_Emp_Gender');
        echo "<br/>";
        echo $form->radioButtonList($employeeRegModelForm, 'techo2_Emp_Gender', $gnderArr);
        echo $form->error($employeeRegModelForm, 'techo2_Emp_Gender');
        ?>
        
        <div class="row">
            <div class="col xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <?php

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
            
            
            
        </div>
            
              
              

		</div>
		<div class="modal-footer">
			<div class="btn-group btn-group-justified" role="group" aria-label="group button">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
				</div>
				<div class="btn-group btn-delete hidden" role="group">
					<button type="button" id="delImage" class="btn btn-default btn-hover-red" data-dismiss="modal"  role="button">Delete</button>
				</div>
				<div class="btn-group" role="group">
                                            <?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-default btn-hover-green','data-action'=>'save','id' => 'saveImage','role'=>'button','data-action'=>'save')); ?>
					
				</div>
			</div>
		</div>
            
            <?php $this->endWidget(); ?>
	</div>
  </div>
</div>









