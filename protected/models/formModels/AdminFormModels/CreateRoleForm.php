<?php

class CreateRoleForm extends CFormModel {

    public $role_name;
    public $role_status;

    public function rules() {
        return array(
            array('role_name', 'required', 'message' => 'Please enter a valid  {attribute}.'),
            array('role_name', 'match', 'pattern' => '/^[A-Za-z0-9_:; \'\-]+$/u', 'message' => "Please enter a valid {attribute}."),
            array('role_name', 'filter', 'filter'=>'trim'),
            array('role_name', 'unique_role_name'),
            array('role_status', 'role_status_validation'),
        );
    }

    public function role_status_validation($attribute) {
        if (-1 == $this->role_status) {
            $this->addError($attribute, "Please select the status.");
            return false;
        } else {
            return true;
        }
    }
    
    public function unique_role_name($attribute){
        $role_name = NULL;
        $role_name_response = NULL;
        if(isset($this->role_name) && !empty($this->role_name)){
           $role_name = $this->role_name;    
        }
        
        if(isset($role_name) && !empty($role_name)){
            $role_name_response = ServiceFactory::dashboardServiceProvider()->chkRoleName($role_name);
        }
        
        if(1 == $role_name_response){
             $this->addError($attribute, "$this->role_name already exists. Try with another one.");
            return false;
        }else if(0 == $role_name_response){
            return true;
        }    
        
        
        
    }
}

?>