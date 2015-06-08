<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Countries extends CActiveRecord{
    
    public $Code;
    public $Name;
    public $Id;
    public $NetworkId;
    public $SegmentId;
    public $Language;
    
    
      public static function model($className=__CLASS__)
    { 
        return parent::model($className);
    }
 
    public function tableName()
    { 
        return 'Countries';
    }
    public function GetCountries(){
        try {
                $resources=Yii::app()->db->createCommand("SELECT c.*,c.Name as CountryNetwork FROM  Countries c,Segment n where c.SegmentId=n.SegmentId")->queryAll();

            } catch (Exception $ex) {
                Yii::log("Countries:GetCountries::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                error_log("Exception Occurred in Countries->GetCountries### ".$ex->getMessage());
            }

              return $resources;
     }
     
     public function getCountryById($id) {
        $returnValue = 'failure';
        try {
            
            $countryData =  Countries::model()->findByAttributes(array("Id" => $id));
       
            if(isset($countryData) && !empty($countryData) ){
                $returnValue=$countryData;
            }
           
       
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("Countries:getCountryById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $returnValue = 'failure';
        }
    }
/*@Author Haribabu
 * This method is used to get the country details by using the country name .
 * return Country object
 * 
 */
    
     public function getCountryByName($country) {
        $returnValue = 'failure';
        try {
            
            $countryData =  Countries::model()->findByAttributes(array("Name" => trim($country)));
       
            if(isset($countryData) && !empty($countryData) ){
                $returnValue=$countryData;
            }
           
       
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("Countries:getCountryById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            $returnValue = 'failure';
        }
    }
    
    
}
