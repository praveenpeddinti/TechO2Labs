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
      
  
    
        if (isset(Yii::app()->session['TinyUserCollectionObj']) && isset(Yii::app()->session['IsAdmin']) && Yii::app()->session['IsAdmin']==0 && Yii::app()->request->url!="/site/privacyPolicy"  ){

            $this->redirect('/outside/index');
        } 
          if (isset(Yii::app()->session['TinyUserCollectionObj']) && isset(Yii::app()->session['IsAdmin']) && Yii::app()->session['IsAdmin']==1  ){

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
      
       
        $this->render('login', array());
        
        } catch (Exception $ex) {
         Yii::log("SiteController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
     }
       
    }


    

    /*     * @author Vamsi Krishna
     * THis is ajax method and used for User Authentication for lofin
     *  This is the method used for login of the user it returns string if it is error and if success
      we redirect to the dashboard page
     */

    
    public function actionLogin() {
        try {
            $model = new LoginForm;
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
                    if ($resultArray == 'success') {
                        $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType($model->email, 'Email');
                        $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userObj->UserId);
                        Yii::app()->session['TinyUserCollectionObj'] = $tinyUserCollectionObj;
                        Yii::app()->session['IsAdmin'] = $userObj->IsAdmin;
                        Yii::app()->session['Email'] = $model->email;
                        $obj = array('status' => "success");
                    } else{
                     $obj = array('status' => "error",'error' =>"Invalid User Name and Password");   
                    }
                }
            }
          echo $this->rendering($obj);
        } catch (Exception $ex) {
            error_log("Exception Occurred in SiteController->actionLogin==" . $ex->getMessage());
            Yii::log("SiteController:actionLogin::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*
     * This  method is used for  New user registration if the user is already exist this method
     * will return user already exist otherwise
     *  create the new user.
     */

    public function actionRegister() {
       try{
            $model = new UserRegistrationForm();
             $cs = Yii::app()->getClientScript();
                      $cs->registerCoreScript('jquery');
            $this->render('register', array("model"=> $model));
        } catch (Exception $ex) {
         Yii::log("SiteController:actionIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    function saveimage($userId,$testTakerForm){
 
   
 if(trim($testTakerForm->Imagesrc)!=""){
 $filteredData = explode(',', $testTakerForm->Imagesrc);

$unencoded = base64_decode($filteredData[1]);
$imgpath="images/users/".$userId.'.png';
$fp = fopen("images/users/".$userId.'.png', 'w');
fwrite($fp, $unencoded);
fclose($fp);
return $imgpath;
    }
    return '/images/users/noimage.png';
    }
    
    
    public function actionRegistration() {
    try {
            $testTakerForm = new UserRegistrationForm();
            if (isset($_POST['UserRegistrationForm'])) {
            $testTakerForm->attributes = $_POST['UserRegistrationForm'];
            $errors = CActiveForm::validate($testTakerForm);
            if ($errors != '[]') {
            $obj = array('status' => 'error', 'data' => '', 'error' => $errors);
            } else {
                $takerexist =array();
                $takerPhoneexist =array();
            //    error_log("&&&&&&&&&&&&&".print_r($testTakerForm->Imagesrc,true));
   if (trim($testTakerForm->Imagesrc) != "") {
                     
                $filteredData = explode(',', $testTakerForm->Imagesrc);
                     $randomName = rand(10000, 10000000);

                                    $unencoded = base64_decode($filteredData[1]);
                                    $imgpath = "images/users/" . $randomName . '.png';
                                    $fp = fopen("images/users/" . $randomName. '.png', 'w');
                                    fwrite($fp, $unencoded);
                                    fclose($fp);
                 }
                $takerexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($testTakerForm->Email);  
                $takerPhoneexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExistWithPhone($testTakerForm->Phone);
                $isSessionExist = ServiceFactory::getTO2TestPreparaService()->isSessionExistToUser($takerPhoneexist->UserId);
               // error_log(print_r($isSessionExist,1)."===============$$$$$$$$$$$$$======================");
                $sessionObj = ServiceFactory::getTO2TestPreparaService()->updateSessionWithUserId(session_id(),$takerPhoneexist->UserId);
                if ((count($takerexist) > 0) && (count($takerPhoneexist) > 0) ) {
                    //if ( (count($takerPhoneexist) > 0) ) {
                        $checkUserTesttaken = ServiceFactory::getTO2TestPreparaService()->getTestIdByUserId($takerPhoneexist->UserId);
                        if(isset($checkUserTesttaken) && sizeof($checkUserTesttaken)>0){
                             if($checkUserTesttaken->Status==0){
                                $updatedDetails = ServiceFactory::getSkiptaUserServiceInstance()->updateTestTakerDetails($testTakerForm);
                                
                                $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType($testTakerForm->Email, 'Email');
                            
                                 if (trim($testTakerForm->Imagesrc) != "") {
                                     $destpath="images/users/" . $userObj->UserId. '.png';
                                 rename("/usr/share/nginx/www/OnlineTest/".$imgpath,"/usr/share/nginx/www/OnlineTest/".$destpath);
                                    $destpath= '/'.$destpath; 
                                }else{
                                     $destpath= '/images/users/noimage.png';
   
                                }
                                
                                $testTakerForm->Imagesrc=$destpath;
                                $updatedDetails = ServiceFactory::getSkiptaUserServiceInstance()->updateTestTakerImagePath($testTakerForm,$userObj->UserId);


                                $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userObj->UserId);
                                Yii::app()->session['TinyUserCollectionObj'] = $tinyUserCollectionObj;
                                Yii::app()->session['IsAdmin'] = $userObj->IsAdmin;
    
                          
                                $obj = array('status' => 'success', 'testInfo' => '', 'error' => ""); 

                            }else {
                                $obj = array('status' => 'error', 'error' => 'Test taker already taken Test.');  
                            }
                        }else{
                          $obj = array('status' => 'error', 'error' => 'Test taker not allowed.');  
                        }
                    }else {
                    $obj = array('status' => 'error', 'error' => 'Test taker doesnot exist.');
                }
            }
            echo CJSON::encode($obj);
        }
        
        } catch (Exception $ex) {
            error_log("Exception Occurred in SiteController->actionLogin==" . $ex->getMessage());
            Yii::log("SiteController:actionLogin::" . $ex->getMessage() . "--" . $ex->getTraceAsString(), 'error', 'application');
        }
    } 
     public function actionPrivacyPolicy() {
          if(Yii::app()->session['TinyUserCollectionObj']->UserId==''){
             $this->redirect('/site/register');
            }else{
         $testRegObj = ServiceFactory::getTO2TestPreparaService()->getTestIdByUserId(Yii::app()->session['TinyUserCollectionObj']->UserId);
      
         $testInfo = TestPreparationCollection::model()->getTestDetails($testRegObj->TestId);
      //   error_log('===========FFFFFFFFFFFF=============='.print_r($testInfo,1));
       $PrivacyPolicyForm = new PrivacyPolicyForm();
     $this->render('privacyPolicy', array("PrivacyPolicyForm"=>$PrivacyPolicyForm,"TestInfo"=>$testInfo));          
      }             
     } 
}
?>
