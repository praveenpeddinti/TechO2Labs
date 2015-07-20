<div class="alert alert-success" id="sucmsg" style='text-align:center;display:none;'></div>
<div class="alert alert-error" id="errmsgForCheckTestPaper" style='display: none'></div>
<div class="padding10ltb">
    <div class="row-fluid groupseperator headermarginzero" id="dashboardtop">
    <div class="span12 paddingtop10 border-bottom">
        <?php $t=0;foreach($reportDataIndex as $value){?>
                            <?php $t=$t+$value['CategoryScore'];?>
                            <?php }?>
        <div class="span3"><h2 class="pagetitle" id="pagetitle">Score Board </h2></div>
        <div class="span3"> <b>Test Name:</b> <?php echo $Title;?></div>
        <div class="span3"> <b>Total Question(s):</b><?php echo $Questions ;?></div>
        <div class="span3"> <b>Total Mark(s):</b><?php echo$t;?></div>
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
    <input type="hidden" id="TId" value="<?php echo $testPaperId?>"/>
    
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
                <?php //$j=1;foreach($reportDataIndex as $Details){ if($j==sizeof($reportDataIndex)){?> 
                
                            <?php //foreach($Details->categoryScoreArray as $value){?>
                            <!--<label><?php ///echo $value['categoryName'];?></label>
                            <input class="categorysearch" id="<?php //echo $value['categoryName'];?>" type="text" maxlength="3" />-->
                            <?php //}} $j++;}?>
                    
                
                            <?php foreach($reportDataIndex as $value){?>
                            <label><?php echo $value['CategoryName'];?></label>
                            <input class="categorysearch" id="<?php echo $value['CategoryName'];?>" type="text" maxlength="3" />
                            <?php }?>
            </div>
            
            
            
    </div>
    <div class="row-fluid">
        <div class="span12">
                <label>&nbsp;&nbsp;</label>
                    <?php 
                        echo CHtml::button('Search',array("id"=>"reportssearchUsers",'class' => 'btn')); 
                        echo "&nbsp;";
                        echo CHtml::resetButton('Reset', array("id" => 'resetInviteUsers', 'class' => 'btn btn_gray')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div id="inviteuser_div">
     
    </div>
    <script>
    $("#reportssearchUsers").click(function() { 
        var testPaperId=$("#TId").val();
        var startDate = $("#InviteUserForm_StartDate").val();
        var endDate = $("#InviteUserForm_EndDate").val();
        var searchText='';
        $(".categorysearch").each(function(){
            var $this = $(this);
        //if($this.val()!=''){
           
        if(searchText==''){
                searchText = $this.attr("id")+"~"+$this.val();
            }else{
                searchText = searchText+','+$this.attr("id")+"~"+$this.val();
            }//}
        });
        
        getInviteUsersWithFiltersDetails(0,testPaperId,startDate,endDate,searchText);
        //var data= {"testPaperId":testPaperId,
        //           "startDate":startDate,             
        //           "endDate":endDate,
        //           "Arithmetic1":cat1
        //          };
  
      //ajaxRequest("/reports/renderReports",data ,renderReportsHandler, "html");
        
    });
   

</script>
<script>
    
    
var g_filterValue = "";
var g_pageNumber = 1;
var g_searchText = "";
var g_startLimit = 0;
var g_pageLength = 5; 
 var g_startdate = "";
 var g_enddate = "";
 var startdate = enddate = "";
$(document).ready(function(){
    Custom.init();
        loadEvents();

        
   renderReport();


});
function renderReport(){
     var data= {"testPaperId":"<?php echo $testPaperId?>","startDate":'',"endDate":'',"pageLength":g_pageLength};
  
    //    var data= {"testPaperId":"<?php echo $testPaperId?>"};
    ajaxRequest("/reports/renderReports",data ,renderReportsHandler, "html");
}

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
                return date.valueOf() > checkin.date.valueOf() ? '' : 'disabled';
            }
        }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');

    }
