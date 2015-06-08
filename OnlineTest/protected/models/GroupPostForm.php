<?php

/* 
 * NormalPostForm class.
 * NormalPostForm is the data structure for saving the stream
 * It is used by the 'index' action of 'PostController'.
 */
class GroupPostForm extends CFormModel
{
    public $Type;
    public $UserId;
    public $GroupId;
    public $Description;
    public $Artifacts;
    public $HashTags;
    public $Mentions;
    public $StartDate;
    public $EndDate;
    public $Location;
    public $OptionOne;
    public $OptionTwo;
    public $OptionThree;
    public $OptionFour;
    public $ExpiryDate;
    public $StartTime;
    public $EndTime;
    public $WebUrls;
    public $Status;
    public $IsPublic;
    public $DisableComments=0;
    public $IsBlockedWordExist=0;
    public $IsFeatured=0;
    public $IsWebSnippetExist=0;
    public $Title;
    public $SubGroupId=0;
    public $CreatedOn;
    public $MigratedPostId='';
    //$postedBy is added by Sagar for PostAsNetwork
    public $PostedBy=0;
    public $NetworkId = 1;
    public $SegmentId = 0;
    public $Language = 'en';
    public $Miscellaneous = 0;
    public $KOLUser;

    public function rules() {
        return array(
             array('Miscellaneous', 'validateOtherFields', 'fieldname' => 'Miscellaneous', 'message' => ' '),
             array('KOLUser,UserId,Miscellaneous,Description,Artifacts,HashTags,Mentions,StartDate,EndDate,Location,Type,OptionOne,OptionTwo,OptionThree,OptionFour,ExpiryDate,Status,StartTime,EndTime,GroupId,NetworkId,Status,IsPublic,DisableComments,IsFeatured,IsWebSnippetExist,WebUrls,Title,SubGroupId,MigratedPostId, PostedBy', 'safe'),
            array('Type', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('Type', 'compare', 'compareValue'=>"Normal Post"),
                        ),
                        'then' => array(
                             array('Description','required', 'message'=>Yii::t('translation','attribute_cannot_be_blank')),
                        ),
                 ),
            array('Type', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('Type', 'compare', 'compareValue'=>"Survey"),
                        ),
                        'then' => array(
                            array('Description','required', 'message'=>Yii::t('translation','attribute_cannot_be_blank')),
                             
                            array('Title,OptionOne,OptionTwo,OptionThree,ExpiryDate', 'required'),
                        ),
                 ),
            array('Type', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('Type', 'compare', 'compareValue'=>""),
                        ),
                        'then' => array(
                             array('Description','required', 'message'=>Yii::t('translation','attribute_cannot_be_blank')),
                        ),
                
                         'if' => array(
                             array('Type', 'compare', 'compareValue'=>"Event"),
                        ),
                        'then' => array(
                             array('Description','required', 'message'=>Yii::t('translation','attribute_cannot_be_blank')),
                        ),

                 ),
             array('Type', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('Type', 'compare', 'compareValue'=>"Event"),
                        ),
                        'then' => array(
                          //   array('Description','required', 'message'=>'Survey Question cannot be blank'),
                             
                            array('Title,StartDate,EndDate,Location', 'required'),
                        ),
                 ),
            
//            array('Miscellaneous', 'ext.YiiConditionalValidator.YiiConditionalValidator',
//                        'if' => array(
//                             array('Miscellaneous', 'compare', 'compareValue'=>"1"),
//                        ),
//                        'then' => array(
//                             array('KOLUser','required', 'message'=>Yii::t('translation','Err_KOLUser')),
//                            
//                        ),
//                 ),
            /* setting the max length of all options */
            array('OptionOne','length','max'=>'50'),
            array('OptionTwo','length','max'=>'50'),
            array('OptionThree','length','max'=>'50'),
            array('OptionFour','length','max'=>'50'),
            
           
            );
    }
    public function validateOtherFields($attribute, $params) {
        try{
            if ($attribute == "Miscellaneous" && $this->Miscellaneous == 1) {
                if ($this->KOLUser == "") {   
                    $message = Yii::t("translation", "Err_KOLUser");                    
                    $this->addError('KOLUser', $message);
                }           
            
        }
        } catch (Exception $ex) {
            Yii::log("GroupPostForm:validateOtherFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
}