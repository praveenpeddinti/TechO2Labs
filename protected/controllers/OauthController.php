<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class OauthController extends   Controller{
    
 
    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }
 public function init() {
    try{
        $this->initializeforms();
        $this->layout='main';
    } catch (Exception $ex) {
            Yii::log("OauthController:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }

    public function actionAuthorize() {
        try{
        $_POST = array("client_id" => 1234567890, 'response_type' => 'token', 'redirect_uri' => 'http://10.10.73.102:8080/site/login');
        $oauth = YiiOAuth2::instance();
        $auth_params = $oauth->getAuthorizeParams();
        $app = $oauth->getClients($auth_params['client_id']);
        $oauth->setVariable("user_id", 1);
        $oauth->finishClientAuthorization(TRUE, $_POST);
        

        if ($_POST) {
// $this->authorization();
            //add your verify username and password code here;
            //$user_id = User::model()->getIdByUsername($_POST['username']);
        }
        } catch (Exception $ex) {
            Yii::log("OauthController:actionAuthorize::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function authorization() {
        try{
        $token = YiiOAuth2::instance()->verifyToken();
        // If we have an user_id, then login as that user (for this request)
        if ($token && isset($token['user_id'])) {

            self::setUid($token['user_id']);
            self::$_oauth = true;
        } else {

            $msg = "Can't verify request, missing oauth_consumer_key or oauth_token";
            throw new CHttpException(401, $msg);
            exit();
        }
        } catch (Exception $ex) {
            Yii::log("OauthController:authorization::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function setUid($uid) {
        try{
        if (empty($uid)) {
            $msg = "authorization failed, missing login user id.";
            throw new CHttpException(401, $msg);
            exit();
        }
        self::$_uid = $uid;
        } catch (Exception $ex) {
            Yii::log("OauthController:setUid::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function getUid() {
        //return "test";
        try{
        if (empty(self::$_uid)) {
            $msg = "Not found";
            throw new CHttpException(403, $msg);
            exit();
        }

        return self::$_uid;
        } catch (Exception $ex) {
            Yii::log("OauthController:getUid::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

   public function actionAccess_token() {
       try{ 
       if (isset(Yii::app()->session['TinyUserCollectionObj']) && !isset($_GET['mobile'])) {
            $_GET['response_type']="token";
            $_POST = $_GET;
            $oauth = YiiOAuth2::instance();
            $auth_params = $oauth->getAuthorizeParams();
            $app = $oauth->getClients($auth_params['client_id']);
//          rror_log(print_r($oauth->setVariable("user_id", Yii::app()->session['TinyUserCollectionObj']->UserId), true));
            $oauth->setVariable("user_id", Yii::app()->session['TinyUserCollectionObj']->UserId);
            $oauth->finishClientAuthorization(TRUE, $_POST);
        } else {
            if(isset($_GET['mobile']) && $_GET['mobile'] == 1 ){
                $fromMobile = 1;
            }else{
               $fromMobile = 0; 
        }
            $this->redirect('/oauth/apiLogin?client_id=' . $_GET['client_id'] . '&redirect_uri=' . $_GET['redirect_uri']."&providerLink=". $_GET['providerLink']."&fromNetwork=". $_GET['fromNetwork']."&mobile=". $fromMobile);
    }
    } catch (Exception $ex) {
            Yii::log("OauthController:actionAccess_token::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionApiLogin() {
        try {
          
            $cs = Yii::app()->getClientScript();
            $consumerObj="";
            $baseUrl = Yii::app()->baseUrl;
            $cs->registerCssFile($baseUrl . '/css/oauth-skiptaNeo.css');
            $cs->registerCssFile($baseUrl . '/css/oauth-skiptatheme.css');
            $_GET['response_type']="token";
              $oauth = YiiOAuth2::instance();
              $app = $oauth->getClients($_GET['client_id']);
              $isValidClient="false";
             
              if(isset($app['client_id']) ){
                 $consumerObj= $this->setConsumerAppProperties($app);
                  $isValidClient="true";
              }
              
            $model = new LoginForm;
          
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                
                if (isset($_POST['cancel'])) {
                  
                    $oauth->finishClientAuthorization(FALSE, '', $app['domain_name'], "CANCEL");
                }


                $loginForm_errors = CActiveForm::validate($model);
                if ($loginForm_errors != "[]") {

                    $obj = array('status' => 'fail', 'data' => '', 'error' => $loginForm_errors);
                } else {
                    $resultArray = ServiceFactory::getSkiptaUserServiceInstance()->userAuthentication($model);
                    if ($resultArray == 'success') {
                         $status = "success";
                    /*Cookie based login*/
                     $identity= new UserIdentity($model->email,$model->pword);
                     $duration=$model->rememberMe ? 3600*24*60 : 0; // 30 days
                 
                    $identity->authenticate();//must
                    Yii::app()->user->login($identity,$duration);
                    $randomKey  = Yii::app()->user->getState('s_k');
                     /*Cookie based login*/
                
                    CommonUtility::setUserSession($model->email);
                        Yii::app()->session['PostAsNetwork'] = 0;
                        Yii::app()->session['LoginUserEmail'] = $model->email;
                        Yii::app()->session['LoginUserFirstName'] = Yii::app()->session['UserStaticData']['FirstName'];
                        if (isset(YII::app()->params['NetworkAdminEmail'])) {
                            $netwokAdminObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType(YII::app()->params['NetworkAdminEmail'], 'Email');
                            Yii::app()->session['NetworkAdminUserId'] = $netwokAdminObj->UserId;
                            Yii::app()->session['NetworkAdminUserName'] = $netwokAdminObj->FirstName . " " . $netwokAdminObj->LastName;
                        }


                        //             $_POST=$_GET;

                        $_POST = $_GET;
                        $oauth = YiiOAuth2::instance();
                        $auth_params = $oauth->getAuthorizeParams();

                        $app = $oauth->getClients($auth_params['client_id']);

                        $oauth->setVariable("user_id", Yii::app()->session['TinyUserCollectionObj']->UserId);
                if(isset($_GET['mobile']) && $_GET['mobile'] == 1){
                        $access_token =  $oauth->createAccessToken($auth_params['client_id'], $scope);
                      $this->redirect(Yii::app()->params['ServerURL'].'/oauthMobileReturn.php#oauth='.$access_token["access_token"]."&providerLink=".$_GET['providerLink']."&fromNetwork=".$_GET['fromNetwork']);

                        
                       // $this->actionMobileRestLogin($access_token["access_token"],$_GET['providerLink'],$_GET['fromNetwork']); 
                       }else{
                        $oauth->finishClientAuthorization(TRUE, $_POST);
                       }
                    } else {
                        if ($resultArray == 'suspend' || $resultArray == 'register' || $resultArray == 'wrongEmail' || $resultArray == 'contactAdmin') {
                            $errormsg = Yii::t('translation', $resultArray);
                            $obj = array('status' => 'fail', 'data' => $errormsg, 'error' => '');
                            $model->addError('email', Yii::t('translation',$resultArray));
                        }if ($resultArray == 'passwordIncorrect') {
                            $errormsg = Yii::t('translation', $resultArray);
                            $obj = array('status' => 'fail', 'data' => $errormsg, 'error' => '');
                            $model->addError('password', Yii::t('translation',$resultArray));
                        }
                    }
                }
            }
 if(isset($_GET['mobile']) && $_GET['mobile'] == 1){
      $mobile = 1;
  }else{
      $mobile = 0;
  }
     
        
            $this->render('apiLogin', array('model' => $model,'consumerObj'=>$consumerObj, 'isValidClient'=> $isValidClient,'mobile'=>$mobile));
        } catch (Exception $ex) {
            Yii::log("OauthController:actionApiLogin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
protected function genAccessToken() {
    try{
        return md5(base64_encode(pack('N6', mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), uniqid())));
    } catch (Exception $ex) {
            Yii::log("OauthController:genAccessToken::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
  }
    function setConsumerAppProperties($array) {
        $consumerProperties = New ConsumerProperties();
        try {
            $consumerProperties->ClientId = $array['client_id'];
            $consumerProperties->ClientSecret = $array['client_secret'];
            $consumerProperties->RedirectURI = $array['redirect_uri'];
            $consumerProperties->Title = $array['app_title'];
            $consumerProperties->Description = $array['app_desc'];
            $consumerProperties->Picture = $array['pic'];
             $consumerProperties->DomainName = $array['domain_name'];
            return $consumerProperties;
        } catch (Exception $ex) {
            Yii::log("OauthController:setConsumerAppProperties::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    function actionGetUserProfileDetails() {
        try {
            if (isset($_GET['access_token'])) {
                $oauth = YiiOAuth2::instance();
                $tokenDetails = $oauth->getToken($_GET['access_token'], 'access');
                if (isset($tokenDetails)) {

                    $userId = $tokenDetails['user_id'];
                    $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection((int) $userId);

                    $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType((int) $userId,'UserId');
                    
                    $userBean = new TinyUserBean();
                    $userBean->APIAccessKey = $userObj->APIAccessKey;
                    $userBean->DisplayName = $tinyUserCollectionObj->DisplayName;
                    $userBean->AboutMe = $tinyUserCollectionObj->AboutMe;
                   //   $userBean->Network = $tinyUserCollectionObj->Network;
                    $userBean->ProfilePicture = $tinyUserCollectionObj->profile250x250;
                    $obj = array("status" => "success", "data" => array("Response"=>$userBean));
                    echo CJSON::encode($obj);
                }
                else{
                     $obj = array("status" => "error", "data" => array("Response"=>"","errorMessage"=>"access token mismatch!"));
                    echo CJSON::encode($obj);
                }
            }
        } catch (Exception $ex) {
            Yii::log("OauthController:actionGetUserProfileDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    function actionGetUserData() {
        
       
        try {
            if (isset($_GET['UserApiAccessKey'])) {
               
                
                    $UserApiAccessKey = $_GET['UserApiAccessKey'];
                    
                   
                    $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType( $UserApiAccessKey,'APIAccessKey');
                   
                    $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection((int)($userObj->UserId));
                
                 
                   $userBean= $this->prepareUserRegisterBean($userObj,$tinyUserCollectionObj,$_GET['fromNetwork']);
                  
                    $obj = array("status" => "success", "data" => array("Response"=>$userBean));
                    echo CJSON::encode($obj);
            }
                else{
                     $obj = array("status" => "error", "data" => array("Response"=>"","errorMessage"=>"Invalid UserAPIAccessKey!"));
                    echo CJSON::encode($obj);
                }
            
        } catch (Exception $ex) {
            Yii::log("OauthController:actionGetUserData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function prepareUserRegisterBean($userObj,$tinyUserCollectionObj,$fromNetwork)    { 
        try{
            $userBean=new UserRegisterBean();
            $userBean->firstName=$userObj->FirstName;

            $userBean->lastName=$userObj->LastName;

            $userBean->displayName=$userObj->DisplayName;
            $countryData=Countries::model()->getCountryById($userObj->Country);
            $userBean->country=$countryData->Name;
            $userBean->state=$userObj->State;
            $userBean->city=$userObj->City;
            $userBean->zip=$userObj->Zip;
            $userBean->companyName=$userObj->Company;
            $userBean->aboutMe=$tinyUserCollectionObj->AboutMe;

            $userBean->profilePicture=$tinyUserCollectionObj->profile250x250;


            $userBean->status=$userObj->Status;
            $userBean->email=$userObj->Email;
            $userBean->registredDate = date('Y-m-d H:i:s', time());

            $userBean->apiAccessKey = $userObj->APIAccessKey;

            $userBean->fromNetwork = $fromNetwork;

            return $userBean;
         } catch (Exception $ex) {
            Yii::log("OauthController:prepareUserRegisterBean::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }  
         
    }

}
