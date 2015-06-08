<div id="newComment"  class="paddinglrtp5">
    <div id="commentTextArea_<?php echo $data->_id; ?>" class="inputor commentplaceholder" contentEditable="true" onkeyup="getsnipetForComment(event,this,'<?php echo $data->_id; ?>');"  onclick="OpenCommentbuttonArea('<?php echo $data->_id; ?>')"></div>
    <div id="commentTextAreaError_<?php echo $data->_id; ?>" style="display: none;"></div>
    <div class="alert alert-error" id="commentTextArea_<?php echo $data->_id; ?>_Artifacts_em_" style="display: none;"></div>
    <input type="hidden" id="artifacts" value=""/>
    <div id="preview_commentTextArea_<?php echo $data->_id; ?>" class="preview" style="display:none">
        <ul id="previewul_commentTextArea_<?php echo $data->_id; ?>" class="imgpreview">

        </ul>
    </div>
    <div  id="snippet_main_<?php echo $data->_id; ?>" class="snippetdiv" style="" ></div>        
    <div class="postattachmentarea" id="commentartifactsarea_<?php echo $data->_id; ?>" style="display:none">
        <div class="pull-left whitespace">
            <div class="advance_enhancement">
                <ul>
                    <li class="dropdown pull-left ">
                        <div id="postupload_<?php echo $data->_id; ?>">
                        </div>
                    </li>
                </ul>
                <a href="#" ></a> <a href="#" ><i><img src="/images/system/spacer.png" class="actionmore" ></i></a></div>
        </div>
        <div class="pull-right">
            <button id="savePostCommentButton" onclick="saveDetailedPostCommentByUserId('<?php echo $data->_id; ?>','<?php echo $data->Type; ?>','<?php echo $data->CategoryType; ?>','<?php echo $data->NetworkId; ?>','<?php echo $data->_id; ?>','postDetailed');" class="btn" data-loading-text="Loading...">Comment</button>
            <button id="cancelPostCommentButton" data-postid="<?php echo $data->_id ?>"  class="btn btn_gray"> Cancel</button>
        </div></div>
     <div ><ul class="qq-upload-list" id="uploadlist_<?php echo $data->_id ?>"></ul></div>
    <div style="display:<?php echo $data->CommentCount > 0 ? 'block' : 'none'; ?>" class="postattachmentareaWithComments"> <img src="/images/system/spacer.png" />
    </div>
</div>