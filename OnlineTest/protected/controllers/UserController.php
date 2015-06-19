<?php


/*
 * Developer Suresh Reddy
 * on 8 th Jan 2014
 * all users actions need to add here
 */

class UserController extends Controller {
  

public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }
public function init() {
    try{
    parent::init();
    
     if(!isset($_REQUEST['mobile'])){error_log("---us1-----");
       if(isset(Yii::app()->session['TinyUserCollectionObj']) && !empty(Yii::app()->session['TinyUserCollectionObj'])){
           $this->tinyObject=Yii::app()->session['TinyUserCollectionObj'];
                $this->userPrivileges=Yii::app()->session['UserPrivileges'];
             
             }else{error_log("---us2-----");
                  $this->redirect('/');
                 }  
     }
     } catch (Exception $ex) {
        Yii::log("UserController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
       
 }
 public function actionError(){
     try{
 $cs = Yii::app()->getClientScript();
$baseUrl=Yii::app()->baseUrl; 
$cs->registerCssFile($baseUrl.'/css/error.css');
    if($error=Yii::app()->errorHandler->error)
        $this->render('error', $error);
    } catch (Exception $ex) {
        Yii::log("UserController:actionError::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}

/**
 * author: karteek.v
 * actionGetMiniPorfile is used to get user mini profile
 * request an userId
 * returns an user object
 */
public function actionGetMiniProfile(){
    try{
        if(isset($_REQUEST['userid'])){
            $userid = $_REQUEST['userid'];
            $result = ServiceFactory::getSkiptaUserServiceInstance()->getUserMiniProfile($userid,Yii::app()->session['TinyUserCollectionObj']->UserId);
        }
        
        $obj = array('status' => 'success', 'data' => $result, 'error' => '', 'networkAdmin'=>(int)Yii::app()->session['NetworkAdminUserId'],'networkmode'=>(int)Yii::app()->session['PostAsNetwork']);        
        echo CJSON::encode($obj);
        
    } catch (Exception $ex) {
        Yii::log("UserController:actionGetMiniProfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    
}
  

public function actionLogout(){
    try {
        Yii::app()->user->logout();
        Yii::app()->session->destroy();
         if(!isset($_REQUEST['mobile'])){
             $randomString = Yii::app()->user->getState('s_k');
          $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
     ServiceFactory::getSkiptaUserServiceInstance()->deleteCookieRandomKeyForUser($userId,$randomString);
      Yii::app()->request->cookies->clear();
       
         $this->redirect('/site'); 
         }else{
              $sessionId = $_POST["sessionId"];
            $userId = $_POST["userId"];
            $response = ServiceFactory::getSkiptaUserServiceInstance()->logout($sessionId,$userId);  
           if($response){
             $obj = array("status"=>"success","data"=>"","error"=>"");    
           }else{
                 $obj = array("status"=>"failure","data"=>"","error"=>"");
           }
            echo $this->rendering($obj);
            
         }
        
         
    } catch (Exception $ex) {
        Yii::log("UserController:actionLogout::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}



    
    public function actionUploadProfileImage() {
        try {
            Yii::import("ext.EAjaxUpload.qqFileUploader");
            $folder = Yii::getPathOfAlias('webroot') . '/upload/'; // folder for uploaded files
            if (!file_exists($folder)) {
                mkdir ($folder, 0755,true);
            }
            $allowedExtensions = array("jpg", "jpeg", "gif", "png", "tiff","tif","TIF"); //array("jpg","jpeg","gif","exe","mov" and etc...
            //$sizeLimit = 30 * 1024 * 1024; // maximum file size in bytes
            $sizeLimit= Yii::app()->params['UploadMaxFilSize'];
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
            $result = $uploader->handleUpload($folder);
            
            $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
            $fileName = $result['filename']; //GETTING FILE NAME
            $extension = $result['extension'];

            $ext = "profile";
            $extTemp = "profile/temp";
            $destnationfolder = $folder . $extTemp;
            
            if (!file_exists($destnationfolder)) {
               mkdir ($destnationfolder, 0755,true);
            }

            $imgArr = explode(".", $result['filename']);
            $date = strtotime("now");
            $finalImg_name = $imgArr[0] . '.' . $imgArr[1];
            $finalImage = $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
            $fileNameTosave = $folder . $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
            $path = $folder . $result['filename'];
             $extension_t = $this->getFileExtension($fileName);                 
            if($extension_t == "tif" || $extension_t == "tiff"){                
                $imgArr = explode(".", $result['mfilename']);
                $fileNameTosave = $folder . $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
                $finalImage = $imgArr[0] . '_' . $result['imagetime'] . '.' . $imgArr[1];
                $path = $folder . $result['mfilename'];
                $result['savedfilename'] = $result['tsavedfilename'];                
            }
            rename($path, $fileNameTosave);

            //  $filename=$result['filename'];
            $sourcepath = $fileNameTosave;
            $destination = $folder . $ext . "/" . $finalImage;
            $destinationTemp = $folder . $extTemp . "/" . $finalImage;            
            if ($extTemp != "") {
                if (file_exists($sourcepath)) {
                    if (copy($sourcepath, $destinationTemp)) {
                        unlink($sourcepath);
                    }
                }
            }
             $img = Yii::app()->simpleImage->load($destinationTemp);
             $width = $img->getWidth();
             if($width>=250){
                $img-> resizeToWidth(250);
             }
             $img->save($destination); 
             $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
            echo $return; // it's array
        } catch (Exception $ex) {
            Yii::log("UserController:actionUploadProfileImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    
      
   public function actionsaveProfileImage() {
        try {
            $absolutePath = Yii::app()->params['ServerURL'];
            $returnValue = 'failure';
            $type = '';
            $value = '';
            $UserId = '';
            $imageName='';
            if ($_REQUEST['type'] == 'ProfilePicture') {
                $value = $_REQUEST['profileImage'];
                $UserId = $_REQUEST['UserId'];
                $type = 'ProfilePicture';
                $imageName = $_REQUEST['profileImageName'];
            }
            $returnValue = ServiceFactory::getSkiptaUserServiceInstance()->saveProfileDetailsUserCollection($UserId, $type,$value, $imageName, $absolutePath );
            Yii::app()->session['TinyUserCollectionObj']['profile250x250'] = $absolutePath.Yii::app()->params['IMAGEPATH250'].$returnValue;
            Yii::app()->session['TinyUserCollectionObj']['profile70x70'] = $absolutePath.Yii::app()->params['IMAGEPATH70'].$returnValue;
            Yii::app()->session['TinyUserCollectionObj']['profile45x45'] = $absolutePath.Yii::app()->params['IMAGEPATH45'].$returnValue;
            
            $obj = array('imageName' => $returnValue,'type'=>$type,'imagePath70'=>$absolutePath.Yii::app()->params['IMAGEPATH70'],'imagePath250'=>$absolutePath.Yii::app()->params['IMAGEPATH250']);
            $renderScript = $this->rendering($obj);
            echo $renderScript;
        } catch (Exception $ex) {
            Yii::log("UserController:actionsaveProfileImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
  
    
    public function actionCheckSession(){
        try{
         
       if (Yii::app()->user->isGuest) {
               $this->guest = "true";
               if (Yii::app()->request->isAjaxRequest) {
                   $result = array("code" => 440, "status" => "sessionTimeout");
               }
           } else {
            $result = array("code"=>200,"status"=>"");
       }
        echo $this->rendering($result);
        } catch (Exception $ex) {
            Yii::log("UserController:actionCheckSession::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   
 
  public function actionUserDetail() {
        try {
            $migratedUserId = $_REQUEST["userGID"];
            $userDetails=ServiceFactory::getSkiptaUserServiceInstance()->getUserByType( $migratedUserId, 'MigratedUserId');
            if($userDetails!='failure'){
                $userId = $userDetails->UserId;
                $result = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
                $this->redirect("/profile/".$result->uniqueHandle);
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in UserController->actionUserDetail==".$ex->getMessage());
            Yii::log("UserController:actionUserDetail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

 

    public function actionGetActionUsers(){
        try{
            $postId = $_POST["postId"];
             $id = $_POST["id"];
            $actionType = $_POST["actionType"];
             $flag = $_POST["flag"];
              $categoryId = $_POST["categoryId"];
            $userId = Yii::app()->session['TinyUserCollectionObj']->UserId;
            $pageLength = 15;
           $page = $_REQUEST['page'];
           $pageSize = ($pageLength * $page); 
            $actionUsersList = ServiceFactory::getSkiptaUserServiceInstance()->getActionUsers($categoryId,$flag,$id,$actionType,$userId,$pageSize,$pageLength);
            if ($actionUsersList != 'failure') {
                $this->renderPartial('actionUsersList_view', array('actionUsersList' => $actionUsersList,'loginUserId'=>$userId));
            }
        } catch (Exception $ex) {
            Yii::log("UserController:actionGetActionUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in UserController->actionGetActionUsers==".$ex->getMessage());
        }
    }
 

    
    /*
     * @Praveen single test takers save functionality start Here
     */
    public function actionLoadSurveySchedule() {
        try {error_log("---user contr1---");
            $takerForm = new TestTakerForm();
            $csvModel = new CSVForm();
            error_log("---user contr2---");
            $this->renderPartial('testTaker', array('takerForm' => $takerForm, 'csvModel' => $csvModel));
            error_log("---user contr3---");
        } catch (Exception $ex) {
            error_log("Exception Occurred in ExtendedSurveyController->actionLoadSurveySchedule==". $ex->getMessage());
            Yii::log("ExtendedSurveyController:actionLoadSurveySchedule::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function actionDownloadCSVFile() {
        $folder = $this->findUploadedPath();
        $file = $folder . '/sampleDownloadFiles/sampleTestTakerCSV.csv';
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }
    
    public function findUploadedPath() {
        try {
            $path = dirname(__FILE__);
            $pathArray = explode('/', $path);
            $appendPath = "";
            for ($i = count($pathArray) - 3; $i > 0; $i--) {
                $appendPath = "/" . $pathArray[$i] . $appendPath;
            }
            $originalPath = $appendPath;
        } catch (Exception $ex) {
            error_log("#########Exception Occurred########".$ex->getMessage());
        }
        return $originalPath;
    }
    
    
    
    public function actionSaveEnrollmentData() {error_log("---1-enter controller test taker------");
        $testTakerForm = new TestTakerForm();
        if (isset($_POST['TestTakerForm'])) {error_log("--2--enter controller test taker------");
            $testTakerForm->attributes = $_POST['TestTakerForm'];
            $errors = CActiveForm::validate($testTakerForm);
            if ($errors != '[]') {error_log("--3--enter controller test taker------");
                $obj = array('status' => 'error', 'data' => '', 'error' => $errors, "emailError" => $common);
            } else {error_log("--4--enter controller test taker------");
                $takerexist =array();
                $takerexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($testTakerForm->Email);  
                error_log("------size---".count($takerexist));

                if (count($takerexist) > 0) {error_log("--if----size---".count($takerexist));
                    $errors = array("TestTakerForm_FirstName" => "User already exist with this Email Please  try with another  Email Address.");
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    error_log("-----else-size---".count($takerexist));
                    $saveDetails = ServiceFactory::getSkiptaUserServiceInstance()->SaveUserCollection($testTakerForm);
                    $obj = array('status' => 'success', 'data' => '', 'error' => ""); 
                    //$Save_userInUserCollection = ServiceFactory::getSkiptaUserServiceInstance()->UpdateUserCollection($UserSettingsForm,$oldUserObj);
                }
            }
            echo CJSON::encode($obj);
        }
    }
    /*
     * @Praveen bulk test takers uploaded functionality End Here
     */
    
    
    
    
    
    /*
     * @Praveen bulk test takers uploaded functionality start Here
     */
    
    public function setTestTakerBeanObject($value) {
        $TestTakerBean = new TestTakerBean();
        $value = str_replace('"', '', $value);
        $TestTakerBean->FirstName = $value[0];
        $TestTakerBean->LastName = $value[1];
        $TestTakerBean->Email = $value[2];
        $TestTakerBean->Phone = $value[3];
        $TestTakerBean->Qualification = $value[4];
        return $TestTakerBean;
    }
    
    
    
    public function actionManageFile() { error_log("-----enter manageFile---1");
        $csvModel = new CSVForm();
        $file = $_FILES['csvfiletype'];
        $delimiter = $_REQUEST['delimiter'];
        error_log("-----enter manageFile---2----");
        if (isset($_FILES['csvfiletype'])) {error_log("-----enter manageFile---3----");
            $fileName = $file['name'][0];
            $errors=$this->checkCSVFileformat($file);
            if (count($errors) == 0) {error_log("-----enter manageFile---4----".$file['name'][0]);
                $fileuploadpath = $this->findUploadedPath();
                error_log("-----enter manageFile---5----".$fileuploadpath);
                $dest = $fileuploadpath . '/csv/' . $file['name'][0];
                error_log("-----enter manageFile---6----".$dest);
                if (move_uploaded_file($file['tmp_name'][0], $dest)) {error_log("-----enter manageFile---7----");
                  
                    $col = 0;
                    $csvFile = file($dest);
                    $i = 0;
                    $j=0;
                    $status = "success";
                     
                    if(sizeof($csvFile)>1){
                    error_log($status."-----enter manageFile---8----".sizeof($csvFile));
                    foreach ($csvFile as $key => $line) {
                        // I'm reading from second line.
                        error_log("-----enter manageFile---9----".sizeof($csvFile));
                        if ($key >= 1) {
                            if ($delimiter == "1")
                                $var = explode("\t", $line);
                            if ($delimiter == "2")
                                $var = explode(",", $line);
                            if ($delimiter == "3")
                                $var = explode(";", $line);
                            if (count($var) <= 1) {error_log("-----enter manageFile---10----".count($var));
                                $errors[$i] = "Empty csv or delimiter mismatch! ";
                                $obj = array("status" => "error", "error" => $errors);
                            } else {error_log("-----enter manageFile---11----".print_r($var,true));
                                if ($var[0] != "" && $var[1] != "" && $var[2] != "" && $var[3] != "" && $var[4] != "") {
                                    $resultObject = $this->setTestTakerBeanObject($var);
                                    error_log("-----enter manageFile---11----".print_r($resultObject,true));
                                    $res = "";
                                    $toEmail = str_replace('"', '', $var[2]);
                                    error_log("-----enter manageFile---12---".$toEmail);
                                    $userexist =array();
                                    $userexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($toEmail);
                                    if (count($userexist) > 0) {
                                        $j++;
                                        error_log("--if----size---".count($userexist));
                                        $errors[$i] = " User already exist with this Email ".$toEmail." Please  try with another  Email Address.";
                                         $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                                    } else {error_log("-----else-size---".count($userexist));
                                    $saveuser = ServiceFactory::getSkiptaUserServiceInstance()->saveUser($resultObject);
                                       $obj = array('status' => 'success', 'data' => '', 'error' => ""); 
                                    //$Save_userInUserCollection = ServiceFactory::getSkiptaUserServiceInstance()->UpdateUserCollection($UserSettingsForm,$oldUserObj);
                                    } 
                                    
                                } else {
//                                    array_push($errors, $line);
                                    $errors[$i] = "Data mismatch... record skipped. --" . $line;
                                    $status = "error";
                                    $obj = array("status" => $status, "error" => $errors);
                                }
                            }
                        }
                          $i++;
                          
                    }
                }else{
                        $errors[0] = "Sorry, file format is wrong.";
                          $status = "error";
                          $obj = array("status" => $status, "error" => $errors);
                    }
            }
                if ($dest != "") {
                    if (file_exists($dest)) {
                        unlink($dest);
                    }
                }
            } else {
                $status = "error";
                $obj = array("status" => $status, "error" => $errors);
            }


// Reading content of the file.

            echo CJSON::encode($obj);
        }
    }

    public function checkCSVFileformat($file) {
        $errors = array();
        $maxsize = 10 * 1024 * 1024;
        $acceptable = array(
            'application/vnd.ms-excel',
            'text/plain',
            'text/csv',
            'text/tsv',
            'application/csv'
        );
        if (($file['size'][0] >= $maxsize) || ($file["size"][0] == 0)) {
            $errors[] = 'File too large. File must be less than 2 megabytes.';
        }
        if (!in_array($file['type'][0], $acceptable) && (!empty($file["type"][0]))) {
            $errors[] = 'Invalid file type. Only CSV is accepted.';
        }
        return $errors;
    }
    
    /*
     * @Praveen bulk test takers uploaded functionality End Here
     */
    
}

?>

