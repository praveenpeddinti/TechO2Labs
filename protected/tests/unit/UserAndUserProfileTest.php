<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserAndUserProfileTest extends CDbTestCase {

//    public $fixtures=array(
//		'User'=>'UserCollection',
//		
//	);
public function testSaveUserTest() {
        try {
            $user = new UserCollection;
            $user->displayName = "Techo2";
            $user->profilePicture = 'krishna.jpg';
            $user->network = 'India';
            $this->assertEquals(1, UserCollection::model()->saveUserCollection($user));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), 'error', 'application');
        }
    }

    public function testSaveUserProfile() {
        try {
            $userProfile = new UserProfileCollection();
            $userProfile->userId = $profileModel->userId;
            $userProfile->firstName = $profileModel->firstName;
            $userProfile->lastName = $profileModel->lastName;
            $userProfile->profilePicture = $profileModel->profilePicture;
            $userProfile->salutation = $profileModel->salutation;
            $userProfile->displayName = $profileModel->displayName;
            $userProfile->country = $profileModel->country;
            $userProfile->state = $profileModel->state;
            $userProfile->city = $profileModel->city;
            $userProfile->zip = $profileModel->zip;
            $userProfile->registeredOn = date('Y-m-d H:i:s', time());
            $userProfile->aboutMe = $profileModel->aboutMe;
            $userProfile->interests = $profileModel->interests;
            $userProfile->status = $profileModel->status;
            $userProfile->email = $profileModel->email;
            $userProfile->password = $profileModel->password;

            $this->assertEquals(1, UserProfileCollection::model()->saveUserProfileCollection($user));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), 'error', 'application');
        }
    }
    
   public function testLogin(){
       try { 
              $loginForm = new LoginForm;
              $loginForm->email='test@gmail.com';
              $loginForm->password='test';
               $service=new SkiptaUserService(); 
               $this->assertEquals('success',  $service->userAuthentication($loginForm));
               
              
       } catch (Exception $exc) {
           echo 'test login expetion test '.$exc->getMessage();
           Yii::log($exc->getMessage(), 'error', 'application');
       }
      }
      
   public function testSaveUserService(){
       try {
           $user=new UserRegistrationForm();      
            $user->firstName = 'Vamsi';
            $user->lastName = 'Krishna';             
            $user->displayName = 'Vamc';
            $user->password ='test';           
            $user->email = 'Vamsikrishna9025@gmail.com';
            $user->country ='India';
            $user->state = 'AP';
            $user->city = 'Hyderabad';
            $user->zip = '500042';
            $user->status = 1;
            $user->companyName = 'Techo2';          
            $user->network = 1;
             
            $service=new SkiptaUserService();           
            $customFileds=new CustomForm();
            $customFileds->isPharmacist=1;
            $customFileds->OtherAffiliation='test';
            $customFileds->StateLicenseNumber='AP122AP';
            $customFileds->PrimaryAffiliation='Doctor';
           
            $this->assertEquals('success', $service->SaveUserCollection($user,$customFileds));
       } catch (Exception $exc) {
           //echo 'In exception '.$exc->getMessage();
           Yii::log($exc->getMessage(), 'error', 'application');
       }
      }
      
    public function testGetUserProfile($filterValue = 'all', $searchText="", $startLimit=0, $pageLength=10) {
        try {// method calling...               
            $userObj = new User();
            $this->assertLessThanOrEqual(array(), User::model()->getUserProfile($filterValue, $searchText, $startLimit, $pageLength));            
        } catch (Exception $exc) {
            echo "\nException=in=testGetUserProfile=".$exc->getMessage();     
            Yii::log("Exception=in=testGetUserProfile==".$exc->getMessage(), 'error', 'application');
        }        
    }
    
    public function testGetUserProfileCount($filterValue = 'all', $searchText="") {
        try {// method calling...               
            $cnt = User::model()->getUserProfileCount($filterValue, $searchText);
            $this->assertLessThanOrEqual(array(), User::model()->getUserProfileCount($filterValue, $searchText));            
            
        } catch (Exception $exc) {
            echo "\nException=in=testGetUserProfileCount=".$exc->getMessage();     
            Yii::log("Exception=in=testGetUserProfileCount==".$exc->getMessage(), 'error', 'application');
        }        
    }
    
    public function testGetUserProfileByUserId($userid=1) {
        try {            
            $this->assertInstanceOf("User", User::model()->getUserProfileByUserId($userid));            
        } catch (Exception $ex) {
            echo "\nException=in=testGetUserProfileByUserId=".$ex->getMessage();  
            Yii::log("Exception=in=testGetUserProfileByUserId==".$ex->getMessage(), 'error', 'application');
        }
        
    }

    public function testUpdateUserStatus($userid=1, $value=2) {
        try {            
            $result = User::model()->updateUserStatus($userid, $value);
            $this->assertEquals("success", User::model()->updateUserStatus($userid, $value));            
        } catch (Exception $ex) {
            echo "\nException=in=testUpdateUserStatus=".$ex->getMessage();
            Yii::log("Exception=in=testUpdateUserStatus==".$ex->getMessage(), 'error', 'application');
        }        
    }
    

//    public function testFollowAUser($userId=74,$followId=73) {
//        try {   
//            echo "\n=====in testFollowAUser=$userId=$followId=";
//            $result = UserProfileCollection::model()->followAction($userId,$followId);
//            echo "\n==result===$result";
//            $this->assertEquals("success",  UserProfileCollection::model()->followAction($userId,$followId));            
//        } catch (Exception $ex) {
//            echo "\nException=in=testFollowAUser=".$ex->getMessage();
//            Yii::log("Exception=in=testUpdateUserStatus==".$ex->getMessage(), 'error', 'application');
//        }        
//    }
//    
//    public function testUnFollowAUser($userId=74,$followId=73) {
//        try {   
//            echo "\n=====in testUnFollowAUser=$userId=$followId=";
//            $result = UserProfileCollection::model()->unFollowAction($userId,$followId);
//            echo "\n==result===$result";
//            $this->assertEquals("success",  UserProfileCollection::model()->followAction($userId,$followId));            
//        } catch (Exception $ex) {
//            echo "\nException=in=testUnFollowAUser=".$ex->getMessage();
//            Yii::log("Exception=in=testUnFollowAUser==".$ex->getMessage(), 'error', 'application');
//        }        
//    }
    

    public function testForgotPassword(){
        try {
            
            $forgotPasswordModel=new ForgotForm();            
            $forgotPasswordModel->email='mikeaaron8@gmail.com';
             $service=new SkiptaUserService();    
             $this->assertInstanceOf("User", $service->userForgotService($forgotPasswordModel)); 
        } catch (Exception $exc) {
            echo $exc->getMessage();
            Yii::log($exc->getTraceAsString(),'error','application');
        }
        }
    
   
    public function testGetUserPrivileges($userid=4027){
        try{
            $this->assertGreaterThanOrEqual(0, count(UserPrivileges::model()->getUserPrivileges($userid)));             
        } catch (Exception $ex) {            
            Yii::log("Exception occurred in getUserPrivileges of Skiptauserservice","error","application");
        }
            
    }
    
    
    public function testUpdateUserPrivileges($privilegesids=4){
        try{
            $this->assertEquals("success",  UserPrivileges::model()->updateUserPrivileges($privilegesids));            
        } catch (Exception $ex) {
            echo "\nException Occured in testUpdateUserPrivileges==".$ex->getMessage();
            Yii::log("Exception occurred in saveUserPrivileges of Skiptauserservice","error","application");
        }
        
    }


}
