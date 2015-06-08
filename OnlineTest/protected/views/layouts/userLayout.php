<?php include 'header.php';
$user_present = Yii::app()->session->get('TinyUserCollectionObj');
if(isset($user_present) || Yii::app()->params['Project']!='SkiptaNeo') {?>
<section id="streamsection" class="streamsection" >
    <div class="container" id="mainCont">
        <?php if(Yii::app()->params['Project']=='Trinity'){ include 'leftsideWidgets.php'; }?>
        <?php if(Yii::app()->params['Project']=='SkiptaNeo'){ include 'leftmenu.php'; }?>
        <?php if ($this->sidelayout == 'yes') { ?>
            <div class="sidebar-nav_right" id="rightpanel">
                <?php //include 'rightsideWidgets.php'; ?>
            </div>
        <?php } ?>
        <div class="streamsectionarea padding10" id="notificationHomediv" style="display:none;">
            <div class="padding10ltb">
                <h2 class="pagetitle"><?php echo Yii::t('translation','History'); ?> 
                    <a id="history_close" href="#" class="notification_history_close pull-right" rel="tooltip" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t('translation','close'); ?>"> <i class="fa fa-times"></i></a>         
                </h2> 
                <div style="text-align: right" id="markallasreaddiv">
                    <div class="markread" style="padding-bottom:4px;">
                        <a class="markallasread_notification markasreadlink" data-notificationflag="1" href="#" data-type="history" rel="tooltip" data-toggle="tooltip" data-placement="bottom" title="<?php echo Yii::t('translation','Mark_all_as_Read'); ?>"><i  class="fa fa-check"></i> <?php echo Yii::t('translation','Mark_all_as_Read'); ?> </a>
                    </div>
                </div>
                <div id="notificationHistory" style="display: none" ></div>
                <div id="history_spinner" style="position:relative;" ></div>

            </div>
        </div>
        <div id="nomorenotifications" style="display:none;">                
            <div class="notificationresults" style="text-align: center;font-size: 16px;" id="notificationText"></div>
        </div>
                <div id="admin_PostDetails" class="streamsectionarea padding10 displayn"></div>
 <div id="chatSpinLoader"></div>
        <div id='chatDiv' class="streamsectionarea  padding10 displayn"></div>
        <div id="norecordsFound" class="displayn streamsectionarea padding10"></div>
        <div id="tosAndPrivacyPolicy"></div>
        <div class="streamsectionarea <?php if ($this->sidelayout == 'yes') { ?>streamsectionarearightpanel<?php } ?>" id="contentDiv">
        <div class="padding10">
        <?php echo $content; ?>
        </div>
        </div>
   </div>
</section>
<?php }else{ ?>
    
   <?php echo $content; ?>
  
 <?php }?>
<?php include 'footer.php' ?>
