<?php

/* 
 * NormalPostForm class.
 * NormalPostForm is the data structure for saving the stream
 * It is used by the 'index' action of 'PostController'.
 */
class SubGroupPostForm extends CFormModel
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
    public $NetworkId;
    public $Status;
    public $IsPublic;
    public $DisableComments=0;
    public $IsBlockedWordExist=0;
    public $IsFeatured=0;
    public $IsWebSnippetExist=0;
    public function rules() {
        return array(
             array('Description,Artifacts,HashTags,Mentions,StartDate,EndDate,Location,Type,OptionOne,OptionTwo,OptionThree,OptionFour,ExpiryDate,Status,StartTime,EndTime,GroupId,NetworkId,Status,IsPublic,DisableComments,IsFeatured,IsWebSnippetExist,WebUrls', 'safe'),
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
                            array('OptionOne,OptionTwo,OptionThree,ExpiryDate', 'required'),
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
                            array('StartDate,EndDate,Location', 'required'),
                        ),
                 ),
            /* setting the max length of all options */
            array('OptionOne','length','max'=>'50'),
            array('OptionTwo','length','max'=>'50'),
            array('OptionThree','length','max'=>'50'),
            array('OptionFour','length','max'=>'50'),
            
           
            );
    }
    
}