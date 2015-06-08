 <?php 
 
 if(count($postSearchResult)>0){
    foreach($postSearchResult as $data){
        ?>
<li class="woomarkLi">
<div class="post item" name="searchPostRecord" data-posttype="<?php echo $data[0]->Type?>" data-categorytype="<?php echo $data[0]->CategoryType?>" data-postid="<?php echo $data[0]->_id ?>">  
 <span id="groupfollowSpinLoader_<?php echo $data[0]->_id; ?>"></span>
    <?php $time=$data[0]->CreatedOn?>

        <div  style="cursor: pointer;" class="stream_title paddingt5lr10"> <b id="postUserName" data-id="<?php echo $data[0]->_id ?>" class="group"><?php echo $data[1] ?></b>  <i><?php echo CommonUtility::styleDateTime($time->sec); ?></i></div>
        <?php if(count($data[0]->Resource)>1){
            ?>
                <a class="pull-left img_more postdetail" >

        <?php
              $extension = $data[0]->Resource[0]['Extension'];
             if(in_array($extension, array("mp4","mp3"))){?>
        <img src="/images/system/audio.png" />
        <?php }else{
              ?>
           <img src="<?php echo $data[0]->Resource[0]['Uri'] ?>"/>
        
        
<!--        <div class="mediaartifacts"><a href="#" class=" "></div>-->
 
        <?php }?>
        </a>
        <?php }else if(count($data[0]->Resource)!=0){
             $extension = $data[0]->Resource[0]['Extension'];
           if(in_array($extension, array("mp4","mp3"))){?>
 <img src="/images/system/audio.png"  style="max-width: 200px"/>
          <?php }else{
              ?>
 <div class="mediaartifacts"><a href="#"><img src="<?php echo $data[0]->Resource[0]['Uri'] ?>"/></a></div>
           
<?php       }
          }
      ?>
 <div class="gametitle">
     <?php echo $data[0]->Title;?>
 </div>
            <?php if($data[0]->HtmlFragment!=''){?>
 <a  class="pull-left img_single NOBJ postdetail" style="margin-top: 6px">
                            <?php $object = stristr($data[0]->HtmlFragment,'<object');
                            if($object!=''){?>
                            <div class="galleria-info" style="bottom:0px"><div class="galleria-info-text" style="border-radius:0px"><div class="galleria-info-description" style="height:132px"></div></div></div>
                            <?php }?>
                        <?php
$pattern = '/(width)="[0-9]*"/';
$string=$data[0]->HtmlFragment;
$string = preg_replace($pattern, "width='180'", $string);
$pattern = '/(height)="[0-9]*"/';
$string = preg_replace($pattern, "height='150'", $string);

echo $string;
?>
                        </a>
                        <?php }?>
        <div class="stream_content">
                     <div class="media" data-id="<?php echo $data[0]->_id ?>">
                            <div class="media-body bulletsShow">
                           <?php echo $data[0]->Description?>
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
     echo Yii::t('translation','No_Data_Found');
 }
      ?>
