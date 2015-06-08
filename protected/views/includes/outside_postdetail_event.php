<?php  if($data->Type==2 && isset($data->StartDate) && $data->EndDate){ 
                    // $timezone =  Yii::app()->session['timezone'];
                     
                     $eventStartDate = CommonUtility::convert_time_zone($data->StartDate->sec,$timezone,'','sec');
                    $eventEndDate = CommonUtility::convert_time_zone($data->EndDate->sec,$timezone,'','sec');
                    //$eventStartDate=$data->StartDate;
                   // $eventEndDate=$data->EndDate;
                    $data->StartDate = date("Y-m-d", $eventStartDate);
                    $data->EndDate = date("Y-m-d", $eventEndDate);
                    $EventStartDay = date("d", $eventStartDate);
                    $EventStartDayString = date("l", $eventStartDate);
                    $EventStartMonth = date("M", $eventEndDate);
                    $EventStartYear = date("Y", $eventEndDate);
                    $EventEndDay = date("d", $eventEndDate);
                    $EventEndDayString = date("l", $eventEndDate);
                    $EventEndMonth = date("M", $eventEndDate);
                    $EventEndYear = date("Y", $eventEndDate);
                    $IsEventAttend = in_array($UserId,$data->EventAttendes);
                     $data->StartTime =  date("h:i A", $eventStartDate);
                    $data->EndTime =  date("h:i A", $eventEndDate);
                    ?>
                 <!-- spinner -->
                      <div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>    
                      <span id="detailed_followUnfollowSpinLoader_<?php echo $data->_id; ?>"></span>
                 <!-- end spinner -->
                <div class="media-body postDetail bulletsShow" id="postDetailPage">

                <p><?php  
                              echo ($data->Description);
                             ?></p>
                <div class="timeshow"> 
                            
                    <ul class="bulletnotShow">
                                <li class="clearboth">
                            <ul class="<?php  echo $data->StartDate==$data->EndDate?'bulletnotShow':"doubleul bulletnotShow" ?>">
                                <li class="doubledate">
                                    <time class="icon" datetime="<?php   echo $data->StartDate; ?>">
                                        <strong><?php   echo $EventStartMonth; ?><?php   echo $data->StartDate!=$data->EndDate?"<br/>":"-"; ?><?php   echo $EventStartYear;?></strong>
                                        <span><?php   echo $EventStartDay;?></span>
                                        <em><?php   echo $EventStartDayString;//day name?></em>
                                        
                                    </time>
                                    
                                </li>
                                
                                <?php   if($data->StartDate!=$data->EndDate){ ?>
                                <li style="width:80px;float:left"><time class="icon" datetime="<?php   echo $data->EndDate; ?>">
                                        <strong><?php   echo $EventEndMonth;?><br/><?php   echo $EventEndYear;?></strong>
                                        <span><?php   echo $EventEndDay;?></span>
                                        <em><?php   echo $EventEndDayString;?></em>
                                    </time>
                                   
                                </li>
                                <?php   } ?>
                            </ul>
                                      </li>
                                       <?php if(trim($data->StartTime)!="" && trim($data->EndTime)!="" && $data->StartTime!=$data->EndTime){ ?>
                                      <li class="clearboth e_datelist"><div class="e_date"><?php   echo $data->StartTime ?> - <?php   echo $data->EndTime ?></div></li>
                                       <?php } ?>
                                  </ul>
                            <div class="et_location clearboth"><span><i class="fa fa-map-marker"></i><?php   echo $data->Location ?></span> </div>

                            
                        </div>
                            <div class="alignright paddingtb clearboth">
                                <?php   if(!$IsEventAttend){ ?>
                                    <button class="eventAttend btn btn-small editable_buttons" id="eventAttendDetailed" name="Attend" data-postid="<?php   echo $data->_id ?>" data-postType="<?php   echo $data->Type;?>" data-categoryType="<?php   echo $categoryType;?>"><i class="fa fa-check-square-o  "></i> Attend</button> 
                                <?php   } ?>
                            </div>
                </div>
                
                <?php  }else{ ?>

                     <!-- spinner -->
                      <div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>   
                      <span id="detailed_followUnfollowSpinLoader_<?php echo $data->_id; ?>"></span>
                 <!-- end spinner -->
                    <div class="media-body postDetail bulletsShow" id="postDetailPage" data-id="<?php echo $data->_id; ?>">
                                <p><?php  echo ($data->Description);?></p>
                                
                             <?php  if($data->Type!=4){?>
                            <!-- Nested media object -->
                                <div class="media">
                                    <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                     <img src="<?php  echo $tinyObject->profile70x70 ?>">
                  
                  </a>
                     </div>
                                    

                                    <div class="media-body">                                   
                                        <span class="m_day"><?php  echo $PostOn; ?></span>
                                        <div class="m_title"><a class="userprofilename_detailed" data-postId="<?php echo $data->_id;?>" data-id="<?php  echo $data->UserId ?>"  style="cursor:pointer"><?php  echo $tinyObject->DisplayName; ?></a><?php  if ($data->Type==5){ $CurbsideConsultCategory =""; ?> <div id="curbside_spinner_<?php echo $data->_id; ?>"></div><span class="pull-right" ><a style='cursor:pointer'data-postId="<?php echo $data->_id; ?>" data-id='<?php  echo $data->CategoryId;?>' class='curbsideCategory'><b><?php  echo isset($curbsideCategory->CategoryName)?$curbsideCategory->CategoryName:''?></b></a></span><?php  }?></div>

                                    </div>
                                </div></div><?php }?>
                            
                            
                               <?php }?>
                 
                 <?php if(isset($data->IsWebSnippetExist) && $data->IsWebSnippetExist=='1'){?>            
                             <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;">
                                 <div class="Snippet_div" style="position: relative">
                            <?php if(isset($data->WebUrls) && isset($data->WebUrls->WebLink)){ ?>
                                     
                                <a href="<?php echo $data->WebUrls->Weburl; ?>" target="_blank">
                                            <?php if($data->WebUrls->WebImage!=""){ ?>
                                    <span  class=" pull-left img_single e_img" style="width:100px;" ><img src="<?php echo $data->WebUrls->WebImage; ?>"></span>
                                            <?php } ?>
                                            <div class="media-body">                                   
                                                    

                                                        <label class="websnipheading"><?php echo $data->WebUrls->WebTitle ?></label>
                                                     <a class="websniplink" href="<?php echo $data->WebUrls->Weburl; ?>" target="_blank"> <?php echo $data->WebUrls->WebLink ?></a>
                                                            
                                                        <p><?php echo $data->WebUrls->Webdescription ?></p>
                                                    
                                                </div>

                                        </a>
                                     
                                      <?php } ?>   
                                    </div>
                           </div>
                          
                               <?php } ?>    
                 