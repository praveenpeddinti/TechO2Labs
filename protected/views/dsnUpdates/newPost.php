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
   
     if(isset($userDetails))
     {
     $OriginalPostTime=$userDetails[0]->OriginalPostTime;
     }
     $artifacts=$notification->Artifacts;
    ?>
   

 <!-- three -->
              <div class="dsn_notifications_float">
            	    
        <div class="dsn_notifications">
        	<div class="stream_title paddingt5lr10 bg_w">
                    <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <img src="<?php echo $userDetails[0]->profile70x70?>">
                  
                  </a>
                     </div>
                    <b><?php echo $userDetails[0]->DisplayName?></b> &nbsp;  made a post  <i><?php echo CommonUtility::styleDateTime($OriginalPostTime->sec)?> </i></div>
             <div class=" stream_content">
            <ul>
            <li class="media"><?php if(sizeof($notification->Artifacts)>0){?>
                    
                    <?php  
                             $extension = "";
                             $videoclassName="";
                             $extension = strtolower($artifacts->Extension);
                              if($extension == 'mp4' || $extension == 'flv' || $extension == 'mov') {
                                      $videoclassName = 'videoThumnailDisplay';
                                    
                                }else {
                                    $videoclassName='videoThumnailNotDisplay';
                                }
                            
                           ?>
                            
                            <?php
                       
                                $className = ""; 
                                $uri = "";
                               
                                $imageVideomp3Id = "";
                                $extension = strtolower($artifacts->Extension);
                                if($extension == "mp4" || $extension == "avi" || $extension == "flv" || $extension == "mov" || $extension == "mp3" ){ 
                                    $className = "videoimage";
                                    $uri = $artifacts->Uri;
                                    $imageVideomp3Id = "imageVideomp3_dnsNotification";
                                }else{
                                    $className = "postdetail";                                
                                   
                                } 
                               
                            ?>
                             
                                <a  class="pull-left img_single "    data-videoimage="<?php echo $uri; ?>" data-vimage="<?php  echo $artifacts->ThumbNailImage ?>"><div id='img_streamVideoDivDSNNewPost' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php  echo $artifacts->ThumbNailImage ?>"   ></a>
                       
                    
                    
                    
                   
                    <?php } ?>
              <div class="media-body">
              <p><?php echo $notification->Description?> </p>
                  
                  <!-- Nested media object -->
              
              </div>
              
              </li>
              </ul>
          </div>
        </div>
          
           
            </div>

 






<?php }?>