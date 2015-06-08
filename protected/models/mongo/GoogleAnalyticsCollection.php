<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GoogleAnalyticsCollection extends EMongoDocument {
    public $_id;
    public $ReportDate;
    public $Pageviews=0;
    public $Pagevisits=0;
    public $DayOfHour=0;
    public $AvgTimeOnsite;
    public $CreatedOn;
    public $GroupId;
    public $Is_Group=0;
    public $CreatedDate;
    public $NetworkId=1;
    
    
    public function getCollectionName() {
        return 'GoogleAnalyticsCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

   public function indexes() {
        return array(
            'index_Pageviews' => array(
                'key' => array(
                    'Pageviews' => EMongoCriteria::SORT_DESC,
                ),
            ),
            'index_Pagevisits' => array(
                'key' => array(
                    'Pagevisits' => EMongoCriteria::SORT_DESC,
                ),
            ),
        );
    }

    public function attributeNames() {
        return array(
            '_id' => '_id',
            'ReportDate' => 'EndDate',
            'Pageviews'=>'Pageviews',
            'Pagevisits'=>'Pagevisits',
            'AvgTimeOnsite'=>'AvgTimeOnsite',
            'DayOfHour'=>'DayOfHour',
            'CreatedOn' => 'CreatedOn',
            'GroupId'=>'GroupId',
            'Is_Group'=>'Is_Group',
            'CreatedDate'=>'CreatedDate',
            'NetworkId'=>'NetworkId'
            
        );
    }


    public function saveGoogleAnalyticsData($reportDate,$pageviews,$pagevisits,$AvgTimeOnSite,$DayOfHour) {
        try {
            $returnValue = 'failure';
            $AnalyticsObj = new GoogleAnalyticsCollection();
            $AnalyticsObj->Pageviews = $pageviews;
            $AnalyticsObj->Pagevisits=$pagevisits;
            $AnalyticsObj->AvgTimeOnsite = $AvgTimeOnSite;
            $AnalyticsObj->ReportDate = $reportDate;
            $AnalyticsObj->DayOfHour = $DayOfHour;
            $AnalyticsObj->Is_Group = (int)0;
            $AnalyticsObj->GroupId = "";
            $AnalyticsObj->CreatedDate=$reportDate;
            $AnalyticsObj->NetworkId = (int)Yii::app()->params['NetWorkId'];
            
            
            $AnalyticsObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            if ($AnalyticsObj->insert()) {
                $returnValue = $AnalyticsObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GoogleAnalyticsCollection:saveGoogleAnalyticsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
     public function CheckGoogleAnalyticsDataExistByDate() {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;
            $criteria->addCond('CreatedDate', '==', new MongoDate(strtotime(date('Y-m-d'))));
            $googleAnalyticsArray = GoogleAnalyticsCollection::model()->findAll($criteria);

            if (is_array($googleAnalyticsArray)) {
                $returnValue = $googleAnalyticsArray;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GoogleAnalyticsCollection:CheckGoogleAnalyticsDataExistByDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function updateGoogleAnalyticsDataExistByDate($reportDate,$pageviews,$pagevisits,$AvgTimeOnSite,$DayOfHour){
         $returnValue='failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Pageviews', 'set', $pageviews); 
            $mongoModifier->addModifier('Pagevisits', 'set', $pagevisits); 
            $mongoModifier->addModifier('AvgTimeOnsite', 'set', $AvgTimeOnSite);
            $mongoModifier->addModifier('ReportDate', 'set', $reportDate);
            $mongoModifier->addModifier('DayOfHour', 'set', $DayOfHour);
            $mongoModifier->addModifier('CreatedDate', 'set', date('Y-m-d'));
            //$AnalyticsObj->DayOfHour = $DayOfHour;
            $mongoCriteria->addCond('CreatedOn', '==', new MongoDate(strtotime(date('Y-m-d')))); 
            GoogleAnalyticsCollection::model()->updateAll($mongoModifier,$mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("GoogleAnalyticsCollection:updateGoogleAnalyticsDataExistByDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
            
    }
     public function GetAnalyticsReportsBasedonDateRange($startDate,$endDate,$groupId,$isGroup,$type){
         $returnValue='failure';
              $dateFormat =  CommonUtility::getDateFormat();
        try {
//            
            $resArray = array();
        $dateFormat = CommonUtility::getDateFormat();
        $finalArray = array();
        // $startDate=date('Y-m-d',strtotime($startDate));
        // $endDate=date('Y-m-d',strtotime($endDate));
        $timezone = Yii::app()->session['timezone'];
//        $startDate = CommonUtility::convert_time_zone(strtotime($startDate), "UTC", $timezone);
//        $endDate = CommonUtility::convert_time_zone(strtotime($endDate), "UTC", $timezone);
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));
        $dateFrom = new DateTime($startDate1);
        $dateTo = new DateTime($endDate1);
        $interval = date_diff($dateFrom, $dateTo);
        $diff = $interval->format('%R%a');
        $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate, $endDate);


        if ($diff > 365) {

            $modeType = '$year';
            $datemode = 'YEAR';
        } elseif ($diff > 92 && $diff <= 365) {

            $modeType = '$month';
            $datemode = 'MONTH';
        } elseif ($diff > 31 && $diff <= 92) {
            $modeType = '$week';
            $datemode = 'WEEK';
        } elseif ($diff <= 31) {

            $modeType = '$dayOfMonth';
            $datemode = 'DATE';
        }
        $Resultsid = array(
            'week' => array("$modeType" => '$CreatedOn'),
            'Pageviews' => array("Pageviews" => '$Pageviews'),
            'Pagevisits' => array("Pagevisits" => '$Pagevisits'),
        );

        if ($groupId == 0) {

            $match = array("Pageviews" => array('$ne' => (int) 0), "Pagevisits" => array('$ne' => (int) 0), "Is_Group" => (int) $isGroup,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
            );
        } else {

            $match = array("Pageviews" => array('$ne' => (int) 0), "Pagevisits" => array('$ne' => (int) 0), "GroupId" => new MongoID($groupId), "Is_Group" => (int) $isGroup,
                "CreatedDate" => array('$gte' => $startDate, '$lte' => $endDate)
            );
        }


            $collection = "GoogleAnalyticsCollection";
            $nresults = CommonUtility::getAnalyticsData($collection, $match, $modeType, $Resultsid);


        foreach ($nresults as $value) {
            $existingArray = array();

            if (array_key_exists($value['_id']['week'], $valid_times)) {
                
                $existingArray[0] = $value['_id']['Pageviews']['Pageviews'];
                $existingArray[1] = $value['_id']['Pagevisits']['Pagevisits'];
                $finalArray[$value['_id']['week']] = $existingArray;
            }
        }

        foreach ($valid_times as $key => $value) {
            $startDate = date('Y-m-d', strtotime($valid_times["$key"]));
            $startDate_tz = CommonUtility::convert_date_zone(strtotime($startDate . " 18:29:00"), date_default_timezone_get(), "UTC");
            $dateArray = array();
            if (is_array($finalArray[$key])) {

                for ($k = 0; $k < 2; $k++) {
                    if (!array_key_exists($k, $finalArray[$key])) {

                        $finalArray[$key][$k] = 0;
                    }
                }
            } else {

                for ($k = 0; $k < 2; $k++) {

                    $finalArray[$key][$k] = 0;
                }
            }

            ksort($finalArray[$key]);


            if ($type == 'report') {

                //  $resArr[date($dateFormat, $startDate_tz)] = $dateArray;
                if ($diff > 365) {
                    $resArray["" . $key . ""] = $finalArray[$key];
                } elseif ($diff > 92 && $diff <= 365) {
                    $resArray["" . date('M Y', $startDate_tz) . ""] = $finalArray[$key];
                } elseif ($diff > 31 && $diff <= 92) {
                    $resArray["" . date($dateFormat, $startDate_tz) . ""] = $finalArray[$key];
                } elseif ($diff <= 31) {
                    $resArray["" . date($dateFormat, $startDate_tz) . ""] = $finalArray[$key];
                }
            } else {

                if ($diff > 365) {
                    $resArray["'" . $key . "'"] = $finalArray[$key];
                } elseif ($diff > 92 && $diff <= 365) {
                    $resArray["'" . date('M Y', $startDate_tz) . "'"] = $finalArray[$key];
                } elseif ($diff > 31 && $diff <= 92) {
                    $resArray["'" . date($dateFormat, $startDate_tz) . "'"] = $finalArray[$key];
                } elseif ($diff <= 31) {
                    $resArray["'" . date($dateFormat, $startDate_tz) . "'"] = $finalArray[$key];
                }
            }
        }

       
return $resArray;
          
            
        } catch (Exception $ex) {
            Yii::log("GoogleAnalyticsCollection:GetAnalyticsReportsBasedonDateRange::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
            
    }
      public function saveGroupWiseGoogleAnalyticsData($reportDate,$pageviews,$pagevisits,$AvgTimeOnSite,$DayOfHour,$groupId,$networkId=0) {
        try {
            $returnValue = 'failure';
            $AnalyticsObj = new GoogleAnalyticsCollection();
            $AnalyticsObj->Pageviews = $pageviews;
            $AnalyticsObj->Pagevisits=$pagevisits;
            $AnalyticsObj->AvgTimeOnsite = $AvgTimeOnSite;
            $AnalyticsObj->ReportDate = $reportDate;
            $AnalyticsObj->DayOfHour = $DayOfHour;
            $AnalyticsObj->Is_Group = (int)1;
            $AnalyticsObj->GroupId = new MongoID($groupId);
            $AnalyticsObj->CreatedDate=$reportDate;
             $AnalyticsObj->NetworkId=$networkId;
            $AnalyticsObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            if ($AnalyticsObj->insert()) {
                $returnValue = $AnalyticsObj->_id;
            }
            return $returnValue;
        } catch (Exception $ex) {
           Yii::log("GoogleAnalyticsCollection:saveGroupWiseGoogleAnalyticsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function getTrafficGoogleAnalyticsdata($startDate,$endDate) {
        try{
          $finalArray = array();
            $startDate=date('Y-m-d',strtotime($startDate));
            $endDate=date('Y-m-d',strtotime($endDate));
     
           $c =  GoogleAnalyticsCollection::model()->getCollection();
           $keys = array("CreatedDate" => 1,"Pageviews"=>1,"Pagevisits"=>1);
           $initial = array("count" => 0);
           $reduce = "function (obj, prev) { prev.count++; }";
           $condition = array('condition' => array("CreatedDate"=>array('$gte' => $startDate,'$lte' => $endDate)));

         $g = $c->group($keys, $initial, $reduce,$condition);

        $arr = $g['retval'];

       
        foreach ($arr as $value) {
          
            $value['CreatedDate'] = date('m/d/Y', strtotime($value['CreatedDate']));
            // $value['CreatedDate'] = str_replace("-","/",$value['CreatedDate']);
           
            $finalArray[$value['CreatedDate']]=array($value['Pageviews'],$value['Pagevisits']);
      }
      } catch (Exception $ex) {
            Yii::log("GoogleAnalyticsCollection:getTrafficGoogleAnalyticsdata::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }

      
    
    }
    
  
       public function CheckGoogleAnalyticsPastDataExistByDate($date) {
        try {
            $returnValue = 'failure';

            $criteria = new EMongoCriteria;
            $criteria->addCond('CreatedDate', '==', date('Y-m-d',strtotime($date)));
            $criteria->addCond('Is_Group', '==', (int)0);
            $googleAnalyticsArray = GoogleAnalyticsCollection::model()->findAll($criteria);

            if (is_array($googleAnalyticsArray)) {
                $returnValue = $googleAnalyticsArray;
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GoogleAnalyticsCollection:CheckGoogleAnalyticsPastDataExistByDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function updateGoogleAnalyticsPastDataExistByDate($reportDate,$pageviews,$pagevisits,$AvgTimeOnSite,$DayOfHour){
         $returnValue='failure';
        try {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            $mongoModifier->addModifier('Pageviews', 'set', $pageviews); 
            $mongoModifier->addModifier('Pagevisits', 'set', $pagevisits); 
            $mongoModifier->addModifier('AvgTimeOnsite', 'set', $AvgTimeOnSite);
            $mongoModifier->addModifier('ReportDate', 'set', $reportDate);
            $mongoModifier->addModifier('DayOfHour', 'set', $DayOfHour);
            $mongoModifier->addModifier('CreatedDate', 'set', date('Y-m-d',  strtotime($reportDate)));
            //$AnalyticsObj->DayOfHour = $DayOfHour;
            $mongoCriteria->addCond('CreatedDate', '==', date('Y-m-d',strtotime($reportDate)));
            $mongoCriteria->addCond('Is_Group', '==', (int)0);
            GoogleAnalyticsCollection::model()->updateAll($mongoModifier,$mongoCriteria);
        } catch (Exception $ex) {
            Yii::log("GoogleAnalyticsCollection:updateGoogleAnalyticsPastDataExistByDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            return $returnValue;
        }
            
    }
       public function saveGoogleAnalyticsPastData($reportDate,$pageviews,$pagevisits,$AvgTimeOnSite,$DayOfHour) {
        try {
            $returnValue = 'failure';
            $AnalyticsObj = new GoogleAnalyticsCollection();
            $AnalyticsObj->Pageviews = $pageviews;
            $AnalyticsObj->Pagevisits=$pagevisits;
            $AnalyticsObj->AvgTimeOnsite = $AvgTimeOnSite;
            $AnalyticsObj->ReportDate = $reportDate;
            $AnalyticsObj->DayOfHour = $DayOfHour;
            $AnalyticsObj->Is_Group = (int)0;
            $AnalyticsObj->GroupId = "";
            $AnalyticsObj->CreatedDate=$reportDate;
            
            
          $AnalyticsObj->CreatedOn = new MongoDate(strtotime($reportDate));
            if ($AnalyticsObj->insert()) {
                $returnValue = $AnalyticsObj->_id;
            }
          
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("GoogleAnalyticsCollection:saveGoogleAnalyticsPastData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }  
    
    

}
