<title>
    <?php
    $commonTitle = Yii::app()->params['pageTitles']['commonTitle'];
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>

</title>


<?php
  echo "<br/>";
  if(isset($logged_in_emp_data) && count($logged_in_emp_data) > 0){
     $this->widget('application.components.EmployeeProfile', array('employee_profile' => $logged_in_emp_data));    
  }
  
 
  
  if(isset($designation_id) && 1 != $designation_id){
      
     $this->widget('application.components.RateYourScoreOnImage', array('employee_id' => $employee_id));      
  }
  
?>

