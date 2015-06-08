<?php 
$sno =0;
$isTop = true;
foreach ($questions as $value) {
    if(isset($value["question"])){
      $question = $value["question"];
    $answer = $value["answer"];
    }else{
       $question =  $value;
       $answer = "";
    }
   
$sno++;

   $resource = $question['Resources'];
   include Yii::app()->basePath . '/views/common/translateButton.php';
    if(count($resource)==0){
    ?>

<div  class="paddingtop6" id="gameAns_<?php echo $sno?>">
  <div class="row-fluid">
  <div class="span12">
  <div class="questiondiv positionrelative">
  <div class="qusetionNumber"><?php echo $sno;?>.</div>
  <div class="questiontext"><?php echo $question['Question']; ?></div>
  <?php if($disclaimer==1){?>
   <div class="qusetiondisclaimer" data-id="<?php echo $question['QuestionId']; ?>" >
     <button class="disclaimericon" data-id="<?php echo $question['QuestionId']; ?>"> </button>
   </div>
  <?php }?>
  </div>
  </div>
  </div>
      <?php if($disclaimer==1){?>
    <div class="row-fluid" id="qDis_<?php echo $question['QuestionId']; ?>" style="display: none">
  <div class="span12">
  <div class="questiondiv positionrelative">
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Question_Disclaimer'); ?></span> <?php echo $question['QuestionDisclaimer']?></div>
  
  </div>
  </div>
</div>
    <?php }?>
<div class="row-fluid padding8top">
<div class="span12">
<div class="span6 "> <div class="answerdiv positionrelative"><div class="answertext">
 <div class="normalanswer positionrelative">
     <div class="answerradio">
         <span  class="<?php if($answer=="") echo 'answerdummyclass';?>" data-id="<?php echo $question['QuestionId']; ?>" data-option="A">
         <input type="radio" name="question_<?php echo $sno?>" <?php if($answer=="A") echo 'checked '?>    class="styled" value="A" />
  
         </span>
 </div>
<div class="inneranswer"> <?php echo $question['OptionA']; ?></div>
 </div>
 </div>

  </div
></div>
    <div class="span6 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="normalanswer positionrelative">
 <div class="answerradio">
              <span class="<?php if($answer=="") echo 'answerdummyclass';?>" data-id="<?php echo $question['QuestionId']; ?>" data-option="B">

     <input type="radio" name="question_<?php echo $sno?>"  value="B" <?php if($answer=="B") echo 'checked' ?>   class="styled"/>
              </span>
 </div>
<div class="inneranswer"> <?php echo $question['OptionB']; ?></div>
 </div>
 </div>

  </div>
</div>
</div>

</div>
 <?php if($question['OptionC']!="" || $question['OptionD']!="" ){?>
   <div class="row-fluid padding8top">
<div class="span12">
     <?php if($question['OptionC']!="" ){?>
<div class="span6 "> <div class="answerdiv positionrelative"><div class="answertext">
 <div class="normalanswer positionrelative">
 <div class="answerradio">
              <span class="<?php if($answer=="") echo 'answerdummyclass';?>" data-id="<?php echo $question['QuestionId']; ?>" data-option="C">

     <input type="radio" name="question_<?php echo $sno?>"  value="C" <?php if($answer=="C") echo 'checked' ?>     class="styled "/>
              </span>
 </div>

<div class="inneranswer"><?php echo $question['OptionC']; ?></div>
 </div>
 </div>

  </div>
</div>
     <?php } 
      if($question['OptionD']!="" ){
     ?>
<div class="span6 "> <div class="answerdiv <?php if($question['OptionC']!="" ){ echo "answerdivright";}?> positionrelative"><div class="<?php if($question['OptionC']!="" ){ echo "answertextright";} else echo "answertext";?>">
 <div class="positionrelative">
 <div class="answerradio">
              <span  class="<?php if($answer=="") echo 'answerdummyclass';?>" data-id="<?php echo $question['QuestionId']; ?>" data-option="D">

     <input type="radio" name="question_<?php echo $sno?>"  value="D" <?php if($answer=="D") echo 'checked' ?>   class="styled "/>
              </span>
 </div>

<div class="inneranswer"><?php echo $question['OptionD']; ?></div>
 </div>
 </div>

  </div>
</div>
 <?php } ?>
</div>

</div> 
 <?php } ?>
        </div>
<hr/>
<?php
}else{
  //  $extension = explode(".", $question['QuestionImage']);
   $extension =  $resource['Extension'];
?>
<div  class="padding8top clearcontent" style="padding-bottom:10px">
  <div class="row-fluid">
  <div class="padding-bottom5">
  <div class="questiondiv positionrelative">
  <div class="qusetionNumber"><?php echo $sno;?>.</div>
  <div class="questiontext"> <?php echo $question['Question']; ?></div>
   <?php if($disclaimer==1){?>
   <div class="qusetiondisclaimer" data-id="<?php echo $question['QuestionId']; ?>">
     <button class="disclaimericon" data-id="<?php echo $question['QuestionId']; ?>"> </button>
   </div>
    <?php }?>
  </div>
  </div>
  </div>
     <?php if($disclaimer==1){?>
 <div class="row-fluid" id="qDis_<?php echo $question['QuestionId']; ?>" style="display: none">
  <div class="span12">
  <div class="questiondiv positionrelative">
  <div class="disclaimertext"><span><?php echo Yii::t('translation','Question_Disclaimer'); ?></span> <?php echo $question['QuestionDisclaimer']?></div>
  
  </div>
  </div>
</div>
     <?php }?>
     <div class="clearboth" >
              <div class="marginautotop" style="position: relative;width:280px;float:left;">
                  <div style="display: table;margin:auto;" class="positionrelative migrationimagestyle">
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
    <div class="row-fluid">
<div class="span12 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="normalanswer positionrelative">
     <div class="answerradio">
                  <span  class="<?php if($answer=="") echo 'answerdummyclass';?>" data-id="<?php echo $question['QuestionId']; ?>" data-option="A">

         <input type="radio" name="question_<?php echo $sno?>" <?php if($answer=="A") echo 'checked' ?>  <?php echo $answer==""?'':"disabled='disabled'";?> class="styled" />
                  </span>
     </div>
 
<div class="inneranswer"><?php echo $question['OptionA']; ?></div>
 </div>
 </div>

  </div>
</div></div>

     <div class="row-fluid ">
    <div class="span12 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="normalanswer positionrelative">
 <div class="answerradio">
              <span  class="<?php if($answer=="") echo 'answerdummyclass';?>" data-id="<?php echo $question['QuestionId']; ?>" data-option="B">

     <input type="radio" name="question_<?php echo $sno?>"  <?php if($answer=="B") echo 'checked' ?> <?php echo $answer==""?'':"disabled='disabled'";?> class="styled "/>
              </span>
 </div>
 
<div class="inneranswer"> <?php echo $question['OptionB']; ?></div>
 </div>
 </div>

  </div>
</div></div>

    <?php if($question['OptionC']!="") {?>
      <div class="row-fluid ">
    <div class="span12 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="normalanswer positionrelative">
 <div class="answerradio">
              <span  class="<?php if($answer=="") echo 'answerdummyclass';?>" data-id="<?php echo $question['QuestionId']; ?>" data-option="C">

     <input type="radio" name="question_<?php echo $sno?>" <?php if($answer=="C") echo 'checked' ?> <?php echo $answer==""?'':"disabled='disabled'";?>   class="styled "/>
              </span>
 </div>
 
<div class="inneranswer"><?php echo $question['OptionC']; ?></div>
 </div>
 </div>

  </div>
</div></div>
    <?php }
       if($question['OptionD']!="") {
    ?>
      <div class="row-fluid ">
    <div class="span12 "> <div class="answerdiv answerdivright positionrelative"><div class="answertextright">
 <div class="normalanswer positionrelative">
 <div class="answerradio">
              <span  class="<?php if($answer=="") echo 'answerdummyclass';?>" data-id="<?php echo $question['QuestionId']; ?>" data-option="D">

     <input type="radio" name="question_<?php echo $sno?>" <?php if($answer=="D") echo 'checked' ?> <?php echo $answer==""?'':"disabled='disabled'";?> class="styled "/>
              </span>
 </div>
 
<div class="inneranswer"><?php echo $question['OptionD']; ?></div>
 </div>
 </div>

  </div>
</div></div>
     <?php }?>
 
</div>
</div></div>
</div>       
   
        </div>
<hr/>
<?php 
}
       }
