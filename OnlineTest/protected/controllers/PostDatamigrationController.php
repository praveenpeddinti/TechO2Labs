<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PostDatamigrationController extends ERestController
{
    /**
     * @author:Praneeth
     * @param  $userCategories 
     * Description: Used to save the categories in MySql and MongoDB databases
     * Purpose: for data migration
     */
     public function actionCurbsideCategorySave() {
        try {
            $userCategories = CJSON::decode($_REQUEST['data'], true);
            $categoryModel = new CurbsidecategorycreationForm();
            foreach ($userCategories as $category) {
                foreach ($category as $key => $value) {                    
                    $categoryModel->category = $value;
                    $userObj = $this->skiptaUserService->adminCategoryCreationService($categoryModel);
                    $message = "category saved successfully";
                }
            }
            echo $message;
        } catch (Exception $ex) {
            Yii::log("-----exception in actionCurbsideCategorySaving--------" . $ex->getMessage(), "error", "application");
        }
    }
}