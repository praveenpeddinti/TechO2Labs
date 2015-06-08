<?php

class WebLinkForm extends CFormModel{
    public $id;
    public $WebLink;
    public $Description;
    public $Status;
    public $WebSnippetUrl;
    public $WebImage;
    public $WebDescription;
    public $WebTitle;
    public $CreatedUserId;
    public $LinkGroup=0;
    public $OtherValue;
    public $Title;
    
    public function rules() {
        return array(
            array('WebLink,Description,Title', 'required'),  
            array(
                                'WebLink',
                                'match', 'pattern' => '/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/',
                                'message' => Yii::t('translation','Link_should_start_with').' http:// or https://',
                            ),
            
            array('id,WebLink,Description,Status,LinkGroup,OtherValue,Title','safe'),
        );
    }
}
