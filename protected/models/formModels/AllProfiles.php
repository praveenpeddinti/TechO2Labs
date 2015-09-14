<?php

class AllProfiles extends CActiveRecord {

    public $phonenumber;
    public $designation_name;
    public $email;
    public $employee_address;
    public $statename;
    public $country_name;
    public $status;
    /*Kavya Sep10 Start*/
    public $s_no;
    public $emp_name;
    public $emp_code;
    public $contact;
    /*Kavya Sep10 End*/

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //[Need To Review ]
    //public function rules() {
//        return array(
//            array('employee_firstname', 'safe', 'on' => 'search'),
//            array('employee_middlename', 'safe', 'on' => 'search'),
//            array('employee_lastname', 'safe', 'on' => 'search'),
//            array('employee_gender', 'safe', 'on' => 'search'),
//            array('employee_dob', 'safe', 'on' => 'search'),
//            array('phonenumber', 'safe', 'on' => 'search'),
//            array('email', 'safe', 'on' => 'search'),
//            array('employee_tag_code', 'safe', 'on' => 'search'),
//            array('designation_name', 'safe', 'on' => 'search'),
//            array('employee_address', 'safe', 'on' => 'search'),
//            array('statename', 'safe', 'on' => 'search'),
//            array('country_name', 'safe', 'on' => 'search'),
//            array('employee_status', 'safe', 'on' => 'search'),
//        );
  //  }

    public function tableName() {
        return 'techo2_employee';
    }

    public function attributeLabels() {
        return array(
            'employee_firstname' => 'Firstname',
            'employee_middlename' => 'Middlename',
            'employee_lastname' => 'Lastname',
            'employee_gender' => 'Gender',
            'employee_dob' => 'Date Of Birth',
            'phonenumber' => 'Phonenumber',
            'email' => 'Email',
            'employee_tag_code' => 'Code',
            'designation_name' => 'Designation',
            'employee_address' => 'Address',
            'statename' => 'State',
            'country_name' => 'Country',
            'employee_status' => 'Status',
            /*Kavya Sep10 Start*/
            's_no'=> Yii::t('WidgetLabels', 's_no'),
            'emp_name'=> Yii::t('WidgetLabels', 'emp_name'),
            'emp_code'=> Yii::t('WidgetLabels', 'emp_code'),
            'contact'=> Yii::t('WidgetLabels', 'contact'),
            /*Kavya Sep10 End*/
        );
    }

    public function getAllProfiles() {


        $criteria = new CDbCriteria;

        $criteria->together = true;

        $criteria->alias = "te";

        $criteria->join = "INNER JOIN techo2_employee_phone as tep ON(tep.employee_idemployee=te.employee_id)";
        $criteria->join .="INNER JOIN techo2_employee_email as tee ON(tee.employee_idemployee=te.employee_id)";
        $criteria->join .="INNER JOIN techo2_employee_designation as ted ON(ted.employee_designation_id=te.designation_iddesignation)";
        $criteria->join .="INNER JOIN techo2_employee_address as tea ON(tea.employee_idemployee = te.employee_id)";
        $criteria->join .="INNER JOIN techo2_state as ts ON(ts.idstate = tea.state_idstate and ts.status = 1)";
        $criteria->join .="INNER JOIN techo2_country as tc ON(tc.idcountry = ts.country_idcountry and tc.status = 1)";

        $criteria->select = 'te.employee_dob,te.employee_firstname,te.employee_middlename,te.employee_lastname,te.employee_id,te.employee_status,tep.phonenumber,tee.email,te.employee_tag_code,ted.name as designation_name,tea.address as employee_address,ts.name as statename,tc.name as country_name,CASE te.employee_gender WHEN "M" THEN "Male" WHEN "F" THEN "Female" WHEN "O" THEN "Other" ELSE "Other" END AS employee_gender,CASE te.employee_status WHEN 0 THEN "Inactive" WHEN 1 THEN "Active" ELSE "Inactive" END as status,te.employee_id';

//[Need To Review ]
//        $criteria->compare('employee_firstname', $this->employee_firstname, true);
//        $criteria->compare('employee_middlename', $this->employee_middlename, true);
//        $criteria->compare('employee_lastname', $this->employee_lastname, true);
//        $criteria->compare('employee_gender', $this->employee_gender, true);
//        $criteria->compare('employee_dob', $this->employee_dob, true);
//        $criteria->compare('phonenumber', $this->phonenumber, true);
//        $criteria->compare('email', $this->email, true);
//        $criteria->compare('employee_tag_code', $this->employee_tag_code, true);
//        $criteria->compare('designation_name', $this->designation_name, true);
//        $criteria->compare('employee_address', $this->employee_address, true);
//        $criteria->compare('statename', $this->statename, true);
//        $criteria->compare('country_name', $this->country_name, true);
//        $criteria->compare('status', $this->status, true);





        $dataProvider = new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'employee_firstname ASC',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['configValues']['defaultPageSize']),
            ),
        ));


        return $dataProvider;
    }
    
    /*
     * Author   : Renigunta Kavya 
     * Date     : 10-09-2015
     * Method   : getAllRatingData
     * Function : Get the data of ratings based on pagination count 
     * Return type : Array
     */
    
    public function getAllRatingData($searchel=NULL) {

        $criteria = new CDbCriteria;

        $criteria->together = true;

        $criteria->alias = "te";

        $criteria->join = "INNER JOIN techo2_employee_phone as tep ON(tep.employee_idemployee=te.employee_id)";
        $criteria->join .="INNER JOIN techo2_employee_email as tee ON(tee.employee_idemployee=te.employee_id)";

        $criteria->select = 'te.employee_id as s_no,concat(te.employee_firstname," ",te.employee_middlename," ",te.employee_lastname) as emp_name,te.employee_tag_code as emp_code,tee.email as email,tep.phonenumber as contact';
        
        if(NULL!=$searchel){
//            $criteria->addSearchCondition('employee_firstname', $searchel, true, 'OR');
//            $criteria->addSearchCondition('employee_middlename', $searchel, true, 'OR');
//            $criteria->addSearchCondition('employee_lastname', $searchel, true, 'OR');
            $criteria->addSearchCondition('concat(employee_firstname," ",employee_middlename," ",employee_lastname)', $searchel, true, 'OR');
        }
        
        
        $dataProvider = new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 's_no ASC',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['configValues']['defaultPageSize']),
            ),
        ));

        return $dataProvider;
    }
    
}

?>