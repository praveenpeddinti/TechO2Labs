<!-- spinner -->
<div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>
<div id="stream_view_detailed_spinner_<?php echo $data->PostId; ?>"></div>
 
<!-- end spinner -->
<div class=" stream_content positionrelative">
    <span id="followUnfollowSpinLoader_<?php echo $data->PostId; ?>"></span>
    <ul>
        <li class="media">
            <a  href="/marketresearchview/1/<?php echo $data->TopicName ?>" class="pull-left img_single" ><img src="<?php echo $data->TopicImage?>"  ></a>

            <div class="media-body gameDesc"  >

                <p class="cursor titleforsurvey" data-bundleName="<?php echo $data->TopicName ?>" id="stream_gameName_<?php echo $data->_id ?>">
                    <?php echo $data->Title ?>
                 </p >
                 
                
            </div>
            
            
            
        </li>
    </ul>
</div>
<script type="text/javascript">
    
    $('.titleforsurvey').live("click",function(){        
        var bundleName=$(this).attr("data-bundleName");
         window.location='/marketresearchview/1/'+bundleName;
    });
</script>