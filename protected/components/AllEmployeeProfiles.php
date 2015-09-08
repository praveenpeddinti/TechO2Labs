<?php

class AllEmployeeProfiles extends CWidget {

    public $all_employee_profiles;

    public function run() {
        $all_emp_profiles_arr = array();
        $all_emp_profiles_arr = $this->all_employee_profiles;
        if (isset($all_emp_profiles_arr) && count($all_emp_profiles_arr) > 0) {
            $this->allProfilesGridView($all_emp_profiles_arr);
        }
    }

    public function allProfilesGridView($profile_arr = array()) {
        $data = array();
        if (isset($profile_arr) && count($profile_arr) > 0) {
            $all_profile_count = 0;
            $all_profile_count = count($profile_arr);
            $response = new CArrayDataProvider($profile_arr, array(
                'keyField' => 'employee_designation',
                'totalItemCount' => $all_profile_count,
                'sort' => array(
                    'attributes' => array(
                        'firstname', 'middlename', 'lastname'
                    ),
                    'defaultOrder' => array(
                        'firstname' => CSort::SORT_ASC, //default sort value
                    ),
                ),
                'pagination' => array(
                    'pageSize' => 2,
                ),
            ));
            if (isset($response) && count($response) > 0) {
                $data['all_emp_profiles_arr'] = $response;
            }
        }
        $this->render('AllEmployeeProfilesView', $data);
    }

}

?>