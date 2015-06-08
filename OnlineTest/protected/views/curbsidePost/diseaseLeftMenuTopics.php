<!-- Pop up  Content -->

<?php
try {
    ?>
        <script type="text/javascript">
               if('<?php echo$categoriescount ?>'>0)
                   {
                       $("#topicsMenu").show();


                       }
                       else
                       {
                           $("#topicsMenu").hide();

                       }
         </script>
                   
               <?php if($categoriescount > 0){ $categoryIds="";$i=1; $ids?>
                <div>
                        <?php foreach ($categories as $obj) {
                            if($i>5) break;
                        $categoryIds=$categoryIds==""?(int)$obj->CategoryId:$categoryIds.",".(int)$obj->CategoryId;
                        // in_array((int) Yii::app()->session['UserStaticData']->UserId,$obj->Followers);  
                            ?> 

<div class="disease_topicssectiondiv topicsClass category_<?php echo $obj->CategoryId?> " >
                                                <div class="disease_topic_icon">
                                                <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <img src="<?php echo $obj->ProfileImage;?>">
                  
                  </a>
                     </div>
                                                    
                                                </div>
                                                <div class="disease_topic_menutitle">
                                                    <?php if ($obj->NumberOfPosts > 0){ ?>

                                               <a style="cursor: pointer;"  onClick="if(window.location.pathname!=='/stream') { sessionStorage.categoryId='<?php echo $obj->CategoryId;?>';sessionStorage.categoryName='<?php echo $obj->CategoryName;?>'; window.location='/stream';

     } getTopicPosts('<?php echo $obj->CategoryId?>','<?php echo $obj->CategoryName?>')" > <i><?php echo $obj->CategoryName?></i><?php //echo $obj->NumberOfPosts?></a>
                                                     <?php } else{ ?>
                            <a > <?php echo $obj->CategoryName?>  <?php //echo $obj->NumberOfPosts?></a><?php }?>
                                                </div>
                                                  <div class="disease_popdiv">
<div data-iframemode="0" data-networkid="1" data-categorytype="1" data-posttype="1" data-postid="540d8815cec9fead1a8b456f" data-id="540d8815cec9fe7f198b4572" class="social_bar" >

<?php  $title=Yii::t('translation','Following');//'Following';
       $action="follow";
         $class='follow'; 
         if(in_array((int)$loginUserId ,$obj->Followers)>0)
        {
         $title=Yii::t('translation','UnFollow');//'Unfollow';
         $class='follow';
         $action='unfollow';
        } 
        
        else
            {
            $title= Yii::t('translation','Follow');//'Follow';
            $class='unfollow';
            $action="follow";
            }
            ?>
    
   <a   class="tooltiplink cursor " onclick="followUnfollowTopic('<?php echo $obj->CategoryId; ?>','curbsideCategoryIdFollowUnFollowImg1_<?php echo $obj->CategoryId; ?>',1)"><i><img style="z-index: 2222" data-original-title="<?php echo $title;?>"  id="curbsideCategoryIdFollowUnFollowImg1_<?php echo $obj->CategoryId; ?>" src="/images/system/spacer.png"  rel="tooltip" data-action="<?php echo $action; ?>" data-placement="bottom" class=<?php echo $class;?> ></i></a> 
   
<a class="follow_a"  style="cursor:default"><i><img data-original-title="<?php echo Yii::t('translation','Number_Of_Posts'); ?>" rel="tooltip" data-placement="bottom" class=" tooltiplink d_conversations" src="/images/system/spacer.png" /></i> <b id="leftmenuPostsCount_<?php echo $obj->CategoryId; ?>"><?php echo $obj->NumberOfPosts;?></b></a>
<a class="follow_a"  style="cursor:default"><i><img data-original-title="<?php echo Yii::t('translation','Followers'); ?>" rel="tooltip" data-placement="bottom" class=" tooltiplink d_followers" src="/images/system/spacer.png" /></i> <b id="leftmenuFollowersCount_<?php echo $obj->CategoryId; ?>" ><?php echo count($obj->Followers);?></b></a>
                                                </div>
                                                    </div>
                                                </div>
             

                        <?php $i=$i+1; } ?>
                   
               <?php } else{ ?>
                   
                   <div style="text-align:center;">
                   <?php echo Yii::t('translation','No_Data_Found'); ?>
                   </div>
               <?php } ?>
              </div>
          
             <?php if($categoriescount>5) { ?>
                           <div class="alignright clearboth paddingr10"> <a class="more" href="/disease/topics"><?php echo Yii::t('translation','more'); ?><i class="fa fa-youtube-play"></i></a></div>
                           
                       <?php } ?>
        
                           <input type="hidden"  id="topicIds" value="<?php echo $categoryIds;?>" >
                           
    <?php
} catch (Exception $exc) {
    
}

?>
<script type="text/javascript">

$(".disease_topicssectiondiv").bind("click",function(){
    $(".topicsClass").removeClass("disease_topicssectiondiv_active");
    $(".topicsClassAdmin").removeClass("disease_topicssectiondiv_active");
     //$(this).removeClass("disease_topicssectiondiv");
    $(this).addClass("disease_topicssectiondiv_active");
});

</script>