?>
               <div class="row-fluid padding8top clearboth">
<div class="span12 alignright bggrey padding10">
<input type="submit" value="<?php echo Yii::t('translation','Finish'); ?>" data-toggle="dropdown" name="submitGame" id="submitGame" class="btn btndisable"> 
</div>
</div>

<script type="text/javascript">
      Custom.init();
   
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
   
    function submitGameHandler(data){
         $("#questions").html(data);
         $("#gameBtn").html("View <i class='fa fa-chevron-circle-right'>");
         $("#gameBtn").attr("class","btn btnviewanswers");
          $(".btnviewanswers").unbind().bind("click",function(){
     $("#gameBtn").attr("class","btn btnviewanswers btndisable");
       $(".btnviewanswers").unbind();
        showGame('view',$(this).attr("data-gameid"),$(this).attr("data-gamescheduleid"));
    });
    }
    
    
      $(".answerdummyclass").unbind().bind("click",function(){
        var questionId = $(this).attr("data-id");
         var option = $(this).attr("data-option");      
       var gameId = $("#questions").attr("game-id");
       var scheduleId = $("#questions").attr("schedule-id");
       var name=$(this).find('input').attr('name');       
       
       
       if($("[type=radio]:checked").length=='<?php echo $sno?>'){
            $("#submitGame").attr("class","btn");
         $("#submitGame").unbind().bind("click",function(){
        var gameId = $("#questions").attr("game-id");
        var scheduleId = $("#questions").attr("schedule-id");
        var queryString = {gameId:gameId,scheduleId:scheduleId};
       ajaxRequest("/game/submitGame",queryString,submitGameHandler,"html");
    });
       }else{
           $("#submitGame").unbind(); 
       }
       
       var queryString = {gameId:gameId,scheduleId:scheduleId,questionId:questionId,answer:option};
       ajaxRequest("/game/saveAnswer",queryString,saveAnswerHandler);
    });    
  

      
    function saveAnswerHandler(data){
        
    }
    if($("[type=radio]:checked").length==<?php echo $sno?>){ 
          $("#submitGame").attr("class","btn");
    }
     $("#submitGame").unbind().bind("click",function(){
          if($("[type=radio]:checked").length==<?php echo $sno?>){ 
         $("#submitGame").attr("class","btn");
        var gameId = $("#questions").attr("game-id");
        var scheduleId = $("#questions").attr("schedule-id");
        var queryString = {gameId:gameId,scheduleId:scheduleId};
       ajaxRequest("/game/submitGame",queryString,submitGameHandler,"html");
          }
    });
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
        
         //$(".ttw-video-player").css('width','250px');
         
   });
//    function saveAnswer(obj){
//      
//        var questionId = obj.getAttribute("data-id");
//         var option = obj.getAttribute("data-option");
//         alert(questionId+"--"+option);
//    }
    </script>