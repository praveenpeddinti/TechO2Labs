<div  id="CommentBoxScrollPaneTest" >
              <div id="commentbox_<?php   echo $data->_id; ?>" style="display:<?php   echo $data->CommentCount>0?'block':'none';?>">
      <div id="commentsAppend_<?php   echo $data->_id; ?>"></div>
              <?php  if($data->CommentCount>0){ $commentsCnt = 0;?>
              
 <?php  foreach ($data->Comments as $key => $value) {
    ?>

    <div class="commentsection commentsectionpaddingzero" id="comment_<?php  echo $value->PostId ?>_<?php  echo $value->CommentId ?>">
        <div id="commentSpinLoader_<?php  echo $value->CommentId; ?>"></div>  
        <div class="row-fluid commenteddiv"  id="comment_<?php echo $value->CommentId; ?>" >
          <div class="span12">
              <?php $commentId = $value->CommentId;
                    $streamId = $data->_id;
                    $postId = $value->PostId;
                    $categoryType = $value->CategoryType;
                    $networkId = $data->NetworkId;
                    include Yii::app()->basePath . '/views/includes/comment_management_actions.php'; 
                ?>
                 <div class=" stream_content">
                <ul>
                    <li class="media">

                       <?php   if(count($value->Resource) >0){?>
                        <div class="padding5">
        
<!--        <div class="chat_subheader ">Artifacts</div>

                    
          
        
         
        <div class="row-fluid padding8top detailed_media">
                            <div class="span12">-->
                                
                             <?php 
                         
                          $CommentResourceArray=array();
                          $CommentResourceUriArray=array();
                         foreach($value->Resource as $key => $res){
                             
                             if (isset($res['Extension'])) {
                                 $ext = strtolower($res['Extension']);

                                 if (isset($res['ThumbNailImage'])) {
                                     $image = $res['ThumbNailImage'];
                                 } else {
                                     $image = "";
                                 }
                                 
                             
                                if ($ext == "mp3") {

                                    $CommentResourceArray[$key] = "/images/system/audio_img.png";
                                     $CommentResourceUriArray[$key]=$res['Uri'];
                                } else if ($ext == "mp4" || $ext == 'flv' || $ext == 'mov') {

                                    $CommentResourceArray[$key] = $image;
                                     $CommentResourceUriArray[$key]=$res['Uri'];
                                } else if ($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif") {
                                    $CommentResourceArray[$key] = $res['Uri'];
                                    if($categoryType ==3){
                                        $CommentResourceUriArray[$key]=str_replace('/upload/public/thumbnails/','/upload/group/images/',$res['Uri']);
                                    }else{
                                        $CommentResourceUriArray[$key]=str_replace('/upload/public/thumbnails/','/upload/public/images/',$res['Uri']);
                                    }
                                     
                                } else if ($ext == "pdf" || $ext == "txt" || $ext == 'doc' || $ext == 'xls' || $ext == "ppt" || $ext == 'docx' || $ext == 'xlsx') {
                                    $CommentResourceArray[$key] = $image;
                                     $CommentResourceUriArray[$key]=$res['Uri'];
                                } else {
                                    $CommentResourceArray[$key] = $image;
                                     $CommentResourceUriArray[$key]=$res['Uri'];
                                }
                               
                         }
                         }

                         ?>
                                
                                
                                
                       
                    
             <div class="pull-left multiple "> 
            <?php  
            $i = 0;
            if (sizeof($value->Resource) > 1) { ?>
            <div class="img_more1"></div>
            <div class="img_more2"></div>
            <?php } ?>
            <a  class="pull-left pull-left1 img_more ">
                <?php $extType = strtolower($value->Resource[0]['Extension']);
                            if(isset($value->Resource[0]['ThumbNailImage'])){
                               $image=$value->Resource[0]['ThumbNailImage'];
                           }else{
                               $image="";
                           }
                        if($extType == "mp3"){?>
                                <?php  if($i == 0){ $i++; $class="d_img_outer_video"; }else{$class="";}?>

                                <div class="d_img_outer_video_play_postdetail" >

                                <img style="cursor:pointer;" src="/images/system/audio_img.png" data-uri="<?php  echo $value->Resource[0]['Uri'];?>" data-format="<?php  echo $extType;?>" id="videodivid"/>
                            </div>
                         
                    
                      <?php  }else if($extType == "mp4" || $extType == 'flv' || $extType == 'mov'){
                          
                       if($categoryType!=3){
                             $videoclassName = 'PostdetailvideoThumnailDisplay PD artifactdetailCV';
                         }else{
                              $videoclassName = 'GroupPostdetailvideoThumnailDisplay PD artifactdetailCV';
                         }
                          
                          
                          ?>
                               <?php if($i == 0){ $i++; $class="d_img_outer_video"; }else{$class="";}?>
                                <div class="d_img_outer_video_play_postdetail" style="cursor:pointer;" ><div  class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div>

                                <img style="cursor:pointer;" src='<?php echo $image;?>' data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>"   data-uri="<?php  echo $value->Resource[0]['Uri'];?>" data-format="<?php  echo $extType;?>" id="videodivid"/>
                            </div>
                      
                        <?php  }else  if($extType == "jpg" || $extType == "png" || $extType == "jpeg" || $extType == "gif"){?>
                            
                               <div class="d_img_outer_video_play_postdetail" id="comment_artifactOpen">
                                    <?php if($categoryType=='3' || $categoryType=='7'){ ?>
                                    <img style="cursor:pointer;"  data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>"  src="<?php  echo str_replace('/upload/public/thumbnails/','/upload/group/images/',$value->Resource[0]['Uri']);?>" data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>" data-uri="<?php  echo str_replace('/upload/public/thumbnails/','/upload/group/images/',$value->Resource[0]['Uri']);?>" id="commentImageDiv" data-format="<?php  echo $extType;?>" class="imageimgdivid"/>
                                    <?php }else{?>
                                    
                                      <img style="cursor:pointer;"  data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>"  src="<?php  echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$value->Resource[0]['Uri']);?>" data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>" data-uri="<?php  echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$value->Resource[0]['Uri']);?>" id="commentImageDiv" data-format="<?php  echo $extType;?>" class="imageimgdivid"/>
                                    
                                    <?php } ?>
                                
                                </div>
                        
                        <?php  }else if($extType == "pdf" || $extType == "txt" || $extType=='doc' || $extType=='xls' || $extType == "ppt" || $extType=='docx' || $extType=='xlsx'){ ?>
                               
                                <div class="d_img_outer_video_play_postdetail" >
                                     <img  style="cursor:pointer;" src="<?php echo $image;?>"  data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>"  data-uri="<?php  echo $value->Resource[0]['Uri'];?>" data-format="<?php  echo $extType;?>" id="pdfdivid"/>
                                </div>  
                       
                        <?php  }else{ ?>
                            
                            <div class="span3">     
                                <div class="">
                               <a href="/post/fileopen/?file=<?php  echo $value->Resource[0]['Uri'];?>"  id="downloadAE"><img   style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $value->Resource[0]['Uri'];?>" data-format="<?php  echo $extType;?>" id="pdfdivid"/> </a>          
                               
                            </div>
                            </div>
                            
                     <?php  } ?>
                             </a>
        </div>
                        </div>
<!--                            </div>
                            </div>
                        </div>-->
                        
                        
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
                        <div id="comment_text_<?php  echo $value->CommentId; ?>"  class="bulletsShow"  data-id="<?php  echo $data->_id; ?>">
                            <?php 
                            echo $value->CommentText; ?>
                        </div>
                        <?php 
                            $translate_fromLanguage = $value->Language;
                            $translate_class = "commenttranslatebutton_postdetail";
                            $translate_id = $value->CommentId;
                            $translate_postId = $value->PostId;
                            $translate_postType = $data->Type;
                            $translate_categoryType = $value->CategoryType;
                            include Yii::app()->basePath . '/views/common/translateButton.php'; 
                        ?>
                        <div class="media">
                            <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a  class="skiptaiconinner">
                       <img   src="<?php echo $value->ProfilePic; ?> "> 
                  
                  </a>
                     </div>
                            <div class="media-body">
                                <span class="m_day"><?php echo $value->PostOn; ?></span>
                                <div class="m_title"><a <a class="userprofilename"  data-id="<?php echo $value->UserId; ?>" style="cursor:pointer"><?php echo $value->DisplayName; ?></a></div>
                            </div>
                        </div>
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
                                            <?php } ?>  </a>   
                                            <div class="media-body">  
                                                <label class="websnipheading" ><?php echo $value->snippetdata['WebTitle']; ?></label>
                                                      <a   class="websniplink" href="<?php echo $value->snippetdata['Weburl']; ?>" target="_blank">     <?php echo $value->snippetdata['WebLink']; ?> </a> 
                                               
                                                            <p><?php echo $value->snippetdata['Webdescription']; ?></p>
                                                    
                                                </div>
                                         
                            <?php } ?>
                                   
                                    </div>
                           </div>
                      
              <?php } ?>
                   
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