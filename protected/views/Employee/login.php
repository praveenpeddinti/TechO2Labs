
<?php
$user_name_label = array('class' => '');
$user_name_arr = array('placeholder' => 'Enter your username', 'class' => 'form-control', 'autocomplete' => 'off');
$password_arr_label = array('class' => '');
$password_arr = array('placeholder' => 'Enter your password', 'class' => 'form-last-name form-control','autocomplete' => 'off');
?>

<!--Display Session Flash Messages Section Start-->

<?php if (Yii::app()->user->hasFlash('loginFail')) { ?>

    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('loginFail'); ?>
    </div>

<?php } ?>

<!--Display Session Flash Messages Section End-->


<div class=" col xs-12 col-sm-6 col-md-6 phone col-sm-offset-6">

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
            
            
            <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <div class="form-signin">
                <span id="reauth-email" class="reauth-email"></span>
                
                <?php //echo $form->labelEx($employeeLoginModelForm, 'techo2_Emp_Username', $user_name_label); ?>
                <?php echo $form->textField($employeeLoginModelForm, 'techo2_Emp_Username', $user_name_arr); ?>
                <?php echo $form->error($employeeLoginModelForm, 'techo2_Emp_Username'); ?>
                
                <?php //echo $form->labelEx($employeeLoginModelForm, 'techo2_Emp_Password', $password_arr_label); ?>
                <?php echo $form->passwordField($employeeLoginModelForm, 'techo2_Emp_Password', $password_arr); ?>
                <?php echo $form->error($employeeLoginModelForm, 'techo2_Emp_Password'); ?>
                
<!--                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>-->
<!--                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>-->
                <div id="remember" class="checkbox">
                   
                </div>
                <?php echo CHtml::submitButton('Sign in', array('class' => 'btn btn-lg btn-primary btn-block btn-signin')); ?>
            </div><!-- /form -->
            <a href="#" class="forgot-password" data-toggle="modal" data-target="#squarespaceModal">
                Not a Member?
            </a>
        </div><!-- /card-container -->
            
            
            


            <div class="form-group">
                <?php //echo $form->labelEx($employeeLoginModelForm, 'techo2_Emp_Username', $user_name_label); ?>
                <?php //echo $form->textField($employeeLoginModelForm, 'techo2_Emp_Username', $user_name_arr); ?>
                <?php //echo $form->error($employeeLoginModelForm, 'techo2_Emp_Username'); ?>
            </div>
        
            <div class="form-group">
                <?php //echo $form->labelEx($employeeLoginModelForm, 'techo2_Emp_Password', $password_arr_label); ?>
                <?php //echo $form->passwordField($employeeLoginModelForm, 'techo2_Emp_Password', $password_arr); ?>
                <?php //echo $form->error($employeeLoginModelForm, 'techo2_Emp_Password'); ?>
            </div>
        
            <div class="form-group">
                <?php //echo CHtml::submitButton('Sign in', array('class' => 'btn btn-lg btn-primary btn-block btn-signin')); ?>
            </div>

        
    </div>



    <?php $this->endWidget(); ?>
</div>












