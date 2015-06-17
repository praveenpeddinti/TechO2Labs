<?php

/**
 * CSVForm class.
 * CSVForm is the data structure for keeping
 * user CSVForm data. It is used by the 'upload' action of 'EmployersController'.
 */
class CSVForm extends CFormModel {

    public $csvfile;
    public $name;
    public $age;
    public $delimeter;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('delimeter', 'required',
                'message' => 'Please choose a {attribute}.'
            ),
            array('csvfile','required','message'=>'Please Upload CSV file with Employee Biometric form data.'),
                
            
            array('name,csvfile,age','safe')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
//		return array(
//			'rememberMe'=>'Remember me next time',
//		);
    }

}
