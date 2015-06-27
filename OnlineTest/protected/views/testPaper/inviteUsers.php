<?php include 'inviteUsersScript.php'; ?>
<div class="alert alert-error" id="errmsgForInviteUsers" style='display: none'></div>
<div class="alert alert-success" id="sucmsgForInviteUsers" style='display: none'></div> 

<div class="padding10">    
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
                <label>Name</label>
                    <?php echo $form->textField($inviteForm, 'Name', array('maxlength' => '15', 'class' => 'form-control', "placeholder" => "Name","style"=>"width:150px")); ?>    
                <div class="control-group controlerror"> 
                    <?php echo $form->error($inviteForm, 'Name'); ?>
                </div>
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
    <?php
    $form1 = $this->beginWidget('CActiveForm', array(
        'id' => 'invites-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'style' => 'margin: 0px; accept-charset=UTF-8',
        ),
    ));
    ?><?php echo $form->hiddenField($inviteForm, 'AllUsers',array("value"=>"")); ?>
    <?php echo $form->hiddenField($inviteForm, 'TestId',array("value"=>$surveyId)); ?>
    <div class="alert alert-success" id="sucmsgForInviteUserTestSchedule" style='display: none'></div> 
    <div id="inviteuser_div">
        <div style="position: relative">
            <div  class="block">
                
                <table cellspacing="0" cellpadding="0" width="100%" border="0" class="dtb_header">
                    <thead><tr><th><input type="checkbox" class="styled" />Allf</th><th class="data_t_hide">Test Taker</th></tr></thead>
                    <tbody>
                        <tr id="noRecordsTR" style="display: none">
                            <td colspan="8">
                                <span class="text-error"> <b>No records found</b></span>
                            </td>
                        </tr>
                         <?php $i=1;foreach($data as $Details){?> 
                    <tr class="<?php if($i%2==0){echo "odd";}else{echo "even";} ?>" >
                        <td class="UserTd">
                            <input type="checkbox" name="usercheck" class="styled" value="<?php echo $Details['UserId']; ?>"/>
                        </td>  
                        <td  class="data_t_hide">
                            <?php echo $Details['FirstName']." ".$Details['LastName'];?>
                        </td>
                    </tr>
                         <?php $i++;}?>
                    </tbody>
                </table>
            </div>        
        </div>
    </div>
    <div id="filterInviteusers_div"></div>
    <div class="row-fluid">
        <div class="span12">
                <label>&nbsp;&nbsp;</label>
                    <?php 
                        echo CHtml::button('Submit',array("id"=>"submitInviteUsers",'class' => 'btn')); 
                        //echo "&nbsp;";
                        //echo CHtml::resetButton('Reset', array("id" => 'resetInviteUsers', 'class' => 'btn btn_gray')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        Custom.init();
        loadEvents();
    });
    var UserIdAlls = "";
    var AllUserIds="";
    function loadEvents() {
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var checkin = $('#dpd1').datepicker({
            onRender: function(date) { 
                return date.valueOf() < now.valueOf() ? '' : '';
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
                return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');

    }
    
    $("#searchInviteUsers").click(function() {
               var startDate = $("#InviteUserForm_StartDate").val();
               var endDate = $("#InviteUserForm_EndDate").val();
       //$("#pagetitle").html("Market Research Analytics");InviteUserForm_AllUsers
        var searchText=$("#InviteUserForm_Name").val();
        //var AllUsers =$("#InviteUserForm_AllUsers").val();
        //$("#inviteuser_div").hide();
        //getInviteUsersWithFiltersDetails(0,"all",searchText);    
        getInviteUsersWithFiltersDetails(0,startDate,endDate,searchText);    
        //$("#filterInviteusers_div").show();
        $("#inviteuser_div").show();
        isDuringAjax = true;
//        ajaxRequest("/extendedSurvey/getSurveyAnalyticsData", {}, getSurveyAnalyticsHandler)
    });
    
    function getInviteUsersWithFiltersDetails(startLimit, startDate,endDate, searchText) {
        if (startDate == "" || startDate == undefined) {
            startdate = "";
        }
        startdate = $.trim(startDate);
        g_startdate = startdate; // assgining filtervalue to global variable...
        if (endDate == "" || endDate == undefined) {
            enddate = "";
        }
        enddate = $.trim(endDate);
        g_enddate = enddate; // assgining filtervalue to global variable...
        if (startLimit == 0) {
            g_pageNumber = 1;
        }
        if (searchText == 'search') {
            searchText = "";
        }
        var queryString = "startDate="+g_startdate+"&endDate=" + g_enddate + "&searchText=" + searchText + "&startLimit=" + startLimit + "&pageLength=" + g_pageLength;
        //scrollPleaseWait('spinner_admin');
        ajaxRequest("/testPaper/getInviteUsersDetails", queryString, getInviteUsersWithFiltersHandler)        
    }
// handler for getInviteUsersWithFiltersDetails...
    function getInviteUsersWithFiltersHandler(data) {
        
        //scrollPleaseWaitClose('spinner_admin');
        var item = {
            'data': data
        };
        $("#inviteuser_div").html(
            $("#inviteUserList_render").render(item)
        );
        if (g_pageNumber == undefined) {
            g_page = 1;
        } else {
            g_page = g_pageNumber;
        }
        if (g_startdate != '') {
            $("#InviteUserForm_StartDate").val(g_startdate);
        } else {
            g_startdate = "";
        }
        if (g_enddate != '') {
            $("#InviteUserForm_EndDate").val(g_enddate);
        } else {
            g_enddate = "";
        } 
        if(g_searchText != undefined && g_searchText != ""){
           
        }
        if (data.total == 0) {
            $("#pagination").hide();
            $("#noRecordsTR").show();
        }
        $("#pagination").pagination({
            currentPage: g_page,
            items: data.total,
            itemsOnPage: g_pageLength,
            cssStyle: 'light-theme',
            onPageClick: function(pageNumber, event) {
                g_pageNumber = pageNumber;
                var startLimit = ((parseInt(pageNumber) - 1) * parseInt(g_pageLength));
                getInviteUsersWithFiltersDetails(startLimit, g_startdate, g_enddate, g_searchText);
            }

        });

        if ($.trim(data.searchText) != undefined && $.trim(data.searchText) != "undefined") {

            $('#searchTextId').val(data.searchText);
        }
        $("#searchTextId").val(g_searchText);
        Custom.init();
        $("[rel=tooltip]").tooltip();
    }

    
    $(".UserTd span").die().live("click",function(){
        var $this = $(this);
        $("input[name='usercheck']").each(function(key, value) {            
        if($(this).is(":checked")){
            if(UserIdAlls == ""){
                UserIdAlls = $(this).val();
            }else {
                UserIdAlls = UserIdAlls+","+$(this).val();
            }
        }
        
    });
    
    
    AllUserIds = UserIdAlls;
    $("#InviteUserForm_AllUsers").val(AllUserIds);
    
    UserIdAlls='';
    AllUserIds='';
    
    
    });
    $("#submitInviteUsers").click(function() {
            if($("#InviteUserForm_AllUsers").val()==''){
                $("#errmsgForInviteUsers").css("display", "block");
                $("#errmsgForInviteUsers").html("Check the Test taker(s).").fadeOut(6000);
            }
        var queryString = "TestId=" + $("#InviteUserForm_TestId").val() + "&UserIds=" + $("#InviteUserForm_AllUsers").val();
        //scrollPleaseWait('spinner_admin');
        ajaxRequest("/testPaper/saveInviteUsersDetails", queryString, saveInviteUsersHandler); 
        $("#InviteUserForm_AllUsers").val('');
       
    });
    function saveInviteUsersHandler(data){
        if(data.status=='success'){
            $("#sucmsgForInviteUsers").css("display", "block");
            $("#sucmsgForInviteUsers").html("Invite Users added Successfully.").fadeOut(6000,"linear",function(){
                getInviteUsersWithFiltersDetails(0,"all",'');
            });
        }
    }
    </script>
