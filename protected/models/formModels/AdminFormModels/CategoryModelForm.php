<?php

class CategoryModelForm extends CFormModel {

    public $category_name;
    public $category_status;

    public function rules() {
        return array(
            array('category_name', 'required', 'message' => 'Please enter a valid  {attribute}.'),
            array('category_name', 'match', 'pattern' => '/^[A-Za-z0-9_:; \'\-]+$/u', 'message' => "Please enter a valid {attribute}."),
            array('category_name', 'filter', 'filter'=>'trim'),
            array('category_name', 'unique_category_name'),
            array('category_status', 'category_status_validation'),
        );
    }

    public function category_status_validation($attribute) {
        if (-1 == $this->category_status) {
            $this->addError($attribute, "Please select the status.");
            return false;
        } else {
            return true;
        }
    }
    
    public function unique_category_name($attribute){
        $category_name = NULL;
        $category_name_response = NULL;
        if(isset($this->category_name) && !empty($this->category_name)){
           $category_name = $this->category_name;    
        }
        
        if(isset($category_name) && !empty($category_name)){
            $category_name_response = ServiceFactory::dashboardServiceProvider()->chkCategoryName($category_name);
        }
        
        if(1 == $category_name_response){
             $this->addError($attribute, "$this->category_name already exists. Try with another one.");
            return false;
        }else if(0 == $category_name_response){
            return true;
        }    
        
        
        
    }
}

?>