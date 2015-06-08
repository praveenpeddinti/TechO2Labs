<?php
$sno =0;
$isTop = true;
foreach ($questions as $value) {
    $question = $value["question"];
    $answer = $value["answer"];
    $correctAnswer = $value["correctAnswer"];
   
$sno++;
  $resource = $question['Resources'];
  include Yii::app()->basePath . '/views/common/translateButton.php';
    if(count($resource)==0){
    ?>
<div  class="padding8top clearboth" style="padding-bottom:10px">
  <div class="row-fluid">
  <div class="padding-bottom5">
  <div class="questiondiv positionrelative">
      <div class="qusetionNumber"><?php echo $sno;?>.</div>
  <div class="questiontext"><?php echo $question['Question'] ?></div>
  <div class="qusetiondisclaimer"  data-id="<?php echo $question['QuestionId']; ?>" style="<?php if($disclaimer=="0"){?> display:none<?php }?>">
     <button class="disclaimericon"  data-id="<?php echo $question['QuestionId']; ?>"> </button></div>
  </div>
  </div>
  </div>
 <div class="row-fluid" id="qDis_<?php echo $question['QuestionId']; ?>" style="display: none">
  <div class="span12">
  <div class="questiondiv positionrelative">
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Question_Disclaimer'); ?></span> <?php echo $question['QuestionDisclaimer']?></div>
  
  </div>
  </div>
</div>
<div class="row-fluid padding8top">
<div class="span12">
<div class="span6 "> <div class="answerdiv positionrelative"><div class="answertext">
 <div class="<?php if($correctAnswer=="A"){echo 'correctanswer';}else if($answer=="A")echo 'wronganswer'; else echo 'normalanswer';?> positionrelative">
     <div class="answerradio"><input type="radio" name="question_<?php echo $sno?>" disabled="disabled" <?php if($answer=="A") echo 'checked' ?> class="styled "/></div>
 <div class="answerselection answercorrect"><i class="fa fa-check"></i></div>
 <div class="answerselection answerwrong"><i class="fa fa-times"></i></div>
<div class="inneranswer">  <?php echo $question['OptionA']; ?></div>
 </div>
 </div>
<div class="qusetiondisclaimer" style="<?php if(trim($question['OptionADisclaimer'])=="" || $disclaimer ==0){?> display:none<?php }?>">
     <button class="disclaimericon" data-id="<?php echo $sno.'_A'?>" > </button></div>
  </div></div>
    <div class="span6 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="<?php if($correctAnswer=="B"){echo 'correctanswer';}else if($answer=="B")echo 'wronganswer'; else echo 'normalanswer';?> positionrelative">
 <div class="answerradio"><input type="radio" name="question_<?php echo $sno?>" disabled="disabled" <?php if($answer=="B") echo 'checked' ?> class="styled "/></div>
 <div class="answerselection answercorrect"><i class="fa fa-check"></i></div>
 <div class="answerselection answerwrong"><i class="fa fa-times"></i></div>
<div class="inneranswer"> <?php echo $question['OptionB']; ?></div>
 </div>
 </div>
            
<div class="qusetiondisclaimer" style="<?php if(trim($question['OptionBDisclaimer'])=="" || $disclaimer ==0){?> display:none<?php }?>">
     <button class="disclaimericon" data-id="<?php echo $sno.'_B'?>"> </button></div>
  </div>
</div>
</div>

</div>
    <div class="row-fluid" >
  <div class="span12">
      <div class="span6" >
  <div class="questiondiv positionrelative" style="display: none" id="qDis_<?php echo $sno.'_A'?>">
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Option_Disclaimer'); ?></span> <?php echo $question['OptionADisclaimer']?></div>
  
  </div>
  </div>
      <div class="span6" >
  <div class="questiondiv positionrelative" style="display: none" id="qDis_<?php echo $sno.'_B'?>">
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Option_Disclaimer'); ?></span> <?php echo $question['OptionBDisclaimer']?></div>
  
  </div>
  </div>
  </div>
</div>
   <?php if($question['OptionC']!="" || $question['OptionD']!="" ){?>  
   <div class="row-fluid padding8top">
<div class="span12">
    <?php if($question['OptionC']!="" ){?>
<div class="span6 "> <div class="answerdiv positionrelative"><div class="answertext">
 <div class="<?php if($correctAnswer=="C"){echo 'correctanswer';}else if($answer=="C")echo 'wronganswer'; else echo 'normalanswer';?> positionrelative">
 <div class="answerradio"><input type="radio" name="question_<?php echo $sno?>"  disabled="disabled" <?php if($answer=="C") echo 'checked' ?> class="styled "/></div>
 <div class="answerselection answercorrect"><i class="fa fa-check"></i></div>
 <div class="answerselection answerwrong"><i class="fa fa-times"></i></div>
<div class="inneranswer">  <?php echo $question['OptionC']; ?></div>
 </div>
 </div>
<div class="qusetiondisclaimer" style="<?php if(trim($question['OptionCDisclaimer'])=="" || $disclaimer ==0){?> display:none<?php }?>">
     <button class="disclaimericon" data-id="<?php echo $sno.'_C'?>"> </button></div>
  </div>
</div>
     <?php } 
      if($question['OptionD']!="" ){
     ?>
<div class="span6 "> <div class="answerdiv <?php if($question['OptionC']!="" ){ echo "answerdivright";}?> positionrelative"><div class="<?php if($question['OptionC']!="" ){ echo "answertextright";} else echo "answertext";?>">
 <div class="<?php if($correctAnswer=="D"){echo 'correctanswer';}else if($answer=="D")echo 'wronganswer'; else echo 'normalanswer';?> positionrelative">
 <div class="answerradio"><input type="radio" name="question_<?php echo $sno?>" disabled="disabled" <?php if($answer=="D") echo 'checked' ?> class="styled "/></div>
 <div class="answerselection answercorrect"><i class="fa fa-check"></i></div>
 <div class="answerselection answerwrong"><i class="fa fa-times"></i></div>
<div class="inneranswer">  <?php echo $question['OptionD']; ?></div>
 </div>
 </div>
<div class="qusetiondisclaimer" style="<?php if(trim($question['OptionDDisclaimer'])=="" || $disclaimer ==0){?> display:none<?php }?>">
     <button class="disclaimericon" data-id="<?php echo $sno.'_D'?>"> </button></div>
  </div>
</div>
      <?php } ?>
</div>

</div>
     <?php } ?>
       <div class="row-fluid">
  <div class="span12">
      <div class="span6" >
  <div class="questiondiv positionrelative" style="display: none" id="qDis_<?php echo $sno.'_C'?>">
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Option_Disclaimer'); ?></span> <?php echo $question['OptionCDisclaimer']?></div>
  
  </div>
  </div>
      <div class="span6" >
  <div class="questiondiv positionrelative" style="display: none" id="qDis_<?php echo $sno.'_D'?>">
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Option_Disclaimer'); ?></span> <?php echo $question['OptionDDisclaimer']?></div>
  
  </div>
  </div>
  </div>
</div>
</div>
<hr/>
<?php
}else{
    
   $extension =  $resource['Extension'];
?>
<div  class="paddingtop6 clearcontent" >
  <div class="row-fluid">
  <div class="span12">
  <div class="questiondiv positionrelative">
  <div class="qusetionNumber"><?php echo $sno;?>.</div>
  <div class="questiontext"> <?php echo $question['Question']; ?></div>
  <div class="qusetiondisclaimer" data-id="<?php echo $question['QuestionId']; ?>" style="<?php if(trim($question['QuestionDisclaimer'])==""){?> display:none<?php }?>">
     <button class="disclaimericon" data-id="<?php echo $question['QuestionId']; ?>"> </button></div>
  </div>
  </div>
  </div>
 <div class="row-fluid" id="qDis_<?php echo $question['QuestionId']; ?>" style="display: none;">
  <div class="span12">
  <div class="questiondiv positionrelative" >
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Option_Disclaimer'); ?></span> <?php echo $question['QuestionDisclaimer']?></div>
  
  </div>
  </div>
</div>
<div class="clearboth" >
              <div class="marginautotop" style="position: relative;width:280px;float:left;">
                  <div class="positionrelative migrationimagestyle">
     
            <?php
     if($extension == "mp4" || $extension == "avi" || $extension == "flv" || $extension == "mov" || $extension == "mp3"){
         
         ?>
      
                <div id="questionVideo_<?php echo $sno;?>" video-id="<?php echo  $resource['Uri']?>" class="gameVideo" ><img src="/images/icons/video_icon.png" style="position: absolute;left:40%;top:40%"><img src="<?php echo  $resource['ThumbNailImage']?>"/></div>

    <?php     
     }else{
         ?>
         <img src="<?php echo $resource['ThumbNailImage']?>" />
        <?php
     }
     ?>
     </div>
      </div>
        <div style="overflow:hidden">
                  <div class="row-fluid">
<div class="span12">
    <div class="row-fluid bottommargin8">
<div class="span12 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="<?php if($correctAnswer=="A"){echo 'correctanswer';}else if($answer=="A")echo 'wronganswer'; else echo 'normalanswer';?> positionrelative">
 <div class="answerradio"><input type="radio" name="question_<?php echo $sno?>" disabled="disabled" <?php if($answer=="A") echo 'checked' ?> class="styled "/></div>
 <div class="answerselection answercorrect"><i class="fa fa-check"></i></div>
 <div class="answerselection answerwrong"><i class="fa fa-times"></i></div>
<div class="inneranswer"> <?php echo $question['OptionA']; ?></div>
 </div>
 </div>
<div class="qusetiondisclaimer" style="<?php if(trim($question['OptionADisclaimer'])==""){?> display:none<?php }?>">
     <button class="disclaimericon" data-id="<?php echo $sno.'_A'?>"> </button></div>
  </div>
</div></div>
    <div class="row-fluid"  style="display: none" id="qDis_<?php echo $sno.'_A'?>">
  <div class="span12">
      
  <div class="questiondiv positionrelative">
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Option_Disclaimer'); ?></span> <?php echo $question['OptionADisclaimer']?></div>
  
  </div>
  
  </div>
</div>
     <div class="row-fluid bottommargin8">
    <div class="span12 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="<?php if($correctAnswer=="B"){echo 'correctanswer';}else if($answer=="B")echo 'wronganswer'; else echo 'normalanswer';?> positionrelative">
 <div class="answerradio"><input type="radio" name="question_<?php echo $sno?>" disabled="disabled" <?php if($answer=="B") echo 'checked' ?> class="styled "/></div>
 <div class="answerselection answercorrect"><i class="fa fa-check"></i></div>
 <div class="answerselection answerwrong"><i class="fa fa-times"></i></div>
<div class="inneranswer"> <?php echo $question['OptionB']; ?></div>
 </div>
 </div>
<div class="qusetiondisclaimer" style="<?php if(trim($question['OptionBDisclaimer'])==""){?> display:none<?php }?>">
     <button class="disclaimericon" data-id="<?php echo $sno.'_B'?>"> </button></div>
  </div>
</div></div>
    <div class="row-fluid" style="display: none" id="qDis_<?php echo $sno.'_B'?>">
  <div class="span12">
      
  <div class="questiondiv positionrelative" >
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Option_Disclaimer'); ?></span> <?php echo $question['OptionBDisclaimer']?></div>
  
  </div>
  
  </div>
</div>
     <?php if($question['OptionC']!="") {?>
      <div class="row-fluid bottommargin8">
    <div class="span12 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="<?php if($correctAnswer=="C"){echo 'correctanswer';}else if($answer=="C")echo 'wronganswer'; else echo 'normalanswer';?> positionrelative">
 <div class="answerradio"><input type="radio" name="question_<?php echo $sno?>" disabled="disabled" <?php if($answer=="C") echo 'checked' ?> class="styled "/></div>
 <div class="answerselection answercorrect"><i class="fa fa-check"></i></div>
 <div class="answerselection answerwrong"><i class="fa fa-times"></i></div>
<div class="inneranswer"> <?php echo $question['OptionC']; ?></div>
 </div>
 </div>
<div class="qusetiondisclaimer" style="<?php if(trim($question['OptionCDisclaimer'])==""){?> display:none<?php }?>">
     <button class="disclaimericon" data-id="<?php echo $sno.'_C'?>"> </button></div>
  </div>
</div></div>
    
    <div class="row-fluid" style="display: none" id="qDis_<?php echo $sno.'_C'?>">
  <div class="span12">
      
  <div class="questiondiv positionrelative" >
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Option_Disclaimer'); ?></span> <?php echo $question['OptionCDisclaimer']?></div>
  
  </div>
  
  </div>
</div>
     <?php }
       if($question['OptionD']!="") {
    ?>
      <div class="row-fluid bottommargin8">
    <div class="span12 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="<?php if($correctAnswer=="D"){echo 'correctanswer';}else if($answer=="D")echo 'wronganswer'; else echo 'normalanswer';?> positionrelative">
 <div class="answerradio"><input type="radio" name="question_<?php echo $sno?>" disabled="disabled" <?php if($answer=="D") echo 'checked' ?> class="styled "/></div>
 <div class="answerselection answercorrect"><i class="fa fa-check"></i></div>
 <div class="answerselection answerwrong"><i class="fa fa-times"></i></div>
<div class="inneranswer"><?php echo $question['OptionD']; ?></div>
 </div>
 </div>
<div class="qusetiondisclaimer" style="<?php if(trim($question['OptionDDisclaimer'])==""){?> display:none<?php }?>">
     <button class="disclaimericon" data-id="<?php echo $sno.'_D'?>"> </button></div>
  </div>
</div></div>
    <div class="row-fluid" style="display: none" id="qDis_<?php echo $sno.'_D'?>">
  <div class="span12">
      
  <div class="questiondiv positionrelative" >
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Option_Disclaimer'); ?></span> <?php echo $question['OptionDDisclaimer']?></div>
  
  </div>
  
  </div>
</div>
      <?php }?>
</div>

</div>
      </div>
  </div>
</div>         
   
<hr/>
    
<?php 
}
}
?>
<script type="text/javascript">
     $(document).ready(function(){
             Custom.init();
  });
  $("#gameQuestions input.translatebutton").unbind().bind("click",function(){
        scrollPleaseWait("gameDetailSpinLoader","contentDiv");
        var queryString = {
                type:'<?php echo $translateNeed["type"] ?>',
                gameId:'<?php echo $translateNeed["gameId"] ?>',
                gameScheduleId:'<?php echo $translateNeed["gameScheduleId"] ?>',
                fromLanguage:'<?php echo $translateNeed["gameLanguage"] ?>',
                toLanguage:'<?php echo $translateNeed["userLanguage"] ?>',
            };
        ajaxRequest("/game/showGame",queryString,function(data){showGameHandler(data,'<?php echo $translateNeed["type"] ?>')},"html");
    });
     $(".disclaimericon").unbind().bind("click",function(){
        var dataId = $(this).attr("data-id");
         $("#qDis_"+dataId).toggle();
    })
       $(".gameVideo").unbind().bind('click',function(){
         var uri = $(this).attr('video-id');
        
            var id = $(this).attr('id');
        var options = {height:250,
                        width:250,
                        autoplay:true,
                        callback:function(){
                           
                        }
                    };
        loadDocumentViewer(id, uri, options);
         $("#"+id+" .document-viewer-wrapper").css('margin','0px');
         $("#"+id+" .document-viewer").css('padding','0px 0px');
         $("#"+id+" .document-viewer").css('width','250px');
         setTimeout(function(){
              $(".ttw-video-player").css('padding','0px 0px');
         },500)
   });
    </script>