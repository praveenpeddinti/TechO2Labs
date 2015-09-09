
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
<?php 


Yii::app()->clientScript->registerCss('initPageSizeCSS', '.page-size-wrap{text-align: right;}'); 

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'all_profiles_grid',
    'dataProvider' => $all_emp_profiles_arr,
    'summaryText' => '{start} - {end} / {count}',
    'columns' => array(
        array(
            'name' => Yii::t('WidgetLables', 'firstname'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["firstname"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'middlename'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["middlename"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'lastname'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["lastname"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'username'),
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data["username"]), "mailto:".CHtml::encode($data["username"]))',
        ),
        array(
            'name' => Yii::t('WidgetLables', 'code'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_code"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'designation'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_designation"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'dob'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_dob"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'email'),
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data["employee_email"]), "mailto:".CHtml::encode($data["employee_email"]))',
        ),
        array(
            'name' => Yii::t('WidgetLables', 'contact'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_phonenumber"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'status'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_status"] == 1 ? "Active" : ($data["employee_status"] == 0 ? "Inactive" : "None"))'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'gender'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_gender"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'country'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["country_name"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'state'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_state"])'
        ),
        array(
            'name' => Yii::t('WidgetLables', 'address'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_address"])'
        ),
        /* View Section Start */
        array(
            'class' => 'CButtonColumn',
            'template' => '{view_employee}{edit_employee}{suspend_employee}{activate_employee}',
            'buttons' => array(
                'suspend_employee' => array(
                    'label' => Yii::t('WidgetLables', 'suspend'),
                    'url'=>'Yii::app()->createUrl("Techo2Employee/SuspendEmployee", array("employee_id"=>$data["employee_id"]))',
                    "options" => array(
                         'confirm'=>'Do you want to suspend ?',
                         'ajax' => array('type' => 'post', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("my-grid")}'),

                    )
                ),
                'activate_employee' => array(
                    'label' => Yii::t('WidgetLables', 'activate'),
                    'url'=>'Yii::app()->createUrl("Techo2Employee/ActivateEmployee", array("employee_id"=>$data["employee_id"]))',
                    "options" => array(
                         'confirm'=>'Do you want to activate ?',
                         'ajax' => array('type' => 'post', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("my-grid")}'),

                    )
                ),
                
                'edit_employee' => array(
                    'label' => Yii::t('WidgetLables', 'update')
                ),
                'view_employee' => array(
                    'label' => Yii::t('WidgetLables', 'view')
                ),
                
            ),
            "htmlOptions" => array(
                'style'=>'width: 60px;',
                'class' => 'action_class'
            )

        ),
    /* View Section End */
    ),
));
?>






<div id="cru-frame"></div>




