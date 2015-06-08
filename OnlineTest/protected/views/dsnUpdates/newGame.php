<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($notification))
{
    
    ?>
  <div class="dsn_notifications_float">
            	    
        <div class="dsn_notifications">
        	<div class="stream_title paddingt5lr10 bg_w">New game&nbsp; <b><?php  echo $notification->GameName;?> </b> has been started</div>
             <div class=" stream_content">
            <ul>
            <li class="media">
              <?php if($notification->Description!=""){?>
               <div class="media-body">
              <p><?php echo $notification->Description?> </p>
                  
                  <!-- Nested media object -->
              
              </div>
<?php }?>
              
              </li>
              </ul>
          </div>
        </div>
          
           
            </div>

  <!-- one -->
                
            <!-- one end -->  



<?php }?>