<?php

$this->widget('CLinkPager', array(
	'pages'=>$all_rating_images_data['pages'],
));

$this->widget('CListPager', array(
	'pages'=>$all_rating_images_data['pages'],
));

?>
<?php
  if(isset($all_rating_images_data) && count($all_rating_images_data) > 0){
     
?>
<table border = "2">
    <tr>
        <th>Image</th>
        <th>Rate</th>
    </tr>

<?php
  foreach($all_rating_images_data['all_rating_images'] as $arid){
      
          $previous_rating = 0;
          $defaultImageName = Yii::app()->params['configValues']['defaultImageName'];
          $imageHeight = Yii::app()->params['configValues']['defaultImageHeight'];
          $imageWidth = Yii::app()->params['configValues']['defaultImageWidth'];
          $imageAdjust = array('width'=>$imageWidth,'height'=>$imageHeight,'title'=>$imageName);
          $imageId = 0;
          $result_on_file = NULL;
          $image_path = Yii::app()->request->getBaseUrl() . "/uploads/";
          $imageName = isset($arid['image_name']) ? $arid['image_name'] :$defaultImageName;
          /*Check is file exists or not section start*/
          $result_on_file = file_exists($image_path.$imageName);
          if(0 == $result_on_file || FALSE == $result_on_file){
              $imageName = $defaultImageName;
          }
          /*Check is file exists or not section end*/
          $imageId = isset($arid['image_id']) ? $arid['image_id'] :$imageId;
          $previous_rating = isset($previous_rating_images[$imageId]) ? $previous_rating_images[$imageId] : $previous_rating;    
?>
    
    <tr>
        
        <td>
          <?php echo CHtml::image(Yii::app()->request->getBaseUrl() . "/uploads/".$imageName, $imageName,$imageAdjust); ?>
        </td>
        <td>
            <?php
        $this->widget('CStarRating',array(
                'name'=>'rating[]'.$imageId,
                'value' => $previous_rating,
                'callback'=>'
        function(){
                $.ajax({
                    type: "POST",
                    url: "'.Yii::app()->createUrl('Techo2Employee/StarRatingAjax').'",
                    data: "'.Yii::app()->request->csrfTokenName.'='.Yii::app()->request->getCsrfToken().'&imageId='.$imageId.'&rate="+$(this).val(),
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
    </table>
<?php
     } ?>

<?php
$this->widget('CLinkPager', array(
	'pages'=>$all_rating_images_data['pages'],
));

$this->widget('CListPager', array(
	'pages'=>$all_rating_images_data['pages'],
));

?>

