<?php if($optionType == "radio"){ ?>
<div class="normaloutersection">
    <div class="normalsection">
        <div class="surveyradiobutton"> <input type="radio" class="styled "  disabled="true"></div>
        <div class="surveyremoveicon"><img src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="Delete option"/></div>
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group controlerror"> 
                    <input type="hidden"  id="radio_hidden_<?php echo $widgetCount; ?>" class="radiohidden"/>
                    <input placeholder="Option Name" value="" type="text" class="textfield span12 radiotype notallowed" name="radio_<?php echo $widgetCount; ?>"  id="radioid_<?php echo $widgetCount; ?>" onblur="insertText(this.id)" onkeyup="insertText(this.id)" />
                    <div style="display:none"  class="errorMessage radioEmessage"  id="radioEmessage_<?php echo $widgetCount; ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else { ?>
<!-- Booelan -->
<div class="normaloutersection">                    
    <div class="normalsection">
        <div class="surveyradiobutton"> 
            <?php if($sType == 1){ ?>
            <input type="radio" class="styled"  disabled="true">
            <?php }else{?>
            <div class="disabledelement"></div>
            <input type="checkbox" class="styled "  readonly="true">
            <?php } ?>
        </div>
        <div class="surveyradiofollowup confirmation_<?php echo $widgetCount; ?>" id="confirmation_<?php echo $widgetCount; ?>" data-value=""><input id="needJust_<?php echo $widgetCount; ?>" type="radio"  name="confirmradio_<?php echo $widgetCount; ?>" class="styled confirmraido" value=""/></div>
        <div class="row-fluid">
            <div class="span12">
                <input type="hidden"  id="radio_hidden_<?php echo $widgetCount; ?>" class="booleanoptionhidden"/>
                <input placeholder="Option Name" type="text" class="textfield span10 radiotype_boolean"  name="boolean_<?php echo $widgetCount; ?>"  id="radioid_<?php echo $widgetCount; ?>" onblur="insertText(this.id)" onkeyup="insertText(this.id)"/>
                <div class="control-group controlerror">  
                    <div style="display:none" id="radioEmessage_<?php echo $widgetCount; ?>" class="errorMessage booleanradioEmessage"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script type="text/javascript">
    Custom.init();
    $("[rel=tooltip]").tooltip();
</script>