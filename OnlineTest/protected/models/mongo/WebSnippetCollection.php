<?php
/**
 * This collection is used to create a new group
 * @author Praneeth
 */
class WebSnippetCollection extends EMongoDocument {

    public $_id;    
    public $Weburl;
    public $WebImage;
    public $WebLink;
    public $Webdescription;
    public $WebTitle;
    public $CreatedOn;
    

    public function getCollectionName() {
        return 'WebSnippetCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function indexes() {
        return array(
            'index_Weburl' => array(
                'key' => array(
                    'Weburl' => EMongoCriteria::SORT_ASC
                ),
            ),
            'index_WebLink' => array(
                'key' => array(
                    'WebLink' => EMongoCriteria::SORT_ASC
                ),
            ),
        );
    }
    public function attributeNames() {
        return array(
            '_id'=>'_id',            
            'Weburl' => 'Weburl',
            'WebImage' => 'WebImage',
            'WebLink' => 'WebLink',
            'Webdescription' => 'Webdescription',
            'WebTitle' => 'WebTitle',
            'CreatedOn' => 'CreatedOn',
        );
    }
/**
     * @author Haribabu
     * @param type snippet object
     * @method TO Save  a new  websnippet
     * @return object type id value
     */
public function saveNewWebSnippet($weburl,$SnippetObj, $createdDate='') {
        try {
           
            $returnValue = 'failure';
            if(isset($SnippetObj['thumbnail_url']) && $SnippetObj['thumbnail_url']!=""){
                $pattern = '~(http.*\.)(jpe?g|png|[tg]iff?|svg)~i';
                $m = preg_match_all($pattern,$SnippetObj['thumbnail_url'],$matches);

                     if(is_array($matches[0]) && sizeof($matches[0])>0){
                         
                          $webImage=$SnippetObj['thumbnail_url'];
                     }else{
                         $webimage="";
                     }
                
               
            }else{
                $webImage="";
            }
            
            $NewSnippetObj = new WebSnippetCollection();
            $pattern = '~(?><(p|span|div)\b[^>]*+>(?>\s++|&nbsp;)*</\1>|<br/?+>|&nbsp;|\s++)+$~i';
           // $weburl = preg_replace($pattern,'', $weburl);
            $weburl= rtrim($weburl);
            $weburl=  str_replace(' ','', $weburl);
            $NewSnippetObj->Weburl= trim($weburl);
            $NewSnippetObj->WebImage = $webImage;
            $NewSnippetObj->WebLink = trim($SnippetObj['provider_url']);
            $NewSnippetObj->Webdescription = $SnippetObj['description'];
            $NewSnippetObj->WebTitle = trim($SnippetObj['title']);
            if(isset($createdDate) && !empty($createdDate)){
                $NewSnippetObj->CreatedOn = new MongoDate(strtotime(date($createdDate, time())));
            }else{
                $NewSnippetObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            }
            
            if ($NewSnippetObj->save()) {
                
                $returnValue = $NewSnippetObj->_id;
            }
            
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("WebSnippetCollection:saveNewWebSnippet::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
 /**
     * @author Haribabu
     * @param type snippet object
     * @method TO GET websnippet details and check web url exist or not
     * @return object type id value
     */   
public function CheckWebUrlExist($weburl) {
        try {
            $returnValue = 'failure';
            $weburl=trim($weburl);
            
            $criteria = new EMongoCriteria;
            
            $weburl=str_replace(' ','', $weburl);
            $criteria->addCond('Weburl', '==',$weburl);
            $SnippetObj=WebSnippetCollection::model()->find($criteria);
           
             if(count($SnippetObj)>0){
                 $returnValue=$SnippetObj;
             }
          
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("WebSnippetCollection:CheckWebUrlExist::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }

   /**
     * @author Haribabu
     * @param type snippet object
     * @method TO get websnippet details 
     * @return object type id value
     */  
public function getWebSnippetDetailsById($WebSnippetId) {
        try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoID($WebSnippetId));
            $SnippetObj=WebSnippetCollection::model()->find($criteria);
            if(is_object($SnippetObj)){
                $returnValue=$SnippetObj;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("WebSnippetCollection:getWebSnippetDetailsById::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
    }
    
 public function updateWebSnippetDetails($snippetId,$SnippetObj){
        try {
            $returnValue = 'failure';
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
           
            $mongoModifier->addModifier('WebImage', 'set', $SnippetObj['thumbnail_url']); 
            $mongoModifier->addModifier('WebLink', 'set', $SnippetObj['provider_url']); 
            $mongoModifier->addModifier('Webdescription', 'set', $SnippetObj['description']); 
            $mongoModifier->addModifier('WebTitle', 'set', $SnippetObj['title']); 
            $mongoCriteria->addCond('_id', '==',  new MongoID($snippetId)); 
            
           
           WebSnippetCollection::model()->updateAll($mongoModifier,$mongoCriteria);
           $returnValue ="success";
           return $returnValue;
        } catch (Exception $ex) {
            Yii::log("WebSnippetCollection:updateWebSnippetDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
  public function getAllWebSnippets(){   
  try {
            $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $postObj = WebSnippetCollection::model()->findAll($criteria);
            $returnValue = $postObj;
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("WebSnippetCollection:getAllWebSnippets::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
  }      
    

}
