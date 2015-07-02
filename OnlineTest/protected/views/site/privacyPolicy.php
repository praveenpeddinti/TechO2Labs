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
<a href="#" class="skiptaiconinner "><img src="/images/sreeni.png"> </a><span class="helpicon"><a href="#"><img src="/images/helpicon_w.png"></a></span>

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
    <?php echo $form->hiddenField($PrivacyPolicyForm, 'UserId',array("value"=>"166")); ?>
    <?php echo $form->hiddenField($PrivacyPolicyForm, 'TestPaperId',array("value"=>"558961abf298fd35048b4573")); ?>
            
                       <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
                       <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
                       <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
                       <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
      
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
    function renderOptionswidgetHandler(data){ alert('kkkkkk=='+data.toSource());
         window.location.href = "question/questionpaperview";
    }
        function privacyHandler(data){
      data = eval(data);          
      window.location.href = "site/privacyPolicy";
    }
</script>