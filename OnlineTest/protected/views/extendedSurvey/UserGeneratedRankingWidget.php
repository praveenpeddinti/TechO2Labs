<input type="hidden" name="ExtendedSurveyForm[NoofOptions][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>" />
<div class="paddingtblr1030">
    
     <?php include 'WidgetOptions.php'; ?>
    <?php include 'newfileuploadscript.php';?>
     <div class="tab_6">        
     <div class="dropdownsectionarea dropdownsmall">
         <div class="row-fluid">
             <div class="span8">
                 <div class="pull-left labelalignment"><label>No.of Options:</label></div>
                 
                 <div class="pull-left positionrelative">
                     <select style="width:180px;" class="styled span6" data-error="ExtendedSurveyForm_NoofOption_<?php echo $widgetCount; ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>">
                    <option value="">Please select</option>
                    <?php for($i=2;$i<10;$i++){ ?>
                         <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                         <?php } ?>
                </select>
                     <div class="control-group controlerror">
                   <div style="display:none"  id="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
               </div>
            </div>
             </div>
             </div>
         </div>
     
     <div class="answersection1" id="userGeneratedRankingwidget_<?php echo $widgetCount; ?>" data-questionId="<?php echo $widgetCount; ?>" data-optionType="usergeneratedRanking">
     

     </div>
     
     
     </div>
     </div>
<script type="text/javascript">
$(document).ready(function(){
   Custom.init(); 
   $("[rel=tooltip]").tooltip();
});

$("#ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>").change(function(event) {
        var $this = $(this);
        var value = $this.val();
       
        var renderV = 0;   
        var renTemp = 0;
        $(".normalouter_<?php echo $widgetCount; ?>").each(function(key){
            renderV++;
        });
        if(value > renderV){
            value = value - renderV;
            $("#ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>").val($this.val());
            var URL = "/extendedSurvey/renderUserGeneratedWidget";
            ajaxRequest(URL, "questionNo=<?php echo $widgetCount; ?>&optionsCount=" + value, function(data) {
                renderHandler(data, '<?php echo $widgetCount; ?>')
            }, "html");
        }else if(value < renderV){  
            //value = renderV - value;
            preq = 0;
            renTemp = renderV;
            i = 0;
            $(".usergeneratedhidden").each(function(key){
                var $this = $(this);
                var qNo = $this.closest("div.answersection1").attr("data-questionId");
                if (preq == 0) {
                    i = 0;
                    preq = qNo;
                }
                if (preq == qNo) {
                    i++;
                } else {
                    preq = qNo;
                    i = 1;
                }                               
                if(renTemp != value){                    
                    $("#ExtendedSurveyForm_OptionName_hid_" + (renTemp) + "_<?php echo $widgetCount; ?>").remove();                    
                    renTemp--;
                } 
            });
            preq = 0;
            nextq = 0;
            renTemp = renderV;
            i = 0;
            $(".userGeneratedOptions").each(function(){
                var $this = $(this);
                var qNo = $this.closest("div.answersection1").attr("data-questionId");
                if (preq == 0) {
                    i = 0;
                    preq = qNo;
                }
                if (preq == qNo) {
                    i++;
                } else {
                    preq = qNo;
                    i = 1;
                }
                
                if(renTemp != value){  
                    $("#ExtendedSurveyForm_userGRanking_" + (renTemp) + "_<?php echo $widgetCount; ?>").closest("div.normaloutersection").remove();
                    renTemp--;
                }                    
                
            });
            preq = 0;
            nextq = 0;
            renTemp = renderV;
            i = 0;
            $(".usergeneratederrorMsg").each(function(){
                var $this = $(this);
                var qNo = $this.closest("div.answersection1").attr("data-questionId");
                if (preq == 0) {
                    i = 0;
                    preq = qNo;
                }
                if (preq == qNo) {
                    i++;
                } else {
                    preq = qNo;
                    i = 1;
                }
                
                if(renTemp != value){  
                    $("#ExtendedSurveyForm_OptionName_" + (renTemp) + "_<?php echo $widgetCount; ?>_em_").remove();
                    renTemp--;
                }               

            });
            
        }
        
        
        if (value <= 0 || value > 10) {
            $("#usergeneratedRankingwidget_<?php echo $widgetCount; ?>").empty();            
            //$("#surveyFormButtonId").hide();
        }else{
            //$("#surveyFormButtonId").show();
        }
    });

    $("#ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    function renderHandler(html, questionno) { 
        $("#userGeneratedRankingwidget_" + questionno).append(html);
        preq = 0;
        nextq = 0;
        i = 0;
        $(".usergeneratedhidden").each(function(key){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            if (preq == 0) {
                i = 0;
                preq = qNo;
            }
            if (preq == qNo) {
                i++;
            } else {
                preq = qNo;
                i = 1;
            }
            $this.attr("id", "ExtendedSurveyForm_OptionName_hid_" + (i) + "_" + qNo);
            $this.attr("name", "ExtendedSurveyForm[OptionName][" + (i) + "_" + qNo+"]");
            
            
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".userGeneratedOptions").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            if (preq == 0) {
                i = 0;
                preq = qNo;
            }
            if (preq == qNo) {
                i++;
            } else {
                preq = qNo;
                i = 1;
            }
            $this.attr("id", "ExtendedSurveyForm_userGRanking_" + (i) + "_" + qNo);
            $this.attr("data-hiddenname", "ExtendedSurveyForm_OptionName_hid_" + (i) + "_" + qNo);
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".usergeneratederrorMsg").each(function(){
            var $this = $(this);
            var qNo = $this.closest("div.answersection1").attr("data-questionId");
            if (preq == 0) {
                i = 0;
                preq = qNo;
            }
            if (preq == qNo) {
                i++;
            } else {
                preq = qNo;
                i = 1;
            }
            $this.attr("id", "ExtendedSurveyForm_OptionName_" + (i) + "_" + qNo+"_em_");
            
        });
    }    
</script>