<?php
class amqp extends CApplicationComponent{
    public function init() {
        parent::init();
        $dir = dirname(__FILE__);
        $alias = md5($dir);
        Yii::setPathOfAlias($alias,$dir);
        Yii::import($alias.'.send');
    }
    public function stream($obj){
        return new send($obj);
    }
    public function achievements($obj){
        return new send($obj, "achievements");
    }
    public function geolocation($obj){
        return new send($obj, "geolocation");
    }
}
?>
