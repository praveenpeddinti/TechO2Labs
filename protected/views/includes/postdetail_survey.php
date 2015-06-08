 <!-- spinner -->
 <?php 
$height = 250;
$width = 300; ?>
<div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>  
<span id="detailed_followUnfollowSpinLoader_<?php echo $data->_id; ?>"></span>
<!-- end spinner -->
<div class="alert alert-error" id="<?php   echo "surveyError_".$data->_id ?>" style='padding-top: 5px;display: none'> Please select an option </div>
      <div class="alert alert-success" id="<?php   echo "surveyConfirmation_".$data->_id ?>" style='padding-top: 5px;display: none'><?php   echo Yii::t('translation', 'Survey_Completed'); ?></div>
      <div id="<?php   echo "surveyArea_".$data->_id ?>">
                                <?php   
          if(!$data->IsSurveyTaken){ ?>
                                                     
                            <div class="media-body postDetail bulletsShow">
                                <div class="surveyquestion" id="postdetail_postText"><?php  echo ($data->Description); ?></div>
                                <div class="row-fluid ">
                                    <div class="span12 customradioanswers">
                                        <div class="customradioanswersdiv">
                                            <div class="c_prefix">A)</div>
                                            <div class="c_suffix">
                                                <input type="radio" class="styled" name="<?php   echo "survey_".$data->_id ?>" value="OptionOne">
                                            </div>
                                        </div>
                                        <div class="c_options" id="OptionOne_<?php echo $data->_id ?>"><?php  echo $data->OptionOne ?></div>
                                    </div>
                                </div>
                                <div class="row-fluid ">
                                    <div class="span12 customradioanswers">
                                        <div class="customradioanswersdiv">
                                            <div class="c_prefix">B)</div>
                                            <div class="c_suffix">
                                                <input type="radio" class="styled" name="<?php   echo "survey_".$data->_id ?>" value="OptionTwo"> 
                                            </div>
                                        </div>
                                        <div class="c_options" id="OptionTwo_<?php echo $data->_id ?>"><?php  echo $data->OptionTwo ?></div>
                                    </div>
                                </div>
                                <div class="row-fluid ">
                                    <div class="span12 customradioanswers">
                                        <div class="customradioanswersdiv">
                                            <div class="c_prefix">C)</div>
                                            <div class="c_suffix">
                                                <input type="radio" class="styled" name="<?php   echo "survey_".$data->_id ?>" value="OptionThree">
                                            </div>
                                        </div>
                                        <div class="c_options" id="OptionThree_<?php echo $data->_id ?>"><?php  echo $data->OptionThree ?></div>
                                    </div>
                                </div>
                                
                                <div class="row-fluid " style="display: <?php echo (isset($data->OptionFour) && !empty($data->OptionFour))?'block':'none' ?>">
                                    <div class="span12 customradioanswers">
                                        <div class="customradioanswersdiv">
                                            <div class="c_prefix">D)</div>
                                            <div class="c_suffix">
                                                <input type="radio" class="styled" name="<?php   echo "survey_".$data->_id ?>" value="OptionFour">
                                            </div>
                                        </div>
                                        <div class="c_options"id="OptionFour_<?php echo $data->_id ?>"><?php  echo $data->OptionFour ?></div>
                                    </div>
                                </div>
                                
                                <div class="alignright paddingtb">
              <input class="btn " name="commit" type="button" value="Submit" onclick="submitSurvey('<?php   echo $data->_id ?>','<?php   echo $data->NetworkId;?>','<?php   echo $data->CategoryType;?>',<?php   echo $data->OptionOneCount;?>,<?php   echo $data->OptionTwoCount;?>,<?php   echo $data->OptionThreeCount ?>,<?php   echo $data->OptionFourCount;?>,'<?php echo $data->_id; ?>',<?php echo $data->IsOptionDExist; ?>)" />
                                </div>
                                <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
                            </div>
                                 
                                    
                            <?php   } ?>
                                </div>
          <div class="media-body postDetail bulletsShow" id="<?php   echo "surveyTakenArea_".$data->_id ?>" style="display:<?php   echo $data->IsSurveyTaken?'block':'none' ?>">
              <div class="surveyquestion"   id="postdetail_postText"><?php   echo ($data->Description); ?></div>
                                    <div class="media-body custommedia-body">
                                         <div class="row-fluid " >
                                             <div class="span12">
                                                 <div class="span7" id="<?php   echo "surveyGraphArea_".$data->_id ?>" ></div>
                                                 <div class="span5 surveyresults" >
                                                     <div class="row-fluid ">
                                                        <div class="span12">
                                                            <?php  echo "A) "?><span id="<?php  echo "GraphArea_OptionOne_".$data->_id ?>"><?php echo $data->OptionOne ?></span>
                                                        </div>
                                                        </div>
                                                        <div class="row-fluid ">
                                                            <div class="span12">
                                                                <?php  echo "B) "?><span id="<?php  echo "GraphArea_OptionTwo_".$data->_id ?>"><?php echo $data->OptionTwo ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid ">
                                                            <div class="span12">
                                                                <?php  echo "C) "?><span id="<?php  echo "GraphArea_OptionThree_".$data->_id ?>"><?php echo $data->OptionThree ?></span>
                                                            </div>
                                                        </div>
                                                     <?php if(isset($data->OptionFour) && !empty($data->OptionFour)){ ?>
                                                        <div class="row-fluid ">
                                                            <div class="span12">
                                                                <?php  echo "D) "?><span id="<?php  echo "GraphArea_OptionFour_".$data->_id ?>"><?php echo $data->OptionFour; ?></span>
                                                            </div>
                                                        </div>
                                                     <?php } ?>
                                                 </div>
                                             </div>
                                        </div>
                                    </div>
                                    <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
                            <?php    
          if($data->IsSurveyTaken){
              if($data->TotalSurveyCount>0){
                                    ?>
                                <script type="text/javascript">                        
                                    <?php 
                                    if (sizeof($data->Resource) != 0) {
                                         $width = 220;
                                     }
?>
                                  $(function(){      
                drawSurveyChart('<?php   echo "surveyGraphArea_$data->_id"; ?>', <?php   echo $data->OptionOneCount ?>, <?php   echo $data->OptionTwoCount ?>,<?php   echo $data->OptionThreeCount ?>,<?php   echo $data->OptionFourCount ?>,'<?php echo $height; ?>','<?php echo $width; ?>', <?php echo $data->IsOptionDExist; ?>);
                                  });
                                </script>
                            <?php   } } ?>
                                
                            </div>