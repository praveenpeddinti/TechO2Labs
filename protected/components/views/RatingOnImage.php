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
     $i = 1; 
     $j = 0;
     
?>
<table border = "2">
    <tr>
        <th>S.No</th>
        <th>Image Name</th>
        <th>Rate</th>
    </tr>

<?php
  foreach($all_rating_images_data['all_rating_images'] as $arid){
      
          $previous_rating = 0;
          $imageName = "image1.jpeg";
          $imageId = 0;
          $imageName = isset($arid['image_name']) ? $arid['image_name'] :$imageName;
          $imageId = isset($arid['image_id']) ? $arid['image_id'] :$imageId;
          $previous_rating = isset($previous_rating_images[$imageId]) ? $previous_rating_images[$imageId] : $previous_rating;    
?>
    
    <tr>
        <td><?php  echo $i; ?></td>
        <td>
          <?php echo CHtml::image(Yii::app()->request->getBaseUrl() . "/uploads/".$imageName, $imageName); ?>
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
     $i++;
     $j++;
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

