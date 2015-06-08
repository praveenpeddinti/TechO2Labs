<?php

/*
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */

class GroupCreationForm extends CFormModel {
    public $id;
    public $GroupName;
    public $ShortDescription;
    public $Description;
    public $UserId;
    public $GroupProfileImage;
    public $Artifacts;
    public $IFrameMode;
    public $IFrameURL;
    public $CreatedOn;
    public $IsPrivate;
    public $AutoFollow;
    public $MigratedGroupId;
    public $GroupMenu;
    public $ConversationVisibility;
    public $AddSocialActions=1;
    public $DisableWebPreview=0;
    public $DisableStreamConversation=0;
    public $SubSpeciality;   
    public $RestrictedAccess = 0;
    public $FileName;
    public $Status;
    public $SegmentId=0;
    public $NetworkId=1;
    public function rules() {
        return array(
            array('IFrameMode', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                'if' => array(
                             array('IFrameMode', 'compare', 'compareValue'=>"1"),
                ),
                'then' => array(
                             array('IFrameURL, GroupName, Description','required'),
                              array(
                                'IFrameURL',
                                'match', 'pattern' => '/(https|http):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/',
                                'message' => Yii::t('translation','URL_should_start_with').' https://.',
                            ),
                    ),
            ),
            array('IFrameMode', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                'if' => array(
                             array('IFrameMode', 'compare', 'compareValue'=>"0"),
                ),
                'then' => array(
                             array('GroupName, Description','required')
                    ),
            ),
            array('IFrameMode', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                'if' => array(
                             array('IFrameMode', 'compare', 'compareValue'=>"2"),
                ),
                'then' => array(
                             array('GroupName, Description,GroupMenu','required')
                    ),
            ),
            array('IFrameMode', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                'if' => array(
                             array('IFrameMode', 'compare', 'compareValue'=>""),
                ),
                'then' => array(
                             array('GroupName,Description,IFrameMode','customRequired'),                                                          
                    ),
            ),

            array('id,GroupName,Description,IFrameURL,IsPrivate,AutoFollow,GroupMenu,ConversationVisibility,AddSocialActions,DisableWebPreview,DisableStreamConversation,GroupProfileImage,SubSpeciality,RestrictedAccess,FileName,Status,NetworkId,SegmentId', 'safe'),

//            array(
//                            'GroupName',
//                            'match', 'not' => true, 'pattern' => "#[^a-z0-9'@\"\s-]#i",
//                            'message' => 'Invalid characters in group name',
//                      ),
            
        );
    }
    
    public function customRequired($attribute_name,$params){  
    try{
        if($attribute_name == "GroupName" && $this->GroupName == "")
            $this->addError('GroupName',Yii::t('translation','GroupName_cannot_be_blank'));
        if($attribute_name == "Description" && $this->Description == "")
            $this->addError('Description',Yii::t('translation','Description_cannot_be_blank'));
        if($attribute_name == "IFrameMode" && $this->IFrameMode == "" && !isset($this->id))
            $this->addError('IFrameMode',Yii::t('translation','Please_choose_Group_Mode'));
    } catch (Exception $ex) {
	Yii::log("GroupCreationForm:customRequired::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
        
    }
    


}
