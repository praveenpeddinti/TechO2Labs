<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($notification))
{
    $topicDetails=$notification->TopicDetails ;
    $userDetails=$notification->UserDetails;
    ?>


<div class="dsn_notifications_float">
            	    
        <div class="dsn_notifications">
        	<div class="stream_title paddingt5lr10 bg_w">
                    <a class="pull-left marginzero normaltext">New topic is</a> 
                    <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <?php if($topicDetails[0]->ProfileImage!=null && $topicDetails[0]->ProfileImage!='') { ?> <img src="<?php echo $topicDetails[0]->ProfileImage?>"><?php } else { ?><img src="/images/system/user_noimage.png"> <?php }?> 
                  
                  </a>
                     </div>
                    <b> &nbsp;  <?php  echo $topicDetails[0]->TopicName;?></b></div>
             
        </div>
          
           
            </div>
  <!-- one -->
                
            <!-- one end -->  



<?php }?>
