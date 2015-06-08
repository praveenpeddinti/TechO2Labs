<input type="hidden" name="ExtendedSurveyForm[NoofOptions][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>" />
<input type="hidden" name="ExtendedSurveyForm[MatrixType][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_MatrixType_hid_<?php echo $widgetCount; ?>" value="1"/>
<input type="hidden" name="ExtendedSurveyForm[TotalValue][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_TotalValue_hid_<?php echo $widgetCount; ?>"/>
<div class="paddingtblr1030">
   
     <?php include 'WidgetOptions.php'; ?>
    
    
     <div class="tab_5">
     <div class="dropdownsectionarea dropdownsmall">
     <div class="row-fluid">
     <div class="span3">
      <div class="pull-left labelalignment"><label>Total Value</label></div>
     <div class="pull-left positionrelative">
         <input type="text" class="span9 textfield" data-error="ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>_em_"  maxlength="4" size="8" data-hiddenname="ExtendedSurveyForm_TotalValue_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>" onkeyup="insertText(this.id)" onblur="insertText(this.id)">
    <div class="control-group controlerror">
        <div style="display:none"  id="ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
    </div>
     </div>
     </div>
     <div class="span5">
    <div class="pull-left labelalignment"><label>No.of Options</label></div>
     <div class="pull-left positionrelative">
         <select style="width:170px" class="styled span6" data-error="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>_em_"   data-hiddenname="ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>" id="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>" name="ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>">
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
     <div class="span4">
     <div class="pull-left labelalignment"><label>Unit type</label></div>     
     <div class="pull-left positionrelative">
         <select style="width:120px" class="styled" id="unitypeddn_<?php echo $widgetCount; ?>" name="unittype_<?php echo $widgetCount; ?>">          
          <option value="1">%</option>
          <option value="2">$</option>               
     </select>
     </div>
     </div>
     </div>
    
     </div>
         
     <div class="answersection1" data-type="percentage" id="percentageWidget_<?php echo $widgetCount; ?>" data-questionId="<?php echo $widgetCount; ?>">
         </div>
     <input type="hidden" name="ExtendedSurveyForm[Other][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_Other_<?php echo $widgetCount; ?>" class="otherhidden"/>
     <input type="hidden" name="ExtendedSurveyForm[OtherValue][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_OtherValue_<?php echo $widgetCount; ?>" class="otherhiddenvalue" value="Other"/>
            <div class="normaloutersection">
                <div class="normalsection othersarea" id="othersarea_<?php echo $widgetCount; ?>">
                    <div class="surveyradiobutton"> <input type="checkbox" class="styled othercheck" name="1" id="othercheck_<?php echo $widgetCount; ?>" /> <i>Others</i> </div>  
                    <div class="row-fluid otherTextdiv" style="display: none;" id="otherTextdiv_<?php echo $widgetCount; ?>">
                        <div class="span12">
                            <div class="control-group controlerror"> 
                                <input type="text" placeholder="Other Value" id="otherText_<?php echo $widgetCount; ?>" class="span12 textfield othertext notallowed"  data-hiddenname="ExtendedSurveyForm_OtherValue_<?php echo $widgetCount; ?>"  onkeyup="insertText(this.id)" onblur="insertText(this.id)"/>
                                <div class="control-group controlerror">
                                    <div style="display:none"  id="ExtendedSurveyForm_OtherValue_<?php echo $widgetCount; ?>_em_" class="errorMessage othererr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
            </div>
     
     </div>
     </div>
