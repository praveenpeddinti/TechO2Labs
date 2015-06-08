<?php 
if ($data->ArtifactIcon != "") {
    if ($data->PostType)
        $extension = "";
    $videoclassName = "";
    $extension = strtolower($data->Resource["Extension"]);
    if ($extension == 'mp4' || $extension == 'flv' || $extension == 'mov') {
        $videoclassName = 'videoThumnailDisplay';
    } else {
        $videoclassName = 'videoThumnailNotDisplay';
    }
    
    if ($data->IsMultiPleResources == 1) {
        ?>

        <?php
        $className = "";
        $uri = "";

        $imageVideomp3Id = "";
        $extension = strtolower($data->Resource["Extension"]);
        if ($extension == "mp4" || $extension == "avi" || $extension == "flv" || $extension == "mov" || $extension == "mp3") {
            $className = "videoimage";
            $uri = $data->Resource["Uri"];
            $imageVideomp3Id = "imageVideomp3_$data->_id";
        } else {
            $className = "postdetail";
            if ($data->IsNativeGroup == 1) {
                $className = "";
            }
        }
        ?>
        <?php if (!empty($imageVideomp3Id)) { ?>
            <div id="playerClose_<?php echo $data->_id; ?>"  style="display: none;">
                <div class="videoclosediv alignright"><button aria-hidden="true"  data-dismiss="modal" onclick="closeVideo('<?php echo $data->_id; ?>');" class="videoclose" type="button">×</button></div>
                <div class="clearboth"><div id="streamVideoDiv<?php echo $data->_id; ?>"></div></div>
            </div>
        <?php } ?>  
        <a id="imgsingle_<?php echo $data->_id; ?>" class="pull-left img_single <?php echo $className; ?>" <?php if ($data->PostType == 15) { ?>data-profile="<?php echo $data->PostCompleteText; ?>" <?php } ?> data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>" data-videoimage="<?php echo $uri; ?>" data-vimage="<?php echo $data->ArtifactIcon ?>"><div id='img_streamVideoDiv<?php echo $data->_id; ?>' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php echo $data->ArtifactIcon ?>" <?php if (!empty($imageVideomp3Id)) {
            echo "id=$imageVideomp3Id";
        } ?>  ></a>
    <?php } else { ?>
        <div class="pull-left multiple "> 
            <div class="img_more1"></div>
            <div class="img_more2"></div>
            <a  class="pull-left pull-left1 img_more  <?php if ($data->IsNativeGroup != 1) { ?> postdetail <?php } ?>"  <?php if ($data->PostType == 15) { ?>data-profile="<?php echo $data->PostCompleteText; ?>" <?php } ?> data-id="<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>"><div id='img_streamVideoDiv<?php echo $data->_id; ?>' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php echo $data->ArtifactIcon ?>"></a>
        </div>
    <?php }
} ?>