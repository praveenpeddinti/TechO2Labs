<?php

class StreamNoteCollection extends EMongoDocument{
  
   public $StreamText;
   public $TranslatedString;
   public $FromLang;
   public $ToLang;
   

    public function getCollectionName() {
        return 'StreamNoteCollection';
    }
//    public function indexes() {
//        return array(
////            'index_userId' => array(
////                'key' => array(
////                //    'StreamText' => EMongoCriteria::SORT_ASC
////                ),
//            )
//        );
//    }
    public function attributeNames() {
        return array(
            'StreamText' => 'StreamText',
            'FromLang' => 'FromLang',
            'ToLang' => 'ToLang',
            'TranslatedString' => 'TranslatedString',
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
   
    /**

     * this method is used to save translated stream note
     * if saves to the userCollection it returns the userID 
     */
    public function saveTranslatedStreamNote($text, $fromLanguage, $toLanguage, $translatedText) {
        try {
            $returnValue=FALSE;
            $translatedObj = new StreamNoteCollection();
            $translatedObj->StreamText = $text;
            $translatedObj->FromLang = trim($fromLanguage);
            $translatedObj->ToLang = trim($toLanguage);
            $translatedObj->TranslatedString = $translatedText;
            $translatedObj->insert();

            if (isset($translatedObj->_id)) {
                $returnValue = true;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("StreamNoteCollection:saveTranslatedStreamNote::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /** This method gets tinyUser collection object from mongo 
    It accepts userId as a paramter and returns faliure string if it didnot find the record and returns 
    * tiny user obj if it finds    */
   public function isStreamNoteTranslated($streamnote,$toLang){
       try {
          $returnValue='false';
          
            $mongoCriteria = new EMongoCriteria;     
            $mongoCriteria->StreamText = new MongoRegex('/'.$streamnote.'.*/i');                
            $mongoCriteria->ToLang=trim($toLang);
            $resObj = StreamNoteCollection::model()->find($mongoCriteria);
             if(is_array($resObj) || is_object($resObj)){
                $returnValue = $resObj->TranslatedString;
            }
            return $returnValue;    
       } catch (Exception $ex) {
           Yii::log("StreamNoteCollection:isStreamNoteTranslated::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
      }


}