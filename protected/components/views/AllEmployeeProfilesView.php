
<?php

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
            'buttons' => array('view' =>
                array(
                    'url' => 'Yii::app()->createUrl("Techo2Employee/ViewEmployeeDetails", array("id"=>$data->ID,"asDialog"=>1))',
                    'options' => array(
                        'ajax' => array(
                            'type' => 'POST',
                            // ajax post will use 'url' specified above 
                            'url' => "js:$(this).attr('href')",
                            'update' => '#id_view',
                        ),
                    ),
                ),
            ),
        ),
    /* View Section End */
    ),
));
?>


<div id="id_view"></div>


