<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EmailConfigurationCreationForm extends CFormModel
{
    public $id;
    public $email;
    public $password;
    public $smtpaddress;
    public $port;
    public $host;
    public $encryption;
    
    
    public function rules() {
        return array(
            // category required
            array('id,email,password,smtpaddress,port,host,encryption', 'safe'),
            
            array('email,password,smtpaddress,port,host', 'required'),
           // array('name', 'CRegularExpressionValidator', 'pattern'=>'/^([0-9a-zA-Z  ]+)$/'),
            );
    }
    
}