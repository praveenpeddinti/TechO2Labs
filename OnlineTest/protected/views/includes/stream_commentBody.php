<?php 
$commentssize = 2;
if($data->PostType == 5 && $translate_categoryType == 2){ // for curbside only
    $commentssize = 1;     
}
         $style="display:none";
        if(sizeof($data->Comments)>0){
         
            if(sizeof($data->Comments)>$commentssize){
                 $style="display:block";
            }
           
         $maxDisplaySize = sizeof($data->Comments)>= $commentssize?$commentssize:sizeof($data->Comments);                
            for($j=sizeof($data->Comments);$j>sizeof($data->Comments)-$maxDisplaySize;$j--){
                if($commentssize > 1) 
                    $comment=$data->Comments[$j-1];
                else
                    $comment=$data->Comments[0]; // for curbside only we are showing one comment....
                ?>
          <div class="commentsection commentsectionpaddingzero">
              <div id="commentSpinLoader_<?php  echo $comment['CommentId']; ?>"></div>
          <div class="row-fluid commenteddiv"  id="comment_<?php echo $comment['CommentId']; ?>" >
          <div class="span12 positionrelative">
              <?php 
                    $commentId = $comment['CommentId'];
                    $streamId = $data->_id;
                    $postId = $data->PostId;
                    $categoryType = $data->CategoryType;
                    $networkId = $data->NetworkId;
                    include Yii::app()->basePath . '/views/includes/comment_management_actions.php'; 
                ?>
                 <div class=" stream_content">
                <ul>
                    <li class="media">
              <?php  if($comment["NoOfArtifacts"]>0){
                  $commentID = $comment['CommentId'];
                  $extension = "";
                   $extension = strtolower($comment['Artifacts']["Extension"]);
                            $videoclassName="";
                             if($extension == 'mp4' || $extension == 'flv' || $extension == 'mov') {
                                      $videoclassName = 'videoThumnailDisplay';
                                    
                                }else {
                                    $videoclassName='videoThumnailNotDisplay';
                                }
                  
                  
              
              ?>
             
                        <?php  if($comment['NoOfArtifacts']==1){$commentID = $comment['CommentId'];
                            foreach($commentID as $id){
                                $commentID = $id;
                            }
                            ?>
                        <?php
                                $className = ""; 
                                $uri = "";
                                $extension = "";
                                $imageVideomp3Id = "";
                                $extension = strtolower($comment['Artifacts']["Extension"]);
                                if($extension == "mp4" || $extension == "avi" || $extension == "flv" || $extension == "mov" || $extension == "mp3" ){ 
                                    $className = "videoimage";
                                    $uri = $comment['Artifacts']["Uri"];
                                    $imageVideomp3Id = "imageVideomp3_$commentID";
                                }else{
                                    $className = "postdetail";                                
                                }
                                if($extension == 'mp4' || $extension == 'flv' || $extension == 'mov') {
                                      $videoclassName = 'videoThumnailDisplay';
                                    
                                }else {
                                    $videoclassName='videoThumnailNotDisplay';
                                }
                            ?>
                            <?php if(!empty($imageVideomp3Id)){ ?>
                            <div id="playerClose_<?php echo $commentID; ?>"  style="display: none;">
                                <div class="videoclosediv alignright"><button aria-hidden="true"  data-dismiss="modal" onclick="closeVideo('<?php echo $commentID; ?>');" class="videoclose" type="button">×</button></div>
                                <div class="clearboth"><div id="streamVideoDiv<?php echo $commentID; ?>"></div></div>
                            </div>
                            <?php } ?>  
                                <a id="imgsingle_<?php echo $commentID; ?>" class="postdetail pull-left img_single" <?php if($data->PostType==15){?>data-profile="<?php echo $data->PostCompleteText; ?>" <?php } ?> data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId;?>" data-categoryType="<?php echo $data->CategoryType;?>" data-postType="<?php echo $data->PostType;?>" data-videoimage="<?php echo $uri; ?>"><div id='img_streamVideoDiv<?php echo $commentID; ?>' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php  echo $comment["ArtifactIcon"] ?>" <?php if(!empty($imageVideomp3Id)){ echo "id=$imageVideomp3Id"; }?>  ></a>
                        <?php  }else{ ?>
                                
                                <div class="pull-left multiple "> 
                                    <div class="img_more1"></div>
                                    <div class="img_more2"></div>
                                    <a class="pull-left pull-left1 img_more  postdetail" <?php if($data->PostType==15){?>data-profile="<?php echo $data->PostCompleteText; ?>" <?php } ?> data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>"><div id='img_streamVideoDiv<?php echo $commentID; ?>' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php echo $comment["ArtifactIcon"] ?>"></a>
                                </div>                                                
                          
                        <?php  } ?>
                             <?php   } ?> 
                            
                        <div class="media-body" >
                            <div class="bulletsShow" id="post_content_total_<?php echo $comment['CommentId']; ?>" style="display:none">

                            <?php  
                                  echo $comment["CommentFullText"];
                             ?>
                                </div>
                    <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>" data-id="<?php echo $data->_id;?>" id="post_content_<?php echo $comment['CommentId']; ?>" data-categoryType="<?php echo $data->CategoryType;?>" data-subgroupid="<?php  echo $data->SubGroupId ?>" data-groupid="<?php  echo $data->GroupId ?>">

                            <?php if($data->PostType != 5){ 
                                  echo $comment["CommentText"];
                                }else{
                                    echo $comment["CommentFullText"];
                                }   
                             ?>
                                </div>
                            <?php 
                                $translate_fromLanguage = $comment["Language"];
                                $translate_class = "commenttranslatebutton";
                                $translate_id = $comment['CommentId'];
                                $translate_postId = $data->PostId;
                                $translate_postType = $data->PostType;
                                $translate_categoryType = $data->CategoryType;
                                include Yii::app()->basePath . '/views/common/translateButton.php'; 
                            ?>
                             <!-- Nested media object -->
                            <div class="media">
                                <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a  class="skiptaiconinner">
                      <img src="<?php  echo $comment['ProfilePicture'] ?>">
                  
                  </a>
                     </div>
                                <div class="media-body">
                                    <span class="m_day"><?php  echo $comment["CreatedOn"]; ?></span>
                                    <div class="m_title"><a class="userprofilename" data-streamId="<?php echo $data->_id;?>" data-id="<?php  echo $comment['UserId'] ?>"  style="cursor:pointer"><?php  echo $comment["DisplayName"] ?></a></div>
                                </div>
                            </div>
                             </div>
                               
    <?php if(isset($comment['WebUrls']['Weburl'])){?>
               <?php if(isset($comment["IsWebSnippetExist"]) && $comment["IsWebSnippetExist"]=='1'){     ?>           

                <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;clear:both;">
                                 <div class="Snippet_div" style="position: relative">

                                        <a href="<?php echo $comment['WebUrls']['Weburl']; ?>" target="_blank">
                                            <?php if($comment['WebUrls']['WebImage']!=""){ ?>
                            <span  class=" pull-left img_single e_img" style="width:100px;" ><img src="<?php echo $comment['WebUrls']['WebImage']; ?>"></span>
                                            <?php } ?>
                            <div class="media-body">  </a>                                 
                                                    

                                                        <label class="websnipheading" ><?php echo $comment['WebUrls']['WebTitle']; ?></label>
                                                        <a   class="websniplink" href="<?php echo $comment['WebUrls']['Weburl']; ?>" target="_blank"> <?php echo $comment['WebUrls']['WebLink']; ?></a>
                                                        <p><?php echo $comment['WebUrls']['Webdescription']; ?></p>
                                                    
                                                </div>
                                       
                                    </div>
                           </div>
                      
    <?php } } ?>
              

                           </li>
                </ul>
            </div>
         
              
          
          </div>
          </div>
  
                </div>
            <?php  } ?>
     
        <?php  }else{
                 $style="display:none";
        } 
        
        if($data->CommentCount >$commentssize && sizeof($data->Comments)==2){
             $style="display:block";
        }else if($data->CommentCount > sizeof($data->Comments)){
             $style="display:block";
        }
        
        ?>