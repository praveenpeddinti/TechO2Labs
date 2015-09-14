<?php
/*
 * Author   : Renigunta Kavya 
 * Date     : 10-09-2015  
 */
?>
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
            'onchange' => "$.fn.yiiGridView.update('rating-grid-view-id',{data:{pageSize:$(this).val()}});",
                )
);
?>

<form method="get" class="paddingtop10">
<input type="search" placeholder="Enter name to search" name="search_element" value="<?php echo isset($_GET['search_element']) ? CHtml::encode($_GET['search_element']) : '' ; ?>" />
<input type="submit" value="search" />
</form>

<div class="page-size-wrap">
    <span>Display:</span><?php echo $pageSizeDropDown; ?>
</div>
<?php Yii::app()->clientScript->registerCss('initPageSizeCSS', '.page-size-wrap{text-align: right;}'); ?>

<?php 
if(isset($_GET['search_element']) && !empty($_GET['search_element'])){
    $dataProvider = $rating_details->getAllRatingData($_GET['search_element']);
}
else{
    $dataProvider = $rating_details->getAllRatingData();
}
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'rating-grid-view-id',
    'dataProvider' => $dataProvider,
    'enableSorting' => true,
    'enablePagination' => true,
    'summaryText' => '{start} - {end} / {count}',
    'columns' => array(
        array(
            'name' => 's_no',
//            'type' => 'raw',
//            'value' => '$data->s_no',
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        array(
            'name' => 'emp_name',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->emp_name)'
        ),
        array(
            'name' => 'emp_code',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->emp_code)'
        ),
        array(
            'name' => 'email',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->email), "mailto:".CHtml::encode($data->email))',
        ),
        /* Rating Section Start */
        array(
            'header' => 'Images',
            'class' => 'CButtonColumn',
            'template' => '{view_images}',
            'buttons' => array(
                'view_images' => array(
                    'label' => 'View Images',
                    'url'=>'Yii::app()->createUrl("Techo2Employee/viewImagesRatings", array("employee_id"=>$data->s_no))',
                    'options' => array(
                        'ajax' => array(
                            'type' => 'post', 
                            'url'=>'js:$(this).attr("href")',
                            'success'=> 'function(data){
                                openModal( "myModal", "Rated images", data);
                            }',
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
            'name' => 'contact',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->contact)'
        ),
        /* View/Edit Section Start */
        array(
            'header' => Yii::t('WidgetLabels', 'admin_actions'),
            'class' => 'CButtonColumn',
            'template' => '{view_employee}{edit_employee}',
            'buttons' => array(
                'view_employee' => array(
                    'label' => 'View ',
                    'url' => 'Yii::app()->createUrl("Techo2Employee/viewRating", array("employee_id"=>$data->s_no))',
                    'options' => array(
                        'ajax' => array(
                            'type' => 'post',
                            'url' => 'js:$(this).attr("href")',
                            'success'=> 'function(data){
                                openModal( "myModal", "Employee details", data);
                            }',
                        ),
                    )
                ),
                'edit_employee' => array(
                    'label' => ' Edit',
                    'url'=>'Yii::app()->createUrl("Techo2Employee/viewImagesRatings", array("employee_id"=>$data->s_no,"edit_rating"=>1))',
                    'options' => array(
                        'ajax' => array(
                            'type' => 'post', 
                            'url'=>'js:$(this).attr("href")',
                            'success'=> 'function(data){
                                openModal( "myModal", "Edit Rated images", data);
                            }',
                        ),
                    )
                ),
            ),
            "htmlOptions" => array(
                'style' => 'width: 70px;',
                'class' => 'action_class'
            )
        ),
    /* View/Edit Section End */
    ),
));
?>