<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GeoCodes extends CActiveRecord {

    public $Id;
    public $Address1;
    public $Address2;
    public $City;
    public $State;
    public $Country;
    public $Zip;
    public $Latitude;
    public $Longitude;
    

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'GeoCodes';
    }

 public function saveGeoCode($addressArray,$geoCode,$flag) {
        try {
           
            $returnValue = false;
            $geoCodeObj = new GeoCodes();
            if($flag == "zip"){
                $geoCodeObj->Zip =  trim($addressArray["Zip"]); 
                $geoCodeObj->Latitude =  trim($geoCode["Latitude"]); 
               $geoCodeObj->Longitude =  trim($geoCode["Longitude"]); 
            }else{
                if(isset($addressArray["Address1"]) && $addressArray["Address1"]!=""){
                    $geoCodeObj->Address1 =  trim($addressArray["Address1"]);   
                }
              if(isset($addressArray["Address2"]) && $addressArray["Address2"]!=""){
                    $geoCodeObj->Address2 =  trim($addressArray["Address2"]); 
              }
              if(isset($addressArray["City"]) && $addressArray["City"]!=""){
                    $geoCodeObj->City =  trim($addressArray["City"]); 
              }
              if(isset($addressArray["State"]) && $addressArray["State"]!=""){
                    $geoCodeObj->State =  trim($addressArray["State"]); 
              }
              if(isset($addressArray["Country"]) && $addressArray["Country"]!=""){
                    $geoCodeObj->Country =  trim($addressArray["Country"]); 
              }
                if(isset($addressArray["Zip"]) && $addressArray["Zip"]!="" ){
                    $geoCodeObj->Zip =  trim($addressArray["Zip"]); 
              }
            
              $geoCodeObj->Latitude =  trim($geoCode["Latitude"]); 
               $geoCodeObj->Longitude =  trim($geoCode["Longitude"]); 
               
            }
           
           
            if ($geoCodeObj->save()) {
                $returnValue = $geoCodeObj->Id;
            }
        
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GeoCodes:saveGeoCode::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function getGeoCodeFromLocalDB($addressArray,$flag){
        $address1 = "";
        $address2 = "";
        $city = "";
        $state = "";
        $country = "";
         $zip = "";
       try {
            $geoCode =  array("Latitude"=>"","Longitude"=>"","Status"=>0);
           if($flag == "zip"){
                 $zip = trim($addressArray['Zip']);
                 $query = "select * from GeoCodes where Zip='".$zip."'";    
           }else{
                $query = "select * from GeoCodes where";
                if(isset($addressArray["City"]) && $addressArray["City"]!=""){
                    $city = trim($addressArray['City']);
                    $query = $query . " City='".$city."'";
              }
              if(isset($addressArray["State"]) && $addressArray["State"]!=""){
                    $state = trim($addressArray['State']); 
                     $query = $query. " and State='".$state."'" ;
              }
              if(isset($addressArray["Country"]) && $addressArray["Country"]!=""){
                     $country = trim($addressArray['Country']);
                      $query = $query. " and Country='".$country."'" ;
              }
                if(isset($addressArray["Zip"]) && $addressArray["Zip"]!=""){
                     $zip= trim($addressArray['Zip']);
                      $query = $query. " and Zip='".$zip."'" ;
              }
                if(isset($addressArray["Address1"]) && $addressArray["Address1"]!=""){
                    $address1 = trim($addressArray['Address1']);
                      $query = $query. " and Address1='".$address1."'" ;
                    
                }
              if(isset($addressArray["Address2"]) && $addressArray["Address2"]!=""){
                    $address2 = trim($addressArray['Address2']);
                      $query = $query. " and Address2='".$address2."'" ;
              }
            
             $query = str_replace("where and", "where",$query);
           }
            $geocodeObj = Yii::app()->db->createCommand($query)->queryRow();
            if(is_array($geocodeObj)){
            $geoCode =  array("Latitude"=>$geocodeObj['Latitude'],"Longitude"=>$geocodeObj['Longitude'],"Status"=>200);
            }
         
            return $geoCode;
        } catch (Exception $ex) {
            Yii::log("GeoCodes:getGeoCodeFromLocalDB::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 
    }
   
}
