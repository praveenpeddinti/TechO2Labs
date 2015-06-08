
 <div  class="generalprofileicon skiptaiconwidth80x80 generalzindex2 positionabsolutediv <?php if($data->CategoryType==11)echo "networkStreamLogoColor"; ?>">
     <div class="skiptaiconinner "> 
     
    <img  src="<?php 
     if($data->CategoryType == 9 && $data->RecentActivity == "Post"){echo $data->NetworkLogo; }
   else if($data->GameAdminUser==1){
                            echo $data->FirstUserProfilePic;
    }
   
                       
                        else if($data->CategoryType==11 || $data->CategoryType==14)
                            echo $data->NetworkLogo;
                        elseif($data->isGroupAdminPost == 'true' && $data->ActionType=='Post') {
                           echo $data->GroupImage; 
                        }else{
                            echo $data->FirstUserProfilePic; } ?>" >
      </div> 
                     </div>
