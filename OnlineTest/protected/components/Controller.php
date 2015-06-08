<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public $layout='userLayout';
        public $sidelayout='no';
        public $tinyObject;
        public $userPrivileges;
        public $userPrivilegeObject;
        public $whichmenuactive;
        public $guest;
        public $returnUrl;
        public $model;
        public $UserRegistrationForm;
        public $forgotModel;
        public $countries;
        public $resetForm;
        public $oAuthNetworksInfo;
        public $subSpe;
     
        public function initializeforms() {
            try{
            if(!isset(Yii::app()->session['TinyUserCollectionObj'])) {
                $this->model = new LoginForm;
                $this->forgotModel = new ForgotForm;  
                $this->UserRegistrationForm = new UserRegistrationForm;
                $this->resetForm = new ResetForm();
                $this->countries = ServiceFactory::getSkiptaUserServiceInstance()->GetCountries(); 
                $this->subSpe = ServiceFactory::getSkiptaUserServiceInstance()->getCustomSubSpeciality(); 
                $this->oAuthNetworksInfo=array();
                if(Yii::app()->params['IsDSN']=='ON')
                {
                    $returnProvidersData= ServiceFactory::getSkiptaUserServiceInstance()->getAllOauthProviderDetails();
                    if($returnProvidersData!="failure" && count($returnProvidersData)>0)
                        $this->oAuthNetworksInfo= $returnProvidersData;
                }
            }
            } catch (Exception $ex) {
            Yii::log("Controller:initializeforms::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            }
        }
        public function init() {
        try{
        //parent::init();
        if(!isset($_REQUEST['mobile'])){
                  $cs = Yii::app()->getClientScript();
                  $cs->registerCoreScript('jquery');
                  $this->cookieBasedLogin();
             }
             if(isset(Yii::app()->session['language'])){
                 Yii::app()->language = Yii::app()->session['language'];
                // Yii::app()->sourceLanguage = Yii::app()->session['sourceLanguage'];
             }else{
               //  Yii::app()->language = "en_us";
                 Yii::app()->language = "en";
             }
         if(isset($_REQUEST['timezone'])){
             $timezone = $_REQUEST['timezone'];
              Yii::app()->session['timezone']=$timezone;
        }
        } catch (Exception $ex) {
            Yii::log("Controller:init::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
       public function cookieBasedLogin(){
        try{    
        if(!Yii::app()->request->isAjaxRequest){
                  Yii::app()->session['returnUrl'] = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
          }
           if(Yii::app()->user->isGuest ){
               $this->guest = "true";
                if(Yii::app()->request->isAjaxRequest) {
                    $result = array("code"=>440,"status"=>"sessionTimeout");
                     echo $this->rendering($result);
                      Yii::app()->end();
                }else{
                    Yii::app()->request->cookies['r_u'] = new CHttpCookie('r_u',  Yii::app()->session['returnUrl']);
                    $this->redirect('/');
                }
               
               
              
        }else{ 
            $this->guest = "false";//
            $randomString = Yii::app()->user->getState('s_k');
            if (!isset(Yii::app()->session['TinyUserCollectionObj']) || empty(Yii::app()->session['TinyUserCollectionObj'])) {
                $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType(Yii::app()->user->getName(), 'Email');
                $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userObj->UserId);
                $validityOfCookie = ServiceFactory::getSkiptaUserServiceInstance()->checkCookieValidityForUser($userObj->UserId,$randomString);
                if ($validityOfCookie=="true") {
                         CommonUtility::reloadUserPrivilegeAndDataByCookie($userObj);
                } else {

                    $this->guest = "true";
                    $this->redirect('/');
                }
            } else {
             
                }
        }
        } catch (Exception $ex) {
            Yii::log("Controller:cookieBasedLogin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       }
        public function rendering($result) {
        try{
            header('Content-type: application/json');  
            return(CJSON::encode($result));
        } catch (Exception $ex) {
            Yii::log("Controller:rendering::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        } 
        
        public function applyLayout($name){
        try{ 
            $this->layout=$name;
        } catch (Exception $ex) {
            Yii::log("Controller:applyLayout::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        public function throwErrorMessage($id,$translation){
            try{
            $obj = array("status" => 'error', "error" => array($id => Yii::t('translation', $translation)));
            echo $this->rendering($obj);
            } catch (Exception $ex) {
            Yii::log("Controller:throwErrorMessage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }
        public function throwSuccessMessage($data,$translation){
            try{
            $obj = array("status" => 'success',"data"=>$data,"message" => array(Yii::t('translation', $translation)));
            echo $this->rendering($obj);
            } catch (Exception $ex) {
            Yii::log("Controller:throwSuccessMessage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        }   
        
    public function getFileExtension($str="") {
        try{
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);

        return strtolower($ext);
        } catch (Exception $ex) {
            Yii::log("Controller:getFileExtension::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}
