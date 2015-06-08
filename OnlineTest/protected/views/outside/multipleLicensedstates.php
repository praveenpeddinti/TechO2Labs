<div  class="row-fluid" id="options_<?php echo $vCnt; ?>">
    <div class="span12">
        <div class="span4 positionrelative">
            <input type="hidden" name="MarketResearchFollowUpForm[LicensedState][<?php echo $vCnt; ?>]" id="MarketResearchFollowUpForm_LicensedStates_<?php echo $vCnt; ?>"/>                                    
            <label><?php echo Yii::t('translation','User_LicensedState'); ?></label>
            <select data-id="<?php echo $vCnt; ?>" style="width:320px" class="styled licstates" id="licensedStates_<?php echo $vCnt; ?>" name="MarketResearchFollowUpForm[LicensedState][<?php echo $vCnt; ?>]" >
                <option value="">Please Select state</option>
                <?php
                foreach ($states as $s) {?>
    
 <option value="<?php echo $s["id"]?>"><?php echo $s["State"]?></option>
                
                <?php
                
                }
                ?>
            </select>
             <div class="control-group controlerror marginbottom20 " >
            <div style="display:none" id="MarketResearchFollowUpForm_LicensedStates_<?php echo $vCnt; ?>_em_" class="errorMessage"  ></div>
        </div>
            </div>
        <div class="span4">            
            <label><?php echo Yii::t('translation','User_LicensedNumber'); ?></label>
            <div class="control-group controlerror marginbottom10">      
                <input type="text" name="MarketResearchFollowUpForm[LicensedNumber][<?php echo $vCnt; ?>]" id="MarketResearchFollowUpForm_LicensedNumbers_<?php echo $vCnt; ?>" data-id="<?php echo $vCnt; ?>" class="span12 textfield licnumber" onblur="insertText(this.id);"/>
                
                <div class="control-group controlerror marginbottom20 " >
                
                <div style="display:none" id="MarketResearchFollowUpForm_LicensedNumbers_<?php echo $vCnt; ?>_em_" class="errorMessage"  ></div>
            </div>
                </div>

        </div>  
        <div class="span1 normaloutersection "><div class="normalsection userInfor_r"><div class="userInfor_r_del surveyremoveicon pull-left"><img data-original-title="Remove option" rel="tooltip" data-placement="bottom" src="/images/system/spacer.png" class="deleteoption" data-value="<?php echo $vCnt; ?>"/></div>
            </div></div>
    </div>
</div> 
<script type="text/javascript">

</script>