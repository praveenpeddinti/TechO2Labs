<title>
    <?php
    $commonTitle = Yii::app()->params['pageTitles']['commonTitle'];
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>

</title>

<?php
//Status
$status_arr = array('placeholder' => 'Enter status name','autocomplete'=>'off');

?>

<!--Display Session Flash Messages Section Start-->

<?php if (Yii::app()->user->hasFlash('statusSuccess')) { ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('statusSuccess'); ?>
    </div>

<?php } ?>

<?php if (Yii::app()->user->hasFlash('statusFail')) { ?>

    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('statusFail'); ?>
    </div>

<?php } ?>

<!--Display Session Flash Messages Section End-->

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'create-status-form',
        'enableClientValidation' => TRUE,
        'clientOptions' => array(
            'validateOnSubmit' => TRUE,
        ),
    ));
    ?>		
    <div class="row">
        <?php echo $form->labelEx($validateStatusCreation, 'status_name'); ?>
        <?php echo $form->textField($validateStatusCreation, 'status_name',$status_arr); ?>
        <?php echo $form->error($validateStatusCreation, 'status_name'); ?>
    </div>
    
    <!--Button Section Start-->
    <div class="row buttons">

        <?php
            echo CHtml::submitButton('Submit');
            echo "&emsp;";
            echo CHtml::resetButton('Clear');
            ?>

    </div>
    <!--Button Section End-->

    <?php $this->endWidget(); ?>

</div>

