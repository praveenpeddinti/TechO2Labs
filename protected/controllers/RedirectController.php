<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RedirectController extends Controller{
    
    public function init() {
        $servername= Yii::app()->params['ServerURL'];
        $this->redirect($servername."/marketresearchwall");
    }

    public function actionIndex(){
        
    }
    
    
}