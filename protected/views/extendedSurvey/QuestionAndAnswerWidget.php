<input type="hidden" name="ExtendedSurveyForm[NoofChars][<?php echo $widgetCount; ?>]" id="ExtendedSurveyForm_NoofChars_hid_<?php echo $widgetCount; ?>"/>
<div class="paddingtblr1030">
    
    <?php include 'WidgetOptions.php'; ?>
    
    <div class="tab_5">
        <div class="dropdownsectionarea dropdownsmall">
            <div class="pull-left labelalignment"><label>No.of Characters:</label></div>
            <div class="pull-left positionrelative">
                <select class="styled span6" style="width:200px;" id="noofchars_<?php echo $widgetCount; ?>" name="noofchars_<?php echo $widgetCount; ?>">
                    <option value="">Please select</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                </select>
                <div class="control-group controlerror">
                    <div style="display:none"  id="ExtendedSurveyForm_NoofChars_<?php echo $widgetCount; ?>_em_" class="errorMessage"></div>
                </div>
            </div>
        </div>
        <div class="answersection1">
            <div class="normaloutersection">
                <div class="normalsection normalsection5">

                    <div class="row-fluid" style="display:none" id="rowfluidChars_<?php echo $widgetCount; ?>">
                        <div class="span12">   
                            <input value="" type="text" class="textfield span12 notallowed" id="qAaTextField_<?php echo $widgetCount; ?>" disabled="true"/>
                            <textarea class="span12" id="qAaTextarea_<?php echo $widgetCount; ?>" disabled="true"></textarea>     
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        Custom.init();
        $("[rel=tooltip]").tooltip(); 
    });
    
    $("#noofchars_<?php echo $widgetCount; ?>").change(function() {
        var $this = $(this);
        if ($this.val() == 100){            
            $("#qAaTextarea_<?php echo $widgetCount; ?>").hide();
            $("#qAaTextField_<?php echo $widgetCount; ?>").show();
        }else if($this.val() > 100){            
            $("#qAaTextarea_<?php echo $widgetCount; ?>").show();
            $("#qAaTextField_<?php echo $widgetCount; ?>").hide();
        }
        if($this.val() >= 1){
            $("#rowfluidChars_<?php echo $widgetCount; ?>").show();
            $("#ExtendedSurveyForm_NoofChars_hid_<?php echo $widgetCount; ?>").val($this.val());
        }
        if($this.val() == ""){
            $("#surveyFormButtonId").hide();
        }else{
            $("#surveyFormButtonId").show();
        }
    });
</script>