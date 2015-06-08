<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
foreach ($data as $key => $value) {
    ?>

    <div class="commentsection commentsectionpaddingzero" id="comment_<?php  echo $value->PostId ?>_<?php  echo $value->CommentId ?>" style="position: relative">
          <div class="row-fluid commenteddiv"  id="comment_<?php echo $value->CommentId; ?>" >
              <div id="commentSpinLoader_<?php  echo $value->CommentId; ?>"></div>
          <div class="span12" style="margin-left: 0">
              <?php $commentId = $value->CommentId;
                    $streamId = $streamId;
                    $postId = $value->PostId;
                    $categoryType = $value->CategoryType;
                    $networkId = $NetworkId;
                    include Yii::app()->basePath . '/views/includes/comment_management_actions.php'; 
                ?>
                 <div class=" stream_content">
                <ul>
                    <li class="media ">

          <?php 
          if($value->PageType=='stream'){
          
          if(count($value->Resource)!=0){
              if($value->ResourceLength > 1){
                  $class="pull-left pull-left1  img_more postdetail";
              }else{
                   $class="pull-left img_single postdetail";
              }
              
              ?>
             <?php  if($value->ResourceLength > 1){ ?>            <div class="pull-left multiple "> 
                                    <div class="img_more1"></div>
                                    <div class="img_more2"></div>
             <?php } ?>
   <a  class="<?php echo $class;?>"  data-profile="<?php echo $profile; ?>"  data-id='<?php  echo $streamId; ?>' data-posttype="<?php echo $value->Type;?>"   data-categorytype="<?php echo $value->CategoryType;?>"   data-postid="<?php echo $value->PostId;?>"  >
                           
     <?php 
      
        $extension=$value->Resource['Extension'];
      if(isset($value->Resource['ThumbNailImage'])){
          $thumnailImage=$value->Resource['ThumbNailImage'];
      }else{
          $thumnailImage="";
      }
      
      ?> 
                <?php  if($extension == "mp4" || $extension == 'flv' || $extension == 'mov'){ ?>
                 
                <div class='videoThumnailDisplay'><img src="/images/icons/video_icon.png"></div>
          <?php } ?>
                <img id="comment_new_photo" src="<?php echo $thumnailImage;?>"  />                 
                                
                  </a> <?php  if($value->ResourceLength > 1){ ?>    </div> <?php } ?>
          <?php }}else{?>
                        
            <?php   if(count($value->Resource) >0){?>
                        <div class="padding5">
        
        <div class="chat_subheader "><?php echo Yii::t('translation','Artifacts'); ?></div>

                    
          
        
         
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
//                    }else if($extType=='exe' || $extType=='xls'|| $extType=='ini'){
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
                                <div class="d_img_outer_video_play">
                                <img style="cursor:pointer;" src="/images/system/audio_img.png" data-uri="<?php  echo $art['Uri'];?>" data-format="<?php  echo $extType;?>" id="videodivid"/>
                            </div>
                            </div>
                    
                      <?php  }else if($extType == "mp4" || $extType == 'flv' || $extType == 'mov'){
                          $videoclassName = 'PostdetailvideoThumnailDisplay';
                          ?>
                               <?php  if($i == 0){ $i++; $class="d_img_outer_video"; }else{$class="";}?>
                            <div class="span3"> 
                               <div class="d_img_outer_video_play"><div  class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div>
                                <img style="cursor:pointer;" src="/images/system/video_img.png" data-uri="<?php  echo $art['Uri'];?>" data-format="<?php  echo $extType;?>" id="videodivid"/>
                            </div>
                            </div>
                        <?php  }else  if($extType == "jpg" || $extType == "png" || $extType == "jpeg" || $extType == "giff"){?>
                            <div class="span3">    
                               <div class="d_img_outer_video_play" id="comment_artifactOpen">
                                    <?php if($value->CategoryType=='3'){ ?>
                                    <img style="cursor:pointer;" src="<?php  echo str_replace('/upload/public/thumbnails/','/upload/group/images/',$art['Uri']);?>" data-uri="<?php  echo str_replace('/upload/public/thumbnails/','/upload/group/images/',$art['Uri']);?>" id="commentImageDiv" data-format="<?php  echo $extType;?>" class="imageimgdivid"/>
                                    <?php }else{?>
                                    
                                      <img style="cursor:pointer;" src="<?php  echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$art['Uri']);?>" data-uri="<?php  echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$art['Uri']);?>" id="commentImageDiv" data-format="<?php  echo $extType;?>" class="imageimgdivid"/>
                                    
                                    <?php } ?>
                                
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
                                       
                        
          <?php }?>         
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
                        <div class="bulletsShow" id="post_content_total_<?php echo $value->CommentId; ?>"  style="display:none">

                            <?php  
                                  echo $value->CommentFullText;
                             ?>
                                </div>
                        <div class="bulletsShow" data-postid="<?php echo $postId; ?>" data-id="<?php echo $streamId;?>" id="post_content_<?php echo $value->CommentId; ?>" data-categoryType="<?php echo $value->CategoryType;?>">
                            <?php echo $value->CommentText; ?>
                        </div>
                        <?php 
                            $translate_fromLanguage = $value->Language;
                            $translate_class = "commenttranslatebutton";
                            $translate_id = $value->CommentId;
                            $translate_postId = $postId;
                            $translate_postType = $postType;
                            $translate_categoryType = $categoryType;
                            include Yii::app()->basePath . '/views/common/translateButton.php'; 
                        ?>
                        
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
                         </div>
                      </div>
                        <?php if( $value->IsWebSnippetExist=='1'){     ?>           

                        
                        
                        <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;clear:both;">
                                 <div class="Snippet_div" style="position: relative">

                                        <a href="<?php echo $value->snippetdata['Weburl']; ?>" target="_blank">
                                            <?php if($value->snippetdata['WebImage']!=""){ ?>
                            <span  class=" pull-left img_single e_img" style="width:100px;" ><img src="<?php echo $value->snippetdata['WebImage']; ?>"></span>
                                            <?php } ?>
                                            <div class="media-body">                                   
                                                    

                                                   <label class="websnipheading" ><?php echo $value->snippetdata['WebTitle']; ?></label>
                                                      <a   class="websniplink" href="<?php echo $value->snippetdata['Weburl']; ?>" target="_blank">     <?php echo $value->snippetdata['WebLink']; ?> </a> 
                                               
                                                        <p><?php echo $value->snippetdata['Webdescription']; ?></p>
                                                    
                                                </div>
                                        </a>
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
    