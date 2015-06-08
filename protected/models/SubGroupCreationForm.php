<?php

/* 
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */
class SubGroupCreationForm extends CFormModel
{ 
    public $id;
    public $SubGroupName;    
    public $SubGroupDescription;
    public $UserId;
    public $GroupProfileImage;
    public $GroupId;
    public $ShowPostInMainStream;
   public $AddSocialActions=1;
    public $DisableWebPreview=0;
    public $DisableStreamConversation=0;
  public $NetworkId=1;
  public $SegmentId=0;
  public $Language='en';
  public $Status=1;
    
    public function rules() {
        return array(
            // username and password are required
            array('SubGroupName', 'required'),
           // array('ShortDescription', 'required'),
            array('SubGroupDescription', 'required'),

            array('id,GroupId,ShowPostInMainStream,AddSocialActions,DisableWebPreview,DisableStreamConversation,GroupProfileImage,NetworkId,SegmentId,Language,Status', 'safe'),



//            array(
//                            'SubGroupName',
//                            'match', 'not' => true, 'pattern' => "#[^a-z0-9'@\"\s-]#i",
//                            'message' => 'Invalid characters in subgroup name',
//                      ),

            );
    }
    
}