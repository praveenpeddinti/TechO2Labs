<?php if(is_object($comments) && $isBlocked == 0){ ?>
  <div class="commentsection">
          <div class="row-fluid commenteddiv">
          <div class="span12">
                 <div class=" stream_content">
                <ul>
                    <li class="media">
           <div class="media-body">
                  
          <div id="comment_new_text"><?php echo $comments->CommentText; ?></div></div>
        
          <?php if (!empty($comments->ResourceLength) && $comments->ResourceLength > 0){             
              ?>
   
   <?php if($comments->ResourceLength > 1){?>
      <div class="pull-left multiple "> 
            <div class="img_more1"></div>
            <div class="img_more2"></div>
    <a  class="pull-left  pull-left1 img_more postdetail" data-postid="<?php echo $comments->PostId; ?>" data-categoryType="<?php echo $comments->CategoryType; ?>" data-postType="<?php echo $comments->Type; ?>">
   <?php } else{?>
   <a  class="pull-left img_single postdetail" data-postid="<?php echo $comments->PostId; ?>" data-categoryType="<?php echo $comments->CategoryType; ?>" data-postType="<?php echo $comments->Type; ?>">
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
              
          <?php } ?>
   </a></div><?php } ?>
          
                     <div class="media-body clearboth">
                  <div id="stream_view_commentscript_spinner_<?php echo $comments->PostId; ?>"></div>
          
                 
          <div class="media ">
              <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <img   src="<?php echo $comments->ProfilePic; ?>"> 
                  </a>
                     </div>
                  <div class="media-body">
                   <span class="m_day"><?php echo Yii::t('translation','few_sec_ago'); ?></span>
                   <div class="m_title"><a <a class="userprofilename"  data-id="<?php echo $comments->UserId; ?>" style="cursor:pointer"><?php echo $comments->DisplayName; ?></a></div>
                   </div>
                </div>
                </div>
                    </li>
                </ul>
                     </div>
              </div></div></div>
              

<?php  }else 
    echo "Blocked"; 
?>