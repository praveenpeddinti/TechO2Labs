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
<a href="#" class="skiptaiconinner "><img src="<?php echo Yii::app()->session['TinyUserCollectionObj']->ProfilePicture?>"> </a><span class="helpicon"><a href="#"><img src="/images/helpicon_w.png"></a></span>

</div>

 </div>
<div class="section_pagetitle_padding padgetitle paddingbottom8">
                        <h4 class="padding-left12">WELCOME TO TECHO2 ONLINE TEST </h4>
                        
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
   
    
    <?php //echo $form->hiddenField($PrivacyPolicyForm, 'TestPaperId',array("value"=>"558961abf298fd35048b4573")); ?>
                            <?php //echo "<pre>",print_r($TestInfo),"</pre>";
                                if(isset($TestInfo) && sizeof($TestInfo)>0){
                            ?>
                            
                            <p><b>Test Name: </b><?php echo $TestInfo->Title ;?></p>
                            <p><b> Description: </b><?php echo $TestInfo->Description; ?>
                       <!--<p><b>Total Questions: <?php //echo $TestInfo->NoofQuestions; ?></p>-->
                       <?php foreach($TestInfo->Category as $row) {
                           $totaltme +=$row['CategoryTime'];
                       } ?>
                       <p><b>Total Time: </b><?php echo $totaltme ?></p>
                       <table><tr><th>Category Name</th><th>Marks</th><th>Time</th></tr>
                           <?php $i=1;  foreach ($TestInfo->Category as $row) { ?>
                           <tr>
                               <Td><?php echo $row['CategoryName']; ?></Td>
                               <Td><?php echo $row['CategoryScore']; ?></Td>
                               <Td><?php echo $row['CategoryTime']." (mins)"; ?></Td>
                           </tr>
                           <!--<p><b>Section<?php //echo $i ?>:<?php //echo $row['CategoryName']; ?></p>
                           <p><b>Number of Questions in Section<?php //echo $i ?> :<?php //echo $row['NoofQuestions']; ?></p>
                           <p><b>Time for Section<?php //echo $i ?>:<?php //echo $row['CategoryTime']; ?></p>-->
                                <?php  //$i++;} 
                                
                                }}
?>
                       </table>
                       <div>
                           <p>When you click the submit the button. The test will start, it is a <b><?php echo $totaltme;?></b> mins long test.
                               Category wise questions and time.</p>

<p><b>Step 1</b> Do Not Use the "Back" Button on Your Browser During the Test once you have begun taking the test. Instead, use the right buttons to go the next question or click the next button or previos button.
Don't close the window of the test for any reason.

If something goes wrong, contact to your instructor.</p>

<p><b>Step 2</b> Review All of Your Answers Before Submitting the Test.</p> 

<p><b>Step 3</b> When you are satisfied with the result make sure you finish by clicking the Completed Test button at the bottom of the screen. Click the Completed Test Button ONLY ONCE!</p>

<p><b>Keep In Mind:</b> It is important that you click the Completed Test button your test is completed.</p>
                       </div> 
                       <div class="text-center">
 <?php echo CHtml::Button('Submit', array('onclick' => 'savePrepareTest();', 'class' => 'btn btn-primary btn-raised btn-custom', 'id' => 'surveyFormButtonId')); ?>
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