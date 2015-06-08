<?php

/* 
 * AbuseWordCreation class.
 * AbuseWordCreation is the data structure for creating a abuse word
 * It is used by the 'forgot' action of 'AdminController'.
 */
class AbuseWordCreationForm extends CFormModel
{
    public $AbuseWord;
    public $id=0;
    
    public function rules() {
        return array(
            array('AbuseWord', 'required'),
            array('id,AbuseWord', 'safe'),
            array('AbuseWord', 'CRegularExpressionValidator', 'pattern'=>'/^([,0-9a-zA-Z  ]+)$/'),
            );
    }
    
}