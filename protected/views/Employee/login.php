<?php
$user_name_label = array('class' => '');
$user_name_arr = array('placeholder' => 'Enter your username', 'class' => 'form-last-name form-control', 'autocomplete' => 'off');

$password_arr_label = array('class' => '');
$password_arr = array('placeholder' => 'Enter your password', 'autocomplete' => 'off');
?>

<!--Display Session Flash Messages Section Start-->

<?php if (Yii::app()->user->hasFlash('loginFail')) { ?>

    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('loginFail'); ?>
    </div>

<?php } ?>

<!--Display Session Flash Messages Section End-->


<div class=" col xs-12 col-sm-6 col-md-6 phone">

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
        <div class="form-top-left"><h1 style="color:#FFFFFF">Login</h1></div>

    </div>
    <div class="form-bottom">


        
            <div class="row"></div>



            <div class="form-group desig"></div>

            <div class="row"></div>


            <div class="form-group">
                <?php echo $form->labelEx($employeeLoginModelForm, 'techo2_Emp_Username', $user_name_label); ?>
                <?php echo $form->textField($employeeLoginModelForm, 'techo2_Emp_Username', $user_name_arr); ?>
                <?php echo $form->error($employeeLoginModelForm, 'techo2_Emp_Username'); ?>

            </div>
            <div class="form-group">
                <?php echo $form->labelEx($employeeLoginModelForm, 'techo2_Emp_Password', $password_arr_label); ?>
                <?php echo $form->passwordField($employeeLoginModelForm, 'techo2_Emp_Password', $password_arr); ?>
                <?php echo $form->error($employeeLoginModelForm, 'techo2_Emp_Password'); ?>

            </div>

            <div class="form-group">

                <?php echo CHtml::submitButton('Submit'); ?>
            </div>

        
    </div>



    <?php $this->endWidget(); ?>
</div>











