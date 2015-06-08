<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MarketResearchFollowUpForm extends CFormModel {

    public $Id;
    public $UserId;
    public $FirstName;
    public $LastName;
    public $State;
    public $City;
    public $Zip;
    public $Credential;
    public $MedicalSpecialty;
    public $Address1;
    public $Address2;
    public $Phone;
    public $NPINumber;
    public $LicensedState;
    public $LicensedStates;
    public $StateLicenseNumber;
     public $LicensedNumber;
    public $LicensedNumbers;
    public $HavingNPINumber;
    public $FederalTaxIdOrSSN;
    public $SurveyId;
    public $ScheduleId;
    public $CreatedDate;
    public $NPIState;
    
          public function Mainrules()
	{
              return array(
                   array('HavingNPINumber', 'validateOtherFields', 'fieldname' => 'HavingNPINumber', 'message' => 'Other Value '),
                   array('StateLicenseNumber,NPINumber', 'safe'),
             
                    array('HavingNPINumber', 'ext.YiiConditionalValidator.YiiConditionalValidator',
                        'if' => array(
                             array('HavingNPINumber', 'compare', 'compareValue'=>1),
                        ),
                        'then' => array(
                            array('NPINumber', 'required','message'=>Yii::t('translation','NPINumber_blank')),
                            array('NPINumber',
                            'match', 'pattern' => '/^[1-9][0-9]{9}$/',
                            'message'=>Yii::t('translation','NPINumber_Invalid_Pattern'))
                        ),
                 ),
                  );
        }
    public function rules() {
        return array(
           // array('HavingNPINumber', 'validateOtherFields', 'fieldname' => 'HavingNPINumber', 'message' => 'Other Value '),
            array('FirstName,LastName,State,City,Zip,Credential,MedicalSpecialty,Address1,Phone,FederalTaxIdOrSSN', 'required'),            
            array('FederalTaxIdOrSSN','length','min'=>'9'),
            array('FederalTaxIdOrSSN','length','max'=>'9'),
            array('LicensedNumbers,LicensedStates,LicensedState,NPINumber,StateLicenseNumber,LicensedNumber,FirstName,LastName,State,City,Zip,Credential,MedicalSpecialty,Address1,Address2,Phone,FederalTaxIdOrSSN,HavingNPINumber,SurveyId,ScheduleId', 'safe'),
        );
    }

    public function validateOtherFields($attribute, $params) {
        try{
            if ($attribute == "HavingNPINumber" && $this->HavingNPINumber == "0") {
            if ($this->LicensedState == "") {
                $message = Yii::t("translation", "Err_LicensedState");
                $this->addError('LicensedStates_1', $message);
            }
            if ($this->LicensedNumber == "") {
                $message = Yii::t("translation", "Err_LicensedNumber");
                $this->addError('LicensedNumber_1', $message);
            }
            if (is_array($this->LicensedState)) {
                foreach ($this->LicensedState as $key => $value) {
                    if ($value == "") {

                        $message = Yii::t("translation", "Err_LicensedState");
                        
                        $this->addError('LicensedStates_' . $key, $message);
                    }
                }
                foreach ($this->LicensedNumber as $key => $value) {
                    if ($value == "") {

                        $message = Yii::t("translation", "Err_LicensedNumber");
                        $this->addError('LicensedNumbers_' . $key, $message);
                    }
                }
                if ($this->LicensedStates == "") {
                    $message = Yii::t("translation", "Err_LicensedState");
                    $this->addError('LicensedStates_1', $message);
                }
                if ($this->LicensedNumbers == "") {
                    $message = Yii::t("translation", "Err_LicensedNumber");
                    $this->addError('LicensedNumber_1', $message);
                }
            }
        } 
        } catch (Exception $ex) {
            Yii::log("MarketResearchFollowUpForm:validateOtherFields::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}