function renderReportsHandler(html){
    
    $("#inviteuser_div").html(html);
    var testPaperId=$("#TId").val();
        if (typeof g_pageNumber == "undefined") {
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
         $("#pagination").pagination({
            currentPage: g_page,
            items: Number($("#reporsttopdiv").attr("data-total")),
            itemsOnPage: g_pageLength,
            cssStyle: 'light-theme',
            onPageClick: function(pageNumber, event) {
                g_pageNumber = pageNumber;
                var startLimit = ((parseInt(pageNumber) - 1) * parseInt(g_pageLength));
                getInviteUsersWithFiltersDetails(startLimit,testPaperId, g_startdate, g_enddate, g_searchText);
            }

        });
        
        
}

$("#reviewNow").live("click",function(){
    var testPaperId = $(this).attr("data-testid");
    var userId = $(this).attr("data-userid");
     var data= {"testPaperId":testPaperId,"userId":userId};
   sessionStorage.reviewUserId = userId;
   ajaxRequest("/reports/getReviewQuestions",data ,reviewQuestionsHandler, "html");
});
function reviewQuestionsHandler(html){
    try{
          $("#newModal .modal-dialog").removeClass('info_modal');
        $("#newModal .modal-dialog").removeClass('alert_modal');
        $("#newModal .modal-dialog").removeClass('error_modal');
        $("#newModalLabel").html("Review Questions");
         $("#newModal .modal-dialog").css('width',"1000px");
        $("#newModal_footer").hide();
        $("#newModal_body").html(html);
        $("#newModal").modal('show');
    }catch(err){alert(err);
    }
   
}


function getInviteUsersWithFiltersDetails(startLimit, testPaperId,startDate,endDate, searchText) {
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
        //if (searchText == 'search') {
          g_searchText = searchText;
        //}
        var queryString = "testPaperId="+testPaperId+"&startDate="+g_startdate+"&endDate=" + g_enddate + "&searchText=" + g_searchText + "&startLimit=" + startLimit + "&pageLength=" +g_pageLength;
        ajaxRequest("/reports/renderReports", queryString, renderReportsHandler,"html")        
    }

    


$("#submitReviewAnswers").live("click",function(){
    
    var finalResult = new Array();
    
    $("[name=reviewQuestions]").each(function( index ) {
         var result = new Object();
     var testPaperId = $( this ).attr("data-testId");
     var questionId = $( this ).attr("data-qid");
     var categoryId = $( this ).attr("data-categoryId");
      var uniqueId = $( this ).attr("data-uniqueId");
     var score = $( this ).val();
        var data= {"testPaperId":testPaperId,"questionId":questionId,"categoryId":categoryId,"score":score};
    
        result.testPaperId=testPaperId;
        result.questionId=questionId;
        result.categoryId=categoryId;
        result.uniqueId=uniqueId;
        result.score=score;
       finalResult.push(result);
       });
       //finalResult.data= result;
      var jsonProducts = JSON.stringify(finalResult);
     // alert(jsonProducts);
      var data={"data":jsonProducts,"reviewUserId":sessionStorage.reviewUserId};
       ajaxRequest("/reports/saveReviewQuestions",data ,saveReviewQuestionsHandler);
})
function saveReviewQuestionsHandler(data){
    
     $("#newModal").modal('hide');
    renderReport();
    }

function validAnswer(evt,value,Score){
    var id = evt.target.id;    
    if(Number(value)>Number(Score)){
       $("#"+id).val('');
      
    }
    
}

//XLS Reports
$("#exportExcel").live("click",function(){
   var testId = $(this).attr("data-testId");
  
  var startDate = $("#InviteUserForm_StartDate").val();
        var endDate = $("#InviteUserForm_EndDate").val();
        var searchText='';
        $(".categorysearch").each(function(){
            var $this = $(this);
        //if($this.val()!=''){
           
        if(searchText==''){
                searchText = $this.attr("id")+"~"+$this.val();
            }else{
                searchText = searchText+','+$this.attr("id")+"~"+$this.val();
            }//}
        });
        
   //scrollPleaseWait('spinner_admin');
  window.open("/extendedSurvey/generateSurveyTakenUsersInfoAnalyticsXLS?testId="+testId+"&sDate="+startDate+"&eDate="+endDate+"&searchCat="+searchText);
});

</script>

