<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TestRegister extends CActiveRecord {

    public $UserId;
    public $TestId;
    public $RegistredDate;
    public $Status=0;
    public $LastLoginDate;
    public $IsAdmin=0;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'TestRegister';
    }

    
    
    public function saveInviteUserForTest($TestId,$UserIds) { 
        try {
            error_log("--sizeofIDs-".sizeof($UserIds));
            $returnValue = false;
            $userObj = new TestRegister();
            //for($i=0;$i<sizeof($UserIds);$i++){
                error_log("-----userIds---".$UserIds);
            $userObj->UserId = $UserIds;
            $userObj->TestId = $TestId;
            $userObj->RegistredDate = date('Y-m-d H:i:s', time());
            $userObj->LastLoginDate = '';
            
            if ($userObj->save()) {
            error_log("-------------------save ---------".$userObj->UserId); 
            $result = TestPreparationCollection::model()->updatedSaveInviteUserDetails($TestId,$userObj->UserId);
            } 
            //$userObj->save();
                
                 //error_log("--testinvite--dddddddssdsddd");
                //$returnValue = "success";
                //error_log("--testinvite--dddddddssdsddd".$returnValue);
            //}
            
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("TestRegister:saveInviteUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
     /*
     * @get Invite Users  when click the invite icon for Test paper dashboard
     */

    public function getInviteUserProfile($TestId,$startDate,$endDate, $searchText, $startLimit = 0, $pageLength = 10) {
        try {
        $searchText = trim($searchText);
        //$defaultcondition="TestId!='$TestId'";
        if (trim($startDate) == "") {
                
            }else{
                $condition1 = "DATE_FORMAT(RegistredDate,'%m/%dd/%Y') >='$startDate' AND DATE_FORMAT(RegistredDate,'%m/%dd/%Y') <='$endDate'";
            }
        
        if (!empty($searchText) && $searchText != "undefined" && $searchText != "null") {
                $namesArray = explode(" ",$searchText);
               
                if(!empty($namesArray[0])){
                    $firstName = trim($namesArray[0]);  
                }
                if((isset($namesArray[1]) && !empty($namesArray[1]))){
                    $lastName = trim($namesArray[1]);
                }
                
                
                if(isset($lastName) && !empty($lastName)){                    
                   $condition .= 'FirstName LIKE "%'.$firstName.'%" AND LastName LIKE "%'.$lastName.'%" ';
                }else{
                   $condition .= 'FirstName LIKE "%'.$firstName.'%" OR Email LIKE "%'.$searchText.'%"';   
                }
                
            
                   
            }
            if((trim($startDate) != "") && (empty($searchText))){
            $query="select UserId, FirstName, LastName, Email, Phone from User1 where UserId not in (select UserId from TestRegister where TestId ='$TestId') AND IsAdmin=0 AND $condition1 Order by UserId DESC limit $startLimit,$pageLength";
            //$query=  "select distinct(U.UserId),U.FirstName,U.LastName,U.Email,U.Phone,T.Status from User1 U right join 
//TestRegister T on U.UserId not in (T.UserId) where $condition Order by U.UserId DESC limit $startLimit,$pageLength";
        }else if((trim($startDate) == "") && (!empty($searchText) && $searchText != "undefined" && $searchText != "null")){error_log("-----cond2----");
            $query="select UserId, FirstName, LastName, Email, Phone from User1 where UserId not in (select UserId from TestRegister where TestId ='$TestId') AND IsAdmin=0 AND $condition Order by UserId DESC limit $startLimit,$pageLength";
            //$query=  "select distinct(U.UserId),U.FirstName,U.LastName,U.Email,U.Phone,T.Status from User1 U right join 
//TestRegister T on U.UserId not in (T.UserId) where $condition Order by U.UserId DESC limit $startLimit,$pageLength";
        }else if((trim($startDate) != "") && (!empty($searchText) && $searchText != "undefined" && $searchText != "null")){error_log("-----cond3----");
            $query="select UserId, FirstName, LastName, Email, Phone from User1 where UserId not in (select UserId from TestRegister where TestId ='$TestId') AND IsAdmin=0 AND  $condition Order by UserId DESC limit $startLimit,$pageLength";
            //$query=  "select distinct(U.UserId),U.FirstName,U.LastName,U.Email,U.Phone,T.Status from User1 U right join 
//TestRegister T on U.UserId not in (T.UserId) where $condition Order by U.UserId DESC limit $startLimit,$pageLength";
        }else{
            $query="select UserId, FirstName, LastName, Email, Phone from User1 where UserId not in (select UserId from TestRegister where TestId ='$TestId') AND IsAdmin=0 Order by UserId DESC limit $startLimit,$pageLength";
            //$query=  "select distinct(U.UserId),U.FirstName,U.LastName,U.Email,U.Phone,T.Status from User1 U right join 
//TestRegister T on U.UserId not in (T.UserId) Order by U.UserId DESC limit $startLimit,$pageLength";
            
        }
        error_log("-----query----".$query);
        $result = Yii::app()->db->createCommand($query)->queryAll(); 
        } catch (Exception $ex) {
            Yii::log("User:getUserProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }

    /*
     * GetUserProfileCount: which takes 2 arguments and 
     * returns the total no. of users.
     */

    public function getInviteUserProfileCount($TestId,$startDate,$endDate, $searchText) {
        try {
            $searchText = trim($searchText);
            //$defaultcondition="TestId!='$TestId'";
        if (trim($startDate) == "") {
                $condition = '';
            }else{
                $condition1 = "DATE_FORMAT(RegistredDate,'%m/%dd/%Y') >='$startDate' AND DATE_FORMAT(RegistredDate,'%m/%dd/%Y') <='$endDate'";
            }
        
        if (!empty($searchText) && $searchText != "undefined" && $searchText != "null") {
                $namesArray = explode(" ",$searchText);
               
                if(!empty($namesArray[0])){
                    $firstName = trim($namesArray[0]);  
                }
                if((isset($namesArray[1]) && !empty($namesArray[1]))){
                    $lastName = trim($namesArray[1]);
                }
                
              
                //$condition .= 'Email LIKE "%'.$searchText.'%"';
                //$condition .= ' FirstName LIKE "%'.$firstName.'%"';
                              
                if(isset($lastName) && !empty($lastName)){                  
                   $condition .= 'FirstName LIKE "%'.$firstName.'%" AND LastName LIKE "%'.$lastName.'%" ';
                }else{
                   $condition .= 'FirstName LIKE "%'.$firstName.'%" OR Email LIKE "%'.$searchText.'%"';      
                }
                
            
                   
            }
        if((trim($startDate) != "") && (empty($searchText))){
        $query="select count(UserId) as totalCount from User1 where UserId not in (select UserId from TestRegister where TestId ='$TestId') AND IsAdmin=0 AND $condition1";
            
            /*$query=  "select count(distinct(U.UserId)) as totalCount from User1 U right join 
TestRegister T on U.UserId not in (T.UserId) where $condition";*/
        }else if((trim($startDate) == "") && (!empty($searchText) && $searchText != "undefined" && $searchText != "null")){error_log("--count---cond2----");
        $query="select count(UserId) as totalCount from User1 where UserId not in (select UserId from TestRegister where TestId ='$TestId') AND IsAdmin=0 AND $condition";
            
            /*$query=  "select count(distinct(U.UserId)) as totalCount from User1 U right join 
TestRegister T on U.UserId not in (T.UserId) where $condition";*/
        }else if((trim($startDate) != "") && (!empty($searchText) && $searchText != "undefined" && $searchText != "null")){error_log("--count---cond3----");
        $query="select count(UserId) as totalCount from User1 where UserId not in (select UserId from TestRegister where TestId ='$TestId') AND IsAdmin=0 AND $condition";
            
            /*$query=  "select count(distinct(U.UserId)) as totalCount from User1 U right join 
TestRegister T on U.UserId not in (T.UserId) where $condition";*/
        }else{
            $query="select count(UserId) as totalCount from User1 where UserId not in (select UserId from TestRegister where TestId ='$TestId') AND IsAdmin=0";
            /*$query=  "select count(distinct(U.UserId)) as totalCount from User1 U right join 
TestRegister T on U.UserId not in (T.UserId)";*/
        }
      
        $result = Yii::app()->db->createCommand($query)->queryRow(); 
        } catch (Exception $ex) {
            Yii::log("User:getUserProfileCount::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        return $result;
    }
    
    public function getTestIdByUserId($userId){
        try{
            //$query = "select * from TestRegister where UserId=$userId AND Status=0 limit 1";
            //error_log("query------".$query);
            //$result = Yii::app()->db->createCommand($query)->queryRow();
            return TestRegister::model()->findByAttributes(array("UserId"=>$userId,"Status"=>0));            
            //return $result;
        } catch (Exception $ex) {
            error_log("TestRegister:getTestIdByUserId::".$ex->getMessage());
            Yii::log("TestRegister:getTestIdByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function updateTestByUserId($userId,$val){
        try{
            $result = "failure";
            $query="update TestRegister set Status = $val,LoginDate = now() where UserId = $userId";
            error_log("******updateRegister111111+++$query");
            if(Yii::app()->db->createCommand($query)->execute()){
                $result = "success";
            } 
            return ;
      } catch (Exception $ex) {
         error_log("TestRegister:getTestIdByUserId::".$ex->getMessage());
            Yii::log("TestRegister:getTestIdByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
        
    }
    public function getUserTestObjectByUserIdTestId($userId,$testId){
        try{
            return TestRegister::model()->findByAttributes(array("UserId"=>$userId,"TestId"=>"$testId"));
        } catch (Exception $ex) {
            error_log("TestRegister:getUserTestObjectByUserIdTestId::".$ex->getMessage());
        }
    }
    
    public function getReportinfo($testId){
        try{ error_log("************userObject##$testId");
             $query="select r.RegistredDate,u.Phone,u.Qualification from TestRegister r join User1 u on r.UserId = u.UserId  where r.TestId = '".$testId."'";
             error_log("****************Query".$query);
             $result = Yii::app()->db->createCommand($query)->queryAll();
             error_log("*******111111111111*****userObject##$testId".print_r($result,1));
        } catch (Exception $ex) {
            Yii::log("User:getReportinfo::".$ex->getMessage(), 'error', 'application');
        }
        
    }
    
}



