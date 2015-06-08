<?php if(is_object($comments) && $isBlocked == 0){ ?>
    
  <div class="commentsection commentsectionpaddingzero">
      <div id="commentSpinLoader_<?php  echo $comments->CommentId; ?>"></div>   
      <div class="row-fluid commenteddiv"  id="comment_<?php echo $comments->CommentId; ?>" >
          <div class="span12">
              <?php if($comments->CommentId!=""){
                        $commentId = $comments->CommentId;
                        $streamId = $comments->streamId;
                        $postId = $comments->PostId;
                        $categoryType = $comments->CategoryType;
                        $networkId = "";
                        include Yii::app()->basePath . '/views/includes/comment_management_actions.php'; 
                    }
                ?>
                 <div class=" stream_content">
                <ul>
                    <li class="media">
          
          <?php if (!empty($comments->Resource) && sizeof($comments->Resource) > 0){
              ?>
           
            <?php 
              if ($comments->ResourceLength > 2){
         
?>   
                        <div class="pull-left multiple "> 
            <div class="img_more1"></div>
            <div class="img_more2"></div>
     
            <a  class="pull-left  pull-left1 img_more postdetail" data-profile="<?php echo $comments->Profilename; ?>" data-id="<?php echo $comments->streamId; ?>" data-postid="<?php echo $comments->PostId; ?>" data-categoryType="<?php echo $comments->CategoryType; ?>" data-postType="<?php echo $comments->Type; ?>">

    <?php }else{  ?>
            <div >     
            <a  class="pull-left img_single postdetail" data-profile="<?php echo $comments->Profilename; ?>" data-id="<?php echo $comments->streamId; ?>" data-postid="<?php echo $comments->PostId; ?>" data-categoryType="<?php echo $comments->CategoryType; ?>" data-postType="<?php echo $comments->Type; ?>">
        
    <?php } ?>
            <?php 
            $Resouce = $comments->Resource;
                if(!empty($Resouce['ThumbNailImage'])){                
            ?>      
               
                <div class="" style="cursor:pointer;" >
                 <?php if ( $Resouce['Extension'] == 'mp4' || $Resouce['Extension'] =='mov' || $Resouce['Extension'] =='flv'){ ?>
                    <div  class='<?php if(Yii::app()->params['IsDSN']=='ON'){ echo "DSNPostdetailvideoThumnailDisplay";}else {echo "PostdetailvideoThumnailDisplay"; } ?>'>
                    <img src="/images/icons/video_icon.png">
                    </div>
                 <?php } ?>
                    <img id="comment_new_photo" src="<?php echo $Resouce['ThumbNailImage']; ?>"  data-uri="<?php echo $Resouce['Uri']; ?>" data-format="<?php echo $Resouce['Extension']; ?>"/>    
                 </div>       
                
          <?php } 
          
                ?>
                  </a></div>
                
          <?php } ?>
          <div id="stream_view_commentscript_spinner_<?php echo $comments->PostId; ?>"></div>
                     <div class="media-body">
                  
          <div class="bulletsShow" id="comment_new_text" data-categorytype="<?php echo $comments->CategoryType;?>"><?php echo $comments->CommentText; ?></div>
          <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner "  >
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
              </div></div></div>
        
<?php  }else 
    echo "Blocked"; 
?>
