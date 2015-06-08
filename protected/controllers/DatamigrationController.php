<?php

/**
 * Developer Name: Suresh Reddy
 * DataMigration class is enable rest calls enable 
 * all RestAPI Call here to migrate data 
 */
class DatamigrationController extends ERestController {

    /**
     * Developer Suresh Reddy & Sagar
     * on 8 th Jan 2014
     * save user Registration 
     * parameter is object of user
     */
    public function actionUser($args = null) {
        $message = "";
        $failedUsers = "";
        try {


            $userRegistrationInfo = CJSON::decode($_REQUEST['data'], true);
            //$userRegistrationInfo = $jsonData['userRegistrationInfo'];
            $existingUsers = array();
            $insertedUsersCount = 0;
            $existingUsersCount = 0;
            $totalUsers = sizeof($userRegistrationInfo);
            if ($totalUsers > 0) {
                $i = 0;
                foreach ($userRegistrationInfo as $usrInfo) {
                    try {
                        if (isset($usrInfo['email'])) {
                            $userexist = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($usrInfo['email']);
                            if (count($userexist) > 0) {
                                $message = "Users already exist with the given Email Please  try with another  Email Address";
                                $existingUsersCount++;
                                array_push($existingUsers, $usrInfo['email']);
                            } else {
                                $uerRegistrationArray = array();
                                $UserRegistrationForm = new UserRegistrationForm();
                                foreach ($UserRegistrationForm->attributes as $key => $value) {

                                    if (isset($usrInfo[$key])) {
                                        $uerRegistrationArray[$key] = $usrInfo[$key];
                                    }
                                }
                                $uerRegistrationArray["registredDate"] = $usrInfo["registredDate"];
                                $uerRegistrationArray["lastLoginDate"] = $usrInfo["lastLoginDate"];
                                $uerRegistrationArray["migratedUserId"] = $usrInfo["migratedUserId"];
                                $customfieldsArray = array();
                                $CustomForm = new CustomForm();
                                foreach ($CustomForm->attributes as $key => $value) {
                                    if (isset($usrInfo[$key])) {
                                        $uerRegistrationArray[$key] = $usrInfo[$key];
                                    }
                                }
                                $Save_userInUserCollection = ServiceFactory::getSkiptaUserServiceInstance()->SaveUserCollection($uerRegistrationArray, $customfieldsArray);
                                if ($Save_userInUserCollection != 'error') {
                                    $message = "User Registered Successfully";
                                    $insertedUsersCount++;
                                } else {
                                    $message = "User registration failed";
                                    $failedUsers = $failedUsers . "," . $usrInfo['email'];
                                }
                            }
                        } else {
                            $message = "User email not found";
                        }
                    } catch (Exception $ex) {
                        error_log("Exception Occurred in DatamigrationController->actionUser==". $ex->getMessage());
             //           echo "==exception==" . $usrInfo['email'];
                        Yii::log("DatamigrationController:actionUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                    }
                }
            } else {
                $message = "Please send atleast one user information";
            }
            if ($insertedUsersCount > 0) {
                $message = "Inserted " . $insertedUsersCount . " user(s). existing users count  " . $existingUsersCount;
            }
            echo $message . " Failed Users : " . $failedUsers;
        } catch (Exception $ex) {
            error_log("Exception Occurred in DatamigrationController->actionUser==". $ex->getMessage());
            Yii::log("DatamigrationController:actionUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUserdetails() {
        try {
            // Initializing variables with default values...
            $result = array();
            $filterValue = 'a';
            $searchText = 'a';
            $startLimit = 1;
            $pageLength = 10;
            $data = ServiceFactory::getSkiptaPostServiceInstance()->getUserProfile($filterValue, $searchText, $startLimit, $pageLength);
            $totalUsers["totalCount"] = ServiceFactory::getSkiptaPostServiceInstance()->getUserProfileCount($filterValue, $searchText);
            // preparing the resultant array for rendering purpose...
            $result = array("data" => $data, "total" => $totalUsers, "status" => 'success');
            echo CJSON::encode($data);
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionUserdetails::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * Developer Suresh Reddy 
     * on 21 th Jan 2014
     * method helpful for  user to user folllowing 
     * parameter is a  object of userEmail , Followers Email's of User
     */
    public function actionUserFollowing() {
        try {
            $message = "";
            $userFollowers = CJSON::decode($_REQUEST['data'], true);
            $email = $userFollowers['UserEmail'];
            $groupFollowOn = $userFollowers['FollowOn'];
            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($email);

            if (isset($UserObj->Email)) {
                $UserIdofUser = $UserObj->UserId;
                $followersEmail = $userFollowers['FollowingEmails'];
                // $folloingEmail = $userFollowers->FollowingsEmails;
                for ($i = 0; $i < sizeof($followersEmail); $i++) {
                    // $followerObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($followersEmail[$i]);
                    $followerObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($followersEmail[$i]);
                    if (isset($followerObj->UserId)) {
                        $followerId = $followerObj->UserId;
                        ServiceFactory::getSkiptaUserServiceInstance()->followAUser($UserIdofUser, $followerId, $groupFollowOn);
                    }
                    $message = "followers saved successfully";
                }
            } else {
                $message = "User does't exist";
            }

            echo $message;
        } catch (Exception $ex) {
            error_log("Exception Occurred in DatamigrationController->actionUserFollowing==". $ex->getMessage());
            Yii::log("DatamigrationController:actionUserFollowing::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * Developer Praneeth
     * on 28 th Jan 2014
     * method helpful for  user to user folllowing 
     * parameter is a  object of userEmail , hashtags of User
     */
    public function actionUserHashtags() {
        try {
            $userHashtags = CJSON::decode($_REQUEST['data'], true);
            $email = $userHashtags['UserEmail'];

            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($email);
            if (isset($UserObj->Email)) {
                $UserIdofUser = (int) $UserObj->UserId;
                $hashtagsByUser = $userHashtags['UserHashtags'];
                if (sizeof($hashtagsByUser) > 0) {
                    $userHashtagObj = ServiceFactory::getSkiptaPostServiceInstance()->saveHashTags($UserIdofUser, $hashtagsByUser);
                    if (is_array($userHashtagObj) && sizeof($userHashtagObj) > 0) {
                        $message = "hashtags saved successfully";
                    } else {
                        $message = "hashtags already saved";
                    }
                } else {
                    $message = "hashtags doesnt exist";
                }
            }
            echo $message;
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionUserHashtags::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionUserPostSaving() {
        try {
            $userPosts = CJSON::decode($_REQUEST['data'], true);
            $email = $userPosts['UserEmail'];
            $hashtagsInPostsByUser = $userPosts['HashTags'];
            $postType = $userPosts['Type'];
            $userComments = $userPosts['Comments'];
            $postFollowedUsers = $userPosts['Followers'];
            if (is_array($userPosts['Resource']) && count($userPosts['Resource']) > 0) {
                $postObj = $userPosts['Resource'][0];
            } else {
                $postObj = $userPosts['Resource'];
            }
            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($email);
            if (isset($UserObj->Email)) {
                $UserIdofUser = $UserObj->UserId;
                $userPostModel = new NormalPostForm();
                $userPostModel->Type = $postType;
                $userPostModel->UserId = $UserIdofUser;
                $userPostModel->CreatedOn = $userPosts['CreatedOn'];
                $userPostModel->Description = $userPosts['Description'];
                if (is_array($userPosts['Resource']) && count($userPosts['Resource']) > 0) {
                    $userPostModel->Artifacts = array($postObj['Uri']);
                } else {
                    $userPostModel->Artifacts = array();
                }
                $hashTagArray = array_unique($hashtagsInPostsByUser);
                $postId = ServiceFactory::getSkiptaUserServiceInstance()->savePost($userPostModel, $hashTagArray);

                if ($postId != '') {
                    $message = "Post saved successfully";
                    if (sizeof($userPosts['Love']) > 0) {
                        foreach ($userPosts['Love'] as $lovedUser) {
                            $lovedUsersObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($lovedUser);
                            if (isset($lovedUsersObj->UserId)) {
                                $lovedId = $lovedUsersObj->UserId;
                                ServiceFactory::getSkiptaUserServiceInstance()->saveLoveToPost($postType, $postId, $lovedId);
                            }
                            $message = "loved Ids saved success";
                        }
                    }
                    if (sizeof($postFollowedUsers) > 0) {
                        for ($i = 0; $i < sizeof($postFollowedUsers); $i++) {
                            $postFollowedUsersObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($postFollowedUsers[$i]);
                            if (isset($postFollowedUsersObj->UserId)) {

                                $postFollowingId = $postFollowedUsersObj->UserId;
                                ServiceFactory::getSkiptaUserServiceInstance()->saveFollowOrUnfollowToPost($postType, $postId, $postFollowingId, 'Follow');
                            }
                            $message = "followers Ids saved success";
                        }
                    }
                    if (sizeof($userComments) > 0) {
                        foreach ($userComments as $userComment) {
                            $commentedUser = $userComment['UserEmail'];
                            $commentedUserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($commentedUser);
                            $commentedUserId = $commentedUserObj->UserId;
                            if (isset($commentedUserObj->UserId)) {
                                $commentedText = $userComment['CommentText'];
                                $createdOn = $userComment['CreatedOn'];
                                $commentbean = new CommentBean();
                                $commentbean->PostId = $postId;
                                $commentbean->CreatedOn = $createdOn;
                                $commentbean->UserId = $commentedUserId;
                                $commentbean->CommentText = $commentedText;
                                if ($postType = "Normal Post") {
                                    $Type = 1;
                                }
                                $commentbean->PostType = $Type;
                                $commentbean->Artifacts = array();
                                $postObj = ServiceFactory::getSkiptaUserServiceInstance()->saveComment($commentbean);
                                $commentbean = "";
                            }
                            $message = "Comment  saved successfully";
                        }
                    }
                    $message = "Post saved successfully";
                } else {
                    $message = "Failed to save the post";
                }
            }
            echo $message;
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionUserPostSaving::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author:Praneeth
     * @param  $userCategories 
     * Description: Used to save the categories in MySql and MongoDB databases
     * Purpose: for data migration
     */
    public function actionSaveCurbsideCategory() {
        try {
            $userCategories = CJSON::decode($_REQUEST['data'], true);
            $categoryModel = new CurbsidecategorycreationForm();
            foreach ($userCategories as $category) {
                foreach ($category as $key => $value) {
                    $categoryModel->category = $value;
                    $userObj = ServiceFactory::getSkiptaUserServiceInstance()->adminCategoryCreationService($categoryModel);
                    $message = "category saved successfully";
                }
            }
            echo $message;
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionSaveCurbsideCategory::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionCreateStore() {
        try{
            Yii::import('ext.phpexcel.XPHPExcel');
            $phpExcel = XPHPExcel::createPHPExcel();
            $objPHPExcel = PHPExcel_IOFactory::load(getcwd() . "/protected/StoreListPrecise.xls");
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
            $values = '';
            for ($row = 2; $row <= $highestRow; ++$row) {
                $values.="(";
                for ($col = 0; $col <= 9; ++$col) {
                    $values .="'" . trim(addslashes($objWorksheet->getCellByColumnAndRow($col, $row)->getValue()));
                    if ($col != 9)
                        $values .="',";
                    else
                        $values .="'";
                }
                if ($row != $highestRow) {
                    $values.="),";
                } else {
                    $values.=");";
                }
            }
            $sql = 'INSERT INTO Store (Id,DescriptiveName,Address1,Address2,City,State,PostalCode,Division,Region,District) VALUES ' . $values;
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionCreateStore::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionCreateUser() {
        try{
            Yii::import('ext.phpexcel.XPHPExcel');
        $phpExcel = XPHPExcel::createPHPExcel();
        $objPHPExcel = PHPExcel_IOFactory::load(getcwd() . "/protected/Sheet2.xls");
        $objWorksheet = $objPHPExcel->getAllSheets();

        $userCollectionModel = new UserCollection();
        $userProfileCollection = new UserProfileCollection();

// Process complete sheets
        for ($sheet = 0; $sheet < (1); $sheet++) {
            $highestRow = $objWorksheet[$sheet]->getHighestRow(); // e.g. 10
//Process Sheets Data and Persist
            for ($row = 2; $row <= $highestRow; ++$row) {

                $values = $values2 = '';
                $values = "INSERT IGNORE INTO User (UserId,FirstName,LastName,Password,Email,NetworkId,Status,RegistredDate,UserTypeId) VALUES  ";
                $values2 = "INSERT IGNORE INTO UserHierarchy (UserId,Division,Region,District,Store,Type) VALUES  ";


                $values .="('" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(0, $row)->getValue())) . "',";

                $name = explode(',', $objWorksheet[$sheet]->getCellByColumnAndRow(1, $row)->getValue());
                $values .="'" . trim(addslashes($name[0])) . "',";
                $values .="'" . trim(addslashes($name[1])) . "',";
                $values .="'d66ad5b60bcdc4f89efc9c06059ea83e',";
                $values .="'" . trim(addslashes(strtolower($name[0] . "_" . $name[1]))) . "@riteaid.com',";
                $values .="'" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(2, $row)->getValue())) . "',";
                $values .="1,";
                $values .="'" . date('Y-m-d') . "',";
                $values .="3);";



                $query = "SELECT Division,Region,District,Store,Type FROM `UserHierarchy`  where Store=" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(2, $row)->getValue())) . " limit 1";
                $command = Yii::app()->db->createCommand($query);
                $data = $command->queryRow();

                if ($data['Division'] != '') {

                    if ($data['Division'] != '0000' && $data['Region'] != '0000' && $data['District'] != '0000' && $data['Store'] != '0000') {
                        $type = 'Store Employee';
                    }
                    if ($data['Division'] != '0000' && $data['Region'] != '0000' && $data['District'] != '0000' && $data['Store'] == '0000') {
                        $type = 'District Leader';
                    }
                    if ($data['Division'] != '0000' && $data['Region'] != '0000' && $data['District'] == '0000' && $data['Store'] == '0000') {
                        $type = 'Regional Leader';
                    }
                    if ($data['Division'] != '0000' && $data['Region'] == '0000' && $data['District'] == '0000' && $data['Store'] == '0000') {
                        $type = 'Divisional Leader';
                    }
                    if ($data['Division'] == '0000' && $data['Region'] == '0000' && $data['District'] == '0000' && $data['Store'] == '0000') {
                        $type = 'Corporate';
                    }
                } else {
                    if (strtolower($name[0]) == 'eric' || strtolower($name[0]) == 'kristin') {
                        $data['Division'] = '5';
                        $data['Region'] = '5001';
                        $data['District'] = '50104';
                        $data['Store'] = '0000';
                        $type = 'District Leader';
                    } else {
                        $data['Division'] = '3';
                        $data['Region'] = '30032';
                        $data['District'] = '33216';
                        $data['Store'] = '0000';
                        $type = 'District Leader';
                    }
                }



                $values2 .="('" . $objWorksheet[$sheet]->getCellByColumnAndRow(0, $row)->getValue() . "',";
                $values2 .="'" . $data['Division'] . "',";
                $values2 .="'" . $data['Region'] . "',";
                $values2 .="'" . $data['District'] . "',";
                $values2 .="'" . $data['Store'] . "',";
                $values2 .="'" . trim(addslashes($type)) . "');";




                $sql = $values;
                $command = Yii::app()->db->createCommand($sql);
                $command->execute();

                $sql2 = $values2;
                $command2 = Yii::app()->db->createCommand($sql2);
                $command2->execute();
//     
                $userCollectionModel->UserId = $objWorksheet[$sheet]->getCellByColumnAndRow(0, $row)->getValue();
                $userCollectionModel->NetworkId = (int) $objWorksheet[$sheet]->getCellByColumnAndRow(2, $row)->getValue();
                $userCollectionModel->ProfilePicture = '/images/icons/user_noimage.png';
                $userCollectionModel->AboutMe = 'About Me';


                UserCollection::model()->saveUserCollection($userCollectionModel);
                UserProfileCollection::model()->saveUserProfileCollection('', $userCollectionModel->UserId);

                $userCollectionModel->DisplayName = trim($name[0]) . " " . trim($name[1]);
            }
        }
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionCreateUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionCreateUserTwo() {
        ini_set("memory_limit", -1);
        try {
            Yii::import('ext.phpexcel.XPHPExcel');
            $phpExcel = XPHPExcel::createPHPExcel();
            $objPHPExcel = PHPExcel_IOFactory::load("/usr/share/nginx/RiteAid/NewUserList.xls");
            $objWorksheet = $objPHPExcel->getAllSheets();
            $userCollectionModel = new UserCollection();
            $userProfileCollection = new UserProfileCollection();
// Process complete sheets
            for ($sheet = 0; $sheet < (1); $sheet++) {
                $highestRow = $objWorksheet[$sheet]->getHighestRow(); // e.g. 10
//Process Sheets Data and Persist
                for ($row = 2; $row <= $highestRow; ++$row) {
                    $values = $values2 = '';
                    $query = "SELECT * from User where UserId=" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(0, $row)->getValue()));
                    $command = Yii::app()->db->createCommand($query);
                    $data = $command->queryRow();

                    if (isset($data['UserId'])) {
                        $updateQuery = "update User set  IsDuplicate=1,Email='" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(7, $row)->getValue())) . "' where UserId=" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(0, $row)->getValue()));
                        YII::app()->db->createCommand($updateQuery)->execute();
                    } else {
                        $values = "INSERT INTO User (UserId,FirstName,LastName,Password,Email,NetworkId,Status,RegistredDate,UserTypeId,IsDuplicate) VALUES  ";
                        $values2 = "INSERT INTO UserHierarchy (UserId,Division,Region,District,Store,Type) VALUES  ";

                        $values .="('" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(0, $row)->getValue())) . "',";
                        $values .="'" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(1, $row)->getValue())) . "',";
                        $values .="'" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(2, $row)->getValue())) . "',";
                        $values .="'d66ad5b60bcdc4f89efc9c06059ea83e',";
                        $values .="'" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(7, $row)->getValue())) . "',";
                        $values .="'" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(6, $row)->getValue())) . "',";
                        $values .="1,";
                        $values .="'" . date('Y-m-d') . "',";
                        $values .="3,";
                        $values .="1);";


                        if ($objWorksheet[$sheet]->getCellByColumnAndRow(3, $row)->getValue() != '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(4, $row)->getValue() != '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(5, $row)->getValue() != '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(6, $row)->getValue() != '0000') {
                            $type = 'Store Employee';
                        }

                        if ($objWorksheet[$sheet]->getCellByColumnAndRow(3, $row)->getValue() != '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(4, $row)->getValue() != '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(5, $row)->getValue() != '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(6, $row)->getValue() == '0000') {
                            $type = 'District Leader';
                        }
                        if ($objWorksheet[$sheet]->getCellByColumnAndRow(3, $row)->getValue() != '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(4, $row)->getValue() != '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(5, $row)->getValue() == '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(6, $row)->getValue() == '0000') {
                            $type = 'Regional Leader';
                        }
                        if ($objWorksheet[$sheet]->getCellByColumnAndRow(3, $row)->getValue() != '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(4, $row)->getValue() == '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(5, $row)->getValue() == '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(6, $row)->getValue() == '0000') {
                            $type = 'Divisional Leader';
                        }
                        if ($objWorksheet[$sheet]->getCellByColumnAndRow(3, $row)->getValue() == '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(4, $row)->getValue() == '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(5, $row)->getValue() == '0000' && $objWorksheet[$sheet]->getCellByColumnAndRow(6, $row)->getValue() == '0000') {
                            $type = 'Corporate';
                        }

                        $values2 .="('" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(0, $row)->getValue())) . "',";
                        $values2 .="'" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(3, $row)->getValue())) . "',";
                        $values2 .="'" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(4, $row)->getValue())) . "',";
                        $values2 .="'" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(5, $row)->getValue())) . "',";
                        $values2 .="'" . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(6, $row)->getValue())) . "',";
                        $values2 .="'" . trim(addslashes($type)) . "');";





                        $sql = $values;
                        $command = Yii::app()->db->createCommand($sql);
                        $command->execute();

                        $sql2 = $values2;
                        $command2 = Yii::app()->db->createCommand($sql2);
                        $command2->execute();



                        $userCollectionModel->UserId = $objWorksheet[$sheet]->getCellByColumnAndRow(0, $row)->getValue();
                        $userCollectionModel->NetworkId = (int) $objWorksheet[$sheet]->getCellByColumnAndRow(6, $row)->getValue();
                        $userCollectionModel->ProfilePicture = '/images/icons/user_noimage.png';
                        $userCollectionModel->AboutMe = 'About Me';
                        $userCollectionModel->DisplayName = trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(1, $row)->getValue())) . " " . trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(2, $row)->getValue()));
                        //$userCollectionModel->uniqueHandle=trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(1, $row)->getValue()))." ".trim(addslashes($objWorksheet[$sheet]->getCellByColumnAndRow(2, $row)->getValue()));

                        UserCollection::model()->saveUserCollection($userCollectionModel);
                        UserProfileCollection::model()->saveUserProfileCollection('', $userCollectionModel->UserId);
                    }
                }
            }
        } catch (Exception $ex) {
            error_log("Exception Occurred in DatamigrationController->actionCreateUserTwo==". $ex->getMessage());
            Yii::log("DatamigrationController:actionCreateUserTwo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author:Praneeth
     * Description: Used to save the curbside posts in MongoDB databases
     * Purpose: for data migration
     */
    public function actionSaveCurbsidePost() {
        try {
            $curbsidePosts = CJSON::decode($_REQUEST['data'], true);
            $email = $curbsidePosts['UserEmail'];
            $hashtagsInCurbsidePostsByUser = $curbsidePosts['HashTags'];
            $postType = $curbsidePosts['Type'];
            $description = (string) $curbsidePosts['Subject'];
            if (is_array($hashtagsInCurbsidePostsByUser) && sizeof($hashtagsInCurbsidePostsByUser) > 0) {
                $description = CommonUtility::FindHashTagAndReplace((string) $curbsidePosts['Subject'], $hashtagsInCurbsidePostsByUser);
            }
            $subject = $description;
            $postFollowedUsers = $curbsidePosts['Followers'];
            $categoryName = $curbsidePosts["CategoryName"];
            $userComments = $curbsidePosts['Comments'];
            $categoryIdObj = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsideCategoryIdByCategoryName($categoryName);
            $categoryId = $categoryIdObj->CategoryId;
            if (is_array($curbsidePosts['Resource']) && count($curbsidePosts['Resource']) > 0) {
                $postObj = $curbsidePosts['Resource'][0];
            } else {
                $postObj = $curbsidePosts['Resource'];
            }
            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($email);
            if (isset($UserObj->Email)) {
                $UserIdofUser = $UserObj->UserId;
                $CurbsidePostModel = new CurbsidePostForm();
                $CurbsidePostModel->MigratedPostId = (string) $curbsidePosts['MigratedPostId'];
                $CurbsidePostModel->Type = $postType;
                $CurbsidePostModel->UserId = $UserIdofUser;
                $CurbsidePostModel->CreatedOn = $curbsidePosts['CreatedOn'];
                $CurbsidePostModel->NetworkId = (int) ($UserObj->NetworkId);
                $CurbsidePostModel->Subject = $subject;
                $CurbsidePostModel->Description = preg_replace('/#(\w+)/', '<span contenteditable="false" class="atwho-view-flag atwho-view-flag-#"><span class="dd-tags hashtag"><b>#$1</b></span></span>', $curbsidePosts['Description']);
                $CurbsidePostModel->CategoryId = $categoryId;
                $CurbsidePostModel->Category = $categoryId;

                if (is_array($curbsidePosts['Resource']) && count($curbsidePosts['Resource']) > 0) {
                    $postObj = $curbsidePosts['Resource'][0];
                } else {
                    $postObj = $curbsidePosts['Resource'];
                }

                if (is_array($curbsidePosts['Resource']) && count($curbsidePosts['Resource']) > 0) {
                    $CurbsidePostModel->Artifacts = array($postObj['Uri']);
                } else {
                    $CurbsidePostModel->Artifacts = array();
                }
                $Type = 1;
                $categoryType = 1;
                $CurbsidePostModel->WebUrls = '';
                $hashTagArray = array_unique($hashtagsInCurbsidePostsByUser);
                $postId = ServiceFactory::getSkiptaPostServiceInstance()->saveCurbidePost($CurbsidePostModel, $hashTagArray);
                $message = "Post saved successfully";

                $categoryType = 2;
                if ($postId != 'failure') {
                    $postId = (string) $postId;
                    $message = "Post saved successfully";
                    if (sizeof($userPosts['Love']) > 0) {
                        foreach ($userPosts['Love'] as $lovedUser) {
                            $lovedUsersObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($lovedUser['Email']);
                            if (isset($lovedUsersObj->UserId)) {
                                $lovedId = (int) ($lovedUsersObj->UserId);
                                ServiceFactory::getSkiptaPostServiceInstance()->saveLoveToPost($postType, $postId, $lovedId, $categoryType, $lovedUser['LoveOn']);
                            }
                            $message = "loved Ids saved success";
                        }
                    }
                    //  Yii::log("222222222222222g--------" , "error", "application");
                    if (sizeof($postFollowedUsers) > 0) {
                        foreach ($postFollowedUsers as $postFollowedUser) {
                            $postFollowedUsersObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($postFollowedUser['Email']);
                            if (isset($postFollowedUsersObj->UserId)) {

                                $postFollowingId = (int) ($postFollowedUsersObj->UserId);
                                ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToPost($postType, $postId, $postFollowingId, 'Follow', $categoryType, $postFollowedUser['FollowOn']);
                            }
                            $message = "followers Ids saved success";
                        }
                    }
                    //Yii::log("Exception Occurred in actionUserPostSaving--------".sizeof($userComments) , "error", "application");
                    if (sizeof($userComments) > 0) {
                        foreach ($userComments as $userComment) {

                            // Yii::log($userComment['CommentText']."1111111Exception Occurred in actionUserPostSaving--------" , "error", "application");
                            $commentedUser = $userComment['UserEmail'];
                            $commentedUserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($commentedUser);
                            $commentedUserId = (int) ($commentedUserObj->UserId);
                            if (isset($commentedUserObj->UserId)) {
                                $commentedText = $userComment['CommentText'];
                                $commentCreatedOn = $userComment['CreatedOn'];
                                // Yii::log($userComment['CommentText']."1111111Exception Occurred in actionUserPostSaving--------" , "error", "application");
                                $commentbean = new CommentBean();
                                $commentbean->PostId = $postId;
                                $commentbean->CreatedOn = strtotime(date($commentCreatedOn, time()));
                                $commentbean->UserId = $commentedUserId;
                                $commentbean->CommentText = $commentedText;

                                $commenturls = array();

                                $commentbean->WebUrls = $commenturls;
                                $commentbean->PostType = $Type;
                                $commentbean->Artifacts = array();
                                $commentbean->IsWebSnippetExist = 0;
                                $commentbean->HashTags = array();

                                $commentbean->Mentions = array();
                                $postObj = ServiceFactory::getSkiptaPostServiceInstance()->saveComment($commentbean, $normalPostModel->NetworkId, $categoryType);
                                $commentbean = "";
                            }
                            $message = "Comment  saved successfully";
                        }
                    }

                    $message = 'Post Saved Successfully';
                } else {
                    $message = 'Curbside Post Saving Fail';
                }
            } else {
                $message = "User Not available";
            }
            echo $message;
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionSaveCurbsidePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author:Praneeth
     * Description: Used to save the groups in MongoDB databases
     * Purpose: for data migration
     */
    public function actionSaveGroups() {
        try {
            $groups = CJSON::decode($_REQUEST['data'], true);
            $email = $groups['UserEmail'];
            $groupName = $groups['GroupName'];
            $groupDescription = $groups['GroupDescription'];
            $groupShortDescription = $groups['GroupShortDescription'];
            $groupCreatedOn = $groups['CreatedOn'];
            $groupProfileImage = $groups['GroupProfileImage'];
            $migratedGroupId = $groups['MigratedGroupId'];
            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($email);
            if (isset($UserObj->Email)) {
                $UserIdofUser = (int) ($UserObj->UserId);
                $newGroupModel = new GroupCreationForm();
                $newGroupModel->UserId = $UserIdofUser;
                $newGroupModel->CreatedOn = $groupCreatedOn;
                $newGroupModel->GroupName = $groupName;
                $newGroupModel->ShortDescription = $groupShortDescription;
                $newGroupModel->Description = $groupDescription;
                $newGroupModel->GroupProfileImage = $groupProfileImage;
                $newGroupModel->MigratedGroupId = $migratedGroupId;
                $postObj = ServiceFactory::getSkiptaPostServiceInstance()->createNewGroup($newGroupModel, $UserIdofUser, (int) ($UserObj->NetworkId));
            }
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionSaveGroups::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        $message = "Group saved successfully";
        echo $message;
    }

    /**
     * @author:Praneeth
     * Description: Used to save the group followers in MongoDB databases
     * Purpose: for data migration
     */
    public function actionSaveGroupsFollowers() {
        try {

            $groupsFollowers = CJSON::decode($_REQUEST['data'], true);
            $groupName = $groupsFollowers['GroupName'];
            $groupFollowers = $groupsFollowers['GroupFollowerEmails'];
            $groupFollowOn = $groupsFollowers['FollowOn'];
            $groupIdObj = ServiceFactory::getSkiptaUserServiceInstance()->getGroupIdByGroupName($groupName);
            $groupId = isset($groupIdObj->_id) ? $groupIdObj->_id : '';
            if ($groupId != '') {
                $groupFollowedUsersObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($groupFollowers);
                if (isset($groupFollowedUsersObj->UserId)) {
                    $groupFollowingId = (int) ($groupFollowedUsersObj->UserId);
                    $result = ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToGroup((string) $groupId, $groupFollowingId, 'Follow', $groupFollowOn);
                }
                $message = "followers Ids saved success";
            }
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionSaveGroupsFollowers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        $message = "followers Ids saved success";
        echo $message;
    }

    public function actionCreatePost() {
        try {
            $normalPostModel = new NormalPostForm();
            $errormessage = "";
            $userPosts = CJSON::decode($_REQUEST['data'], true);
            $obj = array();
            $hashTagArray = array();
            $atMentionArray = array();
            $SurveyQuestionOptions = array();
            $userComments = $userPosts['Comments'];
            $postFollowedUsers = $userPosts['Followers'];
            $normalPostModel->Type = (string) $userPosts['Type'];
            $normalPostModel->MigratedPostId = (string) $userPosts['MigratedPostId'];
            $description = (string) $userPosts['Description'];
            if (is_array($userPosts['HashTags']) && sizeof($userPosts['HashTags']) > 0) {
                $description = CommonUtility::FindHashTagAndReplace((string) $userPosts['Description'], $userPosts['HashTags']);
            }
            $normalPostModel->Description = $description;
            $email = (string) $userPosts['UserEmail'];
            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($email);
            $normalPostModel->UserId = (int) ($UserObj->UserId);
            $normalPostModel->NetworkId = (int) ($UserObj->NetworkId);
            $hashtagsInPostsByUser = $userPosts['HashTags'];
            $hashTagArray = array_unique($hashtagsInPostsByUser);
            $atMentionArray = array();
            $normalPostModel->Mentions = $atMentionArray;
            //$normalPostModel->Location = $userPosts['Location'];
            if (is_array($userPosts['Resource']) && count($userPosts['Resource']) > 0) {
                $postObj = $userPosts['Resource'][0];
            } else {
                $postObj = $userPosts['Resource'];
            }
            if (is_array($userPosts['Resource']) && count($userPosts['Resource']) > 0) {
                $normalPostModel->Artifacts = array($postObj['Uri']);
            } else {
                $normalPostModel->Artifacts = array();
            }
            $normalPostModel->WebUrls = $userPosts['Link'];
            $normalPostModel->CreatedOn = $userPosts['CreatedOn'];

            if (trim($userPosts['Type']) == "Event") {
                $normalPostModel->StartDate = $userPosts['StartDate'];
                $normalPostModel->EndDate = $userPosts['EndDate'];
                $normalPostModel->StartTime = $userPosts['StartTime'];
                $normalPostModel->EndTime = $userPosts['EndTime'];
                $normalPostModel->Location = $userPosts['Location'];
                $normalPostModel->Title = $userPosts['Title'];
            }
            if ($normalPostModel->Type == "Survey") {
                $normalPostModel->OptionOne = $userPosts['OptionOne'];
                $normalPostModel->OptionTwo = $userPosts['OptionTwo'];
                $normalPostModel->OptionThree = $userPosts['OptionThree'];
                $normalPostModel->OptionFour = $userPosts['OptionFour'];
                $normalPostModel->ExpiryDate = $userPosts['ExpiryDate'];
                $normalPostModel->Status = 1;
            }

            $Type = CommonUtility::sendPostType($normalPostModel->Type);
            $categoryType = 1;

            if ($userPosts['Link'] != "" && !empty($userPosts['Link'])) {
                if ($userPosts['IsLinkValidForSnippet'] != false) {
                    $text = trim(urlencode($userPosts['Link']));
                    $ext = strtolower(pathinfo($text, PATHINFO_EXTENSION));
                    if ($ext != 'pdf' && $ext != 'txt') {
//                        $header = $this->get_redirected_web_page($text);
//                        $text = $header['url'];
                        $url = "https://api.embed.ly/1/oembed?key=96677167dd4e4dd494564433fe259ff9&url=" . $text;
                        $details = file_get_contents($url);
                        if (isset($details) && !empty($details)) {
                            $decode = CJSON::decode($details);
                            $SnippetObj = ServiceFactory::getSkiptaPostServiceInstance()->SaveWebSnippet($text, $decode, $userPosts['CreatedOn']);
                        }
                    }
                }
            }
            if ($userPosts['IsAnonymous'] == 'True') {
                $normalPostModel->Type = 'Anonymous';
            }

            $postId = ServiceFactory::getSkiptaPostServiceInstance()->savePost($normalPostModel, $hashTagArray);
            $message = '';

            if ($postId != 'failure') {
                $postId = (string) $postId;

                if ($Type == 2) {
                    if (sizeof($userPosts['attendedPeoples']) > 0) {
                        $this->eventAttendees($userPosts['attendedPeoples'], "EventAttend", $postId, $categoryType, $normalPostModel->CreatedOn);
                    }
                }
                 elseif ($Type == 3) {
                        if (sizeof($userPosts['SurveyResults']) > 0) {
                            $this->submitSurvey($userPosts['SurveyResults'], $postId, $normalPostModel->NetworkId, $categoryType);
                        }
                    }
                    else {
                    if (sizeof($userPosts['Love']) > 0) {
                        $this->saveLoveToPost($Type, $postId, $categoryType, $userPosts['Love']);
                    }
                    if (sizeof($postFollowedUsers) > 0) {
                        $this->saveFollowOrUnfollowToPost($Type, $postId, 'Follow', $categoryType, $postFollowedUsers);
                    }
                    if (sizeof($userComments) > 0) {
                        $this->saveComment($userComments, $categoryType, $postId, $Type);
                    }
                }
                $message = 'Post Saved Successfully';
            } else {
                $message = 'NormalPost Saving Fail';
            }
            echo $message;
        } catch (Exception $ex) {
//            echo "NormalPost Saving Fail Exception";
            Yii::log("DatamigrationController:actionCreatePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionCreateGroupPost() {
        try {
            $groupPostModel = new GroupPostForm();
            $errormessage = "";
            $userPosts = CJSON::decode($_REQUEST['data'], true);
            $obj = array();
            $hashTagArray = array();
            $atMentionArray = array();
            $SurveyQuestionOptions = array();
            $groupPostModel->Type = trim($userPosts['Type']);
            $email = (string) $userPosts['UserEmail'];
            $groupPostModel->MigratedPostId = (string) $userPosts['MigratedPostId'];
            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($email);
            $groupPostModel->UserId = (int) ($UserObj->UserId);
            $groupPostModel->NetworkId = (int) ($UserObj->NetworkId);
            $description = (string) $userPosts['Description'];
            $groupPostModel->Description = $description;
            $postObj = array();
            if (is_array($userPosts['Resource']) && count($userPosts['Resource']) > 0) {
                $postObj = $userPosts['Resource'][0];
            } else {
                $postObj = $userPosts['Resource'];
            }
            if (is_array($userPosts['Resource']) && count($userPosts['Resource']) > 0) {
                $groupPostModel->Artifacts = array($postObj['Uri']);
            } else {
                $groupPostModel->Artifacts = array();
            }
            $groupPostModel->HashTags = (string) $userPosts['Description'];
            $groupPostModel->Mentions = array();

            $groupPostModel->Status = 1;
            $groupPostModel->IsPublic = 1;
            $userComments = $userPosts['Comments'];
            $postFollowedUsers = $userPosts['Followers'];
            $groupPostModel->CreatedOn = $userPosts['CreatedOn'];
            $groupIdObj = ServiceFactory::getSkiptaUserServiceInstance()->getGroupIdByGroupName(trim($userPosts['GroupName']));
            $groupId = isset($groupIdObj->_id) ? $groupIdObj->_id : '';
            if ($groupId != '') {
                $groupPostModel->GroupId = $groupId;
                $groupPostModel->Status = '1';
                $groupPostModel->IsPublic = '1';
                $hashTagArray = $userPosts['HashTags'];
                $groupPostModel->WebUrls = $userPosts['Link'];
                $Type = CommonUtility::sendPostType($groupPostModel->Type);
                if (trim($userPosts['Type']) == "Event") {
                    $groupPostModel->StartDate = $userPosts['StartDate'];
                    $groupPostModel->EndDate = $userPosts['EndDate'];
                    $groupPostModel->StartTime = $userPosts['StartTime'];
                    $groupPostModel->EndTime = $userPosts['EndTime'];
                    $groupPostModel->Location = $userPosts['Location'];
                    $groupPostModel->Title = $userPosts['Title'];
                }
                if ($groupPostModel->Type == "Survey") {
                    $groupPostModel->OptionOne = $userPosts['OptionOne'];
                    $groupPostModel->OptionTwo = $userPosts['OptionTwo'];
                    $groupPostModel->OptionThree = $userPosts['OptionThree'];
                    $groupPostModel->OptionFour = $userPosts['OptionFour'];
                    $groupPostModel->ExpiryDate = $userPosts['ExpiryDate'];
                    $groupPostModel->Status = 1;
                }

                $Type = CommonUtility::sendPostType($groupPostModel->Type);
                //$groupPostModel->Type = $Type;
                if ($userPosts['Link'] != "" && !empty($userPosts['Link'])) {
                    if ($userPosts['IsLinkValidForSnippet'] != false) {
                        $text = trim($userPosts['Link']);
                        $ext = strtolower(pathinfo($text, PATHINFO_EXTENSION));
                        if ($ext != 'pdf' && $ext != 'txt') {
                            //$header = $this->get_redirected_web_page($text);
                            //$text = $header['url'];
                            $url = "https://api.embed.ly/1/oembed?key=96677167dd4e4dd494564433fe259ff9&url=" . $text;
                            $details = file_get_contents($url);
                            if (isset($details) && !empty($details)) {
                                $decode = CJSON::decode($details);
                                $SnippetObj = ServiceFactory::getSkiptaPostServiceInstance()->SaveWebSnippet($text, $decode, $userPosts['CreatedOn']);
                            }
                        }
                    }
                }

                $groupPostModel->IsWebSnippetExist = !empty($userPosts['Link']) ? 1 : 0;
                $postId = ServiceFactory::getSkiptaPostServiceInstance()->saveGroupPost($groupPostModel, $hashTagArray);
                $message = '';
                $categoryType = 3;
                if (!empty($postId) && $postId != 'failure') {
                    $postId = (string) $postId;
                    if ($Type == 2) {
                        if (sizeof($userPosts['attendedPeoples']) > 0) {
                            $this->eventAttendees($userPosts['attendedPeoples'], "EventAttend", $postId, $categoryType, $groupPostModel->CreatedOn);
                        }
                    } elseif ($Type == 3) {
                        if (sizeof($userPosts['SurveyResults']) > 0) {
                            $this->submitSurvey($userPosts['SurveyResults'], $postId, $groupPostModel->NetworkId, $categoryType);
                        }
                    } else {
                        if (sizeof($userPosts['Love']) > 0) {
                            $this->saveLoveToPost($Type, $postId, $categoryType, $userPosts['Love']);
                        }
                        if (sizeof($postFollowedUsers) > 0) {
                            $this->saveFollowOrUnfollowToPost($Type, $postId, 'Follow', $categoryType, $postFollowedUsers);
                        }
                        if (sizeof($userComments) > 0) {
                            $this->saveComment($userComments, $categoryType, $postId, $Type);
                        }
                    }

                    $message = 'Post Saved Successfully';
                } else {
                    $message = 'GroupPost Saving Fail';
                }
            } else {
                $message = 'No Group available';
            }

            echo $message;
        } catch (Exception $ex) {
            echo "GroupPost Saving Fail Exception===" . $ex->getMessage();
            Yii::log("DatamigrationController:actionCreateGroupPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function get_redirected_web_page($url) {
        try{
            $options = array(
                CURLOPT_RETURNTRANSFER => true, // return web page
                CURLOPT_HEADER => false, // don't return headers
                CURLOPT_FOLLOWLOCATION => true, // follow redirects
                CURLOPT_ENCODING => "", // handle all encodings
                CURLOPT_USERAGENT => "spider", // who am i
                CURLOPT_AUTOREFERER => true, // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 600, // timeout on connect
                CURLOPT_TIMEOUT => 600, // timeout on response
                CURLOPT_MAXREDIRS => 1000, // stop after 10 redirects
            );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);
        return $header;
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:get_redirected_web_page::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionTest() {
        try {
            $normalPostModel = new NormalPostForm();
            $errormessage = "";
            $userPosts = CJSON::decode($_REQUEST['data'], true);
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:actionTest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function submitSurvey($SurveyResults, $PostId, $NetworkId, $CategoryType) {
        try {
            foreach ($SurveyResults as $attendedUser) {
                $attendedUserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($attendedUser['UserEmail']);
                if (isset($attendedUserObj->UserId)) {
                    $UserId = (int) ($attendedUserObj->UserId);
                    $Option = $attendedUser['UserOption'];
                    $TakenDate = $attendedUser['TakenDate'];
                    ServiceFactory::getSkiptaPostServiceInstance()->submitSurvey($UserId, $PostId, $Option, $NetworkId, $CategoryType, $TakenDate);
                }
            }
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:submitSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function eventAttendees($attendedPeoples, $actionType, $postId, $categoryType, $CreatedOn) {
        try{
        foreach ($attendedPeoples as $attendedUser) {
            $attendedUserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($attendedUser['UserEmail']);
            if (isset($attendedUserObj->UserId)) {
                $attendedUserId = (int) ($attendedUserObj->UserId);
                ServiceFactory::getSkiptaPostServiceInstance()->saveOrRemoveEventAttende($postId, $attendedUserId, $actionType, $categoryType, $CreatedOn);
            }
        }
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:eventAttendees::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function saveLoveToPost($postType, $postId, $categoryType, $userPosts) {
        try{
        foreach ($userPosts as $lovedUser) {
            $lovedUsersObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($lovedUser['Email']);
            if (isset($lovedUsersObj->UserId)) {
                $lovedId = (int) ($lovedUsersObj->UserId);
                ServiceFactory::getSkiptaPostServiceInstance()->saveLoveToPost($postType, $postId, $lovedId, $categoryType, $lovedUser['LoveOn']);
            }
        }
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:saveLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function saveFollowOrUnfollowToPost($postType, $postId, $action, $categoryType, $postFollowedUsers) {
        try{
            foreach ($postFollowedUsers as $postFollowedUser) {
            $postFollowedUsersObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($postFollowedUser['Email']);
            if (isset($postFollowedUsersObj->UserId)) {
                $postFollowingId = (int) ($postFollowedUsersObj->UserId);
                ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToPost($postType, $postId, $postFollowingId, $action, $categoryType, $postFollowedUser['FollowOn']);
            }
        }
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:saveFollowOrUnfollowToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function saveComment($userComments, $categoryType, $postId, $Type) {
        try{
        foreach ($userComments as $userComment) {
            $commentedUser = $userComment['UserEmail'];
            $commentedUserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($commentedUser);
            $commentedUserId = (int) ($commentedUserObj->UserId);
            $NetworkId = (int) ($commentedUserId->NetworkId);
            if (isset($commentedUserObj->UserId)) {
                $commentedText = $userComment['CommentText'];
                $commentCreatedOn = $userComment['CreatedOn'];
                // Yii::log($userComment['CommentText']."1111111Exception Occurred in actionUserPostSaving--------" , "error", "application");
                $commentbean = new CommentBean();
                $commentbean->PostId = $postId;
                $commentbean->CreatedOn = strtotime(date($commentCreatedOn, time()));
                $commentbean->UserId = $commentedUserId;
                $commentbean->CommentText = $commentedText;

                $commenturls = array();
                if (!empty($userComment['Link'])) {
                    $commenturls[0] = $userComment['Link'];
                }
                $commentbean->WebUrls = $commenturls;
                $commentbean->PostType = $Type;
                $commentbean->Artifacts = array();
                $commentbean->IsWebSnippetExist = 0;
                $commentbean->HashTags = array();

                $commentbean->Mentions = array();
                $postObj = ServiceFactory::getSkiptaPostServiceInstance()->saveComment($commentbean, $NetworkId, $categoryType);
                $commentbean = "";
            }
            $message = "Comment  saved successfully";
        }
        } catch (Exception $ex) {
            Yii::log("DatamigrationController:saveComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionSaveActionsToPost() {
        try {

            $userPosts = CJSON::decode($_REQUEST['data'], true);
            $Type = CommonUtility::sendPostType(trim($userPosts['Type']));
            $categoryType = (int) ($userPosts['CategoryType']);
            $postId = trim($userPosts['PostId']);
            $message = ' action saving fail';
            $postObj = ServiceFactory::getSkiptaPostServiceInstance()->getPostIdByMigratedPostId($categoryType, $postId);
            $postId = (string) ($postObj->_id);
            $userComments = $userPosts['Comments'];
            $loves = $userPosts['Love'];
            $postFollowedUsers = $userPosts['Followers'];
            if ($postId != 'failure') {
                if (sizeof($loves) > 0) {
                    $this->saveLoveToPost($Type, $postId, $categoryType, $loves);
                }
                if (sizeof($postFollowedUsers) > 0) {
                    $this->saveFollowOrUnfollowToPost($Type, $postId, $actionType, $categoryType, $postFollowedUsers);
                }
                if (sizeof($userComments) > 0) {
                    $this->saveComment($userComments, $categoryType, $postId, $Type);
                }
                $message = ' action saved successfully';
            }
            echo $message;
        } catch (Exception $ex) {
            echo "Action Saving Fail Exception===actionSaveActionsToPost" . $ex->getMessage();
            Yii::log("DatamigrationController:actionSaveActionsToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionSaveNews() {
        try {
            //=======before going to start insert network data in Network table and in CuratedTopic
            $userPosts = CJSON::decode(urldecode($_REQUEST['data']), true);
            $message = "";
            $UserEmail = $userPosts['UserEmail'];
            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($UserEmail);
            if (isset($UserObj->UserId)) {
                $UserId = (int) ($UserObj->UserId);

                $network_data = ServiceFactory::getSkiptaUserServiceInstance()->getCuratorAccessTokenService(Yii::app()->params['ServerURL']);
                //$tokenStore = new SessionTokenStore();
                $CuratedDataFromDB = ServiceFactory::getSkiptaPostServiceInstance()->getAllCuratedTopicsService(0, (int) $network_data['NetworkId']);

                $curatedNewCollection = new CuratedNewsCollection();
                $curatedNewCollection->PostId = $userPosts['Id'];
                $curatedNewCollection->TopicId = (int) $CuratedDataFromDB['TopicId'];
                $curatedNewCollection->TopicName = $userPosts['TopicName'];
                $curatedNewCollection->TopicImage = $userPosts['TopicImage'];
                $curatedNewCollection->Title = $userPosts['Title'];
                $curatedNewCollection->HtmlFragment = "";
                $curatedNewCollection->Alignment = '';


                //$curatedNewCollection->Description = CommonUtility::strip_tags(array('blockquote'),$key->htmlContent);
                $curatedNewCollection->Description = $userPosts['Description'];
                $curatedNewCollection->PublisherSource = $userPosts['PublisherSource'];
                $curatedNewCollection->PublisherSourceUrl = $userPosts['PublisherSourceUrl'];
                $date = strtotime(date($userPosts['PublicationDate'], time()));
                $curatedNewCollection->PublicationDate = CommonUtility::millisecondsTOdate($date * 1000, "F j, Y, g:i A");
                $curatedNewCollection->PublicationTime = $date * 1000;
                $curatedNewCollection->CreatedDate = CommonUtility::millisecondsTOdate($date * 1000, "Y-m-d");
                $curatedNewCollection->CreatedOn = new MongoDate(strtotime(date($userPosts['CreatedOn'], time())));
                $curatedNewCollection->NetworkId = (int) 1;
                if ($userPosts['Active'] == "True") {
                    $curatedNewCollection->Released = 1;
                    $curatedNewCollection->UserId = $UserId;
                    $curatedNewCollection->Followers = array((Int) $UserId);
                } else {
                    $curatedNewCollection->UserId = 0;
                }
                $CuratedContentDataPrepared = $curatedNewCollection;
                $newSavedId = ServiceFactory::getSkiptaPostServiceInstance()->saveCuratedPost($CuratedContentDataPrepared);
                ServiceFactory::getSkiptaPostServiceInstance()->releaseNewsObjectToStream($newSavedId, $UserId);
                $message = "News saved successfully";
            } else {
                $message = "User Not available";
            }
            echo $message;
        } catch (Exception $ex) {
            echo "Action Saving Fail Exception===actionSaveNews" . $ex->getMessage();
            Yii::log("DatamigrationController:actionSaveNews::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function actionCreateGame() {
        try {
            $returnValue = '';
            $userGames = CJSON::decode($_REQUEST['data'], true);
            //$UserEmail = $userGames['UserEmail'];
            $UserEmail = Yii::app()->params['NetworkAdminEmail']; //network Admin URL
            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($UserEmail);
            if (isset($UserObj->UserId)) {
                $userId = (int) ($UserObj->UserId);
                $NetworkId = Yii::app()->params['NetWorkId'];
                $gameCollectionObj = new GameCreationForm();
                $gameCollectionObj->GameBannerImage = $userGames["GameBannerImage"];
                $gameCollectionObj->GameName = $userGames["GameName"];
                $gameCollectionObj->GameDescription = $userGames["GameDescription"];
                $gameCollectionObj->CreatedOn = $userGames["CreatedOn"];
                $gameCollectionObj->Questions = $userGames["Questions"];
                $gameCollectionObj->MigratedGameId = $userGames["GameId"];
                $gameCollectionObj->Iscreated = $userGames["CreatedOn"];
                $gameSchedules = $userGames["Schedules"];
                $gameQuestionArray = ServiceFactory::getSkiptaGameServiceInstance()->saveNewGame($gameCollectionObj, $NetworkId, $userId);
                $gameId = $gameQuestionArray['GameId'];
                if (is_array($gameQuestionArray)) {
                    if (is_array($gameSchedules) && count($gameSchedules) > 0) {
                        foreach ($gameSchedules as $gameSchedule) {
                            $scheduleId = $this->scheduleGame($gameSchedule, $gameId, $userId);
                            if ($scheduleId != 'failure') {
                                //UserAnswers
                                $userAnswers = $gameSchedule["UserAnswers"];
                                $userAnswersCount = 0;
                                if (count($userAnswers) > 0) {
                                    $userAnswersCount = $this->saveAnswers($userAnswers, $scheduleId, $gameId, $gameQuestionArray);
                                }
                                //PlayedUsers
                                $playedUsers = $gameSchedule["PlayedUsers"];
                                $playedUsersCount = 0;
                                if (count($playedUsers) > 0) {
                                    $playedUsersCount = $this->insertPlayedUsers($playedUsers, $scheduleId, $gameId, $userGames["CreatedOn"]);
                                }
                                //ResumePlayers
                                $resumedPlayers = $gameSchedule["ResumePlayers"];
                                $resumedPlayersCount = 0;
                                if (count($resumedPlayers) > 0) {
                                    $resumedPlayersCount = $this->insertResumedUsers($resumedPlayers, $scheduleId, $gameId);
                                }

                                $returnValue .= "**Id**" . $gameId . "==SI==" . $scheduleId . "==PU==" . $playedUsersCount . "==RU==" . $resumedPlayersCount . "==Ans==" . $userAnswersCount . "\n";
                            }
                        }
                    }
                }
            } else {
                $returnValue = 'No User found.';
            }
            if ($returnValue == "") {
                $returnValue = "failure";
            }
            echo $returnValue;
        } catch (Exception $ex) {
            echo "Exception in Create Game==actionCreateGame" . $ex->getMessage();
            Yii::log("DatamigrationController:actionCreateGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function scheduleGame($schedule, $gameId, $userId) {
        try {
            $returnValue = 'failure';
            if (isset($gameId) && !empty($gameId)) {
                $newScheduleGame = new ScheduleGameForm();
                $newScheduleGame->GameName = $gameId;
                $newScheduleGame->StartDate = $schedule["StartDate"];
                $newScheduleGame->EndDate = $schedule["EndDate"];
                $newScheduleGame->ShowDisclaimer = (int) $schedule["ShowDisclaimer"];
                $newScheduleGame->ShowThankYou = (int) $schedule["ShowThankYou"];
                $newScheduleGame->ThankYouMessage = $schedule["ThankYouMessage"];
                $newScheduleGame->ThankYouArtifact = $schedule["ThankYouArtifact"];
                $newScheduleGame->MigratedScheduleId = $schedule["GameScheduleId"];
                $returnValue = ServiceFactory::getSkiptaGameServiceInstance()->saveScheduleGame($newScheduleGame, $userId, $newScheduleGame->StartDate);
            } else {
                $returnValue = 'No Game found.';
            }
            return $returnValue;
        } catch (Exception $ex) {
            echo "Exception in Create Game==scheduleGame" . $ex->getMessage();
            Yii::log("DatamigrationController:scheduleGame::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function insertPlayedUsers($playedUsers, $scheduleId, $gameId, $createdDate = "") {
        try {
            $i = 0;
            foreach ($playedUsers as $playedUser) {
                $i++;
                $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($playedUser["UserEmail"]);
                $result = ServiceFactory::getSkiptaGameServiceInstance()->submitGame($UserObj->UserId, $gameId, $scheduleId, (int) $playedUser["TotalTimeSpent"], $createdDate);
            }
            return $i;
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
            Yii::log("DatamigrationController:insertPlayedUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function insertResumedUsers($resumedUsers, $scheduleId, $gameId) {
        try {
            $j = 0;
            foreach ($resumedUsers as $resumedUser) {
                $j++;
                $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($resumedUser["UserEmail"]);
                $result = ServiceFactory::getSkiptaGameServiceInstance()->showGame($UserObj->UserId, "play", $gameId, $scheduleId);
            }
            return $j;
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
            Yii::log("DatamigrationController:insertResumedUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public function saveAnswers($userAnswers, $scheduleId, $gameId, $gameQuestionArray) {
        try {
            $k = 0;
            $questionIdArray = $gameQuestionArray["QuestionIdArray"];
            foreach ($userAnswers as $answer) {
                $k++;
                $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($answer["UserEmail"]);
                $questionId = $answer['QuestionId'];
                $result = ServiceFactory::getSkiptaGameServiceInstance()->saveAnswer($UserObj->UserId, $gameId, $scheduleId, $questionIdArray["$questionId"], $answer["Answer"]);
            }
            return $k;
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
            Yii::log("DatamigrationController:saveAnswers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public function actionSaveWebLinks()    {
        try{
        $webLinks = CJSON::decode($_REQUEST['data'], true);
        $validLink = $webLinks['IsLinkValidForSnippet'];
        $SnippetObj='';
        if($validLink)
        {
            $text = trim(urlencode($webLinks['Link']));
                    $ext = strtolower(pathinfo($text, PATHINFO_EXTENSION));
                    if ($ext != 'pdf' && $ext != 'txt') {
                        $url = "https://api.embed.ly/1/oembed?key=96677167dd4e4dd494564433fe259ff9&url=" . $text;
                        $details = file_get_contents($url);
                        if (isset($details) && !empty($details)) {
                            $decode = CJSON::decode($details);
                            $SnippetObj = ServiceFactory::getSkiptaPostServiceInstance()->SaveWebSnippet($text, $decode, $webLinks['CreatedOn']);
                        }
                    }
            
            
        }
         $userId='';
         $UserEmail = Yii::app()->params['NetworkAdminEmail']; //network Admin URL
            $UserObj = ServiceFactory::getSkiptaUserServiceInstance()->checkUserExist($UserEmail);
            if (isset($UserObj->UserId)) {
            $userId=$UserObj->UserId;
            }
            $webLinkObj=new WebLinks();
            $webLinkObj->WebUrl=$webLinks['Link'];
            $webLinkObj->Description=$webLinks['Description'];
            $webLinkObj->Title = $webLinks['Title'];
            $webLinkObj->OtherValue = $webLinks['CategoryName']; 
            $webLinkObj->LinkGroup = 'other';
            if(is_object($SnippetObj)){
                $webLinkObj->WebDescription=$SnippetObj->Webdescription;
                $webLinkObj->WebImage=$SnippetObj->WebImage;
                $webLinkObj->WebSnippetUrl=$SnippetObj->WebLink;
                $webLinkObj->WebTitle=$SnippetObj->WebTitle;                
            }
            $webLinkObj->Status=1;
            $webLinkObj->CreatedUserId=$userId;
            $Xcol = rand(1, 2);
            $webLinkObj->Xcol=$Xcol;
            $webLinkObj->CreatedOn=$webLinks['CreatedOn'];
            return WebLinks::model()->saveNewWebLink($webLinkObj,'new');
        
    
    } catch (Exception $ex) {
       Yii::log("DatamigrationController:actionSaveWebLinks::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
}
