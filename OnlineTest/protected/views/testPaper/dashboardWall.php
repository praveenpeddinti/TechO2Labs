<?php if(is_array($surveyObject)){    
    $dateFormat =  CommonUtility::getDateFormat();
    ?>   
      <?php foreach($surveyObject as $data){?>

   <li class="surveylist  " style="width: 494px; display: list-item; " id="survey_<?php echo $data->_id;?>">
     <div class="stream_title paddingt5lr10 " style="position: relative">
        
         <b><?php echo $data->_id; ?></b></br>
           <b>Title:<?php echo $data->Title; ?></b>  </br>
           <b>Description:<?php echo $data->Description; ?></b>  </br>
           <b>Total Questions:<?php echo $data->NoofQuestions; ?></b> </br> 
           <?php foreach($data->Category as $categoryDetails){?>
           <b>Category:<?php echo $categoryDetails['CategoryName']; ?></b> </br>    
           <b>Questions:<?php echo $categoryDetails['NoofQuestions']; ?></b> </br>
                
          <?php }?>
      </div>  
      
    
    
</li>
<script type="text/javascript">
$("[rel=tooltip]").tooltip();
</script>
 <?php }?>
<?php } else {
echo $surveyObject ;
        
}?>


    
