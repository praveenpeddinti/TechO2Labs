<?php
$this->widget('CLinkPager', array(
    'pages' => $all_rating_images_data['pages'],
));

$this->widget('CListPager', array(
    'pages' => $all_rating_images_data['pages'],
));
?>
<?php
$defaultImageName = Yii::app()->params['configValues']['defaultImageName'];
if (isset($all_rating_images_data['all_rating_images']) && count($all_rating_images_data['all_rating_images']) > 0) {
    ?>
    <table border = "2">
        <tr>
            <th>Image</th>
            <th>Rate</th>
        </tr>

    <?php
    foreach ($all_rating_images_data['all_rating_images'] as $arid) {

        $previous_rating = 0;

        $img_name = NULL;

        $is_exist = NULL;

        $defaultImageName = Yii::app()->params['configValues']['defaultImageName'];

        $imageName = NULL;

        if (isset($arid['image_name']) && !empty($arid['image_name'])) {

            $imageName = $arid['image_name'];
        } else {

            $imageName = $defaultImageName;
        }

        $imageHeight = Yii::app()->params['configValues']['defaultImageHeight'];

        $imageWidth = Yii::app()->params['configValues']['defaultImageWidth'];

        $imageId = 0;

        $is_exist = realpath(Yii::app()->basePath . '/../uploads/' . $imageName);


        if (file_exists($is_exist)) {

            $img_name = $imageName;
        } else {

            $img_name = $defaultImageName;
        }

        $imageAdjust = array('width' => $imageWidth, 'height' => $imageHeight, 'title' => $imageName);
        /* Check is file exists or not section end */
        $imageId = isset($arid['image_id']) ? $arid['image_id'] : $imageId;
        $previous_rating = isset($previous_rating_images[$imageId]) ? $previous_rating_images[$imageId] : $previous_rating;
        ?>

            <tr>

                <td>
            <?php echo CHtml::image(Yii::app()->request->getBaseUrl() . "/uploads/" . $img_name, $img_name, $imageAdjust); ?>
                </td>
                <td>
        <?php
        $this->widget('CStarRating', array(
            'name' => 'rating[]' . $imageId,
            'value' => $previous_rating,
            'callback' => '
        function(){
                $.ajax({
                    type: "POST",
                    url: "' . Yii::app()->createUrl('Techo2Employee/StarRatingAjax') . '",
                    data: "' . Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->getCsrfToken() . '&imageId=' . $imageId . '&rate="+$(this).val(),
                    success: function(msg){
                                $("#result").html(msg);
                        }})}',
        ));
        ?>
                </td>

            </tr>








        <?php
    }
    ?>

    <?php
} else {
    ?>
        <tr>
            <td>No records are available. Please upload files.</td>
        </tr>
        <?php
    }
    ?>
</table>
    <?php
    $this->widget('CLinkPager', array(
        'pages' => $all_rating_images_data['pages'],
    ));

    $this->widget('CListPager', array(
        'pages' => $all_rating_images_data['pages'],
    ));
    ?>

