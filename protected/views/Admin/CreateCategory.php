<title>
    <?php
    $commonTitle = Yii::app()->params['pageTitles']['commonTitle'];
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>

</title>

<?php
//Category 
$category_arr = array('placeholder' => 'Enter category name','autocomplete'=>'off');
//All Active Status List
$status_list_arr = array();
if (isset($status_list) && count($status_list) > 0) {
    $status_list_arr = array('-1' => '--Select Status--');
    foreach ($status_list as $sl) {
        $status_list_arr[$sl['status_id']] = $sl['status_name'];
    }
}
?>

<!--Display Session Flash Messages Section Start-->

<?php if (Yii::app()->user->hasFlash('categorySuccess')) { ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('categorySuccess'); ?>
    </div>

<?php } ?>

<?php if (Yii::app()->user->hasFlash('categoryFail')) { ?>

    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('categoryFail'); ?>
    </div>

<?php } ?>

<!--Display Session Flash Messages Section End-->

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'create-category-form',
        'enableClientValidation' => TRUE,
        'clientOptions' => array(
            'validateOnSubmit' => TRUE,
        ),
    ));
    ?>		
    <div class="row">
        <?php echo $form->labelEx($categoryValidatinos, 'category_name'); ?>
        <?php echo $form->textField($categoryValidatinos, 'category_name',$category_arr); ?>
        <?php echo $form->error($categoryValidatinos, 'category_name'); ?>
    </div>

    <div class="row">
        <?php
        echo $form->labelEx($categoryValidatinos, 'category_status');
        echo $form->dropDownList($categoryValidatinos, 'category_status', $status_list_arr);
        echo $form->error($categoryValidatinos, 'category_status');
        ?>
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

