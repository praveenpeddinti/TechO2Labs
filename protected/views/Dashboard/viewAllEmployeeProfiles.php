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
    'enableSorting' => true,
    'enablePagination' => true,
    'rowCssClassExpression' => '
        ( $data->employee_status == 1 ? "active" : "Inactive" ) . ( $row%2 ? " even" : " odd" ) . " emp_".$data->employee_id',
    'summaryText' => '{start} - {end} / {count}',
    'columns' => array(
        array(
            'name' => Yii::t('WidgetLabels', 'firstname'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_firstname)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'middlename'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_middlename)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'lastname'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_lastname)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'gender'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_gender)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'dob'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_dob)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'code'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_tag_code)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'designation'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->designation_name)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'contact'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->phonenumber)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'email'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->email)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'status'),
            'type' => 'raw',
            'cssClassExpression' => '"emp_status"',
            'value' => 'CHtml::encode($data->employee_status == 1 ? "Active" : ($data->employee_status == 0 ? "Inactive" : "None"))'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'address'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->employee_address)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'state'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->statename)'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'country'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data->country_name)'
        ),
    /* View Section End */
        array(
            'header' => Yii::t('WidgetLabels', 'admin_actions'),
            'class' => 'CButtonColumn',
            'template' => '{view_employee}{edit_employee}{status_employee}',
            'buttons' => array(
             'view_employee' => array(
                    'label' => 'View',
                    'url'=>'Yii::app()->createUrl("Techo2Employee/ViewEmployeeDetails", array("employee_id"=>$data["employee_id"],"asDialog"=>1))',
                    'options' => array(                    
                        'ajax' => array(
                            'type' => 'POST', 
                            'url'=>'js:$(this).attr("href")',
                            'update'=>'#employee_view',
//                            'success' => 'js:function(data) { $.fn.yiiGridView.update("my-grid")}'
                        ),
                    )
                ),
                'status_employee' => array(
                    'label' => 'Edit status',
                    'url'=>'Yii::app()->createUrl("Techo2Employee/AjaxStatusui",array("employee_id"=>$data["employee_id"],"status"=>$data["employee_status"]))',
                    "options" => array(
                         'ajax' => array('type' => 'post', 'url'=>'js:$(this).attr("href")','success' => 'js:function(data,xhr,ajaxOptions) {$(".emp_"+data.emp_id).find("#yt0").hide();var emp_id = getUrlParameters("employee_id", this.url, true) ;console.log();$(".emp_"+emp_id).find(".emp_status").html(data);$(this).hide();}'),
                    ),  
                ),
            ),
            "htmlOptions" => array(
                'style'=>'width: 70px;',
                'class' => 'action_class'
            )
        ),
        /* View/Edit Section End */
       
    ),
));
?>

<?php
//the dialog
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
'id'=>'dlg-employee-view',
'options'=>array(
    'title'=>'Employee details',
    'autoOpen'=>false, //important!
    'modal'=>false,
    'width'=>550,
    'height'=>470,
),
));
?>
<div id="employee_view"></div>
<?php $this->endWidget();?>