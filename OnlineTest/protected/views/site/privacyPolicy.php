 <section class="login_bg" style="clear:both; height:370px; "> </section >
<section style="clear:both;" >
    <div class="container"  >   
<div class="customLoginform custominstructionsformwidth positioninstructions " >
            <div class="customLoginbg marginlr0">
<div class=" pagetitlebg marginlr0 paddingbottom8 pagetitleloginbg" >
                    <div class="section_pagetitle_padding padgetitle">
                        <h4 class="padding-left12" style="height:53px">&nbsp;</h4>
                        
                    </div>
<div class="upload_profile  ">
<div class="generalprofileicon skiptaiconwidth190x190">
<a href="#" class="skiptaiconinner "><img src="<?php echo Yii::app()->session['TinyUserCollectionObj']->ProfilePicture?>"> </a>

</div>

 </div>
<div class="section_pagetitle_padding padgetitle paddingbottom8">
                        <h4 class="padding-left12">WELCOME TO TECHO2!</h4>
                        
                    </div>
<div class="row " >
                    <div class="col-xs-12 ">
                        <div class="reg_area"> 
                            
                            <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'privacy_form',
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
   
    
    <?php if(isset($TestInfo) && sizeof($TestInfo)>0){ ?>
                            <?php foreach($TestInfo->Category as $row) {
                           $totalTime +=$row['CategoryTime'];
                                        $totalMarks +=$row['CategoryScore'];
                       } ?>
                            
                            <p>You are ready to take the <b><?php echo $TestInfo->Title ;?></b> now!</p>
                            <p><b>Test anatomy</b></br>
                                This test is for total of <?php echo $totalMarks;?> points and you’ll have a total of <?php echo $totalTime;?> minutes for the entire test. The test is organized under one or more categories. The test make up is as follows:</p>

                       
                       
                       <table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr><th style="width:30%">Category Name</th><th>Marks</th><th>Time</th></tr>
                           <?php $i=1;  foreach ($TestInfo->Category as $row) { ?>
                           <tr>
                               <td><?php echo $row['CategoryName']; ?></td>
                               <td><?php echo $row['CategoryScore']; ?></td>
                               <td><?php echo $row['CategoryTime']." (mins)"; ?></td>
                           </tr>
                           <!--<p><b>Section<?php //echo $i ?>:<?php //echo $row['CategoryName']; ?></p>
                           <p><b>Number of Questions in Section<?php //echo $i ?> :<?php //echo $row['NoofQuestions']; ?></p>
                           <p><b>Time for Section<?php //echo $i ?>:<?php //echo $row['CategoryTime']; ?></p>-->
                                <?php  //$i++;} 
                                
                                }}
?>
                       </table>
<p><b>How does the system work?</b></br>
                                        Each category has a set of questions with specific duration. You will have to answer all the questions in a category within the duration allocated for that category. However, you can switch between categories and the questions don’t have to be answered sequentially. Each category of questions have timers associated with them on the right hand side for your convenience to learn how much time is left for each category.  When you switch between categories, the relevant timers fire off and the system will only count down time in the active category. You will not be able to revisit the questions in a category if you have used up all the allocated time for that category.</p>                                     
                                        <p>When you click the "I got this" button below, your test will start immediately.</p>
                                        <p><b>Navigation</b></br>
                                        Use the Next button below each question to move to the next question in sequence. If you want to go to a question out of sequence, use the category widgets on the right hand side to a question directly.</p>
                                        <p><b>Test Completion</b></br>
                                        When you are done with your test (either after finishing all the questions, or if you think you had enough for the day), ensure that you click "I'm done" button on the right hand side. This submits your test answers and is mandatory to complete your test.</p>
                                        <p><b>Don’t do this!</b></br>
                                        Do not use browser buttons to navigate between pages, and only use the navigation options described above. Do not use browser refresh option. Do not close out the browser for any reason. If you see something wrong, contact the support staff for assistance.</p>
                                        <p>Good luck!</p>
                       <div class="text-center">
 <?php echo CHtml::Button('I got this', array('onclick' => 'savePrepareTest();', 'class' => 'btn btn-primary btn-raised btn-custom', 'id' => 'surveyFormButtonId')); ?>
                           </div>
                        <?php $this->endWidget(); ?>
                           
                        </div></div>
</div>
   
</div>
            </div>
</div>
          </div>
</section>
 
<script type="text/javascript">
    
function savePrepareTest() {
   // window.open('/outside/index','','toolbar=no');
     window.location.href = "/outside/index";
   
    
//    ajaxRequest("/question/QuestionPrepare", 'UserId=' + $("#PrivacyPolicyForm_UserId").val() + '&TestId=' + $("#PrivacyPolicyForm_TestPaperId").val(), function(data) {
//                    renderOptionswidgetHandler(data)
//            });
//        
//        alert('hai')
//         $.ajax({
//            type: 'POST',
//            url: '/questionPrepare/questionPrepare?UserId=' + $("#PrivacyPolicyForm_UserId").val() + '&TestId=' + $("#PrivacyPolicyForm_TestPaperId").val(),
//            data: data,
//                success: privacyHandler,
//                error: function(data) { // if error occured
//                    // alert("Error occured.please try again==="+data.toSource());
//                  alert(data.toSource());
//                },
//                dataType: 'json'
//        });
    }
    function renderOptionswidgetHandler(data){ 
         window.location.href = "question/questionpaperview";
    }
        function privacyHandler(data){
      data = eval(data);          
      window.location.href = "site/privacyPolicy";
    }
</script>