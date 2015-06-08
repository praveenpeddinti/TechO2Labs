
<?php 
 if(is_array($groupFollowers)){?>

    
<?php $i = 0; foreach($groupFollowers as $follower ){?>
<?php if($i == 0){ ?>
<div class="row-fluid" style="margin:1px;padding: 4px;">
    <div class="span12">
<?php } ?>
        <!--<div id="stream_view_spinner_<?php // echo $follower->UserId?>" style="position:relative;"></div>-->
    <div class="span4">
        <div class="media" >
            <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a  data-toggle="modal" data-name="<?php echo $follower->DisplayName?>" class="skiptaiconinner profileDetails">
                      <img src="<?php echo $follower->profile250x250?>">
                  
                  </a>
                     </div>
                  <div class="media-body" style="padding:4px;">
                      <div data-name="<?php echo $follower->DisplayName?>"  class="m_title profileDetails"><?php echo $follower->DisplayName?></div>
                    </div>
                </div>
                    </div>
        
        <?php $i++; 
            if($i == 3){
                $i = 0;
            }
            if($i == 0){ ?>
        </div>
        </div>
        <?php } ?>
        <?php }?>
        
<?php }
      else{
          echo $groupFollowers;
      }
?>

