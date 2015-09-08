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
  
  echo "<br/>";
  if(isset($employee_id) && 1 == $employee_id && isset($all_employee_profiles) && count($all_employee_profiles) > 0){
     $this->widget('application.components.AllEmployeeProfiles', array('all_employee_profiles' => $all_employee_profiles));      
  }
  
?>

