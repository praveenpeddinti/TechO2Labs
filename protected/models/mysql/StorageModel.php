<?php
class StorageModel extends CActiveRecord{
    //    Model data
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'techo2_rating_images';
    }
    public function storeFile($fileData,$savedFilename,$session_user) 
        {       
        $storagemodel = new StorageModel;
        $storagemodel->image_name = $savedFilename;
        $storagemodel->image_type = $fileData->type;
        $storagemodel->image_size = $fileData->size;
        $storagemodel->image_extension = $fileData->extensionName;
        $storagemodel->createdby = $session_user;
        $storagemodel->createddate = date('Y-m-d H:i:s');
        if($storagemodel->save())
            {
                return TRUE;
            }
        return false;
        }
    
    
    public function getFiles() {
      $results = Yii::app()->db->createCommand()
              ->select()
              ->from('techo2_rating_images')
              ->queryAll(); 
      if(!empty($results)){
          return $results;
      }
      return FALSE;
    }
}
?>