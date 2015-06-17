<?php

/*
 * Developer Suresh Reddy
 * on 8 th Jan 2014
 * all users actions need to add here
 */

class SiteController extends Controller {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }
    public function init() {
        try{
  
    $cs = Yii::app()->getClientScript();
    $cs->registerCoreScript('jquery');
      
        if (isset(Yii::app()->session['TinyUserCollectionObj'])){

            $this->redirect('/users');
        } 
         
        
      
        } catch (Exception $ex) {
         Yii::log("SiteController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }    
   
     
    }
    /**
     * @author Vamsi Krishna
     * This methods loads the login page
     *
     */
    public function actionIndex() {
       try{
    $this->model = new LoginForm;
         $cs = Yii::app()->getClientScript();
                  $cs->registerCoreScript('jquery');
      
       
        $this->render('index', array());
        
        } catch (Exception $ex) {
         Yii::log("SiteController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
       
    }


    /*
     * This  method is used for  New user registration if the user is already exist this method
     * will return user already exist otherwise
     *  create the new user.
     */

    public function actionRegister() {

        $error = "";
        $message = "";

        $UserRegistrationForm = new UserRegistrationForm;
        try {
            if (isset($_POST['UserRegistrationForm']) || (isset($_POST["mobile"]) && $_POST["mobile"]==1)) {
                $RegistrationForm_errors ="[]";
                $UserRegistrationPostData;
                if(isset($_POST["mobile"]) && $_POST["mobile"]==1){
                    parse_str($_POST["formdata"], $values);
                    $UserRegistrationPostData = $values;
                    $UserRegistrationPostData['email'] = $UserRegistrationPostData['email1'];
                    $UserRegistrationPostData['pass'] = $UserRegistrationPostData['password'];
                   if(!is_numeric($UserRegistrationPostData['Subspeciality'])){
                    $subspecObj = SubSpecialty::model()->getSubSpecialityByType("Value",$UserRegistrationPostData['Subspeciality']);
                    $UserRegistrationPostData['Subspeciality'] = $subspecObj->id;
                   }
                    
                    
                }else{
                    $UserRegistrationPostData = $_POST['UserRegistrationForm'];
                    $RegistrationForm_errors = CActiveForm::validate($UserRegistrationForm);
                }
                if ($RegistrationForm_errors != "[]") {
                    $obj = array('status' => 'fail', 'data' => '', 'error' => $RegistrationForm_errors);
                } else {
                    $email = $UserRegistrationPostData['email'];
                    $userexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($UserRegistrationPostData['email']);

                    if (count($userexist) > 0) {
                        if(isset($userexist->FromNetwork) && isset($userexist->AccessToken) && !empty($userexist->FromNetwork) && !empty($userexist->AccessToken) && Yii::app()->params['IsDSN']=='ON' )
                            {   
                                $providersData= ServiceFactory::getSkiptaUserServiceInstance()->getOauthProviderDetailsByType("NetworkName",$userexist->FromNetwork);
                                if($providersData!="failure" && sizeof($providersData)>0)
                                {
                                    //$oauthLink="<a onclick='loginWithProvider("."'".$providersData->ProviderUrl."/oauth/access_token?client_id="+$providersData->ClientId."&response_type=token&redirect_uri=". Yii::app()->params['ServerURL']."/site/restLogin','".$providersData->NetworkName."','".$providersData->ProviderLink."')'>Login with oauth</a>";
                                     $oauthLink="<a onclick='loginWithProvider(".'"'.$providersData->ProviderUrl."/oauth/access_token?client_id=".$providersData->ClientId."&response_type=token&redirect_uri=".Yii::app()->params['ServerURL']."/site/restLogin".'",'.'"'.$providersData->NetworkName.'",'.'"'.$providersData->ProviderUrl.'"'.")'> Oauth Login</a>";
                                }
                               ;
                               $message = Yii::t('translation', 'User_Already_Exist_Network');
                               $message= str_replace("network",$userexist->FromNetwork." Network",$message);
                               $message=$message." <br/> or login with this link &nbsp; ".$oauthLink;

                            }
                         else 
                             $message = Yii::t('translation', 'User_Already_Exist');
                        // $message ="User already exist with this Email Please  try with another  Email Address";
                        $obj = array('status' => 'fail', 'data' => $message, 'error' => $RegistrationForm_errors);
                    } else {

                        $CustomForm = new CustomForm();
                        $customfields = array();
                        $CustomForm->attributes = $UserRegistrationPostData;
                        foreach ($CustomForm->attributes as $key => $value) {
                            $customfields[$key] = $UserRegistrationPostData[$key];
                        }
                        $UserRegistrationPostData['status'] = 0;
                        $Save_userInUserCollection = ServiceFactory::getSkiptaUserServiceInstance()->SaveUserCollection($UserRegistrationPostData, $customfields);
                        // $Saveuser = ServiceFactory::getSkiptaUserServiceInstance()->saveUserProfile($_POST['UserRegistrationForm'], $customfields);
                        if ($Save_userInUserCollection != 'error') {
                            error_log($Save_userInUserCollection."====Lakshman##############################################");
                            $message = Yii::t('translation', 'User_Register_Success');
                            //$message ="User Registered Successfully";
                            $obj = array('status' => 'success', 'data' => $message, 'error' => '');
                        } else {
                            $errormsg = Yii::t('translation', 'User_Register_Fail');
                            // $errormsg="User registration failed";
                            $obj = array('status' => 'fail', 'data' => $errormsg, 'error' => '');
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            Yii::log("SiteController:actionRegister::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        $renderScript = $this->rendering($obj);
        echo $renderScript;
    }

    /*     * @author Vamsi Krishna
     * THis is ajax method and used for User Authentication for lofin
     *  This is the method used for login of the user it returns string if it is error and if success
      we redirect to the dashboard page
     */

    
    public function actionLogin() {
        try {
            error_log("Exception Occurred in SiteController->actionLogin==");
            $model = new LoginForm;


            error_log("Exception Occurred in SiteC222222222ontroller->actionLogin==");
            $request = yii::app()->getRequest();
            $formname = $request->getParam('LoginForm');
            if ($formname != '') {
                $model->attributes = $formname;
                $errors = CActiveForm::validate($model);
                if ($errors != '[]') {
                    $obj = array('status' => 'error', 'data' => '', 'error' => Yii::t('translation', $errors));
                    echo $this->rendering($obj);
                    return;
                } else {
                    $resultArray = ServiceFactory::getSkiptaUserServiceInstance()->userAuthentication($model);
                    error_log("user authenticationnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn".$resultArray);
                    if ($resultArray == 'success') {
                        $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType($model->email, 'Email');
                        //ServiceFactory::getSkiptaUserServiceInstance()->saveUserLoginActivity($userObj->UserId);
                       
                        error_log("user authenticationnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn".print_r($userObj,true));
                        $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userObj->UserId);
                        
                        
                        
                        Yii::app()->session['TinyUserCollectionObj'] = $tinyUserCollectionObj;
                        Yii::app()->session['IsAdmin'] = $userObj->IsAdmin;
                        Yii::app()->session['Email'] = $model->email;

                        $obj = array('status' => "success");
                    } else{
                     $obj = array('status' => "error");   
                    }
                }
            }
          echo $this->rendering($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in SiteController->actionLogin==" . $ex->getMessage());
            Yii::log("SiteController:actionLogin::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }


}
?>
