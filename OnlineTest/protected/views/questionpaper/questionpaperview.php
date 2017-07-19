<?php include 'questionview.php'; ?>
<?php
//echo "Quesion paper view";

  
//   $questions = $viewObj->Questions;  
//   foreach ($questions as $value) {
//       echo $value["CategoryName"]."<br/>";
//      $CategoryQuestions =  $value["CategoryQuestions"];
//      foreach($CategoryQuestions as $cQuestions){
//            echo $cQuestions."<br/>";
//      }
//}
//echo "<br/><br/><br/>";
//echo "<pre>",print_r($defaultQuestion),"</pre>";
//if(is_object($viewObj)){
//echo "hai";

?>
<section >
<div class="container">
        <div class="marginT80">
<div class="container pagetitlebg">
<div class="section_pagetitle_padding padgetitle">
<h4>Question View <span class="helpicon"><a href="#"><img src="/images/helpicon.png"></a></span></h4>
<h5>This is a quick overview of some features</h5>
</div>
</div>
            <div id="sss"></div>
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'questionprepare_form',
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

<div class="row">
  <div class="col-xs-12  col-md-9 col-sm-8" style="margin-right:0; padding-right:0px;">
   <div class="row" style="margin-right:0; padding-right:0px;">
  <div class="col-xs-12 col-md-12 col-sm-12 mobileview1" style="margin-right:0; padding-right:0px;">
      <div class="questions_area_left_outer">
      	<div class="questions_area_left_inner" id="question_area">
            <?php if($defaultQuestion['QuestionType'] == 1) {?>
        <div class="question_options_div">
        	<div class="question position_R"> <label class="question_no">1) </label><?php echo $defaultQuestion['Question']; ?></div>
            <div class="q_options">
            	<ol>
                    <?php $i=0;foreach($defaultQuestion['Options'] as $rw) { ?>
                	<li><input name="answerinput" type="radio" value="<?php echo ($i+1); ?>"> <?php echo $rw; ?></li>
                <?php } ?>
                    
                </ol>
            </div>
        </div>
            <?php }else if($defaultQuestion['QuestionType'] == 2) { ?>
            kjkdfkdfdfdk
                
                <?php } ?>
        </div>
      </div>
  </div>
  </div>
  </div>
  <div class="col-xs-12 col-md-3  col-sm-4" style="margin-left:0; padding-left:0px;"><div class="dashboardbox dashboardboxrightpanel mobileview3">
 <div class="questions_area_left_outer">
 <!-- question catogories -->
<div class="q_catogories">
   <?php  $questions = $viewObj->Questions;  
   foreach ($questions as $value) {
             $CategoryQuestions =  $value["CategoryQuestions"];
      
   ?>  
    <div class="q_catogories_progress_active">
   	<h3><?php echo $value["CategoryName"]; ?></h3>
    <p>Questions Answered 2 out of 10 </p>
    <?php $j=0;
    foreach($CategoryQuestions as $cQuestions){ ?>
    <a href="#" class="qstnnumber"  data-catname = "<?php echo $value["CategoryName"]; ?>" onclick="getQuestion(<?php echo ($j+1); ?>)" data-qid="<?php echo $cQuestions; ?>" id="qstnId_<?php echo ($j+1); ?>">
        <?php echo ($j+1); 
             $j++;?>
    </a>
    <?php } ?>
    
<!--    <table cellpadding="0" cellspacing="0" width="100%" border="0">
    	<tr>
        	<td style=" text-align:right;padding-right:5px"><img src="/images/time_h.png" width="52" height="52"></td>
            <td style="text-align:left; padding-left:5px"><img src="/images/time_s.png" width="52" height="52"></td>
        </tr>
    </table>-->
   </div>
            
 <?php 
} ?>
   
 <!-- question catogories end -->
</div>
</div></div>
</div>


        </div>
             <?php $this->endWidget(); ?>
</div>
    
   </section>
<script type="text/javascript">

function getQuestion(sno){ 
    //alert(sno)
    var qid = $("#qstnId_"+sno).attr("data-qid");
    var catname = $("#qstnId_"+sno).attr("data-catname");
   // alert(qid); alert(catname);
    /*$.ajax({
            url: '/questionpaper/question?qstnId='+qid+'&catName='+catname,
            data: data,
                success: questionHandler,
                error: function(data) { // if error occured
                    // alert("Error occured.please try again==="+data.toSource());
                  alert(data.toSource());
                },
                dataType: 'json'
        });*/
        var qstng = {qstnId: qid,catName:catname};
       // alert("[[[[+"+qstng);
       ajaxRequest("/questionpaper/question", qstng , questionHandler);
           
} 


function questionHandler(data){
    //alert('me2');   //$('#question_area').html(data)
   //alert("ddfdf--"+data.toSource());
    //var item = {
     //       'data': data
     //   };
        $("#sss").html(
            $("#question_Tmp").render()
        );
//alert("ddfdf-2-"+data.status);
        //$("#question_area").html(data.data.SurveyTitle);
    
}


</script>
    