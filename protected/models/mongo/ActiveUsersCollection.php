<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActiveUsersCollection extends EMongoDocument {
    public $_id;
    public $ReportDate;
    public $Users=0;
    
    public $CreatedOn;
    public $GroupId;
    public $Is_Group=0;//0: thorughout the site, 1: For group Active users, 2: Group Comback user
    public $CreatedDate;
    public $SegmentId=0;
    
    public function getCollectionName() {
        return 'ActiveUsersCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

   public function indexes() {
        return array(
            'index_CreatedOn' => array(
                'key' => array(
                    'CreatedOn' => EMongoCriteria::SORT_DESC,
                ),
            ),
        );
    }

    public function attributeNames() {
        return array(
            '_id' => '_id',
            'ReportDate' => 'EndDate',
            'Users'=>'Users',
            'CreatedOn' => 'CreatedOn',
            'GroupId'=>'GroupId',
            'Is_Group'=>'Is_Group',
            'CreatedDate'=>'CreatedDate',
            'SegmentId'=>'SegmentId'
        );
    }


    public function saveActiveUsersData($reportDate,$users, $segmentId=0) {
        try {
           
            $returnValue = 'failure';
            $ActiveUsersObj = new ActiveUsersCollection();
            $ActiveUsersObj->Users = (int)$users;
            $ActiveUsersObj->ReportDate = $reportDate;
            $ActiveUsersObj->Is_Group = (int)0;
            $ActiveUsersObj->GroupId = "";
            $ActiveUsersObj->CreatedDate=$reportDate;
            $ActiveUsersObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $ActiveUsersObj->SegmentId=(int)$segmentId;
            if ($ActiveUsersObj->insert()) {
                
                $returnValue = $ActiveUsersObj->_id;
            }
            
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ActiveUsersCollection:saveActiveUsersData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function GetActiveUsersReportsBasedonDateRange($startDate,$endDate,$groupId,$isGroup){
         $returnValue='failure';
              $dateFormat =  CommonUtility::getDateFormat();
        try {
//            
            $finalArray = array();
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            
            $c = GoogleAnalyticsCollection::model()->getCollection();
            $keys = array("CreatedDate" => 1, "Pageviews" => 1, "Pagevisits" => 1);
            $initial = array("count" => 0);
            $reduce = "function (obj, prev) { prev.count++; }";
            if($groupId==0){
                 $condition = array('condition' => array("Is_Group"=>(int)$isGroup,"CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)));
            }else{
                 $condition = array('condition' => array("GroupId"=>new MongoID($groupId),"Is_Group"=>(int)$isGroup,"CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)));
            }
               


            $g = $c->group($keys, $initial, $reduce, $condition);

            $arr = $g['retval'];
            
           
            foreach ($arr as $value) {
               // $value['CreatedDate'] = date('m/d/Y', strtotime($value['CreatedDate']));
                $finalArray[$value['CreatedDate']] = array($value['Pageviews'], $value['Pagevisits']);
            }
           ksort($finalArray);
           
            if (count($finalArray) == 0) {
                $startDate = date('m/d/Y', strtotime($startDate));
                $endDate = date('m/d/Y', strtotime($endDate));
                $finalArray[$startDate] = array(0, 0);
                $finalArray[$endDate] = array(0, 0);
            }
           
            
            
            
            
             $start_date =$startDate;
           $end_date = $endDate;
           $returnArray = array();
          while (strtotime($start_date) <= strtotime($end_date)) {
               if (array_key_exists($start_date, $finalArray)) {
                     $returnArray["new Date('".date($dateFormat, strtotime($start_date))."')"]=$finalArray[$start_date];
               }else{
                    $returnArray["new Date('".date($dateFormat, strtotime($start_date))."')"]=array(0,0);
               }

               $start_date = date ('Y-m-d', strtotime("+1 day", strtotime($start_date)));
               
	}
        
        
         
            
//            
////            
//             $start_date = date('m/d/Y', strtotime($startDate));
//           $end_date = date('m/d/Y', strtotime($endDate));
//           $returnArray = array();
//          while (strtotime($start_date) <= strtotime($end_date)) {
//		
//		
//               if (array_key_exists($start_date, $finalArray)) {
//                   
//                    $returnArray[$start_date]=$finalArray[$start_date];
//               }else{
//                   
//                   $returnArray[$start_date]=array(0,0);
//               }
//               $start_date = date ("m/d/Y", strtotime("+1 day", strtotime($start_date)));
//	}
            
            
             return $returnArray;
            
            
            
        } catch (Exception $ex) {
            Yii::log("ActiveUsersCollection:GetActiveUsersReportsBasedonDateRange::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
            
    }
      public function saveGroupWiseActiveUsersAnalyticsData($reportDate,$users,$groupId) {
        try {
            $returnValue = 'failure';
            $ActiveUsersObj = new ActiveUsersCollection();
            $ActiveUsersObj->Users = (int)$users;
            $ActiveUsersObj->ReportDate = $reportDate;
            $ActiveUsersObj->Is_Group = (int)1;
            $ActiveUsersObj->GroupId = new MongoID($groupId);
            $ActiveUsersObj->CreatedDate=$reportDate;
            $ActiveUsersObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            if ($ActiveUsersObj->insert()) {
                
                $returnValue = $ActiveUsersObj->_id;
            }

            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ActiveUsersCollection:saveGroupWiseActiveUsersAnalyticsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
        public function CheckActiveUsersDataExistByDate($reportDate, $segmentId=0) {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;
            $criteria->addCond('ReportDate', '==', trim($reportDate));
            $criteria->addCond('SegmentId', '==', $segmentId);
            $ActiveUsersArray = ActiveUsersCollection::model()->findAll($criteria);
            if (is_array($ActiveUsersArray) && count($ActiveUsersArray)>0) {
                $returnValue = $ActiveUsersArray;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ActiveUsersCollection:CheckActiveUsersDataExistByDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function updateActiveUsersDataExistByDate($reportDate,$users, $segmentId=0){
         $returnValue='failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Users', 'set', (int)$users); 
            $mongoCriteria->addCond('ReportDate', '==', $reportDate);
            $mongoCriteria->addCond('SegmentId', '==', (int)$segmentId);    
            ActiveUsersCollection::model()->updateAll($mongoModifier,$mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("ActiveUsersCollection:updateActiveUsersDataExistByDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
            
    }
    
       public function saveGroupWiseCombackUsersAnalyticsData($reportDate,$users,$groupId) {
        try {
            $returnValue = 'failure';
            $ActiveUsersObj = new ActiveUsersCollection();
            $ActiveUsersObj->Users = (int)$users;
            $ActiveUsersObj->ReportDate = $reportDate;
            $ActiveUsersObj->Is_Group = (int)2;
            $ActiveUsersObj->GroupId = new MongoID($groupId);
            $ActiveUsersObj->CreatedDate=$reportDate;
            $ActiveUsersObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            if ($ActiveUsersObj->insert()) {
                
                $returnValue = $ActiveUsersObj->_id;
            }

            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("ActiveUsersCollection:saveGroupWiseCombackUsersAnalyticsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    

    
    

}
