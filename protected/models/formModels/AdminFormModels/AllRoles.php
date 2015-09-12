<?php

Class AllRoles extends CActiveRecord {

    public $roleName;
    public $status;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('roleName', 'safe', 'on' => 'search'),
            array('status', 'safe', 'on' => 'search'),
        );
    }

    public function tableName() {
        return 'techo2_employee_designation';
    }

    public function attributeLabels() {
        return array(
            'roleName' => 'Role Name',
            'status' => 'Status',
        );
    }

    public function getAllRoles() {


        $criteria = new CDbCriteria;
        
        $criteria->alias = "ted";

        $criteria->select = "ted.name as roleName,CASE ted.status WHEN 1 THEN 'Active' WHEN 0 THEN 'Inactive' ELSE 'Inactive' END AS status";

        $criteria->compare('roleName', $this->roleName, true);

        $criteria->compare('status', $this->status, true);


        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'name ASC',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['configValues']['defaultPageSize']),
            ),
        ));
    }

}

?>