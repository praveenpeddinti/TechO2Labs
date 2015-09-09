<?php
/*
 * Author   : Renigunta Kavya 
 * Date     : 08-09-2015
 */
class RatingDetails extends CWidget {

    public $rating_details;

    public function run() {
        $rating_details_arr = array();
        $rating_details_arr = $this->rating_details;
        if (isset($rating_details_arr) && count($rating_details_arr) > 0) {
            $this->allRatingsGridView($rating_details_arr);
        }
    }

    public function allRatingsGridView($rating_arr = array()) {
        $data_array = array();
        if (isset($rating_arr) && count($rating_arr) > 0) {
            $all_profile_count = 0;
            $all_profile_count = count($rating_arr);
            $response = new CArrayDataProvider($rating_arr, array(
                'keyField' => 'employee_id',
                'totalItemCount' => $all_profile_count,
//                'sort' => array(
//                    'attributes' => array(
//                        'employee_id'
//                    ),
//                    'defaultOrder' => array(
//                        'employee_id' => CSort::SORT_ASC, //default sort value
//                    ),
//                ),
                'pagination' => array(
                    'pageSize' => 5,
                ),
            ));
            if (isset($response) && count($response) > 0) {
                $data_array['rating_details_arr'] = $response;
            }
        }
        $this->render('RatingDetailsView', $data_array);
    }

}

?>