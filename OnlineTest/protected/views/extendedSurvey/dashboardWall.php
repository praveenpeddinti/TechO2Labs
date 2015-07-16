<?php if(is_array($surveyObject)){    
    $dateFormat =  CommonUtility::getDateFormat();
    ?>   
      <?php foreach($surveyObject as $data){?>

<li class="surveylist printrest_box ">
<div class="printrest_box_style">
<!-- PAGE TITLE AREA START -->
<div class="title_area">
<p><?php echo $data->SurveyTitle; ?></p>
<span class="badge_count" data-original-title="Test(s)" rel="tooltip"><?php if(!empty($categoriesCount[$data->SurveyTitle])){ 
    echo $categoriesCount[$data->SurveyTitle]; 
}else{
    echo 0;
}
?>
</span>
</div>
<!-- PAGE TITLE AREA END -->
<p class="description"><?php echo $data->SurveyDescription; ?> </p>

<!-- -->

<div class="category">
<ul>
<li>
    <div class="inner_li">
<p>No of questions</p>    
<label><?php echo $data->QuestionsCount; ?></label>
    </div>
</li>
<li>
    <div class="inner_li">
    <p>Suspended Questions</p>
<label><?php echo $data->SuspendedCount; ?></label>
    </div>
</li>
</ul>
</div>
<!-- -->
<div class="actions_area surveymenuicons" data-id="<?php echo $data->_id;?>">
<ul>
<li> <!--<a href="#" class="view"><img src="images/spacer.png" ></a>--></li>
<li> <a href="#" class="edit edit_icon" data-name="edit_survey"><img src="images/spacer.png" ></a></li>

</ul>
</div>
</div>
</li>


   
<script type="text/javascript">
$("[rel=tooltip]").tooltip();
</script>
 <?php }?>
<?php } else {
echo $surveyObject ;
        
}?>


    
