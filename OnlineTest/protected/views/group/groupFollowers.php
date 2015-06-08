
<?php if($offset==0 && is_object($groupFollowers)){?>
<div class="row-fluid groupseperator">
     <div class="span3 paddingtop18"><h2 class="pagetitle">
              <?php echo Yii::t('translation','Followers'); ?> </h2></div>
          <div class="span9 ">
          <div class="grouphomemenuhelp alignright"></div>
          
          
          </div>
     
     </div>
<?php } ?>
<?php 
 if(is_object($groupFollowers)){?>

    
                 <?php foreach($groupFollowers as $follower ){?>
    <?php if($i == 0){ ?>
    <div class="row-fluid">
    <div class="span12">
    <?php } ?>
        <!--<div id="stream_view_spinner_<?php // echo $follower->UserId?>" style="position:relative;"></div>-->
    <div class="span2">
       
    <div class="followersprofile" data-userId="<?php echo $follower->UserId?>" data-id="<?php echo $follower->UserId?>">
  
    <div class="generalprofileicon  skiptaiconwidth80x80 generalprofileiconborder5 skiptaiconwidth90x90groupfollowers">
                  <a class="skiptaiconinner" >
                       <img src=<?php echo $follower->profile250x250?> >
                                                                  
                  </a>
                     </div>    
    <div class="f_p_name"><?php echo $follower->DisplayName?></div>
    
    </div>
        
    </div>
     <?php $i++;  if($i == 6){ ?>  
        </div>
        </div>
     <?php $i = 0;} 
     ?>
 <?php }?>
<?php }
      else{
          echo $groupFollowers;
      }
?>