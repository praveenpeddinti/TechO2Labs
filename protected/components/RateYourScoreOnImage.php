<?php

class RateYourScoreOnImage extends CWidget {

    
    public $employee_id = 0;

    public function run() {
        $data = array();
        $all_rating_images_arr = array();
        $previous_rating_images = array();
        $imageid_rate_data = array();
        $employee_id = $this->employee_id;
        $all_rating_images_arr = $this->doRatingOnImages();
        $previous_rating_images = $this->getRatingOnImagesOfPerson($employee_id);
        if(isset($previous_rating_images) && count($previous_rating_images) > 0){
            foreach($previous_rating_images as $pri){
                $imageid_rate_data[$pri['image_id']] = $pri['rating'];
             
            }
        }
        if (isset($all_rating_images_arr) && count($all_rating_images_arr) > 0) {
            $data['all_rating_images_data'] = $all_rating_images_arr;
            
        }
        $data['previous_rating_images'] = $imageid_rate_data;
        
        $this->render('RatingOnImage', $data);
    }
    
    public function doRatingOnImages(){
        $finalList = array();
        $totalRecordsArr = array();
        $totalRecords = 0;
        $startCount = 0;
        $endCount = 0;
        $sign = 0;
        $limit = Yii::app()->params['configValues']['limitRecords'];

        $all_images_data = array();

        $totalRecordsArr = ServiceFactory::dashboardServiceProvider()->totalCounOnImages();


        $totalRecords = isset($totalRecordsArr['totalImages']) ? $totalRecordsArr['totalImages'] : $totalRecords;

        $criteria = new CDbCriteria();

        $all_images_data = ServiceFactory::dashboardServiceProvider()->getAllUploadedImages($startCount, $limit);

        $pages = new CPagination($totalRecords);

        $pages->setPageSize($limit);

        $sign = $pages->offset;

        $endCount = ($pages->offset + $pages->limit <= $totalRecords ? $pages->offset + $pages->limit : $totalRecords);


        if ($sign > 0) {
            $all_images_data = ServiceFactory::dashboardServiceProvider()->getAllUploadedImages($sign, $limit);

            $finalList['all_rating_images'] = $all_images_data;
        } else {
            $finalList['all_rating_images'] = $all_images_data;
        }
        $finalList['pages'] = $pages;
        return $finalList;
    }
    
    public function getRatingOnImagesOfPerson($employee_id){
        $response = array();
        $rating_person_details = array();
        $rating_person_details = ServiceFactory::dashboardServiceProvider()->getPersonRatingOnImages($employee_id);
        if(isset($rating_person_details) && count($rating_person_details) > 0){
           $response = $rating_person_details; 
        }
        return $response;
    }
}

?>