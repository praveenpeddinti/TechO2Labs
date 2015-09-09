<title>
    <?php
    $commonTitle = Yii::app()->params['pageTitles']['commonTitle'];
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>

</title>
<div class="col xs-12 col-sm-6 col-md-6 form-box">
<?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'edit-ratings-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
?>
    <div class="form-top">
        <div class="form-top-left"><h1 style="color:#FFFFFF">Edit Ratings</h1></div>

    </div>
    <div class="form-bottom">
        <?php 
            echo $form->textField($editRatingsForm, 'techo2_Emp_Name', $populateData->emp_name);
        ?>
    </div>
<?php $this->endWidget(); ?>
</div>