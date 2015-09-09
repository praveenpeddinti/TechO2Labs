<?php
/*
 * Author   : Renigunta Kavya 
 * Date     : 08-09-2015
 */
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'all_ratings_grid',
    'dataProvider' => $rating_details_arr,
    'summaryText' => '{start} - {end} / {count}',
    'columns' => array(
        array(
            'name' => Yii::t('WidgetLabels', 's_no'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_id"])'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'emp_name'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_name"])'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'emp_code'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_code"])'
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'email'),
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data["employee_email"]), "mailto:".CHtml::encode($data["employee_email"]))',
        ),
        array(
            'name' => Yii::t('WidgetLabels', 'contact'),
            'type' => 'raw',
            'value' => 'CHtml::encode($data["employee_phone"])'
        ),
        /* View/Edit Section Start */
        array(
            'header' => Yii::t('WidgetLabels', 'admin_actions'),
            'class' => 'CButtonColumn',
            'template' => '{view_employee}{edit_employee}',
            'buttons' => array(
                'view_employee' => array(
                    'label' => 'View ',
                    'url'=>'Yii::app()->createUrl("Techo2Employee/viewRating", array("employee_id"=>$data["employee_id"],"asDialog"=>1))',
                    'options' => array(
//                         'confirm'=>'Do you want to view ?',
                        'ajax' => array(
                            'type' => 'post', 
                            'url'=>'js:$(this).attr("href")',
                            'update'=>'#popup_view',
//                            'success' => 'js:function(data) { $.fn.yiiGridView.update("my-grid")}'
                        ),
                    )
                ),
                
                'edit_employee' => array(
                    'label' => ' Edit',
//                    'url'=>'Yii::app()->createUrl("Techo2Employee/EditRating", array("employee_id"=>$data["employee_id"]))',
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
'id'=>'dlg-rating-view',
'options'=>array(
    'title'=>'Rating details',
    'autoOpen'=>false, //important!
    'modal'=>false,
    'width'=>550,
    'height'=>470,
),
));
?>
<div id="popup_view"></div>
<?php $this->endWidget();?>