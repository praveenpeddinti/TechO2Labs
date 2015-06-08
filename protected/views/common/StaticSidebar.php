<div class="sidebar-nav_outer">
<div class="sidebar-nav unlogedProfile" id="menu_bar1">
    <ul  id="menu">
        <li class="" id="post" ><a class="left_home-icon" > <span><?php echo Yii::t('translation','Home'); ?></span></a></li>
        <li class="" id="curbsidepost" ><a class="left_curbside-icon"><span><?php echo Yii::t('translation','Curbside'); ?></span></a></li>
         <li id="grouppost"  ><a class="left_groups-icon" ><span><?php echo Yii::t('translation','GroupsLabel'); ?></span></a></li>
      <?php if (Yii::app()->params['News'] == 'ON') { ?>
         <li class="" id="news" ><a class="left_news-icon" ><span><?php echo Yii::t('translation','News'); ?></span></a></li>
      <?php } ?>
               <?php if (Yii::app()->params['QuickLinks'] == 'ON') { ?>
        <li id="weblinks" ><a  class="left_quicklinks-icon left_quicklinks-iconwidth"><span><?php echo Yii::t('translation','Quick_Links'); ?></span></a></li>
        <?php }?> 
          <?php if (Yii::app()->params['Games'] == 'ON') { ?>
        <li class="" id="games" ><a class="left_games-icon" ><span><?php echo Yii::t('translation','Games'); ?></span></a></li>
          <?php } ?>
            <?php if (Yii::app()->params['Careers'] == 'ON') { ?>
        <li class="" id="careers" ><a class="left_career-icon" ><span><?php echo Yii::t('translation','Careers'); ?></span></a></li>
            <?php } ?>
    </ul>
</div>
</div>   
