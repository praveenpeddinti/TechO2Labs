<div class="row-fluid padding10top">
    <div class="span12">
        <div id="Referral_sucmsg" class="alert alert-success margintop5 " style="display: none"></div>
        <div class="alert alert-error" id="Referral_errmsg" style='padding-top: 5px;text-align:left;display:none;'></div>
          <div id="referral_user_spinner"></div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span12">
                            <div class="control-group">
                                <label><?php echo Yii::t('translation','email'); ?> <b style="align:left"> <i class="fa fa-question helpicon helpmanagement top6  tooltiplink" data-id="referral" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Enter_emails_with_comma_separated'); ?>" style="position: relative;top:auto;vertical-align: middle;right:auto"></i></b></label>
                                
                                        
                                <textarea name="userReferral_email" cols="" rows="" class="span12" id="userReferral_email" placeholder="<?php echo Yii::t('translation','Enter_Email_here'); ?>..."></textarea>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span12">
                            <div class="control-group" id="userReferral_div_message">
                                <label><?php echo Yii::t('translation','Message'); ?></label>
<!--                                <textarea  name="userReferral_message" cols="" rows="" class="span12" id="userReferral_message" placeholder="Enter message here..."></textarea>-->
                                <div id="userReferral_message"  placeholder="<?php echo Yii::t('translation','Enter_Message_here'); ?>..." class="referrerplaceholder referralMessage"  contentEditable="true"  onkeyUp="expanddiv(this.id)" ></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12 alignright">
                        <input name="userreferral"  id="userreferralSubmit" type="submit"  value="<?php echo Yii::t('translation','Submit'); ?>" class="btn ">
                        <input name="userreferralCancel"  id="userreferralCancel" type="button" value="<?php echo Yii::t('translation','Cancel'); ?>" class="btn btn_gray">
                    </div>
                </div>
           
     </div>
</div>