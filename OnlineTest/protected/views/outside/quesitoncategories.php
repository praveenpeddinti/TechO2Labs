
<div style="text-align:center;"><span id="hms_timer"></span><span style="display:none" id="hms_timer_hidden"></span><span style="display:none" id="hms_timer_stop"></span></div>
    
           <?php
           $Totaltime = 0;
          
 $k = 0; foreach($CatName as $row){     ?>
   <div class="q_catogories_progress position_R" id="q_categories_<?php echo ($k+1); ?>" data-val="<?php echo ($k+1); ?>" >
       <div class="headerbg_cat" data-timerid='#hms_timer<?php echo ($k+1); ?>' id="CategoryId_<?php echo $row['CategoryId']; ?>">
   	<h3 class="pull-left" data-info="<?php echo ($k+1); ?>" data-original-title="<?php echo $row['CategoryName']; ?>" rel="tooltip"><?php echo $row['CategoryName']; ?></h3> 
        <div class="subject_timer" id="subject_timer_<?php echo ($k+1); ?>">
            <div class="timer"><span id="hms_timer<?php echo ($k+1); ?>"></span><span style="display:none" id="hms_timer<?php echo ($k+1); ?>_hidden"></span><span style="display:none" id="hms_timer<?php echo ($k+1); ?>_stop"></span>
            </div>
            </div>
       </div>
        <div class="clearboth categorydivpadding">
    <table cellpadding="0" cellspacing="0"  border="0" class="categoryQuestions">
       
        <tr>
        <?php $UserId = Yii::app()->session['TinyUserCollectionObj']->UserId; 
           //  echo $row['ScheduleId'];
            $userCatObj = CommonUtility::getSessionSurveyAnswersByScheduleId($UserId,$row['ScheduleId']);  
        for($i=0;$i < sizeof($row['CategoryQuestions']);$i++){
        if($i%5==0){  ?>
        </tr><tr>
             <?php } ?>
            
            <td class="questionnos" style="background-color:<?php echo (isset($userCatObj['UserAnswers'][$i]['IsCompleted']) &&  ($userCatObj['UserAnswers'][$i]['SelectedOption'][0]!='' || $userCatObj['UserAnswers'][$i]['UsergeneratedRankingOptions'][$i]!='' || $userCatObj['UserAnswers'][$i]['DistributionValues'][$i]!='' || $userCatObj['UserAnswers'][$i]['UserAnswer']!='') || $userCatObj['UserAnswers'][$i]['IsCompleted']==1)?"green":"gray";?>" id="qno_<?php echo ($k+1-1)._.($i+1); ?>" data-activetimer="hms_timer<?php echo ($k+1); ?>_hidden" data-qno="<?php echo $i ?>" data-catid="<?php echo $row['CategoryId']; ?>" data-scheduleid="<?php echo $row['ScheduleId']; ?>"><?php echo ($i+1); ?></td>
    <!--<td class="questionnos" style="background-color:<?php echo ($userCatObj['UserAnswers'][$i]['IsCompleted']==1)?"green":"gray"?>" id="qno_<?php echo ($k+1-1)._.($i+1); ?>" data-activetimer="hms_timer<?php echo ($k+1); ?>_hidden" data-qno="<?php echo $i ?>" data-catid="<?php echo $row['CategoryId']; ?>" data-scheduleid="<?php echo $row['ScheduleId']; ?>"><?php echo ($i+1); ?></td>-->

 <?php   } ?>
        </tr>
     
    </table>
        </div>
      
   </div>

     <script type="text/javascript">
      $("[rel=tooltip]").tooltip();  
     $(function(){
          var minutes=<?php echo gmdate("i",  $row['CategoryTime']); ?>;
         var seconds=<?php echo gmdate("s",  $row['CategoryTime']); ?>;
         if(<?php echo gmdate("i",  $row['CategoryTime']) ?>==0 && <?php echo gmdate("s",  $row['CategoryTime'])?>==0 ){
             seconds=4;
    }
   
                                    $('#hms_timer<?php echo ($k+1); ?>').countdowntimer({
                                        hours : <?php echo gmdate("H",  $row['CategoryTime']); ?>,
                                        minutes :minutes,
                                        //minutes:<?php //echo gmdate("i",  $row['CategoryTime']); ?>,
                                        seconds : seconds,
                                        size : "lg",
					pauseButton : "hms_timer<?php echo ($k+1); ?>_hidden",
					stopButton : "hms_timer<?php echo ($k+1); ?>_stop",
                                        //timeUp:"hms_timer<?php echo ($k+1); ?>"
                                        timeUp : "q_categories_<?php echo ($k+1); ?>"
                                    });
                                    if('#hms_timer<?php echo ($k+1); ?>_stop'!="#hms_timer1_stop"){
                                        $('#hms_timer<?php echo ($k+1); ?>_stop').val("stop").trigger('click');
                                     }


                                    
                                });
                               TimerDivs=TimerDivs+","+"#hms_timer<?php echo ($k+1); ?>_hidden";
                               CategoryDivsID=CategoryDivsID+","+"#q_categories_<?php echo ($k+1); ?>";
                               <?php $Totaltime = $Totaltime+$row['CategoryTime']; ?>;
                              
                               CategoryDivs.push("q_categories_<?php echo ($k+1); ?>");
                               CategoryIdArray.push("<?php echo $row['CategoryId']?>");
                               TotalTimerDivs["q_categories_<?php echo ($k+1); ?>"]="hms_timer<?php echo ($k+1); ?>_hidden";
                           
                               CategoryIdwithCategory["<?php echo $row['CategoryId']?>"]="q_categories_<?php echo ($k+1); ?>";
                               
                                </script>
 <?php $k++; } ?>
<input type="button" value="I'm done" name="commit" class="btn" id="submitQuestion" >
                                <script type="text/javascript">
                                    
                                           $(function(){

                                    $('#hms_timer').countdowntimer({
                                        hours : <?php echo gmdate("H",  $Totaltime); ?>,
                                        minutes :<?php echo gmdate("i",  $Totaltime); ?>,
                                        seconds :<?php echo gmdate("s",  $Totaltime); ?>,
                                        size : "lg",
					pauseButton : "hms_timer_hidden",
					stopButton : "hms_timer_stop",
                                        timeUp : "timeisup"
                                    });


                                    
                                    
                                });

                                    </script>