    <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class UserProfileCollectionMongo extends EMongoDocument // Notice: We extend EMongoDocument class instead of CActiveRecord
{
    public $userId;
    public $firstName;
    public $lastName;
    public $salutation;
    public $displayName;
    public $country;
    public $state;
    public $city;
    public $zip;
    /**
     * This method have to be defined in every Model
     * @return string MongoDB collection name, witch will be used to store documents of this model
     */
    public function getCollectionName()
    {
        return 'UserProfileCollection';
    }

    
    /**
     * This method have to be defined in every model, like with normal CActiveRecord
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
   
   
}
?>
