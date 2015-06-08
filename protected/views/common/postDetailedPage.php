<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/publicprofile.css" rel="stylesheet" type="text/css" media="screen" />    
    <?php  if(is_object($data)){  
    if($categoryType==3 ){
        $status=$data->Status;
    }
    if($status==1){
    $count = 0;
    $createdOn = $data->CreatedOn; 
    $PostOn = CommonUtility::styleDateTime($createdOn->sec);
    if(isset(Yii::app()->session['TinyUserCollectionObj'])){
        $UserId = Yii::app()->session['TinyUserCollectionObj']->UserId;
    }else{
        $UserId = 0;
    }  
    $PostTypeString = CommonUtility::postTypebyIndex($data->Type);     
    $actionText = CommonUtility::actionTextbyActionType($data->Type);
    if($categoryType == 3){
        $PostTypeString = "Group $PostTypeString";
    }
    $ShareCount = 0;
    $FbShareCount = isset($data->FbShare) && is_array($data->FbShare)?sizeof($data->FbShare):0;
    $TwitterShareCount = isset($data->TwitterShare) && is_array($data->TwitterShare)?sizeof($data->TwitterShare):0;
    $ShareCount = $FbShareCount+$TwitterShareCount;
?>

    

<!--<div class="row-fluid " id="postDetailedTitle">
     <div class="span6 "><h2 class="pagetitle"><?php if($data->Type==5){ echo $data->Subject;} else{  echo Yii::t('translation','Normal_Post_Detail');}?></h2>
    
     </div>
          <div class="span6 "  id="detailedclose">
          <div class="grouphomemenuhelp alignright tooltiplink"> <a data-postType="<?php  //echo $data->Type;?>" data-categoryId="<?php // echo $categoryType; ?>" class="detailed_close_page" rel="tooltip"  data-original-title="close" data-placement="bottom" data-toggle="tooltip"> <i class="fa fa-times"></i></a> </div>
          </div>
     </div>-->
    
    <div class="stream_widget marginT10" id="postDetailedwidget">
   	 <div class="generalprofileicon skiptaiconwidth80x80 generalzindex2 positionabsolutediv ">
     <div class="skiptaiconinner ">            
    <img src="<?php  echo $tinyObject->profile250x250;?>" >
      </div> 
                     </div>
    	<div class="post_widget" data-postid="<?php  echo $data->_id ?>" data-postType="<?php  echo $data->Type;?>">
        <div class="stream_msg_box">
            <div class="stream_title paddingt5lr10" style="position: relative">  <a class="userprofilename_detailed" data-postId="<?php echo $data->_id;?>" data-id="<?php  echo $data->UserId ?>" style="cursor:pointer"> <b><?php  if($data->Type != 4) echo $tinyObject->DisplayName;?></b></a>  <?php if($data->Type != 4){ echo "<span>$actionText</span> $PostTypeString";}else{ echo "A new post has been created"; }?><span class='userprofilename'> <?php if($data->Type==2 || $data->Type==3){ if(isset($data->Title) && $data->Title!=""){ echo $data->Title; };} ?></span> <i><?php  echo $PostOn; ?> </i></div>
             <div class=" stream_content">
                
            <ul>
            <li class="media">
            <?php  if($data->Type!=3){ 
                 include Yii::app()->basePath . '/views/includes/outside_postdetail_event.php';
                 
            }else{
                    include Yii::app()->basePath . '/views/includes/outside_postdetail_survey.php';
                   }
             ?>
                <?php 
                    include Yii::app()->basePath . '/views/includes/outside_postdetail_artifacts.php';
                ?>
              <div class="social_bar social_bar_detailed" data-id="<?php  echo $data->_id ?>" data-postid="<?php  echo $data->_id ?>" data-categoryType="<?php  echo $categoryType;?>" data-networkId="<?php  echo $data->NetworkId; ?>">	
                <a class="follow_a"><i><img src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php  echo in_array($UserId, $data->Followers)>0?Yii::t('translation','UnFollow'):Yii::t('translation','Follow');?>" class="<?php  echo in_array($UserId, $data->Followers)>0?'follow':'unfollow';?>" id="detailedfolloworunfollow" data-postid="<?php  echo $data->_id ?>" data-catogeryId="<?php  echo $categoryType;?>"></i><b id="streamFollowUnFollowCount_<?php  echo $data->_id; ?>"><?php  echo count($data->Followers) ?></b></a>
                <?php if($categoryType!=10){?> 
                <a ><i><img  src="/images/system/spacer.png"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Invite'); ?>" class="tooltiplink cursor invite_frds" id="invitefriendsDetailed" data-postid="<?php  echo $data->_id ?>"></i></a>
                <?php }?>
                <span class="cursor"><i><img  class=" <?php  $isLoved = in_array($UserId, $data->Love); if($isLoved){ echo"likes";  }else{ echo"unlikes";};?> " data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>"  src="/images/system/spacer.png" id="detailedLove" data-postid="<?php  echo $data->_id ?>" data-catogeryId="<?php  echo $categoryType;?>"></i><b id="detailedLoveCount"><?php  echo count($data->Love); ?></b></span>
                <?php if($categoryType<3){
                    $IsFbShare = isset($data->FbShare) && is_array($data->FbShare)?in_array($UserId, $data->FbShare):0;
                    $IsTwitterShare = isset($data->TwitterShare) && is_array($data->TwitterShare)?in_array($UserId, $data->TwitterShare):0;

                    if(!$IsTwitterShare || !$IsFbShare){
                        $shareClass = ($IsTwitterShare || $IsFbShare)>0?'sharedisable':'share';
                        ?>
                <span class="sharesection" id="sharesec"><i class="tooltiplink" data-toggle="dropdown" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Share'); ?>" data-placement="bottom"><img src="/images/system/spacer.png"  class="<?php echo $shareClass; ?>"  ></i><b id="streamShareCount_<?php  echo $data->_id; ?>"><?php  echo $ShareCount;?></b>
                <?php }else{?>
                    <span class="sharesection"><i class="tooltiplink" data-toggle="dropdown" rel="tooltip" data-original-title="<?php echo Yii::t('translation','Share'); ?>" data-placement="bottom"><img src="/images/system/spacer.png"  class="sharedisable"  ></i><b id="streamShareCount_<?php  echo $data->_id; ?>"><?php  echo $ShareCount;?></b></span>
                <?php }} ?>
  <?php   if(!$data->DisableComments){
                
                if(count($data->Comments)>0){
                    foreach ($data->Comments as $key=>$value) {
                        if (!(isset($value ['IsBlockedWordExist']) && $value ['IsBlockedWordExist']==1)) {
                            $count++;
                        }
                    }
                }
      ?>
                <span><i><img src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class="detailedComment tooltiplink cursor  <?php   if($data->Type!=5){?>comments<?php  }else{?>comments1<?php  }?>"  id="detailedComment"  data-postid="<?php  echo $data->_id ?>"></i><b id="commentCount_<?php  echo $data->_id ?>"><?php  echo $count; ?></b></span>
                  <?php  }?>              
              </div>
              </li>
              </ul>
             
          </div>
          
        </div>
        <?php if(isset(Yii::app()->session['TinyUserCollectionObj'])){ ?>
          <div class="commentbox <?php  if($data->Type==5){?>commentbox2<?php  }?> " id="cId_<?php   echo $data->_id; ?>" style="display:<?php  echo count($data->Comments)>0?'block':'none';?>">
              <div id="commentSpinLoader_<?php  echo $data->_id; ?>"></div>
            <?php  include Yii::app()->basePath . '/views/includes/outside_postdetail_comment.php'; ?>
               <?php  if($count >5){ ?>
           <div class="viewmorecomments alignright">
                <span  id="viewmorecommentsDetailed" onclick="viewmoreCommentsIndetailedPage('/post/postComments','<?php   echo $data->_id ?>','<?php   echo $data->_id ?>','Streampost','<?php  echo $categoryType; ?>');"><?php echo Yii::t('translation','More_Comments'); ?></span>
              </div>
      <?php   } ?>
              <div id="ArtifactSpinLoader_postupload_<?php  echo $data->_id?>"></div>
              <div id="newComment" style="display:none" class="paddinglrtp5">
        <div id="commentTextArea_<?php  echo $data->_id; ?>" class="inputor commentplaceholder" contentEditable="true" onkeyup="getsnipetForComment(event,this,'<?php echo $data->_id; ?>');"  onclick="OpenCommentbuttonArea('<?php echo $data->_id; ?>')"></div>
            <div id="commentTextAreaError_<?php  echo $data->_id; ?>" style="display: none;"></div>
            <div class="alert alert-error" id="commentTextArea_<?php  echo $data->_id; ?>_Artifacts_em_" style="display: none;"></div>
            <input type="hidden" id="artifacts" value=""/>
            <div id="preview_commentTextArea_<?php  echo $data->_id; ?>" class="preview" style="display:none">
                     <ul id="previewul_commentTextArea_<?php  echo $data->_id; ?>" class="imgpreview">
                         
                    </ul>

   
                 </div>
                          <div  id="snippet_main_<?php echo $data->_id; ?>" class="snippetdiv" style="" ></div>        
<div class="postattachmentarea" id="commentartifactsarea_<?php  echo $data->_id; ?>">
        <div class="pull-left whitespace">
<div class="advance_enhancement">
<ul>
                <li class="dropdown pull-left ">
                  <div id="postupload_<?php  echo $data->_id; ?>">
                  </div>
                 
                    </li>
                   
                     
                    </ul>
                         
    <a href="#" ></a> <a href="#" ><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
     </div>
    <div class="pull-right">
       
        <button id="savePostCommentButton" onclick="saveDetailedPostCommentByUserId('<?php   echo $data->_id; ?>','<?php   echo $data->Type;?>','<?php  echo $categoryType;?>','<?php   echo $data->NetworkId;?>','<?php   echo $data->_id; ?>','postDetailed');" class="btn" data-loading-text="Loading..."><?php echo Yii::t('translation','Comment'); ?></button>
        <button id="cancelPostCommentButton" data-postid="<?php  echo $data->_id ?>"  class="btn btn_gray"> <?php echo Yii::t('translation','Cancel'); ?></button>

    </div></div>
            <div style="display:<?php   echo count($data->Comments)>0?'block':'none';?>" class="postattachmentareaWithComments"> <img src="/images/system/spacer.png" />
                </div>
</div>
              
          </div>
        <?php } ?>
        </div>
    
    </div>
<script type="text/javascript">
$(function(){
    Custom.init();
    $("#postDetailedwidget,#detailedLove,#detailedfolloworunfollow,#invitefriendsDetailed,#detailedComment,#sharesec").on("click",function(){
        showLoginPopup();
    });
});

</script>

<?php          
        
    }else{?>
        <div class="row-fluid">
    <div class="span12" style="text-align:center;">
        <img src="/images/system/groupisinactive.png" />        
    </div>
</div>
    <?php }


              } else{ ?>
<div class="row-fluid">
    <div class="span12" style="text-align:center;">
        <h3><?php echo Yii::t('translation','Page_not_found'); ?></h3>
    </div>
</div>

        <?php }
?>


 

 
<script>
$(document).ready(function(){ 
     $('#mainNav,.navbar-nav ').hide();
    $("div.logo a.brand").attr("href","/");
    $(".logo a,#logo a,div.logo a.brand ").live("click",function(){      
       window.location.href = "/";
    });
 sessionStorage.clear();
 Custom.init();
});
    
</script>