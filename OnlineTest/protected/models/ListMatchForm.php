<?php

/* 
 * AbuseWordCreation class.
 * AbuseWordCreation is the data structure for creating a abuse word
 * It is used by the 'forgot' action of 'AdminController'.
 */
class ListMatchForm extends CFormModel
{
    public $csvfile;

    
    public function rules() {
        return array(
            array('csvfile', 'safe'),
            );
    }
    
}