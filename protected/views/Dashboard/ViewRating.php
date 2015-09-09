<?php 
if(isset($rating_data) && count($rating_data)>0){ ?>
<div id="popup_view">
    <div>  Name : <?php echo $rating_data["employee_name"]?></div>
    <div>  Code : <?php echo $rating_data["employee_code"]?></div>
    <div>  Email Id : <?php echo $rating_data["employee_email"]?></div>
    <div>  Mobile Number  : <?php echo $rating_data["employee_phone"]?></div>
</div>
<?php } ?>