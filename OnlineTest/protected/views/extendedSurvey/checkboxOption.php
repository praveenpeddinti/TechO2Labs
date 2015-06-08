<div class="normaloutersection">
    <div class="normalsection">
        <div class="surveyradiobutton">
             <div class="disabledelement"></div>
            <input type="checkbox" class="styled "  readonly="true"></div>
        <div class="surveyremoveicon"><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="Delete option"/></div>
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group controlerror"> 
                    <input type="hidden"  id="checkbox_hidden_<?php echo $widgetCount; ?>" class="checkboxhidden"/>
                    <input placeholder="Option Name" value="" type="text" class="textfield span12 checkboxtype notallowed" name="checkbox_<?php echo $widgetCount; ?>" id="checkboxid_<?php echo $widgetCount; ?>" onblur="insertText(this.id)"  onkeyup="insertText(this.id)" />
                    <div style="display:none"  class="errorMessage checkboxEmessage"  id="checkboxEmessage_<?php echo $widgetCount; ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        Custom.init();
        $("[rel=tooltip]").tooltip();
    </script>