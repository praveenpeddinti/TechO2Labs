<title>
    <?php
    $commonTitle = Yii::app()->params['pageTitles']['commonTitle'];
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>
</title>

<?php
if (isset($allStatuses) && count($allStatuses)) {
    ?>


    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['configValues']['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
                    'pageSize', $pageSize, Yii::app()->params['configValues']['pageSizeOptions'], array(
                'class' => 'change-pagesize',
                'onchange' => "$.fn.yiiGridView.update('statuses-view-id',{data:{pageSize:$(this).val()}});",
                    )
    );
    ?>
    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
    <?php Yii::app()->clientScript->registerCss('initPageSizeCSS', '.page-size-wrap{text-align: right;}'); ?>




    <?php
    $row = 1;
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'statuses-view-id',
        'dataProvider' => $allStatuses->getAllStatuses(),
        'enableSorting' => true,
        'enablePagination' => true,
        'columns' => array(
            array(
                'header' => 'S.No',
                'value' => '++$row',
            ),
            array(
                'name' => 'statusName',
                'type' => 'raw',
                'value' => 'CHtml::encode($data->statusName)'
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => 'CHtml::encode($data->status)'
            ),
        ),
    ));
    ?>

    <?php
}else{
    echo "No records are available."
?>

<?php } ?>
