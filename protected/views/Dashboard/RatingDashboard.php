<?php
/*
 * Author   : Renigunta Kavya 
 * Date     : 08-09-2015
 */
?>
<title>
    <?php
    $commonTitle = Yii::t('PageTitles', 'commonTitle');
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>

</title>
<?php
  if(isset($employee_id) && 1 == $employee_id && isset($rating_details) && count($rating_details) > 0){
    $this->widget('application.components.RatingDetails', array('rating_details' => $rating_details));      
  }
  
?>