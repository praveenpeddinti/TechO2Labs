<div  class="generalprofileicon skiptaiconwidth80x80 generalzindex2 positionabsolutediv ">
     <div class="skiptaiconinner ">            
    <img src="<?php
    if ($data->isGroupAdminPost == 'true' && $data->ActionType == 'Post') {
        echo $data->GroupImage;
    } else {
        echo $data->FirstUserProfilePic;
    }
    ?>" >
      </div> 
                     </div>