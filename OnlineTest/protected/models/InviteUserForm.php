<?php

class InviteUserForm extends CFormModel {

   public $Name;
   public $StartDate;
   public $EndDate;
   public $AllUsers;
   public $TestId;
   public $Date;
   public $Time;
   public function rules() {
        return array(
            
            array('StartDate,EndDate', 'required'),           
            array('Name,StartDate,EndDate,AllUsers,TestId', 'safe'),
            
        );
    }
    

}
