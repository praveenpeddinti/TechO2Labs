
<?php
  $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'all_profiles_grid',
	'dataProvider' => $all_emp_profiles_arr,
        'summaryText' => '{start} - {end} / {count}',
	'columns' => array(
		array(
			'name' => Yii::app()->params['widgetLables']['firstname'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["firstname"])'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['middlename'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["middlename"])'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['lastname'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["lastname"])'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['username'],
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data["username"]), "mailto:".CHtml::encode($data["username"]))',
		),
		array(
			'name' => Yii::app()->params['widgetLables']['code'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["employee_code"])'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['designation'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["employee_designation"])'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['dob'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["employee_dob"])'
		),
                array(
			'name' => Yii::app()->params['widgetLables']['email'],
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data["employee_email"]), "mailto:".CHtml::encode($data["employee_email"]))',
		),
                array(
			'name' => Yii::app()->params['widgetLables']['contact'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["employee_phonenumber"])'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['status'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["employee_status"] == 1 ? "Active" : ($data["employee_status"] == 0 ? "Inactive" : "None"))'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['gender'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["employee_gender"])'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['country'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["country_name"])'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['state'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["employee_state"])'
		),
		array(
			'name' => Yii::app()->params['widgetLables']['address'],
			'type' => 'raw',
			'value' => 'CHtml::encode($data["employee_address"])'
		),
	),
));

?>


