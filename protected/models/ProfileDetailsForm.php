<?php

/* 
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */
class ProfileDetailsForm extends CFormModel
{
    public $DisplayName;
    public $Speciality;
    public $Company;
    public $Position;
    public $School;
    public $Degree;
    public $Years_Experience;
    public $Highest_Education;
    
    
    public function rules() {
        return array(
            // username and password are required
            array('DisplayName,Speciality,Company,Position,School,Degree,Years_Experience,Highest_Education', 'safe'),
            array('DisplayName', 'required'),
            );
    }
    
}