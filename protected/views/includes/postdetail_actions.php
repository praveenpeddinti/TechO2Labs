<?php   $PostId=empty($PostId)?$data->_id :$PostId;
        $streamType=($data->CategoryType==3 || $data->CategoryType==7)?"group":($streamType=$data->CategoryType==8?"news":null);
        $postactions=(($data->CanSaveItForLater==1 && $data->CategoryType!=9 && (isset($data->IsSaveItForLater) && $data->IsSaveItForLater!=1))||$data->CanPromotePost==1 || $data->CanDeletePost == 1||$data->CanFeaturePost==1|| $data->CanCopyURL == 1 || $data->CanMarkAsAbuse==1)?"display:block":"display:none";
         $isuseForDig=(($data->CategoryType==1 || $data->CategoryType==2|| $data->CategoryType==8|| $data->CategoryType==9)?1:0);
        if(!isset($streamType)){
   if (($data->CategoryType != 3 || $data->IsIFrameMode == 1) && $data->IsAbused != 1 && $isPostManagement==0  &&  $data->IsFeatured!=1 &&   $data->CategoryType != 5 && $data->CategoryType != 6 && $data->CategoryType != 10 && $data->PostType != 15 && $data->CategoryType != 11) { ?>
    <div class="postmg_actions" style="<?php echo $postactions;?>">
        <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
        <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
        <div class="dropdown-menu ">
            <ul class="PostManagementActions" data-streamId="<?php echo $data->_id ?>"  data-postId="<?php echo $PostId ?>" data-postType="<?php echo $data->PostType ?>" data-categoryType="<?php echo $data->CategoryType ?>" data-networkId="<?php echo $data->NetworkId ?>" date-useForDigest="<?php echo $data->IsUseForDigest ?>">
                <?php if ($data->CanFeaturePost == 1 && $data->IsFeatured == 0 && $data->CategoryType != 3) { ?>
                    <li><a id="MarkAsFeatured_<?php echo $data->_id ?>"  class="featured m_featured"><span class="featuredicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','MarkAsFeatured_label'); ?> </a></li><?php } ?>
                <?php if ($data->CategoryType != 9 && $data->CanMarkAsAbuse==1) { ?>
                    <li><a class="abuse"><span class="abuseicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','FlagAsAbuse_label'); ?></a></li>
                <?php } ?>
                            <?php if (($data->CanPromotePost == 1 && $data->CategoryType != 3) || ($data->CategoryType == 3 && $data->IsNativeGroup == 1)) { ?><li><a class="promote"><span class="promoteicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Promote_label'); ?></a>
                    </li><?php } ?>
                     <?php if (($data->CategoryType!=9 && $data->CanSaveItForLater == 1 && (isset($data->IsSaveItForLater) && $data->IsSaveItForLater!=1) )) {?><li><a class="saveitforlater"><span class="saveitforlatericon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Can_SaveItForLater');  ?></a>
                    </li><?php } ?>
                <?php if ($data->CanDeletePost == 1) { ?><li><a class="delete"><span class="deleteicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Delete_label'); ?></a></li><?php } ?>
                <?php if ($data->CanCopyURL == 1 && $data->CategoryType != 3) { ?><li><a class="copyurl"><span class="copyicon"><img src="/images/system/spacer.png" /></span> <?php echo $streamType.Yii::t('translation','CopyUrl_label'); ?></a></li> <?php } ?>
                 <?php if (isset($data->Digest_Use) && $data->Digest_Use == 1) { ?><li><a class="usefordigest"><span class="<?php echo $data->IsUseForDigest==1?'notusefordigesticon':'usefordigesticon';?>"><img src="/images/system/spacer.png" /></span> <?php echo $data->IsUseForDigest==1?Yii::t('translation','notusefordigest_label'):Yii::t('translation','usefordigest_label');  ?></a></li><?php } ?>
            </ul>
        </div>
    </div>
<?php } 
}elseif ($streamType=="group") { ?>
    <div class="postmg_actions" style="<?php echo $postactions;?>" >
        <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
        <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
        <div class="dropdown-menu ">
            <ul class="PostManagementActions" data-streamId="<?php echo $data->_id ?>"  data-postId="<?php echo $PostId ?>" data-postType="<?php echo $data->PostType ?>" data-categoryType="<?php echo $data->CategoryType ?>" data-networkId="<?php echo $data->NetworkId ?>">
                <?php if ($data->CanMarkAsAbuse==1) { ?>
                <li><a class="abuse"><span class="abuseicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','FlagAsAbuse_label'); ?></a></li><?php } ?>
                     <?php if (($data->CategoryType!=9 &&$data->CanSaveItForLater == 1 && (isset($data->IsSaveItForLater) && $data->IsSaveItForLater!=1) )) { ?><li><a class="saveitforlater"><span class="saveitforlatericon"><img src="/images/system/spacer.png" /></span> <?php echo  Yii::t('translation','Can_SaveItForLater'); ?></a></li><?php } ?>
<?php if ($data->CanDeletePost == 1) { ?><li><a class="delete"><span class="deleteicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Delete_label'); ?></a></li><?php } ?>
            </ul>
        </div>
    </div>
<?php } elseif ($streamType=="news") { ?>
        <div class="postmg_actions <?php echo empty($fromSTream)?'margin-right10':''?>" style="<?php echo $postactions;?>">
        <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
        <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
        <div class="dropdown-menu ">
            <ul class="PostManagementActions" data-streamId="<?php echo $data->_id ?>"  data-postId="<?php echo $PostId ?>" data-postType="<?php echo $data->PostType ?>"  data-categoryType="<?php echo $data->CategoryType ?>" data-networkId="<?php echo $data->NetworkId ?>" date-useForDigest="<?php echo $data->IsUseForDigest ?>">
               <?php if ($data->CanCopyURL == 1 ) { ?> <li><a class="copyurl"><span class="copyicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','CopyUrl_label'); ?></a></li><?php } ?>
                <?php if (($data->CategoryType!=9 && $data->CanSaveItForLater == 1 && (isset($data->IsSaveItForLater) && $data->IsSaveItForLater!=1) )) {?><li><a class="saveitforlater"><span class="saveitforlatericon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Can_SaveItForLater'); ?></a>
                    </li><?php } ?>
                 <?php if (isset($data->CanPromotePost) && $data->CanPromotePost == 1) { ?><li><a class="promote"><span class="promoteicon"><img src="/images/system/spacer.png" /></span> <?php echo Yii::t('translation','Promote_label'); ?></a></li><?php } ?>
                 <?php if (isset($data->Digest_Use) && $data->Digest_Use == 1) { ?><li><a class="usefordigest"><span class="<?php echo $data->IsUseForDigest==1?'notusefordigesticon':'usefordigesticon';?>"><img src="/images/system/spacer.png" /></span> <?php echo $data->IsUseForDigest==1?Yii::t('translation','notusefordigest_label'):Yii::t('translation','usefordigest_label');  ?></a></li><?php } ?>
            </ul>
        </div>
    </div>
<?php }  ?>
<script type="text/javascript">
    $(" .PostManagementActions a.featured").live("click touchstart",function(){
       var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
       var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
       var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
       var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
       var modelType = 'error_modal';  
       var type='Featured';
   var queryString = "postId="+postId+"&categoryType="+categoryType+"&networkId="+networkId+"&type="+type; 
       var modelType = 'info_modal';
       var title = 'Post Featured Item';
       var content = "<label>Featured Item Title<label><div class='row-fluid'> \
                      <input class='textfield span12' type='text' id='featured_"+postId+"' maxlength='100' /> </div>\n\
                      <div class='control-group controlerror'> <div style='display: none;' id='featured_error_"+postId+"' class='errorMessage'>Featured Item Title cannot be blank</div> </div>";
       var closeButtonText = 'Close';
       var okButtonText = 'Submit';
       var okCallback = featuredItemCallback;
       var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + queryString + ',MarkPostAsFeaturedtHandler'+'';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);

   }); 
   
       $(" .PostManagementActions a.delete").live("click touchstart", function() {
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var modelType = 'error_modal';
        var title = 'Delete';
        var content = "Are you sure you want to delete this post?";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var okCallback = deleteCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId+ ',' + 'postDetail' + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").show();
    });
        $(" .PostManagementActions a.abuse").live("click touchstart", function() {
        var actionType = "Abuse";
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');
        var modelType = 'error_modal';
        var title = 'Flag as abuse';
        var content = "Are you sure you want to flag this message as inappropriate?";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var okCallback = abuseCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId + ',' + actionType + ',' + 'postDetail' + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").show();
    });
    
    $(" .PostManagementActions a.promote").live("click touchstart", function() {
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');        
        var modelType = 'info_modal';
        var title = 'Promote';
        var content = $('#promoteCalcDiv').clone().find('div.promoteCalc').attr('id', 'promoteCalc_' + streamId).end().find('input.promoteInput').attr('id', 'promoteInput_' + streamId).end().html();
        var closeButtonText = 'Close';
        var okButtonText = 'Promote';
        var okCallback = promoteCallback;
        var param = '' + streamId + ',' + postId + ',' + categoryType + ',' + networkId + '';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param);
        $("#newModal_btn_close").hide();
        $("#newModal_btn_primary").attr('disabled', 'disabled');
        $("#newModal_btn_primary").addClass('disabled');
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var expirydate = "";
        if ($(this).closest('.post_widget').find('li time.icon').length > 0) {
            var datesLength = $(this).closest('.post_widget').find('li time.icon').length;
            expirydate = $(this).closest('.post_widget').find('li:nth-child(' + datesLength + ') time.icon').attr('datetime');
            var dateArray = expirydate.split("-");
            expirydate = new Date(dateArray[0], dateArray[1] - 1, dateArray[2], 0, 0, 0, 0);
        }
        var checkin = $('#promoteCalc_' + streamId).datepicker({
            orientation: 'right',
            onRender: function(date) {
                $('.datepicker').css('z-index', 1060);
                return date.valueOf() < now.valueOf() ? 'disabled' : (expirydate != "" && date.valueOf() > expirydate.valueOf() ? 'disabled' : '');
            }
        }).on('changeDate', function(ev) {
            $('.datepicker').hide();
            $("#newModal_btn_primary").removeAttr('disabled');
            $("#newModal_btn_primary").removeClass('disabled');
        });
    });
    
     $(" .PostManagementActions a.saveitforlater").live("click touchstart", function() {
         
        // alert('savet it for later');
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-streamId');
        var postId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        var categoryType = $(this).closest('ul.PostManagementActions').attr('data-categoryType');
        var networkId = $(this).closest('ul.PostManagementActions').attr('data-networkId');        
         var postType = $(this).closest('ul.PostManagementActions').attr('data-postType');
        var modelType = 'info_modal';
      
        var title = 'Save it for later';
        var content = "Are you sure you want to save it for later?";
        var closeButtonText = 'No';
        var okButtonText = 'Yes';
        var okCallback = saveitforlaterCallback;
      
        var param = '' + streamId + ',' + postId + ',' + categoryType +  ','+ networkId+ ',' + 'postDetail' + ',' + postType+'';
        openModelBox(modelType, title, content, closeButtonText, okButtonText, okCallback, param, $(this));
        $("#newModal_btn_close").show();
    });
    
     $(" .PostManagementActions a.copyurl").live("click", function() {
        var streamId = $(this).closest('ul.PostManagementActions').attr('data-postId');
        loadPostSnippetWidget(streamId);
    }); 
     
    $(" .PostManagementActions a.usefordigest").live("click touchstart", function() {
       useForDigest(this);
    });
</script>
