<?php

class CreateStatusForm extends CFormModel {

    public $status_name;
    
    public function rules() {
        return array(
            array('status_name', 'required', 'message' => 'Please enter a valid  {attribute}.'),
            array('status_name', 'match', 'pattern' => '/^[A-Za-z0-9_:; \'\-]+$/u', 'message' => "Please enter a valid {attribute}."),
            array('status_name', 'filter', 'filter'=>'trim'),
            array('status_name', 'unique_status_name'),
        );
    }

   
    
    public function unique_status_name($attribute){
        $status_name = NULL;
        $status_name_response = NULL;
        if(isset($this->status_name) && !empty($this->status_name)){
           $status_name = $this->status_name;    
        }
        
        if(isset($status_name) && !empty($status_name)){
            $status_name_response = ServiceFactory::dashboardServiceProvider()->chkStatusName($status_name);
        }
        
        if(1 == $status_name_response){
             $this->addError($attribute, "$this->status_name already exists. Try with another one.");
            return false;
        }else if(0 == $status_name_response){
            return true;
        }
    }
}

?>