<?php


/*
 * Developer Praveen 
 * on 6 th June 2015
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

 

    public function actionLogout(){
        try {
            Yii::app()->session->destroy();

             $this->redirect('/'); 

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
        try {
            $takerForm = new TestTakerForm();
            $csvModel = new CSVForm();
            $this->renderPartial('testTaker', array('takerForm' => $takerForm, 'csvModel' => $csvModel));
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
    
    
    
    public function actionSaveEnrollmentData() {
        $testTakerForm = new TestTakerForm();
        if (isset($_POST['TestTakerForm'])) {
            $testTakerForm->attributes = $_POST['TestTakerForm'];
            $errors = CActiveForm::validate($testTakerForm);
            if ($errors != '[]') {
                $obj = array('status' => 'error', 'data' => '', 'error' => $errors, "emailError" => $common);
            } else {
                $takerexist =array();
                $takerPhoneexist =array();
                $takerexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($testTakerForm->Email);  
                $takerPhoneexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExistWithPhone($testTakerForm->Phone);
                if (count($takerexist) > 0) {
                    $errors = array("TestTakerForm_Email" => "User already exist with this Email Please  try with another  Email Address.");
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                }else if (count($takerPhoneexist) > 0) {
                    $errors = array("TestTakerForm_Phone" => "User already exist with this Phone Please  try with another Phone.");
                    $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                } else {
                    error_log("***************testTakerForm".print_r($testTakerForm,1));
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
    
    
    
    public function actionManageFile() { 
        $csvModel = new CSVForm();
        $file = $_FILES['csvfiletype'];
        $delimiter = $_REQUEST['delimiter'];
        if (isset($_FILES['csvfiletype'])) {
            $fileName = $file['name'][0];
            $errors=$this->checkCSVFileformat($file);
            if (count($errors) == 0) {
                $fileuploadpath = $this->findUploadedPath();
                $dest = $fileuploadpath . '/csv/' . $file['name'][0];
                if (move_uploaded_file($file['tmp_name'][0], $dest)) {
                  
                    $col = 0;
                    $csvFile = file($dest);
                    $i = 0;
                    $j=0;
                    $status = "success";
                     
                    if(sizeof($csvFile)>1){
                    foreach ($csvFile as $key => $line) {
                        // I'm reading from second line.
                        if ($key >= 1) {
                            if ($delimiter == "1")
                                $var = explode("\t", $line);
                            if ($delimiter == "2")
                                $var = explode(",", $line);
                            if ($delimiter == "3")
                                $var = explode(";", $line);
                            if (count($var) <= 1) {
                                $errors[$i] = "Empty csv or delimiter mismatch! ";
                                $obj = array("status" => "error", "error" => $errors);
                            } else {
                                if ($var[0] != "" &&  $var[2] != "" && $var[3] != "" ) {
                                    if(strlen(trim($var[3]))!=10){
                                        $errors[$i] = "Phone number is Invaild... record skipped. --" . $line;
                                    $status = "error";
                                    $obj = array("status" => $status, "error" => $errors);
                                    } else if  (!filter_var($var[2], FILTER_VALIDATE_EMAIL)) {
                                        
                                        $errors[$i] = "Invalid Email format... record skipped. --" . $line;
                                    $status = "error";
                                    $obj = array("status" => $status, "error" => $errors);
                                      }else{
                                    $resultObject = $this->setTestTakerBeanObject($var);
                                    $res = "";
                                    $toEmail = str_replace('"', '', $var[2]);
                                    $toPhone = str_replace('"', '', $var[3]);
                                    $userexist =array();
                                    $takerPhoneexist = array();
                                    $userexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($toEmail);
                                    $takerPhoneexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExistWithPhone($toPhone);
                                    if (count($userexist) > 0) {
                                        $j++;
                                        $errors[$i] = " User already exist with this Email ".$toEmail." Please  try with another Email Address.";
                                        $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                                    } else if (count($takerPhoneexist) > 0) {
                                        $errors[$i] = " User already exist with this Phone ".$toPhone." Please  try with another Phone.";    
                                        $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
                                    }else {
                                    //$saveuser = ServiceFactory::getSkiptaUserServiceInstance()->saveUser($resultObject);
                                    $saveuser = ServiceFactory::getSkiptaUserServiceInstance()->SaveUserCollection($resultObject);
                                       $obj = array('status' => 'success', 'data' => '', 'error' => ""); 
                                    //$Save_userInUserCollection = ServiceFactory::getSkiptaUserServiceInstance()->UpdateUserCollection($UserSettingsForm,$oldUserObj);
                                    } 
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

