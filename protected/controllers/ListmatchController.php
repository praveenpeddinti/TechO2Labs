<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ListMatchController extends Controller{
    
    public function init() {
        parent::init();
        
            if(isset(Yii::app()->session['TinyUserCollectionObj'])){
                 $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];
                  $this->userPrivileges=Yii::app()->session['UserPrivileges'];
                $this->userPrivilegeObject = Yii::app()->session['UserPrivilegeObject'];
                $this->whichmenuactive=8;
                if(Yii::app()->session['IsAdmin']=='1')
                {   
                    //$this->redirect('/');
                }else{
                    if($this->userPrivilegeObject->canManageFlaggedPost==1 || $this->userPrivilegeObject->canManageAbuseScan==1 ){
                        
                    }else{
                       $this->redirect('/'); 
                    }
                }
             }else{
                  $this->redirect('/');
        }
        CommonUtility::registerClientScript('simplePagination/','jquery.simplePagination.js');
        CommonUtility::registerClientScript('adminOperations.js');
        CommonUtility::registerClientCss();
    }

    public function actionIndex(){
         $normalPostModel = new ListMatchForm();
      
        $this->render('listmatch', array('listmatchForm' => $normalPostModel));
      
    }
    /**
     * ActionUserManagement: 
     * called for the time and get with Users Object and then render to a view.
     */
    // first time it will called...
    public function actionListmatch(){
         $normalPostModel = new ListMatchForm();
      
        $this->render('listmatch', array('listmatchForm' => $normalPostModel));
      
    }
    
        public function actionListMatchCSV(){
            $fp = Yii::app()->params['WebrootPath']."/temp/".$_POST['filename'];
       $existingUsers = array();
       $existingUserNames=array();
            $insertedUsersCount = 0;
            $existingUsersCount = 0;
            $totalUsers = sizeof($userRegistrationInfo);
            
            
            $row = 1;
if (($handle = fopen($fp, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
      
        $row++;
        $userInfo= array();
        $userInfo['email']=$data[1];
        
        $namearray = explode(" ", trim($data[0]),2);
        
        
        $usrInfo['email']=$data[1];
        $usrInfo['firstName']=$namearray[0];
        $usrInfo['lastName']=$namearray[1];
    
        $encryption_salt = Yii::app()->params['ENCRYPTION_SALT'];
        $usrInfo['pass']=md5($encryption_salt . 'oncology14');;
        $usrInfo['status']=1;
        $usrInfo['network']=1;
        

                                
                $uerRegistrationArray["registredDate"] = date('Y-m-d H:i:s', time());
                $uerRegistrationArray["lastLoginDate"] = date('Y-m-d H:i:s', time());
                $uerRegistrationArray["migratedUserId"] = 0;





                try {
                    if (isset($usrInfo['email'])) {
                        $userexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($usrInfo['email']);
                        if (count($userexist) > 0) {
                            $message = "Users already exist with the given Email Please  try with another  Email Address";
                            $existingUsersCount++;
                            array_push($existingUsers, $usrInfo['email']);
                             array_push($existingUserNames, $data[0]);
                            
                        } else {
                            $uerRegistrationArray = array();
                            $UserRegistrationForm = new UserRegistrationForm();
                            foreach ($UserRegistrationForm->attributes as $key => $value) {

                                if (isset($usrInfo[$key])) {
                                    $uerRegistrationArray[$key] = $usrInfo[$key];
                                }
                            }
                            $uerRegistrationArray["registredDate"] = $usrInfo["registredDate"];
                            $uerRegistrationArray["lastLoginDate"] = $usrInfo["lastLoginDate"];
                            $uerRegistrationArray["migratedUserId"] = $usrInfo["migratedUserId"];
                            $customfieldsArray = array();
                            $CustomForm = new CustomForm();
                            foreach ($CustomForm->attributes as $key => $value) {
                                if (isset($usrInfo[$key])) {
                                    $uerRegistrationArray[$key] = $value;
                                }
                            }
                            $Save_userInUserCollection = ServiceFactory::getSkiptaUserServiceInstance()->SaveUserCollection($uerRegistrationArray, $customfieldsArray);
                            if ($Save_userInUserCollection != 'error') {
                                $message = "User Registered Successfully";
                                $insertedUsersCount++;
                            } else {
                                $message = "User registration failed";
                                $failedUsers = $failedUsers . "," . $usrInfo['email'];
                            }
                        }
                    } else {
                        $message = "User email not found";
                    }
                    
                    
                } catch (Exception $exc) {
                    error_log("==in exception==loop==" . $usrInfo['email'] . "===" . $exc->getMessage());
                    echo "==exception==" . $usrInfo['email'];
                }
            }
    fclose($handle);
}

if ($insertedUsersCount > 0) {
                $message = "Inserted " . $insertedUsersCount . " user(s). existing users count  " . $existingUsersCount;
            }
            //echo $message . " Failed Users : " . $failedUsers;


            
            //    echo   $content = fread($fp, filesize($file->tempName));

        

//      
     //   $obj = array('status' => $message,'exist'=>$existingUsers);
        
//   try{     
//$list = array (
//    array('aaa', 'bbb', 'ccc', 'dddd'),
//    array('123', '456', '789'),
//    array('"aaa"', '"bbb"')
//);
//
//$fp = fopen('/opt/existingfile.csv', 'w');
//
//foreach ($list as $fields) {
//    fputcsv($fp, $fields);
//}
//
//fclose($fp);
//   }catch(Exception $e){
//       
//       error_log("@@@@@@@@@@@@@@@@@222".$e->getMessage());
//   }
        
         echo $this->renderPartial('listmatch_view', array('Emails' => $existingUsers,'UserNames'=>$existingUserNames), true);
         
        
        //$renderScript = $this->rendering($obj);
      //echo $renderScript;
    }
    
    /**
     * @author Reddy
     *  This  method is used for  upload the artifacts and save different folders based on type of file uploaded.
     */
    public function actionUpload() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            //  $folder=Yii::getPathOfAlias('webroot').'/temp/';// folder for uploaded files
            $folder = Yii::app()->params['ArtifactSavePath'];
            $webroot = Yii::app()->params['WebrootPath'];
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $allowedExtensions = array("csv"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //$sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
             $sizeLimit= Yii::app()->params['UploadMaxFilSize'];
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            
            if(isset($result['filename'])){
            $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
            $fileName=$result['filename'];//GETTING FILE NAME
             $result["filepath"]= Yii::app()->getBaseUrl(true).'/temp/'.$fileName;
             $result["fileremovedpath"]= $folder.$fileName; 
            }else{
              $result['success']=false;  
            }

         
            
            $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
        } catch (Exception $exc) {
            Yii::log($exc->getTraceAsString(), "error", "application");
        }
    }
   
   
    
    
}