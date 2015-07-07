<div class="alert alert-success" id="sucmsg" style='text-align:center;display:none;'></div>
<div class="alert alert-error" id="errmsgForCheckTestPaper" style='display: none'></div>
<div class="padding10ltb">
    <div class="row-fluid groupseperator headermarginzero" id="dashboardtop">
    <div class="span12 paddingtop10 border-bottom">
        <div class="span12"><h2 class="pagetitle" id="pagetitle">Score Board</h2></div>
      
    </div>
  
</div>    
    
    
</div>
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'invite-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'style' => 'margin: 0px; accept-charset=UTF-8',
        ),
    ));
    ?>
    
    <div id="inviteUsersSpinner"></div>
    <div class="row-fluid">
        <div class="span12">
            <div class="span4">
                <div style="padding-right: 60px" id="dpd1" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">
                    <label><?php echo Yii::t('translation', 'EventPost_Start_lable'); ?></label>
                    <?php echo $form->textField($inviteForm, 'StartDate', array('maxlength' => '20', 'class' => 'textfield span11 ', 'readonly' => "true")); ?>    
                    <span class="add-on">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($inviteForm, 'StartDate'); ?>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div id="dpd2" style="padding-right: 60px" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">
                    <label><?php echo Yii::t('translation', 'EventPost_Enddate_lable'); ?></label>
                    <?php echo $form->textField($inviteForm, 'EndDate', array('maxlength' => '20', 'class' => 'textfield span11', 'readonly' => "true")); ?>    
                    <span class="add-on">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($inviteForm, 'EndDate'); ?>
                    </div>
                </div>
            </div>
            <div class="span4">
                <?php $j=1;foreach($reportData as $Details){ if($j==sizeof($reportData)){?> 
                            <?php foreach($Details->categoryScoreArray as $value){?>
                            <label><?php echo $value['categoryName'];?></label>
                            <input id="<?php echo $value['categoryName'];?>" type="text" maxlength="3" />
                            <?php }} $j++;}?>
                    
            </div>
            
            
            
    </div>
    <div class="row-fluid">
        <div class="span12">
                <label>&nbsp;&nbsp;</label>
                    <?php 
                        echo CHtml::button('Search',array("id"=>"searchInviteUsers",'class' => 'btn')); 
                        echo "&nbsp;";
                        echo CHtml::resetButton('Reset', array("id" => 'resetInviteUsers', 'class' => 'btn btn_gray')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div id="inviteuser_div">
     
    </div>
<script>
    
$(document).ready(function(){
    Custom.init();
        loadEvents();
   var data= {"testPaperId":"<?php echo $testPaperId?>"};
  
      ajaxRequest("/reports/renderReports",data ,renderReportsHandler, "html");

});
    function loadEvents() {
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var checkin = $('#dpd1').datepicker({
            onRender: function(date) { 
                return date.valueOf() < now.valueOf() ? '' : 'disabled';
            }
        }).on('changeDate', function(ev) {
            if ((ev.date.valueOf() > checkout.date.valueOf()) || checkout.date.valueOf() != "") {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 0);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('#dpd2')[0].focus();
        }).data('datepicker');

        var checkout = $('#dpd2').datepicker({
            onRender: function(date) {
                return date.valueOf() < checkin.date.valueOf() ? '' : 'disabled';
            }
        }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');

    }
function renderReportsHandler(html){
    //alert('renderReportsHandler--'+html);
    $("#inviteuser_div").html(html);
}
$("#reviewNow").live(function(){
     var data= {"testPaperId":"559a561c900cecfc1f8b4620","userId":"169"};
   ajaxRequest("/reports/getReviewQuestions",data ,reviewQuestionsHandler, "html");
});
function reviewQuestionsHandler(html){
    alert(html);
}
</script>

