<?php

/*
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */

class ScheduleGameForm extends CFormModel {

   public $GameName;
   public $StartDate;
   public $EndDate;
   public $ShowDisclaimer;
   public $ShowThankYou;
   public $ThankYouMessage;
   public $ThankYouArtifact;
   public $IsPromoted;
   public $StreamId;
   public $MigratedScheduleId;
     public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';
    public function rules() {
        return array(
           
//            array('IFrameMode', 'ext.YiiConditionalValidator.YiiConditionalValidator',
//                'if' => array(
//                             array('IFrameMode', 'compare', 'compareValue'=>"0"),
//                ),
//                'then' => array(
//                             array('GroupName, Description','required')
//                    ),
//            ),
            
            array('StartDate', 'required'),           
            array('EndDate', 'required'),
            array('NetworkId,SegmentId,Language,GameName,StartDate,EndDate,ShowDisclaimer,ShowThankYou,ThankYouMessage,ThankYouArtifact,IsPromoted,StreamId,MigratedScheduleId', 'safe'),
            array('ShowThankYou', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('ShowThankYou', 'compare', 'compareValue'=>"1"),
                        ),
                        'then' => array(
                            array('ThankYouMessage', 'required'),
                        ),
                 ),
        );
    }

}
