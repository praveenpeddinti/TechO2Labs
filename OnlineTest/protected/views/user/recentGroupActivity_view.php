<?php
if ($groupActivityListCount > 0) {
    ?>
 <div class="rightwidget borderbottom1 padding-bottom10 " id="rightSideSectionSeperation2" >
<div class="rightwidgettitle paddingt12">
        <i class="spriteicon"><img class="r_g_activity" src="/images/system/spacer.png"></i><span class="widgettitle"><?php echo Yii::t('translation','Group_Activity'); ?></span>
    </div>
 
<div class="r_followersdiv r_widgetmarginbottom10">
 <div class="media lineheight16 padding39 GroupActivity">
     <ul>
         <?php 
            foreach ($groupActivityList as $data) {
                ?>
         <li>
             <div name="GroupDetailInRightWidget" data-id="<?php echo$data->GroupId ?>" data-name="<?php echo $data->GroupUniqueName ?>"  style="cursor: pointer">
              <a class="pull-left marginzero maxwidth80" href="#">
                 <?php
            if ($data->GroupIcon !='') {
                ?>
                       
                  <img src="<?php echo $data->GroupIcon ?> ">
                   <?php } else{
                   ?>
                  <img src="/images/system/nogroup.png">
                   <?php } 
                   ?>
                  </a>
                  <div class="media-body">
                      <div class="r_ga_content" ><?php echo html_entity_decode($data->GroupName); ?>
                  </div>
                  </div>
                 </div>
             <div class="clearboth"></div>
             
         </li>
         <?php } ?>
     </ul>
                 
     
                </div>
        </div>
  </div> 
<?php } ?>