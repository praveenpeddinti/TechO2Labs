<title>
    <?php
    $commonTitle = Yii::app()->params['pageTitles']['commonTitle'];
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>
</title>

<?php
$pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['configValues']['defaultPageSize']);

$pageSizeDropDown = CHtml::dropDownList(
                'pageSize', $pageSize, Yii::app()->params['configValues']['pageSizeOptions'], array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('grid-view-id',{data:{pageSize:$(this).val()}});",
                )
);
?>
<div class="page-size-wrap">
    <span>Display by:</span><?php echo $pageSizeDropDown; ?>
</div>
<?php Yii::app()->clientScript->registerCss('initPageSizeCSS', '.page-size-wrap{text-align: right;}'); ?>




    <?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'grid-view-id',
    'dataProvider' => $allProfiles->getAllProfiles(),
    'filter' => $allProfiles,
    'enableSorting' => true,
    'enablePagination' => true,
    'summaryText' => '{start} - {end} / {count}',
    'columns' => array(
        array(
            'name' => 'employee_firstname',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_firstname)'
        ),
        array(
            'name' => 'employee_middlename',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_middlename)'
        ),
        array(
            'name' => 'employee_lastname',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_lastname)'
        ),
        array(
            'name' => 'employee_gender',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_gender)'
        ),
        array(
            'name' => 'employee_dob',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_dob)'
        ),
        array(
            'name' => 'employee_tag_code',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_tag_code)'
        ),
        array(
            'name' => 'designation_name',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->designation_name)'
        ),
        array(
            'name' => 'phonenumber',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->phonenumber)'
        ),
        array(
            'name' => 'email',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->email)'
        ),
        array(
            'name' => 'employee_address',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_address)'
        ),
        array(
            'name' => 'statename',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->statename)'
        ),
        array(
            'name' => 'country_name',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->country_name)'
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->status)'
        ),
        
        
    ),
));
?>