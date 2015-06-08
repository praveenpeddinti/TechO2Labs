<div class="dropdownsectionarea dropdownmedium">
<div class="row-fluid ">
    <div class="span12 positionrelative" >
        <?php if($type == "checkbox"){ ?>
        <div class="span9">
            
            <div class="span6">
                <div class="pull-left labelalignment_c"><label class="rr_widget"><?php echo Yii::t("translation","Ex_DisplayType"); ?></label></div>
                <div class="pull-left positionrelative">
            <select class="styled questionDisplayType" style="width:100%;" id="displaytype_<?php echo $widgetCount; ?>" name="displaytype_<?php echo $widgetCount; ?>" data-optionType="<?php echo $type; ?>" data-questionid="<?php echo $widgetCount; ?>">
                <option value="1"><?php echo Yii::t("translation","Ex_DisplayType_Check"); ?></option>
                <option value="2"><?php echo Yii::t("translation","Ex_DisplayType_Multi"); ?></option>
            </select>
            </div>
                
            </div>
            
            
        </div>
        <?php } ?>
        <div class="span3 positionabsolutediv " style="right:0; ">
                <select class="styled selectoptions" style="width:100%;" id="selectoptions_<?php echo $widgetCount; ?>" name="selectoptions_<?php echo $widgetCount; ?>" data-optionType="<?php echo $type; ?>" data-questionid="<?php echo $widgetCount; ?>">
                <?php for($opt=1;$opt<=30;$opt++){ ?>
                <option value="<?php echo $opt; ?>" <?php if($opt == 4) echo "selected"; ?>><?php $str = "option"; if($opt > 1){
                    $str = $str."s";
                } echo $opt." ".$str; ?></option>
                <?php }?>
            </select>

        </div>
    </div>

</div>
    </div>