<script type="text/javascript">
Custom.init();
$("[rel=tooltip]").tooltip();
$("#ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>").change(function(){
    var $this = $(this);
    $("#ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>").val($this.val());
    var TotalValue = $("#ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>").val();
    var optionValue = $this.val();
    var URL = "/extendedSurvey/renderPercentageOptions";
    var renderV = 0;
    var renTemp = 0,
            preq = 0,
            i=0;
    
    $(".normalouter_<?php echo $widgetCount; ?>").each(function(key){
            renderV++;
        }); 
      if(TotalValue == "" || TotalValue == 0){
          $("#selectExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>").html("Please select");
          $("#ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>").val("");
          $("#ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>_em_").text("Total Value cannot be blank");
          $("#ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>_em_").show();
          $("#ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>_em_").fadeOut(7000);    
          
      }
    if(optionValue > renderV){
        optionValue = optionValue - renderV;
        if(optionValue != 0 && TotalValue != 0){        
            $("#ExtendedSurveyForm_TotalValue_hid_<?php echo $widgetCount; ?>").val(TotalValue);
            ajaxRequest(URL, "questionNo=<?php echo $widgetCount; ?>&optionsCount="+optionValue+"&unitType="+$("#unitypeddn_<?php echo $widgetCount; ?>").val() , function(data) {
                renderPerHandler(data, '<?php echo $widgetCount; ?>')
            }, "html");
        }
    }else if(optionValue < renderV){
            preq = 0;
            renTemp = renderV;
            i = 0;
            $(".percentagehidden").each(function(key){
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
                if(renTemp != optionValue){                    
                    $("#ExtendedSurveyForm_OptionName_hid_" + (renTemp) + "_<?php echo $widgetCount; ?>").remove();                    
                    renTemp--;
                } 
            });
            preq = 0;            
            renTemp = renderV;
            i = 0;
            $(".percentageOptionname").each(function(){
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
                
                if(renTemp != optionValue){  
                    $("#ExtendedSurveyForm_percentage_" + (renTemp) + "_<?php echo $widgetCount; ?>").closest("div.normaloutersection").remove();
                    renTemp--;
                }                    
                
            });
            preq = 0;
            nextq = 0;
            renTemp = renderV;
            i = 0;
            $(".percentageOptionerr").each(function(){
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
                
                if(renTemp != optionValue){  
                    $("#ExtendedSurveyForm_OptionName_" + (renTemp) + "_<?php echo $widgetCount; ?>_em_").remove();
                    renTemp--;
                }               

            });
    }
});
$("#unitypeddn_<?php echo $widgetCount; ?>").change(function(){
    var $this = $(this);
    $("#ExtendedSurveyForm_MatrixType_hid_<?php echo $widgetCount; ?>").val($this.val()); 
    var TotalValue = $("#ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>").val();
    var optionValue = $("#ExtendedSurveyForm_NoofOptions_hid_<?php echo $widgetCount; ?>").val();
    var errmsgTV="",errmsgOp="";
    var erridop,erridtv;
    var URL = "/extendedSurvey/renderPercentageOptions";
    erridtv = $("#ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>").attr("data-error");
    if(TotalValue == ""){
        errmsgTV = "Total value cann't be blank";
    }else if(!$.isNumeric(TotalValue) || TotalValue == 0){
        errmsgTV = "Total value is in between 2 and 10";
    }
    if(errmsgTV != ""){
        $("#"+erridtv).show();
        $("#"+erridtv).text(errmsgTV);
        $("#"+erridtv).fadeOut(7000,function(){errmsgTV = "";});

    }
    erridop = $("#ExtendedSurveyForm_NoofOptions_<?php echo $widgetCount; ?>").attr("data-error");
    
    if(optionValue == ""){
        errmsgOp = "No of Options cann't be blank";
    }else if(!$.isNumeric(optionValue) || optionValue == 0){
        errmsgOp = "Options value is in between 2 and 10";
    }
    if(errmsgOp != ""){
        $("#"+erridop).show();
        $("#"+erridop).text(errmsgOp);
        $("#"+erridop).fadeOut(7000,function(){errmsgOp = "";});

    }
    var renderV = 0;
    $(".normalouter_<?php echo $widgetCount; ?>").each(function(){
        renderV++;
    });
    if(optionValue > renderV){
        optionValue = optionValue - renderV;
        if(optionValue != 0 && TotalValue != 0){        
            $("#ExtendedSurveyForm_TotalValue_hid_<?php echo $widgetCount; ?>").val(TotalValue);
            ajaxRequest(URL, "questionNo=<?php echo $widgetCount; ?>&optionsCount="+optionValue+"&unitType="+$this.val() , function(data) {
                renderPerHandler(data, '<?php echo $widgetCount; ?>')
            }, "html");
        }
    }else if(optionValue == renderV){
        $(".perUnitType_<?php echo $widgetCount; ?>").each(function(){
            var unitType = $("#unitypeddn_<?php echo $widgetCount; ?>").val();
            if(unitType == 1 ){
                $(this).html("%");
            }else if(unitType == 2){
                $(this).html("$");
            }    
            
        });
    }
    
     
});
    function renderPerHandler(html,questionno){    
        $("#percentageWidget_"+questionno).append(html);
//        $(".perUnitType_<?php echo $widgetCount; ?>").each(function(){
//            var unitType = $("#unitypeddn_<?php echo $widgetCount; ?>").val();
//            if(unitType == 1 ){
//                $(this).html("%");
//            }else if(unitType == 2){
//                $(this).html("$");
//            }    
//            
//        });
       var preq = 0;
       var nextq = 0;
       var i = 0;
        $(".percentagehidden").each(function(){
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
        $(".percentageOptionname").each(function(){
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
            $this.attr("id", "ExtendedSurveyForm_percentage_" + (i) + "_" + qNo);
            $this.attr("data-hiddenname", "ExtendedSurveyForm_OptionName_hid_" + (i) + "_" + qNo);
            
        });
        preq = 0;
        nextq = 0;
        i = 0;
        $(".percentageOptionerr").each(function(){
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
$("#ExtendedSurveyForm_TotalValue_<?php echo $widgetCount; ?>").keydown(function (e) {
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
</script>