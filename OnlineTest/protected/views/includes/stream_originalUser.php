<div class="media">
            <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <img src="<?php echo $data->OriginalUserProfilePic ?>">
                  
                  </a>
                     </div>
    <div class="media-body">                                   
        <span class="m_day"><?php echo $data->OriginalPostPostedOn; ?></span>
        <div class="m_title"><a class="userprofilename" data-streamId="<?php echo $data->_id; ?>" data-id="<?php echo $data->OriginalUserId ?>"  style="cursor:pointer"><?php echo $data->OriginalUserDisplayName; ?></a><?php if ($data->PostType == 5) { ?><div id="curbside_spinner_<?php echo $data->_id; ?>"></div><span class="pull-right" data-id="<?php echo $data->_id; ?>"><?php echo $data->CurbsideConsultCategory ?></span><?php } ?></div>

    </div>
</div>