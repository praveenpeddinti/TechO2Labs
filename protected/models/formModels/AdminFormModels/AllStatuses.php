<?php

Class AllStatuses extends CActiveRecord {

    public $statusName;
    public $status;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('statusName', 'safe', 'on' => 'search'),
            array('status', 'safe', 'on' => 'search'),
        );
    }

    public function tableName() {
        return 'techo2_status';
    }

    public function attributeLabels() {
        return array(
            'statusName' => 'Status Name',
            'status' => 'Status',
        );
    }

    public function getAllStatuses() {


        $criteria = new CDbCriteria;
        
        $criteria->alias = "ts";

        $criteria->select = "ts.status_name as statusName,CASE ts.status_status WHEN 1 THEN 'Active' WHEN 0 THEN 'Inactive' ELSE 'Inactive' END AS status";

        $criteria->compare('statusName', $this->statusName, true);

        $criteria->compare('status', $this->status, true);


        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'status_name ASC',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['configValues']['defaultPageSize']),
            ),
        ));
    }

}

?>