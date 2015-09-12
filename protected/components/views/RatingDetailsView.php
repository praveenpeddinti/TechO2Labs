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
        /* Rating Section Start */
        array(
            'header' => 'Images',
            'class' => 'CButtonColumn',
            'template' => '{view_images}',
            'buttons' => array(
                'view_images' => array(
                    'label' => 'View Images',
                    'url'=>'Yii::app()->createUrl("Techo2Employee/viewImagesRatings", array("employee_id"=>$data["employee_id"],"asDialog"=>1))',
                    'options' => array(
//                         'confirm'=>'Do you want to view ?',
                        'ajax' => array(
                            'type' => 'post', 
                            'url'=>'js:$(this).attr("href")',
                            'update'=>'#popup_images',
//                            'success' => 'js:function(data) { $.fn.yiiGridView.update("my-grid")}'
//                            'success'=> 'function(data){
//                                openModal( "myModal", "Rated images", data);
//                            }',
                        ),
                    )
                ),
            ),
            "htmlOptions" => array(
                'style'=>'width: 80px;',
                'class' => 'action_class'
            )
        ),
        /* Rating Section End */
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
//                            'success'=> 'function(data){
//                                openModal( "myModal", "Employee details", data);
//                            }',
                        ),
                    )
                ),
                
                'edit_employee' => array(
                    'label' => ' Edit',
//                    'url'=>'Yii::app()->createUrl("Techo2Employee/EditRating", array("employee_id"=>$data["employee_id"]))',
                    'url'=>'Yii::app()->createUrl("Techo2Employee/viewImagesRatings", array("employee_id"=>$data["employee_id"],"asDialog"=>1,"edit_rating"=>1))',
                    'options' => array(
//                         'confirm'=>'Do you want to view ?',
                        'ajax' => array(
                            'type' => 'post', 
                            'url'=>'js:$(this).attr("href")',
                            'update'=>'#popup_images',
//                            'success' => 'js:function(data) { $.fn.yiiGridView.update("my-grid")}'
//                            'success'=> 'function(data){
//                                openModal( "myModal", "Edit Rated images", data);
//                            }',
                        ),
                    )
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
    'id' => 'dlg-rating-view',
    'options' => array(
        'title' => 'Rating details',
        'autoOpen' => false, //important!
        'resizable' => true,
        'modal' => false,
//    'width'=>550,
//    'height'=>470,
        'show' => array(
            'effect' => 'blind',
            'duration' => 1000,
        ),
        'hide' => array(
            'effect' => 'explode',
            'duration' => 500,
        ),
    ),
));
?>
<div id="popup_view"></div></br></br></br>
<?php 
$this->endWidget();
?>

<?php
//the dialog
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//    'id' => 'dlg-images-view',
//    'options' => array(
//        'title' => 'Images details',
//        'autoOpen' => false, //important!
//        'modal' => false,
////    'width'=>550,
////    'height'=>470,
//    ),
//));
?>
<div id="popup_images"></div>
<?php 
//$this->endWidget();
?>