

<div class="sidebar-nav_outer">
    <div class="sidebar-nav " id="menu_bar">

    <ul  id="menu" >

        <li <?php if ($this->whichmenuactive == 1) { ?>class="active"<?php } ?> id="homestream"><a href="/" class="left_home-icon" > <span><?php echo Yii::t('translation','Home'); ?></span></a></li>
        
         
        
       

<?php if (Yii::app()->session['IsAdmin'] == 1) { ?>
            <li class="hovermenu <?php if ($this->whichmenuactive == 8) { ?> active<?php } ?>" id="admin"  ><a class="left_admin-icon" ><span><?php echo Yii::t('translation','Admin'); ?></span></a>
                <ul class="subnavinner subnavinneradmin" id="adminsubmenu">

                    <li ><a href="/users"><?php echo Yii::t('translation','User_Management'); ?></a></li>
                   <?php if (Yii::app()->params['ESurvey'] == 'ON') { ?>
                    <li><a href="/marketresearchwall">Market dashboard</a></li>
                          
                   <?php } ?>
                    
                </ul>
                
            </li> 
              
        <?php
        
} ?>
<li><a href="/testpaper">Test Paper</a></li>

    </ul>
        <div class="leftfooterlinks">
            <div>
            <a class="cursor" onclick="openFooterTabs('/common/termsOfServices');">Terms of Use</a>
            </div>
            <div>
            <a class="cursor" onclick="openFooterTabs('/common/privacyPolicy');">Privacy Policy</a>
            </div>
        </div>
</div>
</div>
