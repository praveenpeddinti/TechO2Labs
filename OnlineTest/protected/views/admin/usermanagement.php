<?php
include 'userMgmntScript.php';
//include 'userSettings.php';
?>
<div id="advanceOptionsSpinner"></div>
<?php if(Yii::app()->params['Project']!='SkiptaNeo'){?>
<?php $mainClass=(Yii::app()->params['Project']!='Trinity')?"streamsectionarea  streamsectionarearightpanelno":"";?>
<div class="<?php echo $mainClass ?>">
        <div class="padding10 ">
<?php }?>
     <div class="row-fluid groupseperator headermarginzero" id="dashboardtop">
    <div class="span12 paddingtop10 border-bottom">
        <div class="span12"><h2 class="pagetitle" >User Management</h2></div>
       </div>
  </div>
            <div id="usermanagement_div"></div>
<?php if(Yii::app()->params['Project']!='SkiptaNeo'){?>
        </div>
    </div>
<?php }?>
<script type="text/javascript">
    getMgmntHandler(<?php echo $data; ?>);
    $('#ChangeRoleDropDown ul li a').live('click', function(event){
        if($(event.target).parent('li.active').length){
            return false;
        }
        var userId = $(this).attr('data-userId');
        var roleId = $(this).attr('data-roleId');
        conformChangeRole(userId, roleId);
    });
</script>