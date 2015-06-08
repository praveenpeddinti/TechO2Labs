<?php 
try {
    
 if(is_object($stream))
      { 
$isdivadded = 0;
     $style="";
     $i=0;
     $totalPremiumAds = 0;
     foreach($stream as $data){
         if($data->CategoryType == 13 && isset($data->IsPremiumAd) && $data->IsPremiumAd == 1){            
             $totalPremiumAds++;
         }
         if($data->IsPromoted == 1){
             $totalPremiumAds++;
         }
         if($data->IsSaveItForLater == 1){
             $totalPremiumAds++;
         }
     }
     
    foreach($stream as $data){    
          $canMarkAsAbuse = isset($data->CanMarkAsAbuse)?$data->CanMarkAsAbuse:0;

     $translate_fromLanguage = $data->Language;
        $postDetailClass = $data->PostTextLength>=500?'postdetail':'';
        $translate_class = "translatebutton ".$postDetailClass;
        if($data->CategoryType==11) {
            $translate_class = "translatebutton";
        }
        $translate_id = $data->_id;
        $translate_postId = $data->PostId;
        $translate_postType = $data->PostType;
        $translate_categoryType = $data->CategoryType;
?>


<?php if($data->CategoryType!=13){  ?>
    <div class="post item <?php echo (isset($data->IsPromoted) && $data->IsPromoted==1)?'promoted':''; 
echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1) ?' saveitforlater' :'' ?>" style="width:100%;display:none;" id="postitem_<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-posttype="<?php  echo $data->PostType;?>" data-categorytype="<?php  echo $data->CategoryType;?>">

<div class="stream_widget marginT10 positionrelative" >
    <?php include 'stream_profile_image.php'; ?>
    <div class="post_widget impressionDiv" data-postid="<?php  echo $data->PostId ?>" data-postType="<?php  echo $data->PostType;?>">
        <div class="stream_msg_box">
    <?php include 'stream_header.php'; ?>
           
      <?php if(($data->CategoryType!=3 || $data->IsIFrameMode==1) && ($data->PostType < 6 || $data->PostType==13 || $data->PostType==14 ||$data->PostType==15 || $data->PostType==17)){ ?>
            <div class=" stream_content positionrelative">
                <span id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></span>
                <ul>
                    <li class="media">
                            <div class="isFeatured" id="isFeatutedIcon_<?php  echo $data->_id ?>" <?php if($data->IsFeatured==1){?> style="display:block" <?php }else {?> style="display:none"<?php  }?> > </div>
                        
                    <?php if($data->PostType!=3){//not survey post 
                          include Yii::app()->basePath . '/views/includes/stream_artifacts.php'; ?>
                        
                        <div class="media-body" id="media_main_<?php echo $data->_id; ?>">
                            <?php  if($data->PostType==2){ 
                                include Yii::app()->basePath . '/views/includes/stream_event.php';
                            }else{ ?>

                            <?php include Yii::app()->basePath . '/views/includes/stream_postText.php';  ?>

                                
                              <?php

                              if($data->IsAnonymous == 0 && (int) $data->FirstUserId !=  (int)$data->OriginalUserId ){
                                  include Yii::app()->basePath . '/views/includes/stream_originalUser.php';
                                }else if($data->PostType==5){ ?>
                                 <div class="media-body"> 
                                     <div id="curbside_spinner_<?php echo $data->_id; ?>"></div>
                                    <div class="m_title"><span class="pull-right" data-id="<?php echo $data->_id; ?>"><?php echo $data->CurbsideConsultCategory?></span></div>
                                </div>
                             <?php }}?>
                            
                           
                              
                        </div>
                                <?php if($data->CategoryType==3 && $data->IsIFrameMode==1){ ?>
                                   <div class="media-body"> 
                                    <div class="m_title">
                                        <span class="pull-right" data-id="<?php echo $data->_id; ?>">
                                            <a class="grpIntro grpIntro_b" data-streamId="<?php echo $data->_id;?>" data-id="<?php echo $data->MainGroupId; ?>" data-groupname="<?php echo $data->GroupUniqueName; ?>" style="cursor:pointer"><b><?php echo $data->GroupName; ?></b></a>
                                        </span>
                                    </div>
                                </div> 
                            <?php } 
                                include Yii::app()->basePath . '/views/includes/stream_webSnippet.php';
                            }else{ 
                                $isStream = true;
                                include Yii::app()->basePath . '/views/includes/stream_survey.php';
                            } ?>
                             <?php include Yii::app()->basePath . '/views/common/translateButton.php'; ?>
                <?php $joyride=0;?> <!-- This id numero3 is used for Joyride help -->
                <?php include Yii::app()->basePath . '/views/includes/stream_socialBar.php'; ?>
                              </li>
                </ul>
            </div>
            <?php }
            else if($data->PostType ==9 || ($data->CategoryType==3 && $data->IsIFrameMode!=1)){
                include Yii::app()->basePath . '/views/includes/stream_group.php';
            }else if($data->PostType ==8 ){ 
                include Yii::app()->basePath . '/views/includes/stream_curbsideCategory.php'; 
            }else if($data->PostType ==7 ){
                include Yii::app()->basePath . '/views/includes/stream_hashtag.php';
            }else if($data->PostType ==11 ){
                include Yii::app()->basePath . '/views/includes/stream_news.php';
            }else if($data->PostType ==12 ){
                include Yii::app()->basePath . '/views/includes/stream_game.php';
            }else if($data->CategoryType ==16 ){
                include Yii::app()->basePath . '/views/includes/stream_extendedSurvey.php';
            }
             ?>            
        </div>
            

        <?php if($data->CategoryType==1 || $data->CategoryType==10 || $data->CategoryType==12 ){ ?>
        <?php if($data->RecentActivity=="Invite"){ ?>
        <div style="" id="Invite_<?php  echo $data->_id; ?>" class="commentbox  ">
            <div class="padding10"><?php echo $data->InviteMessage; ?></div>
            <style>#Invite_<?php  echo $data->_id; ?>.commentbox:before{left:48px}</style><style>#Invite_<?php  echo $data->_id; ?>.commentbox:after{left:48px}</style>
        </div>
        <?php } ?>
         <div id="PostdetailSpinLoader_streamDetailedDiv_<?php  echo $data->_id; ?>"></div>
         <div class="commentbox <?php if ($data->PostType == 5) { ?>commentbox2<?php } ?> " id="cId_<?php echo $data->_id; ?>"  style="display:<?php echo (count($data->Comments) == 0 || $data->RecentActivity == "Invite") ? 'none' : 'block'; ?>">
            <?php include Yii::app()->basePath . '/views/includes/stream_comments.php'; ?>
              <div class="viewmorecomments alignright" style="<?php echo $style; ?>">
               <span<?php  if($data->CommentCount > 10){?> class="postdetail" data-id="<?php echo $data->_id;?>" data-postid="<?php echo $data->PostId;?>" data-categoryType="<?php echo $data->CategoryType;?>" data-postType="<?php echo $data->PostType;?>" <?php } ?> id="viewmorecomments_<?php  echo $data->_id; ?>" style="<?php echo $style; ?>" <?php  if($data->CommentCount <= 10){?> onclick="viewmoreComments('/post/postComments','<?php  echo $data->PostId ?>','<?php  echo $data->_id ?>','<?php echo $data->CategoryType; ?>');" <?php } ?>>More Comments</span>
                            </div>
            <div id="ArtifactSpinLoader_postupload_<?php echo $data->_id ?>"></div>
            <?php include Yii::app()->basePath . '/views/includes/stream_newComment.php'; ?>
         </div>
        <script type="text/javascript">
            $(function(){
                var extensions='"zip","jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
                initializeFileUploader("postupload_<?php  echo $data->_id?>", '/post/upload', '10*1024*1024', extensions,4, 'commentTextArea','<?php  echo $data->_id?>',previewImage,appendErrorMessages,"uploadlist_<?php  echo $data->_id?>");
            });
            
         </script>
        <?php } ?>
    </div>
</div>
</div>
          <?php }else{
              if($data->IsSurveyTaken != 1) // If Survey is not done by the User...
                include 'advertisement_view.php';
 
          } ?>
<script type="text/javascript">
    var createdon = '<?php  echo $data->CreatedOn->sec; ?>';
   
   $("#postitem_<?php echo $data->_id; ?> .moreiconcolor").unbind("click");
    $("#postitem_<?php echo $data->_id; ?> .moreiconcolor").bind("click",function(){
         var IsSaveItForLater='<?php echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1)?1:0?>';
      
       if(IsSaveItForLater==1)
       {
           cancelSaveItForLater('<?php echo $data->CategoryType?>','<?php echo $data->PostType?>','<?php echo $data->PostId?>','<?php echo $data->_id?>')
           //do ajax call
       }
    });
    $("#postitem_<?php  echo $data->_id; ?>").show(); 
    if(g_pflag == 0){
        g_pflag = 1;    
            g_postIds = '<?php  echo $data->PostId."_".$data->CategoryType; ?>';
        }else{
               g_postIds = g_postIds+','+'<?php  echo $data->PostId."_".$data->CategoryType; ?>';
                g_pflag = 1;
        }
       // alert(g_postIds);
        <?php if($data->IsPromoted == 0){?>
    if(g_postDT != undefined && g_postDT != null){        
        if(g_postDT < createdon){            
            g_postDT = createdon;
            g_iv = 1;
            status = 0;            
        }else if(g_iv == 0){            
            g_postDT = createdon;            
            g_iv = 1;
            status = 0;
        }   
    }
//    alert(g_postIds)
        <?php } ?>
            var postid='<?php echo $data->_id; ?>';
              var divheight=$("#CommentBoxScrollPane_"+ postid).height();

          if(divheight >250){}  
//    socketPost.emit('updateGlobalDateValue', g_postDT,g_postIds);
</script>

<script type="text/javascript">
    $(function(){
         Custom.init();                  
        if($('#commentCount_<?php  echo $data->PostId; ?>').length>0){
            var commentArrowLeft = $('#commentCount_<?php  echo $data->PostId; ?>').prev().find('img').position().left;
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:before{left:'+commentArrowLeft+'px}</style>');
            $('div#cId_<?php  echo $data->_id; ?>.commentbox').append('<style>div#cId_<?php  echo $data->_id; ?>.commentbox:after{left:'+commentArrowLeft+'px}</style>');
        }// span.postdetail---prevAll()
        $('#post_content_<?php  echo $data->_id; ?>').find('>p').each(function(key,ele){
            if($(ele).prop("tagName")=='p' || $(ele).prop("tagName")=='P'){
                if($(ele).text().length==0){
                    $(ele).remove();
                }
            }
        });
        if($('#post_content_<?php  echo $data->_id; ?> span.postdetail').length>0){
//            if($('#post_content_<?php  echo $data->_id; ?> >p').last().length>0){
//                $('#post_content_<?php  echo $data->_id; ?> span.postdetail').appendTo($('#post_content_<?php  echo $data->_id; ?> >p').last());
//            }
        }
        if(detectDevices()){
           $('.postmg_actions').removeClass().addClass("postmg_actions postmg_actions_mobile");           
        }       
    });
    $('.grpIntro').live("click",function(){
        var groupId=$(this).attr('data-id');
        getGroupIntroPopUp(groupId);             

    });
    $(".grpdetailed").live("click",function(){
            var groupId=$(this).attr('data-id');
            var groupName = $(this).data("groupname");
            window.location.href="/"+groupName;
        }); 
              
      <?php if(isset($data->WebUrls->Weburl)){ ?> 
        if(detectDevices()){
            $("#media_main_"+'<?php echo $data->_id; ?>').attr("style","overflow:visible;");
            $("#post_content_"+'<?php echo $data->_id; ?>').attr("style","padding-right:40px;");
            $("#imgsingle_"+'<?php echo $data->_id; ?>').attr("style","margin-right:10px;");
        }
      <?php }?>
      
      $('#postitem_'+'<?php echo $data->_id; ?>').mousemove(function( event ) {
          var id = $(this).prop('id');
          use4storiesinsertedid = id;
          
          
        });        
    </script>
    
    

<?php $i=$i+1;  
 
if($data->CategoryType == 13 && isset($data->IsPremiumAd) && $data->IsPremiumAd == 1){ ?> 
<script type="text/javascript">    
    timeS[tIndex] = Number("<?php echo $data->PTimeInterval; ?>")*1000; 
    tIndex++;
    //console.log("times array==="+timeS);
</script>
<script type="text/javascript">
    $(document).ready(function(){    
        <?php if($data->CategoryType == 13 && isset($data->IsPremiumAd) && $data->IsPremiumAd == 1 && $i == $totalPremiumAds){ ?>
         pauseLength = Number(timeS[i]);
         if(slideQty == 0){
         setTimeout(function(){ 
             //console.log("===setTimeout carousel===")
//             if(timeS.length > 1){
//                 isAutoslide = true;
//             }
             if(slideQty == 0){ 
                 slideQty++;
             settingsOps = {
            mode: 'horizontal',
            auto:true,
            nextText:'',
            prevText:'',
            speed:200,
            pause:getPauseLength(),           
            pager:false,
            //startSlide:2,
            //autoControls:true,
            
            onSlideBefore: function(e){                
                if(i >= 0 && i < timeS.length-1){
                    i++;
                }else {
                    i = 0;
                    //tIndex = timeS.length-1;
                }
                
                //console.log("=Index="+i+"==slider.getCurrentSlide();="+slider.getCurrentSlide());
                pauseLength = Number(timeS[i]);
                settingsOps.pause = getPauseLength();
                slider.destroySlider();
                slider.reloadSlider();
                //console.log("=onbefore="+pauseLength+":=Index="+i);
                customReloadSlider(pauseLength);                 
            },

            
        } }  
        
        if(isScriptAdded == 0){  
            //console.log("===initialize carousel===")
           slider = $('.bxslider').bxSlider(settingsOps);
           isScriptAdded = 1;
       }
         },1000);
     }
        <?php } ?>
    });

    function customReloadSlider(pauseL){     
       //console.log("====customReload===");
        slider.reloadSlider({
                  mode: 'horizontal',
                  auto: true,
                  pause: getPauseLength(),
                  speed: 500,
                  nextText:'',
                    prevText:'',
                    pager:false,
                    startSlide:i,
                    onSlideBefore:function(){
                        if(i >= 0 && i < timeS.length-1){
                            i++;
                        }else {
                            i = 0;
                            //tIndex = timeS.length-1;
                        }

                        //console.log("@@@@@@customReloadSlider@@@@@@@@@@=Index="+i+"==slider.getCurrentSlide();="+slider.getCurrentSlide());
                        pauseLength = Number(timeS[i]);                        
                        settingsOps.pause = getPauseLength();
                        slider.destroySlider();                        
                        customReloadSlider(pauseLength);        
                    },
                });
    }

function getPauseLength(){
    return pauseLength;
}


</script>
<?php }
        }?>
                   

    <?php
      }else{
          echo $stream;
      }
      } catch (Exception $exc) {
          error_log("exception-------------".$exc->getMessage());
}
?>