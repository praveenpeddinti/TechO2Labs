<?php

Class AllActiveCategoriesModel extends CActiveRecord {

    public $categoryName;
    public $status;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('categoryName', 'safe', 'on' => 'search'),
            array('status', 'safe', 'on' => 'search'),
        );
    }

    public function tableName() {
        return 'techo2_categories';
    }

    public function attributeLabels() {
        return array(
            'categoryName' => 'Category',
            'status' => 'Status',
        );
    }

    public function getAllActiveCategories() {


        $criteria = new CDbCriteria;
        
        $criteria->alias = "tc";

        $criteria->select = "tc.category_name as categoryName,CASE tc.category_status WHEN 1 THEN 'Active' WHEN 0 THEN 'Inactive' ELSE 'Inactive' END AS status";

        $criteria->compare('categoryName', $this->categoryName, true);

        $criteria->compare('status', $this->status, true);


        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'category_name ASC',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['configValues']['defaultPageSize']),
            ),
        ));
    }

}

?>