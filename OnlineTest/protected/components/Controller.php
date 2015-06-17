<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{/**
	 * @var string the default layout for the controller view. Defaults to 'column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='userLayout';
         public $model;
           public $whichmenuactive;
           public $sidelayout='no';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
        public $tinyObject='';
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
       public function init() {
        try{
          $cs = Yii::app()->getClientScript();
                  $cs->registerCoreScript('jquery');
        } catch (Exception $ex) {

       }}
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
