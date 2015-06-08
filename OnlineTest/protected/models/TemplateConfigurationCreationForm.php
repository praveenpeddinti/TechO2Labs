<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TemplateConfigurationCreationForm extends CFormModel
{
    public $id;
    public $title;
    public $filename;
    public $email;
    
    
    public function rules() {
        return array(
            // category required
            array('id,title,filename,email', 'safe'),
            
            array('title,filename', 'required'),
           // array('name', 'CRegularExpressionValidator', 'pattern'=>'/^([0-9a-zA-Z  ]+)$/'),
            );
    }
    
}