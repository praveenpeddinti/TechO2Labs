<?php
/**
 * This collection is used to create a new group
 * @author Praneeth
 */
class TrackBrowseDetailsCollection extends EMongoDocument {

   
    public $SecurityToken;
    public $ClickType;
    public $UserId;
    public $IP;
    public $FeatureType;
    public $AccessFrom;
    public $AccessType;
    public $TimeStamp;
    public $Date;
    public $Time;
    public $Hour;
    public $Location;
    public $OSType;
    public $OSVersion;
    public $Address;
    public $Country;
    public $State;
    public $Browser;
    public $Device;
    public $GroupId;
    public $CreatedOn;
    public $SegmentId=0;
    public $NetworkId=1;

    public function getCollectionName() {
        return 'TrackBrowseDetailsCollection';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function indexes() {
        return array(
            'index_SecurityToken' => array(
                'key' => array(
                    'SecurityToken' => EMongoCriteria::SORT_ASC
                ),
            )
        );
    }
    
    public function attributeNames() {
        return array(
            '_id' => '_id',
            'SecurityToken' => 'SecurityToken',
            'Address' => 'Address',
            'Country' => 'Country',
            'State' => 'State',
            'Browser' => 'Browser',
            'IP' => 'IP',
            'OSVersion' => 'OSVersion',
            'OSType' => 'OSType',
            'Location' => 'Location',
            'Hour' => 'Hour',
            'Time' => 'Time',
            'Date' => 'Date',
            'TimeStamp' => 'TimeStamp',
            'AccessType' => 'AccessType',
            'AccessFrom' => 'AccessFrom',
            'UserId' => 'UserId',
            'FeatureType' => 'FeatureType',
            'ClickType' => 'ClickType',
            'Device'=>'Device',
            'GroupId'=>'GroupId',
            'CreatedOn'=>'CreatedOn',
            'SegmentId'=>'SegmentId',
            'NetworkId'=>'NetworkId'
        );
    }
/**
     * @author suresh reddy
     * @param type $sessionObj
     * @method TO 
     * @return object type id value
     */
public function saveBrowseDetails($sessionObj,$clientIP) {
        try {
             $address_array=  explode(',',$sessionObj->Address);
            $country="";
            $state="";
            if(isset($address_array[0]) && $address_array[0]!=""){
              $country =$address_array[0];
            }
            if(isset($address_array[1]) && $address_array[1]!=""){
              $state =$address_array[1];  //changed to array index to 1 since need to the state in Us
            }
            
            $groupId="";
            $returnValue = 'failure';
            $sesObj = new TrackBrowseDetailsCollection();
            $sesObj->SecurityToken = $sessionObj->SecurityToken;
            $sesObj->Address = $sessionObj->Address;
            $sesObj->TimeStamp = gmdate("Y-m-d H:i:s", time());
            $sesObj->AccessType = $sessionObj->AccessType;
            $sesObj->ClickType = "";
            $sesObj->IP = $clientIP;
            $sesObj->Date = gmdate("Y-m-d", time());
            $sesObj->Time = gmdate("H:i:s", time());
            $sesObj->Hour = gmdate("H", time());
            $sesObj->Location = $sessionObj->Location;
            $sesObj->OSType = $sessionObj->OSType;
            $sesObj->OSVersion = $sessionObj->OSVersion;
            $sesObj->Browser = $sessionObj->Browser;
            $sesObj->Address = $sessionObj->Address;
            $sesObj->Country = $country;
            $sesObj->State = $state;
            $sesObj->AccessFrom = $sessionObj->AccessFrom;
            $sesObj->Device = $sessionObj->Device;
            $sesObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
            $sesObj->SegmentId = isset($sessionObj->SegmentId)?(int)$sessionObj->SegmentId:0;
            $sesObj->NetworkId = (int)Yii::app()->params['NetWorkId'];
            if($sessionObj->GroupId == 0){
                $sesObj->GroupId = (int)$sessionObj->GroupId;
            }
            else{
                $sesObj->GroupId = new MongoID($sessionObj->GroupId);
            }
            
            if ($sesObj->save()) {
                $sesObj->NetworkId =(int) Yii::app()->params['NetWorkId'];
                $val = urlencode(CJSON::encode($sesObj));
                CommonUtility::executecurl(Yii::app()->params['ProphecyURL'], $val,"Usability");
               $returnValue = 'success';  
            }
            return $returnValue;
        } catch (Exception $ex) {
        Yii::log("TrackBrowseDetailsCollection:saveBrowseDetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function GetAnalyticsReportsBasedonDateRange($startDate,$endDate,$type, $segmentId=0){
      try {   
         $finalArray = array();
            $finalArray['Year'] = "";
            $labelsArray = array();
             $dateFormat =  CommonUtility::getDateFormat();

            $timezone = Yii::app()->session['timezone'];
//            $startDate = CommonUtility::convert_time_zone(strtotime($startDate), "UTC", $timezone);
//            $endDate = CommonUtility::convert_time_zone(strtotime($endDate), "UTC", $timezone);
            $startDate1 = date('Y-m-d', strtotime($startDate));
            $endDate1 = date('Y-m-d', strtotime($endDate));
            $dateFrom = new DateTime($startDate1);
            $dateTo = new DateTime($endDate1);
            $interval = date_diff($dateFrom, $dateTo);
            $diff = $interval->format('%R%a');
            $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate1, $endDate1);

             if ($diff > 365) {
                  
                   $modeType='$year';
                   $datemode='YEAR';
                   
               } elseif ($diff > 92 && $diff <= 365) {
                   
                   $modeType='$month';
                   $datemode='MONTH';
                   
               } elseif ($diff > 31 && $diff <= 92) {
                  $modeType='$week';
                  $datemode='WEEK';
                   
               } elseif ($diff <= 31) {
                  
                   $modeType='$dayOfMonth';
                   $datemode='DATE';
               }


            $match = array("Date" => array('$gte' => $startDate1, '$lte' => $endDate1));
            if($segmentId!=0){
                $match = array("SegmentId"=>array('$in'=>array((int)$segmentId)),"Date" => array('$gte' => $startDate1, '$lte' => $endDate1));
            }
            $id=array(
                        'week' => array("$modeType" => '$CreatedOn'),
                        'Device' => array("Device" => '$Device'),                   
                    );
            $collection = "TrackBrowseDetailsCollection";
            $nresults = CommonUtility::getAnalyticsData($collection, $match, $modeType,$id);
            foreach ($nresults as $value) {

                if (!in_array($value['_id']['Device']['Device'], $labelsArray)) {
                    array_push($labelsArray, $value['_id']['Device']['Device']);
                }
            }
            $labelsArray = array_unique($labelsArray);

            foreach ($nresults as $key => $value) {
                $existingArray = array();

                $keyV = array_search($value['_id']['Device']['Device'], $labelsArray);


                for ($k = 0; $k < count($labelsArray); $k++) {
                    if ($k == $keyV) {
                        $existingArray[$keyV] = $existingArray[$keyV] + $value['count'];
                    } else {
                        $existingArray[$k] = 0;
                    }
                }

                if (!array_key_exists($value['_id']['week'], $finalArray)) {
                    $finalArray[$value['_id']['week']] = $existingArray;
                } else {
                    $finalArray[$value['_id']['week']][$keyV] = $value['count'];
                }

                ksort($finalArray[$value['_id']['week']]);
            }
            $finalArray['Year'] = $labelsArray;

            $resArr = array();
            $resArr['Year'] = $labelsArray;
            foreach ($valid_times as $key => $value) {

                $startDate = date('Y-m-d', strtotime($valid_times["$key"]));
                $startDate_tz = CommonUtility::convert_date_zone(strtotime($startDate . " 18:29:00"), date_default_timezone_get(), "UTC");

                $dateArray = array();
                if (!array_key_exists($key, $finalArray)) {
                    for ($j = 0; $j < count($labelsArray); $j++) {
                        array_push($dateArray, 0);
                    }
                } else {
                    $dateArray = $finalArray[$key];
                }

                if ($type == 'xls') {

                    //  $resArr[date($dateFormat, $startDate_tz)] = $dateArray;
                    if ($diff > 365) {
                        $resArr["" . $key . ""] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["" . date('M Y', $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    }
                } else {

                    if ($diff > 365) {
                        $resArr["'" . $key . "'"] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["'" . date('M Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    }
                }
            }
            return $resArr;
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetAnalyticsReportsBasedonDateRange::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


    public function GetBrowserUsabilityBasedOnDateRangeAndType($startDate,$endDate,$type, $segmentId=0){
      try {   
          
          $finalArray = array();
            $finalArray['Year'] = "";
            $labelsArray = array();
             $dateFormat =  CommonUtility::getDateFormat();

            $timezone = Yii::app()->session['timezone'];
//            $startDate = CommonUtility::convert_time_zone(strtotime($startDate), "UTC", $timezone);
//            $endDate = CommonUtility::convert_time_zone(strtotime($endDate), "UTC", $timezone);
            $startDate1 = date('Y-m-d', strtotime($startDate));
            $endDate1 = date('Y-m-d', strtotime($endDate));
            $dateFrom = new DateTime($startDate1);
            $dateTo = new DateTime($endDate1);
            $interval = date_diff($dateFrom, $dateTo);
            $diff = $interval->format('%R%a');
            $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate1, $endDate1);

             if ($diff > 365) {
                  
                   $modeType='$year';
                   $datemode='YEAR';
                   
               } elseif ($diff > 92 && $diff <= 365) {
                   
                   $modeType='$month';
                   $datemode='MONTH';
                   
               } elseif ($diff > 31 && $diff <= 92) {
                  $modeType='$week';
                  $datemode='WEEK';
                   
               } elseif ($diff <= 31) {
                  
                   $modeType='$dayOfMonth';
                   $datemode='DATE';
               }


            $match = array("Date" => array('$gte' => $startDate1, '$lte' => $endDate1));
            if($segmentId!=0){
                $match = array("SegmentId"=>array('$in'=>array((int)$segmentId)),"Date" => array('$gte' => $startDate1, '$lte' => $endDate1));
            }
            $id=array(
                        'week' => array("$modeType" => '$CreatedOn'),
                        'Browser' => array("Browser" => '$Browser'),  
               
                    );
            $collection = "TrackBrowseDetailsCollection";
            $nresults = CommonUtility::getAnalyticsData($collection, $match, $modeType,$id);
            if(!empty($nresults) && $nresults!=""){
                foreach ($nresults as $value) {

                    if (!in_array($value['_id']['Browser']['Browser'], $labelsArray)) {
                        array_push($labelsArray, $value['_id']['Browser']['Browser']);
                    }
                }
            }
            $labelsArray = array_unique($labelsArray);

            foreach ($nresults as $key => $value) {
                $existingArray = array();

                $keyV = array_search($value['_id']['Browser']['Browser'], $labelsArray);


                for ($k = 0; $k < count($labelsArray); $k++) {
                    if ($k == $keyV) {
                        $existingArray[$keyV] = $existingArray[$keyV] + $value['count'];
                    } else {
                        $existingArray[$k] = 0;
                    }
                }

                if (!array_key_exists($value['_id']['week'], $finalArray)) {
                    $finalArray[$value['_id']['week']] = $existingArray;
                } else {
                    $finalArray[$value['_id']['week']][$keyV] = $value['count'];
                }

                ksort($finalArray[$value['_id']['week']]);
            }
            $finalArray['Year'] = $labelsArray;

            $resArr = array();
            $resArr['Year'] = $labelsArray;
            foreach ($valid_times as $key => $value) {

                $startDate = date('Y-m-d', strtotime($valid_times["$key"]));
                $startDate_tz = CommonUtility::convert_date_zone(strtotime($startDate . " 18:29:00"), date_default_timezone_get(), "UTC");

                $dateArray = array();
                if (!array_key_exists($key, $finalArray)) {
                    for ($j = 0; $j < count($labelsArray); $j++) {
                        array_push($dateArray, 0);
                    }
                } else {
                    $dateArray = $finalArray[$key];
                }

                if ($type == 'xls') {

                    //  $resArr[date($dateFormat, $startDate_tz)] = $dateArray;
                    if ($diff > 365) {
                        $resArr["" . $key . ""] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["'" . date('M Y', $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    }
                } else {

                    if ($diff > 365) {
                        $resArr["'" . $key . "'"] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["'" . date('M Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    }
                }
            }
            return $resArr;
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetBrowserUsabilityBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public function GetDevicePieChartUsabilityBasedOnDateRangeAndType($startDate,$endDate, $segmentId=0){
      try {
          
          $finalArray = array();
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            $c = TrackBrowseDetailsCollection::model()->getCollection();
            $match = array("Date" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("SegmentId"=>array('$in'=>array((int)$segmentId)),"Date" => array('$gte' => $startDate, '$lte' => $endDate));
            }
             $results = $c->aggregate(
                    array('$match' => $match
                        ), array('$group' => array(
                    '_id' => array(
                            'Device'=>'$Device',
                            
                        ),
                        "count" => array('$sum' => 1),
                )), array(
                '$sort' => array('count' => 1)
                    )
            );
             if(isset($results['result']) && !empty($results['result'])){
                $i = 0;
                foreach ($results['result'] as $value) {
                     if($value['_id']['Device'] !="" && $value['_id']['Device'] !="undefined" ){
                        $finalArray[$i]['device'] = $value['_id']['Device'];
                        $finalArray[$i]['count'] = $value['count'];
                        $i++;
                     }
                }
             }
            return $finalArray;  
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetDevicePieChartUsabilityBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public function GetBrowserUsabilityPieChartBasedOnDateRangeAndType($startDate,$endDate, $segmentId=0){
      try {
           $finalArray = array();
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            $c = TrackBrowseDetailsCollection::model()->getCollection();
            $match = array("Date" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("SegmentId"=>array('$in'=>array((int)$segmentId)),"Date" => array('$gte' => $startDate, '$lte' => $endDate));
            }
             $results = $c->aggregate(
                    array('$match' => $match
                        ), array('$group' => array(
                    '_id' => array(
                            'Browser'=>'$Browser',
                            
                        ),
                        "count" => array('$sum' => 1),
                )), array(
                '$sort' => array('count' => 1)
                    )
            );
             if(isset($results['result']) && !empty($results['result'])){
                $i = 0;
                foreach ($results['result'] as $value) {
                     if($value['_id']['Browser'] !="" && $value['_id']['Browser'] !="undefined" ){
                        $finalArray[$i]['browser'] = $value['_id']['Browser'];
                        $finalArray[$i]['count'] = $value['count'];
                        $i++;
                     }
                }
             }
            return $finalArray;          
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetBrowserUsabilityPieChartBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function GetLocationLineGraphReportsBasedonDateRange($startDate,$endDate,$type, $segmentId=0){
      try {   
          $finalArray = array();
            $finalArray['Year'] = "";
            $labelsArray = array();
             $dateFormat =  CommonUtility::getDateFormat();

            $timezone = Yii::app()->session['timezone'];
//            $startDate = CommonUtility::convert_time_zone(strtotime($startDate), "UTC", $timezone);
//            $endDate = CommonUtility::convert_time_zone(strtotime($endDate), "UTC", $timezone);
            $startDate1 = date('Y-m-d', strtotime($startDate));
            $endDate1 = date('Y-m-d', strtotime($endDate));
            $dateFrom = new DateTime($startDate1);
            $dateTo = new DateTime($endDate1);
            $interval = date_diff($dateFrom, $dateTo);
            $diff = $interval->format('%R%a');
            $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate1, $endDate1);

             if ($diff > 365) {
                  
                   $modeType='$year';
                   $datemode='YEAR';
                   
               } elseif ($diff > 92 && $diff <= 365) {
                   
                   $modeType='$month';
                   $datemode='MONTH';
                   
               } elseif ($diff > 31 && $diff <= 92) {
                  $modeType='$week';
                  $datemode='WEEK';
                   
               } elseif ($diff <= 31) {
                  
                   $modeType='$dayOfMonth';
                   $datemode='DATE';
               }


            $match = array("Date" => array('$gte' => $startDate1, '$lte' => $endDate1));
            if($segmentId!=0){
                $match = array("SegmentId"=>array('$in'=>array((int)$segmentId)),"Date" => array('$gte' => $startDate1, '$lte' => $endDate1));
            }
            $id=array(
                        'week' => array("$modeType" => '$CreatedOn'),
                        'State' => array("State" => '$State'),  
                    );
            $collection = "TrackBrowseDetailsCollection";
            $nresults = CommonUtility::getAnalyticsData($collection, $match, $modeType,$id);
            if(!empty($nresults) && $nresults!=""){
                foreach ($nresults as $value) {

                    if (!in_array($value['_id']['State']['State'], $labelsArray)) {
                        array_push($labelsArray, $value['_id']['State']['State']);
                    }
                }
            }
            $labelsArray = array_unique($labelsArray);

            foreach ($nresults as $key => $value) {
                $existingArray = array();

                $keyV = array_search($value['_id']['State']['State'], $labelsArray);


                for ($k = 0; $k < count($labelsArray); $k++) {
                    if ($k == $keyV) {
                        $existingArray[$keyV] = $existingArray[$keyV] + $value['count'];
                    } else {
                        $existingArray[$k] = 0;
                    }
                }

                if (!array_key_exists($value['_id']['week'], $finalArray)) {
                    $finalArray[$value['_id']['week']] = $existingArray;
                } else {
                    $finalArray[$value['_id']['week']][$keyV] = $value['count'];
                }

                ksort($finalArray[$value['_id']['week']]);
            }
            $finalArray['Year'] = $labelsArray;

            $resArr = array();
            $resArr['Year'] = $labelsArray;
            foreach ($valid_times as $key => $value) {

                $startDate = date('Y-m-d', strtotime($valid_times["$key"]));
                $startDate_tz = CommonUtility::convert_date_zone(strtotime($startDate . " 18:29:00"), date_default_timezone_get(), "UTC");

                $dateArray = array();
                if (!array_key_exists($key, $finalArray)) {
                    for ($j = 0; $j < count($labelsArray); $j++) {
                        array_push($dateArray, 0);
                    }
                } else {
                    $dateArray = $finalArray[$key];
                }

                if ($type == 'xls') {

                    //  $resArr[date($dateFormat, $startDate_tz)] = $dateArray;
                    if ($diff > 365) {
                        $resArr["" . $key . ""] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["" . date('M Y', $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    }
                } else {

                    if ($diff > 365) {
                        $resArr["'" . $key . "'"] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["'" . date('M Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    }
                }
            }
            return $resArr;
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetLocationLineGraphReportsBasedonDateRange::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function GetLocationPieChartUsabilityBasedOnDateRangeAndType($startDate,$endDate, $segmentId=0){
      try {
           $finalArray = array();
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            $c = TrackBrowseDetailsCollection::model()->getCollection();
            $match = array("Date" => array('$gte' => $startDate, '$lte' => $endDate));
            if($segmentId!=0){
                $match = array("SegmentId"=>array('$in'=>array((int)$segmentId)),"Date" => array('$gte' => $startDate, '$lte' => $endDate));
            }
             $results = $c->aggregate(
                    array('$match' => $match
                        ), array('$group' => array(
                    '_id' => array(
                            'State'=>'$State',
                            
                        ),
                        "count" => array('$sum' => 1),
                )), array(
                '$sort' => array('count' => 1)
                    )
            );
             if(isset($results['result']) && !empty($results['result'])){
                $i = 0;
                foreach ($results['result'] as $value) {
                     if($value['_id']['State'] !="" && $value['_id']['State'] !="undefined" ){
                        $finalArray[$i]['locations'] = $value['_id']['State'];
                        $finalArray[$i]['count'] = $value['count'];
                        $i++;
                     }
                }
             }
            return $finalArray; 
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetLocationPieChartUsabilityBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function isGroupComebackUser($groupId, $SecurityToken)
    {
        try
        {
            $return='success';
            $mongoCriteria = new EMongoCriteria;            
            $mongoCriteria->addCond('GroupId', '==', new MongoID($groupId));
            $mongoCriteria->addCond('SecurityToken', '==', $SecurityToken);
            
          
            $sessionDetails = TrackBrowseDetailsCollection::model()->find($mongoCriteria);
            if(isset($sessionDetails)){
                 $return ='failure';
            }
            else{
                $return='success';
            }
            return $return;
            
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:isGroupComebackUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function GetGroupDeviceUsabilityAnalyticsReportsBasedonDateRange($groupId,$startDate,$endDate,$type){
      try {   
          
           $finalArray = array();
            $finalArray['Year'] = "";
            $labelsArray = array();
             $dateFormat =  CommonUtility::getDateFormat();

            $timezone = Yii::app()->session['timezone'];
//            $startDate = CommonUtility::convert_time_zone(strtotime($startDate), "UTC", $timezone);
//            $endDate = CommonUtility::convert_time_zone(strtotime($endDate), "UTC", $timezone);
            $startDate1 = date('Y-m-d', strtotime($startDate));
            $endDate1 = date('Y-m-d', strtotime($endDate));
            $dateFrom = new DateTime($startDate1);
            $dateTo = new DateTime($endDate1);
            $interval = date_diff($dateFrom, $dateTo);
            $diff = $interval->format('%R%a');
            $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate1, $endDate1);

             if ($diff > 365) {
                  
                   $modeType='$year';
                   $datemode='YEAR';
                   
               } elseif ($diff > 92 && $diff <= 365) {
                   
                   $modeType='$month';
                   $datemode='MONTH';
                   
               } elseif ($diff > 31 && $diff <= 92) {
                  $modeType='$week';
                  $datemode='WEEK';
                   
               } elseif ($diff <= 31) {
                  
                   $modeType='$dayOfMonth';
                   $datemode='DATE';
               }


            $match = array("GroupId"=>new MongoId($groupId),"Date" => array('$gte' => $startDate1, '$lte' => $endDate1));
            $id=array(
                        'week' => array("$modeType" => '$CreatedOn'),
                        'Device' => array("Device" => '$Device'),  
                    );
            $collection = "TrackBrowseDetailsCollection";
            $nresults = CommonUtility::getAnalyticsData($collection, $match, $modeType,$id);
            foreach ($nresults as $value) {

                if (!in_array($value['_id']['Device']['Device'], $labelsArray)) {
                    array_push($labelsArray, $value['_id']['Device']['Device']);
                }
            }
            $labelsArray = array_unique($labelsArray);

            foreach ($nresults as $key => $value) {
                $existingArray = array();

                $keyV = array_search($value['_id']['Device']['Device'], $labelsArray);


                for ($k = 0; $k < count($labelsArray); $k++) {
                    if ($k == $keyV) {
                        $existingArray[$keyV] = $existingArray[$keyV] + $value['count'];
                    } else {
                        $existingArray[$k] = 0;
                    }
                }

                if (!array_key_exists($value['_id']['week'], $finalArray)) {
                    $finalArray[$value['_id']['week']] = $existingArray;
                } else {
                    $finalArray[$value['_id']['week']][$keyV] = $value['count'];
                }

                ksort($finalArray[$value['_id']['week']]);
            }
            $finalArray['Year'] = $labelsArray;

            $resArr = array();
            $resArr['Year'] = $labelsArray;
            foreach ($valid_times as $key => $value) {

                $startDate = date('Y-m-d', strtotime($valid_times["$key"]));
                $startDate_tz = CommonUtility::convert_date_zone(strtotime($startDate . " 18:29:00"), date_default_timezone_get(), "UTC");

                $dateArray = array();
                if (!array_key_exists($key, $finalArray)) {
                    for ($j = 0; $j < count($labelsArray); $j++) {
                        array_push($dateArray, 0);
                    }
                } else {
                    $dateArray = $finalArray[$key];
                }

                if ($type == 'xls') {

                    //  $resArr[date($dateFormat, $startDate_tz)] = $dateArray;
                    if ($diff > 365) {
                        $resArr["" . $key . ""] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["" . date('M Y', $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["'" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    }
                } else {

                    if ($diff > 365) {
                        $resArr["'" . $key . "'"] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["'" . date('M Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    }
                }
            }
            return $resArr;
          
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetGroupDeviceUsabilityAnalyticsReportsBasedonDateRange::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function GetGroupDevicePieChartUsabilityBasedOnDateRangeAndType($groupId,$startDate,$endDate){
      try {
            $finalArray = array();
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            $c = TrackBrowseDetailsCollection::model()->getCollection();
             $results = $c->aggregate(
                    array('$match' => array("GroupId"=>new MongoId($groupId),"Date" => array('$gte' => $startDate, '$lte' => $endDate))), array('$group' => array(
                    '_id' => array(
                            'Device'=>'$Device',
                            
                        ),
                        "count" => array('$sum' => 1),
                )), array(
                '$sort' => array('count' => 1)
                    )
            );

            $i = 0;
            foreach ($results['result'] as $value) {
                $finalArray[$i]['device'] = $value['_id']['Device'];
                $finalArray[$i]['count'] = $value['count'];
                $i++;
            }
            return $finalArray;
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetGroupDevicePieChartUsabilityBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function GetGroupLocationUsabilityAnalyticsReportsBasedonDateRange($groupId,$startDate,$endDate,$type){
      try {   
          
          
            $finalArray = array();
            $finalArray['Year'] = "";
            $labelsArray = array();
             $dateFormat =  CommonUtility::getDateFormat();

            $timezone = Yii::app()->session['timezone'];
//            $startDate = CommonUtility::convert_time_zone(strtotime($startDate), "UTC", $timezone);
//            $endDate = CommonUtility::convert_time_zone(strtotime($endDate), "UTC", $timezone);
            $startDate1 = date('Y-m-d', strtotime($startDate));
            $endDate1 = date('Y-m-d', strtotime($endDate));
            $dateFrom = new DateTime($startDate1);
            $dateTo = new DateTime($endDate1);
            $interval = date_diff($dateFrom, $dateTo);
            $diff = $interval->format('%R%a');
            $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate1, $endDate1);

             if ($diff > 365) {
                  
                   $modeType='$year';
                   $datemode='YEAR';
                   
               } elseif ($diff > 92 && $diff <= 365) {
                   
                   $modeType='$month';
                   $datemode='MONTH';
                   
               } elseif ($diff > 31 && $diff <= 92) {
                  $modeType='$week';
                  $datemode='WEEK';
                   
               } elseif ($diff <= 31) {
                  
                   $modeType='$dayOfMonth';
                   $datemode='DATE';
               }


            $match = array("GroupId"=>new MongoId($groupId),"Date" => array('$gte' => $startDate1, '$lte' => $endDate1));
            $id=array(
                        'week' => array("$modeType" => '$CreatedOn'),
                        'State' => array("State" => '$State'),  
                    );
            $collection = "TrackBrowseDetailsCollection";
            $nresults = CommonUtility::getAnalyticsData($collection, $match, $modeType,$id);
            foreach ($nresults as $value) {

                if (!in_array($value['_id']['State']['State'], $labelsArray)) {
                    array_push($labelsArray, $value['_id']['State']['State']);
                }
            }
            $labelsArray = array_unique($labelsArray);

            foreach ($nresults as $key => $value) {
                $existingArray = array();

                $keyV = array_search($value['_id']['State']['State'], $labelsArray);


                for ($k = 0; $k < count($labelsArray); $k++) {
                    if ($k == $keyV) {
                        $existingArray[$keyV] = $existingArray[$keyV] + $value['count'];
                    } else {
                        $existingArray[$k] = 0;
                    }
                }

                if (!array_key_exists($value['_id']['week'], $finalArray)) {
                    $finalArray[$value['_id']['week']] = $existingArray;
                } else {
                    $finalArray[$value['_id']['week']][$keyV] = $value['count'];
                }

                ksort($finalArray[$value['_id']['week']]);
            }
            $finalArray['Year'] = $labelsArray;

            $resArr = array();
            $resArr['Year'] = $labelsArray;
            foreach ($valid_times as $key => $value) {

                $startDate = date('Y-m-d', strtotime($valid_times["$key"]));
                $startDate_tz = CommonUtility::convert_date_zone(strtotime($startDate . " 18:29:00"), date_default_timezone_get(), "UTC");

                $dateArray = array();
                if (!array_key_exists($key, $finalArray)) {
                    for ($j = 0; $j < count($labelsArray); $j++) {
                        array_push($dateArray, 0);
                    }
                } else {
                    $dateArray = $finalArray[$key];
                }

                if ($type == 'xls') {

                    //  $resArr[date($dateFormat, $startDate_tz)] = $dateArray;
                    if ($diff > 365) {
                        $resArr["" . $key . ""] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["" . date('M Y', $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    }
                } else {

                    if ($diff > 365) {
                        $resArr["'" . $key . "'"] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["'" . date('M Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    }
                }
            }
            return $resArr;
          
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetGroupLocationUsabilityAnalyticsReportsBasedonDateRange::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function GetGroupLocationPieChartUsabilityBasedOnDateRangeAndType($groupId,$startDate,$endDate){
      try {
            $finalArray = array();
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            $c = TrackBrowseDetailsCollection::model()->getCollection();
             $results = $c->aggregate(
                    array('$match' => array("GroupId"=>new MongoId($groupId),"Date" => array('$gte' => $startDate, '$lte' => $endDate))), array('$group' => array(
                    '_id' => array(
                            'State'=>'$State',
                            
                        ),
                        "count" => array('$sum' => 1),
                )), array(
                '$sort' => array('count' => 1)
                    )
            );

            $i = 0;
             foreach ($results['result'] as $value) {
             if($value['_id']['State'] !="" && $value['_id']['State'] !="undefined" ){
                     $finalArray[$i]['locations'] = $value['_id']['State'];
                     $finalArray[$i]['count'] = $value['count'];
                     $i++;
                }
             }
            return $finalArray;
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetGroupLocationPieChartUsabilityBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function GetGroupBrowserUsabilityAnalyticsReportsBasedonDateRange($groupId,$startDate,$endDate,$type){
      try {   
          
          
           $finalArray = array();
            $finalArray['Year'] = "";
            $labelsArray = array();
             $dateFormat =  CommonUtility::getDateFormat();

            $timezone = Yii::app()->session['timezone'];
//            $startDate = CommonUtility::convert_time_zone(strtotime($startDate), "UTC", $timezone);
//            $endDate = CommonUtility::convert_time_zone(strtotime($endDate), "UTC", $timezone);
            $startDate1 = date('Y-m-d', strtotime($startDate));
            $endDate1 = date('Y-m-d', strtotime($endDate));
            $dateFrom = new DateTime($startDate1);
            $dateTo = new DateTime($endDate1);
            $interval = date_diff($dateFrom, $dateTo);
            $diff = $interval->format('%R%a');
            $valid_times = CommonUtility::GetIntervalsBetweenTwoDates($startDate1, $endDate1);

             if ($diff > 365) {
                  
                   $modeType='$year';
                   $datemode='YEAR';
                   
               } elseif ($diff > 92 && $diff <= 365) {
                   
                   $modeType='$month';
                   $datemode='MONTH';
                   
               } elseif ($diff > 31 && $diff <= 92) {
                  $modeType='$week';
                  $datemode='WEEK';
                   
               } elseif ($diff <= 31) {
                  
                   $modeType='$dayOfMonth';
                   $datemode='DATE';
               }


            $match = array("GroupId"=>new MongoId($groupId),"Date" => array('$gte' => $startDate1, '$lte' => $endDate1));
            $id=array(
                        'week' => array("$modeType" => '$CreatedOn'),
                        'Browser' => array("Browser" => '$Browser'),  
                    );
            $collection = "TrackBrowseDetailsCollection";
            $nresults = CommonUtility::getAnalyticsData($collection, $match, $modeType,$id);
            foreach ($nresults as $value) {

                if (!in_array($value['_id']['Browser']['Browser'], $labelsArray)) {
                    array_push($labelsArray, $value['_id']['Browser']['Browser']);
                }
            }
            $labelsArray = array_unique($labelsArray);

            foreach ($nresults as $key => $value) {
                $existingArray = array();

                $keyV = array_search($value['_id']['Browser']['Browser'], $labelsArray);


                for ($k = 0; $k < count($labelsArray); $k++) {
                    if ($k == $keyV) {
                        $existingArray[$keyV] = $existingArray[$keyV] + $value['count'];
                    } else {
                        $existingArray[$k] = 0;
                    }
                }

                if (!array_key_exists($value['_id']['week'], $finalArray)) {
                    $finalArray[$value['_id']['week']] = $existingArray;
                } else {
                    $finalArray[$value['_id']['week']][$keyV] = $value['count'];
                }

                ksort($finalArray[$value['_id']['week']]);
            }
            $finalArray['Year'] = $labelsArray;

            $resArr = array();
            $resArr['Year'] = $labelsArray;
            foreach ($valid_times as $key => $value) {

                $startDate = date('Y-m-d', strtotime($valid_times["$key"]));
                $startDate_tz = CommonUtility::convert_date_zone(strtotime($startDate . " 18:29:00"), date_default_timezone_get(), "UTC");

                $dateArray = array();
                if (!array_key_exists($key, $finalArray)) {
                    for ($j = 0; $j < count($labelsArray); $j++) {
                        array_push($dateArray, 0);
                    }
                } else {
                    $dateArray = $finalArray[$key];
                }

                if ($type == 'xls') {

                    //  $resArr[date($dateFormat, $startDate_tz)] = $dateArray;
                    if ($diff > 365) {
                        $resArr["" . $key . ""] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["" . date('M Y', $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["" . date($dateFormat, $startDate_tz) . ""] = $dateArray;
                    }
                } else {

                    if ($diff > 365) {
                        $resArr["'" . $key . "'"] = $dateArray;
                    } elseif ($diff > 92 && $diff <= 365) {
                        $resArr["'" . date('M Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff > 31 && $diff <= 92) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    } elseif ($diff <= 31) {
                        $resArr["'" . date('m/d/Y', $startDate_tz) . "'"] = $dateArray;
                    }
                }
            }
            return $resArr;
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetGroupBrowserUsabilityAnalyticsReportsBasedonDateRange::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public function GetGroupBrowserPieChartUsabilityBasedOnDateRangeAndType($groupId,$startDate,$endDate){
      try {
            $finalArray = array();
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            $c = TrackBrowseDetailsCollection::model()->getCollection();
             $results = $c->aggregate(
                    array('$match' => array("GroupId"=>new MongoId($groupId),"Date" => array('$gte' => $startDate, '$lte' => $endDate))), array('$group' => array(
                    '_id' => array(
                            'Browser'=>'$Browser',
                            
                        ),
                        "count" => array('$sum' => 1),
                )), array(
                '$sort' => array('count' => 1)
                    )
            );

            $i = 0;
             foreach ($results['result'] as $value) {
            
                     $finalArray[$i]['browser'] = $value['_id']['Browser'];
                     $finalArray[$i]['count'] = $value['count'];
                     $i++;
             }
            return $finalArray;
        } catch (Exception $ex) {
            Yii::log("TrackBrowseDetailsCollection:GetGroupBrowserPieChartUsabilityBasedOnDateRangeAndType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
       public function GetAllPosts(){
        try {       
            $returnValue='failure';
            
            $criteria = new EMongoCriteria;
            $criteria->setSelect(array('TimeStamp'=>true));
            $allposts = TrackBrowseDetailsCollection::model()->findAll($criteria); 
            return $allposts;

        } catch (Exception $ex) {
           Yii::log("TrackBrowseDetailsCollection:GetAllPosts::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
      public function UpdateAllPostsCreatedDate($postId,$createdDate){
        try {       
          
           $returnValue = 'failure';
            $criteria = new EMongoCriteria;
            $criteria->addCond('_id', '==', new MongoId($postId));
            $mongoModifier = new EMongoModifier;  
            $mongoModifier->addModifier('CreatedOn', 'set', new MongoDate(strtotime($createdDate)));
            $returnValue=TrackBrowseDetailsCollection::model()->updateAll($mongoModifier,$criteria);
           
        } catch (Exception $ex) {
           Yii::log("TrackBrowseDetailsCollection:UpdateAllPostsCreatedDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
     }
