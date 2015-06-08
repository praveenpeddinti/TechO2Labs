<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HelpIconcreationForm extends CFormModel
{
    public $name;
    public $id;
    public $description;
    public $cue;
    public $artifacts;
    
    public function rules() {
        return array(
            // category required
            array('id,name,artifacts,cue,description', 'safe'),
            
            array('name,description,cue', 'required'),
            array('name', 'CRegularExpressionValidator', 'pattern'=>'/^([0-9a-zA-Z  ]+)$/'),
            );
    }
    
}