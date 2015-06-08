 <?php  
                
                $IsSurveyTaken = 0; 
                if(isset($data->SurveyTaken)){
                    foreach($data->SurveyTaken as $surveyTaken){
                        if($surveyTaken['UserId']==$UserId){
                            $IsSurveyTaken = 1;
                        }
                    }
                }                
                    
                    $TotalSurveyCount = $data->OptionOneCount+$data->OptionTwoCount+$data->OptionThreeCount+$data->OptionFourCount;
                   
                ?>
                  <!-- spinner -->
                      <div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>  
                      <span id="detailed_followUnfollowSpinLoader_<?php echo $data->_id; ?>"></span>
                 <!-- end spinner -->
                <div class="alert alert-error" id="<?php   echo "surveyError_".$data->_id ?>" style='padding-top: 5px;display: none'> Please select an option </div>
                            <div class="alert alert-success" id="<?php   echo "surveyConfirmation_".$data->_id ?>" style='padding-top: 5px;display: none'><?php   echo Yii::t('translation', 'Survey_Completed'); ?></div>
                            <div id="<?php   echo "surveyArea_".$data->_id ?>">
                                <?php   
                                if(!$IsSurveyTaken){ ?>
                                                     
                            <div class="media-body postDetail bulletsShow">
                                <div class="surveyquestion" ><?php  echo ($data->Description); ?></div>
                                <div class="row-fluid ">
                                    <div class="span12">
                                        <input type="radio" class="styled" name="<?php   echo "survey_".$data->_id ?>" value="OptionOne"> <?php   echo $data->OptionOne ?>
                                    </div>
                                </div>
                                <div class="row-fluid ">
                                    <div class="span12">
                                        <input type="radio" class="styled" name="<?php   echo "survey_".$data->_id ?>" value="OptionTwo">   <?php   echo $data->OptionTwo ?>
                                    </div>
                                </div>
                                <div class="row-fluid ">
                                    <div class="span12">
                                        <input type="radio" class="styled" name="<?php   echo "survey_".$data->_id ?>" value="OptionThree">   <?php   echo $data->OptionThree ?>
                                    </div>
                                </div>
                                <div class="row-fluid ">
                                    <div class="span12">
                                        <input type="radio" class="styled" name="<?php   echo "survey_".$data->_id ?>" value="OptionFour">   <?php   echo $data->OptionFour ?>
                                    </div>
                                </div>
                                <div class="alignright paddingtb">
                                    <input class="btn " name="commit" type="button" value="Submit"  onclick="showLoginPopup();"/>
                                </div>
                                
                            </div>
                                 
                                    
                            <?php   } ?>
                                </div>
                                <div class="media-body postDetail bulletsShow" id="<?php   echo "surveyTakenArea_".$data->_id ?>" style="display:<?php   echo $IsSurveyTaken?'block':'none' ?>">
                                    <div class="surveyquestion" ><?php   echo ($data->Description); ?></div>
                                    <div class="media-body custommedia-body">
                                         <div class="row-fluid " >
                                             <div class="span12">
                                                 <div class="span7" id="<?php   echo "surveyGraphArea_".$data->_id ?>" ></div>
                                                 <div class="span5 surveyresults" >
                                                     <div class="row-fluid ">
                                                        <div class="span12">
                                                            <?php   echo "A) ".$data->OptionOne ?>
                                                        </div>
                                                        </div>
                                                        <div class="row-fluid ">
                                                            <div class="span12">
                                                                <?php   echo "B) ".$data->OptionTwo ?>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid ">
                                                            <div class="span12">
                                                                <?php   echo "C) ".$data->OptionThree ?>
                                                            </div>
                                                        </div>
                                                        <div class="row-fluid ">
                                                            <div class="span12">
                                                                <?php   echo "D) ".$data->OptionFour ?>
                                                            </div>
                                                        </div>
                                                 </div>
                                             </div>
                                        </div>
                                    </div>
                                    
                            <?php    
                                if($IsSurveyTaken){
                                    $totalSurveyCount = $data->OptionOneCount+$data->OptionTwoCount+$data->OptionThreeCount+$data->OptionFourCount;
                                    if($totalSurveyCount>0){
                                    ?>
                                <script type="text/javascript">
                                  $(function(){                                      
                                      drawSurveyChart('<?php   echo "surveyGraphArea_$data->_id"; ?>', <?php   echo $data->OptionOneCount ?>, <?php   echo $data->OptionTwoCount ?>,<?php   echo $data->OptionThreeCount ?>,<?php   echo $data->OptionFourCount ?>,250,300);
                                  });
                                </script>
                            <?php   } } ?>
                                
                            </div>
                             <?php if(isset($data->IsWebSnippetExist) && $data->IsWebSnippetExist=='1'){   ?>            
                             <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;">
                                 <div class="Snippet_div" style="position: relative">
                                     <?php if(isset($data->WebUrls) && isset($data->WebUrls->WebLink)){ ?>
                                      <a href="<?php echo $data->WebUrls->Weburl; ?>" target="_blank">
                                            <?php if($data->WebUrls->WebImage!=""){ ?>
                                    <span  class=" pull-left img_single e_img" style="width:100px;" ><img src="<?php echo $data->WebUrls->WebImage; ?>"></span>
                                            <?php } ?>
                                            <div class="media-body">                                   
                                                    

                                                        <label class="websnipheading" ><?php echo $data->WebUrls->WebTitle ?></label>

                                                <a   class="websniplink" href="<?php echo $data->WebUrls->Weburl; ?>" target="_blank">     <?php echo $data->WebUrls->WebLink ?> </a> 
                                               
                                                        <p><?php echo $data->WebUrls->Webdescription ?></p>
                                                    
                                                </div>

                                        </a>
                                     <?php } ?>
                                    </div>
                           </div>
                          
                               <?php } ?>
                              