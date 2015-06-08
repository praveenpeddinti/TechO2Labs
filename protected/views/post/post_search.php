 <?php 
 
 if(count($postSearchResult)>0){
    foreach($postSearchResult as $data){
      
        ?>
<li class="woomarkLi">
<div class="post item" name="searchPostRecord" data-posttype="<?php echo $data[0]->Type?>" data-categorytype="<?php echo $data[2]?>" data-postid="<?php echo $data[0]->_id ?>">  
 <span id="groupfollowSpinLoader_<?php echo $data[0]->_id; ?>"></span>
    <?php $time=$data[0]->CreatedOn?>

        <div  style="cursor: pointer;" class="stream_title paddingt5lr10"> <b id="postUserName" data-id="<?php echo $data[0]->_id ?>" class="group"><?php echo $data[1] ?></b>  <i><?php echo CommonUtility::styleDateTime($time->sec); ?></i></div>
     <?php if($data[0]->Type==12){
    if(count($data[0]->Resource)>1){
            ?>
                <a class="pull-left img_more postdetail" >

        <?php
              $extension = $data[0]->Resource['Extension'];
             if(in_array($extension, array("mp3","swf"))){?>
        <img src="/images/system/audio.png" />
        <?php }else if(in_array($extension, array("mp4","mov"))){?>
        <img src="/images/system/video_img.png" />
        <?php }
        else if(in_array($extension, array("doc","docx"))) {?>
         <img src="/images/system/MS-Word-2-icon.png" />    
      <?php  } else if(in_array($extension, array("pdf"))){?>
          <img src="/images/system/pdf.png" />
      <?php }else if(in_array($extension, array("xls","xlsx"))){?>
          <img src="/images/system/Excel-icon.png" />
      <?php }
      else if(in_array($extension, array("txt"))){?>
          <img src="/images/system/notepad-icon.png" />
      <?php }
         else if(in_array($extension, array("ppt","pptx"))){?>
          <img src="/images/system/PPT-File-icon.png" />
      <?php }else{
              ?>
           <img src="<?php echo $data[0]->Resource['Uri'] ?>"/>
        
        
<!--        <div class="mediaartifacts"><a href="#" class=" "></div>-->
 
        <?php }?>
        </a>
        <?php }else if(count($data[0]->Resource)!=0){
             $extension = $data[0]->Resource['Extension'];
           if(in_array($extension, array("mp3","swf"))){?>
 <img src="/images/system/audio.png"  style="max-width: 200px"/>
          <?php }else if(in_array($extension, array("mp4","mov"))){?>
        <img src="/images/system/video_img.png" />
        <?php }
          else if(in_array($extension, array("doc","docx"))) {?>
         <img src="/images/system/MS-Word-2-icon.png" />    
      <?php  } else if(in_array($extension, array("pdf"))){?>
          <img src="/images/system/pdf.png" />
      <?php }else if(in_array($extension, array("xls","xlsx"))){?>
          <img src="/images/system/Excel-icon.png" />
      <?php }else if(in_array($extension, array("txt"))){?>
          <img src="/images/system/notepad-icon.png" />
      <?php }
         else if(in_array($extension, array("ppt","pptx"))){?>
          <img src="/images/system/PPT-File-icon.png" />
      <?php }else{
              ?>
 <div class="mediaartifacts"><a href="#"><img src="<?php echo $data[0]->Resource['Uri'] ?>"/></a></div>
           
<?php       }
          }
     }else{
      ?>
  <?php if(count($data[0]->Resource)>1){
            ?>
                <a class="pull-left img_more postdetail" >

        <?php
              $extension = $data[0]->Resource[0]['Extension'];
             if(in_array($extension, array("mp3","swf"))){?>
        <img src="/images/system/audio.png" />
        <?php }else if(in_array($extension, array("mp4","mov"))){?>
        <img src="/images/system/video_img.png" />
        <?php }else if(in_array($extension, array("doc","docx"))) {?>
         <img src="/images/system/MS-Word-2-icon.png" />    
      <?php  } else if(in_array($extension, array("pdf"))){?>
          <img src="/images/system/pdf.png" />
      <?php }else if(in_array($extension, array("xls","xlsx"))){?>
          <img src="/images/system/Excel-icon.png" />
      <?php }else if(in_array($extension, array("txt"))){?>
          <img src="/images/system/notepad-icon.png" />
      <?php }
         else if(in_array($extension, array("ppt","pptx"))){?>
          <img src="/images/system/PPT-File-icon.png" />
      <?php }else{
              ?>
           <img src="<?php echo $data[0]->Resource[0]['Uri'] ?>"/>
        
        
<!--        <div class="mediaartifacts"><a href="#" class=" "></div>-->
 
        <?php }?>
        </a>
        <?php }else if(count($data[0]->Resource)!=0){
             $extension = $data[0]->Resource[0]['Extension'];
           if(in_array($extension, array("mp3","swf"))){?>
 <img src="/images/system/audio.png"  style="max-width: 200px"/>
          <?php } else if(in_array($extension, array("mp4","mov"))){?>
        <img src="/images/system/video_img.png" />
        <?php }else if(in_array($extension, array("doc","docx"))){?>
             <img src="/images/system/MS-Word-2-icon.png" />    
        <?php  } else if(in_array($extension, array("pdf"))){?>
          <img src="/images/system/pdf.png" />
      <?php }
       else if(in_array($extension, array("xls","xlsx"))){?>
          <img src="/images/system/Excel-icon.png" />
      <?php }else if(in_array($extension, array("txt"))){?>
          <img src="/images/system/notepad-icon.png" />
      <?php }
      else if(in_array($extension, array("ppt","pptx"))){?>
          <img src="/images/system/PPT-File-icon.png" />
      <?php }else{
              ?>
 <div class="mediaartifacts"><a href="#"><img src="<?php echo $data[0]->Resource[0]['Uri'] ?>"/></a></div>
           
<?php       }
          }
     }
      ?>
        
 
        <div class="stream_content">
                     <div class="media" data-id="<?php echo $data[0]->_id ?>">
                            <div class="media-body bulletsShow">
                           <?php if($data[0]->Type==12){ echo $data[0]->GameDescription;}else{ 
                               if(isset($data[0]->IsWebSnippetExist) && !empty($data[0]->IsWebSnippetExist) && $data[0]->IsWebSnippetExist != "undefined" ){
                                   $data[0]->Description = CommonUtility::findUrlInStringAndMakeLink($data[0]->Description);
                               }                               
                               echo $data[0]->Description;
                               
                               
                           }?>
                            </div>
                        
                        
<div class="social_bar" data-groupid="<?php echo $data[0]->_id; ?>">   
   
              <span style="min-width: 40px" class="follow_a"><i><img data-placement="bottom" rel="tooltip"  data-original-title="<?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $data[0]->Followers)?Yii::t('translation','UnFollow'):Yii::t('translation','Follow') ?>" class="<?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $data[0]->Followers)?'follow':'unfollow' ?>" src="/images/system/spacer.png"></i><b><?php echo count($data[0]->Followers) ?></b></span>
           <span><i><img data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>" src="/images/system/spacer.png" class="<?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $data[0]->Love)?'likes':'unlikes' ?>" ></i> <b><?php echo count($data[0]->Love) ?></b></span>
            <span><i><img data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" src="/images/system/spacer.png" class="g_posts" ></i> <b><?php echo count($data[0]->Comments) ?></b></span>
          

                         </div>

                        </div>
        </div>
                    
                </div>
        
    </li>
<?php }
 }else{
     echo "nodata";
 }
      ?>
