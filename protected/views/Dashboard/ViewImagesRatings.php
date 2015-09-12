<?php 
if(isset($rating_data) && count($rating_data)>0){ ?>
<div id="popup_images">
    <?php 
    $defaultImageName = Yii::app()->params['configValues']['defaultImageName'];
    ?>
    <div><?php echo $employee_name;?></div>
    <table border = "2">
        <tr>
            <th>Image</th>
            <th>Rate</th>
        </tr>
        <?php foreach($rating_data as $eachImage){
                $img_name = NULL;
                $is_exist = NULL;
                $previous_rating = 0;
                $rated_employeeid = 0; 
                $defaultImageName = Yii::app()->params['configValues']['defaultImageName'];
                if (isset($eachImage['rated_imagename']) && !empty($eachImage['rated_imagename'])) {

                    $imageName = $eachImage['rated_imagename'];
                } else {

                    $imageName = $defaultImageName;
                }

                $imageHeight = Yii::app()->params['configValues']['defaultImageHeight'];

                $imageWidth = Yii::app()->params['configValues']['defaultImageWidth'];

                $imageId = 0;

                $imageUrl = Yii::app()->baseUrl . '/uploads/'.$imageName;
                $localFilePath = Yii::getPathOfAlias('webroot').$imageUrl;

                if (file_exists($localFilePath)) {
                    $img_name = $imageName;
                } else {
                    $img_name = $defaultImageName;
                }

                $imageAdjust = array('width' => $imageWidth, 'height' => $imageHeight, 'title' => $imageName);
                /* Check is file exists or not section end */
                $imageId = isset($eachImage['rated_imageid']) ? $eachImage['rated_imageid'] : $imageId;
                $previous_rating = $eachImage['emp_rating'];
                $rated_employeeid = $eachImage['emp_id'];
        ?>
        <tr>
            <td>
                <?php echo CHtml::image(Yii::app()->request->getBaseUrl() . "/uploads/" . $img_name, $img_name, $imageAdjust); ?>
            </td>
            <td>
                <?php if(isset($isEdit) && $isEdit==1){?>
                <?php
                    $this->widget('CStarRating', array(
                                'name' => 'rating[]' . $imageId,
                                'value' => $previous_rating,
                                'callback' => '
                                    function(){
                                        $.ajax({
                                            type: "POST",
                                            url: "' . Yii::app()->createUrl('Techo2Employee/StarRatingAjax') . '",
                                            data: "' . Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->getCsrfToken() . '&rated_employeeid='.$rated_employeeid.'&imageId=' . $imageId . '&rate="+$(this).val(),
                                            success: function(msg){
                                                $("#result").html(msg);
                                            }})}',
                    ));
                ?>
                <?php } else { ?>
                <?php
                    $this->widget('CStarRating', array(
                                'name' => 'rating[]' . $imageId,
                                'value' => $previous_rating,
                                'readOnly' => true,
                            ));
                ?>
                <?php }?>
                
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
<?php } else{?>
<div><?php echo $employee_name;?></div>
<div>No ratings yet</div>
<?php } ?>