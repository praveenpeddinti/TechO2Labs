<?php if(is_object($comments) && $isBlocked == 0){ ?>
    
  <div class="commentsection commentsectionpaddingzero">
          <div class="row-fluid commenteddiv">
          <div class="span12">
              <?php if($comments->CommentId!=""){
                        $commentId = $comments->CommentId;
                        $streamId = $comments->streamId;
                        $postId = $comments->PostId;
                        $categoryType = $comments->CategoryType;
                        $networkId = "";
                        include Yii::app()->basePath . '/views/includes/comment_management_actions.php'; 
                    }
                    $replacePath="";
                    if($categoryType != 3) {
                        $replacePath = '/upload/public/images/';
                    } else {
                        $replacePath = '/upload/group/images/';
                    }
                    ?>
                 <div class=" stream_content">
                <ul>
                    <li class="media">
          
          <?php if (!empty($comments->Resource) && sizeof($comments->Resource) > 0){
             
                $Resouce = $comments->Resource;
              ?>
      

                  </a>
<!--                  </div>-->
                
                
            
        

                       <?php  
                       
            foreach($comments->Resource  as $key=>$res){

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
                                      if($categoryType!=3){
                                          $CommentResourceUriArray[$key]=str_replace('/upload/public/thumbnails/','/upload/public/images/',$res['Uri']);
                                      }else{
                                          $CommentResourceUriArray[$key]=str_replace('/upload/public/thumbnails/','/upload/group/images/',$res['Uri']);
                                      }
                                     
                                } else if ($ext == "pdf" || $ext == "txt" || $ext == 'doc' || $ext == 'xls' || $ext == "ppt" || $ext == 'docx' || $ext == 'xlsx') {
                                    $CommentResourceArray[$key] = $image;
                                     $CommentResourceUriArray[$key]=$res['Uri'];
                                } else {
                                    $CommentResourceArray[$key] = $image;
                                     $CommentResourceUriArray[$key]=$res['Uri'];
                                }
                               
                         }
                
                 }?>


                
<!--          <div class="postartifactsdiv padding5">       -->
             <div class="pull-left multiple "> 
            <?php  
            $i = 0;
            if (sizeof($comments->Resource) > 2) { ?>
            <div class="img_more1"></div>
            <div class="img_more2"></div>
            <?php } ?>
            <a  class="pull-left pull-left1 img_more ">
                <?php $extType = strtolower($comments->Resource[0]['Extension']);
                            if(isset($comments->Resource[0]['ThumbNailImage'])){
                               $image=$comments->Resource[0]['ThumbNailImage'];
                           }else{
                               $image="";
                           }
                        if($extType == "mp3"){?>
                                <?php  if($i == 0){ $i++; $class="d_img_outer_video"; }else{$class="";}?>

                                <div class="d_img_outer_video_play_postdetail" >

                                <img style="cursor:pointer;" src="/images/system/audio_img.png" data-uri="<?php  echo $comments->Resource[0]['Uri'];?>" data-format="<?php  echo $extType;?>" id="videodivid"/>
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

                                <img style="cursor:pointer;" src='<?php echo $image;?>' data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>" data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>" data-uri="<?php  echo $comments->Resource[0]['Uri'];?>" data-format="<?php  echo $extType;?>" id="videodivid"/>
                            </div>
                      
                        <?php  }else  if($extType == "jpg" || $extType == "png" || $extType == "jpeg" || $extType == "gif"){?>
                            
                               <div class="d_img_outer_video_play_postdetail" id="comment_artifactOpen">
                                    <?php if($categoryType=='3' || $categoryType=='7'){ ?>
                                    <img style="cursor:pointer;" src="<?php  echo str_replace('/upload/public/thumbnails/','/upload/group/images/',$comments->Resource[0]['Uri']);?>" data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>" data-uri="<?php  echo str_replace('/upload/public/thumbnails/','/upload/group/images/',$comments->Resource[0]['Uri']);?>" id="commentImageDiv" data-format="<?php  echo $extType;?>" class="imageimgdivid"/>
                                    <?php }else{?>
                                    
                                      <img style="cursor:pointer;" src="<?php  echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$comments->Resource[0]['Uri']);?>" data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>" data-uri="<?php  echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$comments->Resource[0]['Uri']);?>" id="commentImageDiv" data-format="<?php  echo $extType;?>" class="imageimgdivid"/>
                                    
                                    <?php } ?>
                                
                                </div>
                        
                        <?php  }else if($extType == "pdf" || $extType == "txt" || $extType=='doc' || $extType=='xls' || $extType == "ppt" || $extType=='docx' || $extType=='xlsx'){ ?>
                               
                                <div class="d_img_outer_video_play_postdetail" >
                                     <img  style="cursor:pointer;" src="<?php echo $image;?>"  data-src="<?php echo implode(',', $CommentResourceArray); ?>" data-srcuri="<?php echo implode(',', $CommentResourceUriArray); ?>" data-uri="<?php  echo $comments->Resource[0]['Uri'];?>" data-format="<?php  echo $extType;?>" id="pdfdivid"/>
                                </div>  
                       
                        <?php  }else{ ?>
                            
                            <div class="span3">     
                                <div class="">
                               <a href="/post/fileopen/?file=<?php  echo $comments->Resource[0]['Uri'];?>"  id="downloadAE"><img   style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $comments->Resource[0]['Uri'];?>" data-format="<?php  echo $extType;?>" id="pdfdivid"/> </a>          
                               
                            </div>
                            </div>
                            
                     <?php  } ?>
                             </a>
        </div>
<!--                        </div>      -->
         
                
                
                
              
          <?php } ?>
          <div id="stream_view_commentscript_spinner_<?php echo $comments->PostId; ?>"></div>
                     <div class="media-body">
                  
          <div id="comment_new_text" class="bulletsShow"><?php echo $comments->CommentText; ?></div>
                 
          <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <img   src="<?php echo $comments->ProfilePic; ?>">  
                  
                  </a>
                     </div>
                  
                  <div class="media-body">
                   <span class="m_day"> few sec ago</span>
                   <div class="m_title"><a <a class="userprofilename"  data-id="<?php echo $comments->UserId; ?>" style="cursor:pointer"><?php echo $comments->DisplayName; ?></a></div>
                   </div>
                
                     </div>
          <!-- Web snippet .. -->
          <?php if($comments->IsWebSnippetExist == 1){ ?>
          
            <div style="position: relative" class="Snippet_div">
                <?php $snippet = $comments->snippetdata; ?>
                              
                                      <div class="row-fluid">
                                          <div class="span12">
                                              <div class="span3">
                                                <a href="<?php echo $snippet['WebLink']; ?>" target="_blank">   <img  style="width: 100px;height:100px" src="<?php echo $snippet['WebImage']; ?>"  class="e_img"/></a>
                                              </div> 
                                              <div class="span9">
                                                  <div class="paddinglr">
                                                  
                                                <label><?php echo $snippet['WebTitle']; ?></label>
                                                <label> <a href="<?php echo $snippet['WebLink']; ?>" target="_blank"><?php echo $snippet['WebLink']; ?> </a> </label>
                                                 <p><?php echo $snippet['Webdescription']; ?></p>
                                                  </div>
                                              </div>
                                              
                                          </div>
                                          
                                      </div>
                    
            </div>
          <?php }  // end IsWebSnippetExist?>
           
        
                
                    </li>
                </ul>
                      </div>
                     </div>
              </div></div>
        
<?php  }else 
    echo "Blocked"; 
?>
