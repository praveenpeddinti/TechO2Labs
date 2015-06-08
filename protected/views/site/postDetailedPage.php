<?php  if(is_object($data)){
    $count = 0;
    $createdOn = $data->CreatedOn;    
    $PostOn = CommonUtility::styleDateTime($createdOn->sec);
    $UserId = $this->tinyObject->UserId;
    $PostTypeString = CommonUtility::postTypebyIndex($data->Type);     
    $actionText = CommonUtility::actionTextbyActionType($data->Type);
    if($categoryType == 3){
        $PostTypeString = "Group $PostTypeString";
    }
    $ShareCount = 0;
    $FbShareCount = isset($data->FbShare) && is_array($data->FbShare)?sizeof($data->FbShare):0;
    $TwitterShareCount = isset($data->TwitterShare) && is_array($data->TwitterShare)?sizeof($data->TwitterShare):0;
    $ShareCount = $FbShareCount+$TwitterShareCount;
?>
    
    

<div class="row-fluid " id="postDetailedTitle">
     <div class="span6 "><h2 class="pagetitle"><?php if($data->Type==5){ echo $data->Subject;} else{  echo Yii::t('translation','Normal_Post_Detail');}?></h2>
    
     </div>
          <div class="span6 ">
          <div class="grouphomemenuhelp alignright tooltiplink"> <a data-postType="<?php  echo $data->Type;?>" data-categoryId="<?php  echo $categoryType; ?>" class="detailed_close_page" rel="tooltip"  data-original-title="close" data-placement="bottom" data-toggle="tooltip"> <i class="fa fa-times"></i></a> </div>
          </div>
     </div>
    
    <div class="stream_widget marginT10" id="postDetailedwidget">
   	 <div class="generalprofileicon skiptaiconwidth80x80 generalzindex2 positionabsolutediv ">
     <div class="skiptaiconinner ">            
    <img src="<?php  echo $tinyObject->profile250x250;?>" >
      </div> 
                     </div>
    	<div class="post_widget" data-postid="<?php  echo $data->_id ?>" data-postType="<?php  echo $data->Type;?>">
        <div class="stream_msg_box">
            <div class="stream_title paddingt5lr10" style="position: relative">  <a class="userprofilename_detailed" data-postId="<?php echo $data->_id;?>" data-id="<?php  echo $data->UserId ?>" style="cursor:pointer"> <b><?php  if($data->Type != 4) echo $tinyObject->DisplayName;?></b></a>  <?php if($data->Type != 4){ echo "<span>$actionText</span> $PostTypeString";}else{ echo "A new post has been created"; }?><span class='userprofilename'> <?php if($data->Type==2 || $data->Type==3){ if(isset($data->Title) && $data->Title!=""){ echo $data->Title; };} ?></span> <i><?php  echo $PostOn; ?> </i></div>
             <div class=" stream_content">
                
            <ul>
            <li class="media">
            <?php  if($data->Type!=3){  ?>
                <?php  if($data->Type==2 && isset($data->StartDate) && $data->EndDate){ 
                    $eventStartDate=$data->StartDate;
                    $eventEndDate=$data->EndDate;
                    $data->StartDate = date("Y-m-d", $eventStartDate->sec);
                    $data->EndDate = date("Y-m-d", $eventEndDate->sec);
                    $EventStartDay = date("d", $eventStartDate->sec);
                    $EventStartDayString = date("l", $eventStartDate->sec);
                    $EventStartMonth = date("M", $eventEndDate->sec);
                    $EventStartYear = date("Y", $eventEndDate->sec);
                    $EventEndDay = date("d", $eventEndDate->sec);
                    $EventEndDayString = date("l", $eventEndDate->sec);
                    $EventEndMonth = date("M", $eventEndDate->sec);
                    $EventEndYear = date("Y", $eventEndDate->sec);
                    $IsEventAttend = in_array($UserId,$data->EventAttendes);
                    
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
                                       <?php if(trim($data->StartTime)!="" && trim($data->EndTime)!="" ){ ?>
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
                            
                            
                               <?php  }?>
                 
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
                 
                 
            <?php  }else{?>
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
                                    <input class="btn " name="commit" type="button" value="Submit" onclick="submitSurvey('<?php   echo $data->_id ?>','<?php   echo $data->NetworkId;?>','<?php   echo $categoryType;?>',<?php   echo $data->OptionOneCount;?>,<?php   echo $data->OptionTwoCount;?>,<?php   echo $data->OptionThreeCount ?>,<?php   echo $data->OptionFourCount;?>)" />
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
                                    
                <?php  }?>
              
         <?php  if(sizeof($data->Resource)>0){   ?>    
        <div class="postartifactsdiv padding5">
        
            <div class="chat_subheader ">Artifacts</div>
         
        <div class="row-fluid padding8top detailed_media">
                            <div class="span12">
                               <?php  
                    foreach($data->Resource as $res){
                         if(isset($res['Extension'])){
                        $ext = strtolower($res['Extension']);
                         //                        if($ext=='ppt'||$ext=='pptx'){
//                         $image="/images/system/PPT-File-icon.png";
//                    }else if($ext=='pdf'){
//                         $image="/images/system/pdf.png";
//                    }else if($ext=='doc' || $ext=='docx'){
//                         $image="/images/system/MS-Word-2-icon.png";
//                    }else if($ext=='exe' || $ext=='xls'|| $ext=='xlsx'|| $ext=='ini'){
//                         $image="/images/system/Excel-icon.png";
//                    } else if ($ext == 'txt') {
//                            $image = "/images/system/notepad-icon.png";
//                    }
                        if(isset($res['ThumbNailImage'])){
                               $image=$res['ThumbNailImage'];
                           }else{
                               $image="";
                           }
    
                    if($ext == "mp3"){?>
                            <div class="span3"> 

                                <div class="d_img_outer_video_play" >

                                <img style="cursor:pointer;" src="/images/system/audio_img.png" data-uri="<?php  echo $res['Uri'];?>" data-format="<?php  echo $ext;?>" id="videodivid"/>
                            </div>
                            </div>
                    
                      <?php  }else if($ext == "mp4" || $ext == 'flv' || $ext == 'mov'){
                         if($categoryType!=3){
                             $videoclassName = 'PostdetailvideoThumnailDisplay';
                         }else{
                              $videoclassName = 'GroupPostdetailvideoThumnailDisplay';
                         }
                            
                          
                          
                          ?>
                            <div class="span3"> 

                                <div class="d_img_outer_video_play" style="cursor:pointer;" ><div  class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div>

                                <img style="cursor:pointer;" src='<?php echo $image; ?>' data-uri="<?php  echo $res['Uri'];?>" data-format="<?php  echo $ext;?>" id="videodivid"/>
                            </div>
                            </div>
                        <?php  }else  if($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif"){?>
                            <div class="span3">
                                <div class="d_img_outer_video_play" >
                                <img style="cursor:pointer;" src="<?php  echo $res['Uri'];?>" data-uri="<?php echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$res['Uri']);?>" id="imageimgdivid" data-format="<?php  echo $ext;?>" class="imageimgdivid"/>
                                </div>
                            </div>
                    <?php  }else  if($ext == "pdf" || $ext == "txt"){                   
                    ?>
                            <div class="span3"> 
                                <div class="d_img_outer_video_play" >
                                     <img  id="artifactOpen" style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $res['Uri'];?>" data-format="<?php  echo $ext;?>" id="pdfdivid"/>
        
                                </div>  
                            </div>
                    <?php }else{ ?> 
                            <div class="span3"> 
                                <div class="">
                                     <a href="/post/fileopen/?file=<?php  echo $res['Uri'];?>"  id="downloadAE"><img  id="artifactOpen" style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $res['Uri'];?>" data-format="<?php  echo $ext;?>" id="pdfdivid"/> </a>    
        
        </div>
                            </div>
                            
                        <?php  }
                    
                    
                        } }?>
                    
                            </div>
                            </div>
        </div>
                 <?php  } ?>
              <div class="social_bar social_bar_detailed" data-id="<?php  echo $data->_id ?>" data-postid="<?php  echo $data->_id ?>" data-categoryType="<?php  echo $categoryType;?>" data-networkId="<?php  echo $data->NetworkId; ?>">	
                  <?php if($categoryType!=10){?> 
                <a ><i><img  src="/images/system/spacer.png"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Invite'); ?>" class="tooltiplink cursor invite_frds" id="invitefriendsDetailed" data-postid="<?php  echo $data->_id ?>"></i></a>
                  <?php }?>
                <a class="follow_a"><i><img src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php  echo in_array($UserId, $data->Followers)>0?'UnFollow':'Follow';?>" class="<?php  echo in_array($UserId, $data->Followers)>0?'follow':'unfollow';?>" id="detailedfolloworunfollow" data-postid="<?php  echo $data->_id ?>" data-catogeryId="<?php  echo $categoryType;?>"></i><b id="streamFollowUnFollowCount_<?php  echo $data->_id; ?>"><?php  echo count($data->Followers) ?></b></a>
                <?php if($categoryType<3){
                    $IsFbShare = isset($data->FbShare) && is_array($data->FbShare)?in_array($UserId, $data->FbShare):0;
                    $IsTwitterShare = isset($data->TwitterShare) && is_array($data->TwitterShare)?in_array($UserId, $data->TwitterShare):0;

                    if(!$IsTwitterShare || !$IsFbShare){?>
                <span class="sharesection"><i class="tooltiplink" data-toggle="dropdown" rel="tooltip" data-original-title="Share" data-placement="bottom"><img src="/images/system/spacer.png"  class="share"  ></i><b id="streamShareCount_<?php  echo $data->_id; ?>"><?php  echo $ShareCount;?></b>
                    <div class="dropdown-menu actionmorediv">
                         <ul id="share_<?php echo $data->_id; ?>">
                             <?php if(!$IsFbShare){ ?>
                             <li><a onclick="prepareWallPostData('<?php  echo $data->_id ?>','<?php  echo $categoryType;?>','<?php  echo $data->_id;?>','postDetail')"><i class="fa fa-facebook"></i> Facebook</a></li>
                             <?php }if(!$IsTwitterShare){ ?>
                             <li ><a onclick="getTweetLink('<?php  echo $data->_id ?>','<?php  echo $categoryType;?>','<?php  echo $data->_id;?>','postDetail')"><i class="fa fa-twitter"></i> Twitter</a></li>
                             <?php } ?>
                        </ul>
                    </div>
                 </span>
                <?php }else{?>
                    <span class="sharesection"><i class="tooltiplink" data-toggle="dropdown" rel="tooltip" data-original-title="Share" data-placement="bottom"><img src="/images/system/spacer.png"  class="sharedisable"  ></i><b id="streamShareCount_<?php  echo $data->_id; ?>"><?php  echo $ShareCount;?></b></span>
                <?php }} ?>
                <span class="cursor"><i><img  class=" <?php  $isLoved = in_array($UserId, $data->Love); if($isLoved){ echo"likes";  }else{ echo"unlikes";};?> " data-placement="bottom" rel="tooltip"  data-original-title="Love"  src="/images/system/spacer.png" id="detailedLove" data-postid="<?php  echo $data->_id ?>" data-catogeryId="<?php  echo $categoryType;?>"></i><b id="detailedLoveCount"><?php  echo count($data->Love); ?></b></span>
  <?php   if(!$data->DisableComments){
                
                if(count($data->Comments)>0){
                    foreach ($data->Comments as $key=>$value) {
                        if (!(isset($value ['IsBlockedWordExist']) && $value ['IsBlockedWordExist']==1)) {
                            $count++;
                        }
                    }
                }
      ?>
                <span><i><img src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="Comment" class="detailedComment tooltiplink cursor  <?php   if($data->Type!=5){?>comments<?php  }else{?>comments1<?php  }?>"  id="detailedComment"  data-postid="<?php  echo $data->_id ?>"></i><b id="commentCount_<?php  echo $data->_id ?>"><?php  echo $count; ?></b></span>
                  <?php  }?>              </div>
              </li>
              </ul>
             
          </div>
          
        </div>
        
          <div class="commentbox <?php  if($data->Type==5){?>commentbox2<?php  }?> " id="cId_<?php   echo $data->_id; ?>" style="display:<?php  echo count($data->Comments)>0?'block':'none';?>">
              <div id="commentSpinLoader_<?php  echo $data->_id; ?>"></div>
            
              <div  id="CommentBoxScrollPaneTest" >
              <div id="commentbox_<?php   echo $data->_id; ?>" style="display:<?php   echo count($data->Comments)>0?'block':'none';?>">
      <div id="commentsAppend_<?php   echo $data->_id; ?>"></div>
              <?php  if(count($data->Comments)>0){ $commentsCnt = 0;?>
              
 <?php  foreach ($commentsdata as $key => $value) {
    ?>

    <div class="commentsection" id="comment_<?php  echo $value->PostId ?>_<?php  echo $value->CommentId ?>">
          <div class="row-fluid commenteddiv">
          <div class="span12">
                 <div class=" stream_content">
                <ul>
                    <li class="media overfolw-inherit">

                       <?php   if(count($value->Resource) >0){?>
                        <div class="padding5">
        
        <div class="chat_subheader ">Artifacts</div>

                    
          
        
         
        <div class="row-fluid padding8top detailed_media">
                            <div class="span12">
                               <?php  
                               $i = 0;
                    foreach($value->Resource as $art){
                        
                           $extType = strtolower($art['Extension']);
//                            if($extType=='ppt'||$extType=='pptx'){
//                             $image="/images/system/PPT-File-icon.png";
//                        }else if($extType=='pdf'){
//                         $image="/images/system/pdf.png";
//                    }else if($extType=='doc' || $extType=='docx'){
//                         $image="/images/system/MS-Word-2-icon.png";
//                    }else if($extType=='exe' || $extType=='xls'|| $extType=='xlsx'|| $extType=='ini'){
//                         $image="/images/system/Excel-icon.png";
//                    } else if ($extType == 'txt') {
//                            $image = "/images/system/notepad-icon.png";
//                    }
                            if(isset($art['ThumbNailImage'])){
                               $image=$art['ThumbNailImage'];
                           }else{
                               $image="";
                           }
                        if($extType == "mp3"){?>
                                <?php  if($i == 0){ $i++; $class="d_img_outer_video"; }else{$class="";}?>
                            <div class="span3"> 

                                <div class="d_img_outer_video_play" >

                                <img style="cursor:pointer;" src="/images/system/audio_img.png" data-uri="<?php  echo $art['Uri'];?>" data-format="<?php  echo $extType;?>" id="videodivid"/>
                            </div>
                            </div>
                    
                      <?php  }else if($extType == "mp4" || $extType == 'flv' || $extType == 'mov'){
                          
                          $videoclassName = 'PostdetailvideoThumnailDisplay';
                          
                          ?>
                               <?php  if($i == 0){ $i++; $class="d_img_outer_video"; }else{$class="";}?>
                            <div class="span3"> 

                                <div class="d_img_outer_video_play" style="cursor:pointer;" ><div  class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div>

                                <img style="cursor:pointer;" src='<?php echo $image;?>' data-uri="<?php  echo $art['Uri'];?>" data-format="<?php  echo $extType;?>" id="videodivid"/>
                            </div>
                            </div>
                        <?php  }else  if($extType == "jpg" || $extType == "png" || $extType == "jpeg" || $extType == "giff"){?>
                            <div class="span3">    
                               <div class="d_img_outer_video_play" id="comment_artifactOpen">
                                    <?php if($categoryType=='3'){ ?>
                                    <img style="cursor:pointer;" src="<?php  echo str_replace('/upload/public/thumbnails/','/upload/group/images/',$art['Uri']);?>" data-uri="<?php  echo str_replace('/upload/public/thumbnails/','/upload/group/images/',$art['Uri']);?>" id="commentImageDiv" data-format="<?php  echo $extType;?>" class="imageimgdivid"/>
                                    <?php }else{?>
                                    
                                      <img style="cursor:pointer;" src="<?php  echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$art['Uri']);?>" data-uri="<?php  echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$art['Uri']);?>" id="commentImageDiv" data-format="<?php  echo $extType;?>" class="imageimgdivid"/>
                                    
                                    <?php } ?>
                                
                                </div>
                            </div>
                        <?php  }else if($extType == "pdf" || $extType == "txt"){ ?>
                                <div class="span3"> 
                                <div class="d_img_outer_video_play" >
                                     <img  id="artifactOpen" style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $art['Uri'];?>" data-format="<?php  echo $extType;?>" id="pdfdivid"/>
                                </div>  
                            </div>
                        <?php  }else{ ?>
                            
                            <div class="span3">     
                                <div class="">
                               <a href="/post/fileopen/?file=<?php  echo $art['Uri'];?>"  id="downloadAE"><img  id="artifactOpen" style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $art['Uri'];?>" data-format="<?php  echo $extType;?>" id="pdfdivid"/> </a>          
                               
                            </div>
                            </div>
                            
                     <?php  } }?>
                    
                
                            
                            </div>
                            </div>
                        </div>
                        
                        
                             <?php    } ?> 
                            
                            
                            
                <div class="media-body overfolw-inherit" >
                    <div class="positionrelative padding-right30 streampostactions">
                        <?php if($value->IsBlockedWordExist==1){ ?>
                        <div class="postmg_actions">
                            <i data-placement="right" data-toggle="dropdown" class="fa fa-chevron-down"></i>
                            <i data-placement="right" data-toggle="dropdown" class="fa fa-chevron-up"></i>
                            <div id="CommentBlockOrRemove" class="dropdown-menu ">
                                <ul class="PostManagementActions abusedPosts" data-postId="<?php echo $value->PostId ?>" data-commentId="<?php echo $value->CommentId ?>" data-categoryType="<?php echo $value->CategoryType ?>" data-networkId="<?php echo $NetworkId ?>">
                                    <li><a name="Block" class="Block"><span class="blockicon"><img src="/images/system/spacer.png"></span> Block</a></li>
                                    <li><a name="Release" class="Release"><span class="releaseicon"><img src="/images/system/spacer.png"></span> Release</a></li>
                                </ul>

                            </div>
                        </div>
                        <?php } ?>
                        <div id="comment_text" data-id="<?php  echo $data->_id; ?>"><?php echo $value->CommentText; ?></div>

                        <div class="media">
                            <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <img   src="<?php echo $value->ProfilePic; ?> ">  
                  
                  </a>
                     </div>
                            <div class="media-body">
                                <span class="m_day"><?php echo $value->PostOn; ?></span>
                                <div class="m_title"><a <a class="userprofilename"  data-id="<?php echo $value->UserId; ?>" style="cursor:pointer"><?php echo $value->DisplayName; ?></a></div>
                            </div>
                        </div>
                        <?php if(isset($value->IsWebSnippetExist)&& $value->IsWebSnippetExist=='1'){     ?>           

                <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;">
                                 <div class="Snippet_div" style="position: relative">
                            <?php if(isset($value->snippetdata['Weburl'])&& ($value->snippetdata['Weburl']!="")){ ?>      
                                    <a href="<?php 
                                         echo $value->snippetdata['Weburl']; ?>" target="_blank">
                                            
                                        <?php if($value->snippetdata['WebImage']!=""){ ?>
                                             <span  class=" pull-left img_single e_img" style="width:100px;" ><img src="<?php echo $value->snippetdata['WebImage']; ?>"></span>
                                            <?php } ?>     
                                            <div class="media-body">                                   
                                              <label class="websnipheading" ><?php echo $value->snippetdata['WebTitle']; ?></label>
                                                      <a   class="websniplink" href="<?php echo $value->snippetdata['Weburl']; ?>" target="_blank">     <?php echo $value->snippetdata['WebLink']; ?> </a> 
                                               
                                                            <p><?php echo $value->snippetdata['Webdescription']; ?></p>
                                                    
                                                </div>
                                        </a>  
                            <?php } ?>
                                   
                                    </div>
                           </div>
                      
              <?php } ?>
                    </div>
                </div>
              </li>
                </ul>
            </div>
              
              
              
                      
               
              
               
              
          
          </div>
          </div>
  
                </div>
<?php } ?>
       
          
          </div>
         
        <?php  } ?>
              </div>
               <?php  if($count >5){ ?>
           <div class="viewmorecomments alignright">
                <span  id="viewmorecommentsDetailed" onclick="viewmoreCommentsIndetailedPage('/post/postComments','<?php   echo $data->_id ?>','<?php   echo $data->_id ?>','Streampost','<?php  echo $categoryType; ?>');">More Comments</span>
              </div>
      <?php   } ?>
              <div id="ArtifactSpinLoader_postupload_<?php  echo $data->_id?>"></div>
              <div id="newComment" style="display:none" class="paddinglrtp5">
        <div id="commentTextArea_<?php  echo $data->_id; ?>" class="inputor commentplaceholder" contentEditable="true" onkeyup="getsnipetForComment(event,this,'<?php echo $data->_id; ?>');"  onclick="OpenCommentbuttonArea('<?php echo $data->_id; ?>')"></div>
            <div id="commentTextAreaError_<?php  echo $data->_id; ?>" style="display: none;"></div>
            <div class="alert alert-error" id="commentTextArea_<?php  echo $data->_id; ?>_Artifacts_em_" style="display: none;"></div>
            <input type="hidden" id="artifacts" value=""/>
            <div id="preview_commentTextArea_<?php  echo $data->_id; ?>" class="preview" style="display:none">
                     <ul id="previewul_commentTextArea_<?php  echo $data->_id; ?>" class="imgpreview">
                         
                    </ul>

   
                 </div>
                          <div  id="snippet_main_<?php echo $data->_id; ?>" class="snippetdiv" style="" ></div>        
<div class="postattachmentarea" id="commentartifactsarea_<?php  echo $data->_id; ?>">
        <div class="pull-left whitespace">
<div class="advance_enhancement">
<ul>
                <li class="dropdown pull-left ">
                  <div id="postupload_<?php  echo $data->_id; ?>">
                  </div>
                 
                    </li>
                   
                     
                    </ul>
                         
    <a href="#" ></a> <a href="#" ><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
     </div>
    <div class="pull-right">
       
        <button id="savePostCommentButton" onclick="saveDetailedPostCommentByUserId('<?php   echo $data->_id; ?>','<?php   echo $data->Type;?>','<?php  echo $categoryType;?>','<?php   echo $data->NetworkId;?>','<?php   echo $data->_id; ?>','postDetailed');" class="btn" data-loading-text="Loading..."><?php echo Yii::t('translation','Comment'); ?></button>
        <button id="cancelPostCommentButton" data-postid="<?php  echo $data->_id ?>"  class="btn btn_gray"> <?php echo Yii::t('translation','Cancel'); ?></button>

    </div></div>
            <div style="display:<?php   echo count($data->Comments)>0?'block':'none';?>" class="postattachmentareaWithComments"> <img src="/images/system/spacer.png" />
                </div>
</div>
              
          </div>
        </div>
    
    </div>

 
<?php          
        }
?>


 

 
