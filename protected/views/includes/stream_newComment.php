<div id="newComment_<?php echo $data->_id; ?>" style="display:none" class="paddinglrtp5">
    <div id="commentTextArea_<?php echo $data->_id; ?>" class="inputor commentplaceholder" isWebPreview="<?php echo $data->DisableWebPreview?>" contentEditable="true"<?php if($data->DisableWebPreview==0){?>  onkeyup="getsnipetForComment(event, this, '<?php echo $data->_id; ?>');" <?php }?> onclick="OpenCommentbuttonArea('<?php echo $data->_id; ?>')"  ontouchstart="OpenCommentbuttonArea('<?php echo $data->_id; ?>')"></div>
    <div id="commentTextAreaError_<?php echo $data->_id; ?>" style="display: none;"></div>
    <div class="alert alert-error" id="commentTextArea_<?php echo $data->_id; ?>_Artifacts_em_" style="display: none;"></div>
    <input type="hidden" id="artifacts_<?php echo $data->_id; ?>" value=""/>
    <div id="preview_commentTextArea_<?php echo $data->_id; ?>" class="preview" style="display:none">
        <ul id="previewul_commentTextArea_<?php echo $data->_id; ?>" class="imgpreview">

        </ul>


    </div>
    <div  id="snippet_main_<?php echo $data->_id; ?>" class="snippetdiv" style="" ></div> 
    <div class="postattachmentarea" id="commentartifactsarea_<?php echo $data->_id; ?>" style="display:none;">

        <div class="pull-left whitespace">
            <div class="advance_enhancement">
                <ul>
                    <li class="dropdown pull-left ">
                        <div id="postupload_<?php echo $data->_id ?>" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Upload'); ?>">
                        </div>

                    </li>


                </ul>

                <a ></a> <a ><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
        </div>

        <div class="pull-right">

            <button id="savePostCommentButton_<?php echo $data->_id; ?>" onclick="savePostCommentByUserId('<?php echo $data->PostId; ?>', '<?php echo $data->PostType; ?>', '<?php echo $data->CategoryType; ?>', '<?php echo $data->NetworkId; ?>', '<?php echo $data->_id; ?>');" class="btn" data-loading-text="Loading...">Comment</button>
            <button id="cancelPostCommentButton_<?php echo $data->_id; ?>" onclick="cancelPostCommentByUserId('<?php echo $data->_id; ?>')" class="btn btn_gray"> Cancel</button>

        </div>
        <div id="commenterror_<?php echo $data->PostId; ?>" class="alert alert-error displayn" style="margin-left: 30px;margin-right: 157px;"></div>

    </div>
    <div>
        <ul class="qq-upload-list" id="uploadlist_<?php echo $data->_id ?>"></ul>
    </div>

</div>