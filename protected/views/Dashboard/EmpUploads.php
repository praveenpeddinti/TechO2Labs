<title>    
    <?php
    $commonTitle = Yii::app()->params['pageTitles']['commonTitle'];
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>
</title>

<?php echo CHtml::link("Add New", '', array('class' => 'class_here btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '.bs-example-modal-lg', 'onclick' => '$("#remaining").html("")')); ?>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Uploads</h4>
            </div>

            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'upload-file',
                    'enableAjaxValidation' => false,
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>
                <div>
                    <?php
                    $i = 0;
                    $i++;
                    echo CHtml::ajaxLink('Add', Yii::app()->createUrl('Techo2Employee/fileUploads?id= ' . +$i . ' '), array(
                        'type' => 'post',
                        'success' => 'function(data){$("#remaining").append(data)}',
                    ));
                    ?>

                    <?php echo CHtml::link("Remove", "#", array('id' => 'remove-item')); ?>
                </div>

                <div class="form-group">
                    <div class="row" id="file_u">
            
                <?php
                $this->widget('CMultiFileUpload', array(
                    'model' => $validations,
                    'accept' => 'jpg|gif|png',
                    'remove' => '[X]',
                    'duplicate' => 'Already Selected',
                    'denied' => 'Invalid file type',
                    'name' => 'image',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'multiple' => 'multiple'),
                ));
                ?>

                        <?php echo $form->error($validations, 'image'); ?>


                    </div>  
                    <div id="remaining" class="row"></div>
                </div>

                <div class="row buttons">
<?php echo CHtml::submitButton('Upload'); ?>
                </div>

                    <?php $this->endWidget(); ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>


        </div>

    </div>
</div>
</div>


<script type="text/javascript">
    $('a#remove-item').click(function () {
        $('#rows').last().remove();
    });
</script>


