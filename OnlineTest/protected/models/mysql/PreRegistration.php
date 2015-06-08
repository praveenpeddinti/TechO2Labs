<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PreRegistration extends CActiveRecord {

    public $UserId;
    public $First_Name;
    public $Middle_Name;
    public $Last_Name;
    public $Title_Code;
    public $NPI_Number;
    public $Email;
    public $Phone;
    public $Practice_Name;
    public $Speciality;
    public $Address;
    public $City;
    public $State;
    public $Country;
    public $Zip;
    public $Registration_State;
    public $UpdatedOn;
    public $Invitation_Link;
    public $AccessKey;
   
    //   public $Designation ;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Pre_Registration';
    }
    /*@Author Haribabu
     *This mehtod is used to update the  Hds user any filed  by using user accesskey
     * 
     */

    public function updateUserStatus($AccessId,$field,$value) {
        try {
            $return = "failed";

            $user = PreRegistration::model()->findByAttributes(array("AccessKey" => $AccessId));
            if (isset($user)) {

                $user->$field = $value;
                if ($user->update()) {
                    $return = "success";
                }
            }
        } catch (Exception $ex) {
            Yii::log("PreRegistration:updateUserStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $return;
    }

    /*@Author Haribabu
     * This method is used to get the Hds user details by using Accesskey
     */

    public function getHdsuserDetails($AccessKey) {
        try {
            $result = 'failure';
            $user = PreRegistration::model()->findByAttributes(array("AccessKey" => $AccessKey));
            if (isset($user)) {
                $result = $user;
            } 
            return $result;
        } catch (Exception $ex) {
          
            Yii::log("PreRegistration:getHdsuserDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function getHdsUsersByUsingStatus($Status) {
        try {
            
             $returnValue='failure';
             $query="select  @a := @a + 1 AS SNo,First_Name,Last_Name,Email from Pre_Registration, (SELECT @a:= 0) AS a  where  Registration_State='".$Status."'";            
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;

        } catch (Exception $ex) {          
            Yii::log("PreRegistration:getHdsUsersByUsingStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /*@Author Haribabu
     *This mehtod is used to update the  Hds user any filed  by using user accesskey
     * 
     */

    public function getAllHdsUsersWithStatus() {
        try {
           
          $returnValue='failure';
            //$query="select @i:=@i+1 AS Id,First_Name,Last_Name,Email,Registration_State from Pre_Registration  order by Registration_State asc";   
            $query="select @a:=@a+1 AS Id,First_Name,Last_Name,Email,Registration_State from Pre_Registration, (SELECT @a:= 0) AS a order by Registration_State asc";
             $users = Yii::app()->db->createCommand($query)->queryAll();
             if(count($users)>0){
                 $returnValue= $users;
             }
             return $returnValue;  
            
            
        } catch (Exception $ex) {
            Yii::log("PreRegistration:updateUserStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $return;
    }

}

