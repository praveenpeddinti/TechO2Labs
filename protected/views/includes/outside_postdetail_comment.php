
              <div  id="CommentBoxScrollPaneTest" >
              <div id="commentbox_<?php   echo $data->_id; ?>" style="display:<?php   echo count($data->Comments)>0?'block':'none';?>">
      <div id="commentsAppend_<?php  echo $data->_id; ?>"></div>
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
        
        <div class="chat_subheader "><?php echo Yii::t('translation','Artifacts'); ?></div>

                    
          
       
         
        <div class="row-fluid padding8top detailed_media">
                            <div class="span12">
                               <?php  
                               $i = 0;
                    foreach($value->Resource as $art){
                        
                           $extType = strtolower($art['Extension']);
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
                                    <li><a name="Block" class="Block"><span class="blockicon"><img src="/images/system/spacer.png"></span> <?php echo Yii::t('translation','Block'); ?></a></li>
                                    <li><a name="Release" class="Release"><span class="releaseicon"><img src="/images/system/spacer.png"></span> <?php echo Yii::t('translation','Release'); ?></a></li>
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
                                                 <label class="websnipheading" > <?php echo $value->snippetdata['WebTitle'] ?> </label>
                                                     <a class="websniplink" href="<?php echo $value->snippetdata['Weburl']; ?>" target="_blank"> <?php echo $value->snippetdata['WebLink']; ?></a>
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