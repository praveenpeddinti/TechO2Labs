<?php

/**
 * Developer Name: Suresh Reddy
 * CommonUtility is the customized for common methods.
 * All  common methods need to mention here.
 */
class CommonUtility {

    /**
     * Developer Name: Suresh Reddy & HariBabu
     * this method is used for send a mail using below parameters.
     * 
     * 
     * $view  basic template file
     * $params array ,these array parames will bind with view file.
     * $subject subject of email
     * $toAddress toAddress , sender's email addresses
     * $fromAddress fromAddress of User
     */
    public $tinyObject; // this is local variable, which can accessiable in any function
   public $array = array();
    public function actionSendmail($view, $params, $subject, $recipients) {

        try {
            $fromAddress = Yii::app()->params['SendGridFromEmail'];
            $fromName = Yii::app()->params['NetworkName'];
            if (DEPLOYMENT_MODE == 'PRODUCTION') {
                $controller = new CController('YiiMail');
                if (isset(Yii::app()->controller)) {
                    $controller = Yii::app()->controller;
                }
                $resultantPreparedHtml = $controller->renderInternal(Yii::app()->basePath . '/views/mail/' . $view . '.php', $params, 1);
                $result = Yii::app()->sendgrid->sendMail($recipients, '', '', $subject, $resultantPreparedHtml, '', $fromAddress, '', $fromName, '');
                if ($result['message'] == 'success') {
                    return true;
                } else {
                    return false;
                }
            } else {
                Yii::import('ext.yii-mail.YiiMailMessage');
                Yii::app()->mail->transportOptions = array(
                    'host' => 'smtp.gmail.com',
                    'username' => 'mikeaaron8@gmail.com',
                    'password' => 'test@123',
                    'port' => '465',
                    'encryption' => 'ssl',
                );
                Yii::app()->mail->transportType = "smtp"; // Uncomment these when email is configured in admin section for Template management
                $message = new YiiMailMessage;
                $message->view = $view;
                $message->setBody($params, 'text/html');
                $message->subject = $subject;
                $message->addTo($recipients);
                $message->from = 'mikeaaron8@gmail.com';

                if (Yii::app()->mail->send($message)) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:actionSendmail::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->actionSendmail==".$ex->getMessage());
        }
    }

    /*
     * it using for given string is md5 format or not
     * $md5 is md5 format string. it's return 0 or 1
     */

    static function isValidMd5($md5 = '') {
        try {
            $md5 = strtolower($md5);
            return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:isValidMd5::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function getDateFormat() {
        try {


            if (Yii::app()->params['DateFormat'] == "mm/dd/yyyy") {
                $dateFormat = "m/d/Y";
            } else if (Yii::app()->params['DateFormat'] == "dd/mm/yyyy") {
                $dateFormat = "d/m/Y";
            } else if (Yii::app()->params['DateFormat'] == "yyyy/mm/dd") {
                $dateFormat = "Y/m/d";
            } else if (Yii::app()->params['DateFormat'] == "yyyy-mm-dd") {
                $dateFormat = "Y-m-d";
            } else if (Yii::app()->params['DateFormat'] == "mm-dd-yyyy") {
                $dateFormat = "m-d-Y";
            } else if (Yii::app()->params['DateFormat'] == "dd-mm-yyyy") {
                $dateFormat = "d-m-Y";
            }
            $dateFormat = Yii::app()->params['PHPDateFormat'];

            return $dateFormat;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getDateFormat::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function get_highest($arr) {
        try{
        foreach ($arr as $key => $val) {

            if (is_array($val))
                $arr[$key] = CommonUtility::get_highest($val);
        }

        sort($arr);

        return array_pop($arr);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:get_highest::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*     * it's return index of action type
     * 
     * send a context type
     * 
     */

    static function getIndexByActionType($type = '') {
        try {
            $index = 0;
            if ($type == 'Post') {
                $index = 1;
            }
            if ($type == 'Follow') {
                $index = 2;
            }
            if ($type == 'Comment') {
                $index = 3;
            }
            if ($type == 'Like') {
                $index = 3;
            }
            if ($type == 'Share') {
                $index = 4;
            }
            return $index;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getIndexByActionType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function getUserActivityIndexByActionType($type = '') {
        try {
            $index = 0;
            if ($type == 'PostCreated') {
                $index = 2;
            } else if ($type == 'HashTagCreation') {
                $index = 1;
            } else if ($type == 'Love') {
                $index = 1;
            } else if ($type == 'Comment') {
                $index = 1;
            } else if ($type == 'Follow') {
                $index = 1;
            } else if ($type == 'UnFollow') {
                $index = 1;
            } else if ($type == 'Share') {
                $index = 1;
            } else if ($type == 'Invite') {
                $index = 1;
            } else if ($type == 'SurveySubmit') {
                $index = 1;
            } else if ($type == 'Login') {
                $index = 1;
            } else if ($type == 'HashtagUsed') {
                $index = 1;
            } else if ($type == 'MentionUsed') {
                $index = 1;
            } else if ($type == 'ProjectSearch') {
                $index = 1;
            } else if ($type == 'CategoryFilter') {
                $index = 1;
            } else if ($type == 'PostDetailOpen') {
                $index = 1;
            }
             else if ($type == 'CareerDetailOpen') {
                $index = 1;
            }
             else if ($type == 'QuickLinksDetailOpen') {
                $index = 1;
            }else if ($type == 'Stream') {
                $index = 1;
            } else if ($type == 'Curbside') {
                $index = 1;
            } else if ($type == 'Group') {
                $index = 1;
            } else if ($type == 'Profile') {
                $index = 1;
            } else if ($type == 'Chat') {
                $index = 1;
            } else if ($type == 'Notification') {
                $index = 1;
            } else if ($type == 'History') {
                $index = 1;
            } else if ($type == 'Settings') {
                $index = 1;
            } else if ($type == 'GroupCreation') {
                $index = 2;
            } else if ($type == 'GroupDetail') {
                $index = 1;
            } else if ($type == 'SubGroupDetail') {
                $index = 1;
            } else if ($type == 'GroupMinPopup') {
                $index = 1;
            } else if ($type == 'SubGroupMinPopup') {
                $index = 1;
            } else if ($type == 'EventAttend') {
                $index = 1;
            } else if ($type == 'Loaded') {
                $index = 1;
            } else if ($type == 'Scroll') {
                $index = 1;
            } else if ($type == 'HashTagMinPopup') {
                $index = 1;
            } else if ($type == 'MentionMinPopup') {
                $index = 1;
            } else if ($type == 'ProfileMinPopup') {
                $index = 1;
            } else if ($type == 'CurbCategoryMinPopup') {
                $index = 1;   //done
            } else if ($type == 'PostDelete') {
                $index = 1;   //done
            } else if ($type == 'PostPromote') {
                $index = 1;   //done
            } else if ($type == 'PostFlagAbuse') {
                $index = 1;   //done
            } else if ($type == 'PostFeatured') {
                $index = 1;   //done
            } else if ($type == 'PostSaveItForLater') {
                $index = 1;   //done
            }
            else if ($type == 'HashTagSearch') {
                $index = 1;
            }
            else if ($type == 'HashTagUsage') {
                $index = 1;
            }else if($type=='JobsLinkOpen'){
                 $index = 1;
            }else if($type=='SetUpPassword'){
                 $index = 1;
            }else if($type=='Impression'){
                 $index = 1;
            }else if($type=='QuickLinkClick'){
                 $index = 1;
            }
            else if($type=='SaveItForLater'){
                 $index = 1;
            }
              else if($type=='CustomGroupTab'){
                 $index = 1;
            }else if($type=='Register'){
                 $index = 1;
            }
            return $index;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getUserActivityIndexByActionType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function getProjectSearchTypeIndex($searchType = '') {
        try {

            $index = 0;

            if ($searchType == 'profile') {
                $index = 1;
            } else if ($searchType == 'group') {
                $index = 2;
            } else if ($searchType == 'subgroup') {
                $index = 3;
            }


            return $index;
        } catch (Exception $ex) {
           Yii::log("CommonUtility:getProjectSearchTypeIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }

    static function getPageIndex($page = '') {
        try {
            $index=0;
            if ($page == 'HomeStream') {
                $index = 1;
            } else if ($page == 'CurbStream') {
                $index = 2;
            } else if ($page == 'GroupStream') {
                $index = 3;
            } else if ($page == 'SubGroupStream') {
                $index = 4;
            } else if ($page == 'ProfileStream') {
                $index = 5;
            } else if ($page == 'Post') {
                $index = 6;
            } else if ($page == 'HashTag') {
                $index = 7;
            } else if ($page == 'Mention') {
                $index = 8;
            } else if ($page == 'ProjectSearch') {
                $index = 9;
            } else if ($page == 'Group') {
                $index = 10;
            } else if ($page == 'SubGroup') {
                $index = 11;
            } else if ($page == 'PostDetail') {
                $index = 13;
            } else if ($page == 'News') {
                $index = 14;
            } else if ($page == 'Game') {
                $index = 15;
            }
             else if ($page == 'QuickLinks') {
                $index = 16;
            }
             else if ($page == 'Chat') {
                $index = 17;
            }
            else if ($page == 'Career') {
                $index = 18;
            }
             else if ($page == 'CareerDetail') {
                $index = 19;
            }
             else if ($page == 'QuickLinksDetail') {
                $index = 20;
            }else if ($page == 'JobsLinksOpen') {
                $index = 21;
            }else if ($page == 'JobsCreation') {
                $index = 22;
            }else if ($page == 'Login') {
                $index = 22;
            }
            return $index;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getPageIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function getUserActivityContextIndexByActionType($type = '') {
        try {
            $index = 0;
            if ($type == 'Login') {
                $index = 1;
            } else if ($type == 'PostCreated') {
                $index = 2;   //done
            } else if ($type == 'PostHashTagCreation') {
                $index = 3;   //done
            } else if ($type == 'CurbPostHashTagCreation') {
                $index = 4;
            } else if ($type == 'GroupHashTagCreation') {
                $index = 5;
            } else if ($type == 'CommentHashTagCreation') {
                $index = 6;
            } else if ($type == 'PostHashTagUsed') {
                $index = 7;   //done
            } else if ($type == 'CurbPostHashTagUsed') {
                $index = 8;   ///done
            } else if ($type == 'GroupHashTagUsed') {
                $index = 9;
            } else if ($type == 'CommentHashTagUsed') {
                $index = 10;
            } else if ($type == 'PostMentionUsed') {
                $index = 11;
            } else if ($type == 'CurbPostMentionUsed') {
                $index = 12;
            } else if ($type == 'GroupPostMentionUsed') {
                $index = 13;
            } else if ($type == 'CommentMentionUsed') {
                $index = 14;
            } else if ($type == 'InviteMentionUsed') {
                $index = 15;
            } else if ($type == 'Love') {
                $index = 16;
            } else if ($type == 'Comment') {
                $index = 17;
            } else if ($type == 'Follow') {
                $index = 18;   //done
            } else if ($type == 'UnFollow') {
                $index = 19;   //done
            } else if ($type == 'FBShare') {
                $index = 20;
            } else if ($type == 'TwitterShare') {
                $index = 21;
            } else if ($type == 'Invite') {
                $index = 22;
            } else if ($type == 'ProjectSearch') {
                $index = 23; //done  
            } else if ($type == 'HashTagMinPopup') {
                $index = 24;   //done
            } else if ($type == 'MentionMinPopup') {
                $index = 25;   //done
            } else if ($type == 'HashTagFilter') {
                $index = 26;   //done
            } else if ($type == 'CategoryFilter') {
                $index = 27;   //done
            } else if ($type == 'PostDetailOpen') {
                $index = 28;   //done
            } else if ($type == 'Stream') {
                $index = 29;
            } else if ($type == 'Curbside') {
                $index = 30;
            } else if ($type == 'Group') {
                $index = 31;
            } else if ($type == 'Profile') {
                $index = 32;
            } else if ($type == 'GroupFollow') {
                $index = 33;
            } else if ($type == 'GroupUnFollow') {
                $index = 34;
            } else if ($type == 'CurbsideCategoryFollow') {
                $index = 35;
            } else if ($type == 'CurbsideCategoryUnFollow') {
                $index = 36;
            } else if ($type == 'HashTagFollow') {
                $index = 37;
            } else if ($type == 'HashTagUnFollow') {
                $index = 38;
            } else if ($type == 'UserFollow') {
                $index = 39;
            } else if ($type == 'UserUnFollow') {
                $index = 40;
            } else if ($type == 'StreamScroll') {
                $index = 41;
            } else if ($type == 'CurbsideScroll') {
                $index = 42;
            } else if ($type == 'GroupScroll') {
                $index = 43;
            } else if ($type == 'ProfileScroll') {
                $index = 44;
            } else if ($type == 'Chat') {
                $index = 45;
            } else if ($type == 'Notification') {
                $index = 46;
            } else if ($type == 'History') {
                $index = 47;
            } else if ($type == 'Settings') {
                $index = 48;
            } else if ($type == 'GroupCreation') {
                $index = 49;
            } else if ($type == 'GroupDetail') {
                $index = 50;
            } else if ($type == 'SubGroupDetail') {
                $index = 51;
            } else if ($type == 'GroupStream') {
                $index = 52;
            } else if ($type == 'CurbStream') {
                $index = 53;
            } else if ($type == 'GroupMedia/Resource') {
                $index = 54;
            } else if ($type == 'SubGroupStream') {
                $index = 55;
            } else if ($type == 'SubGroupMedia/Resource') {
                $index = 56;
            } else if ($type == 'GroupMinPopup') {
                $index = 57;
            } else if ($type == 'SubGroupMinPopup') {
                $index = 58;
            } else if ($type == 'SubGroupFollow') {
                $index = 59;   //done
            } else if ($type == 'SubGroupUnFollow') {
                $index = 60;
            } else if ($type == 'EventAttend') {
                $index = 61;
            } else if ($type == 'SurveySubmit') {
                $index = 62;   //done
            } else if ($type == 'Loaded') {
                $index = 63;   //done
            } else if ($type == 'Scroll') {
                $index = 64;   //done
            } else if ($type == 'ProfileMinPopup') {
                $index = 65;   //done
            } else if ($type == 'CurbCategoryMinPopup') {
                $index = 66;   //done
            } else if ($type == 'PostDelete') {
                $index = 67;   //done
            } else if ($type == 'PostPromote') {
                $index = 68;   //done
            } else if ($type == 'PostFlagAbuse') {
                $index = 69;   //done
            } else if ($type == 'PostFeatured') { 
                $index = 70;   //done
            } else if ($type == 'HashTagSearch') {
                $index = 71;   //done
            }
            else if ($type == 'HashTagUsage') {
                $index = 72;   //done
            }
             else if ($type == 'CareerDetailOpen') {
                $index = 73;   //done
            }
             else if ($type == 'QuickLinksDetailOpen') {
                $index = 74;   //done
            }else if($type=='JobsLinkOpen'){
                  $index = 75;   //done
            }else if($type=='JobsCreation'){
                  $index = 76;   //done
            }else if ($type == 'PostSaveItForLater') { 
                $index = 77;   //done
            }else if ($type == 'StreamImpression') { 
                $index = 78;   //done
            }else if ($type == 'CurbsideImpression') { 
                $index = 79;   //done
            }else if ($type == 'NewsImpression') { 
                $index = 80;   //done
            }else if ($type == 'WeblinkImpression') { 
                $index = 81;   //done
            }else if ($type == 'GameWallImpression') { 
                $index = 82;   //done
            }else if ($type == 'CareerImpression') { 
                $index = 83;   //done
            }else if ($type == 'GroupStreamImpression') { 
                $index = 84;   //done
            }else if ($type == 'SubGroupStreamImpression') { 
                $index = 85;   //done
            }else if ($type == 'FollowGroupsImpression') { 
                $index = 86;   //done
            }else if ($type == 'MoreGroupsImpression') { 
                $index = 87;   //done
            }else if ($type == 'AdsImpression') { 
                $index = 88;   //done
            }else if($type=='QuickLinkClick'){
                 $index = 89;
            }else if ($type == 'MediaImpression') { 
                $index = 90;   //done
            }else if ($type == 'ResourcesImpression') { 
                $index = 91;   //done
            }else if($type=='NotificationClick'){
                 $index = 92;
            }else if($type=='NotificationMarkAsRead'){
                 $index = 93;
            }else if($type=='ChatClick'){
                 $index = 94;
            }else if($type=='ChatFindUsers'){
                 $index = 95;
            }else if($type=='OpenFollowers'){
                 $index = 96;
            }else if($type=='OpenFollowings'){
                 $index = 97;
            }else if($type=="InteractionsClick"){
                 $index = 98;
            }else if($type == "ProfileClick"){
                 $index = 99;
            }else if($type == "CVClick"){
                 $index = 100;
            }else if($type=='Register'){
                 $index = 101;
            }else if($type=='LoginFail'){
                 $index = 102;
            }else if($type=='ForgotPassword'){
                 $index = 103;
            }else if($type=='Translation'){
                 $index = 104;
            }else if($type=='CommentTranslation'){
                 $index = 105;
            }else if($type=='HelpManagement'){
                 $index = 106;
            }else if($type=='ProfileInteractionImpression'){
                 $index = 107;
            }
            else if ($type == 'SetUpPassword') { 
                $index = 108;   //done
            }
             else if ($type == 'CustomGroupTab') { 
                $index = 109;   //done
            }
             else if ($type == 'Game') { 
                $index = 110;   //done
            }

            return $index;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getUserActivityContextIndexByActionType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*     * it's return index of getIndexBySystemCategoryType 
     * 
     * send a context type
     * 
     */

    static function getIndexBySystemCategoryType($type = '') {
        try {
            $index = 0;
            if ($type == 'Normal') {
                $index = 1;
            }else if ($type == 'Curbside') {
                $index = 2;
            }else if ($type == 'Group') {
                $index = 3;
            }else if ($type == 'User') {
                $index = 4;
            }else if ($type == 'HashTag') {
                $index = 5;
            }else if ($type == 'CurbsideCategory') {
                $index = 6;
            }else if ($type == 'SubGroup') {
                $index = 7;
            }else if ($type == 'News') {
                $index = 8;
            }else if ($type == 'Game') {
                $index = 9;
            }else if ($type == 'Badge') {
                $index = 10;
            }else if ($type == 'NetworkInvite') {
                $index = 11;
            }else if ($type == 'CV') {
                $index = 12;
            }else if ($type == 'Advertisement') {
                $index = 13;
            }else if ($type == 'DSNNotification') {
                $index = 14;
            }else if ($type == 'Career') {
                $index = 15;
            }
            /* this category is used for extended survey */
            
            if ($type == 'ExtendedSurvey') {
                $index = 16;
            }else if ($type == 'Weblink') {
                $index = 21;
            }else if ($type == 'Ads') {
                $index = 17;
            }else if ($type == 'Media') {
                $index = 18;
            }else if ($type == 'Resources') {
                $index = 19;
            }
            else if ($type == 'SystemNotification') {
                $index = 20;
            }else if ($type == 'Profile') {
                $index = 22;
            }
            return $index;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getIndexBySystemCategoryType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*     * it's return index of getIndexBySystemCategoryType 
     * 
     * send a context type
     * 
     */

    public static function getIndexBySystemFollowingThing($type = '') {
        try {
            $index = 0;
            if ($type == 'Post') {
                $index = 1;
            }
            if ($type == 'Group') {
                $index = 2;
            }
            if ($type == 'User') {
                $index = 3;
            }
            if ($type == 'HashTag') {
                $index = 4;
            }
            if ($type == 'CurbsideCategory') {
                $index = 5;
            }
            if ($type == 'SubGroup') {
                $index = 6;
            }

            return $index;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getIndexBySystemFollowingThing::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /*     * return post type of integer 
     * param $type is type post like 'normalpost' ,etc.
     * 
     */

    public static function sendPostType($type) {
        try {

            $returnValue = 0;
            if ($type == 'Normal Post') {
                $returnValue = 1;
            } else if ($type == 'Event') {
                $returnValue = 2;
            } else if ($type == 'Survey') {
                $returnValue = 3;
            } else if ($type == 'Anonymous') {
                $returnValue = 4;
            } else if ($type == 'CurbsidePost') {
                $returnValue = 5;
            } else if ($type == 'User') {
                $returnValue = 6;
            } else if ($type == 'HashTag') {
                $returnValue = 7;
            } else if ($type == 'CurbsideCategory') {
                $returnValue = 8;
            } else if ($type == 'Group') {
                $returnValue = 9;
            } else if ($type == 'SubGroup') {
                $returnValue = 10;
            } else if ($type == 'News') {
                $returnValue = 11;
            } else if ($type == 'Game') {
                $returnValue = 12;
            }
            else if ($type == 'Badge') {
                $returnValue = 13;
            }
            else if ($type == 'NetworkInvite') {
                $returnValue = 14;
            }
             else if ($type == 'CV') {
                $returnValue = 15;
            }

             else if ($type == 'Advertisement') {
                $returnValue = 16;
            }
            

             else if ($type == 'Jobs') {
                $returnValue = 18;
            }
            else if ($type == 'SystemNotification') {
                $returnValue = 20;
            }

            else if ($type == 'ExtendedSurvey') {
                $returnValue = 19;
            }

            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:sendPostType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * 
     * @param type $type
     * @return int
     */
    static function postTypebyIndex($type, $isGroupCategory = 0) {
        try {

            $returnValue = 0;
            if ($type == 1) {
                $returnValue = ' a Post';
            } else if ($type == 2) {
                $returnValue = ' an Event ';
            } else if ($type == 3) {
                $returnValue = 'a Survey ';
            } else if ($type == 4) {
                // Anonymous Post
                $returnValue = ' a Post ';
            } else if ($type == 11) {
                // Anonymous Post
                $returnValue = ' a News';
            } else if ($type == 5) {
                $name = Yii::t('translation', 'CurbsideConsult');
                $returnValue = " a $name";
            } else if ($type == 6) {
                $returnValue = ' a Group ';
            } else if ($type == 7) {
                $returnValue = ' a Sub Group ';
            } else if ($type == 12) {
                $returnValue = ' a Game ';
            }
            else if ($type == 13) {
                $returnValue = ' a Badge ';
            }
            else if ($type == 14) {
                $returnValue = ' Network';
            }
              else if ($type == 16) {
                $returnValue = ' Advertisement';
            }

            
             else if ($type == 15) {
                $returnValue = ' CV ';
            }
            else if ($type == 16) {
                $returnValue = ' Market Research ';
            }

            if ($isGroupCategory == 3) {
                if ($type == 1) {
                    $returnValue = ' a Group Post';
                } else if ($type == 2) {
                    $returnValue = ' a Group Event ';
                } else if ($type == 3) {
                    $returnValue = 'a  Group Survey ';
                }
            }
            if ($isGroupCategory == 7) {
                if ($type == 1) {
                    $returnValue = ' a Sub Group Post';
                } else if ($type == 2) {
                    $returnValue = ' a Sub Group Event ';
                } else if ($type == 3) {
                    $returnValue = 'a  Sub Group Survey ';
                }
            }


            return str_replace("Survey",Yii::t("translation","Survey"),$returnValue);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:postTypebyIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * 
     * @param type $type
     * @return int
     */
    static function actionTextbyActionType($type) {
        try {
            $returnValue = 0;
            if ($type == 1) {
                //normal post type
                $returnValue = ' made  ';
            } else if ($type == 2) {
                //Event post type
                $returnValue = ' created  ';
            } else if ($type == 3) {
                //survery post type
                $returnValue = ' posted  ';
            } else if ($type == 4) {
                //anonymous post  type
                $returnValue = ' made  ';
            } else if ($type == 5) {
                //curbsidepost type
                $returnValue = '  posted  ';
            } else if ($type == 11) {
                //curbsidepost type
                $returnValue = ' posted ';
            } else if ($type == 12) {
                //game
                $returnValue = ' scheduled ';
            }
            else if ($type == 13) {
                //game
                $returnValue = ' unlocked ';
            }
            else if ($type == 14) {
                //game
                $returnValue = ' Join the ';
            }
            
              else if ($type == 15) {
                //game
                $returnValue = ' updated ';
            }
            
             else if ($type == 17) {
                //game
                $returnValue = ' updates ';
            }
            
            
            else if ($type == 'Follow') {
                $returnValue = ' is following ';
            } else if ($type == 'Comment') {
                $returnValue = ' commented on  ';
            } else if ($type == 'UserMention') {
                $returnValue = ' mentioned you in ';
            } else if ($type == 'HashTag') {
                $returnValue = ' on a hashtag  ';
            } else if ($type == 'UserFollow') {
                $returnValue = ' has following   ';
            } else if ($type == 'EventAttend') {
                $returnValue = ' is attending   ';
            } else if ($type == 'Invite') {
                $returnValue = ' has been invited to ';
            } else if ($type == 'Survey') {
                $returnValue = ' has answered   ';
            } else if ($type == 'UserFollow') {
                $returnValue = ' is following  ';
            } else if ($type == 'UserUnFollow') {
                $returnValue = ' is Unfollowing  ';
            } else if ($type == 'GroupFollow') {
                $returnValue = ' is following  ';
            } else if ($type == 'GroupUnFollow') {
                $returnValue = ' is Unfollowing  ';
            } else if ($type == 'HashTagFollow') {
                $returnValue = ' is following  ';
            } else if ($type == 'HashTagUnFollow') {
                $returnValue = ' is Unfollowing  ';
            } else if ($type == 'CurbsideCategoryFollow') {
                $returnValue = ' is following  ';
            } else if ($type == 'CurbsideCategoryUnFollow') {
                $returnValue = ' is Unfollowing  ';
            } else if ($type == 'Love') {
                $returnValue = ' loved ';
            } else if ($type == 'FbShare' || $type == 'TwitterShare') {
                $returnValue = ' shared ';
            } else if ($type == 'SubGroupFollow') {
                $returnValue = ' is following  ';
            } else if ($type == 'SubGroupUnFollow') {
                $returnValue = ' is Unfollowing  ';
            } else if ($type == 'Play') {
                $returnValue = ' has Played  ';
            } else if ($type == 'Resume') {
                $returnValue = ' have Paused ';
            }
            else if ($type == 'Resume') {
                $returnValue = ' are Paused ';
            }
            else if ($type == 'ExtendedSurveyFinished') {
                $returnValue = ' has answered ';
            }

            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:actionTextbyActionType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function styleDateTime($timestamp, $type = "web") {
        try{
        $text = date("d-m-Y h:i:s A", $timestamp);
        $difference = time() - $timestamp;
        
        //Yii::t('translation', 'Flag_as_abuse');
        $periods = array(Yii::t('translation', 'Time_Sec'), Yii::t('translation', 'Time_Min'), Yii::t('translation', 'Time_Hour'), Yii::t('translation', 'Time_Day'), Yii::t('translation', 'Time_Week'),Yii::t('translation', 'Time_Month'), Yii::t('translation', 'Time_Year'), Yii::t('translation', 'Time_Decade'));
        if ($type == "mobile") {
            $periods = array("s", "m", "h", "d", "w", "mo", "y", "decade");
        }

        $lengths = array("60", "60", "24", "7", "4.35", "12", "10", "100");
        if ($difference >= 0) { // this was in the past time
            $ending = Yii::t('translation', 'Time_Ago');
            $j = 0;
            for (; $difference >= $lengths[$j]; $j++) {
                $difference /= $lengths[$j];
            }
            $difference = round($difference);
            if ($j < 8) {
                if ($difference != 1 && $type == "web") {
                    //$periods[$j].= "s";
                }
                if (($j == 0 && $difference < 5) && $type == "web") {
                    $difference = Yii::t('translation', 'Time_Few');
                }
                if ($type == "mobile") {

                    $ending = "";
                    $text = "$difference"."$periods[$j] $ending";
                }else{
                    //$text = "$difference $periods[$j] $ending";
                    $arr = array("{number}"=>$difference, "{period}"=>$periods[$j]);
                    if($difference==1){
                        $text = Yii::t('streamnotes', '{number} {period} ago', $arr);
                    }else{
                        $text = Yii::t('streamnotes', '{number} {period}s ago', $arr);
                    }
                }
                
            }
        } else { // this was in the future time
            $ending = "to go";
            $j = 0;
            $difference = abs($difference);
            for (; $difference >= $lengths[$j]; $j++) {
                $difference /= $lengths[$j];
            }
            $difference = round($difference);
            if ($j < 8) {
                if ($difference != 1 && $type == "web") {
                    $periods[$j].= "s";
                }
                if (($j == 0 && $difference < 5) && $type == "web") {
                    $difference = $difference = Yii::t('translation', 'Time_Few');
                }

                 if($type=="mobile"){
                    $ending="";
                    $text = "$difference"."$periods[$j] $ending";
                }else{
                    $text = "$difference $periods[$j] $ending";

                }
            }

            // $text = date(Yii::app()->params['PHPDateFormat'], $timestamp);
        }

        return $text;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:styleDateTime::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function prepareHashTagsArray($hashtagString) {
        try{
        $hashtagString = CommonUtility::findUrlInStringAndMakeLink($hashtagString);
        $hashtagString = preg_replace('#<a.*?>.*?</a>#i', '', $hashtagString);
        $hashTagArray = array();
        $explosion = explode("#", strstr($hashtagString, '#'));
        $count = count($explosion);
        $hashtags = "";
        for ($i = 0; $i < $count; $i++) {
            if (strlen($explosion[$i]) > 2) {
                $explosion2 = explode(" ", $explosion[$i]);
                $explosion2 = explode(" ", $explosion2[0]); //it is a special character
                $explosion2 = $explosion2[0];
                $hashtags.="," . $explosion2;
            }
        }
        $hashtags = substr($hashtags, 1);
        if (strlen($hashtags) > 0) {
            $hashTagArray = explode(",", $hashtags);
            $hashTagArray = array_unique($hashTagArray);
        }
        return $hashTagArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareHashTagsArray::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function prepareAtMentionsArray($atMentions) {
        try{
        $atMentionArray = array();
        $atMentions = strlen($atMentions) > 0 ? substr($atMentions, 1) : "";
        if (strlen($atMentions) > 0) {
            $atMentionArray = array_unique(array_map('intval', explode(",", $atMentions)));
        }
        return $atMentionArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareAtMentionsArray::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar pathepalli 
     * @param type $streamPostData
     * @return array
     * 
     */
     static function prepareStreamData($UserId, $streamPostData, $UserPrivileges, $isHomeStream = 0, $PostAsNetwork = 0, $timezone = '', $previousStreamIdArray=array(), $isTimeVisible=1) {

        try {
            $streamIdArray = array();
             $zeroRecordArray=array();
             $oneRecordArray=array();
             $currentStreamIdArray = array();
             $totalStreamIdArray = array();
              $currentUserObj = UserCollection::model()->getTinyUserCollection($UserId);
              $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType($UserId, 'UserId');
            foreach ($streamPostData as $key=>$data){

                   array_push($totalStreamIdArray, (string)$data->PostId);
                  if (in_array("$data->PostId", $currentStreamIdArray)) {                                                     
                                unset($streamPostData[$key]);
                                continue;
                  
                        }
            
             $data->IsAdmin = 1;//$userObj->UserTypeId;
             //Advertisements filtaring start
                if(isset($data->DisplayPage) && $data->AdType!=1){
                    if($isHomeStream==1 && $data->DisplayPage!="Home"){
                      unset($streamPostData[$key]);
                       continue;  
                    }
                    
                    else if($isHomeStream==2 && $data->DisplayPage!="Group"){
                      unset($streamPostData[$key]);
                       continue;  
                    }
                    else if($isHomeStream==3 && $data->DisplayPage!="Curbside"){
                      unset($streamPostData[$key]);
                      continue;   
                    }
              
                   if($data->DisplayPage=="Group"){
                       $reg='/'.$_GET['groupId'].'/';
                       if($data->Groups!="AllGroups" && !preg_match($reg,$data->Groups) ){
                          unset($streamPostData[$key]);
                          continue; 
                       }  
                    }
                    
                }
                //Advertisements filtaring end
                array_push($totalStreamIdArray, (string)$data->PostId);
                if (!in_array((string)$data->PostId, $previousStreamIdArray)) {
                $recentActivityUser2="";
                $isPromoted = isset($data->IsPromoted)?$data->IsPromoted:0;
                $data->IsIFrameMode = 0;
                if ($data->CategoryType == 3) {
                    if (isset($data->GroupId)) {

                        $groupData = GroupCollection::model()->getGroupDetailsById($data->GroupId);

                        if ($groupData != "failure") {
                            $data->IsFollowingEntity = in_array($UserId, $groupData->GroupMembers);
                        if (($isHomeStream == 1 && $groupData->IsPrivate == 1) || ($isHomeStream == 1 && $data->IsFollowingEntity == 0)) {

                                unset($streamPostData[$key]);
                               continue;
                            }
                            $isIframeModeValue = (isset($groupData->IsIFrameMode) && $groupData->IsIFrameMode == 1) ? 1 : 0;
                            if ($isIframeModeValue == 1 && in_array($UserId, $groupData->GroupMembers) || ($groupData->CustomGroup == 1 && $groupData->IsHybrid == 0)) {

                                $data->IsIFrameMode = 1;//then it is  a iframe group
                                $data->IsNativeGroup=1; //then it is custom or iframe group
                            }
                            $data->GroupName = $groupData->GroupName;
                            $data->GroupUniqueName= $groupData->GroupUniqueName;
                            $data->MainGroupId = $groupData->_id;
                            $data->GroupImage = $groupData->GroupProfileImage;
                            $data->IsPrivate = $groupData->IsPrivate;

                            if (in_array($data->OriginalUserId, $groupData->GroupAdminUsers) || ($groupData->IsIFrameMode == 1 || ($groupData->CustomGroup == 1 && $groupData->IsHybrid == 0))) {
                                $data->isGroupAdminPost = 'true';
                            }
                            /***** ConversationVisibility settings *****/
                            if($groupData->DisableWebPreview == 1){
                                   $data->DisableWebPreview = 1;
                            }
                            /***** DisableStreamConversation settings *****/
                            if($groupData->DisableStreamConversation == 1){
                                   $data->DisableStreamConversation = 1;
                            }
                            if($groupData->ConversationVisibility == 1){
                                    $data->IsIFrameMode = 1;
                            }
                            
                            if ($data->IsIFrameMode != 1) {
                                $data->GroupImage = $groupData->GroupProfileImage;
                              
                                /* for more */                                
                                $tagsFreeDescription = strip_tags(($groupData->GroupDescription));
                                $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);

                                $descriptionLength = strlen($tagsFreeDescription);
                                
                                /* for more */


                                if ($descriptionLength > 240) {
                                    $description = CommonUtility::truncateHtml($groupData->GroupDescription, 240);
                                    $data->GroupDescription = trim($description) .  Yii::t('translation','Readmore');
                                } else {
                                    $data->GroupDescription = $groupData->GroupDescription;
                                }


                                $data->PostFollowers = array_values(array_unique($data->PostFollowers));
                                $data->GroupFollowersCount = sizeof($data->PostFollowers);
                                $data->IsFollowingPost = in_array($UserId, $data->PostFollowers);


                                if ($data->isDerivative == 0) {
                                    if ($isHomeStream == 1 && (!($data->IsFollowingEntity) || $isPromoted == 1)) {
                                        unset($streamPostData[$key]);
                                        continue;
                                    }
                                } else {
                                    
                                }
                                }
                                if (isset($groupData->AddSocialActions)) {
                                        $data->AddSocialActions = $groupData->AddSocialActions;
                                    }
                                    if($groupData->RestrictedAccess == 1){
                                    $data->RestrictedAccessGroup = 1;
                                }
                            }
                            /*
                              * KOL post start
                              */ 
                            if(isset($data->Miscellaneous) && $data->Miscellaneous == 1){//KOL Post
                                $data->AddSocialActions = 0;
                                $data->GroupUniqueName = "";
                                $data->isGroupAdminPost = "false";
                            }
                            /*
                              * KOL post end
                              */ 
                    }
                }
                if ($data->CategoryType == 7) {
                    if (isset($data->SubGroupId)) {

                        $groupData = SubGroupCollection::model()->getSubGroupDetailsById($data->SubGroupId);
                        $gData = GroupCollection::model()->getGroupDetailsById($data->GroupId);

                        if ($groupData != "failure") {
                            $data->SubGroupImage = $groupData->SubGroupProfileImage;
                            $data->SubGroupName = $groupData->SubGroupName;
                            $data->SubGroupUniqueName= $groupData->SubGroupUniqueName;
                            $data->GroupUniqueName= $gData->GroupUniqueName;
                            $data->GroupName = $gData->GroupName;
                            $data->MainGroupId = $groupData->_id;
                             if($groupData->DisableWebPreview == 1){
                                   $data->DisableWebPreview = 1;
                            }
                            if($groupData->DisableStreamConversation == 1){
                                   $data->DisableStreamConversation = 1;
                            }                            
                            if (in_array($data->OriginalUserId, $groupData->SubGroupAdminUsers)) {
                                $data->isGroupAdminPost = 'true';
                            }
                            /* for more */
                            $tagsFreeDescription = strip_tags(($groupData->SubGroupDescription));
                            $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);

                            $descriptionLength = strlen($tagsFreeDescription);
                            /* for more */

                            if ($descriptionLength > 240) {
                                $description = CommonUtility::truncateHtml($groupData->SubGroupDescription, 240);
                                $data->SubGroupDescription = trim($description) .  Yii::t('translation','Readmore');
                            } else {
                                $data->SubGroupDescription = $groupData->SubGroupDescription;
                            }

                             $key = array_search(0, $groupData->SubGroupMembers);
                            if ($key != FALSE) {
                                unset($groupData->SubGroupMembers[$key]);
                            }
                             $data->PostFollowers = array_values(array_unique($data->PostFollowers));
                            $data->SubGroupFollowersCount = sizeof($data->PostFollowers);
                            $data->IsFollowingEntity = in_array($UserId, $groupData->SubGroupMembers);
                            if ($data->isDerivative == 0) {
                                if ($isHomeStream == 1 && (!($data->IsFollowingEntity) || $isPromoted == 1)) {
                                    unset($streamPostData[$key]);
                                    continue;
                                }
                            }
                           if (isset($groupData->AddSocialActions)) {
                                    $data->AddSocialActions = $groupData->AddSocialActions;
                                }
                            }
                    }
                }
               
                $data->IsPromoted = $isPromoted;

                if ($data->CategoryType == 9) {
                    try {
                        if ($data->UserId == 0) {
                            if (count($oneRecordArray) > 0) {
                                $key_1 = array_search($data->PostId, $oneRecordArray);
                                if (is_int($key_1)) {
                                    unset($streamPostData[$key]);
                                    continue;
                                }
                            }
                            $zeroRecordArray[$key] = $data->PostId;
                        } else {
                            $oneRecordArray[$key] = $data->PostId;
                            if (count($zeroRecordArray) > 0) {
                                $key12 = array_search($data->PostId, $zeroRecordArray);
                                if (is_int($key12)) {
                                    unset($streamPostData[$key12]);
                                    //continue;
                                }
                            }
                        }
                        $sDate = strtotime($data->StartDate);                       
                        $gameUserStatus='no schedule';
                        if((String)$data->CurrentGameScheduleId!='0'){
                        $gameUserStatus = ScheduleGameCollection::model()->findUserGameStatus($UserId, $data->CurrentGameScheduleId, $data->StartDate);
                        }
                        $gameScheduls = ScheduleGameCollection::model()->getSchedulesForGame($data->PostId,$data->SegmentId);
                        if (!is_string($gameScheduls)) {
                            $data->SchedulesArray = $gameScheduls;
                        } else {
                            $data->SchedulesArray = 'noschedules';
                        }
                        $data->GameStatus = $gameUserStatus;
                        
                        /** this is logic for Previous Schedules */
                        $previousSchedule = $data->PreviousGameScheduleId;
                        if (isset($previousSchedule) && $previousSchedule != null) {
                            $gameUserStatusForPreviousSchedule = ScheduleGameCollection::model()->findUserGameStatusForPreviousSchedule($UserId, $previousSchedule, $data->StartDate);

                            $data->PreviousGameStatus = $gameUserStatusForPreviousSchedule;
                        }
                       
                        if($data->SegmentId != $currentUserObj["SegmentId"]){
                            $data->CanScheduleGame = 0;
                        }
                        if ($UserId == $data->OriginalUserId) {
                            $data->GameAdminUser = 1;
                        } else {
                            $data->GameAdminUser = 0;
                        }
                    } catch (Exception $ex) {
                        Yii::log("CommonUtility:prepareStreamData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                        error_log("Exception Occurred in CommonUtility->prepareStreamData==".$ex->getMessage());
                    }
                }else {
                    if (sizeof($streamIdArray) > 0) {
                        if (array_key_exists("$data->PostId", $streamIdArray)) {
                            if ($streamIdArray["$data->PostId"] == $isPromoted) {
                                unset($streamPostData[$key]);
                                continue;
                            }
                        }
                    }
                }
                
                $data->CanMarkAsAbuse = 0;
                $streamIdArray["$data->PostId"] = $isPromoted;
                $data->SessionUserId = $UserId;
                $data->CanDeletePost = ($data->OriginalUserId == $data->SessionUserId) ? 1 : 0;
                if (is_array($UserPrivileges)) {
                    foreach ($UserPrivileges as $value) {
                        if ($value['Status'] == 1) {
                            if ($value['Action'] == 'Delete') {
                                $data->CanDeletePost = 1;
                            } else if ($value['Action'] == 'Promote_Post') {
                                $data->CanPromotePost = 1;
                            } else if ($value['Action'] == 'Promote_To_Featured_Items') {
                                $data->CanFeaturePost = 1;
                            } else if ($value['Action'] == 'Mark_As_Abuse') {
                                $data->CanMarkAsAbuse = 1;
                            }
                              else if ($value['Action'] == 'Can_Copy_URL') {
                                $data->CanCopyURL=1;
                            }
                             else if ($value['Action'] == 'Save_It_For_Later') {
                                $data->CanSaveItForLater=1;
                            }
                             else if ($value['Action'] == 'Digest_Use') {
                                $data->Digest_Use=1;
                            }
                        
                        }
                    }
                }

                $createdOn = $data->CreatedOn;
                $originalPostTime = $data->OriginalPostTime;
                if ($isPromoted == 1) {
                    $data->PostOn = CommonUtility::styleDateTime($originalPostTime->sec);
                    $data->PromotedDate = CommonUtility::styleDateTime($createdOn->sec);
                    $currentDate = date('Y-m-d', time());
                    $postPromotedDate = date('Y-m-d', $createdOn->sec);
                    if ($postPromotedDate < $currentDate) {
                        $data->PostOn = CommonUtility::styleDateTime($createdOn->sec);
                        $data->IsPromoted = 0;
                    }
                    if ($data->CanPromotePost == 1) {
                        if ($postPromotedDate > $currentDate) {
                            //   $data->CanPromotePost=0;
                        }
                    }
                } else {

                    $data->PostOn = CommonUtility::styleDateTime($createdOn->sec);

                }
                $data->OriginalPostPostedOn = CommonUtility::styleDateTime($originalPostTime->sec);
                $textWithOutHtml = $data->PostText;

                $textLength = strlen($textWithOutHtml);
                if (isset($data->WebUrls) && !empty($data->WebUrls) && $data->WebUrls != null) {
                    if (isset($data->IsWebSnippetExist) && $data->IsWebSnippetExist == '1') {
                        $snippetdata = WebSnippetCollection::model()->CheckWebUrlExist($data->WebUrls[0]);

                        $data->WebUrls = $snippetdata;
                    } else {
                        $data->WebUrls = "";
                    }
                }


                if (isset($data->PostTextLength) && $data->PostTextLength > 240 && $data->PostTextLength < 500) {
                    $appendData = '<span class="seemore tooltiplink"   onclick="expandpostDiv(' . "'" . $data->_id . "'" . ')"> <i class="fa  moreicon moreiconcolor">'. Yii::t('translation','Readmore').'</i></span>';
                } else {

                    $appendData = ' <span class="postdetail tooltiplink" data-id=' . $data->_id . '  data-postid="' . $data->PostId . '" data-categoryType="' . $data->CategoryType . '" data-postType="' . $data->PostType . '"> <i class="fa  moreicon moreiconcolor">'. Yii::t('translation','Readmore').'</i></span>';
                }

                $data->PostCompleteText = $data->PostText;
                if ($data->PostTextLength > 240) {
                    $description = CommonUtility::truncateHtml($data->PostText, 240, '...', true, true, $appendData);

                    $text = $description;
                    if($isHomeStream==1 && $data->IsNativeGroup==1)
                         $data->PostText = $data->PostText;
                    else{
                           $data->PostText = $text;
                    }
                }
                $tinyOriginalUser = UserCollection::model()->getTinyUserCollection($data->OriginalUserId);
                $postType = CommonUtility::postTypebyIndex($data->PostType, $data->CategoryType);
                if($data->CategoryType!=13){
                 $data->PostTypeString = $postType;    
                }              
                            
                            
                $createdOn = $data->CreatedOn;
                $originalPostTime = $data->OriginalPostTime;
                $recentActivity1UserId = "";
                $recentActivity2UserId = "";
                if ($data->RecentActivity == "Post") {
                    $recentActivity1UserId = $data->OriginalUserId;
                    $recentActivity2UserId = "";
                }

                elseif ($data->RecentActivity == "UserMention") {
                    $recentActivity1UserId = $data->MentionUserId;
                } elseif ($data->RecentActivity == "Love") {
                    $LoveUserId = array_values(array_unique($data->LoveUserId));
                    if (sizeof($LoveUserId) > 1) {
                        $recentActivity1UserId = $LoveUserId[sizeof($LoveUserId) - 1];
                        $recentActivity2UserId = $LoveUserId[sizeof($LoveUserId) - 2];
                    } elseif (sizeof($LoveUserId) == 1) {
                        $recentActivity1UserId = $LoveUserId[sizeof($LoveUserId) - 1];
                    }
                } elseif ($data->RecentActivity == "Comment") {
                    $CommentUserId =  array_values(array_unique(array_reverse($data->CommentUserId)));
                    $CommentUserId =  array_reverse($CommentUserId);
                    if (sizeof($CommentUserId) > 1) {
                        $recentActivity1UserId = $CommentUserId[sizeof($CommentUserId) - 1];
                        $recentActivity2UserId = $CommentUserId[sizeof($CommentUserId) - 2];
                    } elseif (sizeof($CommentUserId) == 1) {
                        $recentActivity1UserId = $CommentUserId[sizeof($CommentUserId) - 1];
                    }
                } elseif ($data->RecentActivity == "UserFollow") {

                    $FollowUserId = array_values(array_unique($data->UserFollowers));
                    if (count($FollowUserId) > 1) {
                        $recentActivity1UserId = $FollowUserId[sizeof($FollowUserId) - 1];
                        $recentActivity2UserId = $FollowUserId[sizeof($FollowUserId) - 2];
                    } elseif (sizeof($FollowUserId) == 1) {
                        $recentActivity1UserId = $FollowUserId[sizeof($FollowUserId) - 1];
                    }
                } elseif ($data->RecentActivity == "PostFollow") {
                    //  $PostFollow = array_values(array_unique($data->PostFollowers));
                    $PostFollow =  array_values(array_unique(array_reverse($data->PostFollowers)));
                    $PostFollow =  array_reverse($PostFollow);
                    if (count($PostFollow) > 1) {
                        $recentActivity1UserId = $PostFollow[sizeof($PostFollow) - 1];
                        $recentActivity2UserId = $PostFollow[sizeof($PostFollow) - 2];
                    } elseif (sizeof($PostFollow) == 1) {
                        $recentActivity1UserId = $PostFollow[sizeof($PostFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "EventAttend") {
                    $EventAttendes = array_values(array_unique($data->EventAttendes));
                    if (sizeof($EventAttendes) > 1) {
                        $recentActivity1UserId = $EventAttendes[sizeof($EventAttendes) - 1];
                        $recentActivity2UserId = $EventAttendes[sizeof($EventAttendes) - 2];
                    } elseif (sizeof($EventAttendes) == 1) {
                        $recentActivity1UserId = $EventAttendes[sizeof($EventAttendes) - 1];
                    }
                } elseif ($data->RecentActivity == "Invite") {
                    $InviteUsers = array_values(array_unique($data->InviteUsers));
                    if (sizeof($InviteUsers) > 1) {
                        $recentActivity1UserId = $InviteUsers[sizeof($InviteUsers) - 1];
                        $recentActivity2UserId = $InviteUsers[sizeof($InviteUsers) - 2];
                    } elseif (sizeof($InviteUsers) == 1) {
                        $recentActivity1UserId = $InviteUsers[sizeof($InviteUsers) - 1];
                    }
                } elseif ($data->RecentActivity == "Survey") {
                    $SurveyTaken = array_values(array_unique($data->SurveyTaken));
                    if (sizeof($SurveyTaken) > 1) {
                        $recentActivity1UserId = $SurveyTaken[sizeof($SurveyTaken) - 1];
                        $recentActivity2UserId = $SurveyTaken[sizeof($SurveyTaken) - 2];
                    } elseif (sizeof($SurveyTaken) == 1) {
                        $recentActivity1UserId = $SurveyTaken[sizeof($SurveyTaken) - 1];
                    }
                } elseif ($data->RecentActivity == "GroupFollow") {
                    $GroupFollow = array_values(array_unique($data->GroupFollowers));
                    if (sizeof($GroupFollow) > 1) {
                        $recentActivity1UserId = $GroupFollow[sizeof($GroupFollow) - 1];
                        $recentActivity2UserId = $GroupFollow[sizeof($GroupFollow) - 2];
                    } elseif (sizeof($GroupFollow) == 1) {
                        $recentActivity1UserId = $GroupFollow[sizeof($GroupFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "CurbsideCategoryFollow") {
                    $CurbsideFollow = array_values(array_unique($data->CurbsideCategoryFollowers));
                    if (sizeof($CurbsideFollow) > 1) {
                        $recentActivity1UserId = $CurbsideFollow[sizeof($CurbsideFollow) - 1];
                        $recentActivity2UserId = $CurbsideFollow[sizeof($CurbsideFollow) - 2];
                    } elseif (sizeof($CurbsideFollow) == 1) {
                        $recentActivity1UserId = $CurbsideFollow[sizeof($CurbsideFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "HashTagFollow") {
                    $recentActivity1UserId = $data->HashTagPostUserId;
                    $HashTagFollow = array_values(array_unique($data->HashTagFollowers));
                    if (sizeof($HashTagFollow) > 1) {
                        $recentActivity1UserId = $HashTagFollow[sizeof($HashTagFollow) - 1];
                        $recentActivity2UserId = $HashTagFollow[sizeof($HashTagFollow) - 2];
                    } elseif (sizeof($HashTagFollow) == 1) {
                        $recentActivity1UserId = $HashTagFollow[sizeof($HashTagFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "Play") {
                    if (isset($data->CurrentScheduledPlayers) && is_array($data->CurrentScheduledPlayers) ) {
                        // $PlayedUsers = array_values(array_unique($data->CurrentScheduledPlayers));
//                    $PlayedUsers =  array_values(array_unique(array_reverse($data->CurrentScheduledPlayers)));
//                    $PlayedUsers =  array_reverse($PlayedUsers);
                      $PlayedUsers =  array_values($data->CurrentScheduledPlayers);
                        if (sizeof($PlayedUsers) > 1) {
                            $recentActivity1UserId = $PlayedUsers[sizeof($PlayedUsers) - 1]['UserId'];
                            $recentActivity2UserId = $PlayedUsers[sizeof($PlayedUsers) - 2]['UserId'];
                        } elseif (sizeof($PlayedUsers) == 1) {
                            $recentActivity1UserId = $PlayedUsers[sizeof($PlayedUsers) - 1]['UserId'];
                        }
                    }
                }
                 elseif ($data->ActionType == "FbShare") {
                    $ShareUserId = array_values(array_unique($data->FbShare));
                    if (sizeof($ShareUserId) > 1) {
                        $recentActivity1UserId = $ShareUserId[sizeof($ShareUserId) - 1];
                        $recentActivity2UserId = $ShareUserId[sizeof($ShareUserId) - 2];
                    } elseif (sizeof($ShareUserId) == 1) {
                        $recentActivity1UserId = $ShareUserId[sizeof($ShareUserId) - 1];
                    }
                }
                elseif ($data->ActionType == "TwitterShare") {
                    $ShareUserId = array_values(array_unique($data->TwitterShare));
                    if (sizeof($ShareUserId) > 1) {
                        $recentActivity1UserId = $ShareUserId[sizeof($ShareUserId) - 1];
                        $recentActivity2UserId = $ShareUserId[sizeof($ShareUserId) - 2];
                    } elseif (sizeof($ShareUserId) == 1) {
                        $recentActivity1UserId = $ShareUserId[sizeof($ShareUserId) - 1];
                    }
                }
                 elseif ($data->ActionType == "TwitterShare") {
                    $ShareUserId = array_values(array_unique($data->TwitterShare));
                    if (sizeof($ShareUserId) > 1) {
                        $recentActivity1UserId = $ShareUserId[sizeof($ShareUserId) - 1];
                        $recentActivity2UserId = $ShareUserId[sizeof($ShareUserId) - 2];
                    } elseif (sizeof($ShareUserId) == 1) {
                        $recentActivity1UserId = $ShareUserId[sizeof($ShareUserId) - 1];
                    }
                }else if($data->ActionType=="ExtendedSurveyFinished"){
                    $surveyUsers=$data->SurveyTaken;
                    $recentActivity1UserId=$surveyUsers[0];
                }
                
                
                elseif ($data->RecentActivity == "Schedule") {
                    $recentActivity2UserId = $data->OriginalUserId;
                }
//                if($isPromoted == 1){
//                    $recentActivity1UserId = (int)$data->PromotedUserId;
//                }
                $recentActivityUser1 = UserCollection::model()->getTinyUserCollection($recentActivity1UserId);
                if (!empty($recentActivity2UserId)) {
                    $recentActivityUser2 = UserCollection::model()->getTinyUserCollection($recentActivity2UserId);
                }
                $whosePost = "";
                if ($data->ActionType == 'Comment' || $data->ActionType == 'Follow' || $data->ActionType == 'EventAttend' || $data->ActionType == 'Invite') {
                    if ($data->OriginalUserId == $UserId) {
                        $whosePost = "your";
                    } elseif (in_array($data->OriginalUserId, array_unique($data->UserFollowers)) || in_array($data->OriginalUserId, array_unique($data->PostFollowers))) {
                        $whosePost = $tinyOriginalUser['DisplayName'];
                    }
                }
                $userId1 = "";
                $userId2 = "";
                $displayName1 = "";
                $displayName2 = "";
                $secondUser = "";
                if($data->CategoryType!=13){
                  $userId1 = $recentActivityUser1['UserId'];
                    $displayName1 = $UserId == $recentActivityUser1['UserId'] ? 'You' : $recentActivityUser1['DisplayName'];
                    /*if ($PostAsNetwork == 1) {
                        $displayName1 = $recentActivityUser1['DisplayName'];
                    }*/

                    if (!empty($recentActivityUser2)) {
                        $userId2 = $recentActivityUser2['UserId'];
                        $displayName2 = $UserId == $recentActivityUser2['UserId'] ? 'You' : $recentActivityUser2['DisplayName'];
                        if ($PostAsNetwork == 1) {
                            $displayName2 = $recentActivityUser2['DisplayName'];
                        }
                        if ($displayName2 == "You") {
                            $displayName2 = $displayName1;
                            $displayName1 = "You";
                            $temp = $userId1;
                            $userId1 = $userId2;
                            $userId2 = $temp;
                        }
                        $secondUser = ", <a class='userprofilename' data-id='" . $userId2 . "' style='cursor:pointer'><b>" . $displayName2 . "</b></a>";
                    }else{
                        if($data->CategoryType == 9 && $data->RecentActivity == "Post" ){
                          
                                    $displayName1 = $data->BannerTitle;
                          
                        }
                    }  
                }
                
                
                if($displayName1=="You"){
                    
                    $displayName1=Yii::t('translation', 'You');
                }

                
                $data->FirstUserId = $userId1;
                $data->FirstUserDisplayName = $displayName1;
                if($data->CategoryType==13){
                  $data->FirstUserProfilePic=$data->NetworkLogo;  
                }
                else{
                   $data->FirstUserProfilePic = $recentActivityUser1['profile250x250']; 
                }
                                    
                $data->SecondUserData = $secondUser;
                $data->PostBy = $whosePost;
                $data->OriginalUserDisplayName = $tinyOriginalUser['DisplayName'];
                $data->OriginalUserProfilePic = $tinyOriginalUser['profile70x70'];
                $data->IsFollowingPost = in_array($UserId, $data->PostFollowers);
                $data->IsLoved = in_array($UserId, $data->LoveUserId);
                $data->FbShare = isset($data->FbShare) && is_array($data->FbShare) ? in_array($UserId, $data->FbShare) : 0;
                $data->TwitterShare = isset($data->TwitterShare) && is_array($data->TwitterShare) ? in_array($UserId, $data->TwitterShare) : 0;
                if(is_array($data->SurveyTaken)) // if it is an array...
                    $data->IsSurveyTaken = in_array($UserId, $data->SurveyTaken);
                $data->TotalSurveyCount = $data->OptionOneCount + $data->OptionTwoCount + $data->OptionThreeCount + $data->OptionFourCount;
                if (isset($data->OptionFour) && !empty($data->OptionFour))
                    $data->IsOptionDExist = 1;

                $image = "";
               $isMine = 0;
                if ($data->IsMultiPleResources > 0) {
                    if (isset($data->Resource["ThumbNailImage"])) {
                        $data->ArtifactIcon = $data->Resource["ThumbNailImage"];
                    } else {
                        $data->ArtifactIcon = "";
                    }
                }
                if ($secondUser != "") {
                      $isMine = 1;
                    if (trim($data->StreamNote) == "is following") {
                        $data->StreamNote = " are following";
                    }
                    if (trim($data->StreamNote) == "is attending") {
                        $data->StreamNote = " are attending";
                    }
                    if (trim($data->StreamNote) == "has answered") {
                        $data->StreamNote = " have answered";
                    }
                    if (trim($data->StreamNote) == "is Played") {
                        $data->StreamNote = " are Played";
                    }
                    if (trim($data->StreamNote) == "has Played") {
                        $data->StreamNote = " have Played ";
                    }
                }
                if ($UserId == $recentActivityUser1['UserId'] && trim($secondUser) == "") {
                    
                   
                     $isMine = 1;


                    if (trim($data->StreamNote) == "is following") {
                        $data->StreamNote = " are following";
                    }
                    if (trim($data->StreamNote) == "is attending") {
                        $data->StreamNote = " are attending";
                    }
                    if (trim($data->StreamNote) == "has answered") {
                        $data->StreamNote = " have answered";
                    }if (trim($data->StreamNote) == "is Played") {
                        $data->StreamNote = " Played";
                    }
                    if (trim($data->StreamNote) == "has invited to") {
                        $data->StreamNote = " have invited to ";
                    }
                    if (trim($data->StreamNote) == "has Played") {
                        $data->StreamNote = " have Played ";
                    }
                }
                 if (trim($data->StreamNote) == "has been invited to") {
                        $data->StreamNote = "has been invited you to";
                    }

                if ($data->PostType == 4) {
                    $data->PostBy = "";
                    if ($data->ActionType == "Post") {
                        $data->PostBy = "";
                        $data->FirstUserDisplayName = "";
                        $data->FirstUserProfilePic = "/images/icons/user_noimage.png";
                        $data->SecondUserData = "";
                        $data->StreamNote = "A new post has been created";
                        $data->PostTypeString = "";
                    }
                }
                if ($data->PostType == 2) {
                    $eventStartDate = CommonUtility::convert_time_zone($data->StartDate->sec, $timezone, '', 'sec');
                    $eventEndDate = CommonUtility::convert_time_zone($data->EndDate->sec, $timezone, '', 'sec');
                    $data->Title = $data->Title;
                    $data->StartDate = date("Y-m-d", $eventStartDate);
                    $data->EndDate = date("Y-m-d", $eventEndDate);
                    $data->EventStartDay = date("d", $eventStartDate);
                    $data->EventStartDayString = date("l", $eventStartDate);
                    $data->EventStartMonth = date("M", $eventStartDate);
                    $data->EventStartYear = date("Y", $eventStartDate);
                    $data->EventEndDay = date("d", $eventEndDate);
                    $data->EventEndDayString = date("l", $eventEndDate);
                    $data->EventEndMonth = date("M", $eventEndDate);
                    $data->EventEndYear = date("Y", $eventEndDate);
                    $data->StartTime = date("h:i A", $eventStartDate);
                    $data->EndTime = date("h:i A", $eventEndDate);
                    if ($eventEndDate <= CommonUtility::currentSpecifictime_timezone($timezone)) {
                        $data->CanPromotePost = 0;
                        $data->IsEventAttend = 1;
                    } else {
                        $data->IsEventAttend = in_array($UserId, $data->EventAttendes);
                    }
                } elseif ($data->PostType == 3) {


                    $surveyExpiryDate = $data->ExpiryDate;
                    $data->Title = $data->Title;
                    if (isset($surveyExpiryDate->sec) && $surveyExpiryDate->sec <= time()) {
                        $data->CanPromotePost = 0;
                        $data->ExpiryDate = date("Y-m-d", $surveyExpiryDate->sec);
                    }
                    $surveyExpiryDate_tz = CommonUtility::convert_date_zone($surveyExpiryDate->sec, $timezone);
                    $currentDate_tz = CommonUtility::currentdate_timezone($timezone);
                    if ($surveyExpiryDate_tz < $currentDate_tz) {
                        $data->IsSurveyTaken = true; //expired
                    }
                }
               // $data->StreamNote = str_replace("scheduled","presents",$data->StreamNote);               
if ($data->IsAnonymous == 1) {
                    $data->PostBy = "";
                    if ($data->ActionType == "Post") {
                        $data->PostBy = "";
                        $data->FirstUserDisplayName = "";
                        if($data->RecentActivity=="UserMention"){
                           $data->FirstUserDisplayName = "Someone";  
                        }
                        
                        $data->FirstUserProfilePic = "/images/icons/user_noimage.png";
                        $data->SecondUserData = "";
                        $data->PostTypeString = "";
                        if ($data->PostType == 2) {
                           // $data->Title = "";
                            $data->StreamNote = "A new event has been created"; 
                        }
                        else if ($data->PostType == 3) {
                            // $data->Title = "";
                            $data->StreamNote = "A new ".Yii::t("translation","Survey")." has been created"; 
                        }else{
                             $data->StreamNote = "A new post has been created";
                        }
                    }
                }
                $comments = $data->Comments;
                //$commentCount = sizeof($comments);
                //$data->CommentCount = $data->CommentCount;
                $commentCount=0;
                if (sizeof($comments) > 0) {
                    foreach ($comments as $key => $value) {
                        $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
                        $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
                        if(!$IsBlockedWordExist && !$IsAbused){
                            $commentCount++;
                        }
                    }
                }
                $data->CommentCount = $data->CommentCount;;
                $commentsArray = array();
                if (sizeof($comments) > 0) {
                    $data->IsCommented = in_array((int) $UserId, $data->CommentUserId);
                    $commentsDisplayCount = 0;
                    for ($j = sizeof($comments); $j > 0; $j--) {
                        $comment = $comments[$j - 1];

                        $IsBlockedWordExist = isset($comment['IsBlockedWordExist']) && $comment['IsBlockedWordExist']?true:false;
                        $IsAbused = isset($comment['IsAbused']) && $comment['IsAbused']?true:false;
                        if(!$IsBlockedWordExist && !$IsAbused){
                            $commentsDisplayCount++;
                            $commentedUser = UserCollection::model()->getTinyUserCollection($comment["UserId"]);
                            $comment["CreatedOn"] = $comment["CreatedOn"];
                            $textWithOutHtml = CommonUtility::findUrlInStringAndMakeLink($comment["CommentText"]);
                            $comment['CommnetTextComplete'] = $comment["CommentText"];
                            if (isset($comment['WebUrls']) && !empty($comment['WebUrls']) && $comment['WebUrls'] != null) {

                                if (isset($comment['IsWebSnippetExist']) && $comment['IsWebSnippetExist'] == '1') {
                                    $CommentSnippetdata = WebSnippetCollection::model()->CheckWebUrlExist($comment['WebUrls'][0]);
                                    $comment['WebUrls'] = $CommentSnippetdata;
                                } else {

                                    $comment['WebUrls'] = "";
                                }
                            }
                            
                            if (isset($comment["CommentTextLength"]) && $comment["CommentTextLength"] > 240) {
                                
                                $appendCommentData = ' <span class="postdetail tooltiplink" data-id="' . $data->_id . '"  data-postid="' . $data->PostId . '" data-categoryType="' . $data->CategoryType . '" data-postType="' . $data->PostType . '"> <i class="fa  moreicon moreiconcolor">'. Yii::t('translation','Readmore').'</i></span>';
                                $description = CommonUtility::truncateHtml($comment["CommentText"], 240, 'Read more', true, true, $appendCommentData);
                                $text = $description;

                                $comment["CommentText"] = $text;
                            } else {

                                $comment["CommentText"] = $comment["CommentText"];
                            }
                                
                                                                 
                            $comment["CommentText"] = CommonUtility::findUrlInStringAndMakeLink($comment["CommentText"]);
                                
                            $comment['ProfilePicture'] = $commentedUser['profile70x70'];
                            $commentCreatedOn = $comment["CreatedOn"];
                            $comment["CreatedOn"] = CommonUtility::styleDateTime($commentCreatedOn->sec);
                            $comment["DisplayName"] = $commentedUser['DisplayName'];
                            $image = "";
                            if (sizeof($comment["Artifacts"]) > 0) {
                                if (isset($comment["Artifacts"]['ThumbNailImage'])) {
                                    $image = $comment["Artifacts"]['ThumbNailImage'];
                                } else {
                                    $image = "";
                                }
                            }
                            $comment["ArtifactIcon"] = $image;
                            array_push($commentsArray, $comment);
                            if ($commentsDisplayCount == 2) {
                                break;
                            }
                        }
                    }
                }
                $data->Comments = $commentsArray;
                if ($data->CategoryType == 3) {
                    if (isset($data->GroupId)) {
                        $data->PostTypeString = " " . $data->PostTypeString;
                    }
                }
                if ($data->CategoryType == 7) {
                    if (isset($data->SubGroupId)) {
                        $data->PostTypeString = " " . $data->PostTypeString;
                    }
                }
                if ($data->CategoryType == 11) {
                 if(isset(Yii::app()->params['InviteObjectType']) && Yii::app()->params['InviteObjectType']=="Text") {
                      $data->GroupImage = "";
                 } else{
                   $data->GroupImage = Yii::app()->params['ServerURL']  ."/images/system/invite.png";   
                 }
                   
                }
                /**
                 * follow Object  post type
                 * post type user is 6
                 * post type hashtag 7
                 * post type curbsidecategory 8
                 * post  type group 9
                 */
                if ($data->PostType == 9) {
                    if (isset($data->GroupId)) {
                        $groupData = GroupCollection::model()->getGroupDetailsById($data->GroupId);

                        $data->GroupImage = Yii::app()->params['ServerURL'] . $groupData->GroupProfileImage;
                        $data->GroupName =  $groupData->GroupName;
                         $data->GroupUniqueName =  $groupData->GroupUniqueName;
                        

                        if (strlen($groupData->GroupDescription) > 240) {
                            $description = CommonUtility::truncateHtml($groupData->GroupDescription, 240);
                            $data->GroupDescription = $description .  Yii::t('translation','Readmore');
                        } else {
                            $data->GroupDescription = $groupData->GroupDescription;
                        }
                        $data->GroupFollowersCount = sizeof($groupData->GroupMembers);
                        $data->IsFollowingEntity = in_array($UserId, $groupData->GroupMembers);
                        $data->PostTypeString = " Group ";
                    }
                }

                if ($data->PostType == 10) {
                    if (isset($data->SubGroupId)) {
                        $groupData = SubGroupCollection::model()->getSubGroupDetailsById($data->SubGroupId);
                        $data->SubGroupImage = $groupData->SubGroupProfileImage;
                        $data->SubGroupName = $groupData->SubGroupName;

                        if (strlen($groupData->SubGroupDescription) > 240) {
                            $description = CommonUtility::truncateHtml($groupData->GroupDescription, 240);
                            $data->SubGroupDescription = $description . Yii::t('translation','Readmore');
                        } else {
                            $data->SubGroupDescription = $groupData->SubGroupDescription;
                        }
                        $data->SubGroupFollowersCount = sizeof($groupData->SubGroupMembers);
                        $data->IsFollowingEntity = in_array($UserId, $groupData->SubGroupMembers);
                        $data->PostTypeString = " Sub Group ";
                    }
                }
                if ($data->PostType == 7) {
                    $data->PostTypeString = " #Tag";
                    $data->GroupImage = "/images/icons/hashtag_img.png";
                    $data->HashTagName = $data->HashTagName;
                    $data->GroupDescription = "";
                    $data->HashTagPostCount = count($data->HashTagFollowers);

                    $data->IsFollowingEntity = in_array($UserId, $data->HashTagFollowers);
                    $data->PostTypeString = " " . $data->HashTagName;
                    $data->PostFollowers =  $data->HashTagFollowers;
                }
                if ($data->PostType == 8) {
                    $name = Yii::t('translation', 'CurbsideConsult');
                    $data->PostTypeString = " $name Category";
                    $data->GroupImage = "/images/icons/curbesidepost_img.png";
                    $data->CurbsideConsultCategory = $data->CurbsideConsultCategory;
                    $data->GroupDescription = "";
                    $data->CurbsidePostCount = sizeof($data->CurbsideCategoryFollowers);
                    $data->IsFollowingEntity = in_array($UserId, $data->CurbsideCategoryFollowers);
                    $data->PostTypeString = " " . $data->PostTypeString;
                    $data->PostFollowers =  $data->CurbsideCategoryFollowers;
                }
                if ($data->PostType == 11) {
                    $data->IsNotifiable = (int) $data->IsNotifiable;
                }
                if ($data->PostType == 15) {                       
                    $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($data->OriginalUserId);
                    $data->PostCompleteText = "/profile/$userObj->uniqueHandle";
                    $data->PostTypeString = " in".$data->PostTypeString;                    
                    if($displayName1 == "You"){                       
                        $data->StreamNote = "have ".$data->StreamNote." your";
                        
                    }else{
                        $data->StreamNote = $data->StreamNote." their ";
                        
                    }
                    
//                    $data->PostBy = "";
//                    if ($data->ActionType == "Post") {
//                        $data->PostBy = "";
//                        $data->FirstUserDisplayName = "";
//                        $data->FirstUserProfilePic = "/images/icons/user_noimage.png";
//                        $data->SecondUserData = "";
//                        $data->StreamNote = "A new post has been created";
//                        $data->PostTypeString = "";
//                    }
                }
                if ($data->CategoryType == 16) {
                    $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$data->CurrentGameScheduleId);
                    
                    if(in_array($data->UserId,  is_array($obj->SurveyTakenUsers)?$obj->SurveyTakenUsers:array()) || $obj->IsCancelSchedule==1){
                        unset($streamPostData[$key]); 
                      continue;
                    }else{
                        if(is_object($obj) && $obj->MaxSpots>0){
                        $spotsCount = SurveyUsersSessionCollection::model()->getSpotsAvailabeForScheduledSurvey($obj,$obj->SurveyId);
                   $data->SpotsCount = $spotsCount; 
                   
                  $spotMessage =  CommonUtility::getSpotMessage($spotsCount,$obj->MaxSpots);
                   $data->SpotsMessage = $spotMessage;
                   } 
                    }
                  
                }
                
//                if($isPromoted){
//                    $data->StreamNote = "promoted";  
//                }
                
                  if($data->PostType!=17)
                {
                 $data->PostText = CommonUtility::findUrlInStringAndMakeLink($data->PostText);
                 $data->PostCompleteText = CommonUtility::findUrlInStringAndMakeLink($data->PostCompleteText);
                }
               
               
                 if ($data->CategoryType == 13) {
                     $flag=false;
                     if (isset($data->AdClassification) || isset($data->AdState) || (isset($data->AdCountry) && $data->AdCountry!=0) || isset($data->AdSubSpeciality)) { 
                         if (isset($data->AdClassification) && $data->AdClassification != $currentUserObj->UserClassification) {
                                unset($streamPostData[$key]);
                                continue;
                            }
                            if (isset($data->AdSubSpeciality) && $data->AdSubSpeciality != $currentUserObj->SubSpeciality) {
                                unset($streamPostData[$key]);
                                continue;
                            }
                            if ((isset($data->AdCountry) && $data->AdCountry!=0) && $data->AdCountry != $currentUserObj->CountryId) {
                                unset($streamPostData[$key]);
                                continue;
                            } else {
                                if (isset($data->AdState) && $data->AdState != $currentUserObj->State) {
                                    unset($streamPostData[$key]);
                                    continue;
                                }
                            }
                        }

                        $advertisementObj = Advertisements::model()->getAdvertisementsById($data->AdvertisementId);
                     if($advertisementObj != "failure"){
                    if(isset($advertisementObj->ScheduleId) && !empty($advertisementObj->ScheduleId)){
                        $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$advertisementObj->ScheduleId);
                   if(is_object($obj) && $obj->MaxSpots>0){
                        $spotsCount = SurveyUsersSessionCollection::model()->getSpotsAvailabeForScheduledSurvey($obj,$obj->SurveyId);
                   $data->SpotsCount = $spotsCount; 
                   
                  $spotMessage =  CommonUtility::getSpotMessage($spotsCount,$obj->MaxSpots);
                   $data->SpotsMessage = $spotMessage;
                   }
                         
                    }
                        
                   }
                     
                        $date = date('Y-m-d');
                        $sdate =$data->StartDate;
                        $exdate=$data->ExpiryDate;
                        $sdate =date("Y-m-d",$sdate->sec);
                        $exdate =date("Y-m-d",$exdate->sec);
                        $redirectUrl = $data->RedirectUrl;
                        if ($data->AdType == 3) {

                            $requestedFieldsArray = explode(",", $data->RequestedFields);
                            $QueryParms;
                            $userobj = UserCollection::model()->getTinyUserCollection($UserId);
                            $md5 = md5($UserId . "_" . $data->AdvertisementId);
                            foreach ($requestedFieldsArray as $value) {
                                $customUserId = null;
                                $customdisplayName = null;
                                if ($data->RequestedParams != "" && $data->RequestedParams != null) {
                                    $reqParms = explode(',', $data->RequestedParams);

                                    foreach ($reqParms as $param) {
                                        $paramList = explode(':', $param);
                                        if (trim($paramList[0]) == "UserId") {
                                            $customUserId = $paramList[1];
                                        }
                                        if (trim($paramList[0]) == "Display Name") {
                                            $customdisplayName = $paramList[1];
                                        }
                                    }
                                }

                                $QueryParms = ($QueryParms == "" ? $QueryParms : $QueryParms . "&");
                                if ($value == "UserId") {
                                    if ($customUserId == null) {
                                        $QueryParms.=trim($value) . "=" . $md5;
                                    } else {
                                        $QueryParms.=trim($customUserId) . "=" . $md5;
                                    }
                                }
                                if (trim($value) == "Display Name") {
                                    if ($customdisplayName == null) {
                                        $QueryParms.=trim($value) . "=" . $userobj->DisplayName;
                                    } else {
                                        $QueryParms.=trim($customdisplayName) . "=" . $userobj->DisplayName;
                                    }
                                }
                                if (trim($value) == "Email") {
                                    $QueryParms.=trim($value) . "=" . Yii::app()->session['Email'];
                                }
                            }
                            $QueryParms = str_replace(' ', '', $QueryParms);

                            if (stristr($redirectUrl, "?") == "") {
                                $redirectUrl.="?" . $QueryParms . "&NeoId=" . $md5;
                            } else {
                                $redirectUrl.="&" . $QueryParms . "&NeoId=" . $md5;
                            }
                        }
                            
                    if($data->IsNotifiable==1 && $sdate<=$date && $date<=$exdate){$data->IsNotifiable=1;}else{$data->IsNotifiable=0;}
                        $data->RedirectUrl = $redirectUrl==""?"#":$redirectUrl;
                    }


$lovefollowArray =  CommonUtility::getLoveAndFollowUsers($UserId,$data->LoveUserId,$data->PostFollowers);
                    $data->loveUsersArray = $lovefollowArray["loveUsersArray"];
                    $data->followUsersArray = $lovefollowArray["followUsersArray"];
                    $streamnote = '';


                    $streamnote = $streamnote . $data->StreamNote;
                    if ($data->CategoryType == 12) {
                        if (isset($data->Title) && $data->Title != "") {
                            $streamnote . $data->Title;
                        }
                    }
                    if ($data->CategoryType != 10 && $data->CategoryType != 11) {

                        $streamnote = $streamnote . $data->PostTypeString;
                    } else if ($data->CategoryType == 11) {
                        $networkUrl = $data->NetworkRedirectUrl;
                        $networkUrl = split("/site", $networkUrl);
                        $streamnote = $streamnote . "<a href='$networkUrl[0]' target='_blank'>" . $data->BadgeName . "</a>" . " " . $data->PostTypeString;
                    }
/**************Badge Name coming twice in stream note**************
                      else {
                      $streamnote = $streamnote . $data->BadgeName." badge";
                      }
**************Badge Name coming twice in stream note********end******/
                    $streamnote = $streamnote . "</span>";

                    /**************Stream messages preperation*******Start*********/
                    $categoryType = $data->CategoryType;
                    $postTypeId = $data->PostType;
                    $recentActivity = $data->RecentActivity;
                    $isAnonymous = $data->IsAnonymous;
                  
                    $badgeName = "";
                    if ($data->CategoryType == 10) {
                        $networkUrl = $data->NetworkRedirectUrl;
                        $networkUrl = split("/site", $networkUrl);
                        $badgeName = "<a href='$networkUrl[0]' target='_blank'>". Yii::t('posttypes',$data->BadgeName."Badge"). "</a>";
                    }
                    $cvType = "";
                    if ($data->CategoryType == 12) {
                        $cvType = $data->Title;
                    }        
                    
                    $invitedUsers = "";
                    $isInvited = 0;
                    if($recentActivity=="Invite"){
                        if(isset($data->InviteUsers)){
                            $tinyOriginalUser = UserCollection::model()->getTinyUserCollection($data->InviteUsers);   
                        }                         
                       
                        if($data->Priority!=0){
                            $isInvited = 1;
                        }
                        $InviteUserName=$tinyOriginalUser['DisplayName'];
                        $invitedUsers = "<a style='cursor:pointer' data-id='". $data->InviteUsers ."' class='userprofilename'><b>". $InviteUserName." </b></a>";
                    }
                    
                    $streamMessage = "";
                    if($categoryType!=11){
                    $streamMessage = CommonUtility::getStreamNote($categoryType, $postTypeId, $recentActivity, $isAnonymous, $isMine, $badgeName, $cvType, $invitedUsers, $isInvited);
                    }
                    if($streamMessage!=""){
                        $streamnote = $streamMessage;
                    }
                    /**************Stream messages preperation*******End*********/
                    if ($data->PostType == 2 || $data->PostType == 3) {
                        if (isset($data->Title) && $data->Title != "") {
                            $streamnote = $streamnote .' - '. '<span class="userprofilename">' . $data->Title . '</span>';
                        };
                    } else if ($data->PostType == 11) {
                        $streamnote = $streamnote . ' - ' . $data->Title;
                    } else if ($data->PostType == 5) {
                        $streamnote = $streamnote . ' - ' . $data->CurbsideConsultTitle;
                    } 

                    if($isTimeVisible==1){
                       $streamnote = $streamnote . ' <i>' . $data->PostOn . '</i>'; 
                    }                    
                    $data->StreamNote = $streamnote;
                    
                    
                    
                    
                    array_push($currentStreamIdArray, (string) $data->PostId);
                } else {

                    unset($streamPostData[$key]);
                continue;
            }
            }
            //if($isHomeStream == 1){
                             
                return array('streamPostData'=>$streamPostData, 'streamIdArray'=>$currentStreamIdArray,"totalStreamIdArray"=>$totalStreamIdArray);
//            }else{
//                return $streamPostData;
//            }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareStreamData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareStreamData==".$ex->getMessage());
        }
    }

    /**
     * @author Sagar pathepalli 
     * @param type $abusedPostData
     * @return array
     * 
     */
    static function prepareAbusedPostData($userId, $abusedPostData, $categoryType, $displayType = "Abuse") {
        try {
            foreach ($abusedPostData as $data) {

                $tinyOriginalUser = UserCollection::model()->getTinyUserCollection($data->UserId);

                $data->OriginalUserDisplayName = $tinyOriginalUser['DisplayName'];
                $data->OriginalUserProfilePic = $tinyOriginalUser['profile250x250'];
                $data->OriginalUserId = $data->UserId;
                $originalPostTime = $data->CreatedOn;
                $data->OriginalPostPostedOn = CommonUtility::styleDateTime($originalPostTime->sec);
                $data->DisplayType = $displayType;
                $isAbused = (isset($data->IsAbused) && $data->IsAbused)?1:0;
                $isCommentAbused = (isset($data->IsCommentAbused) && $data->IsCommentAbused)?1:0;
                $data->IsAbused = $isAbused;
                $data->IsCommentAbused = $isCommentAbused;
                if ($displayType == "Abuse" && ($isAbused || $isCommentAbused)) {//*********Abused posts
                    $abusedUserId = $data->IsAbused?$data->AbusedUserId:$data->UserId;
                    $tinyAbusedUser = UserCollection::model()->getTinyUserCollection($abusedUserId);
                    $data->AbusedUserProfilePic = $tinyAbusedUser['profile250x250'];
                    $data->AbusedUserDisplayName = ($userId == $abusedUserId) ? "You" : $tinyAbusedUser['DisplayName'];
                    $abusedOn = $data->AbusedOn;
                    $data->AbusedOn = CommonUtility::styleDateTime($abusedOn->sec);
                    $data->IsBlockedWordExist = 0;
                } else {//*********Blocked posts
                    $data->AbusedUserProfilePic = $data->OriginalUserProfilePic;
                    $data->AbusedUserDisplayName = ($userId == $data->OriginalUserId) ? "You" : $data->OriginalUserDisplayName;
                    $data->AbusedUserId = $data->OriginalUserId;
                    $data->AbusedOn = $data->OriginalPostPostedOn;
                    $data->IsBlockedWordExist = 1;
                    $data->IsAbused = 0;
                    $blockedWords = AbuseKeywords::model()->getAllAbuseWords();
                    if (is_array($blockedWords) && sizeof($blockedWords) > 0) {
                        $data->Description = CommonUtility::FindElementAndReplace($data->Description, $blockedWords);
                    }
                }
                $image = "";
                $filetype = "";
                if (sizeof($data->Resource) > 0) {
                    $filetype = isset($data->Resource[sizeof($data->Resource) - 1]["Extension"]) ? $data->Resource[sizeof($data->Resource) - 1]["Extension"] : "";
                    if (isset($data->Resource[sizeof($data->Resource) - 1]["ThumbNailImage"])) {
                        $image = $data->Resource[sizeof($data->Resource) - 1]["ThumbNailImage"];
                    } else {
                        $image = "";
                    }
                }
                $data->Extension = $filetype;
                $data->ArtifactIcon = $image;
                $data->IsMultiPleResources = sizeof($data->Resource) > 2 ? 2 : sizeof($data->Resource);
                if ($data->Type == 2) {
                    $eventStartDate = $data->StartDate;
                    $eventEndDate = $data->EndDate;
                    $data->Title = $data->Title;
                    $data->StartDate = date("Y-m-d", $eventStartDate->sec);
                    $data->EndDate = date("Y-m-d", $eventEndDate->sec);
                    $data->EventStartDay = date("d", $eventStartDate->sec);
                    $data->EventStartDayString = date("l", $eventStartDate->sec);
                    $data->EventStartMonth = date("M", $eventEndDate->sec);
                    $data->EventStartYear = date("Y", $eventEndDate->sec);
                    $data->EventEndDay = date("d", $eventEndDate->sec);
                    $data->EventEndDayString = date("l", $eventEndDate->sec);
                    $data->EventEndMonth = date("M", $eventEndDate->sec);
                    $data->EventEndYear = date("Y", $eventEndDate->sec);
                }
                if ($data->Type == 5) {
                    $curbsideCategory = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId($data->CategoryId);
                    $data->CurbsideConsultCategory = "<a style='cursor:pointer' data-id='" . $data->CategoryId . "' class='curbsideCategory'><b>" . isset($curbsideCategory['CategoryName']) ? $curbsideCategory['CategoryName'] : '' . "</b></a>";
                    $data->CurbsideConsultTitle = $data->Subject;
                }
                if ($categoryType == 3 && !is_int($data->SubGroupId)) {
                    $subgroupDetails = SubGroupCollection::model()->getSubGroupDetailsById($data->SubGroupId);
                    if (is_object($subgroupDetails)) {
                        $data->SubGroupName = $subgroupDetails->SubGroupName;
                    }

                    $categoryType = 7;
                }
                if ($categoryType == 3) {
                    $groupDetails = GroupCollection::model()->getGroupDetailsWithoutGroupMembersByGroupId($data->GroupId);
                    if (is_object($groupDetails)) {
                        $data->GroupName = $groupDetails->GroupName;
                    }
                }


                $data->CategoryType = $categoryType;


                $postType = CommonUtility::postTypebyIndex($data->Type, $data->CategoryType);
                $data->PostTypeString = $postType;
                $isPromoted = isset($data->IsPromoted) ? $data->IsPromoted : 0;
                if ($isPromoted == 1) {
                    $currentDate = date('Y-m-d', time());
                    $postPromotedDate = date('Y-m-d', $originalPostTime->sec);
                    if ($postPromotedDate < $currentDate) {
                        $data->IsPromoted = 0;
                    }
                }
                if ($isCommentAbused) {//*********Abused posts
                    $data->Comments = CommonUtility::abusedComments($data->Comments);
                }elseif (isset($data->IsBlockedWordExistInComment) && $data->IsBlockedWordExistInComment == 1) {
                    $data->Comments = CommonUtility::blockedComments($data->Comments);
                }
            }
               
            return $abusedPostData;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareAbusedPostData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Haribabu 
     * @param type post description
     * @return string
     * 
     */
    static function truncateHtml($text, $length, $ending = 'Read more', $exact = true, $considerHtml = true, $customizedHtml = "") {
        try{
        if ($considerHtml) {
            // if the plain text is shorter than the maximum length, return the whole text
            if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            // splits all html-tags to scanable lines
            preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';
            foreach ($lines as $line_matchings) {
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
                if (!empty($line_matchings[1])) {
                    // if it's an "empty element" with or without xhtml-conform closing slash
                    if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                        // do nothing
                        // if tag is a closing tag
                    } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                        // delete tag from $open_tags list
                        $pos = array_search($tag_matchings[1], $open_tags);
                        if ($pos !== false) {
                            unset($open_tags[$pos]);
                        }
                        // if tag is an opening tag
                    } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                        // add tag to the beginning of $open_tags list
                        array_unshift($open_tags, strtolower($tag_matchings[1]));
                    }
                    // add html-tag to $truncate'd text
                    $truncate .= $line_matchings[1];
                }
                // calculate the length of the plain text part of the line; handle entities as one character
                $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
                if ($total_length + $content_length > $length) {
                    // the number of characters which are left
                    $left = $length - $total_length;
                    $entities_length = 0;
                    // search for html entities
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                        // calculate the real length of all entities in the legal range
                        foreach ($entities[0] as $entity) {
                            if ($entity[1] + 1 - $entities_length <= $left) {
                                $left--;
                                $entities_length += strlen($entity[0]);
                            } else {
                                // no more characters left
                                break;
                            }
                        }
                    }
                    $truncate .= substr($line_matchings[2], 0, $left + $entities_length);
                    // maximum lenght is reached, so get off the loop
                    break;
                } else {
                    $truncate .= $line_matchings[2];
                    $total_length += $content_length;
                }
                // if the maximum length is reached, get off the loop
                if ($total_length >= $length) {
                    break;
                }
            }
        } else {
            if (strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = substr($text, 0, $length - strlen($ending));
            }
        }
        // if the words shouldn't be cut in the middle...
       // if (!$exact) {
            // ...search the last occurance of a space...
            $spacepos = strrpos($truncate, ' ');
            if (isset($spacepos)) {
                // ...and cut the text in this position
                $truncate = substr($truncate, 0, $spacepos);
            }
        //}
        // add the defined ending to the text
        //$truncate .= $ending;
        if ($considerHtml) {
            // close all unclosed html-tags
            $totalTags = count($open_tags);
            if ($totalTags == 0) {
                $truncate.=$customizedHtml;
            } else {
                $i = 0;
                foreach ($open_tags as $tag) {
                    $i++;
                    if ($i == $totalTags) {
                        $truncate.=$customizedHtml;
                    }
                    $truncate .= '</' . $tag . '>';
                }
            }
        }
        return $truncate;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:truncateHtml::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
   static function prepareDSNStreamObject($userId, $actionType, $postId, $categoryId, $networkName, $description, $networkLogo )
    {
        try {
            //echo "Prepare stream object";
            $streamObj = new UserStreamBean();
           
            $user_data = UserCollection::model()->getTinyUserCollection($userId);
            
            $streamObj->UserId = $userId;
            $streamObj->PostId = (String) $postId;
            $streamObj->CommentUserId = array();
            $streamObj->NetworkId = $user_data->NetworkId;
           
            $streamObj->ActionType = $actionType;
            $streamObj->CategoryType = $categoryId;
            $streamObj->FollowEntity = CommonUtility::getIndexBySystemFollowingThing('');
            
            $date = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                $streamObj->CreatedOn = $date->sec;
            $streamObj->OriginalPostTime = $date->sec;
            $streamObj->IsBlockedWordExist = isset($postObj->IsBlockedWordExist) ? $postObj->IsBlockedWordExist : 0;
            $streamObj->IsWebSnippetExist = (int) 0;
            $streamObj->NetworkLogo=$networkLogo;
           
           
                $streamObj->PostType = 17;
                
                
            $streamObj->StreamNote = $networkName." ".CommonUtility::actionTextbyActionType($streamObj->PostType);;
            
           
            /*  $descriptionLength = strlen(preg_replace('/<.*?>/', '', $postObj->Description)); */
            
            $streamObj->PostText = ($description);
           
            
          
           
            $streamObj->IsMultiPleResources = 0;
            $streamObj->OriginalUserId =0;

           
           

            
           
           
          
           
            try {
                if(isset( YII::app()->params['NetworkAdminEmail'])){
                    $netwokAdminObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType( YII::app()->params['NetworkAdminEmail'], 'Email');
                   if(isset($netwokAdminObj->UserId)){
                    $streamObj->NetworkAdminUserId=(string)($netwokAdminObj->UserId);
                   }else{
                       $streamObj->NetworkAdminUserId=0;
                   }
                }
                Yii::app()->amqp->stream(json_encode($streamObj));
            } catch (Exception $ex) {
                Yii::log("CommonUtility:prepareDSNStreamObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                error_log("Exception Occurred in CommonUtility->prepareDSNStreamObject==".$ex->getMessage());
                return FALSE;
            }
           
           
            return TRUE;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareDSNStreamObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareDSNStreamObject==".$ex->getMessage());
            return FALSE;
        }
        
    }
    
   
    static function prepareStreamObject($userId, $actionType, $postId, $categoryId, $followEntity, $commentObj, $createdDate = '') {
        try {
            //echo "Prepare stream object";
            $streamObj = new UserStreamBean();
            if ((int) $categoryId == 2) {
                $postObj = CurbsidePostCollection::model()->getPostById($postId);
            } elseif ($categoryId == 3 || $categoryId == 7) {
                $postObj = GroupPostCollection::model()->getGroupPostById($postId);
                $streamObj->Miscellaneous = $postObj->Miscellaneous;
                
            } elseif ($categoryId == 8) {
                $postObj = CuratedNewsCollection::model()->getNewsObjectById($postId);
                $streamObj->HtmlFragment = $postObj->HtmlFragment;
                $streamObj->TopicId = $postObj->TopicId;
                $streamObj->Released = $postObj->Released;
                $streamObj->Editorial = $postObj->Editorial;
                $streamObj->PublisherSource = $postObj->PublisherSource;
                $streamObj->PublicationTime = $postObj->PublicationTime;
                $streamObj->PublicationDate = $postObj->PublicationDate;
                $streamObj->PublisherSourceUrl = $postObj->PublisherSourceUrl;
                $streamObj->TopicName = $postObj->TopicName;
                $streamObj->Alignment = $postObj->Alignment;
                $streamObj->Title = $postObj->Title;
                $streamObj->TopicImage = $postObj->TopicImage;
                $streamObj->IsNotifiable = (int) $postObj->IsNotifiable;
            } else if ($categoryId == 9) {
                $postObj = GameCollection::model()->getGameDetailsObject('Id', $postId);
                $streamObj->PostId = (String) $postId;
                $streamObj->GameName = $postObj->GameName;
                $streamObj->GameDescription = $postObj->GameDescription;

                $streamObj->PlayersCount = $postObj->PlayersCount;
                $streamObj->QuestionsCount = $postObj->QuestionsCount;
                $streamObj->GameBannerImage = $postObj->GameBannerImage;
                $streamObj->AdType = $postObj->IsSponsored;
                $streamObj->BannerTitle = $postObj->BrandName;
                $streamObj->NetworkLogo = $postObj->BrandLogo;
                $streamObj->IsUseForDigest = $postObj->IsEnableSocialActions;                
                $streamObj->Resource=$postObj->Resources['ThumbNailImage'];
                if(!empty($followEntity)){
                    $scheduleDetails = ScheduleGameCollection::model()->getScheduleGameDetailsObject('Id', $followEntity); 
                    $streamObj->StartDate = $scheduleDetails->StartDate;
                    $streamObj->EndDate = $scheduleDetails->EndDate;
                }
                
                

                if ($actionType == 'Comment') {                       
                    if (isset($postObj->CurrentScheduleId) && $postObj->CurrentScheduleId!==0 ) {                      
                        $streamObj->CurrentGameScheduleId = (String) $postObj->CurrentScheduleId;
                    }
                }
                if ($actionType == 'Post') {

                    $streamObj->PreviousGameScheduleId = (String) $commentObj->_id;
                    $streamObj->CurrentGameScheduleId = (String) $postObj->CurrentScheduleId;
                    $streamObj->CurrentScheduledPlayers = array();
                    $streamObj->CurrentScheduleResumePlayers = array();
                    $streamObj->PreviousSchedulePlayers = $commentObj->Players;
                    $streamObj->PreviousScheduleResumePlayers = $commentObj->ResumePlayers;
                    $streamObj->IsNotifiable = 0;
                }

                if ($actionType == "Play") {
                    $streamObj->CurrentScheduledPlayers = $commentObj;
                    $streamObj->CurrentGameScheduleId = (String) $postObj->CurrentScheduleId;
                }
                if ($actionType == "Playing") {
                    $streamObj->CurrentScheduleResumePlayers = $userId;
                }
            }
            elseif($categoryId==10 && $postId!="")
            {//Badging
               
                    $postObj=UserBadgeCollection::model()->getUserBadgeCollectionById($postId);
         
                if($postObj!="failure" && count($postObj)>0)
                {
                  
                    $badgeObj=Badges::model()->getBadgeById($postObj->BadgeId);
                    $streamObj->Title=$badgeObj->hover_text;
                    $streamObj->BadgeName=$badgeObj->badgeName;
                    $streamObj->BadgeLevelValue=$postObj->BadgeLevelValue;
                    $streamObj->BadgeHasLevel=$badgeObj->has_level;
                    $resourceBean=new ResourceCollection();
                    $resourceBean->Extension="png";
                    $resourceBean->Uri=$badgeObj->image_path;
                    $resourceBean->ThumbNailImage=$badgeObj->image_path;;
                    $streamObj->Resource=$resourceBean;
                    $postObj->Description=$badgeObj->description;
                   
                
                 
                  
                }
                
            }elseif($categoryId==16){
                $postObj=ExtendedSurveyCollection::model()->getSurveyDetailsObject('Id',$postId);
                $streamObj->Title=$postObj->SurveyTitle;
                $streamObj->BannerContent=$postObj->SurveyLogo;
                $streamObj->ActionType=$actionType;
                $streamObj->RecentActivity=$actionType;
                $streamObj->Priority=(int)1;
            
                $streamObj->CurrentGameScheduleId=(String)$postObj->CurrentScheduleId;
                $streamObj->StreamBundle=$postObj->SurveyRelatedGroupName;
                
                
            }            
            elseif($categoryId==12)
            {//CV
                    $postObj=UserCVPublicationsCollection::model()->getUserCVPCollectionByCriteria($userId);
                    $streamObj->Title=$postObj->Title;
                    $streamObj->PostText=$postObj->Description; 
            }
             elseif($categoryId==11 && $postId!="")
            {//Badging
               
               $postObj=UserNetworkInviteCollection::model()->getUserNetworkInviteCollectionById($postId);
                if($postObj!="failure" && count($postObj)>0)
                {
                    $networkInviteInfo=  NetworkInvites::model()->getNetworkInfoId($postObj->NetworkInviteId);
                    $Oauth2Client=Oauth2Clients::model()->getOauth2ClientDetailsByCriteria("client_id",$postObj->NetworkClientId);
                  
                    $streamObj->NetworkInviteId=$postObj->NetworkInviteId;
                    $streamObj->NetworkLogo=$networkInviteInfo->NetworkLogo;
                    $streamObj->NetworkRedirectUrl=$Oauth2Client->redirect_uri;
                     $streamObj->BadgeName=$networkInviteInfo->NetworkName;
                     $postObj->Description=$networkInviteInfo->Description;
                 
                }
                
            }
            else if($categoryId==13 && $postId!=""){
                $postObj=AdvertisementCollection::model()->getAdvertisementDetailsById($postId);
                
                    $streamObj->Title=$postObj->Title;
                    $streamObj->NetworkLogo= "/images/system/networkbg_logo.png";
                    if($postObj->IsThisExternalParty==1){
                        $streamObj->Title="<b>".$postObj->ExternalPartyName."</b><span> ".$postObj->Title."</span>";
                        $streamObj->NetworkLogo= $postObj->ExternalPartyUrl;
                    }
                    
                    $resourceBean=new ResourceBean();
                    $resourceBean->Extension=$postObj->ExtensionType;
                    $resourceBean->Uri=$postObj->Url;
                    $resourceBean->ThumbNailImage=$postObj->Url;
                    $streamObj->Resource=$resourceBean;
                    $streamObj->RedirectUrl=$postObj->RedirectUrl;
                    $stdate=$postObj->StartDate;
                    $streamObj->StartDate=$stdate->sec;
                    $endDate=$postObj->ExpiryDate;
                    $streamObj->ExpiryDate=$endDate->sec;
                    $streamObj->IsNotifiable=$postObj->Status;
                    $streamObj->DisplayPage=$postObj->DisplayPage;
                    $streamObj->Groups=$postObj->GroupId;
                    $streamObj->AdvertisementId=$postObj->AdvertisementId;
                    $streamObj->RequestedParams=$postObj->RequestedParams;
                    $streamObj->BannerTemplate=$postObj->BannerTemplate;
                    $streamObj->BannerContent= $postObj->BannerContent;
                    $streamObj->BannerTitle= $postObj->BannerTitle;
                    $streamObj->ImpressionTag= $postObj->ImpressionTag;
                    $streamObj->ClickTag= $postObj->ClickTag;
                    $streamObj->StreamBundle= $postObj->StreamBundle;
                    $streamObj->BannerOptions= $postObj->BannerOptions;
                    $streamObj->Uploads= $postObj->Uploads;
                    $streamObj->Banners= $postObj->Banners;
                    $streamObj->AdSubSpeciality= $postObj->SubSpeciality;
                    $streamObj->AdCountry = $postObj->Country;
                    $streamObj->AdState= $postObj->State;
                    $streamObj->AdClassification= $postObj->Classification;
                    if($postObj->DisplayPage!="Group"){
                         $streamObj->Groups="";
                    }
                    $streamObj->RequestedFields=$postObj->RequestedFields;
                    $streamObj->AdType=$postObj->AdType;
                    if($postObj->AdType==3){
                             $streamObj->RequestedFields=$postObj->RequestedFields;
                    }
                    if($postObj->AdType == 2){
                        $streamObj->IsPremiumAd = $postObj->IsPremiumAd;
                        $streamObj->PTimeInterval = $postObj->PTimeInterval;
                    }
                          
            }
            
            
            else {
                $postObj = PostCollection::model()->getPostById($postId);
            }
               
            $user_data = UserCollection::model()->getTinyUserCollection($userId);
            $streamObj->UserId = $userId;
            $streamObj->StreamNote = '';
            $streamObj->PostId = (String) $postId;
            $streamObj->CommentUserId = array();
            if(isset($user_data->NetworkId)){
            $streamObj->NetworkId = $user_data->NetworkId;
            $streamObj->Language = $user_data->Language;
            }
            
            $streamObj->NetworkId = $postObj->NetworkId;
            $streamObj->Language = $postObj->Language;
            $streamObj->SegmentId = $postObj->SegmentId;
            
            $streamObj->PostType = $postObj->Type;
            $streamObj->ActionType = $actionType;
            $streamObj->CategoryType = $categoryId;
            $streamObj->FollowEntity = CommonUtility::getIndexBySystemFollowingThing('');
            $originalPostCreatedDate = $postObj->CreatedOn;
            $streamObj->CreatedOn = $originalPostCreatedDate->sec;
            $streamObj->OriginalPostTime = $originalPostCreatedDate->sec;
            $streamObj->IsBlockedWordExist = isset($postObj->IsBlockedWordExist) ? $postObj->IsBlockedWordExist : 0;
            $streamObj->IsWebSnippetExist = (int) $postObj->IsWebSnippetExist;
            $streamObj->WebUrls = $postObj->WebUrls;
            $streamObj->Division = $postObj->Division;
            $streamObj->District = $postObj->District;
            $streamObj->Region = $postObj->Region;
            $streamObj->Store = $postObj->Store;
            $streamObj->IsSaveItForLater=0;
            
            if ($categoryId == 10) {
                $streamObj->PostType = 13;
            }
             if ($categoryId == 11) {
                $streamObj->PostType = 14;
            }
            if ($categoryId == 16) {
                $streamObj->PostType = 19;
            }
            /*  $descriptionLength = strlen(preg_replace('/<.*?>/', '', $postObj->Description)); */
            if ($categoryId == 9) {
                $tagsFreeDescription = strip_tags(($postObj->GameDescription));
                $date = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                $streamObj->CreatedOn = $date->sec;
            } else {
                $tagsFreeDescription = strip_tags(($postObj->Description));
            }

            $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
            $descriptionLength = strlen($tagsFreeDescription);
            if ($descriptionLength >= '500') {
                $length = '500';
            } else {

                $length = '240';
            }
            if ($categoryId == 9) {
                $description = CommonUtility::truncateHtml($postObj->GameDescription, $length);
            } else {
                $description = CommonUtility::truncateHtml($postObj->Description, $length);
            }
            $streamObj->PostText = trim($description);
            if($categoryId!=10 && $categoryId!=9  &&  $categoryId!=13)
            {
            if (sizeof($postObj->Resource) == 0) {
                $streamObj->Resource = '';
            } else {
                $streamObj->Resource = $postObj->Resource[0];
            }
            }
            
            $streamObj->PostTextLength = $descriptionLength;
            if ($categoryId == 9) {
                $streamObj->PostText = $postObj->GameDescription;
            } else {
                $streamObj->PostText = $postObj->Description;
            }
            
            $streamObj->IsMultiPleResources = sizeof($postObj->Resource);
            $streamObj->OriginalUserId = $postObj->UserId;

            $streamObj->MentionArray = $postObj->Mentions;
            $streamObj->HashTags = $postObj->HashTags;
            if ($postObj->Type == 2) {
                $streamObj->Title = $postObj->Title;
                $streamObj->EventAttendes = (int)$postObj->UserId;
                $streamObj->StartDate = $postObj->StartDate->sec;
                $streamObj->EndDate = $postObj->EndDate->sec;
                $streamObj->StartTime = $postObj->StartTime;
                $streamObj->EndTime = $postObj->EndTime;
                $streamObj->Location = $postObj->Location;
                $streamObj->Title = $postObj->Title;
            }
            if ($postObj->Type == 3) {
                $streamObj->Title = $postObj->Title;
                $streamObj->OptionOne = $postObj->OptionOne;
                $streamObj->OptionTwo = $postObj->OptionTwo;
                $streamObj->OptionThree = $postObj->OptionThree;
                $streamObj->OptionFour = $postObj->OptionFour;
                $streamObj->ExpiryDate = $postObj->ExpiryDate->sec;
                $streamObj->OptionOneCount = (int) $postObj->OptionOneCount;
                $streamObj->OptionTwoCount = (int) $postObj->OptionTwoCount;
                $streamObj->OptionThreeCount = (int) $postObj->OptionThreeCount;
                $streamObj->OptionFourCount = (int) $postObj->OptionFourCount;
                $streamObj->Title = $postObj->Title;
            }

            if ($actionType == "Comment") {
                $streamObj->HashTags = $commentObj->HashTags;
                $streamObj->MentionArray = $commentObj->Mentions;
                $commentObj->CommentFullText = $commentObj->CommentText;
                /*   $descriptionLength=strlen(preg_replace('/<.*?>/', '', $commentObj->CommentText)); */
                $tagsFreeDescription = strip_tags(($commentObj->CommentText));
                $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
                $descriptionLength = strlen($tagsFreeDescription);
                if ($descriptionLength >= '500') {

                    $length = '500';
                } else {

                    $length = '240';
                }
                if($categoryId != 2){
                    $description = CommonUtility::truncateHtml($commentObj->CommentText, $length);
                }else{
                    $description = $commentObj->CommentText;
                }
                $streamObj->CreatedOn = $commentObj->CreatedOn;
                $commentObj->CommentText = $description;
                $commentObj->CommentTextLength = $descriptionLength;

                $streamObj->IsBlockedWordExistInComment = isset($postObj->IsBlockedWordExistInComment) ? $postObj->IsBlockedWordExistInComment : 0;
                $streamObj->Comments = $commentObj;
                $streamObj->RecentAcivity = "Comment";
                if ((int) $categoryId != 2) {
                    if (isset($postObj->EventAttendes) && sizeof($postObj->EventAttendes) > 0) {
                        if (in_array((int) $userId, $postObj->EventAttendes)) {
                            $streamObj->EventAttendes = (int) $userId;
                        }
                    }
                    if (isset($postObj->SurveyTaken) && sizeof($postObj->SurveyTaken) > 0) {
                        if (in_array((int) $userId, $postObj->SurveyTaken)) {
                            $streamObj->SurveyTaken = (int) $userId;
                        }
                    }
                }
                if (isset($postObj->Love) && sizeof($postObj->Love) > 0) {
                    if (in_array((int) $userId, $postObj->Love)) {
                        $streamObj->LoveUserId = (int) $userId;
                    }
                }
                if (isset($postObj->Followers) && sizeof($postObj->Followers) > 0) {
                    if (in_array((int) $userId, $postObj->Followers)) {
                        $streamObj->PostFollowers = (int) $userId;
                    }
                }
                if (isset($postObj->FbShare) && sizeof($postObj->FbShare) > 0) {
                    if (in_array((int) $userId, $postObj->FbShare)) {
                        $streamObj->FbShare = (int) $userId;
                    }
                }
                if (isset($postObj->TwitterShare) && sizeof($postObj->TwitterShare) > 0) {
                    if (in_array((int) $userId, $postObj->TwitterShare)) {
                        $streamObj->TwitterShare = (int) $userId;
                    }
                }
            }
            if ($actionType == "EventAttend") {
                $streamObj->EventAttendes = (int) $userId;
                $streamObj->CreatedOn = strtotime(date('Y-m-d H:i:s', time()));
                if (!empty($createdDate)) {
                    $streamObj->CreatedOn = strtotime(date($createdDate, time()));
                }
            }
            if ($actionType == "Love") {
                $streamObj->LoveUserId = (int) $userId;
                $streamObj->RecentAcivity = "Love";
                $streamObj->CreatedOn = strtotime(date('Y-m-d H:i:s', time()));
                if (!empty($createdDate)) {
                    $streamObj->CreatedOn = strtotime(date($createdDate, time()));
                }
            }
            if ($actionType == "Follow") {
                $streamObj->PostFollowers = (int) $userId;
                $streamObj->CreatedOn = strtotime(date('Y-m-d H:i:s', time()));
                if (!empty($createdDate)) {
                    $streamObj->CreatedOn = strtotime(date($createdDate, time()));
                }
            }
            if ($actionType == "UnFollow") {
                $streamObj->PostFollowers = (int) $userId;
            }
            if ($actionType == "Survey") {
                $streamObj->SurveyTaken = (int) $userId;
                $streamObj->CreatedOn = strtotime(date('Y-m-d H:i:s', time()));
                if (!empty($createdDate)) {
                    $streamObj->CreatedOn = strtotime(date($createdDate, time()));
                }
            }
            if ($actionType == "Invite") {
                $inviteobj = $postObj->Invite[sizeof($postObj->Invite) - 1];
                $streamObj->InviteUsers = $inviteobj[1];
                $streamObj->InviteMessage = $inviteobj[2];
                $streamObj->CreatedOn = strtotime(date('Y-m-d H:i:s', time()));
                if (!empty($createdDate)) {
                    $streamObj->CreatedOn = strtotime(date($createdDate, time()));
                }
            }
            if ($actionType == "FbShare") {
                $streamObj->FbShare = (int) $userId;
                $streamObj->CreatedOn = strtotime(date('Y-m-d H:i:s', time()));
                if (!empty($createdDate)) {
                    $streamObj->CreatedOn = strtotime(date($createdDate, time()));
                }
            }
            if ($actionType == "TwitterShare") {
                $streamObj->TwitterShare = (int) $userId;
                $streamObj->CreatedOn = strtotime(date('Y-m-d H:i:s', time()));
                if (!empty($createdDate)) {
                    $streamObj->CreatedOn = strtotime(date($createdDate, time()));
                }
            }
            $streamObj->OriginalUserId = (int) $postObj->UserId;
            $streamObj->LoveCount = (int) count($postObj->Love);
            $count = 0;
            if (count($postObj->Comments) > 0) {
                foreach ($postObj->Comments as $key => $value) {
                    $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
                    $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
                    if(!$IsBlockedWordExist && !$IsAbused){
                        $count++;
                    }
                }
            }
            $streamObj->CommentCount = $count;
            $streamObj->FollowCount = (int) count($postObj->Followers);
            $streamObj->InviteCount = (int) count($postObj->Invite);
            $fbCount = 0;
            $twitterCount = 0;
            if (isset($postObj->FbShare) && sizeof($postObj->FbShare) > 0) {
                $fbCount = (int) count($postObj->FbShare);
            }
            if (isset($postObj->TwitterShare) && sizeof($postObj->TwitterShare) > 0) {
                $twitterCount = (int) count($postObj->TwitterShare);
            }
            $streamObj->ShareCount = $fbCount + $twitterCount;
            $streamObj->DisableComments = isset($postObj->DisableComments) ? $postObj->DisableComments : 0;
           

            if ((int) $categoryId == 3) {
                $streamObj->GroupId = (String) $postObj->GroupId;
                $groupDetails = GroupCollection::model()->getGroupDetailsById($streamObj->GroupId);
                $streamObj->ShowPostInMainStream = 1;
                $streamObj->IsPrivate = $groupDetails->IsPrivate;
            }
            if ((int) $categoryId == 7) {
                $streamObj->GroupId = (String) $postObj->GroupId;
                $streamObj->SubGroupId = (String) $postObj->SubGroupId;
                $subGroupDetails = SubGroupCollection::model()->getSubGroupDetailsById($postObj->SubGroupId);
                if (is_object($subGroupDetails)) {
                    $streamObj->ShowPostInMainStream = $subGroupDetails->ShowPostInMainStream;
                }
            }

            if ((int) $categoryId == 2) {
                if ($postObj->IsFeatured == 1) {
                    $streamObj->IsFeatured = $postObj->IsFeatured;
                    $streamObj->FeaturedUserId = (int) $postObj->UserId;
                    $streamObj->FeaturedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                }

                $streamObj->CurbsideConsultTitle = $postObj->Subject;
                $curbsideCategoryObj = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId((int) $postObj->CategoryId);
                $streamObj->CurbsideConsultCategory = "<a style='cursor:pointer' data-id='$postObj->CategoryId' class='curbsideCategory'><b>$curbsideCategoryObj->CategoryName</b></a>";
                $streamObj->CurbsideCategoryId = $postObj->CategoryId;
            }
            if ((int) $categoryId == 1) {
                if ($postObj->IsFeatured == 1) {
                    $streamObj->IsFeatured = $postObj->IsFeatured;
                    $streamObj->FeaturedUserId = (int) $postObj->UserId;
                    $streamObj->FeaturedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
                }
            }
            if ($categoryId == 9) {
                $streamObj->CreatedOn = $createdDate == "" ? $streamObj->CreatedOn : $createdDate;
            }
            if($categoryId==10 || $categoryId==13 )
            {
                    $streamObj->IsMultiPleResources=1;
            }
            if(isset($postObj->IsAnonymous)){
               $streamObj->IsAnonymous = $postObj->IsAnonymous; 
            }
            if(isset($postObj->IsUseForDigest)){
               $streamObj->IsUseForDigest = $postObj->IsUseForDigest; 
            }
           
           
            try {
                if(isset( YII::app()->params['NetworkAdminEmail'])){
                    $netwokAdminObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType( YII::app()->params['NetworkAdminEmail'], 'Email');
                   if(isset($netwokAdminObj->UserId)){
                    $streamObj->NetworkAdminUserId=(string)($netwokAdminObj->UserId);
                   }else{
                       $streamObj->NetworkAdminUserId=0;
                   }
                }
                //error_log($streamObj->UserId."==================@@@@======================^^^^^^^^^^^^^^^^^^");
                Yii::app()->amqp->stream(json_encode($streamObj));
            } catch (Exception $ex) {
                Yii::log("CommonUtility:prepareStreamObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                error_log("Exception Occurred in CommonUtility->prepareStreamObject==".$ex->getMessage());
                return FALSE;
            }
           
           
            return TRUE;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareStreamObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareStreamObject==".$ex->getMessage());
            return FALSE;
        }
    }

    static function registerClientScript($path = '', $js = '') {
        try{
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl . '/js/' . $path . $js);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:registerClientScript::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function registerClientCss($path = 'simplePagination/', $css = 'simplePagination.css') {
        try{
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/css/' . $path . $css);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:registerClientCss::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function IsArrayElementsExistsInString($input, array $referers) {
        try{
        foreach ($referers as $referer) {
            if (preg_match("/\b$referer\b/i", $input)) {
                return true;
            }
        }
        return false;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:IsArrayElementsExistsInString::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function prepareStreamObjectForFollowEntity($userId, $actionType, $followId, $categoryType, $followEntity, $createdDate = '') {
        try {
            /**
             * category 4 is user profile category, geeting user details from here
             * category 5 hashtag,
             * category 2 is curbside
             * category 3 is group , here no need group detail so we  have get group data
             */
            if ($categoryType == 4) {
                $obj = UserProfileCollection::model()->getUserProfileCollection((int) $userId);
            } else if ($categoryType == 5) {
                $obj = HashTagCollection::model()->getHashTagsById($followId);
            } else if ($categoryType == 6) {
                $obj = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId($followId);
            }

            $streamObj = new UserStreamBean();
            $streamObj->UserId = (int) $userId;
            if (isset($createdDate) && !empty($createdDate)) {
                $streamObj->CreatedOn = strtotime(date($createdDate, time()));
            }
            /**
             * as per convinent of stream (already defined) , so we add postcollecton  id into post Id.
             * post type user.
             */
            $user_data = UserCollection::model()->getTinyUserCollection($userId);
            $streamObj->NetworkId = $user_data->NetworkId;
            $streamObj->FollowEntity = $followEntity;
            $streamObj->CategoryType = $categoryType;
            $streamObj->ActionType = $actionType;
            $streamObj->RecentActivity = $actionType;



            /**
             * follow Object  post type
             * post type user is 6
             * post type hashtag 7
             * post type curbsidecategory 8
             * post  type group 9
             * 
             * follow entity id's Post is 1
             * Group 2
             * User 3
             * Hashtag 4
             * Curbside category 5 
             * 
             */
            /**
             * @commented on 5th march 2014 Reddy
             * we should show hashtag followers count, curbside followers count in home stream 
             * show in ealier we are inserted  post counts and showing post count in home strem, now we are change to followers count but we are use same parameters. 
             */
            if ($actionType == "UserFollow" || $actionType == "UserUnFollow") {
                $streamObj->PostType = CommonUtility::sendPostType("User");
                $streamObj->PostId = $obj->_id;
                $streamObj->UserFollowers = (int) $followId;
            }

            if ($actionType == "HashTagFollow" || $actionType == "HashTagUnFollow") {
                $streamObj->PostType = CommonUtility::sendPostType("HashTag");

                $streamObj->PostId = $followId;
                $streamObj->HashTagId = $followId;
                $streamObj->HashTagName = $obj->HashTagName;
                $streamObj->HashTagPostCount = (int) count($obj->HashTagFollowers);
            }
            if ($actionType == "GroupFollow" || $actionType == "GroupUnFollow") {
                $streamObj->PostType = CommonUtility::sendPostType("Group");
                $streamObj->PostId = (string) $followId;
                $streamObj->GroupId = (string) $followId;
                $streamObj->GroupFollowers = (int) $userId;
            }
            if ($actionType == "SubGroupFollow" || $actionType == "SubGroupUnFollow") {
                $streamObj->PostType = CommonUtility::sendPostType("SubGroup");
                $streamObj->PostId = (String) $followId;
                $streamObj->SubGroupId = (String) $followId;
                $streamObj->SubGroupFollowers = (int) $userId;
            }
            if ($actionType == "CurbsideCategoryFollow" || $actionType == "CurbsideCategoryUnFollow") {
                $streamObj->PostType = CommonUtility::sendPostType("CurbsideCategory");
                $streamObj->CurbsideConsultCategory = $obj->CategoryName;
                $streamObj->CurbsidePostCount = count($obj->Followers);
                $streamObj->CurbsideCategoryId = $followId;
                $streamObj->PostId = (String) $obj->_id;
                $streamObj->CurbsideCategoryFollowers = (int) $userId;
            }

            try {
                Yii::app()->amqp->stream(json_encode($streamObj));
            } catch (Exception $ex) {
                Yii::log("CommonUtility:prepareStreamObjectForFollowEntity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                error_log("Exception Occurred in CommonUtility->prepareStreamObjectForFollowEntity==".$ex->getMessage());
            }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareStreamObjectForFollowEntity::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function getUserPrivilege() {
        try {
            $privileges = Yii::app()->session['UserPrivileges'];
            $privilegeBean = new PrivilegeBean();
            foreach ($privileges as $privilege) {
                if ($privilege['Status'] == 1) {
                    if ($privilege['Action'] == 'Create_Group')
                        $privilegeBean->canCreateGroup = 1;
                    if ($privilege['Action'] == 'Survey')
                        $privilegeBean->canSurvey = 1;
                    if ($privilege['Action'] == 'Event')
                        $privilegeBean->canEvent = 1;
                    if ($privilege['Action'] == 'Delete')
                        $privilegeBean->canDelete = 1;
                    if ($privilege['Action'] == 'Promote_To_Featured_Items')
                        $privilegeBean->canFeature = 1;
                    if ($privilege['Action'] == 'Private_Messaging')
                        $privilegeBean->canMessage = 1;
                    if ($privilege['Action'] == 'Manage_Flagged_Posts')
                        $privilegeBean->canManageFlaggedPost = 1;
                    if ($privilege['Action'] == 'Mark_As_Abuse')
                        $privilegeBean->canAbuse = 1;
                    if ($privilege['Action'] == 'Promote_Post')
                        $privilegeBean->canPromote = 1;
                    if ($privilege['Action'] == 'Manage_Post')
                        $privilegeBean->canManagePost = 1;
                    if ($privilege['Action'] == 'Abuse_Scan')
                        $privilegeBean->canManageAbuseScan = 1;
                    if ($privilege['Action'] == 'Analytics')
                        $privilegeBean->canViewAnalytics = 1;
                    if ($privilege['Action'] == 'Digest_Use')
                        $privilegeBean->Digest_Use = 1;
                }
                  if ($privilege['Action'] == 'Can_Copy_URL')
                    $privilegeBean->canCopyURL = 1;
            }
            return $privilegeBean;
        } catch (Exception $ex) {
           Yii::log("CommonUtility:getUserPrivilege::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application'); 
        }
    }

    /**
     * @author Sagar pathepalli 
     * @param type $streamPostData
     * @return array
     * 
     */
    static function prepareProfileIntractionData($UserId, $streamPostData) {
        try {
            $streamIdArray = array();
            $groupNameObject = "";
            $isGroupPostAdmin = "false";
            foreach ($streamPostData as $key => $data) {

                if (($data->PostType < 7 || $data->PostType == 11 || $data->PostType == 12) && $data->RecentActivity != "UnFollow" ) {
                  
                    if($data->IsAnonymous==1 && (trim($data->StreamNote) == "made" || trim($data->StreamNote) == "created" || trim($data->StreamNote) == "posted" )){
                      unset($streamPostData[$key]);
                  }else{
                    $data->SessionUserId = $UserId;
                    $isPromoted = isset($data->IsPromoted) ? $data->IsPromoted : 0;
                    $createdOn = $data->CreatedOn;
                    $originalPostTime = $data->OriginalPostTime;
                    $data->PostOn = CommonUtility::styleDateTime($createdOn->sec);
                    $postType = CommonUtility::postTypebyIndex($data->PostType, $data->CategoryType);
                    $data->PostTypeString = $postType;
                    $createdOn = $data->CreatedOn;
                    if ($data->GroupId != '') {
                        $isGroupPostAdmin = ServiceFactory::getSkiptaPostServiceInstance()->checkIsGroupAdminById($data);
                        $groupNameObject = ServiceFactory::getSkiptaPostServiceInstance()->getGroupNameById($data->GroupId);
                        $data->ConversationVisibility = $groupNameObject->ConversationVisibility;
                        if ($isGroupPostAdmin == 'true' && $groupNameObject->ConversationVisibility == 0) {
                            unset($streamPostData[$key]);
                            continue;
                        }

                        $data->isGroupAdminMember = $isGroupPostAdmin;
                        
                            if ($groupNameObject->GroupMembers != null) {
                            $isFollowingGroup = in_array($UserId, $groupNameObject->GroupMembers);
                        } else {
                            $isFollowing = 0;
                        }
                        
                        if($groupNameObject->IsIFrameMode == 1 || ($groupNameObject->CustomGroup == 1 && $groupNameObject->IsHybrid == 0)){
                            $data->ConversationVisibility = 1;
                        }                        
                        if ($isFollowingGroup == 0) {
                            unset($streamPostData[$key]);
                            continue;
                        }                        
                        //if($data->IsGroupPostVisible == 0){
                            $data->MainGroupName = $groupNameObject->GroupName;
                            $data->MainGroupId = $groupNameObject->_id;
                            $data->GroupProfileImage = $groupNameObject->GroupProfileImage;
                           if (isset($groupNameObject->AddSocialActions)) {
                                        $data->AddSocialActions = $groupNameObject->AddSocialActions;
                                    }
                             /*
                              * KOL post start
                              */       
                              if(isset($data->Miscellaneous) && $data->Miscellaneous == 1){//KOL Post
                                $data->AddSocialActions = 0;
                              
                            } 
                               /*
                              * KOL post end
                              */ 
                            $grouptagsFreeDescription = strip_tags(($groupNameObject->GroupDescription));
                            $grouptagsFreeDescription = str_replace("&nbsp;", " ", $grouptagsFreeDescription);

                            $groupdescriptionLength = strlen($grouptagsFreeDescription);
                            if ($groupdescriptionLength > 240) {
                                $groupdescription = CommonUtility::truncateHtml($groupNameObject->GroupDescription, 240);
                                $data->GroupDescription = trim($groupdescription) . Yii::t('translation','Readmore');
                            } else {
                                $data->GroupDescription = $groupNameObject->GroupDescription;
                            }
                            $data->GroupDescription = CommonUtility::findUrlInStringAndMakeLink($data->GroupDescription);
                            if ($isGroupPostAdmin == 'true') {
                                if ($groupNameObject != 'failure') {
                                    $mainGroupCollection = $groupNameObject;
                                    if ($groupNameObject->IsPrivate == 1) {
                                        $groupsDataArray['groupMembers'] = $groupNameObject->GroupMembers;

                                        if($groupNameObject->GroupMembers != null ){
                                        $isFollowing = in_array($UserId, $groupNameObject->GroupMembers);
                                        }else{
                                           $isFollowing=0; 
                                        }

                                        if ($isFollowing == 1) {
                                            $data->ShowPrivateGroupPost = 1;
                                        } else {
                                            $data->ShowPrivateGroupPost = 0;
                                            unset($streamPostData[$key]);
                                            continue;
                                        }
                                    } else {
                                        $data->ShowPrivateGroupPost = 1;
                                    }
                                }
                            }
                        //}
                        
                    }
                    $recentActivityUser1 = UserCollection::model()->getTinyUserCollection($data->UserId);
                    


                    $textWithOutHtml = $data->PostText;
                    $textLength = strlen($textWithOutHtml);
                    if (isset($data->PostTextLength) && $data->PostTextLength > 240 && $data->PostTextLength < 500) {

                        $appendData = '<span    onclick="expandpostDiv(' . "'" . $data->_id . "'" . ')"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                    } else {

                        $appendData = ' <span class="postdetail"  data-id="' . $data->_id . '" data-postid="' . $data->PostId . '" data-categoryType="' . $data->CategoryType . '" data-postType="' . $data->PostType . '"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                    }
                    if (isset($data->PostTextLength) && ($data->PostTextLength == 240 || $data->PostTextLength > 500)) {
                        // $description = CommonUtility::truncateHtml($textWithOutHtml, 240,$appendData);
                        $description = CommonUtility::truncateHtml($textWithOutHtml, 240, 'Read more', true, true, $appendData);
                        $text = $description;
                        $data->PostText = $text;
                    }
                    if (isset($data->OriginalUserId) && $data->OriginalUserId != $data->UserId) {
                        $originalPostTime = $data->OriginalPostTime;
                        $data->OriginalPostPostedOn = CommonUtility::styleDateTime($originalPostTime->sec);
                        $tinyOriginalUser = UserCollection::model()->getTinyUserCollection($data->OriginalUserId);
                        $data->OriginalUserDisplayName = $tinyOriginalUser['DisplayName'];
                        $data->OriginalUserProfilePic = $tinyOriginalUser['profile250x250'];
                    }
                    $displayName1 = ($UserId == $recentActivityUser1['UserId']) ? 'You' : $recentActivityUser1['DisplayName'];
                    $data->UserDisplayName = $displayName1;
                    $data->UserProfilePic = $recentActivityUser1['profile250x250'];
                    if($data->PostFollowers!=null){
                    $data->IsFollowingPost = in_array($UserId, $data->PostFollowers);
                    }
                    $data->FollowersCount = $data->FollowCount;
                    if($data->LoveUserId!=null){
                    $data->IsLoved = in_array($UserId, $data->LoveUserId);
                    }
                    
                    $data->IsSurveyTaken = $data->RecentActivity == "Survey" ? 1 : 0;
                    $data->TotalSurveyCount = $data->OptionOneCount + $data->OptionTwoCount + $data->OptionThreeCount + $data->OptionFourCount;
                    if ($data->ActionType == 'Comment' && $data->Comments) {
                        $commentsSize = sizeof($data->Comments);
                        $data->CommentMessage = $data->Comments[$commentsSize - 1]['CommentText'];
                    }
                    $commentedUsers = UserStreamCollection::model()->getCommentedUsersForPost($data->PostId, $UserId);
                  
                    if($commentedUsers!=null){
                      $IsUserCommented = in_array((int) $UserId, $commentedUsers);  
                       $data->IsCommented = $IsUserCommented;
                    }
                   
                    
                   
                    $image = "";
                    if ($data->IsMultiPleResources > 0) {
                        if (isset($data->Resource["ThumbNailImage"])) {
                            if (isset($data->Resource['ThumbNailImage'])) {
                                $image = $data->Resource['ThumbNailImage'];
                            } else {
                                $image = "";
                            }
                        }

                        $data->ArtifactIcon = $image;
                        $data->Extension = $data->Resource["Extension"];
                    }

                    if ($data->PostType == 2) {
                        $eventStartDate = $data->StartDate;
                        $eventEndDate = $data->EndDate;
                        $data->Title = $data->Title;
                        $data->StartDate = date("Y-m-d", $eventStartDate->sec);
                        $data->EndDate = date("Y-m-d", $eventEndDate->sec);
                        $data->EventStartDay = date("d", $eventStartDate->sec);
                        $data->EventStartDayString = date("l", $eventStartDate->sec);
                        $data->EventStartMonth = date("M", $eventStartDate->sec);
                        $data->EventStartYear = date("Y", $eventStartDate->sec);
                        $data->EventEndDay = date("d", $eventEndDate->sec);
                        $data->EventEndDayString = date("l", $eventEndDate->sec);
                        $data->EventEndMonth = date("M", $eventEndDate->sec);
                        $data->EventEndYear = date("Y", $eventEndDate->sec);
                        $data->IsEventAttend = 1;
                        if ($eventEndDate->sec <= time()) {
                            $data->CanPromotePost = 0;
                        }
                    } elseif ($data->PostType == 3) {
                        $surveyExpiryDate = $data->ExpiryDate;
                        $data->Title = $data->Title;
                        if (isset($surveyExpiryDate->sec) && $surveyExpiryDate->sec <= time()) {
                            $data->CanPromotePost = 0;
                            $data->ExpiryDate = date("Y-m-d", $surveyExpiryDate->sec);
                        }
                    }
                    if ($data->SessionUserId == $data->UserId) {
                        if (trim($data->StreamNote) == "is following") {
                            $data->StreamNote = " are following ";
                        }
                        if (trim($data->StreamNote) == "is attending") {
                            $data->StreamNote = " are attending ";
                        }
                        if (trim($data->StreamNote) == "has answered") {
                            $data->StreamNote = " have answered ";
                        }
                        if (trim($data->StreamNote) == "has been invited to") {
                            $data->StreamNote = " have been invited  to ";
                        }
                        if (trim($data->StreamNote) == "has invited to") {
                            if(isset($data->InviteUsers)){
                             $tinyOriginalUser = UserCollection::model()->getTinyUserCollection($data->InviteUsers);   
                            }                            
                            $InviteUserName=$tinyOriginalUser['DisplayName'];
                            $data->StreamNote = " have invited  <a style='cursor:pointer' data-id='". $data->InviteUsers ."' class='userprofilename'><b>". $InviteUserName." </b></a> to";
                        }
                        if (trim($data->StreamNote) == "has Played") {
                            $data->StreamNote = " have Played ";
                        }
                        if (trim($data->StreamNote) == "has Resume") {
                            $data->StreamNote = " have Resumed ";
                        }
                    }
                    
                    /**************Stream messages preperation*******Start*********/
                    $categoryType = $data->CategoryType;
                    $postTypeId = $data->PostType;
                    $recentActivity = $data->RecentActivity;
                    $isAnonymous = $data->IsAnonymous;
                    $isMine = 0;
                    if($UserId==$data->UserId){
                        $isMine = 1;
                    }
                    $badgeName = "";
                    if ($data->CategoryType == 10) {
                        $networkUrl = $data->NetworkRedirectUrl;
                        $networkUrl = split("/site", $networkUrl);
                        $badgeName = "<a href='$networkUrl[0]' target='_blank'>". Yii::t('posttypes',$data->BadgeName."Badge"). "</a>";
                    }
                    $cvType = "";
                    if ($data->CategoryType == 12) {
                        $cvType = $data->Title;
                    }        
                    $invitedUsers = "";
                    $isInvited = 0;
                    if($recentActivity=="Invite"){
                        if(isset($data->InviteUsers)){
                            $tinyOriginalUser = UserCollection::model()->getTinyUserCollection($data->InviteUsers);   
                        }                         
                        if($data->Priority!=0){
                            $isInvited = 1;
                        }
                        $InviteUserName=$tinyOriginalUser['DisplayName'];
                        $invitedUsers = "<a style='cursor:pointer' data-id='". $data->InviteUsers ."' class='userprofilename'><b>". $InviteUserName." </b></a>";
                    }
                    
                    $streamMessage = "";
                    $streamMessage = CommonUtility::getStreamNote($categoryType, $postTypeId, $recentActivity, $isAnonymous, $isMine, $badgeName, $cvType, $invitedUsers, $isInvited, 1);
                    if($streamMessage!=""){
                        $data->StreamNote = $streamMessage;
                    }
                    /**************Stream messages preperation*******End*********/
                    
                    
                $data->PostText = CommonUtility::findUrlInStringAndMakeLink($data->PostText);
                $lovefollowArray =  CommonUtility::getLoveAndFollowUsers($UserId,$data->LoveUserId,$data->PostFollowers);
                 $data->loveUsersArray = $lovefollowArray["loveUsersArray"];
                 $data->followUsersArray = $lovefollowArray["followUsersArray"];        
         
                }
                } else {
                    unset($streamPostData[$key]);
                }
            }

            return $streamPostData;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareProfileIntractionData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function FindElementAndReplace($input, array $arrayElements) {
        try{
        $arrayReplaceElements = array();
        $abuseWords = array();
        for ($i = 0; $i < sizeof($arrayElements); $i++) {
            $abuseWords[$i] = "/\b$arrayElements[$i]\b/i";
            $arrayReplaceElements[$i] = "<span contenteditable='false' class='atmention_error dd-tags'><b>" . $arrayElements[$i] . "</b></span>";
        }
        $output = preg_replace($abuseWords, $arrayReplaceElements, $input);
        return $output;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:FindElementAndReplace::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function FindHashTagAndReplace($input, array $arrayElements) {
        try{
        $arrayReplaceElements = array();
        $hashtags = array();
        for ($i = 0; $i < sizeof($arrayElements); $i++) {
            $ele = $arrayElements[$i];
            $hashtags[$i] = "/\b#$ele\b/i";
            $arrayReplaceElements[$i] = "<span class=\"dd-tags hashtag\"><b>#$arrayElements[$i]</b></span>";
        }
        $output = preg_replace($hashtags, $arrayReplaceElements, $input);
        return $output;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:FindHashTagAndReplace::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function reloadUserPrivilegeAndData($userId) {
        try{
        $userPrivileges = ServiceFactory::getSkiptaUserServiceInstance()->getUserActionsByUserType($userId, Yii::app()->session['UserStaticData']->UserTypeId);
        Yii::app()->session['UserPrivileges'] = $userPrivileges;
        Yii::app()->session['UserPrivilegeObject'] = CommonUtility::getUserPrivilege();
        Yii::app()->session['UserStaticData'] = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType(Yii::app()->session['UserStaticData']->Email, 'Email');
        Yii::app()->session['IsAdmin'] = Yii::app()->session['UserStaticData']->UserTypeId;
        if(isset(YII::app()->params['IsMultipleSegment']) && YII::app()->params['IsMultipleSegment']==1){
            $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userId);
            $segmentChanged = $tinyUserCollectionObj['SegmentId']!=Yii::app()->session['TinyUserCollectionObj']['SegmentId']?true:false;
            $languageChanged = $tinyUserCollectionObj['Language']!=Yii::app()->session['TinyUserCollectionObj']['Language']?true:false;
            if($segmentChanged || $languageChanged){
                if($segmentChanged){
                    $attributeArray = array("SegmentId" => $tinyUserCollectionObj['SegmentId']);
                    Yii::app()->session['CurrentSegment'] = ServiceFactory::getSkiptaUserServiceInstance()->getSegmentByAttributes($attributeArray);
                }
                if($languageChanged){
                    $language = (isset($tinyUserCollectionObj['Language']) && $tinyUserCollectionObj['Language']!="")?$tinyUserCollectionObj['Language']:"en";
                    CommonUtility::changeLanguage($language); 
                }
                Yii::app()->session['TinyUserCollectionObj'] = $tinyUserCollectionObj;
            }
        }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:reloadUserPrivilegeAndData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function generateRandomString($length = 10) {
        try{
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:generateRandomString::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * 
     * @param type $type
     * @return int
     */
    static function postStringTypebyIndex($type, $isGroupCategory = 0) {
        try {

            $returnValue = 0;
            if ($type == 1) {
                $returnValue = '  Post';
            } else if ($type == 2) {
                $returnValue = '  Event ';
            } else if ($type == 3) {
                $returnValue = ' Survey ';
            } else if ($type == 4) {
                // Anonymous Post
                $returnValue = '  Post ';
            } else if ($type == 5) {
                $name = Yii::t('translation', 'CurbsideConsult');
                $returnValue = "  $name ";
            } else if ($type == 6) {
                $returnValue = '  Group ';
            } else if ($type == 7) {
                $returnValue = '  SubGroup ';
            } else if ($type == 11) {
                $returnValue = ' News ';
            } else if ($type == 12) {
                $returnValue = ' Game ';
            }
            else if ($type == 13) {
                $returnValue = ' Badge ';
            }

            if ($isGroupCategory == 3) {
                if ($type == 1) {
                    $returnValue = '  Group Post';
                } else if ($type == 2) {
                    $returnValue = '  Group Event ';
                } else if ($type == 3) {
                    $returnValue = '  Group Survey ';
                }
            }
            if ($isGroupCategory == 7) {
                if ($type == 1) {
                    $returnValue = '  SubGroup Post';
                } else if ($type == 2) {
                    $returnValue = '  SubGroup Event ';
                } else if ($type == 3) {
                    $returnValue = ' SubGroup Survey ';
                }
            }
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:postStringTypebyIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /** @author Vamsi Krishna 
     * THis method is used to prepare featured items 
     * @param type $userId
     * @param type $abusedPostData
     * @param type $categoryType
     * @return type
     */
    static function prepareFeaturedPostData($userId, $abusedPostData, $categoryType) {
        try {
            foreach ($abusedPostData as $data) {
                if ((int) $data->CategoryType == 2) {
                    $postObj = CurbsidePostCollection::model()->getPostById($data->PostId);
                } else if ((int) $data->CategoryType == 8) {
                    $postObj = CuratedNewsCollection::model()->getPostById($data->PostId);
                } else if ((int) $data->CategoryType == 9) {
                    $postObj = GameCollection::model()->getPostById($data->PostId);
                } else {
                    $postObj = PostCollection::model()->getPostById($data->PostId);
                }

                $tinyOriginalUser = UserCollection::model()->getTinyUserCollection($postObj->UserId);
                $data->OriginalUserDisplayName = $tinyOriginalUser['DisplayName'];
                $data->OriginalUserProfilePic = $tinyOriginalUser['profile250x250'];
                $data->OriginalUserId = $data->UserId;
                $originalPostTime = $data->CreatedOn;
                $data->Type = $postObj->Type;
                $data->OriginalPostPostedOn = CommonUtility::styleDateTime($originalPostTime->sec);
                $postType = CommonUtility::postTypebyIndex($data->Type, $data->CategoryType);
                $data->PostTypeString = $postType;
                $image = "";
                $filetype = "";
                if (sizeof($postObj->Resource) > 0) {
                    $filetype = isset($postObj->Resource[sizeof($postObj->Resource) - 1]["Extension"]) ? $postObj->Resource[sizeof($postObj->Resource) - 1]["Extension"] : "";
                    if (isset($postObj->Resource[sizeof($postObj->Resource) - 1]["ThumbNailImage"])) {
                        $image = $postObj->Resource[sizeof($postObj->Resource) - 1]["ThumbNailImage"];
                    } else {
                        $image = "";
                    }
                }
                $data->Extension = $filetype;
                $data->ArtifactIcon = $image;
                $data->IsMultiPleResources = sizeof($postObj->Resource) > 2 ? 2 : sizeof($postObj->Resource);
                if ($postObj->Type == 2) {
                    $eventStartDate = $postObj->StartDate;
                    $eventEndDate = $postObj->EndDate;
                    $data->Title = $postObj->Title;
                    $data->StartDate = date("Y-m-d", $eventStartDate->sec);
                    $data->EndDate = date("Y-m-d", $eventEndDate->sec);

                    $data->EventStartDay = date("d", $eventStartDate->sec);
                    $data->EventStartDayString = date("l", $eventStartDate->sec);

                    $data->EventStartMonth = date("M", $eventEndDate->sec);
                    $data->EventStartYear = date("Y", $eventEndDate->sec);

                    $data->EventEndDay = date("d", $eventEndDate->sec);
                    $data->EventEndDayString = date("l", $eventEndDate->sec);
                    $data->EventEndMonth = date("M", $eventEndDate->sec);
                    $data->EventEndYear = date("Y", $eventEndDate->sec);
                    $data->Location = $postObj->Location;
                    $data->StartTime = $postObj->StartTime;
                    $data->EndTime = $postObj->EndTime;
                }
                if ($postObj->Type == 3) {
                    $data->Title = $postObj->Title;
                    $data->OptionOne = $postObj->OptionOne;
                    $data->OptionTwo = $postObj->OptionTwo;
                    $data->OptionThree = $postObj->OptionThree;
                    $data->OptionFour = $postObj->OptionFour;
                    //$data->ExpiryDate = $postObj->ExpiryDate->sec;
                }
                if ($postObj->Type == 5) {

//                    $curbsideCategory = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId($data->CategoryType);
//                   
//                    $postObj->CurbsideConsultCategory="<a style='cursor:pointer' data-id='".$data->CategoryType."' class='curbsideCategory'><b>".isset($curbsideCategory['CategoryName'])?$curbsideCategory['CategoryName']:''."</b></a>";
//                   
//                    $postObj->CurbsideConsultTitle=$postObj->Subject;
                }
                $data->CategoryType = $data->CategoryType;
                 if($data->IsAnonymous == 1){
                 $data->Title = "";
                 $data->OriginalUserDisplayName = "";
                  $data->OriginalUserProfilePic = "/images/icons/user_noimage.png";
               }
            }
           
            return $abusedPostData;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareFeaturedPostData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar
     * @param type $input
     * @param array $referers
     * @return array of matched eemets
     */
    static function ArrayElementsExistsInString($input, array $referers) {
        try{
        $returnArray = array();
        foreach ($referers as $referer) {
            if (preg_match("/\b$referer\b/i", $input)) {
                array_push($returnArray, $referer);
            }
        }
        return $returnArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:ArrayElementsExistsInString::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function GetNetworkDetailsUtility($urlORname) {
        try{
        return ServiceFactory::getSkiptaUserServiceInstance()->getNeworkDetailsService($urlORname);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:GetNetworkDetailsUtility::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function isValidURL($url) {
        try{
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:isValidURL::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function strip_tags($tags_to_strip, $string) {
        try{
        foreach ($tags_to_strip as $tag) {
            $string = preg_replace("/<\/?" . $tag . "(.|\s)*?>/", '', $string);
        }
        return $string;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:strip_tags::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function millisecondsTOdate($mil, $format) {
        try{
        $seconds = $mil / 1000;
        return date($format, $seconds);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:millisecondsTOdate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author suresh reddy 
     *  by coookie based on  need to reload their primary detail to session 
     * @param type $userObj
     */
    public static function reloadUserPrivilegeAndDataByCookie($userObj) {
        try {
            $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userObj->UserId);
            $userPrivileges = ServiceFactory::getSkiptaUserServiceInstance()->getUserActionsByUserType($userObj->UserId, $userObj->UserTypeId);
            $segmentId = isset($tinyUserCollectionObj->SegmentId)?$tinyUserCollectionObj->SegmentId:0;
            $userFollowingGroups = ServiceFactory::getSkiptaUserServiceInstance()->groupsUserFollowing($userObj->UserId, $segmentId);

            $userHierarchy = ServiceFactory::getSkiptaUserServiceInstance()->getUserHierarchy($userObj->UserId);
            Yii::app()->session['UserFollowingGroups'] = $userFollowingGroups;
            Yii::app()->session['TinyUserCollectionObj'] = $tinyUserCollectionObj;
            Yii::app()->session['UserPrivileges'] = $userPrivileges;
            Yii::app()->session['UserPrivilegeObject'] = CommonUtility::getUserPrivilege();
            Yii::app()->session['UserStaticData'] = $userObj;
            Yii::app()->session['IsAdmin'] = Yii::app()->session['UserStaticData']->UserTypeId;
            Yii::app()->session['UserHierarchy'] = $userHierarchy;
             $networkId = (int) $tinyUserCollectionObj->NetworkId;
            $segments = ServiceFactory::getSkiptaUserServiceInstance()->getAllSegmentsByNetwork($networkId);
            Yii::app()->session['Segments'] = $segments;
            $attributeArray = array("SegmentId" => $segmentId);
          Yii::app()->session['CurrentSegment'] = ServiceFactory::getSkiptaUserServiceInstance()->getSegmentByAttributes($attributeArray);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:reloadUserPrivilegeAndDataByCookie::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author Sagar Pathapelli
     * @usage This method is used to insert the image in xls file.
     * @param type $r //php xls object 
     * @param type $activeSheet
     * @param type $imagePath
     * @param type $coordinates
     * @param type $offSetX
     * @param type $offSetY
     */
    public static function insertImageInExcelSheet($r, $activeSheet, $imagePath, $coordinates, $offSetX, $offSetY) {
        try {
            $objDrawingPType = new PHPExcel_Worksheet_Drawing();
            $objDrawingPType->setWorksheet($r->setActiveSheetIndex($activeSheet));
            $objDrawingPType->setPath($imagePath);
            $objDrawingPType->setCoordinates($coordinates);
            $objDrawingPType->setOffsetX($offSetX);
            $objDrawingPType->setOffsetY($offSetY);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:insertImageInExcelSheet::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

/**
     * @autor Sagar Pathapelli
     * @usage This method is used for rendering the data dynamically in xls file
     * @param type $r
     * @param type $initialRowVal------from which row the data need to be inserted
     * @param type $labelArray---------header array
     * @param type $dataArray----------associative array of data
     */
public static function insertDataDynamicallyInExcelSheet($r, $initialRowVal, $labelArray, $dataArray) {
        try {
            $alphabetsArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $objWorksheet = $r->getActiveSheet();
            $rowsWidth = array();
            //-----------inserting headers----------------
            if (count($labelArray) > 0) {
                for ($i = 0; $i < count($labelArray); $i++) {
                    $celval = (string) ($alphabetsArray[$i] . $initialRowVal);
                    $r->getActiveSheet()->setCellValue($celval, $labelArray[$i]);
                    //setting column width
                    $headerLength = strlen($labelArray[$i]) + 4;
                    $headerLength = $headerLength < 8 ? 8 : $headerLength; //--minimum width of column is 8
                    $r->getActiveSheet()->getColumnDimension($alphabetsArray[$i])->setWidth($headerLength);
                    $rowsWidth[$alphabetsArray[$i]] = $headerLength;
                }
            }
            //------------inserting data-----------------
            if (count($dataArray) > 0) {
                $rowVal = $initialRowVal;
                for ($j = 0; $j < count($dataArray); $j++) {
                    $rowVal = $rowVal + 1;
                    $objWorksheet->insertNewRowBefore($rowVal + 1, 1);
                    for ($k = 0; $k < count($dataArray[$j]); $k++) {
                        $celval = (string) ($alphabetsArray[$k] . $rowVal);
                        $r->getActiveSheet()->setCellValue($celval, $dataArray[$j][$k]);

                        $datalength = strlen($dataArray[$j][$k]);
                        $datalength = $datalength + 4;
                        if ($datalength > $rowsWidth[$alphabetsArray[$k]]) {
                            //updating column width
                            $r->getActiveSheet()->getColumnDimension($alphabetsArray[$k])->setWidth($datalength);
                            $rowsWidth[$alphabetsArray[$k]] = $datalength;
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:insertDataDynamicallyInExcelSheet::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @developer Lakshmn
     * @usage 
     * @param type $r
     * @param type $initialRowVal
     * @param type $labelArray
     * @param type $dataArray@
     */
    public static function insertDataDynamicallyInExcelSheetForSurvey($r, $initialRowVal, $labelArray, $dataArray ) {
        try {
            $alphabetsArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');            
            if(count($dataArray[2]) > 1)
                $endCell = $alphabetsArray[count($dataArray[2])-1];
            else
                $endCell = "C";
            
            $activeSheet = $dataArray["activeSheet"];
 
            if($activeSheet>=0){

                $questionNo = "";
                if($dataArray["QNumber"]!="")
                    $questionNo = $dataArray["QNumber"].") "; 
                
                    $r->createSheet($activeSheet);
                    $r->setActiveSheetIndex($activeSheet);

                    
                if($activeSheet==0){
                    $r->removeSheetByIndex(0);
                    $r->getActiveSheet()->setTitle("worksheet");
                    $endCell = "C";
                    
                    
                                        
                }else{
                    $r->getActiveSheet()->setTitle("worksheet".$activeSheet);
                }
               
                $objWorksheet = $r->getActiveSheet();
                $r->getActiveSheet()->getStyle("A1:".$endCell."1")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => "0066cc"
                    )
                ));
                $r->getActiveSheet()->getRowDimension('1')->setRowHeight(55);
                $r->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
                $r->getActiveSheet()->mergeCells('B1:'.$endCell.'1');
                $r->getActiveSheet()->setCellValue("B1", "Activity Report");
                $r->getActiveSheet()->getStyle('B1:'.$endCell.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $r->getActiveSheet()->getStyle('B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                //$objPHPExcel->getActiveSheet()->getStyle('A1:G20')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                
                $styleArray = array(
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFFF'),
                        'size'  => 20,
                        'name'  => 'Arial'
                    ));

                //$phpExcel->getActiveSheet()->getCell('B1')->setValue('Some text');
                $r->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
                
                $r->getActiveSheet()->mergeCells('A2:'.$endCell.'2');
                $r->getActiveSheet()->setCellValue("A2", $dataArray["SurveyTitle"]." - Activity Report");
                
                $styleArray1 = array(
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '000000'),
                        'size'  => 16,
                        'name'  => 'Arial'
                    ));
                
                $r->getActiveSheet()->getStyle("A2:".$endCell."2")->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                         'rgb' => "e6e6e6"
                    )
                ));
                
                $r->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray1);
                
                $r->getActiveSheet()->getStyle('A2:'.$endCell.'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }else{
                $questionNo = "";
                $objWorksheet = $r->getActiveSheet();
            }            
            
            $styleFont = array(
                'font'  => array(
                'bold'  => true
            ));            

            $rowsWidth = array();
            //-----------inserting headers----------------
            if (count($labelArray) > 0) {
                for ($i = 0; $i < count($labelArray); $i++) {
                    $celval = (string) ($alphabetsArray[$i] . $initialRowVal);
                    $r->getActiveSheet()->setCellValue($celval, $labelArray[$i]);
                    //setting column width
                    $headerLength = strlen($labelArray[$i]) + 4;
                    $headerLength = $headerLength < 8 ? 8 : $headerLength; //--minimum width of column is 8
                    $r->getActiveSheet()->getColumnDimension($alphabetsArray[$i])->setWidth($headerLength);
                    $rowsWidth[$alphabetsArray[$i]] = $headerLength;
                }
            }
            //------------inserting data-----------------
            if (count($dataArray) > 0) {
                $rowVal = $initialRowVal;
                for ($j = 0; $j < count($dataArray); $j++) {
                    $rowVal = $rowVal + 1;                    
                    $objWorksheet->insertNewRowBefore($rowVal + 1, 1);
                    for ($k = 0; $k < count($dataArray[$j]); $k++) {
                        $celval = (string) ($alphabetsArray[$k] . $rowVal);
                        if($j == 0 && $k == 0){
                            $cellTxt = $questionNo.$dataArray[$j][$k];
                        }
                        else{
                            $cellTxt = $dataArray[$j][$k];
                        }
                        if($j == 0 || $j == 2)
                            $r->getActiveSheet()->getStyle($celval)->applyFromArray($styleFont);
                       
                       
                        if(($j == 5 || $j == 8 || $j == 10)  && $activeSheet==0 && $r->getActiveSheet()->getCell("A5")->getValue() != "Page Analytics"){
                            $r->getActiveSheet()->getStyle($celval)->applyFromArray($styleFont);
                        }
                        
                        
                        $r->getActiveSheet()->setCellValue($celval, $cellTxt);
                        
                        if($k > 0){
                            $r->getActiveSheet()->getStyle($celval)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        }

                        $datalength = strlen($dataArray[$j][$k]);
                        $datalength = $datalength + 4;
                        if ($datalength > $rowsWidth[$alphabetsArray[$k]]) {
                            //updating column width
                            $r->getActiveSheet()->getColumnDimension($alphabetsArray[$k])->setWidth($datalength);
                            $rowsWidth[$alphabetsArray[$k]] = $datalength;
                        }
                    }
                    
                }
                $beforeCell = "A".  preg_replace('/\D/', '', $celval); 
                $cellTxt1 = $r->getActiveSheet()->getCell($beforeCell)->getValue();
                
                if($cellTxt1 == "Total"){
                                   
                    $r->getActiveSheet()->getStyle($celval)->applyFromArray($styleFont);
                    $r->getActiveSheet()->getStyle($beforeCell)->applyFromArray($styleFont);
                }
            }

        } catch (Exception $ex) {
            Yii::log("CommonUtility:insertDataDynamicallyInExcelSheetForSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function convert_time_zone($sec, $to_tz, $from_tz = "", $type = "") {
        try{
        $date_time = date("Y-m-d H:i:s", $sec);
        if ($from_tz == "") {
            $from_tz = date_default_timezone_get();
        }
         if ($to_tz == "") {
            $to_tz = date_default_timezone_get();
        }
        $time_object = new DateTime($date_time, new DateTimeZone($from_tz));
        $time_object->setTimezone(new DateTimeZone($to_tz));
        if ($type == "sec") {
            return strtotime($time_object->format('Y-m-d H:i:s'));
        } else {
            return $time_object->format('Y-m-d H:i:s');
        }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:convert_time_zone::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function convert_date_zone($sec, $to_tz, $from_tz = "", $type = "") {
        try{
        $date_time = date("Y-m-d H:i:s", $sec);
        if ($from_tz == "") {
            $from_tz = date_default_timezone_get();
        }
        if ($to_tz == "") {
            $to_tz = date_default_timezone_get();
        }
        $time_object = new DateTime($date_time, new DateTimeZone($from_tz));
        $time_object->setTimezone(new DateTimeZone($to_tz));
        return strtotime($time_object->format('Y-m-d'));
        } catch (Exception $ex) {
            Yii::log("CommonUtility:convert_date_zone::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function currentdate_timezone($to_tz) {
        try{
        $date = date("Y-m-d");
        $date_object = new DateTime($date, new DateTimeZone(date_default_timezone_get()));
         if ($to_tz == "") {
            $to_tz = date_default_timezone_get();
        }
        $date_object->setTimezone(new DateTimeZone($to_tz));
        return strtotime($date_object->format('Y-m-d'));
        } catch (Exception $ex) {
            Yii::log("CommonUtility:currentdate_timezone::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function currenttime_timezone($to_tz) {
        try{
        $date = date("Y-m-d H:i:s");
        $date_object = new DateTime($date, new DateTimeZone(date_default_timezone_get()));
         if ($to_tz == "") {
            $to_tz = date_default_timezone_get();
        }
        $date_object->setTimezone(new DateTimeZone($to_tz));
        return strtotime($date_object->format('Y-m-d H:i:s'));
        } catch (Exception $ex) {
            Yii::log("CommonUtility:currenttime_timezone::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function currentSpecifictime_timezone($to_tz) {
        try{
        $date = date("Y-m-d H:i:s");
        $date_object = new DateTime($date);
         if ($to_tz == "") {
            $to_tz = date_default_timezone_get();
        }
        $date_object->setTimezone(new DateTimeZone($to_tz));
        return strtotime($date_object->format('Y-m-d H:i:s'));
        } catch (Exception $ex) {
            Yii::log("CommonUtility:currentSpecifictime_timezone::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function generateSecurityToken() {
        try{
        $rand = rand(0, 10000);
        $securityToken = Yii::app()->params['phasePhrase'] . "-" . $rand . "-" . time();
        $securityToken = base64_encode($securityToken);
        return $securityToken;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:generateSecurityToken::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @author suresh Reddy
     * @param type $streamPostData
     * @return array
     * 
     */
    static function prepareStreamDataForMobile($UserId, $streamPostData, $UserPrivileges, $isHomeStream = 0, $PostAsNetwork = 0, $timezone = '', $previousStreamIdArray=array()) {

        try {
            $streamIdArray = array();
            $zeroRecordArray = array();
            $oneRecordArray = array();
            $currentStreamIdArray = array();
            $totalStreamIdArray = array();
            if($isHomeStream==3 && Yii::app()->params['IsDSN']=='ON'){
               $isHomeStream==1; 
            }
            foreach ($streamPostData as $key => $data) {
                array_push($totalStreamIdArray, (string)$data->PostId);
                if (!in_array((string)$data->PostId, $previousStreamIdArray)) {
                $data->IsHomeStream = $isHomeStream;
                $recentActivityUser2 = "";
                $isPromoted = isset($data->IsPromoted) ? $data->IsPromoted : 0;
                $data->IsIFrameMode = 0;
                if ($data->CategoryType == 3) {
                    if (isset($data->GroupId)) {

                        $groupData = GroupCollection::model()->getGroupDetailsById($data->GroupId);

                        if ($groupData != "failure") {
                            $data->IsFollowingEntity = in_array($UserId, $groupData->GroupMembers);
                            if ($groupData->IsPrivate == 1 && $isHomeStream == 1 && $data->IsFollowingEntity == 0) {

                                unset($streamPostData[$key]);
                                continue;
                            }
                            $isIframeModeValue = (isset($groupData->IsIFrameMode) && $groupData->IsIFrameMode == 1) ? 1 : 0;
                            if ($isIframeModeValue == 1 && in_array($UserId, $groupData->GroupMembers)) {

                                $data->IsIFrameMode = 1;
                            }
                            $data->GroupName = $groupData->GroupName;
                            $data->MainGroupId = $groupData->_id;
                            $data->GroupImage = Yii::app()->params['ServerURL'] . $groupData->GroupProfileImage;
                            $data->IsPrivate = $groupData->IsPrivate;

                            if (in_array($data->OriginalUserId, $groupData->GroupAdminUsers)) {
                                $data->isGroupAdminPost = 'true';
                            }
                            if ($data->IsIFrameMode != 1) {
                                $data->GroupImage = Yii::app()->params['ServerURL'] . $groupData->GroupProfileImage;

                                /* for more */
                                $tagsFreeDescription = strip_tags(($groupData->GroupDescription));
                                $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);

                                $descriptionLength = strlen($tagsFreeDescription);
                                /* for more */


                                if ($descriptionLength > 240) {
                                    $description = CommonUtility::truncateHtml($groupData->GroupDescription, 240);
                                    $data->GroupDescription = trim($description) .Yii::t('translation','Readmore');
                                } else {
                                    $data->GroupDescription = $groupData->GroupDescription;
                                }



                                $data->GroupFollowersCount = sizeof($data->PostFollowers);
                                $data->IsFollowingPost = in_array($UserId, $data->PostFollowers);


                                if ($data->isDerivative == 0) {
                                    if ($isHomeStream == 1 && (!($data->IsFollowingEntity) || $isPromoted == 1)) {
                                        unset($streamPostData[$key]);
                                        continue;
                                    }
                                } else {
                                    
                                }
                            }
                        }
                    }
                }
                if ($data->CategoryType == 7) {
                    if (isset($data->SubGroupId)) {

                        $groupData = SubGroupCollection::model()->getSubGroupDetailsById($data->SubGroupId);
                        $gData = GroupCollection::model()->getGroupDetailsById($data->GroupId);

                        if ($groupData != "failure") {
                            $data->SubGroupImage = Yii::app()->params['ServerURL'] . $groupData->SubGroupProfileImage;
                            $data->SubGroupName = $groupData->SubGroupName;
                            $data->GroupName = $gData->GroupName;

                            /* for more */
                            $tagsFreeDescription = strip_tags(($groupData->SubGroupDescription));
                            $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);

                            $descriptionLength = strlen($tagsFreeDescription);
                            /* for more */

                            if ($descriptionLength > 240) {
                                $description = CommonUtility::truncateHtml($groupData->SubGroupDescription, 240);
                                $data->SubGroupDescription = trim($description) . Yii::t('translation','Readmore');
                            } else {
                                $data->SubGroupDescription = $groupData->SubGroupDescription;
                            }
                            

                            $data->SubGroupFollowersCount = sizeof($groupData->SubGroupMembers);
                            $data->IsFollowingEntity = in_array($UserId, $groupData->SubGroupMembers);
                            if ($data->isDerivative == 0) {
                                if ($isHomeStream == 1 && (!($data->IsFollowingEntity) || $isPromoted == 1)) {
                                    unset($streamPostData[$key]);
                                    continue;
                                }
                            }
                        }
                    }
                }

                $data->IsPromoted = $isPromoted;

                if ($data->CategoryType == 9) {
                    
                } else {
                    if (sizeof($streamIdArray) > 0) {
                        if (array_key_exists("$data->PostId", $streamIdArray)) {
                            if ($streamIdArray["$data->PostId"] == $isPromoted) {
                                unset($streamPostData[$key]);
                                continue;
                            }
//                        elseif($streamIdArray["$data->PostId"]==$isPromoted && $data->UserId!=0){                            
//                            unset($streamPostData[$key]);
//                        }
                        }
                    }
                }


                $streamIdArray["$data->PostId"] = $isPromoted;
                $data->SessionUserId = $UserId;
                $data->CanDeletePost = ($data->OriginalUserId == $data->SessionUserId) ? 1 : 0;
                if (is_array($UserPrivileges)) {
                    foreach ($UserPrivileges as $value) {
                        if ($value['Status'] == 1) {
                            if ($value['Action'] == 'Delete') {
                                $data->CanDeletePost = 1;
                            } else if ($value['Action'] == 'Promote_Post') {
                                $data->CanPromotePost = 1;
                            } else if ($value['Action'] == 'Promote_To_Featured_Items') {
                                $data->CanFeaturePost = 1;
                            } else if ($value['Action'] == 'Mark_As_Abuse') {
                                $data->CanMarkAsAbuse = 1;
                            }
                        }
                    }
                }

                $createdOn = $data->CreatedOn;
                $originalPostTime = $data->OriginalPostTime;
                if ($isPromoted == 1) {
                    $data->PostOn = CommonUtility::styleDateTime($originalPostTime->sec, 'mobile');
                    $data->PromotedDate = CommonUtility::styleDateTime($createdOn->sec);
                    $currentDate = date('Y-m-d', time());
                    $postPromotedDate = date('Y-m-d', $createdOn->sec);
                    if ($postPromotedDate < $currentDate) {
                        $data->IsPromoted = 0;
                    }
                    if ($data->CanPromotePost == 1) {
                        if ($postPromotedDate > $currentDate) {
                            $data->CanPromotePost = 0;
                        }
                    }
                    if ($data->CanDeletePost == 1 && $data->PromotedUserId != $UserId) {
                        $data->CanDeletePost = 0;
                    }
                } else {

                    $data->PostOn = CommonUtility::styleDateTime($createdOn->sec, 'mobile');

//                    if($data->CategoryType==2){
//                        $postDetails=  CurbsidePostCollection::model()->getPostById($data->PostId);
//                        $postCollectionDate=$postDetails->CreatedOn;
//                       $data->PostOn = CommonUtility::styleDateTime($postCollectionDate->sec); 
//                    }else if($data->CategoryType==1) {
//                        $postDetails=  PostCollection::model()->getPostById($data->PostId);
//                        $postCollectionDate=$postDetails->CreatedOn;
//                        $data->PostOn = CommonUtility::styleDateTime($postCollectionDate->sec); 
//                    }else{
//                        $data->PostOn = CommonUtility::styleDateTime($originalPostTime->sec);  
                    //  }
                }
                $data->OriginalPostPostedOn = CommonUtility::styleDateTime($originalPostTime->sec, 'mobile');
                $textWithOutHtml = $data->PostText;

                $textLength = strlen($textWithOutHtml);
                if (isset($data->WebUrls) && !empty($data->WebUrls) && $data->WebUrls != null) {
                    if (isset($data->IsWebSnippetExist) && $data->IsWebSnippetExist == '1') {
                        $snippetdata = WebSnippetCollection::model()->CheckWebUrlExist($data->WebUrls[0]);

                        $data->WebUrls = $snippetdata;
                    } else {
                        $data->WebUrls = "";
                    }
                }

//
//                /*for more*/
//                        $tagsFreeDescription= strip_tags(($data->PostText));
//                        $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
//                 
//                        $descriptionLength =  strlen($tagsFreeDescription);
//                       
//                       /*for more*/
                // $textLength=strlen($textWithOutHtml);

                if (isset($data->PostTextLength) && $data->PostTextLength > 240 && $data->PostTextLength < 500) {
                    $appendData = '<span class="seemore tooltiplink"   onclick="expandpostDiv(' . "'" . $data->_id . "'" . ')"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                } else {

                    $appendData = ' <span class="postdetail tooltiplink" data-id=' . $data->_id . '  data-postid="' . $data->PostId . '" data-categoryType="' . $data->CategoryType . '" data-postType="' . $data->PostType . '"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                }
                $data->PostCompleteText = $data->PostText;
                if ($data->PostTextLength > 240) {
                    $description = CommonUtility::truncateHtml($data->PostText, 240, 'Read more', true, true, $appendData);

                    $text = $description;
                    $data->PostText = $text;
                }
                //  $data->PostText .= ' <span class="postdetail" data-postid="'.$data->PostId.'" data-categoryType="'.$data->CategoryType.'" data-postType="'.$data->PostType.'"> <i class="fa fa-ellipsis-h"></i></span>';
                $tinyOriginalUser = UserCollection::model()->getTinyUserCollection($data->OriginalUserId);
                $postType = CommonUtility::postTypebyIndex($data->PostType, $data->CategoryType);
                $data->PostTypeString = $postType;
                $createdOn = $data->CreatedOn;
                $originalPostTime = $data->OriginalPostTime;
                $recentActivity1UserId = "";
                $recentActivity2UserId = "";
                if ($data->RecentActivity == "Post") {
                    $recentActivity1UserId = $data->OriginalUserId;
                    $recentActivity2UserId = "";
                }
                //elseif ($data->RecentActivity=="HashTagFollow") {
                //   $recentActivity1UserId=$data->HashTagPostUserId;
                //           }
                elseif ($data->RecentActivity == "UserMention") {
                    $recentActivity1UserId = $data->MentionUserId;
                } elseif ($data->RecentActivity == "Love") {
                    $LoveUserId = array_values(array_unique($data->LoveUserId));
                    if (sizeof($LoveUserId) > 1) {
                        $recentActivity1UserId = $LoveUserId[sizeof($LoveUserId) - 1];
                        $recentActivity2UserId = $LoveUserId[sizeof($LoveUserId) - 2];
                    } elseif (sizeof($LoveUserId) == 1) {
                        $recentActivity1UserId = $LoveUserId[sizeof($LoveUserId) - 1];
                    }
                } elseif ($data->RecentActivity == "Comment") {
                    $CommentUserId = array_values(array_unique($data->CommentUserId));
                    if (sizeof($CommentUserId) > 1) {
                        $recentActivity1UserId = $CommentUserId[sizeof($CommentUserId) - 1];
                        $recentActivity2UserId = $CommentUserId[sizeof($CommentUserId) - 2];
                    } elseif (sizeof($CommentUserId) == 1) {
                        $recentActivity1UserId = $CommentUserId[sizeof($CommentUserId) - 1];
                    }
                } elseif ($data->RecentActivity == "UserFollow") {

                    $FollowUserId = array_values(array_unique($data->UserFollowers));
                    if (count($FollowUserId) > 1) {
                        $recentActivity1UserId = $FollowUserId[sizeof($FollowUserId) - 1];
                        $recentActivity2UserId = $FollowUserId[sizeof($FollowUserId) - 2];
                    } elseif (sizeof($FollowUserId) == 1) {
                        $recentActivity1UserId = $FollowUserId[sizeof($FollowUserId) - 1];
                    }
                } elseif ($data->RecentActivity == "PostFollow") {
                    $PostFollow = array_values(array_unique($data->PostFollowers));
                    if (count($PostFollow) > 1) {
                        $recentActivity1UserId = $PostFollow[sizeof($PostFollow) - 1];
                        $recentActivity2UserId = $PostFollow[sizeof($PostFollow) - 2];
                    } elseif (sizeof($PostFollow) == 1) {
                        $recentActivity1UserId = $PostFollow[sizeof($PostFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "EventAttend") {
                    $EventAttendes = array_values(array_unique($data->EventAttendes));
                    if (sizeof($EventAttendes) > 1) {
                        $recentActivity1UserId = $EventAttendes[sizeof($EventAttendes) - 1];
                        $recentActivity2UserId = $EventAttendes[sizeof($EventAttendes) - 2];
                    } elseif (sizeof($EventAttendes) == 1) {
                        $recentActivity1UserId = $EventAttendes[sizeof($EventAttendes) - 1];
                    }
                } elseif ($data->RecentActivity == "Invite") {
                    $InviteUsers = array_values(array_unique($data->InviteUsers));
                    if (sizeof($InviteUsers) > 1) {
                        $recentActivity1UserId = $InviteUsers[sizeof($InviteUsers) - 1];
                        $recentActivity2UserId = $InviteUsers[sizeof($InviteUsers) - 2];
                    } elseif (sizeof($InviteUsers) == 1) {
                        $recentActivity1UserId = $InviteUsers[sizeof($InviteUsers) - 1];
                    }
                } elseif ($data->RecentActivity == "Survey") {
                    $SurveyTaken = array_values(array_unique($data->SurveyTaken));
                    if (sizeof($SurveyTaken) > 1) {
                        $recentActivity1UserId = $SurveyTaken[sizeof($SurveyTaken) - 1];
                        $recentActivity2UserId = $SurveyTaken[sizeof($SurveyTaken) - 2];
                    } elseif (sizeof($SurveyTaken) == 1) {
                        $recentActivity1UserId = $SurveyTaken[sizeof($SurveyTaken) - 1];
                    }
                } elseif ($data->RecentActivity == "GroupFollow") {
                    $GroupFollow = array_values(array_unique($data->GroupFollowers));
                    if (sizeof($GroupFollow) > 1) {
                        $recentActivity1UserId = $GroupFollow[sizeof($GroupFollow) - 1];
                        $recentActivity2UserId = $GroupFollow[sizeof($GroupFollow) - 2];
                    } elseif (sizeof($GroupFollow) == 1) {
                        $recentActivity1UserId = $GroupFollow[sizeof($GroupFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "CurbsideCategoryFollow") {
                    $CurbsideFollow = array_values(array_unique($data->CurbsideCategoryFollowers));
                    if (sizeof($CurbsideFollow) > 1) {
                        $recentActivity1UserId = $CurbsideFollow[sizeof($CurbsideFollow) - 1];
                        $recentActivity2UserId = $CurbsideFollow[sizeof($CurbsideFollow) - 2];
                    } elseif (sizeof($CurbsideFollow) == 1) {
                        $recentActivity1UserId = $CurbsideFollow[sizeof($CurbsideFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "HashTagFollow") {
                    $recentActivity1UserId = $data->HashTagPostUserId;
                    $HashTagFollow = array_values(array_unique($data->HashTagFollowers));
                    if (sizeof($HashTagFollow) > 1) {
                        $recentActivity1UserId = $HashTagFollow[sizeof($HashTagFollow) - 1];
                        $recentActivity2UserId = $HashTagFollow[sizeof($HashTagFollow) - 2];
                    } elseif (sizeof($HashTagFollow) == 1) {
                        $recentActivity1UserId = $HashTagFollow[sizeof($HashTagFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "Play") {
                    if (isset($data->CurrentScheduledPlayers)) {
                        $PlayedUsers = array_values(array_unique($data->CurrentScheduledPlayers));
                        if (sizeof($PlayedUsers) > 1) {
                            $recentActivity1UserId = $PlayedUsers[sizeof($PlayedUsers) - 1]['UserId'];
                            $recentActivity2UserId = $PlayedUsers[sizeof($PlayedUsers) - 2]['UserId'];
                        } elseif (sizeof($PlayedUsers) == 1) {
                            $recentActivity1UserId = $PlayedUsers[sizeof($PlayedUsers) - 1]['UserId'];
                        }
                    }
                } elseif ($data->RecentActivity == "Schedule") {
                    $recentActivity2UserId = $data->OriginalUserId;
                }

                $recentActivityUser1 = UserCollection::model()->getTinyUserCollection($recentActivity1UserId);
                if (!empty($recentActivity2UserId)) {
                    $recentActivityUser2 = UserCollection::model()->getTinyUserCollection($recentActivity2UserId);
                }
                $whosePost = "";
                if ($data->ActionType == 'Comment' || $data->ActionType == 'Follow' || $data->ActionType == 'EventAttend' || $data->ActionType == 'Invite') {
                    if ($data->OriginalUserId == $UserId) {
                        $whosePost = "your";
                    } elseif (in_array($data->OriginalUserId, array_unique($data->UserFollowers)) || in_array($data->OriginalUserId, array_unique($data->PostFollowers))) {
                        $whosePost = $tinyOriginalUser['DisplayName'];
                    }
                }
                $userId1 = $recentActivityUser1['UserId'];
                $userId2 = "";
                $displayName1 = $UserId == $recentActivityUser1['UserId'] ? 'You' : $recentActivityUser1['DisplayName'];
                if ($PostAsNetwork == 1) {
                    $displayName1 = $recentActivityUser1['DisplayName'];
                }
                $displayName2 = "";
                $secondUser = "";
                if (!empty($recentActivityUser2)) {
                    $userId2 = $recentActivityUser2['UserId'];
                    $displayName2 = $UserId == $recentActivityUser2['UserId'] ? 'You' : $recentActivityUser2['DisplayName'];
                    if ($PostAsNetwork == 1) {
                        $displayName2 = $recentActivityUser2['DisplayName'];
                    }
                    if ($displayName2 == "You") {
                        $displayName2 = $displayName1;
                        $displayName1 = "You";
                        $temp = $userId1;
                        $userId1 = $userId2;
                        $userId2 = $temp;
                    }
                    $secondUser = ", <a class='userprofilename' data-id='" . $userId2 . "' style='cursor:pointer'><b>" . $displayName2 . "</b></a>";
                }

                $data->FirstUserId = $userId1;
                $data->FirstUserDisplayName = $displayName1;
                $data->FirstUserProfilePic = $recentActivityUser1['profile250x250'];
                $data->SecondUserData = $secondUser;
                $data->PostBy = $whosePost;
                $data->OriginalUserDisplayName = $tinyOriginalUser['DisplayName'];
                $data->OriginalUserProfilePic = $tinyOriginalUser['profile70x70'];
                $data->IsFollowingPost = in_array($UserId, $data->PostFollowers);
                $data->IsLoved = in_array($UserId, $data->LoveUserId);
                $data->FbShare = isset($data->FbShare) && is_array($data->FbShare) ? in_array($UserId, $data->FbShare) : 0;
                $data->TwitterShare = isset($data->TwitterShare) && is_array($data->TwitterShare) ? in_array($UserId, $data->TwitterShare) : 0;
                $data->IsSurveyTaken = in_array($UserId, $data->SurveyTaken);
                $data->TotalSurveyCount = $data->OptionOneCount + $data->OptionTwoCount + $data->OptionThreeCount + $data->OptionFourCount;
                if (isset($data->OptionFour) && !empty($data->OptionFour))
                    $data->IsOptionDExist = 1;

                $image = "";
                if ($data->IsMultiPleResources > 0) {

                    if (isset($data->Resource["ThumbNailImage"])) {
                        $data->ArtifactIcon = Yii::app()->params['ServerURL'] . "" . $data->Resource["ThumbNailImage"];
                        $data->Resource["Uri"]= Yii::app()->params['ServerURL'] . "" . $data->Resource["Uri"];

                        } else {
                        $data->ArtifactIcon = "";
                    }
                }
                if ($secondUser != "") {
                    if (trim($data->StreamNote) == "is following") {
                        $data->StreamNote = " are following";
                    }
                    if (trim($data->StreamNote) == "is attending") {
                        $data->StreamNote = " are attending";
                    }
                    if (trim($data->StreamNote) == "has answered") {
                        $data->StreamNote = " have answered";
                    }
                    if (trim($data->StreamNote) == "is Played") {
                        $data->StreamNote = " are Played";
                    }
                    if (trim($data->StreamNote) == "has Played") {
                        $data->StreamNote = " have Played ";
                    }
                }
                if ($UserId == $recentActivityUser1['UserId'] && trim($secondUser) == "") {


                    if (trim($data->StreamNote) == "is following") {
                        $data->StreamNote = " are following";
                    }
                    if (trim($data->StreamNote) == "is attending") {
                        $data->StreamNote = " are attending";
                    }
                    if (trim($data->StreamNote) == "has answered") {
                        $data->StreamNote = " have answered";
                    }if (trim($data->StreamNote) == "is Played") {
                        $data->StreamNote = " Played";
                    }
                    if (trim($data->StreamNote) == "has invited to") {
                        $data->StreamNote = " have invited to ";
                    }
                    if (trim($data->StreamNote) == "has Played") {
                        $data->StreamNote = " have Played ";
                    }
                }

                if ($data->PostType == 4) {
                    $data->PostBy = "";
                    if ($data->ActionType == "Post") {
                        $data->PostBy = "";
                        $data->FirstUserDisplayName = "";
                        $data->FirstUserProfilePic = "/images/icons/user_noimage.png";
                        $data->SecondUserData = "";
                        $data->StreamNote = "A new post has been created";
                        $data->PostTypeString = "";
                    }
                }

                if ($data->PostType == 2) {

                    $eventStartDate = CommonUtility::convert_time_zone($data->StartDate->sec, $timezone, '', 'sec');
                    $eventEndDate = CommonUtility::convert_time_zone($data->EndDate->sec, $timezone, '', 'sec');
                    $data->Title = $data->Title;
                    $data->StartDate = date("Y-m-d", $eventStartDate);
                    $data->EndDate = date("Y-m-d", $eventEndDate);
                    $data->EventStartDay = date("d", $eventStartDate);
                    $data->EventStartDayString = date("l", $eventStartDate);
                    $data->EventStartMonth = date("M", $eventStartDate);
                    $data->EventStartYear = date("Y", $eventStartDate);
                    $data->EventEndDay = date("d", $eventEndDate);
                    $data->EventEndDayString = date("l", $eventEndDate);
                    $data->EventEndMonth = date("M", $eventEndDate);
                    $data->EventEndYear = date("Y", $eventEndDate);
                    $data->StartTime = date("h:i A", $eventStartDate);
                    $data->EndTime = date("h:i A", $eventEndDate);
                    if ($eventEndDate <= CommonUtility::currentSpecifictime_timezone($timezone)) {
                        $data->CanPromotePost = 0;
                        $data->IsEventAttend = 1;
                    } else {
                        $data->IsEventAttend = in_array($UserId, $data->EventAttendes);
                    }
                } elseif ($data->PostType == 3) {


                    $surveyExpiryDate = $data->ExpiryDate;
                    $data->Title = $data->Title;
                    if (isset($surveyExpiryDate->sec) && $surveyExpiryDate->sec <= time()) {
                        $data->CanPromotePost = 0;
                        $data->ExpiryDate = date("Y-m-d", $surveyExpiryDate->sec);
                    }
                    $surveyExpiryDate_tz = CommonUtility::convert_date_zone($surveyExpiryDate->sec, $timezone);
                    $currentDate_tz = CommonUtility::currentdate_timezone($timezone);
                    if ($surveyExpiryDate_tz < $currentDate_tz) {
                        $data->IsSurveyTaken = true; //expired
                    }
                }

                $comments = $data->Comments;
                $commentCount = sizeof($comments);
                $data->CommentCount = $data->CommentCount;
                $commentsArray = array();
                if ($commentCount > 0) {
                    $data->IsCommented = in_array((int) $UserId, $data->CommentUserId);
                    //$maxDisplaySize = $commentCount>2?2:$commentCount;
                    $commentsDisplayCount = 0;
                    for ($j = $commentCount; $j > 0; $j--) {
                        $comment = $comments[$j - 1];
                        $isBlockedComment = isset($comment['IsBlockedWordExist']) ? $comment['IsBlockedWordExist'] : 0;
                        if ($isBlockedComment != 1) {
                            $commentsDisplayCount++;
                            $commentedUser = UserCollection::model()->getTinyUserCollection($comment["UserId"]);
                            $comment["CreatedOn"] = $comment["CreatedOn"];
                            $textWithOutHtml = $comment["CommentText"];

                            if (isset($comment['WebUrls']) && !empty($comment['WebUrls']) && $comment['WebUrls'] != null) {

                                if (isset($comment['IsWebSnippetExist']) && $comment['IsWebSnippetExist'] == '1') {
                                    $CommentSnippetdata = WebSnippetCollection::model()->CheckWebUrlExist($comment['WebUrls'][0]);
                                    $comment['WebUrls'] = $CommentSnippetdata;
                                } else {

                                    $comment['WebUrls'] = "";
                                }
                            }
                            if (isset($comment["CommentTextLength"]) && $comment["CommentTextLength"] > 240) {

                                $appendCommentData = ' <span class="postdetail tooltiplink" data-id="' . $data->_id . '"   data-postid="' . $data->PostId . '" data-categoryType="' . $data->CategoryType . '" data-postType="' . $data->PostType . '"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                                // $description = CommonUtility::truncateHtml($comment["CommentText"], 240,$appendCommentData);
                                $description = CommonUtility::truncateHtml($comment["CommentText"], 240, 'Read more', true, true, $appendCommentData);
                                $text = $description;

                                $comment["CommentText"] = str_replace("&nbsp;"," ",$text);
                            } else {

                                $comment["CommentText"] =  str_replace("&nbsp;"," ",$comment["CommentText"]);
                            }
                            $comment['ProfilePicture'] = $commentedUser['profile70x70'];
                            $commentCreatedOn = $comment["CreatedOn"];
                            $comment["CreatedOn"] = CommonUtility::styleDateTime($commentCreatedOn->sec, 'mobile');
                            $comment["DisplayName"] = $commentedUser['DisplayName'];
                            $image = "";
                            if (sizeof($comment["Artifacts"]) > 0) {
                                if (isset($comment["Artifacts"]['ThumbNailImage'])) {
                                    $image = Yii::app()->params['ServerURL'] . "" . $comment["Artifacts"]['ThumbNailImage'];
                                  $ArtifactExtension=$comment["Artifacts"]['Extension'];
                                    $comment["ArtifactExtension"] = strtolower($ArtifactExtension);
                                    
                                } else {
                                    $image = "";
                                    $comment["ArtifactExtension"] ="";
                                }
                            }
                            $comment["ArtifactIcon"] = $image;
                           
                            array_push($commentsArray, $comment);
                            if ($commentsDisplayCount == 2) {
                                break;
                            }
                        }
                    }
                }
                $data->Comments = $commentsArray;
                if ($data->CategoryType == 3) {
                    if (isset($data->GroupId)) {
                        $data->PostTypeString = " " . $data->PostTypeString;
                    }
                }
                if ($data->CategoryType == 7) {
                    if (isset($data->SubGroupId)) {
                        $data->PostTypeString = " " . $data->PostTypeString;
                    }
                }
                  if ($data->CategoryType == 11) {
                    if (isset($data->SubGroupId)) {
                        $data->PostTypeString = " " . $data->PostTypeString;
                    }
                }


                /**
                 * follow Object  post type
                 * post type user is 6
                 * post type hashtag 7
                 * post type curbsidecategory 8
                 * post  type group 9
                 */
                if ($data->PostType == 9) {
                    if (isset($data->GroupId)) {
                        $groupData = GroupCollection::model()->getGroupDetailsById($data->GroupId);

                        $data->GroupImage = Yii::app()->params['ServerURL'] . $groupData->GroupProfileImage;
                        $data->GroupName = $groupData->GroupName;

                        if (strlen($groupData->GroupDescription) > 240) {
                            $description = CommonUtility::truncateHtml($groupData->GroupDescription, 240);
                            $data->GroupDescription = $description . Yii::t('translation','Readmore');
                        } else {
                            $data->GroupDescription = $groupData->GroupDescription;
                        }
                        //$data->GroupDescription = $groupData->GroupDescription;
                        $data->GroupFollowersCount = sizeof($groupData->GroupMembers);
                        $data->IsFollowingEntity = in_array($UserId, $groupData->GroupMembers);
                        $data->PostTypeString = " Group ";
                    }
                }

                if ($data->PostType == 10) {
                    if (isset($data->SubGroupId)) {
                        $groupData = SubGroupCollection::model()->getSubGroupDetailsById($data->SubGroupId);
                        $data->SubGroupImage = Yii::app()->params['ServerURL'] . $groupData->SubGroupProfileImage;
                        $data->SubGroupName = $groupData->SubGroupName;

                        if (strlen($groupData->SubGroupDescription) > 240) {
                            $description = CommonUtility::truncateHtml($groupData->GroupDescription, 240);
                            $data->SubGroupDescription = $description . Yii::t('translation','Readmore');
                        } else {
                            $data->SubGroupDescription = $groupData->SubGroupDescription;
                        }
                        //$data->GroupDescription = $groupData->GroupDescription;
                        $data->SubGroupFollowersCount = sizeof($groupData->SubGroupMembers);
                        $data->IsFollowingEntity = in_array($UserId, $groupData->SubGroupMembers);
                        $data->PostTypeString = " Sub Group ";
                    }
                }
                if ($data->PostType == 7) {
                    $data->PostTypeString = " #Tag";
                    $data->GroupImage = Yii::app()->params['ServerURL'] . "/images/icons/hashtag_img.png";
                    $data->HashTagName = $data->HashTagName;
                    $data->GroupDescription = "";
                    $data->HashTagPostCount = count($data->HashTagFollowers);

                    $data->IsFollowingEntity = in_array($UserId, $data->HashTagFollowers);
                    $data->PostTypeString = " " . $data->HashTagName;
                }
                if ($data->PostType == 8) {
                    $name = Yii::t('translation', 'CurbsideConsult');
                    $data->PostTypeString = " $name Category";
                    $data->GroupImage = Yii::app()->params['ServerURL'] . "/images/icons/curbesidepost_img.png";
                    $data->CurbsideConsultCategory = $data->CurbsideConsultCategory;
                    $data->GroupDescription = "";
                    // $data->CurbsidePostCount =  $data->CurbsidePostCount;
                    $data->CurbsidePostCount = sizeof($data->CurbsideCategoryFollowers);
                    $data->IsFollowingEntity = in_array($UserId, $data->CurbsideCategoryFollowers);
                    $data->PostTypeString = " " . $data->PostTypeString;
                }
                if ($data->PostType == 11) {
                  
                  $pattern = '/object/';
                    if(preg_match($pattern, $data->HtmlFragment)){
                        
                        $data->IsVideo = 1;
                    }else{
                         
                         $data->IsVideo = 0;
                        
                    }
                    if($isHomeStream==1){
                        $width="width='100'";
                        $height="height='100'";
                    }else{
                          $width="width='250'";
                        $height="height='250'";
                    }
                    $pattern = '/(width)="[0-9]*"/';
                    $string=$data->HtmlFragment;
                    $string = preg_replace($pattern, $width, $string);
                    $pattern = '/(height)="[0-9]*"/';
                    $string = preg_replace($pattern, $height, $string);

                    $data->HtmlFragment = $string;
                    $data->IsNotifiable = (int) $data->IsNotifiable;
                    $data->PublicationDate = CommonUtility::styleDateTime(strtotime($data->PublicationDate), "mobile");
                    if ($data->Editorial != '') {
                        $editorial = $data->Editorial;
                        if (strlen($data->Editorial) > 240) {
                            $editorial = substr($editorial, 0, 240);
                            $editorial = $editorial . '<a  class="showmore postdetail" data-id="' . $data->PostId . '">&nbsp<i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></a>';
                        }
                        $data->Editorial = $editorial;
                    }
                }elseif ($data->PostType == 13) {
                    $data->PostTypeString = $data->BadgeName." badge";
                }
                $data->PostId = (String) $data->PostId;
                $data->_id = (String) $data->_id;
                array_push($currentStreamIdArray, (string)$data->PostId);
                }else{
                    
                    unset($streamPostData[$key]);
                    continue;
                }
            }

            //if($isHomeStream == 1){
                
              //  return array('streamPostData'=>$streamPostData, 'streamIdArray'=>$currentStreamIdArray,"totalStreamIdArray"=>$totalStreamIdArray);
//            }else{
               return $streamPostData;
//            }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareStreamDataForMobile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareStreamDataForMobile==".$ex->getMessage());
        }
    }
    
    static function prepareStreamDataForMobile_V3($UserId, $streamPostData, $UserPrivileges, $isHomeStream = 0, $PostAsNetwork = 0, $timezone = '', $previousStreamIdArray=array()) {

        try {
            $streamIdArray = array();
            $zeroRecordArray = array();
            $oneRecordArray = array();
            $currentStreamIdArray = array();
            $totalStreamIdArray = array();
            foreach ($streamPostData as $key => $data) {
		//Advertisements filtaring start
                // Stopiing ad start here
                if($data->AdType == 2 || $data->AdType == 3){
                     unset($streamPostData[$key]);
                }
                  // Stopiing ad end here
                if(isset($data->DisplayPage) && $data->AdType!=1){
                    if($isHomeStream==1 && $data->DisplayPage!="Home"){
                      unset($streamPostData[$key]);
                       continue;  
                    }
                    
                    else if($isHomeStream==2 && $data->DisplayPage!="Group"){
                      unset($streamPostData[$key]);
                      continue;   
                    }
                    else if($isHomeStream==3 && $data->DisplayPage!="Curbside"){
                      unset($streamPostData[$key]);
                      continue;   
                    }
        
                   if($data->DisplayPage=="Group"){
                       $reg='/'.$_GET['groupId'].'/';
                       if($data->Groups!="AllGroups" && !preg_match($reg,$data->Groups) ){
                          unset($streamPostData[$key]);
                          continue; 
                       }  
                    }
                    
                }
                 //Advertisements filtaring end
                array_push($totalStreamIdArray, (string)$data->PostId);
                if (!in_array((string)$data->PostId, $previousStreamIdArray)) {
                if($isHomeStream == 3){
                        $data->IsHomeStream = 0;
                    }
                     if($isHomeStream == 1){
                        $data->IsHomeStream = 1;
                    }
                $recentActivityUser2 = "";
                $isPromoted = isset($data->IsPromoted) ? $data->IsPromoted : 0;
                $data->IsIFrameMode = 0;
                if ($data->CategoryType == 3) {
                    if (isset($data->GroupId)) {

                        $groupData = GroupCollection::model()->getGroupDetailsById($data->GroupId);

                        if ($groupData != "failure") {
                            $data->IsFollowingEntity = in_array($UserId, $groupData->GroupMembers);
                            if ($groupData->IsPrivate == 1 && $isHomeStream == 1 && $data->IsFollowingEntity == 0) {

                                unset($streamPostData[$key]);
                                continue;
                            }
                            $isIframeModeValue = (isset($groupData->IsIFrameMode) && $groupData->IsIFrameMode == 1) ? 1 : 0;
                            if ($isIframeModeValue == 1 && in_array($UserId, $groupData->GroupMembers)|| ($groupData->CustomGroup == 1 && $groupData->IsHybrid == 0)) {

                                $data->IsIFrameMode = 1;
 				$data->IsNativeGroup=1;
                            }
                            $data->GroupName = $groupData->GroupName;
                            $data->MainGroupId = $groupData->_id;
                            $data->GroupImage = Yii::app()->params['ServerURL'] . $groupData->GroupProfileImage;
                            $data->IsPrivate = $groupData->IsPrivate;                            
                            $data->ConversationVisibility =$groupData->ConversationVisibility;                       
                            if (in_array($data->OriginalUserId, $groupData->GroupAdminUsers)) {
                                $data->isGroupAdminPost = 'true';
                            }
                            if (isset($groupData->AddSocialActions)) {
                                        $data->AddSocialActions = $groupData->AddSocialActions;
                            }
  			   // if($groupData->ConversationVisibility!=1){
                             //  unset($streamPostData[$key]);
                              // continue;
                           //}
 				if($groupData->ConversationVisibility == 1){
                                    $data->IsIFrameMode = 1;
                            }
                            if ($data->IsIFrameMode != 1) {
                                $data->GroupImage = Yii::app()->params['ServerURL'] . $groupData->GroupProfileImage;

                                /* for more */
                                $tagsFreeDescription = strip_tags(($groupData->GroupDescription));
                                $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);

                                $descriptionLength = strlen($tagsFreeDescription);
                                /* for more */


                                if ($descriptionLength > 240) {
                                    $description = CommonUtility::truncateHtml($groupData->GroupDescription, 240);
                                    $data->GroupDescription = trim($description) . Yii::t('translation','Readmore');
                                } else {
                                    $data->GroupDescription = $groupData->GroupDescription;
                                }



                                $data->GroupFollowersCount = sizeof($data->PostFollowers);
                                $data->IsFollowingPost = in_array($UserId, $data->PostFollowers);


                                if ($data->isDerivative == 0) {
                                    if ($isHomeStream == 1 && (!($data->IsFollowingEntity) || $isPromoted == 1)) {
                                        unset($streamPostData[$key]);
                                        continue;
                                    }
                                } else {
                                    
                                }
                            }
                        }
                    }
                }
                if ($data->CategoryType == 7) {
                    if (isset($data->SubGroupId)) {

                        $groupData = SubGroupCollection::model()->getSubGroupDetailsById($data->SubGroupId);
                        $gData = GroupCollection::model()->getGroupDetailsById($data->GroupId);

                        if ($groupData != "failure") {
                            $data->SubGroupImage = Yii::app()->params['ServerURL'] . $groupData->SubGroupProfileImage;
                            $data->SubGroupName = $groupData->SubGroupName;
                            $data->GroupName = $gData->GroupName;
                           if (isset($groupData->AddSocialActions)) {
                                        $data->AddSocialActions = $groupData->AddSocialActions;
                            }
                            /* for more */
                            $tagsFreeDescription = strip_tags(($groupData->SubGroupDescription));
                            $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);

                            $descriptionLength = strlen($tagsFreeDescription);
                            /* for more */

                            if ($descriptionLength > 240) {
                                $description = CommonUtility::truncateHtml($groupData->SubGroupDescription, 240);
                                $data->SubGroupDescription = trim($description) . Yii::t('translation','Readmore');
                            } else {
                                $data->SubGroupDescription = $groupData->SubGroupDescription;
                            }


                            $data->SubGroupFollowersCount = sizeof($groupData->SubGroupMembers);
                            $data->IsFollowingEntity = in_array($UserId, $groupData->SubGroupMembers);
                            if ($data->isDerivative == 0) {
                                if ($isHomeStream == 1 && (!($data->IsFollowingEntity) || $isPromoted == 1)) {
                                    unset($streamPostData[$key]);
                                    continue;
                                }
                            }
                        }
                    }
                }

                $data->IsPromoted = $isPromoted;
                if ($data->CategoryType == 9) {
                  try {
                 
                    
                        if ($data->UserId == 0) {
                            if (count($oneRecordArray) > 0) {
                                $key_1 = array_search($data->PostId, $oneRecordArray);
                                if (is_int($key_1)) {
                                    unset($streamPostData[$key]);
                                    continue;
                                }
                            }
                            $zeroRecordArray[$key] = $data->PostId;
                } else {
                            $oneRecordArray[$key] = $data->PostId;
                            if (count($zeroRecordArray) > 0) {
                                $key12 = array_search($data->PostId, $zeroRecordArray);
                                if (is_int($key12)) {
                                    unset($streamPostData[$key12]);
                                    //continue;
                                }
                            }
                        }
                          $dateFormat =  CommonUtility::getDateFormat();
                        $sDate = strtotime($data->StartDate);
                    $gameUserStatus = ScheduleGameCollection::model()->findUserGameStatus($UserId, $data->CurrentGameScheduleId, $data->StartDate);
                        $gameScheduls = ScheduleGameCollection::model()->getSchedulesForGame($data->PostId);
                       $gameSchedules = array();
                      
                       if (!is_string($gameScheduls)) {
                                foreach ($gameScheduls as $value) {

                                    $value['StartDate'] = date($dateFormat, CommonUtility::convert_date_zone($value['StartDate']->sec, "Asia/Kolkata", date_default_timezone_get()));
                                    $value['EndDate'] = date($dateFormat, CommonUtility::convert_date_zone($value['EndDate']->sec, "Asia/Kolkata", date_default_timezone_get()));

                                    array_push($gameSchedules, $value);
                                }
                                // $data->SchedulesArray = $gameSchedules;
                                $data->SchedulesArray = []; //for mobile schudules not 
                            } else {
                                $data->SchedulesArray = 'noschedules';
                            }
                            $data->GameStatus = $gameUserStatus;
                            $data->GameBannerImage = Yii::app()->params['ServerURL'] . $data->GameBannerImage;

                            /** this is logic for Previous Schedules */
                            $previousSchedule = $data->PreviousGameScheduleId;
                            if (isset($previousSchedule) && $previousSchedule != null) {
                                $gameUserStatusForPreviousSchedule = ScheduleGameCollection::model()->findUserGameStatusForPreviousSchedule($UserId, $previousSchedule, $data->StartDate);

                                $data->PreviousGameStatus = $gameUserStatusForPreviousSchedule;
                            }

                            if ($UserId == $data->OriginalUserId) {
                                $data->GameAdminUser = 1;
                            } else {
                                $data->GameAdminUser = 0;
                            }

                            $data->StartDate = date($dateFormat, CommonUtility::convert_date_zone($data->StartDate->sec, "Asia/Kolkata", date_default_timezone_get()));
                            $data->EndDate = date($dateFormat, CommonUtility::convert_date_zone($data->EndDate->sec, "Asia/Kolkata", date_default_timezone_get()));
                            $descriptionLength = strlen($data->GameDescription);
                            if ($descriptionLength > 100) {
                                $description = CommonUtility::truncateHtml($data->GameDescription, 100);
                                $data->GameDescription = trim($description) . Yii::t('translation', 'Readmore');
                            }

                            // $data->IsFollowingPost = in_array($UserId, $data->PostFollowers); 
                        
                        
                    } catch (Exception $ex) {
                        Yii::log("CommonUtility:prepareStreamDataForMobile_V3::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                        error_log("Exception Occurred in CommonUtility->prepareStreamDataForMobile_V3==".$ex->getMessage());
                    }  
                } else {
                    if (sizeof($streamIdArray) > 0) {
                        if (array_key_exists("$data->PostId", $streamIdArray)) {
                            if ($streamIdArray["$data->PostId"] == $isPromoted) {
                                unset($streamPostData[$key]);
                                continue;
                            }
//                        elseif($streamIdArray["$data->PostId"]==$isPromoted && $data->UserId!=0){                            
//                            unset($streamPostData[$key]);
//                        }
                        }
                    }
                }


                $streamIdArray["$data->PostId"] = $isPromoted;
                $data->SessionUserId = $UserId;
                $data->CanDeletePost = ($data->OriginalUserId == $data->SessionUserId) ? 1 : 0;
                if (is_array($UserPrivileges)) {
                    foreach ($UserPrivileges as $value) {
                        if ($value['Status'] == 1) {
                            if ($value['Action'] == 'Delete') {
                                $data->CanDeletePost = 1;
                            } else if ($value['Action'] == 'Promote_Post') {
                                $data->CanPromotePost = 1;
                            } else if ($value['Action'] == 'Promote_To_Featured_Items') {
                                $data->CanFeaturePost = 1;
                            } else if ($value['Action'] == 'Mark_As_Abuse') {
                                $data->CanMarkAsAbuse = 1;
                            }
                        }
                    }
                }

                $createdOn = $data->CreatedOn;
                $originalPostTime = $data->OriginalPostTime;
                if ($isPromoted == 1) {
                    $data->PostOn = CommonUtility::styleDateTime($originalPostTime->sec, 'mobile');
                    $data->PromotedDate = CommonUtility::styleDateTime($createdOn->sec);
                    $currentDate = date('Y-m-d', time());
                    $postPromotedDate = date('Y-m-d', $createdOn->sec);
                    if ($postPromotedDate < $currentDate) {
                        $data->IsPromoted = 0;
                    }
                    if ($data->CanPromotePost == 1) {
                        if ($postPromotedDate > $currentDate) {
                            $data->CanPromotePost = 0;
                        }
                    }
                    if ($data->CanDeletePost == 1 && $data->PromotedUserId != $UserId) {
                        $data->CanDeletePost = 0;
                    }
                } else {

                    $data->PostOn = CommonUtility::styleDateTime($createdOn->sec, 'mobile');

//                    if($data->CategoryType==2){
//                        $postDetails=  CurbsidePostCollection::model()->getPostById($data->PostId);
//                        $postCollectionDate=$postDetails->CreatedOn;
//                       $data->PostOn = CommonUtility::styleDateTime($postCollectionDate->sec); 
//                    }else if($data->CategoryType==1) {
//                        $postDetails=  PostCollection::model()->getPostById($data->PostId);
//                        $postCollectionDate=$postDetails->CreatedOn;
//                        $data->PostOn = CommonUtility::styleDateTime($postCollectionDate->sec); 
//                    }else{
//                        $data->PostOn = CommonUtility::styleDateTime($originalPostTime->sec);  
                    //  }
                }
                $data->OriginalPostPostedOn = CommonUtility::styleDateTime($originalPostTime->sec, 'mobile');
                $textWithOutHtml = $data->PostText;

                $textLength = strlen($textWithOutHtml);
                if (isset($data->WebUrls) && !empty($data->WebUrls) && $data->WebUrls != null) {
                    if (isset($data->IsWebSnippetExist) && $data->IsWebSnippetExist == '1') {
                        $snippetdata = WebSnippetCollection::model()->CheckWebUrlExist($data->WebUrls[0]);

                        $data->WebUrls = $snippetdata;
                    } else {
                        $data->WebUrls = "";
                    }
                }

//
//                /*for more*/
//                        $tagsFreeDescription= strip_tags(($data->PostText));
//                        $tagsFreeDescription = str_replace("&nbsp;", " ", $tagsFreeDescription);
//                 
//                        $descriptionLength =  strlen($tagsFreeDescription);
//                       
//                       /*for more*/
                // $textLength=strlen($textWithOutHtml);

                if (isset($data->PostTextLength) && $data->PostTextLength > 240 && $data->PostTextLength < 500) {
                    $appendData = '<span class="seemore tooltiplink"   onclick="expandpostDiv(' . "'" . $data->_id . "'" . ')"> <i class="fa fa-ellipsis-h moreicon moreiconcolor"></i></span>';
                } else {

                    $appendData = ' <span class="postdetail tooltiplink" data-id=' . $data->_id . '  data-postid="' . $data->PostId . '" data-categoryType="' . $data->CategoryType . '" data-postType="' . $data->PostType . '"> <i class="fa fa-ellipsis-h moreicon moreiconcolor"></i></span>';
                }
               $data->PostText =  CommonUtility::remove_unicode($data->PostText);
                  
                $data->PostCompleteText = $data->PostText;
                if ($data->PostTextLength > 240) {
                    $description = CommonUtility::truncateHtml($data->PostText, 240, '...', true, true, $appendData);

                    $text = $description;
 		if(($isHomeStream==1 && $data->IsNativeGroup==1) || $data->IsIFrameMode==1){                  
                $data->PostText = $data->PostText;                
                }
                    else{
                           $data->PostText = $text;                        
                    }                 
                }
                //  $data->PostText .= ' <span class="postdetail" data-postid="'.$data->PostId.'" data-categoryType="'.$data->CategoryType.'" data-postType="'.$data->PostType.'"> <i class="fa fa-ellipsis-h"></i></span>';
                $tinyOriginalUser = UserCollection::model()->getTinyUserCollection($data->OriginalUserId);
                $postType = CommonUtility::postTypebyIndex($data->PostType, $data->CategoryType);
                $data->PostTypeString = $postType;
                $createdOn = $data->CreatedOn;
                $originalPostTime = $data->OriginalPostTime;
                $recentActivity1UserId = "";
                $recentActivity2UserId = "";
                if ($data->RecentActivity == "Post") {
                    $recentActivity1UserId = $data->OriginalUserId;
                    $recentActivity2UserId = "";
                }
                //elseif ($data->RecentActivity=="HashTagFollow") {
                //   $recentActivity1UserId=$data->HashTagPostUserId;
                //           }
                elseif ($data->RecentActivity == "UserMention") {
                    $recentActivity1UserId = $data->MentionUserId;
                } elseif ($data->RecentActivity == "Love") {
                    $LoveUserId = array_values(array_unique($data->LoveUserId));
                    if (sizeof($LoveUserId) > 1) {
                        $recentActivity1UserId = $LoveUserId[sizeof($LoveUserId) - 1];
                        $recentActivity2UserId = $LoveUserId[sizeof($LoveUserId) - 2];
                    } elseif (sizeof($LoveUserId) == 1) {
                        $recentActivity1UserId = $LoveUserId[sizeof($LoveUserId) - 1];
                    }
                } elseif ($data->RecentActivity == "Comment") {
                    $CommentUserId = array_values(array_unique($data->CommentUserId));
                    if (sizeof($CommentUserId) > 1) {
                        $recentActivity1UserId = $CommentUserId[sizeof($CommentUserId) - 1];
                        $recentActivity2UserId = $CommentUserId[sizeof($CommentUserId) - 2];
                    } elseif (sizeof($CommentUserId) == 1) {
                        $recentActivity1UserId = $CommentUserId[sizeof($CommentUserId) - 1];
                    }
                } elseif ($data->RecentActivity == "UserFollow") {

                    $FollowUserId = array_values(array_unique($data->UserFollowers));
                    if (count($FollowUserId) > 1) {
                        $recentActivity1UserId = $FollowUserId[sizeof($FollowUserId) - 1];
                        $recentActivity2UserId = $FollowUserId[sizeof($FollowUserId) - 2];
                    } elseif (sizeof($FollowUserId) == 1) {
                        $recentActivity1UserId = $FollowUserId[sizeof($FollowUserId) - 1];
                    }
                } elseif ($data->RecentActivity == "PostFollow") {
                    $PostFollow = array_values(array_unique($data->PostFollowers));
                    if (count($PostFollow) > 1) {
                        $recentActivity1UserId = $PostFollow[sizeof($PostFollow) - 1];
                        $recentActivity2UserId = $PostFollow[sizeof($PostFollow) - 2];
                    } elseif (sizeof($PostFollow) == 1) {
                        $recentActivity1UserId = $PostFollow[sizeof($PostFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "EventAttend") {
                    $EventAttendes = array_values(array_unique($data->EventAttendes));
                    if (sizeof($EventAttendes) > 1) {
                        $recentActivity1UserId = $EventAttendes[sizeof($EventAttendes) - 1];
                        $recentActivity2UserId = $EventAttendes[sizeof($EventAttendes) - 2];
                    } elseif (sizeof($EventAttendes) == 1) {
                        $recentActivity1UserId = $EventAttendes[sizeof($EventAttendes) - 1];
                    }
                } elseif ($data->RecentActivity == "Invite") {
                    $InviteUsers = array_values(array_unique($data->InviteUsers));
                    if (sizeof($InviteUsers) > 1) {
                        $recentActivity1UserId = $InviteUsers[sizeof($InviteUsers) - 1];
                        $recentActivity2UserId = $InviteUsers[sizeof($InviteUsers) - 2];
                    } elseif (sizeof($InviteUsers) == 1) {
                        $recentActivity1UserId = $InviteUsers[sizeof($InviteUsers) - 1];
                    }
                } elseif ($data->RecentActivity == "Survey") {
                    $SurveyTaken = array_values(array_unique($data->SurveyTaken));
                    if (sizeof($SurveyTaken) > 1) {
                        $recentActivity1UserId = $SurveyTaken[sizeof($SurveyTaken) - 1];
                        $recentActivity2UserId = $SurveyTaken[sizeof($SurveyTaken) - 2];
                    } elseif (sizeof($SurveyTaken) == 1) {
                        $recentActivity1UserId = $SurveyTaken[sizeof($SurveyTaken) - 1];
                    }
                } elseif ($data->RecentActivity == "GroupFollow") {
                    $GroupFollow = array_values(array_unique($data->GroupFollowers));
                    if (sizeof($GroupFollow) > 1) {
                        $recentActivity1UserId = $GroupFollow[sizeof($GroupFollow) - 1];
                        $recentActivity2UserId = $GroupFollow[sizeof($GroupFollow) - 2];
                    } elseif (sizeof($GroupFollow) == 1) {
                        $recentActivity1UserId = $GroupFollow[sizeof($GroupFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "CurbsideCategoryFollow") {
                    $CurbsideFollow = array_values(array_unique($data->CurbsideCategoryFollowers));
                    if (sizeof($CurbsideFollow) > 1) {
                        $recentActivity1UserId = $CurbsideFollow[sizeof($CurbsideFollow) - 1];
                        $recentActivity2UserId = $CurbsideFollow[sizeof($CurbsideFollow) - 2];
                    } elseif (sizeof($CurbsideFollow) == 1) {
                        $recentActivity1UserId = $CurbsideFollow[sizeof($CurbsideFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "HashTagFollow") {
                    $recentActivity1UserId = $data->HashTagPostUserId;
                    $HashTagFollow = array_values(array_unique($data->HashTagFollowers));
                    if (sizeof($HashTagFollow) > 1) {
                        $recentActivity1UserId = $HashTagFollow[sizeof($HashTagFollow) - 1];
                        $recentActivity2UserId = $HashTagFollow[sizeof($HashTagFollow) - 2];
                    } elseif (sizeof($HashTagFollow) == 1) {
                        $recentActivity1UserId = $HashTagFollow[sizeof($HashTagFollow) - 1];
                    }
                } elseif ($data->RecentActivity == "Play") {
                    if (isset($data->CurrentScheduledPlayers)) {
                        $PlayedUsers = array_values(array_unique($data->CurrentScheduledPlayers));
                        if (sizeof($PlayedUsers) > 1) {
                            $recentActivity1UserId = $PlayedUsers[sizeof($PlayedUsers) - 1]['UserId'];
                            $recentActivity2UserId = $PlayedUsers[sizeof($PlayedUsers) - 2]['UserId'];
                        } elseif (sizeof($PlayedUsers) == 1) {
                            $recentActivity1UserId = $PlayedUsers[sizeof($PlayedUsers) - 1]['UserId'];
                        }
                    }
                } elseif ($data->RecentActivity == "Schedule") {
                    $recentActivity2UserId = $data->OriginalUserId;
                }

                $recentActivityUser1 = UserCollection::model()->getTinyUserCollection($recentActivity1UserId);
                if (!empty($recentActivity2UserId)) {
                    $recentActivityUser2 = UserCollection::model()->getTinyUserCollection($recentActivity2UserId);
                }
                $whosePost = "";
                if ($data->ActionType == 'Comment' || $data->ActionType == 'Follow' || $data->ActionType == 'EventAttend' || $data->ActionType == 'Invite') {
                    if ($data->OriginalUserId == $UserId) {
                        $whosePost = "your";
                    } elseif (in_array($data->OriginalUserId, array_unique($data->UserFollowers)) || in_array($data->OriginalUserId, array_unique($data->PostFollowers))) {
                        $whosePost = $tinyOriginalUser['DisplayName'];
                    }
                }
                $userId1 = $recentActivityUser1['UserId'];
                $userId2 = "";
                $displayName1 = $UserId == $recentActivityUser1['UserId'] ? 'You' : $recentActivityUser1['DisplayName'];
                if ($PostAsNetwork == 1) {
                    $displayName1 = $recentActivityUser1['DisplayName'];
                }
                $displayName2 = "";
                $secondUser = "";
                if (!empty($recentActivityUser2)) {
                    $userId2 = $recentActivityUser2['UserId'];
                    $displayName2 = $UserId == $recentActivityUser2['UserId'] ? 'You' : $recentActivityUser2['DisplayName'];
                    if ($PostAsNetwork == 1) {
                        $displayName2 = $recentActivityUser2['DisplayName'];
                    }
                    if ($displayName2 == "You") {
                        $displayName2 = $displayName1;
                        $displayName1 = "You";
                        $temp = $userId1;
                        $userId1 = $userId2;
                        $userId2 = $temp;
                    }
                    $secondUser = ", <a class='userprofilename' data-id='" . $userId2 . "' style='cursor:pointer'><b>" . $displayName2 . "</b></a>";
                }

                $data->FirstUserId = $userId1;
                $data->FirstUserDisplayName = $displayName1;
                if ($data->CategoryType == 13) {
                    $data->FirstUserProfilePic =$data->NetworkLogo;
                }
                else{
                    $data->FirstUserProfilePic = $recentActivityUser1['profile250x250'];
                }
                $data->SecondUserData = $secondUser;
                $data->PostBy = $whosePost;
                $data->OriginalUserDisplayName = $tinyOriginalUser['DisplayName'];
                $data->OriginalUserProfilePic = $tinyOriginalUser['profile70x70'];
                $data->IsFollowingPost = in_array($UserId, $data->PostFollowers);
                $data->IsLoved = in_array($UserId, $data->LoveUserId);
                $data->FbShare = isset($data->FbShare) && is_array($data->FbShare) ? in_array($UserId, $data->FbShare) : 0;
                $data->TwitterShare = isset($data->TwitterShare) && is_array($data->TwitterShare) ? in_array($UserId, $data->TwitterShare) : 0;
                $data->IsSurveyTaken = in_array($UserId, $data->SurveyTaken);
                $data->TotalSurveyCount = $data->OptionOneCount + $data->OptionTwoCount + $data->OptionThreeCount + $data->OptionFourCount;
                if (isset($data->OptionFour) && !empty($data->OptionFour))
                    $data->IsOptionDExist = 1;

                $image = "";
                if ($data->IsMultiPleResources > 0) {

                    if (isset($data->Resource["ThumbNailImage"])) {
                        $data->ArtifactIcon = Yii::app()->params['ServerURL'] . "" . $data->Resource["ThumbNailImage"];
                        $data->Resource["Uri"]= Yii::app()->params['ServerURL'] . "" . $data->Resource["Uri"];
                           if(isset($data->Resource["Height"])){
                                if($data->Resource["Height"]!=null && $data->Resource["Height"]!="") {                   
                            $data->Resource["Height"] = (100/$data->Resource["Width"])* $data->Resource["Height"] ;
                            }else{
                                 $data->Resource["Height"]="";
                            }
                           }
                           
                        } else {
                            
                        $data->ArtifactIcon = "";
                    }
                }
                if ($secondUser != "") {
                    if (trim($data->StreamNote) == "is following") {
                        $data->StreamNote = " are following";
                    }
                    if (trim($data->StreamNote) == "is attending") {
                        $data->StreamNote = " are attending";
                    }
                    if (trim($data->StreamNote) == "has answered") {
                        $data->StreamNote = " have answered";
                    }
                    if (trim($data->StreamNote) == "is Played") {
                        $data->StreamNote = " are Played";
                    }
                    if (trim($data->StreamNote) == "has Played") {
                        $data->StreamNote = " have Played ";
                    }
                }
                if ($UserId == $recentActivityUser1['UserId'] && trim($secondUser) == "") {


                    if (trim($data->StreamNote) == "is following") {
                        $data->StreamNote = " are following";
                    }
                    if (trim($data->StreamNote) == "is attending") {
                        $data->StreamNote = " are attending";
                    }
                    if (trim($data->StreamNote) == "has answered") {
                        $data->StreamNote = " have answered";
                    }if (trim($data->StreamNote) == "is Played") {
                        $data->StreamNote = " Played";
                    }
                    if (trim($data->StreamNote) == "has invited to") {
                        $data->StreamNote = " have invited to ";
                    }
                    if (trim($data->StreamNote) == "has Played") {
                        $data->StreamNote = " have Played ";
                    }
                }

                if ($data->PostType == 4) {
                    $data->PostBy = "";
                    if ($data->ActionType == "Post") {
                        $data->PostBy = "";
                        $data->FirstUserDisplayName = "";
                        $data->FirstUserProfilePic = "/images/icons/user_noimage.png";
                        $data->SecondUserData = "";
                        $data->StreamNote= "A new post has been created";
                        $data->PostTypeString = "";
                    }
                }
//                 if($data->UserId == 0 && $data->CategoryType == 1){
//                      $data->StreamNote = " made ";
//                     
//                 }
//                  if($data->UserId == 0 && $data->CategoryType == 2){
//                      $data->StreamNote = " posted ";
//                     
//                 }

                if ($data->PostType == 2) {

                    $eventStartDate = CommonUtility::convert_time_zone($data->StartDate->sec, $timezone, '', 'sec');
                    $eventEndDate = CommonUtility::convert_time_zone($data->EndDate->sec, $timezone, '', 'sec');
                    $data->Title = $data->Title;
                    $data->StartDate = date("Y-m-d", $eventStartDate);
                    $data->EndDate = date("Y-m-d", $eventEndDate);
                    $data->EventStartDay = date("d", $eventStartDate);
                    $data->EventStartDayString = date("l", $eventStartDate);
                    $data->EventStartMonth = date("M", $eventStartDate);
                    $data->EventStartYear = date("Y", $eventStartDate);
                    $data->EventEndDay = date("d", $eventEndDate);
                    $data->EventEndDayString = date("l", $eventEndDate);
                    $data->EventEndMonth = date("M", $eventEndDate);
                    $data->EventEndYear = date("Y", $eventEndDate);
                    $data->StartTime = date("h:i A", $eventStartDate);
                    $data->EndTime = date("h:i A", $eventEndDate);
                    if ($eventEndDate <= CommonUtility::currentSpecifictime_timezone($timezone)) {
                        $data->CanPromotePost = 0;
                        $data->IsEventAttend = 1;
                    } else {
                        $data->IsEventAttend = in_array($UserId, $data->EventAttendes);
                    }
                } elseif ($data->PostType == 3) {


                    $surveyExpiryDate = $data->ExpiryDate;
                    $data->Title = $data->Title;
                    if (isset($surveyExpiryDate->sec) && $surveyExpiryDate->sec <= time()) {
                        $data->CanPromotePost = 0;
                        $data->ExpiryDate = date("Y-m-d", $surveyExpiryDate->sec);
                    }
                    $surveyExpiryDate_tz = CommonUtility::convert_date_zone($surveyExpiryDate->sec, $timezone);
                    $currentDate_tz = CommonUtility::currentdate_timezone($timezone);
                    if ($surveyExpiryDate_tz < $currentDate_tz) {
                        $data->IsSurveyTaken = true; //expired
                    }
                }

                $comments = $data->Comments;
                $commentCount = sizeof($comments);
                $data->CommentCount = $data->CommentCount;
                $commentsArray = array();
                if ($commentCount > 0) {
                    $data->IsCommented = in_array((int) $UserId, $data->CommentUserId);
                    //$maxDisplaySize = $commentCount>2?2:$commentCount;
                    $commentsDisplayCount = 0;
                    for ($j = $commentCount; $j > 0; $j--) {
                        $comment = $comments[$j - 1];
                        $isBlockedComment = isset($comment['IsBlockedWordExist']) ? $comment['IsBlockedWordExist'] : 0;
                         $isAbusedComment = isset($comment['IsAbused']) ? $comment['IsAbused'] : 0;
                        if ($isBlockedComment != 1 && $isAbusedComment!=1) {
                            $commentsDisplayCount++;
                            $commentedUser = UserCollection::model()->getTinyUserCollection($comment["UserId"]);
                            $comment["CreatedOn"] = $comment["CreatedOn"];
                            $textWithOutHtml = $comment["CommentText"];

                            if (isset($comment['WebUrls']) && !empty($comment['WebUrls']) && $comment['WebUrls'] != null) {

                                if (isset($comment['IsWebSnippetExist']) && $comment['IsWebSnippetExist'] == '1') {
                                    $CommentSnippetdata = WebSnippetCollection::model()->CheckWebUrlExist($comment['WebUrls'][0]);
                                    $comment['WebUrls'] = $CommentSnippetdata;
                                } else {

                                    $comment['WebUrls'] = "";
                                }
                            }
                            if (isset($comment["CommentTextLength"]) && $comment["CommentTextLength"] > 240) {

                                $appendCommentData = ' <span class="postdetail tooltiplink" data-id="' . $data->_id . '"   data-postid="' . $data->PostId . '" data-categoryType="' . $data->CategoryType . '" data-postType="' . $data->PostType . '"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                                // $description = CommonUtility::truncateHtml($comment["CommentText"], 240,$appendCommentData);
                                $description = CommonUtility::truncateHtml($comment["CommentText"], 240, 'Read more', true, true, $appendCommentData);
                                $text = $description;

                                $comment["CommentText"] = str_replace("&nbsp;"," ",$text);
                            } else {

                                $comment["CommentText"] =  str_replace("&nbsp;"," ",$comment["CommentText"]);
                            }
                            $comment['ProfilePicture'] = $commentedUser['profile70x70'];
                            $commentCreatedOn = $comment["CreatedOn"];
                            $comment["CreatedOn"] = CommonUtility::styleDateTime($commentCreatedOn->sec, 'mobile');
                            $comment["DisplayName"] = $commentedUser['DisplayName'];
                            $image = "";
                            $height="";
                            if (sizeof($comment["Artifacts"]) > 0) {
                                if (isset($comment["Artifacts"]['ThumbNailImage'])) {
                                    $image = Yii::app()->params['ServerURL'] . "" . $comment["Artifacts"]['ThumbNailImage'];
                               if(isset($comment["Artifacts"]['Height'])){
                                   $height = $comment["Artifacts"]['Height'];
                                if(isset($comment["Artifacts"]["Height"])&& !empty($comment["Artifacts"]["Height"])){
                               $height = (100/$comment["Artifacts"]["Width"])* $comment["Artifacts"]["Height"];
                                }  
                               }
                                  
                                    $ArtifactExtension=$comment["Artifacts"]['Extension'];
                                    $comment["ArtifactExtension"] = strtolower($ArtifactExtension);
                                    
                                } else {
                                    $image = "";
                                    $height="";
                                    $comment["ArtifactExtension"] = "";
                                }
                            }
                            $comment["ArtifactIcon"] = $image;
                             $comment["Height"] = $height;
                           
                            array_push($commentsArray, $comment);
                            if ($commentsDisplayCount == 2) {
                                break;
                            }
                        }
                    }
                }
                $data->Comments = $commentsArray;
                if ($data->CategoryType == 3) {
                    if (isset($data->GroupId)) {
                        $data->PostTypeString = " " . $data->PostTypeString;
                    }
                }
                if ($data->CategoryType == 7) {
                    if (isset($data->SubGroupId)) {
                        $data->PostTypeString = " " . $data->PostTypeString;
                    }
                }


                /**
                 * follow Object  post type
                 * post type user is 6
                 * post type hashtag 7
                 * post type curbsidecategory 8
                 * post  type group 9
                 */
                if ($data->PostType == 9) {
                    if (isset($data->GroupId)) {
                        $groupData = GroupCollection::model()->getGroupDetailsById($data->GroupId);

                        $data->GroupImage = Yii::app()->params['ServerURL'] . $groupData->GroupProfileImage;
                        $data->GroupName = $groupData->GroupName;

                        if (strlen($groupData->GroupDescription) > 240) {
                            $description = CommonUtility::truncateHtml($groupData->GroupDescription, 240);
                            $data->GroupDescription = $description . Yii::t('translation','Readmore');
                        } else {
                            $data->GroupDescription = $groupData->GroupDescription;
                        }
                        //$data->GroupDescription = $groupData->GroupDescription;
                        $data->GroupFollowersCount = sizeof($groupData->GroupMembers);
                        $data->IsFollowingEntity = in_array($UserId, $groupData->GroupMembers);
                        $data->PostTypeString = " Group ";
                    }
                }

                if ($data->PostType == 10) {
                    if (isset($data->SubGroupId)) {
                        $groupData = SubGroupCollection::model()->getSubGroupDetailsById($data->SubGroupId);
                        $data->SubGroupImage = Yii::app()->params['ServerURL'] . $groupData->SubGroupProfileImage;
                        $data->SubGroupName = $groupData->SubGroupName;

                        if (strlen($groupData->SubGroupDescription) > 240) {
                            $description = CommonUtility::truncateHtml($groupData->GroupDescription, 240);
                            $data->SubGroupDescription = $description . Yii::t('translation','Readmore');
                        } else {
                            $data->SubGroupDescription = $groupData->SubGroupDescription;
                        }
                        //$data->GroupDescription = $groupData->GroupDescription;
                        $data->SubGroupFollowersCount = sizeof($groupData->SubGroupMembers);
                        $data->IsFollowingEntity = in_array($UserId, $groupData->SubGroupMembers);
                        $data->PostTypeString = " Sub Group ";
                    }
                }
                if ($data->PostType == 7) {
                    $data->PostTypeString = " #Tag";
                    $data->GroupImage = Yii::app()->params['ServerURL'] . "/images/icons/hashtag_img.png";
                    $data->HashTagName = $data->HashTagName;
                    $data->GroupDescription = "";
                    $data->HashTagPostCount = count($data->HashTagFollowers);

                    $data->IsFollowingEntity = in_array($UserId, $data->HashTagFollowers);
                    $data->PostTypeString = " " . $data->HashTagName;
                }
                if ($data->PostType == 8) {
                    $name = Yii::t('translation', 'CurbsideConsult');
                    $data->PostTypeString = " $name Category";
                    $data->GroupImage = Yii::app()->params['ServerURL'] . "/images/icons/curbesidepost_img.png";
                    $data->CurbsideConsultCategory = $data->CurbsideConsultCategory;
                    $data->GroupDescription = "";
                    // $data->CurbsidePostCount =  $data->CurbsidePostCount;
                    $data->CurbsidePostCount = sizeof($data->CurbsideCategoryFollowers);
                    $data->IsFollowingEntity = in_array($UserId, $data->CurbsideCategoryFollowers);
                    $data->PostTypeString = " " . $data->PostTypeString;
                }
                if ($data->PostType == 11) {
                  
                  $pattern = '/object/';
                    if(preg_match($pattern, $data->HtmlFragment)){
                        
                        $data->IsVideo = 1;
                    }else{
                         
                         $data->IsVideo = 0;
                        
                    }
                    if($isHomeStream==1){
                        $width="width='100'";
                        $height="height='100'";
                    }else{
                          $width="width='250'";
                        $height="height='250'";
                    }
                    $pattern = '/(width)="[0-9]*"/';
                    $string=$data->HtmlFragment;
                    $string = preg_replace($pattern, $width, $string);
                    $pattern = '/(height)="[0-9]*"/';
                    $string = preg_replace($pattern, $height, $string);

                    $data->HtmlFragment = $string;
                    $data->IsNotifiable = (int) $data->IsNotifiable;
                    $data->PublicationDate = CommonUtility::styleDateTime(strtotime($data->PublicationDate), "mobile");
                    if ($data->Editorial != '') {
                        $editorial = $data->Editorial;
                        if (strlen($data->Editorial) > 240) {
                            $editorial = substr($editorial, 0, 240);
                            $editorial = $editorial . '<a class="showmore postdetail" data-id="' . $data->PostId . '">&nbsp<i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></a>';
                        }
                        $data->Editorial = $editorial;
                    }
                }elseif ($data->PostType == 13) {
                    $data->PostTypeString = $data->BadgeName." badge";
                }
                
                

if ($data->CategoryType == 13) {
           
    $date = date('Y-m-d');
    $sdate =$data->StartDate;
    $exdate=$data->ExpiryDate;
    $sdate =date("Y-m-d",$sdate->sec);
    $exdate =date("Y-m-d",$exdate->sec);
$redirectUrl=$data->RedirectUrl;
    
if($data->AdType==3){
    
    $requestedFieldsArray=  explode(",", $data->RequestedFields);
    $QueryParms;
    $userobj = UserCollection::model()->getTinyUserCollection($UserId);
    $md5=md5($UserId."_".$data->AdvertisementId);
    foreach($requestedFieldsArray as  $value){
        $customUserId=null;
         $customdisplayName=null;
         if ($data->RequestedParams != "" && $data->RequestedParams != null) {
            $reqParms = explode(',', $data->RequestedParams);
            
            foreach ($reqParms as $param) {
                $paramList = explode(':', $param);
                if (trim($paramList[0]) == "UserId") {
                   $customUserId=$paramList[1];
                }
                if (trim($paramList[0]) == "Display Name") {
                   $customdisplayName=$paramList[1];
                }
            }
        }

        $QueryParms=($QueryParms==""?$QueryParms:$QueryParms."&");
       if($value=="UserId"){
           if($customUserId==null){
              $QueryParms.=trim($value)."=".$md5;   
           }
           else{
               $QueryParms.=trim($customUserId)."=".$md5;
           }
          
       }
       if(trim($value)=="Display Name"){
           if($customdisplayName==null){
             $QueryParms.=trim($value)."=".$userobj->DisplayName;   
           }
           else{
              $QueryParms.=trim($customdisplayName)."=".$userobj->DisplayName;     
           }
            
       }
       if(trim($value)=="Email"){
           $QueryParms.=trim($value)."=".Yii::app()->session['Email'];  
       }
    }
     $QueryParms=str_replace(' ', '', $QueryParms);
    
   if(stristr($redirectUrl,"?")==""){
      $redirectUrl.="?".$QueryParms."&NeoId=".$md5; 
   } else{
      $redirectUrl.="&".$QueryParms."&NeoId=".$md5;  
   } 
  
}

if($data->IsNotifiable==1 && $sdate<=$date && $date<=$exdate){$data->IsNotifiable=1;}else{$data->IsNotifiable=0;}

$data->RedirectUrl=$redirectUrl;



                }
                $data->PostId = (String) $data->PostId;
                $data->_id = (String) $data->_id;
                array_push($currentStreamIdArray, (string)$data->PostId);
                }else{
                    
                    unset($streamPostData[$key]);
                    continue;
                }
            }
            //if($isHomeStream == 1){
                
                return array('streamPostData'=>$streamPostData, 'streamIdArray'=>$currentStreamIdArray,"totalStreamIdArray"=>$totalStreamIdArray);
//            }else{
//                return $streamPostData;
//            }

        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareStreamDataForMobile_V3::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareStreamDataForMobile_V3==".$ex->getMessage());
        }
    }

    public static function prepareCommentObject($rs, $commentDisplayCount = 0) {
        try {
            $commentCount = 0;
            $MoreCommentsArray = array();
            foreach ($rs as $key => $value) {
                 $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
                        $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
                        if(!$IsBlockedWordExist && !$IsAbused){
               // if (!(isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist'] == 1) && !(isset($value['IsAbused']) && $value['IsAbused'] == 1) ) {
                    $commentUserBean = new CommentUserBean();
                    $userDetails = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($value['UserId']);
                    $createdOn = $value['CreatedOn'];
                    $commentUserBean->UserId = $userDetails['UserId'];

                    $postId = (isset($value["PostId"])) ? $value["PostId"] : '';
                    $CategoryType = (isset($value["CategoryType"])) ? $value["CategoryType"] : '';
                    $PostType = (isset($value["PostType"])) ? $value["PostType"] : '';
                    $value["CommentText"] = $value["CommentText"];
                    $commentUserBean->CommentText = str_replace("&nbsp;", " ", $value['CommentText']);
                    if (is_int($createdOn)) {
                        
                        $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn, "mobile");
                    } else if (is_numeric($createdOn)) {
                        
                        $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn, "mobile");
                    } else {
                        
                        $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn->sec, "mobile");
                    }

                    $commentUserBean->DisplayName = $userDetails['DisplayName'];
                    $commentUserBean->ProfilePic = $userDetails['profile70x70'];
                    $commentUserBean->CategoryType = $CategoryType;
                    $commentUserBean->PostId = $postId;
                    $commentUserBean->Type = $PostType;
                    foreach ($value['Artifacts'] as $key => $artifact) {
                        $value['Artifacts'][$key]['VideoImageExist'] = 1;
                        $filetype = strtolower($artifact["Extension"]);
                        $value['Artifacts'][$key]['Uri'] = Yii::app()->params['ServerURL'] . $artifact['Uri'];
                        if ($filetype == 'mp4' || $filetype == 'mov' || $filetype == 'flv') {
                            $filename = "/images/system/video_img.png";
                            if (file_exists($artifact["ThumbNailImage"])) {
                                $filename = $artifact["ThumbNailImage"];
                            }else{
                                $value['Artifacts'][$key]['VideoImageExist'] = 0;
                            }
                            $value['Artifacts'][$key]['ThumbNailImage'] = Yii::app()->params['ServerURL'] . $filename;
                        } else if ($filetype == 'mp3') {
                            $filename = "/images/system/audio_img.png";
                            if (file_exists($artifact["ThumbNailImage"])) {
                                $filename = $artifact["ThumbNailImage"];
                            }else{
                                $value['Artifacts'][$key]['VideoImageExist'] = 0;
                            }
                            $value['Artifacts'][$key]['ThumbNailImage'] = Yii::app()->params['ServerURL'] . $filename;
                        }else{
                            $value['Artifacts'][$key]['ThumbNailImage'] = Yii::app()->params['ServerURL'].$artifact['ThumbNailImage'];
                        }
                    }
                    $commentUserBean->Resource = $value['Artifacts'];
                    $commentUserBean->ResourceCount = count($commentUserBean->Resource);
                    $commentUserBean->ResourceLength = count($value['Artifacts']);
                    //$commenturls=$value['WebUrls'];
                    if (array_key_exists('WebUrls', $value)) {
                        $snippetData = "";
                        if (isset($value['WebUrls']) && is_array($value['WebUrls']) && count($value['WebUrls']) > 0) {
                            $commenturls = $value['WebUrls'];
                            $WeburlObj = ServiceFactory::getSkiptaPostServiceInstance()->CheckWebUrlExist($commenturls[0]);
                            if ($WeburlObj != 'failure') {
                                $snippetData = $WeburlObj;
                            }
                        }
                        $commentUserBean->snippetdata = $snippetData;
                         $commentUserBean->CommentId =  (string)$value['CommentId'];
                         $commentUserBean->NetworkId =  $value['NetworkId'];
                        if (isset($value['IsWebSnippetExist'])) {
                            $commentUserBean->IsWebSnippetExist = $value['IsWebSnippetExist'];
                        } else {
                            $commentUserBean->IsWebSnippetExist = "";
                        }
                    }

                    array_push($MoreCommentsArray, $commentUserBean);
                    $commentCount++;
                    if ($commentDisplayCount != 0 && $commentCount == $commentDisplayCount) {
                        break;
                    }
                }
            }
            return $MoreCommentsArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareCommentObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareCommentObject==".$ex->getMessage());
        }
    }

    /**
     * @author Haribabu 
     *  get the intervals bettwo dates
     * @param type array
     */
    public static function GetIntervalsBetweenTwoDates($startDate, $endDate) {
        try {
            $valid_times = array();
            $finalArray = array();
            $dateFrom = new DateTime($startDate);
            $dateTo = new DateTime($endDate);

            $interval = date_diff($dateFrom, $dateTo);
            $diff = $interval->format('%R%a');

            $intervals = ceil($diff / 10);
            if ($diff > 365) {

                $finalArray = CommonUtility::get_years($startDate, $endDate);
            } elseif ($diff > 92 && $diff <= 365) {
                $finalArray = CommonUtility::get_months($startDate, $endDate);
            } elseif ($diff > 31 && $diff <= 92) {
                $finalArray = CommonUtility::get_weeks($startDate, $endDate);
            } elseif ($diff <= 31) {

                $finalArray = CommonUtility::get_dates($startDate, $endDate);
            }

            return $finalArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:GetIntervalsBetweenTwoDates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

  
    public static function prepareNotificationMessage($data, $reqUserId, $respondedUserList, $totalArray, $notifications, $deviceType) {
        try{
        $notificationMessage = "";
        $who = "";
        $action = "";
        $postType = "";
        $actionedUserCount = 1;
        $isAnonymous = (int)$data->IsAnonymous;
        $isMine = 1;
        $whose = "";
        
        if ($data->RecentActivity != "UserFollow") {
            $postType = CommonUtility::getTranslatedPostTypebyIndex((int) $data->PostType, (int) $data->CategoryType);
        }
        $tinyOriginalUserObject = null;

        
        if (isset($data->OriginalUserId) && $data->OriginalUserId != $reqUserId) {
            
            $tinyOriginalUserObject = UserCollection::model()->getTinyUserCollection($data->OriginalUserId);
            if ((int) $data->PostType != 4 && $data->IsAnonymous != 1) {
                if (isset($tinyOriginalUserObject->DisplayName)) {
                    $isMine = 0;
                    $whose = "<b class='notification_displayname'>$tinyOriginalUserObject->DisplayName</b>";
                }
            }else{
                if($data->OriginalUserId == $reqUserId){
                   $isMine = 1;  
                }else{
                     $isMine = 0;
                }
            }
        }
        if ($data->RecentActivity == "post") {
            $tinyUserObject = UserCollection::model()->getTinyUserCollection($data->OriginalUserId);
            if (is_object($tinyUserObject)) {
                $notifications->DisplayName = $tinyUserObject->DisplayName;
                $notifications->ProfilePic = $tinyUserObject->profile70x70;
                $who = "<b class='notification_displayname'>$tinyUserObject->DisplayName</b>";
            }
        } else if ($data->RecentActivity == "invite") {
            $tinyUserObject = UserCollection::model()->getTinyUserCollection($data->InviteUserId);
            if (is_object($tinyUserObject)) {
                $who = "<b class='notification_displayname'>$tinyUserObject->DisplayName</b>";
                $notifications->DisplayName = $tinyUserObject->DisplayName;
                $notifications->ProfilePic = $tinyUserObject->profile70x70;
                
            }
        } else {
            if (is_array($respondedUserList) && sizeof($respondedUserList) >= 2) {
                $firstUserId = end($respondedUserList);
                $nextUserId = prev($respondedUserList);
                if ((isset($firstUserId) && !empty($firstUserId)) || ($firstUserId == $nextUserId)) {
                    $tinyUserObject = UserCollection::model()->getTinyUserCollection($firstUserId);
                    if (is_object($tinyUserObject)) {
                        $who = "<b class='notification_displayname'>$tinyUserObject->DisplayName</b>";
                    }
                }
                if (isset($nextUserId) && !empty($nextUserId) && ($firstUserId != $nextUserId)) {
                    $actionedUserCount = sizeof($respondedUserList);
                    $tinyUserObject = UserCollection::model()->getTinyUserCollection($nextUserId);
                    if (is_object($tinyUserObject)) {
                        $who = "$who, <b class='notification_displayname'>$tinyUserObject->DisplayName</b>";
                    }
                }
            } else if (is_array($respondedUserList) && sizeof($respondedUserList) > 0) {
                $firstUserId = end($respondedUserList);
                if (isset($firstUserId) && !empty($firstUserId)) {
                    $tinyUserObject = UserCollection::model()->getTinyUserCollection($firstUserId);
                    if (is_object($tinyUserObject)) {
                        $notifications->DisplayName = $tinyUserObject->DisplayName;
                        $notifications->ProfilePic = $tinyUserObject->profile70x70;
                        $who = "<b class='notification_displayname'>$tinyUserObject->DisplayName</b>";
                    }
                }
            }
        }
        
        $recentActivity = $data->RecentActivity;
        if($recentActivity == "love"){
            $action = Yii::t('posttypes', "loved");
            $notificationMessage = CommonUtility::notificationStringForLove($who, $action, $postType, $actionedUserCount, $isAnonymous, $isMine, $whose);
        }else if($recentActivity == "comment"){
            $action = Yii::t('posttypes', "commented");
            $hashtag = isset($data->Hashtag)?$data->Hashtag:"";
            if($hashtag!=""){
                $postType = Yii::t('posttypes', "comment");
            }
            $notificationMessage = CommonUtility::notificationStringForComment($who, $action, $postType, $actionedUserCount, $isAnonymous, $isMine, $whose, $hashtag);
        }else if($recentActivity == "follow"){
            $action = Yii::t('posttypes', "following");
            $notificationMessage = CommonUtility::notificationStringForFollow($who, $action, $postType, $actionedUserCount, $isAnonymous, $isMine, $whose);
        }else if($recentActivity == "invite"){
            $action = Yii::t('posttypes', "inviting");
            $postTypeId = $data->PostType;
            $notificationMessage = CommonUtility::notificationStringForInvite($who, $action, $postType, $postTypeId);
        }else if($recentActivity == "mention"){
            if($isAnonymous==1){
            $who = "<b class='notification_displayname'>Someone</b>";
            $notifications->ProfilePic='';
            }
            $action = Yii::t('posttypes', "mentioned");
            $postTypeId = $data->PostType;
            $notificationMessage = CommonUtility::notificationStringForMention($who, $action, $postType, $postTypeId);
        }else if($recentActivity == "UserFollow"){
            $action = Yii::t('posttypes', "following");
            $notificationMessage = CommonUtility::notificationStringForUserFollow($who, $action, $actionedUserCount);
        }else if($recentActivity == "post"){
            $hashtag = $data->Hashtag; 
            $curbsideCategory = $data->CurbsideCategory;
            $notificationMessage = CommonUtility::notificationStringForPost($who, $postType, $hashtag, $curbsideCategory);
        }
        
        if (!empty($who) && $who!="") {
            $createdOn = $data->CreatedOn;
            $notifications->CreatedOn = CommonUtility::styleDateTime($createdOn->sec, $deviceType);
            $notifications->NotificationString = $notificationMessage;
            $notifications->IsRead = $data->isRead;
            $notifications->_id = $data->_id;
            $notifications->PostId = $data->PostId;
            $notifications->PostType = $data->PostType;
            $notifications->CategoryType = $data->CategoryType;
            array_push($totalArray, $notifications);
        }

        return $totalArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareNotificationMessage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

            

    /**
     * @author Kishore
     * @param 
     * @return array
     */
    public static function prepareStringToNotification($Ndata,$reqUserId,$isNHistory,$deviceType="web"){
        try{
            $totalArray = array();
            $adminSystemArray = array();
            $totalNotificationTobeShownCount=1;
            $adminArray = $systemArray = array();
            foreach($Ndata as $data){
                 try{
                $notifications = new NotificationBean();
                $userName = "";
//                $postText=$this->postStringTypebyIndex((int)$data->PostType,(int)$data->CategoryType);
//                $custompostText=$postText;                
                /* Admin/System generated notifications...
                 * 1: Admin
                 * 2: System
                 */ 
                    if(isset($data->NotificationType) && ($data->NotificationType != 3) && $isNHistory == 0){  
                        if($data->NotificationType == 1)
                           $adminArray = CommonUtility::prepareNotificationMessageForAdminSystem($data,$reqUserId,$notifications,$deviceType,$adminArray);                   
                        else
                            $systemArray = CommonUtility::prepareNotificationMessageForAdminSystem($data,$reqUserId,$notifications,$deviceType,$systemArray);                   
                    }else if(isset($data->NotificationType) && ($data->NotificationType != 3) && $isNHistory == 1){
                        $totalArray = CommonUtility::prepareNotificationMessageForAdminSystem($data,$reqUserId,$notifications,$deviceType,$totalArray);                   
                    }
                    //love...
                    if(isset($data->Love) && $data->RecentActivity == "love"){
                      $totalArray=CommonUtility::prepareNotificationMessage($data,$reqUserId,$data->Love,$totalArray,$notifications,$deviceType);
                    }
                    //comment...
                    if($data->RecentActivity == "comment" && isset($data->CommentUserId)){
                      $totalArray=CommonUtility::prepareNotificationMessage($data,$reqUserId,$data->CommentUserId,$totalArray,$notifications,$deviceType);
                    }
                    //post...
                    if($data->RecentActivity == "post" && isset($data->OriginalUserId)){
                       $totalArray=CommonUtility::prepareNotificationMessage($data,$reqUserId,array(),$totalArray,$notifications,$deviceType);
                    }
                    //follow...
                    if($data->RecentActivity == "follow" && isset($data->PostFollowers)){
                         $totalArray=CommonUtility::prepareNotificationMessage($data,$reqUserId,$data->PostFollowers,$totalArray,$notifications,$deviceType);
                    }
                    //mentioned...
                    if ($data->RecentActivity == "mention" && isset($data->MentionedUserId)) {
                            $totalArray=CommonUtility::prepareNotificationMessage($data,$reqUserId,$data->MentionedUserId,$totalArray,$notifications,$deviceType);

                    }
                    // invite ...
                    if($data->RecentActivity == "invite" && !empty($data->InviteUserId)){
                        $totalArray=CommonUtility::prepareNotificationMessage($data,$reqUserId,array(),$totalArray,$notifications,$deviceType);
                    }

                       // UserFollow ...
                    if($data->RecentActivity == "UserFollow" && isset($data->NewFollowers)){
                         $totalArray=CommonUtility::prepareNotificationMessage($data,$reqUserId,$data->NewFollowers,$totalArray,$notifications,$deviceType);
                    }
                    if($isNHistory==0 && $totalNotificationTobeShownCount==10){
                        break;
                    }

                    $totalNotificationTobeShownCount++;
                 }
                 catch(Exception $ex)
                 {
                     Yii::log("CommonUtility:prepareStringToNotification::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
                      error_log("Exception Occurred in CommonUtility->prepareStringToNotification==".$ex->getMessage());
                 }
               
               
            } 
            if($isNHistory == 0){
                $adminSystemArray = array_merge($adminArray,$systemArray);
                $totalArray = array_merge($adminSystemArray,$totalArray);
            }
            return $totalArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareStringToNotification::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareStringToNotification==".$ex->getMessage());
        }
        
    }
    

    public static function getNearyestWeekEndDate($date) {
        try{
        $time = strtotime($date);
        $found = false;
        while (!$found) {
            $d = date('N', $time);
            if ($d == 7) {
                $found = true;
                $weekend = date('Y-m-d', $time);
            }
            $time += 86400;
        }
        return $weekend;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getNearyestWeekEndDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function get_months($date1, $date2) {
        try{
        $date1 = date('Y-m', strtotime($date1));
        $date2 = date('Y-m', strtotime($date2));

        if ($date1 < $date2) {
            $past = $date1;
            $future = $date2;
        } else {
            $past = $date2;
            $future = $date1;
        }

        $months = array();

        for ($i = $past; $past <= $future; $i++) {
            $timestamp = strtotime($past . '-1');
            $d = date('F Y', $timestamp);
            $m = intval(date('m', $timestamp));
            $months[$m] = $d;
            $past = date('Y-m', strtotime('+1 month', $timestamp));
        }
        return $months;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:get_months::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function get_weeks($startDate, $endDate) {
        try{
        $startDateUnix = strtotime($startDate);
        $endDateUnix = strtotime($endDate);

        $currentDateUnix = $startDateUnix;

        $weekNumbers = array();
        $i = 0;
        while ($currentDateUnix < $endDateUnix) {
            
            //  echo $currentDateUnix;
            // echo date('Y-m-d',$currentDateUnix);
            $week = date('W', $currentDateUnix);
            $year = date('Y', $currentDateUnix);
            $date = CommonUtility::getStartAndEndDate($week, $year);
            if ($i == 0) {
                if (strtotime($startDate) == strtotime($date)) {
                    $date = $date;
                } else {
                    // $date=$startDate;
                    $weekNumbers[$week - 1] = $startDate;
                }
            }

            $weekNumbers[$week] = $date;
            $currentDateUnix = strtotime('+1 week', $currentDateUnix);
            $i++;
        }
        
       
        return $weekNumbers;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:get_weeks::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function get_dates($startdate, $enddate) {
        try{
        $dates = array();
        $firstdate = array();
        $arrayone = array();
        $fday = intval(date('d', strtotime($startdate)));
        $dates[] = $startdate;

        while (end($dates) < $enddate) {

            $date = date('Y-m-d', strtotime(end($dates) . ' +1 day'));
            $day = intval(date('d', strtotime($date)));
            $dates[$day] = $date;
        }
        if (!array_key_exists($fday, $dates)) {
            $firstdate[$fday] = $startdate;
            unset($dates[0]);
            $arrayone = $firstdate + $dates;
        } else {
            $arrayone = $dates;
        }


        return $arrayone;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:get_dates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function get_years($stratdate, $enddate) {
        try{
        $NoOfIntervals = 'P1Y';
        $year = date('Y', strtotime($stratdate));
        $ydate = date("Y-m-d", mktime(0, 0, 0, 12, 31, $year));
        $dateFrom = new DateTime($stratdate);
        $dateTo = new DateTime($enddate);


        $valid_times[$year] = $year;
        while ($dateFrom <= $dateTo) {
            $dateFrom->add(new DateInterval($NoOfIntervals));
            $y = $dateFrom->format('Y');
            $valid_times[$y] = $y;
            $dateFrom = new DateTime($dateFrom->format('Y-m-d'));
        }

        return $valid_times;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:get_years::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function getAnalyticsData($collection, $match, $modeType, $id) {
        try{
        $returnVal = array();
        $c = $collection::model()->getCollection();
//
        $results = $c->aggregate(
                array('$match' => $match
                ), array('$group' => array(
                '_id' => $id,
                "count" => array('$sum' => 1),
            )), array(
            '$sort' => array('_id' => 1)
                )
        );
        $returnVal = isset($results['result'])?$results['result']:array();
        return $returnVal;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getAnalyticsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function getStartAndEndDate($week, $year) {
        // Adding leading zeros for weeks 1 - 9.
        try{
        $date_string = $year . 'W' . sprintf('%02d', $week);
        $startDate = date('Y-n-j', strtotime($date_string));
        $from = date("Y-m-d", strtotime("{$year}-W{$week}-7"));

        return $from;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getStartAndEndDate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    //Badgin -related methods start----------------------
    
    public static function getUserMetaCollectionObjByUserId($UserId) {
        try{
         $metaObj=  UserMetaCollection::model()->getUserMetaCollectionByUserId($UserId);
         return $metaObj;
         } catch (Exception $ex) {
            Yii::log("CommonUtility:getUserMetaCollectionObjByUserId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
    public static function startBadging($streamObj) {
          try{
        $metaObj= CommonUtility::getUserMetaCollectionObjByUserId($streamObj->UserId);
      
        if($streamObj->ActionType == 'UserFollow' ||  $streamObj->ActionType == "UserUnFollow")
        {
             
             $resUser=CommonUtility::prepareAndSaveUserMetaCollection($metaObj,"UserFollowing",$streamObj->UserId,$streamObj->ActionType,'');
             $followerObj= UserMetaCollection::model()->getUserMetaCollectionByUserId($streamObj->UserFollowers);
             $resUserFollowing=CommonUtility::prepareAndSaveUserMetaCollection($followerObj,"Followers",$streamObj->UserFollowers,$streamObj->ActionType,'');
             if($streamObj->ActionType == 'UserFollow')
             {
                 CommonUtility::badgingInterceptor("UserFollow",$streamObj->UserId);
                 CommonUtility::badgingInterceptor("UserFollowers",$streamObj->UserFollowers);
             }
            
        }
        else if($streamObj->ActionType == "Love")
        {
            $resUser=CommonUtility::prepareAndSaveUserMetaCollection($metaObj,"Loves",$streamObj->UserId,$streamObj->ActionType,'');
                    
            CommonUtility::badgingInterceptor("Love",$streamObj->UserId);
        }
        else if($streamObj->ActionType == "Comment")
        {
           
             $resObj=CommonUtility::prepareAndSaveUserMetaCollection($metaObj,"Comments",$streamObj->UserId,$streamObj->ActionType,''); 
            
             $metaObjComments= CommonUtility::getUserMetaCollectionObjByUserId($streamObj->UserId);
            
             if((count($metaObjComments)>0 && $metaObjComments->Comments==1 ))
             {
                // echo "In If conditon of comments";
             CommonUtility::badgingInterceptor("FirstComment",$streamObj->UserId);
             }
              $commentObj= $streamObj->Comments ;
             // echo "PRINT comemtn OBJ".print_r($commentObj);
              if(isset($commentObj) && count($commentObj['HashTags'])>0)
              {
                 $resObjHashTags=CommonUtility::prepareAndSaveUserMetaCollection($metaObjComments,"HashTags",$streamObj->UserId,$streamObj->ActionType,count($commentObj['HashTags'])) ;
                if($metaObjComments->HashTags==0 )
                {
                     CommonUtility::badgingInterceptor("FirstHashTag",$streamObj->UserId);
                }  
              }
              CommonUtility::badgingInterceptor("Comments",$streamObj->UserId);
        }
        else if($streamObj->CategoryType == 1 && $streamObj->PostType!=4 && $streamObj->ActionType=="Post")
        {
             $resObj=CommonUtility::prepareAndSaveUserMetaCollection($metaObj,"Posts",$streamObj->UserId,$streamObj->ActionType,''); 
             $metaObjPosts= CommonUtility::getUserMetaCollectionObjByUserId($streamObj->UserId);
             if((count($metaObjPosts)>0 && $metaObjPosts->Posts==1 ))
             {
              
                 CommonUtility::badgingInterceptor("FirstPost",$streamObj->UserId);
             }
           
             
        }
        
        else if($streamObj->CategoryType == 2 && ($streamObj->PostType==5 ) && $streamObj->ActionType=="Post")
        {
            
             $resObj=CommonUtility::prepareAndSaveUserMetaCollection($metaObj,"CurbsidePosts",$streamObj->UserId,$streamObj->ActionType,''); 
            
             $metaObjCSPosts= CommonUtility::getUserMetaCollectionObjByUserId($streamObj->UserId);
            
             if((count($metaObjCSPosts)>0 && $metaObjCSPosts->CurbsidePosts==1 ))
             {
               
                 CommonUtility::badgingInterceptor("CurbsidePosts",$streamObj->UserId);
             }
             
        }
        
        if($streamObj->ActionType=="Post")
        {
             if(count($streamObj->HashTags)>0)
             { 
                 $metaObjPosts= CommonUtility::getUserMetaCollectionObjByUserId($streamObj->UserId);
                 $resObjHashTags=CommonUtility::prepareAndSaveUserMetaCollection($metaObjPosts,"HashTags",$streamObj->UserId,$streamObj->ActionType,count($streamObj->HashTags)); ;
                if($metaObjPosts->HashTags==0 )
                {
                     CommonUtility::badgingInterceptor("FirstHashTag",$streamObj->UserId);
                }
                //In case of multiple hashtags case of badge just call the badging intercepter here with that context
             }
        }
       
     
     } catch (Exception $ex) {
            Yii::log("CommonUtility:startBadging::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }  
        
        
    }
    
    public static  function prepareAndSaveUserMetaCollection($metaObj,$action,$userId,$actionType,$HashTagsCount) {
         //Here insert data for user following count and also followers count for other user
         try{
            if($metaObj!="failure" )
            {
                 
                if(count($metaObj)==0 && $actionType!="UserUnFollow" )
                {
                   
                     $prepareMetaObj=array("UserId"=>$userId,"Followers"=> 0,"UserFollowing"=>0,"Loves"=>0,"Comments"=>0,"Posts"=>0,"CurbsidePosts"=>0,"HashTags"=>0);
                     $prepareMetaObj[$action]=1;
                      if($action=="HashTags")
                       $prepareMetaObj[$action]=$HashTagsCount;   
                     $res= UserMetaCollection::model()->saveUserMetaCollection($prepareMetaObj); 
                  
                }
                else if(count($metaObj)>0 )
                {
                    
                     $prepareMetaObj=array("UserId"=>$metaObj->UserId,"Followers"=> 0,"UserFollowing"=>0,"Loves"=>0,"Comments"=>0,"Posts"=>0,"CurbsidePosts"=>0,"HashTags"=>0);
                     $prepareMetaObj[$action]="Yes";  
                      $addValue=1;
                    if($actionType=="UserUnFollow")
                    {
                      
                       if($metaObj->$action>0) 
                             $addValue=-1;
                       else
                           $addValue=0;
                    }
                  
                    if($action=="HashTags")
                        $addValue=$HashTagsCount;   
                    $res= UserMetaCollection::model()->updateUserMetaCollection($metaObj,$prepareMetaObj,$metaObj->UserId,$addValue); 
                }
            }
           // return $res;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareAndSaveUserMetaCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }    
           
    }
    
   
     public static function badgingInterceptor($context,$userId){
       try{
         $badgeCollectionObjSave='';
         if($context=='FirstLogin')
         {
            //check ifuser logins first here
           $isFirstLogin=CommonUtility::checkUserFirstLogin($userId,'web');
         
            if($isFirstLogin)
            {
               $badgeCollectionObjSave= CommonUtility::badgesSavingInterceptor($context,$userId,'');
                 if($badgeCollectionObjSave!='error' && $badgeCollectionObjSave>0);
                  
            }
             
         }
         else if($context=='MobileFirstLogin')
         {
            
              $isFirstLogin=CommonUtility::checkUserFirstLogin($userId,'mobile');
            if($isFirstLogin)
            {
               $badgeCollectionObjSave= CommonUtility::badgesSavingInterceptor($context,$userId,'');
                 if($badgeCollectionObjSave!='error' && $badgeCollectionObjSave>0);
                  
            }
         }
         else if($context=='UserFollow')
         {
            
             CommonUtility::badgesSavingInterceptor($context, $userId,"UserFollowing");// The last parametere is the Metacollection property name of each context
         }
         else if($context=='Love')
         {
             $badgeCollectionObjSave=  CommonUtility::badgesSavingInterceptor($context,$userId,"Loves");
         }
         
          else if($context=='UserFollowers')
         {
             
             $badgeCollectionObjSave=  CommonUtility::badgesSavingInterceptor($context,$userId,"Followers");
         }
          else if($context=='FirstComment')
         {
             
             $badgeCollectionObjSave=  CommonUtility::badgesSavingInterceptor($context,$userId,"Comments");
         }
          else if($context=='Comments')
         {
             
             $badgeCollectionObjSave=  CommonUtility::badgesSavingInterceptor($context,$userId,"Comments");
         }
         else if($context=="FirstPost")
         {
              $badgeCollectionObjSave=  CommonUtility::badgesSavingInterceptor($context,$userId,"Posts");
         }
         else if($context=="CurbsidePosts")
         {
              $badgeCollectionObjSave=  CommonUtility::badgesSavingInterceptor($context,$userId,"CurbsidePosts");
         }
          else if($context=="FirstHashTag")
         {
              $badgeCollectionObjSave=  CommonUtility::badgesSavingInterceptor($context,$userId,"HashTags");
         }
         return $badgeCollectionObjSave;
         } catch (Exception $ex) {
            Yii::log("CommonUtility:badgingInterceptor::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
     
     public static function checkUserFirstLogin($userId,$type) {
         try{
         $returnValue=false;
         if($type=="web")
         {
            
            $userObj=ServiceFactory::getSkiptaUserServiceInstance()->getUserByType($userId,'UserId');  

            if( $userObj->PreviousLastLoginDate=='' ||$userObj->PreviousLastLoginDate==null)
            {
               $returnValue= true ;
            }
         }
         else
         {
            $isLogin=ServiceFactory::getSkiptaUserServiceInstance()->checkMobileLogin($userId); 
            
             if(!$isLogin)
              $returnValue= true ;
         }
         
         return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:checkUserFirstLogin::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
     }
     
     public static function getBadgeInfo($context) {
        try{ 
           $badgeInfo=  ServiceFactory::getSkiptaUserServiceInstance()->getBadgeInfoByContextAndBadgeName($context);
           return $badgeInfo;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getBadgeInfo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
     
       public static function getBadgeLeveInfo($badgeId,$levelValue) {
        try{
           $badgeInfo=  ServiceFactory::getSkiptaUserServiceInstance()->getBadgeLevelInfoByBadgeId($badgeId,$levelValue);
           return $badgeInfo;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getBadgeLeveInfo::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
    
     public static function getUserBadgeCollection($userId,$badgeId,$limit) {
        try{
         $userBadgeCollection=  ServiceFactory::getSkiptaUserServiceInstance()->getUserBadgeCollectionByCriteria($userId,$badgeId,$limit);
           return $userBadgeCollection;
           } catch (Exception $ex) {
            Yii::log("CommonUtility:getUserBadgeCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
     
     public static function getBadgesNotShownToUser($userId,$limit) {
        try{
            $userBadgeCollection=  ServiceFactory::getSkiptaUserServiceInstance()->getBadgesNotShownToUser($userId,$limit);
            return $userBadgeCollection;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getBadgesNotShownToUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
     }
    
    
    public static function badgesSavingInterceptor($context,$userId,$MetaObjproperty)
    {
         $categoryId = CommonUtility::getIndexBySystemCategoryType('Badge');
         $postType=  CommonUtility::sendPostType('Badge');
         $badgeCollectionObjSave="";
         try
         {
            $badgeInfo=  CommonUtility::getBadgeInfo($context);
         
             if($badgeInfo!="failure" && is_object($badgeInfo))
             {
              
                 //save badge info
                 $hasLevel=false;
                if($badgeInfo->has_level)
                {
                    if(CommonUtility::checkForSaveBadgeToUser($badgeInfo,$userId,$MetaObjproperty))
                            $hasLevel=true;
                }
                 
                $badgeCollectionObjSave=  CommonUtility::saveBadgeCollection($badgeInfo,$userId,$hasLevel);
               
                //prepare stream obj if exists
                if($badgeCollectionObjSave!="")
                {
                    //prepare stream obj and save in the userstream collection obj.
                    $result=ServiceFactory::getSkiptaPostServiceInstance()->saveFollowOrUnfollowToPost($postType,$badgeCollectionObjSave, $userId, 'Follow', $categoryId);
                    if($badgeInfo->stream_effect)
                      if (!CommonUtility::prepareStreamObject($userId, "Post", $badgeCollectionObjSave, $categoryId, '', '','')) {
                       // return "failure";
                    }
                }
                
                
             }
             
         } catch (Exception $ex) {
               Yii::log("CommonUtility:badgesSavingInterceptor::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
         }
         return $badgeCollectionObjSave;
         
        
    }
    
    public static function saveBadgeCollection($badgeInfo,$userId,$hasLevel) {
        try{
        $userBadgeCollection= CommonUtility::getUserBadgeCollection($userId,$badgeInfo->id,1);
    
        $badgeCollectionObjSave="";
        if($userBadgeCollection!="failure" )
             {
                 if(count($userBadgeCollection)==0)
                 {
                   //create badge if doest not exist
                     if($badgeInfo->has_level && $hasLevel)
                     { //Save the badge only if the criteria is satisfied ($hasLevel==this property will be set to true  only if the user has acheieved the no.units required , then only badge gets saved by setting the level as 1)
                         $prepareObj=CommonUtility::prepareBadgeCollection($badgeInfo,1,$userId);
                       $badgeCollectionObjSave=  ServiceFactory::getSkiptaUserServiceInstance()->saveUserBadgeCollection($prepareObj);
                     }
                     else if(!$badgeInfo->has_level)
                     {
                       $prepareObj=CommonUtility::prepareBadgeCollection($badgeInfo,1,$userId);
                       $badgeCollectionObjSave=  ServiceFactory::getSkiptaUserServiceInstance()->saveUserBadgeCollection($prepareObj);  
                     }
                 }
                 else
                 {
                    if($hasLevel) //this property will be set to true  only if the user has acheieved the no.units required , then only badge gets saved by increasing the level
                    {
                         
                         $badgeCollectionObjSave=  ServiceFactory::getSkiptaUserServiceInstance()->saveUserBadgeCollection(CommonUtility::prepareBadgeCollection($badgeInfo,$userBadgeCollection->BadgeLevelValue+1,$userId));
                    }
                 }
                

             }
             return $badgeCollectionObjSave;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:saveBadgeCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }     

    }
    
    public static function prepareBadgeCollection($badgeInfo, $unitValue, $userId) {
        try{
        $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection((int) $userId);
        $badgeCollectionObj = array("userId" => $userId, "SegmentId" => (int) $tinyUserCollectionObj->SegmentId, "NetworkId" => (int) $tinyUserCollectionObj->NetworkId, "Language" => $tinyUserCollectionObj->Language, "badgeId" => $badgeInfo->id, "badgeLevelValue" => $unitValue, 'isBadgeShown' => 0); //default value "1" for level 1 or no levels
        return $badgeCollectionObj;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareBadgeCollection::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function checkForSaveBadgeToUser($badgeInfo,$userId,$MetaObjproperty)    {
        try{
        $userBadgeCollection= CommonUtility::getUserBadgeCollection($userId,$badgeInfo->id,1); 
       
           $metaObj= CommonUtility::getUserMetaCollectionObjByUserId($userId);
          
           if($userBadgeCollection!="failure" )
           {
               if(count($userBadgeCollection)==0 )
               {
                 $levelValue=1;  
               }
            else {
               
                $levelValue=(int)($userBadgeCollection->BadgeLevelValue)+1;
            }
           
           }
             $badgeLevelInfo=  CommonUtility::getBadgeLeveInfo($badgeInfo->id,$levelValue);
             //check if followers limit is reached or not
               //if reached return true else false
           
              if(count($badgeLevelInfo)>0 )
              {
                 if( $metaObj->$MetaObjproperty == $badgeLevelInfo[0]->unitValue)
                  return true;
              }
         
          
           return false;
           } catch (Exception $ex) {
            Yii::log("CommonUtility:checkForSaveBadgeToUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

     //Badgin -related methods start
    
    public static function encrypt($data_input) {
    try{
        $key = "#";
    $td = mcrypt_module_open('cast-256', '', 'ecb', '');
    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $encrypted_data = mcrypt_generic($td, $data_input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $encoded_64=base64_encode($encrypted_data);
    return $encoded_64; 
    } catch (Exception $ex) {
            Yii::log("CommonUtility:encrypt::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public static function decrypt($encoded_64) {
    try{    
       $decoded_64=base64_decode($encoded_64);
    $key = "#";// same as you used to encrypt
    $td = mcrypt_module_open('cast-256', '', 'ecb', '');
    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $decrypted_data = mdecrypt_generic($td, $decoded_64);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return $decrypted_data; 
    } catch (Exception $ex) {
            Yii::log("CommonUtility:decrypt::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    public static function prepareFeaturedItemsForMobile($providerData){
        try{
        $featuredItems = array();
        if (sizeof($providerData) != 0) {
            foreach ($providerData as $data) {
                $featuredDisplayBean = new StreamPostDisplayBean();
                $featuredDisplayBean->_id = (string)$data->_id;
                $featuredDisplayBean->PostId = (string)$data->PostId;
                $appendData = '<span data-posttype="'+$data->Type+'" data-categorytype="'+$data->CategoryType+'" data-postid="'+$data->PostId+'" data-id="'+$data->PostId+'"  class="postdetail tooltiplink"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                $featuredDisplayBean->PostText = CommonUtility::truncateHtml($data->Description, 240, Yii::t('translation','Readmore'), true, true, $appendData);
                $featuredDisplayBean->PostType = $data->Type;
                $featuredDisplayBean->CategoryType = $data->CategoryType;
                $featuredDisplayBean->FirstUserDisplayName = $data->Title;
                $featuredDisplayBean->IsMultipleArtifact=$data->IsMultipleArtifact;
                if ($data->Resource != '' || !empty($data->Resource)) {
                    if ($data->CategoryType == 9) {
                        $featuredDisplayBean->ArtifactIcon = Yii::app()->params['ServerURL'] . $data->Resource;
                    } else if (isset($data->Resource["Extension"])) {
                        $filetype = strtolower($data->Resource["Extension"]);
                        if ($filetype == 'jpg' || $filetype == 'jpeg' || $filetype == 'gif' || $filetype == 'tiff' || $filetype == 'png') {
                            $featuredDisplayBean->ArtifactIcon = Yii::app()->params['ServerURL'] . $data->Resource["Uri"];
                        } else if ($filetype == 'mp4' || $filetype == 'mov' || $filetype == 'flv') {
                            $filename = "/images/system/video_img.png";
                            if (file_exists($data->Resource["ThumbNailImage"])) {
                                $filename = $data->Resource["ThumbNailImage"];
                            }
                            $featuredDisplayBean->ArtifactIcon = Yii::app()->params['ServerURL'] . $filename;
                        } else if ($filetype == 'mp3') {
                            $filename = "/images/system/audio_img.png";
                            if (file_exists($data->Resource["ThumbNailImage"])) {
                                $filename = $data->Resource["ThumbNailImage"];
                            }
                            $featuredDisplayBean->ArtifactIcon = Yii::app()->params['ServerURL'] . $filename;
                        } else {
                            $tinyUserObj = UserCollection::model()->getTinyUserCollection($data->UserId);
                            $featuredDisplayBean->ArtifactIcon = Yii::app()->params['ServerURL'] . $tinyUserObj['ProfilePicture'];
                        }
                    }
                } else if ($data->HtmlFragment != '' || !empty($data->HtmlFragment)) {
                    $html = $data->HtmlFragment;
                    $present = stristr($html, 'img');
                    if ($present != '') {
                        $doc = new DOMDocument();
                        libxml_use_internal_errors(true);
                        $doc->loadHTML($html);
                        $xpath = new DOMXPath($doc);
                        $src = $xpath->evaluate("string(//img/@src)");
                        $featuredDisplayBean->ArtifactIcon = $src;
                    } else {
                        $tinyUserObj = UserCollection::model()->getTinyUserCollection($data->UserId);
                        $featuredDisplayBean->ArtifactIcon = Yii::app()->params['ServerURL'] . $tinyUserObj['ProfilePicture'];
                    }
                } else {
                    $tinyUserObj = UserCollection::model()->getTinyUserCollection($data->UserId);
                    if ($data['Type'] == 4) {
                        $featuredDisplayBean->ArtifactIcon = Yii::app()->params['ServerURL'] . "/upload/profile/user_noimage.png";
                    } else {
                        $featuredDisplayBean->ArtifactIcon = Yii::app()->params['ServerURL'] . $tinyUserObj['ProfilePicture'];
                    }
                }
                array_push($featuredItems, $featuredDisplayBean);
            }
            $returnValue = $featuredItems;
        }
        }catch(Exception $ex){
            Yii::log("CommonUtility:prepareFeaturedItemsForMobile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareFeaturedItemsForMobile==".$ex->getMessage());
        }
        return $returnValue;
    }
    
    public static function getImageFromURL($imgpath, $todest) {
         
        try {
            
            $content = file_get_contents($imgpath);
            $retrunvalue=file_put_contents($todest, $content);            
           
            
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getImageFromURL::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->getImageFromURL==".$ex->getMessage());
        }
    }

    public static function remove_unicode($string){
    try{
        return  preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
    } catch (Exception $ex) {
            Yii::log("CommonUtility:remove_unicode::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }

    
    
/**
 * Returns an encrypted & utf8-encoded
 */
static function encryptString($pure_string) {
    try{
    $encryption_key="!@#$%^&*";
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
    } catch (Exception $ex) {
            Yii::log("CommonUtility:encryptString::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}



    
    public static function prepareSurveyDashboradData($UserId, $surveyObject) {
        try {

            $totalBeansArray = array();            
            foreach ($surveyObject as $data) {
                $extendedBean = new ScheduleSurveyBean();
                $extendedBean->_id = $data->_id;
                if (strlen($data->SurveyTitle) > 240) {
                    $description = CommonUtility::truncateHtml($data->SurveyTitle, 240);
                    $extendedBean->SurveyTitle = $description . Yii::t('translation','Readmore');
                } else {
                    $extendedBean->SurveyTitle = $data->SurveyTitle;
                }
                if (strlen($data->SurveyDescription) > 240) {
                    $description = CommonUtility::truncateHtml($data->SurveyDescription, 240);
                    $extendedBean->SurveyDescription = $description . "  more";
                } else {
                    $extendedBean->SurveyDescription = $data->SurveyDescription;
                }
                $extendedBean->SuspendedCount = ExtendedSurveyCollection::model()->getSuspendedQuestionsCount($data->_id);
                error_log("&&&&&&&&&&&&suspendcount".$extendedBean->SuspendedCount);
                $extendedBean->QuestionsCount = $data->QuestionsCount;
                $extendedBean->SurveyLogo = $data->SurveyLogo;
                $extendedBean->SurveyRelatedGroupName = $data->SurveyRelatedGroupName;
//                $extendedBean->SurveyTakenCount = $data->SurveyTakenCount;
                $extendedBean->UserId = $data->UserId;
                $extendedBean->Status = $data->Status;
                $extendedBean->IsDeleted = $data->IsDeleted;
                $extendedBean->IsCurrentSchedule = $data->IsCurrentSchedule;
                $extendedBean->CurrentScheduleId = $data->CurrentScheduleId;
                $surveySchedules = ScheduleSurveyCollection::model()->getSchedulesForSurvey($data->_id);
                if (!is_string($surveySchedules)) {                    

                    $extendedBean->SchedulesArray = $surveySchedules;
                    if(isset($surveySchedules) && sizeof($surveySchedules) > 0){  
                        $spotsCount = 0;
                        $message = "";
                        foreach($surveySchedules as $schedule){
                            $obj = ServiceFactory::getSkiptaExSurveyServiceInstance()->getScheduleSurveyById("Id",$schedule->_id);
                            if(is_object($obj) && $obj->MaxSpots>0){
                                $spotsCount = SurveyUsersSessionCollection::model()->getSpotsAvailabeForScheduledSurvey($obj,$obj->SurveyId); 
                                $message = Yii::t("translation","MarketSurvey_Spots_tooltip");                                
                                $message = str_replace("SPOTSCOUNT",$spotsCount,$message);
                                $message = str_replace("TOTALSPOTS",$obj->MaxSpots,$message);
                                $schedule->Status = $message;                                
                            }
                            
                        }
                    }
                } else {
                    $extendedBean->SchedulesArray = 'noschedules';
                }
                $extendedBean->NetworkId = $data->NetworkId;
                
                
                
                
                array_push($totalBeansArray, $extendedBean);
                $i++;
            }            
            return $totalBeansArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareSurveyDashboradData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareSurveyDashboradData==".$ex->getMessage());
        }
    }

    public static function prepateSurveyAnalyticsData($userId, $scheduleId, $groupName = NULL) {
        try {
            $questionType1 = array();
            $questionType2 = array();
            $questionType3 = array();
            $questionType4 = array();
            $questionType5 = array();
            $questionType6 = array();
            $questionType7 = array();
            $questionType8 = array();
            $isUserAnswered = 0;

            $scheduleObject = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject("Id", $scheduleId);
            $userAnswers = $scheduleObject->UserAnswers;
            
             $uncompletedAnswers = SurveyUsersSessionCollection::model()->getAllAnswersForSchedule($scheduleId);
             foreach ($uncompletedAnswers as $uncompleteAnswer) {
                 if(is_array($uncompleteAnswer) && sizeof($uncompleteAnswer)>0){
                     $userAnswers = array_merge($userAnswers, $uncompleteAnswer);
                 }
             }
             //$userAnswers = $scheduleObject->UserAnswers;
            
            $surveyObject = ExtendedSurveyCollection::model()->getSurveyDetailsObject("Id", $scheduleObject->SurveyId);


            foreach ($userAnswers as $userAnswer) {
                if ($userAnswer['QuestionType'] == 1) {
                    array_push($questionType1, $userAnswer);
                } else if ($userAnswer['QuestionType'] == 2) {
                    array_push($questionType2, $userAnswer);
                } else if ($userAnswer['QuestionType'] == 3) {
                    array_push($questionType3, $userAnswer);
                } else if ($userAnswer['QuestionType'] == 4) {
                    array_push($questionType4, $userAnswer);
                } else if ($userAnswer['QuestionType'] == 5) {
                    array_push($questionType5, $userAnswer);
                } else if ($userAnswer['QuestionType'] == 6) {
                    array_push($questionType6, $userAnswer);
                } else if ($userAnswer['QuestionType'] == 7) {
                    array_push($questionType7, $userAnswer);
                } else if ($userAnswer['QuestionType'] == 8) {
                    array_push($questionType8, $userAnswer);
                } 
            }

            $questions = $surveyObject->Questions;
            $newQuestionsArray = array();
            foreach ($questions as $question) {
                $isUserAnswered = 0;
                //if($question['IsAnalyticsShown'] == 1){
                    if ($question['QuestionType'] == 1 || $question['QuestionType'] == 2 || $question['QuestionType'] == 8) {
                    $optionsArray = $question['Options'];
                    $optionsNewArray = array();
                    foreach ($optionsArray as $option) {
                        $optionsNewArray[$option] = 0;
                    }
                    if ($question['Other'] == 1) {
                        $optionsNewArray[$question['OtherValue']] = 0;
                    }
                    if ($question['QuestionType'] == 1) {
                        $answersArray = $questionType1;
                    } else if ($question['QuestionType'] == 2) {
                        $answersArray = $questionType2;
                    } else if ($question['QuestionType'] == 8) {
                        $answersArray = $questionType8;
                    }
                    $totalCount = 0;
                    $userAnnotationArray = array();
                   $userCount = 0;
                    foreach ($answersArray as $value) {
                        if ($question['QuestionId'] == $value["QuestionId"]) {
                           $userCount++;
                            if ($value['Other'] == 1) {
                                $totalCount++;
                                $optionsNewArray[$question['OtherValue']] = $optionsNewArray[$question['OtherValue']] + 1;
                                if ((int)$userId == (int)$value["UserId"]) {
                                    array_push($userAnnotationArray,$question['OtherValue']);
                                    //$isUserAnswered = 1;
                                }
                                
                            } 
//                            else {
                                $selectedOptionArray = $value['SelectedOption'];
                                foreach ($selectedOptionArray as $sop) {
                                    $sop = $sop - 1;
                                    if ($userId == $value["UserId"]) {
                                        array_push($userAnnotationArray, $optionsArray[$sop]);
                                    }

                                    if (isset($optionsNewArray[$optionsArray[$sop]])) {
                                        $totalCount++;
                                        $optionsNewArray[$optionsArray[$sop]] = $optionsNewArray[$optionsArray[$sop]] + 1;
                                    }
                                }
//                            }
     
                        }
                       
                    } 
                            $optionsPercentageArray = array();
                            $percentTageValue = 0;
                            foreach ($optionsNewArray as $key => $value) {
                                if($userCount > 0){
                                    $percentTageValue = round(($value * 100) / $userCount,2);
                                    $isUserAnswered = 1;
                                }
                                $optionsPercentageArray[$key] = $percentTageValue;
                                
                            }
                    $question['OptionsNewArray'] = $optionsNewArray;
                    $question['OptionsPercentageArray'] = $optionsPercentageArray;
                    $question['UserAnnotationArray'] = $userAnnotationArray;
                    $question['SurveyTakenUsers'] = sizeof($scheduleObject->SurveyTakenUsers);
                    $question['isUserAnswered'] = $isUserAnswered;
                   // $question["OtherKey"] = $question['OtherValue'];
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                }
                if ($question['QuestionType'] == 3 || $question['QuestionType'] == 4) {
                    //$totalCount=0;
                    $optionsArray = $question['OptionName'];
                      $JustificationPlaceholders = $question['JustificationPlaceholders'];
                      if($question['AnyOther'] == 1){
                         $question['OtherValue'] = end($optionsArray);
                    }
                    
                    
                    $labelNameArray = $question['LabelName'];
                    if ($question['Other'] == 1) {

                        array_push($labelNameArray, "N/A");
                    }
                    $question['LabelName'] = $labelNameArray;
                    $optionsNewArray = array();
                     $optionsCommentsNewArray = array();
                    foreach ($optionsArray as $option) {
                        $emptyArray = array();
                        for ($i = 0; $i < sizeof($labelNameArray); $i++) {
                            array_push($emptyArray, 0);
                        }

                        $optionsNewArray[$option] = $emptyArray;
                    }
                 
                   foreach ($JustificationPlaceholders as $key=>$optionComment) {
                                        
                        $optionsCommentsNewArray[$key] = 0;
                    }
                   
                    
//                    if($question['AnyOther'] == 1){
//                        $optionsNewArray[$option] = 0;
//                    }
//                if ($question['Other'] == 1) {
//                    $optionsNewArray[$question['OtherValue']] = [0,0,0];;
//                }

                    if ($question['QuestionType'] == 3) {
                        $answersArray = $questionType3;
                    } else if ($question['QuestionType'] == 4) {
                        $answersArray = $questionType4;
                    }
                    $userSelectedOptionsArray = array();
                    $userCount=0;
                    foreach ($answersArray as $value) {
                        
                        if ($question['QuestionId'] == $value["QuestionId"]) {   
                            $selectedOptionArray = $value['Options'];
                             $selectedOptionCommnetsArray = $value['OptionCommnets'];
                           $userSelectedOptionsArray[$value['UserId']] = $value['Options'];
                            foreach ($selectedOptionArray as $key => $sop) {
                                //$totalCount++;                                  
                                if (isset($optionsNewArray[$optionsArray[$key]])) {

                                    //if($sop == 1){
                                    if(is_array($sop)){                                        
                                            foreach ($sop as $x=>$v) {                                                
                                               // $val = $optionsNewArray[$optionsArray[$key]][$v - 1];
                                                $val = $optionsNewArray[$optionsArray[$key]][$x];
                                                $optionsNewArray[$optionsArray[$key]][$x] = $val+$v;                                             
                                            }
                                      
                                    }else
                                    if($sop > 0){
                                        $val = $optionsNewArray[$optionsArray[$key]][$sop - 1];
                                        $optionsNewArray[$optionsArray[$key]][$sop - 1] = $val + 1;
                                    }
                                   } else {
                                    }
//                                    if(!empty($sop)){
//                                        $isUserAnswered = 1;
//                                    }else{
//                                        $isUserAnswered = 0;
//                                    }
                                    
                            }
                            if(sizeof($selectedOptionCommnetsArray) > 0){
                                foreach ($selectedOptionCommnetsArray as $key => $sop) {
                                    if(isset($sop) && !empty($sop)){
                                       $val =  $optionsCommentsNewArray[$key];
                                       $optionsCommentsNewArray[$key] = $val+1;
                                    }
                                }
                                    
                            }
                            $question['OptionsNewArray'] = $optionsNewArray;
                            $userOptionComments = array();
                            if(sizeof($value["OptionCommnets"])>0){
                                foreach ($value["OptionCommnets"] as $key => $value1) {                                   
                                    $userOptionComments[$key] = $value1;
                                }
                            }
                            $optionsPercentageArray = array();                          
                            foreach ($optionsNewArray as $key => $value) {
                                $percent = 0;
                                $totalValue = array_sum($value);
                                foreach ($value as $k => $v) {
                                    if($totalValue > 0){
                                        $percent = floor(($v * 100) / $totalValue);
                                        $isUserAnswered = 1;
                                    }else{
                                        $isUserAnswered = 0;
                                    }
                                    $value[$k] = $percent;                                    
                                }

                                $optionsPercentageArray[$key] = $value;
                            }

                            $userCount++;
                            
                        }
//                        if(sizeof($value["OptionCommnets"]) > 0){
//                            $userOptionComments = 
//                        }
                    }
                           $optionsCommentsPercentageArray = array();
                             $sumComments = $userCount;
                              foreach ($optionsCommentsNewArray as $key => $value) {
                              
                                $percent = 0;
                                if($sumComments !=0){
                                     $percent = floor(($value * 100) / $sumComments);
                                $optionsCommentsPercentageArray[$key] = $percent;
                                }else{
                                    $optionsCommentsPercentageArray[$key] = 0; 
                                }
                                
                            }
                    $question['OptionsPercentageArray'] = $optionsPercentageArray;
                    $question['OptionCommnets'] = $userOptionComments;
                     $question['OptionsCommentsPercentageArray'] = $optionsCommentsPercentageArray;
                      $question['OptionsCommentsNewArray'] = $optionsCommentsNewArray;
                    if(!empty($userId) && isset($userSelectedOptionsArray[$userId]) && !empty( $userSelectedOptionsArray[$userId]))
                        $question['userSelectedOptionsArray'] = $userSelectedOptionsArray[$userId];
                    else
                        $question['userSelectedOptionsArray'] = array();
                    $question['SurveyTakenUsers'] = sizeof($scheduleObject->SurveyTakenUsers);
                    $question['isUserAnswered'] = $isUserAnswered;
                   
                    
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                }



                if ($question['QuestionType'] == 5) {

                    $userAnnotationArray = array();
                    $optionsArray = $question['OptionName'];
                    $optionsNewArray = array();
                    foreach ($optionsArray as $option) {
                        $optionsNewArray[$option] = 0;
                    }
                    if($question['Other'] == 1){
                         $optionsNewArray[$question['OtherValue']] = 0;
                         array_push($optionsArray, $question['OtherValue']);
                    }
                    $answersArray = $questionType5;

                    foreach ($answersArray as $value) {
                        if ($question['QuestionId'] == $value["QuestionId"]) {
                            
                            $selectedOptionArray = $value['DistributionValues'];
                            foreach ($selectedOptionArray as $key => $sop) {                                
                                if ((int)$userId == (int)$value["UserId"] && $sop > 0) {
                                    array_push($userAnnotationArray, $optionsArray[$key]);
                                }
                                if (isset($optionsNewArray[$optionsArray[$key]])) {
                                    $val = $optionsNewArray[$optionsArray[$key]];
                                    $optionsNewArray[$optionsArray[$key]] = $val + $sop;
                                }
                            }

                            //  return;
                        }
                    }
                    $optionsPercentageArray = array();
                    $percentTageValue = 0;
                    $totalValue = array_sum($optionsNewArray);
                    foreach ($optionsNewArray as $key => $value) {
                        if($totalValue > 0){
                            $isUserAnswered = 1;
                            $percentTageValue = round(($value * 100) / $totalValue,2);
                        }else{
                            $isUserAnswered = 0;
                        }
                        $optionsPercentageArray[$key] = $percentTageValue;
                    }
                    
                    $question['OptionsNewArray'] = $optionsNewArray;
                    $question['OptionsPercentageArray'] = $optionsPercentageArray;
                    if (!empty($userId) && !empty($userAnnotationArray)) {
                        $question['UserAnnotationArray'] = $userAnnotationArray;
                    }else{
                        $question['UserAnnotationArray'] = array();
                    }
                    $question['SurveyTakenUsers'] = sizeof($scheduleObject->SurveyTakenUsers);
                    $question['isUserAnswered'] = $isUserAnswered;
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                }


                if ($question['QuestionType'] == 6) {

                    $answersArray = $questionType6;
                     $answeredCount = 0;
                    foreach ($answersArray as $value) {
                        if ($question['QuestionId'] == $value["QuestionId"]) {
                        $answeredCount++;
                        }
                    }
                    $totalSurveyTakenUsers = count($scheduleObject->SurveyTakenUsers)+count($scheduleObject->ResumeUsers);                   
                   $unansweredUsersCount =  ($totalSurveyTakenUsers - $answeredCount);
                  
                
                    $question['OptionsNewArray'] = ["Answered Users"=>$answeredCount,"Unanswered Users"=>$unansweredUsersCount];
                   $optionsPercentageArray = array();
                    foreach($question['OptionsNewArray'] as $key=>$value){
                      $optionsPercentageArray[$key] =  ($value/$totalSurveyTakenUsers)*100;
                    }
                     $question['OptionsPercentageArray'] = $optionsPercentageArray;
                    
                    
                    $question['SurveyTakenUsers'] = $totalSurveyTakenUsers;
                    $question['isUserAnswered'] = $isUserAnswered;
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                    
                    
                    
                    
                    
                    
                   
                }

                if ($question['QuestionType'] == 7) {
                    $answersArray = $questionType7;
                    $userAnswersTotalArray = array();
                    foreach ($answersArray as $value) {
                        if ($question['QuestionId'] == $value["QuestionId"]) {
                            $userAnswer = $value['UsergeneratedRankingOptions'];
                            foreach ($userAnswer as $v) {

                                array_push($userAnswersTotalArray, $v);
                            }
                        }
                    }
                    $userAnswersTotalArray = array_map('strtolower', $userAnswersTotalArray);
                    $userAnswersTotalArray = array_map('trim', $userAnswersTotalArray);
                    $words = array_count_values($userAnswersTotalArray);

                    arsort($words);
                    $words = array_slice($words, 0, 5, true);
                    $words1 = array_slice($words, 4);
                    $optionsPercentageArray = array();
                    $percentTageValue = 0;
                    foreach($words as $k=>$v){
                        if(sizeof($words) > 0){
                            $percentTageValue = ($v * 100) / array_sum($words);
                            $isUserAnswered = 1;
                        }else{
                            $isUserAnswered = 0;
                        }
                        $optionsPercentageArray[$k] = $percentTageValue;
                            
                        }
                    $otherValue = array_sum($words1);
                    
                    $words["Other"] = $otherValue;
                    $question['OptionsNewArray'] = $words;
                    $question['OptionsPercentageArray'] = $optionsPercentageArray;
                    $question['SurveyTakenUsers'] = sizeof($scheduleObject->SurveyTakenUsers);
                    $question['isUserAnswered'] = $isUserAnswered;
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                }
                //}
                
            }
            $analyticsPreviewArray = array();
            foreach($newQuestionsArray as $row){
                if($row['isUserAnswered']){
                    array_push($analyticsPreviewArray,$row);
                }
            }
            $surveyObject->Questions = $newQuestionsArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepateSurveyAnalyticsData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepateSurveyAnalyticsData==".$ex->getMessage());
        }
        return $surveyObject;
    }

    public static function filterArrayWithStringLength($words, $strLength, $max, $array = []) {
        try{
        $return = false;
        foreach ($words as $key => $value) {
            if (strlen($key) >= $strLength) {
                $array[$key] = $value;
                if (sizeof($array) == $max) {

                    $return = true;
                    break;
                }
            }
        }
        if ($return == true) {
            return $array;
        } else {
            if ($max == sizeof($array)) {
                return $array;
            } else {
                $strLength = $strLength - 1;
                if ($strLength > 0) {
                    return CommonUtility::filterArrayWithStringLength($words, $strLength, $max, $array);
                }
            }
        }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:filterArrayWithStringLength::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function prepateSurveyAnalyticsDataByGroup($userId, $groupName,$surveyId,$timezone) {
        try {
            $questionType1 = array();
            $questionType2 = array();
            $questionType3 = array();
            $questionType4 = array();
            $questionType5 = array();
            $questionType6 = array();
            $questionType7 = array();
            $questionType8 = array();
            $totalArray = array();            
            $scheduleObjs = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObjectByGroupName($groupName,$surveyId);            
            $dateTotalArray = array();
            $isUserAnswered = 0;
            $totalSurveyTakenUsers = 0;
            $totalAnsweredUsersArray = array();
            $abandonedUsersArray = array();
            foreach ($scheduleObjs as $obj) {
                $scheduleId = $obj->_id;
                 $totalSurveyTakenUsers = $totalSurveyTakenUsers+ count($obj->SurveyTakenUsers);
                 $abandonedUsers += count($obj->ResumeUsers);
                 $totalAnsweredUsersArray = array_merge($totalAnsweredUsersArray,$obj->SurveyTakenUsers);
                 $abandonedUsersArray = array_merge($abandonedUsersArray,$obj->ResumeUsers);
                $scheduleObject = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject("Id", $scheduleId);
                $userAnswers = $scheduleObject->UserAnswers;
                $dateFormat = CommonUtility::getDateFormat();
                $surveyObject = ExtendedSurveyCollection::model()->getSurveyDetailsObject("Id", $scheduleObject->SurveyId);
                $startDate = date($dateFormat,CommonUtility::convert_date_zone($scheduleObject['StartDate']->sec,$timezone,  date_default_timezone_get())) ;
                $endDate = date($dateFormat,CommonUtility::convert_date_zone($scheduleObject['EndDate']->sec,$timezone,  date_default_timezone_get())) ;  
                
                array_push($dateTotalArray,$startDate." to ".$endDate);
                if(sizeof($userAnswers) > 0){
                    
                }
                foreach ($userAnswers as $userAnswer) {
                    
                    if ($userAnswer['QuestionType'] == 1) {
                        array_push($questionType1, $userAnswer);
                    } else if ($userAnswer['QuestionType'] == 2) {
                        array_push($questionType2, $userAnswer);
                    } else if ($userAnswer['QuestionType'] == 3) {
                        array_push($questionType3, $userAnswer);
                    } else if ($userAnswer['QuestionType'] == 4) {
                        array_push($questionType4, $userAnswer);
                    } else if ($userAnswer['QuestionType'] == 5) {
                        array_push($questionType5, $userAnswer);
                    } else if ($userAnswer['QuestionType'] == 6) {
                        array_push($questionType6, $userAnswer);
                    } else if ($userAnswer['QuestionType'] == 7) {
                        array_push($questionType7, $userAnswer);
                    } else if ($userAnswer['QuestionType'] == 8) {
                        array_push($questionType8, $userAnswer);
                    }
                }

                $questions = $surveyObject->Questions;
                $newQuestionsArray = array();
                foreach ($questions as $question) { 
                    if ($question['QuestionType'] == 1 || $question['QuestionType'] == 2 || $question['QuestionType'] == 8) {
                    $optionsArray = $question['Options'];
                    $optionsNewArray = array();
                    foreach ($optionsArray as $option) {
                        $optionsNewArray[$option] = 0;
                    }
                    if ($question['Other'] == 1) {
                        $optionsNewArray[$question['OtherValue']] = 0;
                    }
                    if ($question['QuestionType'] == 1) {
                        $answersArray = $questionType1;
                    } else if ($question['QuestionType'] == 2) {
                        $answersArray = $questionType2;
                    } else if ($question['QuestionType'] == 8) {
                        $answersArray = $questionType8;
                    }
                    $totalCount = 0;
                    $userAnnotationArray = array();
                   $userCount = 0;
                    foreach ($answersArray as $value) {
                        if ($question['QuestionId'] == $value["QuestionId"]) {
                           $userCount++;
                            if ($value['Other'] == 1) {
                                $totalCount++;
                                $optionsNewArray[$question['OtherValue']] = $optionsNewArray[$question['OtherValue']] + 1;
                                if ((int)$userId == (int)$value["UserId"]) {
                                    array_push($userAnnotationArray,$question['OtherValue']);
                                    //$isUserAnswered = 1;
                                }
                                
                            } 
//                            else {
                                $selectedOptionArray = $value['SelectedOption'];
                                foreach ($selectedOptionArray as $sop) {
                                    $sop = $sop - 1;
                                    if ($userId == $value["UserId"]) {
                                        array_push($userAnnotationArray, $optionsArray[$sop]);
                                    }

                                    if (isset($optionsNewArray[$optionsArray[$sop]])) {
                                        $totalCount++;
                                        $optionsNewArray[$optionsArray[$sop]] = $optionsNewArray[$optionsArray[$sop]] + 1;
                                    }
                                }
//                            }
     
                        }
                       
                    } 
                            $optionsPercentageArray = array();
                            $percentTageValue = 0;
                            foreach ($optionsNewArray as $key => $value) {
                                if($userCount > 0){
                                    $percentTageValue = round(($value * 100) / $userCount,2);
                                    $isUserAnswered = 1;
                                }
                                $optionsPercentageArray[$key] = $percentTageValue;
                                
                            }
                    $question['OptionsNewArray'] = $optionsNewArray;
                    $question['OptionsPercentageArray'] = $optionsPercentageArray;
                    $question['UserAnnotationArray'] = $userAnnotationArray;
                    $question['SurveyTakenUsers'] = sizeof($scheduleObject->SurveyTakenUsers);
                    $question['isUserAnswered'] = $isUserAnswered;
                   // $question["OtherKey"] = $question['OtherValue'];
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                }
                if ($question['QuestionType'] == 3 || $question['QuestionType'] == 4) {
                    
                    $optionsArray = $question['OptionName'];
                      $JustificationPlaceholders = $question['JustificationPlaceholders'];
                     
                      if($question['AnyOther'] == 1){
                         $question['OtherValue'] = end($optionsArray);
                    }
                    
                    
                    $labelNameArray = $question['LabelName'];
                    if ($question['Other'] == 1) {

                        array_push($labelNameArray, "N/A");
                    }
                    $question['LabelName'] = $labelNameArray;
                    $optionsNewArray = array();
                     $optionsCommentsNewArray = array();
                  
                    foreach ($optionsArray as $option) {
                        $emptyArray = array();
                        for ($i = 0; $i < sizeof($labelNameArray); $i++) {
                            array_push($emptyArray, 0);
                        }

                        $optionsNewArray[$option] = $emptyArray;
                    }
                 
                   foreach ($JustificationPlaceholders as $key=>$optionComment) {
                                        
                        $optionsCommentsNewArray[$key] = 0;
                    }
                    
                    if ($question['QuestionType'] == 3) {
                        $answersArray = $questionType3;
                    } else if ($question['QuestionType'] == 4) {
                        $answersArray = $questionType4;
                    }
                    $userSelectedOptionsArray = array();
                    $userCount=0;
                    foreach ($answersArray as $value) {
                        
                        if ($question['QuestionId'] == $value["QuestionId"]) {   
                            $selectedOptionArray = $value['Options'];
                             $selectedOptionCommnetsArray = $value['OptionCommnets'];
                          
                            $userSelectedOptionsArray[$value['UserId']] = $value['Options'];
                            foreach ($selectedOptionArray as $key => $sop) {
                                                       
                                if (isset($optionsNewArray[$optionsArray[$key]])) {

                                   
                                    if(is_array($sop)){                                        
                                            foreach ($sop as $x=>$v) {                                                
                                               // $val = $optionsNewArray[$optionsArray[$key]][$v - 1];
                                                $val = $optionsNewArray[$optionsArray[$key]][$x];
                                                $optionsNewArray[$optionsArray[$key]][$x] = $val+$v;                                             
                                            }
                                      
                                    }else
                                    if($sop > 0){
                                        $val = $optionsNewArray[$optionsArray[$key]][$sop - 1];
                                        $optionsNewArray[$optionsArray[$key]][$sop - 1] = $val + 1;
                                    }
                                   } else {
                                    }

                                    
                            }
                      
                        foreach ($selectedOptionCommnetsArray as $key => $sop) {
                    if(isset($sop) && !empty($sop)){
                       $val =  $optionsCommentsNewArray[$key];
                       $optionsCommentsNewArray[$key] = $val+1;
                    }
                                    
                            }
                           
                            $question['OptionsNewArray'] = $optionsNewArray;
                            $userOptionComments = array();
                            if(sizeof($value["OptionCommnets"])>0){
                                foreach ($value["OptionCommnets"] as $key => $value1) {                                   
                                    $userOptionComments[$key] = $value1;
                                }
                            }
                            $optionsPercentageArray = array();                          
                            foreach ($optionsNewArray as $key => $value) {
                                $percent = 0;
                                $totalValue = array_sum($value);
                                foreach ($value as $k => $v) {
                                    if($totalValue > 0){
                                        $percent = floor(($v * 100) / $totalValue);
                                        $isUserAnswered = 1;
                                    }else{
                                        $isUserAnswered = 0;
                                    }
                                    $value[$k] = $percent;
                                }

                                $optionsPercentageArray[$key] = $value;
                            }
                            
                            $userCount++;
                            
                        }

                    }
                           $optionsCommentsPercentageArray = array();
                             $sumComments = $userCount;
                              foreach ($optionsCommentsNewArray as $key => $value) {
                    
                                $percent = 0;
                                if($sumComments !=0){
                                     $percent = floor(($value * 100) / $sumComments);
                                $optionsCommentsPercentageArray[$key] = $percent;
                                }else{
                                    $optionsCommentsPercentageArray[$key] = 0; 
                                }
                                
                            }
                    $question['OptionsPercentageArray'] = $optionsPercentageArray;
                    $question['OptionCommnets'] = $userOptionComments;
                     $question['OptionsCommentsPercentageArray'] = $optionsCommentsPercentageArray;
                      $question['OptionsCommentsNewArray'] = $optionsCommentsNewArray;
                    if(!empty($userId) && isset($userSelectedOptionsArray[$userId]) && !empty( $userSelectedOptionsArray[$userId]))
                        $question['userSelectedOptionsArray'] = $userSelectedOptionsArray[$userId];
                    else
                        $question['userSelectedOptionsArray'] = array();
                    $question['SurveyTakenUsers'] = sizeof($scheduleObject->SurveyTakenUsers);
                    $question['isUserAnswered'] = $isUserAnswered;
                   
                    
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                }



                if ($question['QuestionType'] == 5) {

                    $userAnnotationArray = array();
                    $optionsArray = $question['OptionName'];
                    $optionsNewArray = array();
                    foreach ($optionsArray as $option) {
                        $optionsNewArray[$option] = 0;
                    }
                    $answersArray = $questionType5;

                    foreach ($answersArray as $value) {
                        if ($question['QuestionId'] == $value["QuestionId"]) {
                            
                            $selectedOptionArray = $value['DistributionValues'];
                            foreach ($selectedOptionArray as $key => $sop) {                                
                                if ((int)$userId == (int)$value["UserId"] && $sop > 0) {
                                    array_push($userAnnotationArray, $optionsArray[$key]);
                                }
                                if (isset($optionsNewArray[$optionsArray[$key]])) {
                                    $val = $optionsNewArray[$optionsArray[$key]];
                                    $optionsNewArray[$optionsArray[$key]] = $val + $sop;
                                }
                            }

                        }
                    }
                    $optionsPercentageArray = array();
                    $percentTageValue = 0;
                    $totalValue = array_sum($optionsNewArray);
                    foreach ($optionsNewArray as $key => $value) {
                        if($totalValue > 0){
                            $isUserAnswered = 1;
                            $percentTageValue = round(($value * 100) / $totalValue,2);
                        }else{
                            $isUserAnswered = 0;
                        }
                        $optionsPercentageArray[$key] = $percentTageValue;
                    }
                    
                    $question['OptionsNewArray'] = $optionsNewArray;
                    $question['OptionsPercentageArray'] = $optionsPercentageArray;
                    if (!empty($userId) && !empty($userAnnotationArray)) {
                        $question['UserAnnotationArray'] = $userAnnotationArray;
                    }else{
                        $question['UserAnnotationArray'] = array();
                    }
                    $question['SurveyTakenUsers'] = sizeof($scheduleObject->SurveyTakenUsers);
                    $question['isUserAnswered'] = $isUserAnswered;
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                }

                if ($question['QuestionType'] == 6) {

                    $answersArray = $questionType6;
                     $answeredCount = 0;
                    foreach ($answersArray as $value) {
                        if ($question['QuestionId'] == $value["QuestionId"]) {
                        $answeredCount++;
                        }
                    }
                        
                   $unansweredUsersCount =  $totalSurveyTakenUsers - $answeredCount;
                
                    $question['OptionsNewArray'] = ["Answered Users"=>$answeredCount,"Unanswered Users"=>$unansweredUsersCount];
                   $optionsPercentageArray = array();
                    foreach($question['OptionsNewArray'] as $key=>$value){
                      $optionsPercentageArray[$key] =  ($value/$totalSurveyTakenUsers)*100;
                            }
                     $question['OptionsPercentageArray'] = $optionsPercentageArray;
                            
                
                    $question['SurveyTakenUsers'] = sizeof($scheduleObject->SurveyTakenUsers);
                    $question['isUserAnswered'] = $isUserAnswered;
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                             }

                if ($question['QuestionType'] == 7) {
                    $answersArray = $questionType7;
                    $userAnswersTotalArray = array();
                    foreach ($answersArray as $value) {
                        if ($question['QuestionId'] == $value["QuestionId"]) {
                            $userAnswer = $value['UsergeneratedRankingOptions'];
                            foreach ($userAnswer as $v) {

                                array_push($userAnswersTotalArray, $v);
                            }
                        }
                    }
                    $userAnswersTotalArray = array_map('strtolower', $userAnswersTotalArray);
                    $userAnswersTotalArray = array_map('trim', $userAnswersTotalArray);
                    $words = array_count_values($userAnswersTotalArray);
                    arsort($words);
                    $words = array_slice($words, 0, 5, true);
                    $words1 = array_slice($words, 4);
                    
                    $optionsPercentageArray = array();
                    $percentTageValue = 0;
                    foreach($words as $k=>$v){
                        if(sizeof($words) > 0){
                            $percentTageValue = ($v * 100) / sizeof($words);
                            $isUserAnswered = 1;
                        }else{
                            $isUserAnswered = 0;
                        }
                        $optionsPercentageArray[$k] = $percentTageValue;
                            
                        }
                    $otherValue = array_sum($words1);
                    
                    $words["Other"] = $otherValue;
                    $question['OptionsNewArray'] = $words;
                    $question['OptionsPercentageArray'] = $optionsPercentageArray;
                    $question['SurveyTakenUsers'] = sizeof($scheduleObject->SurveyTakenUsers);
                    $question['isUserAnswered'] = $isUserAnswered;
                    $isUserAnswered = 0;
                    array_push($newQuestionsArray, $question);
                }
            }
            
            }


            $analyticsPreviewArray = array();
            foreach($newQuestionsArray as $row){
                if($row['isUserAnswered']){
                    array_push($analyticsPreviewArray,$row);
                }
            }
            $surveyObject->Questions = $newQuestionsArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepateSurveyAnalyticsDataByGroup::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepateSurveyAnalyticsDataByGroup==".$ex->getMessage());
        }
        $totalArray[0] = $surveyObject;
        $totalArray[1] = $dateTotalArray;
        $totalArray[2] = count($totalAnsweredUsersArray);
        $totalArray[3] = count($abandonedUsersArray);
         $pagesAnalyticsData = CommonUtility::getSurveyPageAnalytics("",$surveyId);
        $PagesAnalyticsData = $pagesAnalyticsData["PagesAnalyticsData"];
        $totalTimeSpent = $pagesAnalyticsData["totalTimeSpent"];
           if($totalTimeSpent > 0 ){
                $avgTimeSpentOnSurvey = $totalTimeSpent/( $totalArray[2]+$totalArray[3]);
            }else{
                $avgTimeSpentOnSurvey = 0;
            }
         $avgTimeSpentOnSurvey =  gmdate("H:i:s", $avgTimeSpentOnSurvey);  
        $pagesAnalyticsData["avgTimeSpent"] = $avgTimeSpentOnSurvey;
         foreach ($PagesAnalyticsData as $key=>$value) {
             $PageTimeSpentInSeconds =  $value["PageTimeSpentInSeconds"];
              $percentage = ($PageTimeSpentInSeconds/$totalTimeSpent)*100;
              $percentage = round($percentage,2);
             $value["Percentage"] = $percentage;
             $PagesAnalyticsData[$key] = $value;
         }
            
         $pagesAnalyticsData["PagesAnalyticsData"] = $PagesAnalyticsData;
           $totalArray[4] = $pagesAnalyticsData;
        
        return $totalArray;
    }    
    
    public static function resizeImage($filepath,$resizeType,$resizeValue){
        try{
            $img = Yii::app()->simpleImage->load($filepath);
            list($width, $height) = getimagesize($filepath);
            if($resizeType == "both"){
                if ($width > $resizeValue) {
                    $img->resizeToWidth($resizeValue);
                }
                if ( $heigh > $resizeValue) {
                    $img->resizeToHeight($resizeValue);
                }
            } else if($resizeType == "width"){
                if ( $width > $resizeValue) {
                    $img->resizeToWidth($resizeValue);
                }
            } else if($resizeType == "height"){
                if ($heigh > $resizeValue) {
                    $img->resizeToHeight($resizeValue);
                }
            }
           
            $img->save($filepath); 
        } catch (Exception $ex) {
            Yii::log("CommonUtility:resizeImage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /*
     * MOin Hussain
     * Sending Push notification for IOS and Droid
     */
     public static function initiatePushNotification($obj,$main) {
        try {
            if (isset($obj->ActionType) && $obj->ActionType == 'Comment') {
             if ($obj->IsBlockedWordExist != 1) {
                if ($obj->OriginalUserId != $obj->UserId) {
                    $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($obj->OriginalUserId);
                    if ($userSettings != "failure") {
                        if ($userSettings->Commented == 1) {
                         
                                $notificationObj = Notifications::model()->getNotificationForPostByActionType($obj->PostId,"comment");
                                if($notificationObj!=""){
                                $commentCount = sizeof($notificationObj->CommentUserId);
                                $readStatus = $notificationObj->isRead;
                                if($commentCount == 4){
                                    
                                    if($readStatus == 0){
                                         //send push 
                                        $usercount =  sizeof(array_unique($notificationObj->CommentUserId));
                                        
                                         CommonUtility::sendPushNotification($obj,$usercount);
                                    }else{
                                    }
                                }else{
                                    $commentCount = $commentCount + 1;
                                    $frequency = CommonUtility::pushNotificationConfigurationByActionType($obj->ActionType);
                                    if($commentCount%$frequency == 0){
                                        if($readStatus == 0){
                                              //send push
                                          $usercount =  sizeof(array_unique($notificationObj->CommentUserId));

                                           CommonUtility::sendPushNotification($obj,$usercount);
                                        }
                                    }else{
                                    }
                                }
                            }else{
                                         //send push
                                         CommonUtility::sendPushNotification($obj,1);
                            }
                                
                           
                        }
                    }
                }
           }
           
            }
            else if (isset($obj->ActionType) && $obj->ActionType == 'Love') {
                if ($obj->OriginalUserId != $obj->LoveUserId) {
                    $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($obj->OriginalUserId);
                    if ($userSettings != "failure") {
                        if ($userSettings->Loved == 1) {
                          
                                $notificationObj = Notifications::model()->getNotificationForPostByActionType($obj->PostId,"love");
                                if($notificationObj!=""){
                                $loveCount = sizeof($notificationObj->Love);
                                $loveReadStatus = $notificationObj->isRead;
                                if($loveCount == 4){
                                    
                                    if($loveReadStatus == 0){
                                         //send push 
                                         $usercount =  sizeof(array_unique($notificationObj->Love));
                                         CommonUtility::sendPushNotification($obj,$usercount);
                                    }else{
                                        // error_log("*******love skipped notification*********** ");
                                    }
                                }else{
                                    $loveCount = $loveCount + 1;
                                    $frequency = CommonUtility::pushNotificationConfigurationByActionType($obj->ActionType);
                                    if($loveCount%$frequency == 0){
                                        if($loveReadStatus == 0){
                                              //send push
                                             $usercount =  sizeof(array_unique($notificationObj->Love));

                                           CommonUtility::sendPushNotification($obj,$usercount);
                                        }
                                    }else{
                                        // error_log("*******love skipped notification*********** ");
                                    }
                                }
                            }
                                
                           
                        }
                    }
                }
            }
             else if (isset($obj->ActionType) && $obj->ActionType == 'Follow') {
                if ($obj->OriginalUserId != $obj->UserId) {
                    $userSettings = UserNotificationSettingsCollection::model()->getUserSettings($obj->OriginalUserId);
                    if ($userSettings != "failure") {
                        if ($userSettings->ActivityFollowed == 1) {
                          
                                $notificationObj = Notifications::model()->getNotificationForPostByActionType($obj->PostId,"follow");
                                if($notificationObj!=""){
                                $followersCount = sizeof($notificationObj->PostFollowers);
                                $readStatus = $notificationObj->isRead;
                                if($followersCount == 4){
                                    
                                    if($readStatus == 0){
                                         //send push 
                                         $usercount =  sizeof(array_unique($notificationObj->PostFollowers));

                                         CommonUtility::sendPushNotification($obj,$usercount);
                                    }else{
                                        // error_log("*******follow skipped notification*********** ");
                                    }
                                }else{
                                    $followersCount = $followersCount + 1;
                                    $frequency = CommonUtility::pushNotificationConfigurationByActionType($obj->ActionType);
                                    if($followersCount%$frequency == 0){
                                        if($readStatus == 0){
                                              //send push
                                          $usercount =  sizeof(array_unique($notificationObj->PostFollowers));
                                           CommonUtility::sendPushNotification($obj,$usercount);
                                        }
                                    }else{
                                         //error_log("*******follow skipped notification*********** ");
                                    }
                                }
                            }
                                
                           
                        }
                    }
                }
            }
             else if (isset($obj->ActionType) && $obj->ActionType == 'Chat') {
                   CommonUtility::sendPushNotification($obj,0);
              }
            if($main == false){
               if (isset($obj->ActionType) && $obj->ActionType == 'Mention') {
                   CommonUtility::sendPushNotification($obj,0);
            }
              else  if (isset($obj->ActionType) && $obj->ActionType == 'Invite') {
                    CommonUtility::sendPushNotification($obj,0);
            }  
            }
             
           
        } catch (Exception $ex) {
            Yii::log("CommonUtility:initiatePushNotification::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->initiatePushNotification==".$ex->getMessage());

        }
    }
    public static function pushNotificationConfigurationByActionType($actionType) {
        try{
        $frequency = 10;
         if($actionType == "comment"){
              $frequency = 10;
        }
        else if($actionType == "Love"){
              $frequency = 10;
        }
        else if($actionType == "Follow"){
              $frequency = 10;
        }
        return $frequency;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:pushNotificationConfigurationByActionType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    static function sendPushNotification($obj,$count){
        try{
            $device_tokens = MobileSessions::model()->getDeviceTokensForUser($obj->OriginalUserId);
            $push = 0;
             if($count>1){
                     $count--;
                     if($count == 1){
                         $string = " and ".$count. " other";
                     }else{
                          $string = " and ".$count. " others";
                     }
                     
                 }else{
                   $string = "";
   
                 }
            if($obj->ActionType == "Comment"){
                 $userObj = UserCollection::model()->getTinyUserCollection($obj->UserId);
                
                  $message = $userObj->DisplayName.$string." commented on your post"; 
                 $push = 1;
            }
            else if($obj->ActionType == "Love"){
                 $userObj = UserCollection::model()->getTinyUserCollection($obj->LoveUserId);
                 $message = $userObj->DisplayName.$string." loved your post";
                 $push = 1;
            }
            else if($obj->ActionType == "Follow"){
                 $userObj = UserCollection::model()->getTinyUserCollection($obj->UserId);
                 $message = $userObj->DisplayName.$string." followed your post";
                 $push = 1;
            }
              else if($obj->ActionType == "Mention"){
                 $userObj = UserCollection::model()->getTinyUserCollection($obj->UserId);
                 $message = $userObj->DisplayName." mentioned you on post";
                 $push = 1;
            }
              else if($obj->ActionType == "Invite"){
                 $userObj = UserCollection::model()->getTinyUserCollection($obj->UserId);
                 $message = $userObj->DisplayName." invited you on post";
                 $push = 1;
            }
            else if($obj->ActionType == "Chat"){
                 $userObj = UserCollection::model()->getTinyUserCollection($obj->UserId);
                 $message = $userObj->DisplayName." sent a message for you";
                 $push = 1;
            }
            if($push == 1){
              PushNotificationCollection::model()->savePushNotification($obj->OriginalUserId,$message);
              $count =  PushNotificationCollection::model()->getUnreadMessagesCount($obj->OriginalUserId);
              CommonUtility::sendIOSPushNotification($message,$count,$device_tokens,$obj->ActionType);
              CommonUtility::sendAndroidPushNotification($message,$count,$device_tokens,$obj->ActionType);
            }
              
        } catch (Exception $ex) {
            Yii::log("CommonUtility:sendPushNotification::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->sendPushNotification==".$ex->getMessage());
        }
    }
    static function sendIOSPushNotification($message,$badge=1,$device_tokens,$actionType){
        try{
          if (array_key_exists(1,$device_tokens)){
          $iosDevice_tokens = $device_tokens[1];
  
          $sound = "default";
          $passphrase = Yii::app()->params['PusNotificationPassPhrase'] ;

          $payload = array();
          $payload['aps'] = array(
              'alert' => $message,
              'badge' => intval($badge),
              'sound' => $sound

          );
          if($actionType == "Chat"){
               $payload['actionType']="chat";
          }else{
              $payload['actionType']="notification";
          }
        $payload = json_encode($payload);    

          $apns_url = NULL;
          $apns_cert = NULL;
          $apns_port = 2195;

          $networkName = Yii::app()->params['NetworkName'];
          $networkName = preg_replace('/\s+/', '', $networkName);
          if(DEPLOYMENT_MODE == 'DEVELOPMENT'){

              $apns_url = "gateway.sandbox.push.apple.com";

              $apns_cert = $networkName."_Dev.pem";


          } else{
              $apns_url = "gateway.push.apple.com";

              $apns_cert = $networkName."_Prod.pem";
          }
          $stream_context = stream_context_create();
          stream_context_set_option($stream_context, 'ssl', 'local_cert', $apns_cert);   
          stream_context_set_option($stream_context, 'ssl', 'passphrase', $passphrase);
          $apns = @stream_socket_client('ssl://' . $apns_url . ':' . $apns_port, $error, $error_string, 2, STREAM_CLIENT_CONNECT, $stream_context);
          if(!$apns){
              error_log("Failed To Connect : $error $error_string");
               Yii::log("Problem in Push notfication Cerificate -- ".$apns_cert, "error", "application");
              return;
          } else{
                error_log('Connection Successful..!');
          }

          foreach ($iosDevice_tokens as $token) {
              $apns_message = chr(0) . chr(0) . chr(32);
              $apns_message .= pack('H*', str_replace(' ', '', $token));
              $apns_message .= chr(0) . chr(strlen($payload)) . $payload; 
              fwrite($apns, $apns_message);
          }

          error_log("Notification Delivered Successfully..!");

          //@socket_close($apns);
          @fclose($apns);
            }
        }catch(Exception $ex){
             Yii::log("CommonUtility:sendIOSPushNotification::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
    }
     static function sendAndroidPushNotification($message,$badge=1,$device_tokens,$actionType){
         try{
        $apiKey = Yii::app()->params['DroidGMSApiKey'];
        if (array_key_exists(2, $device_tokens)) {
            $registrationIDs = $device_tokens[2];
            $url = 'https://android.googleapis.com/gcm/send';
            $data = array("title"=>Yii::app()->params['NetworkName'],"message" => $message, "msgcnt" => $badge);
           if($actionType == "Chat"){
               $data['actionType']="chat";
          }else{
              $data['actionType']="notification";
          }
            $fields = array(
                'registration_ids' => $registrationIDs,
                'data' => $data,
            );
            $headers = array(
                'Authorization: key=' . $apiKey,
                'Content-Type: application/json'
            );

            // Open connection
            $ch = curl_init();

            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //     curl_setopt($ch, CURLOPT_POST, true);
            //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            // Execute post
            $result = curl_exec($ch);

            // Close connection
            curl_close($ch);
            echo $result;
            //print_r($result);
            //var_dump($result);  
        }
       }catch(Exception $ex){
            Yii::log("CommonUtility:sendAndroidPushNotification::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
       }
    }
    static function findUrlInStringAndMakeLink($htmlString){
        try{
            $htmlString = str_replace("&nbsp;","",$htmlString);
            $url = str_replace("https","",YII::app()->params['ServerURL']);
            $url = str_replace("http","",$url);
            $pattern = "~<a\s+.*?</a>~is";
            if(!preg_match_all($pattern, $htmlString)){
                if(stristr($htmlString,$url) != ""){
                    $htmlString = preg_replace("/(((https?)\:\/\/)|(www\.))[A-Za-z0-9][A-Za-z0-9.-]+(:\d+)?(\/[^ ]*)?/",
                            "<a href=\"\\0\" >\\0</a>",
                            $htmlString);
                }else{
                    $htmlString = preg_replace("/(((https?)\:\/\/)|(www\.))[A-Za-z0-9][A-Za-z0-9.-]+(:\d+)?(\/[^ ]*)?/",
                                "<a href=\"\\0\" target='_blank'>\\0</a>",
                                $htmlString);
                }
            }

            return $htmlString;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:findUrlInStringAndMakeLink::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->findUrlInStringAndMakeLink==".$ex->getMessage());
        }
    }

    
    
     static function getIndexByDSNNotficationType($type = '') {
        try {
            $index = 0;
            if ($type == 'Trending Topic') {
                $index = 1;
            }
            if ($type == 'New Topic') {
                $index = 2;
            }
            
             if ($type == 'New Post') {
                $index = 3;
            }
            if ($type == 'New Game') {
                $index = 4;
            }

            

            return $index;
        } catch (Exception $ex) {
          Yii::log("CommonUtility:getIndexByDSNNotficationType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


    static function prepareComments($pageSize, $MinpageSize, $postId, $categoryType, $IsWebSnippetExist="", $numberOfComments=5, $isPostManagement=0) {
        try {
          $result = ServiceFactory::getSkiptaPostServiceInstance()->getRecentCommentsforPost($pageSize, $MinpageSize, $postId, (int) $categoryType);
         $commentDisplayCount = 0;
         $rs=array();
    if(is_array($result) || is_object($result)){$rs=array_reverse($result);}
         $MoreCommentsArray = array();
        foreach ($rs as $key => $value) {
            $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
            $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
            if($isPostManagement==1){
                $IsBlockedWordExist = false;
                $IsAbused = false;
            }
            if(!$IsBlockedWordExist && !$IsAbused){
                $commentUserBean = new CommentUserBean();
                $userDetails = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($value['UserId']);
                $createdOn = $value['CreatedOn'];
                $commentUserBean->UserId = $userDetails['UserId'];

                $postId = (isset($value["PostId"])) ? $value["PostId"] : '';
                $CategoryType = (isset($value["CategoryType"])) ? $value["CategoryType"] : $categoryType;
                $PostType = (isset($value["PostType"])) ? $value["PostType"] : '';
                $commentUserBean->CommentText = $value['CommentText'];
                $commentUserBean->CommentId = $value['CommentId'];
                $commentUserBean->Language = $value['Language'];
                if($IsWebSnippetExist!=""){
                    $commentUserBean->CommentText = CommonUtility::findUrlInStringAndMakeLink($value['CommentText']);
                }
                if(is_int($createdOn))
                {
                    $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn);
                }
                else if(is_numeric($createdOn))
                {
                    $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn);
                }
                else
                {
                    
                    $commentUserBean->PostOn = CommonUtility::styleDateTime($createdOn->sec);
                }

                $commentUserBean->DisplayName = $userDetails['DisplayName'];
                $commentUserBean->ProfilePic = $userDetails['profile70x70'];
                $commentUserBean->CategoryType = $CategoryType;
                $commentUserBean->PostId = $postId;
                $commentUserBean->Type = $PostType;
                $commentUserBean->Resource=$value['Artifacts'];
                $commentUserBean->ResourceLength = count($value['Artifacts']);
                //$commenturls=$value['WebUrls'];
                if (array_key_exists('WebUrls', $value)) {
                 if(isset($value['WebUrls']) && is_array($value['WebUrls']) && count($value['WebUrls'])>0){
                     
                      $commenturls=$value['WebUrls'];
                         $WeburlObj = ServiceFactory::getSkiptaPostServiceInstance()->CheckWebUrlExist($commenturls[0]);
                     
                         if($WeburlObj!='failure'){
                               $snippetData=$WeburlObj;
                          }else{
                              
                              $snippetData="";
                          }
                        }else{
                            
                            $snippetData="";
                        }
                    $commentUserBean->snippetdata = $snippetData;
                     if(isset($value['IsWebSnippetExist'])){
                         $commentUserBean->IsWebSnippetExist = $value['IsWebSnippetExist'];
                    }else{
                         $commentUserBean->IsWebSnippetExist = "";
                    }
                  }

                array_push($MoreCommentsArray, $commentUserBean);
                 $commentDisplayCount++;
                  if($commentDisplayCount==$numberOfComments){
                                break;
                     }
                
            }
        }
        return $MoreCommentsArray;   
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareComments==".$ex->getMessage());
        }

       
    }

    static function preparePostDetailData($postId, $postType, $categoryType, $loggedInUserId, $IsLoadRequest,$UserPrivileges,$recentActivity="", $timezone="", $translate=0,$isPostManagement=0) {
        $curbsideCategory = array();
        $object=0;
         try{
        if ($categoryType == 1 && $postType != 5) {
                $object = ServiceFactory::getSkiptaPostServiceInstance()->getPostObjectById($postId);
        } else if ($postType == 5) {
            $object = ServiceFactory::getSkiptaPostServiceInstance()->getCurbsidePostObjectById($postId);
        } else if ($postType == 2 || $categoryType == 3 || $categoryType == 7) {
            $object = ServiceFactory::getSkiptaPostServiceInstance()->getGroupPostObjectById($postId);
            $groupStatus=ServiceFactory::getSkiptaGroupServiceInstance()->getGroupStatus($object->GroupId);
            if(!is_string($groupStatus)){
                $object['Status']=$groupStatus->Status;
            }
        } else if($categoryType == 8){                
            $object = ServiceFactory::getSkiptaPostServiceInstance()->getNewsPostObjectById($postId);
        }
         else if ($categoryType == 10) 
        {
            $object = ServiceFactory::getSkiptaUserServiceInstance()->getUserBadgeObjectById($postId);
        }
        else if($categoryType == 12){
            $object = ServiceFactory::getSkiptaPostServiceInstance()->getCareerPostObjectById($postId);
        }
        if ((isset($object) && !empty($object)) && (is_array($object) || is_object($object)) ) {
            $UserId = $loggedInUserId;
            $IsWebSnippetExist="";
            $postType=isset($object->Type)?$object->Type:$postType;
            $tinyUserProfileObject = array();
            $tinyUserProfileObject = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($UserId);
            if (isset($object->WebUrls)) {
                if (isset($object->IsWebSnippetExist) && $object->IsWebSnippetExist == '1') {
                    $snippetdata = WebSnippetCollection::model()->CheckWebUrlExist($object->WebUrls[0]);
                    $object->WebUrls = $snippetdata;
                    $IsWebSnippetExist=1;
                } else {
                    $object->WebUrls = "";
                }
            }
            /***************************New changes**************Start****/
            $object = (array)$object;
            $object["IsPostManagement"] = $isPostManagement;
            $object["CreatedOn"] = date(Yii::app()->params['PHPDateFormat'], $object["CreatedOn"]->sec);
            if ($_REQUEST['recentActivity'] == "invite") {
                $inviteArray = array();
                $inviteArray = $object["Invite"];
                $userId = $loggedInUserId;

                foreach ($inviteArray as $n) {
                    if(is_array($n[1]))
                        $isPresent = in_array($userId, $n[1]);
                    
                    if ($isPresent) {
                        $object["InviteMessage"] = $n[2];
                        break;
                    }
                }
            }
//            if(isset($object["IsWebSnippetExist"]) && $object["IsWebSnippetExist"]=='1'){
                $object["Description"] = CommonUtility::findUrlInStringAndMakeLink($object["Description"]); 
//            }

$currenttinyUserProfileObject = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($object["UserId"]);
            $object["RecentActivity"]=$recentActivity;
            $object["CategoryType"] = (int)$categoryType;
            $object["Profile250x250"] = $currenttinyUserProfileObject["profile250x250"];
            $object["Profile70x70"] = $currenttinyUserProfileObject["profile70x70"];
            $object["DisplayName"] = $currenttinyUserProfileObject["DisplayName"];
             
            $PostTypeString = CommonUtility::postTypebyIndex($object["Type"]); 
            $PostTypeString = trim($PostTypeString) == trim("a Survey")?Yii::t("translation","Survey"):$PostTypeString;
            $ActionText = CommonUtility::actionTextbyActionType($object["Type"]);
            if($categoryType == 3){
                $PostTypeString = "Group $PostTypeString";
            }
             if($categoryType == 10){
                $ActionText = "unlocked";
            }
            $object["IsFollowing"] = in_array($loggedInUserId, $object["Followers"]);
            $object["IsLoved"] = in_array($loggedInUserId, $object["Love"]);
            $object["FollowCount"] = count($object["Followers"]);
            $object["LoveCount"] = count($object["Love"]);
            $commentCount=0;
            if (!$object["DisableComments"]) {
                if (count($object["Comments"]) > 0) {
                    foreach ($object["Comments"] as $key => $value) {
                        $IsBlockedWordExist = isset($value['IsBlockedWordExist']) && $value['IsBlockedWordExist']?true:false;
                        $IsAbused = isset($value['IsAbused']) && $value['IsAbused']?true:false;
                        if($isPostManagement==1){
                            $IsBlockedWordExist = false;
                            $IsAbused = false;
                        }
                        if(!$IsBlockedWordExist && !$IsAbused){
                            $commentCount++;
                        }
                    }
                }
            }
            $object["CommentCount"] = $commentCount;
            $object["CategoryType"] = $categoryType;
            $ShareCount = 0;
            $FbShareCount = isset($object["FbShare"]) && is_array($object["FbShare"])?sizeof($object["FbShare"]):0;
            $TwitterShareCount = isset($object["TwitterShare"]) && is_array($object["TwitterShare"])?sizeof($object["TwitterShare"]):0;            
            $ShareCount = $FbShareCount+$TwitterShareCount;
            $ShareCount = $FbShareCount+$TwitterShareCount;
            $object["ShareCount"] = $ShareCount;
            $IsFbShare = isset($object["FbShare"]) && is_array($object["FbShare"])?in_array($UserId, $object["FbShare"]):0;
            $IsTwitterShare = isset($object["TwitterShare"]) && is_array($object["TwitterShare"])?in_array($UserId, $object["TwitterShare"]):0;
            $object["IsFbShare"] = $IsFbShare;
            $object["IsTwitterShare"] = $IsTwitterShare;
            if(!$IsTwitterShare || !$IsFbShare){
                $object["ShareClass"] = ($IsTwitterShare || $IsFbShare)>0?'sharedisable':'share';
            }
            $ShareCount = $FbShareCount+$TwitterShareCount;
            $object["PostTypeString"] = $PostTypeString;
            $object["ActionText"] = $ActionText;
            
            $object["DisplayName1"]=$object["UserId"]==$loggedInUserId?'You':$currenttinyUserProfileObject["DisplayName"];
            $object["PostOn"] = $object["CreatedOn"]; 
            
            if($postType==2 && isset($object["StartDate"]) && $object["EndDate"]){ 
                $eventStartDate = CommonUtility::convert_time_zone($object["StartDate"]->sec,$timezone,'','sec');
                $eventEndDate = CommonUtility::convert_time_zone($object["EndDate"]->sec,$timezone,'','sec');
                   
                $object["StartDate"] = date("Y-m-d", $eventStartDate);
                $object["EndDate"] = date("Y-m-d", $eventEndDate);
                $EventStartDay = date("d", $eventStartDate);
                $EventStartDayString = date("l", $eventStartDate);
                $EventStartMonth = date("M", $eventEndDate);
                $EventStartYear = date("Y", $eventEndDate);
                $EventEndDay = date("d", $eventEndDate);
                $EventEndDayString = date("l", $eventEndDate);
                $EventEndMonth = date("M", $eventEndDate);
                $EventEndYear = date("Y", $eventEndDate);
                $object["IsEventAttend"] = in_array($loggedInUserId,$object["EventAttendes"]);
                $object["EventStartMonth"] = $EventStartMonth;
                $object["EventStartYear"] = $EventStartYear;
                $object["EventStartDay"] = $EventStartDay;
                $object["EventStartDayString"] = $EventStartDayString;
                $object["EventEndMonth"] = $EventEndMonth;
                $object["EventEndYear"] = $EventEndYear;
                $object["EventEndDay"] = $EventEndDay;
                $object["EventEndDayString"] = $EventEndDayString;
            }else if($postType==3) {
                $IsSurveyTaken = 0; 
                if(isset($object["SurveyTaken"])){
                    foreach($object["SurveyTaken"] as $surveyTaken){
                        if($surveyTaken['UserId']==$UserId){
                            $IsSurveyTaken = 1;
                        }
                    }
                }
                     $surveyExpiryDate = $object['ExpiryDate'];
                   
                    if (isset($surveyExpiryDate->sec) && $surveyExpiryDate->sec <= time()) {
                       $object['ExpiryDate'] = date("Y-m-d", $surveyExpiryDate->sec);
                         $surveyExpiryDate_tz = CommonUtility::convert_date_zone($surveyExpiryDate->sec, $timezone);
                        $currentDate_tz = CommonUtility::currentdate_timezone($timezone);
                        if ($surveyExpiryDate_tz < $currentDate_tz) {
                            $IsSurveyTaken = 1; //expired
                        }
                    }
                  
                
                $object["IsSurveyTaken"] = $IsSurveyTaken;
                $isOptionDExist = -1;
                if(isset($object["OptionFour"]) && !empty($object["OptionFour"])){ 
                    $isOptionDExist = 0;
                 }
                $object["IsOptionDExist"] = $isOptionDExist;
                $TotalSurveyCount = $object["OptionOneCount"]+$object["OptionTwoCount"]+$object["OptionThreeCount"]+$object["OptionFourCount"];
                $object["TotalSurveyCount"] = $TotalSurveyCount;
            }else if($postType=5){
                $curbsideCategory = CurbSideCategoryCollection::model()->getCurbsideCategoriesByCategoryId($object["CategoryId"]);
                $object["CategoryName"] = isset($curbsideCategory->CategoryName)?$curbsideCategory->CategoryName:'';
            }
            
            if($IsLoadRequest==0){
                $mainGroupCollection="";
                $isGroupAdmin="false";
                if ($postType == 2 || $categoryType == 3 || $categoryType == 7) {
                    $groupObject = ServiceFactory::getSkiptaPostServiceInstance()->getGroupPostObjectById($postId);
                    $isGroupPostAdmin = ServiceFactory::getSkiptaPostServiceInstance()->checkIsGroupAdminById($groupObject);
                    $object["IsGroupPostAdmin"] = $isGroupPostAdmin;
                    if($isGroupPostAdmin == 'true')
                    {
                       $groupNameObject =  ServiceFactory::getSkiptaPostServiceInstance()->getGroupNameById($groupObject->GroupId);
                       if($groupNameObject != 'failure')
                       {
                            $mainGroupCollection = $groupNameObject;
                            $object["GroupProfileImage"] = $mainGroupCollection->GroupProfileImage;
                            $object["GroupId"] = $mainGroupCollection->_id;
                            $object["GroupName"] = $mainGroupCollection->GroupName;
                            $object["IsIFrameMode"] = $mainGroupCollection->IsIFrameMode;
                            $object["AddSocialActions"] = $mainGroupCollection->AddSocialActions;
                        }
                    }

                }else if ($categoryType == 10) 
                {
                    $badgeInfo=ServiceFactory::getSkiptaUserServiceInstance()->getBadgeInfoById($object["BadgeId"]);
                    $object["BadgeName"] = $badgeInfo->badgeName;
                    $object["BadgeImagePath"] = $badgeInfo->image_path;
                    $object["BadgeDescription"] = $badgeInfo->description;
                }
            }

         $object["PostType"] = (int)$postType;
         if($postType==2){
              $object["EventAttendCount"] = count(array_values(array_unique($object["EventAttendes"])));
              $lovefollowArray =  CommonUtility::getLoveAndFollowUsers($loggedInUserId,$object["Love"], $object["Followers"],$object["EventAttendes"]);
           
         }else if($postType==3){
              $object["SurveyTakenCount"] = count($object["SurveyTaken"]);
              $lovefollowArray =  CommonUtility::getLoveAndFollowUsers($loggedInUserId,$object["Love"], $object["Followers"],null,$object["SurveyTaken"]);
           
         }
         else{
          $lovefollowArray =  CommonUtility::getLoveAndFollowUsers($loggedInUserId,$object["Love"], $object["Followers"]);
         }
            $object["lovefollowArray"] = $lovefollowArray;
            $MinpageSize = 2;
            $page = 0;
            $pageSize = ($MinpageSize * $page);
            $numberOfComments = 10;
            $MoreCommentsArray = CommonUtility::prepareComments($pageSize, $MinpageSize, $postId, (int) $categoryType, $IsWebSnippetExist,$numberOfComments, $isPostManagement);
            $object["Comments"] = $MoreCommentsArray;
            $commentedUsers = ServiceFactory::getSkiptaPostServiceInstance()->getCommentedUsersForPost($postId, $loggedInUserId);
            $object["IsCommented"] = in_array($loggedInUserId, $commentedUsers);
          
                  if (is_array($UserPrivileges)) {
                    foreach ($UserPrivileges as $value) {
                        if ($value['Status'] == 1) {
                            if ($value['Action'] == 'Delete') {
                                $object["CanDeletePost"] = 1;
                            } else if ($value['Action'] == 'Promote_Post') {
                                $object["CanPromotePost"] = 1;
                            } else if ($value['Action'] == 'Promote_To_Featured_Items') {
                                $object["CanFeaturePost"] = 1;
                            } else if ($value['Action'] == 'Mark_As_Abuse') {
                               $object["CanMarkAsAbuse"] = 1;
                            }
                              else if ($value['Action'] == 'Can_Copy_URL') {
                                $object["CanCopyURL"]=1;
                            }

                             else if ($value['Action'] == 'Save_It_For_Later') {
                                $object["CanSaveItForLater"]=1;
                            }
                              else if ($value['Action'] == 'Digest_Use') {
                                $object["Digest_Use"]=1; 
                            }
                        }
                    }
                }
               $streamObj = UserStreamCollection::model()->getStreamObjbyPostId(new MongoId($postId), $loggedInUserId); 
                 if (sizeof($streamObj)>0) {
                  $object['IsSaveItForLater']= $streamObj->IsSaveItForLater;  
                 }  
               
           
            $object = (object)$object;
            if($translate==1){ 
                $object = CommonUtility::translatedPostDetailObject($object, $tinyUserProfileObject);
            }
            
            $title=""; 
            $object->ActionText=trim($object->ActionText);
if($object->Type != 4 && $object->IsAnonymous == 0 &&  $object->CategoryType!=10 ){ 

$title= $object->ActionText." ".$object->PostTypeString;}
else if($object->CategoryType == 10){
$title=$object->ActionText ." - ".$object->BadgeName."  badge";
}else{
 $title="A new post has been created"; }

        /**************Stream messages preperation*******Start*********/
        $categoryType = $object->CategoryType;
        $postTypeId = $object->Type;
        $recentActivity = "Post";
        $isAnonymous = $object->IsAnonymous;
        $isMine = 0;
        if($UserId==$object->UserId){
            $isMine = 1;
        }
        $badgeName = "";
        if ($object->CategoryType == 10) {
            $badgeName = Yii::t('posttypes',$object->BadgeName."Badge");
        }
        $cvType = "";
        if ($object->CategoryType == 12) {
            $cvType = $object->Title;
        }        
        
        $streamMessage = "";
        $streamMessage = CommonUtility::getStreamNote($categoryType, $postTypeId, $recentActivity, $isAnonymous, $isMine, $badgeName, $cvType);
        if($streamMessage!=""){
            $title = $streamMessage;
        }
        /**************Stream messages preperation*******End*********/
 
 if($object->IsAnonymous == 0 &&  $object->Type==2 || $object->Type==3){ if(isset($object->Title) && $object->Title!=""){ 

$title=$title."- ".$object->Title;
 };} 
 
//   if($tinyUserProfileObject->Language!="en"){
//$title = CommonUtility::getStreamNoteMessages($title, $tinyUserProfileObject->Language);
//}
 $title= $title."<i> $object->PostOn  </i>";
   $object->StreamTitle=$title;
   
   
            
          
        } else {
            $object = 0;
        }   
               return $object;
        }catch(Exception $ex){
            Yii::log("CommonUtility:preparePostDetailData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->preparePostDetailData==".$ex->getMessage());
           //  return $object;
        }
    }

    static function getLoveAndFollowUsers($UserId, $loveUsers, $followUsers,$eventAttendUsers=array(),$surveyUsers=array()) {
        try{
        $returnArr = array();
        $loveUsersArray = array();
        if(!is_array($loveUsers)){
           $loveUsers=array(); 
        }
         if(!is_array($followUsers)){
           $followUsers=array(); 
        }
        $loveUsers = array_unique($loveUsers);
        $followUsers = array_unique($followUsers);
        $loveUsers = array_reverse($loveUsers);
        $followUsers = array_reverse($followUsers);

        $key = array_search($UserId, $followUsers);
        if ($key != FALSE) {
            unset($followUsers[$key]);
            array_unshift($followUsers, $UserId);
        }


        $key = array_search($UserId, $loveUsers);


        if ($key != FALSE) {
            unset($loveUsers[$key]);
            array_unshift($loveUsers, $UserId);
        }

        if(is_array($eventAttendUsers)){
             $eventAttendUsers = array_unique($eventAttendUsers);
              $eventAttendUsers = array_reverse($eventAttendUsers);
          $key = array_search($UserId, $eventAttendUsers);
               if ($key != FALSE) {
                   unset($eventAttendUsers[$key]);
                   array_unshift($eventAttendUsers, $UserId);
               }
               if (sizeof($eventAttendUsers) > 10) {
                   $eventAttendUsers = array_slice($eventAttendUsers, 0, 10);
               }
        }
         if(is_array($surveyUsers)){
             
              $surveyUsersArray = array();
                foreach ($surveyUsers as $obj) {
                     array_push($surveyUsersArray,$obj["UserId"]);
                }
             
             
             $surveyUsersArray = array_unique($surveyUsersArray);
              $surveyUsersArray = array_reverse($surveyUsersArray);
          $key = array_search($UserId, $surveyUsersArray);
               if ($key != FALSE) {
                   unset($surveyUsersArray[$key]);
                   array_unshift($surveyUsersArray, $UserId);
               }
               if (sizeof($surveyUsersArray) > 10) {
                   $surveyUsersArray = array_slice($surveyUsersArray, 0, 10);
               }
        }
        
        


        if (sizeof($loveUsers) > 10) {
            $loveUsers = array_slice($loveUsers, 0, 10);
        }
        if (sizeof($followUsers) > 10) {
            $followUsers = array_slice($followUsers, 0, 10);
        }

        foreach ($loveUsers as $userId) {
            if ($UserId == $userId) {
                //$name = "You";
                $name = Yii::t('translation','You'); 
            } else {
                $name = UserCollection::model()->getUserName($userId);
            }
            if ($name != "") {

                array_push($loveUsersArray, $name);
            }
        }

        $followUsersArray = array();
        foreach ($followUsers as $userId) {
            if ($UserId == $userId) {
               $name = Yii::t('translation','You'); 
            } else {
                $name = UserCollection::model()->getUserName($userId);
            }
            if ($name != "") {
                array_push($followUsersArray, $name);
            }
        }
     if(is_array($eventAttendUsers)){
           $eventAttendUsersArray = array();
        foreach ($eventAttendUsers as $userId) {
            if ($UserId == $userId) {
                //$name = "You";
                $name = Yii::t('translation','You'); 
            } else {
                $name = UserCollection::model()->getUserName($userId);
            }
            if ($name != "") {
                array_push($eventAttendUsersArray, $name);
            }
        }
         $returnArr["eventAttendUsersArray"] = $eventAttendUsersArray;
     }
  if(is_array($surveyUsersArray)){
           $surveyUsersArrayFinal = array();
        foreach ($surveyUsersArray as $userId) {
          
            if ($UserId == $userId) {
                //$name = "You";
                $name = Yii::t('translation','You'); 
            } else {
                $name = UserCollection::model()->getUserName($userId);
            }
            if ($name != "") {
                array_push($surveyUsersArrayFinal, $name);
            }
        }
         $returnArr["surveyUsersArray"] = $surveyUsersArrayFinal;
     }
        /* Showing Followers and Lovers End */
        $returnArr["loveUsersArray"] = $loveUsersArray;
        $returnArr["followUsersArray"] = $followUsersArray;
        return $returnArr;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getLoveAndFollowUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


    static function setUserSession($email) {
        try{
        $userObj = ServiceFactory::getSkiptaUserServiceInstance()->getUserByType($email, 'Email');
        //ServiceFactory::getSkiptaUserServiceInstance()->saveUserLoginActivity($userObj->UserId);
        $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($userObj->UserId);
        ServiceFactory::getSkiptaPostServiceInstance()->trackEngagementAction($tinyUserCollectionObj->UserId, "Login", "Login", "", "0", "", $tinyUserCollectionObj->NetworkId, "", $tinyUserCollectionObj->SegmentId);
        $userPrivileges = ServiceFactory::getSkiptaUserServiceInstance()->getUserActionsByUserType($userObj->UserId, $userObj->UserTypeId);
        $userFollowingGroups = ServiceFactory::getSkiptaUserServiceInstance()->groupsUserFollowing($userObj->UserId);
        $userHierarchy = ServiceFactory::getSkiptaUserServiceInstance()->getUserHierarchy($userObj->UserId);

        Yii::app()->session['UserFollowingGroups'] = $userFollowingGroups;
        Yii::app()->session['TinyUserCollectionObj'] = $tinyUserCollectionObj;
        Yii::app()->session['UserPrivileges'] = $userPrivileges;
        Yii::app()->session['UserPrivilegeObject'] = CommonUtility::getUserPrivilege();
        Yii::app()->session['UserStaticData'] = $userObj;
        Yii::app()->session['IsAdmin'] = Yii::app()->session['UserStaticData']->UserTypeId;
        Yii::app()->session['UserHierarchy'] = $userHierarchy;
        Yii::app()->session['Email'] = $email;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:setUserSession::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function formStringTypeByIndex($type){
        try{
            $returnString = "";
            if($type == 6){
                $returnString = "";
                        }

            return $returnString;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:formStringTypeByIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    static function prepareSurveyAnalyticsAnyOtherValues($surveyId, $questionId,$startLimit,$pageLength){
        try{
            
            $totalArray = array();
            $userAnswers = ServiceFactory::getSkiptaExSurveyServiceInstance()->getUserOtherValues($surveyId, $questionId,$startLimit,$pageLength);
            foreach($userAnswers as $row){                
                $surveyAnyOtherValuesBean = new SurveyAnyOtherValuesBean();
                if(isset($row['AnyOtherComment']) && sizeof($row['AnyOtherComment']) > 0){
                    $tinyUserCollectionObj = ServiceFactory::getSkiptaUserServiceInstance()->getTinyUserCollection($row['UserId']);
                    $surveyAnyOtherValuesBean->ProfilePic = $tinyUserCollectionObj->profile70x70;                
                    $surveyAnyOtherValuesBean->Answers = $row['AnyOtherComment'];
                    $sessObj = Yii::app()->session['TinyUserCollectionObj'];
                    if($sessObj->UserId == $row['UserId']){
                        $surveyAnyOtherValuesBean->Title = "You";
                    }else{
                        $surveyAnyOtherValuesBean->Title = $tinyUserCollectionObj->DisplayName;
                    }
                    array_push($totalArray, $surveyAnyOtherValuesBean);
                }
            }            
            return $totalArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareSurveyAnalyticsAnyOtherValues::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }




       
      

    static function abusedComments($comments){
        try{
        $commentsArray = array();
        $commentCount = sizeof($comments);
        if ($commentCount > 0) {
            for ($j = $commentCount; $j > 0; $j--) {
                $comment = $comments[$j - 1];
                $comment["IsAbused"] = isset($comment["IsAbused"]) ? $comment["IsAbused"] : 0;
                if($comment["IsAbused"]==1){
                    $commentedUser = UserCollection::model()->getTinyUserCollection($comment["UserId"]);
                    $comment["CreatedOn"] = $comment["CreatedOn"];
                    $comment["CommentId"] = $comment["CommentId"];
                    $comment["CommentText"] = $comment["CommentText"];
                    $comment['ProfilePicture'] = $commentedUser['profile70x70'];
                    $commentCreatedOn = $comment["CreatedOn"];
                    $comment["CreatedOn"] = CommonUtility::styleDateTime($commentCreatedOn->sec);
                    $comment["DisplayName"] = $commentedUser['DisplayName'];
                    $image = "";
                    $filetype = "";
                    if (sizeof($comment["Artifacts"]) > 0) {
                        $filetype = $comment["Artifacts"][0]['Extension'];
                        if (isset($comment["Artifacts"][0]["ThumbNailImage"])) {
                            $image = $comment["Artifacts"][0]["ThumbNailImage"];
                        } else {
                            $image = "";
                        }
                    }
                    $comment["Extension"] = $filetype;
                    $comment["ArtifactIcon"] = $image;
                    array_push($commentsArray, $comment);
                }
            }
        }
        return $commentsArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:abusedComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    static function blockedComments($comments){
        try{
        $commentsArray = array();
        $commentCount = sizeof($comments);
        if ($commentCount > 0) {
            for ($j = $commentCount; $j > 0; $j--) {
                $comment = $comments[$j - 1];
                $comment["IsBlockedWordExist"] = isset($comment["IsBlockedWordExist"]) ? $comment["IsBlockedWordExist"] : 0;
                $commentedUser = UserCollection::model()->getTinyUserCollection($comment["UserId"]);
                $comment["CreatedOn"] = $comment["CreatedOn"];
                $comment["CommentId"] = $comment["CommentId"];
                if ($comment["IsBlockedWordExist"] == 1) {
                    $blockedWords = AbuseKeywords::model()->getAllAbuseWords();
                    if (is_array($blockedWords) && sizeof($blockedWords) > 0) {
                        $comment["CommentText"] = CommonUtility::FindElementAndReplace($comment["CommentText"], $blockedWords);
                    }
                } else {
                    $comment["CommentText"] = $comment["CommentText"];
                }
                $comment['ProfilePicture'] = $commentedUser['profile70x70'];
                $commentCreatedOn = $comment["CreatedOn"];
                $comment["CreatedOn"] = CommonUtility::styleDateTime($commentCreatedOn->sec);
                $comment["DisplayName"] = $commentedUser['DisplayName'];
                $image = "";
                $filetype = "";
                if (sizeof($comment["Artifacts"]) > 0) {
                    $filetype = $comment["Artifacts"][0]['Extension'];
                    if (isset($comment["Artifacts"][0]["ThumbNailImage"])) {
                        $image = $comment["Artifacts"][0]["ThumbNailImage"];
                    } else {
                        $image = "";
                    }
                }
                $comment["Extension"] = $filetype;
                $comment["ArtifactIcon"] = $image;
                array_push($commentsArray, $comment);
            }
        }
        return $commentsArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:blockedComments::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    
/**
 * Returns decrypted original string
 */
static function decryptString($encrypted_string) {
    try{
    $encryption_key="!@#$%^&*";
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
    } catch (Exception $ex) {
       Yii::log("CommonUtility:decryptString::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
}

    static function abusedPostConditions(){
        try{
        $orCondition = array();
        if (Yii::app()->session['IsAdmin'] == '1') {
            $orCondition = array(
                '$or' => [
                    array(
                        'IsAbused' => 1
                    ),
                    array(
                        'IsCommentAbused' => 1
                    )
                ]
            );
        } else if (Yii::app()->session['UserPrivilegeObject']->canManageFlaggedPost == '1') {

            $userHierarchy = Yii::app()->session['UserHierarchy'];
            if ($userHierarchy['Division'] != 0) {
                $division = $userHierarchy['Division'];
                $orCondition = array(
                    '$or' => [
                        array(
                            'Division' => (int) ($division),
                            'IsAbused' => 1
                        ),
                        array(
                            'IsCommentAbused' => 1
                        )
                    ]
                );
            }
            if ($userHierarchy['Region'] != 0) {
                $region = $userHierarchy['Region'];
                $orCondition = array(
                    '$or' => [
                        array(
                            'Region' => (int) ($region),
                            'IsAbused' => 1
                        ),
                        array(
                            'IsCommentAbused' => 1
                        )
                    ]
                );
            }
            if ($userHierarchy['District'] != 0) {
                $district = $userHierarchy['District'];
                $orCondition = array(
                    '$or' => [
                        array(
                            'District' => (int) ($district),
                            'IsAbused' => 1
                        ),
                        array(
                            'IsCommentAbused' => 1
                        )
                    ]
                );
            }

            if ($userHierarchy['Store'] != 0) {
                $store = $userHierarchy['Store'];
                $orCondition = array(
                    '$or' => [
                        array(
                            'Store' => (int) ($store),
                            'IsAbused' => 1
                        ),
                        array(
                            'IsCommentAbused' => 1
                        )
                    ]
                );
            }
            if ($userHierarchy['Division'] == 0) {
                $orCondition = array(
                    '$or' => [
                        array(
                            'Store' => 0,
                            'Division' => 0,
                            'District' => 0,
                            'Region' => 0,
                            'IsAbused' => 1
                        ),
                        array(
                            'IsCommentAbused' => 1
                        )
                    ]
                );
            }
        }
        return $orCondition;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:abusedPostConditions::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


    
    static function getSpotMessage($spotsCount,$totalSpots){
        try{
        $spotMessage = "";
          if ($spotsCount == 0) {
           // $spotMessage = "There are no more spots left to take this survey";
            $spotMessage = Yii::t("translation","MarketSurvey_NoMoreSpots");
        } else if ($spotsCount == 1) {
            $spotMessage = "There is " . $spotsCount . " spot left to take this survey act now";
            $spotMessage = Yii::t("translation","MarketSurvey_MoreSpot");
            $spotMessage = str_replace("FILLREMAININGHERE", $spotsCount, $spotMessage);
            $spotMessage = str_replace("FILLTOTALHERE", $totalSpots, $spotMessage);
        } else {
            $spotMessage = "There are " . $spotsCount . " spots left to take this survey act now";
            $spotMessage = Yii::t("translation","MarketSurvey_MoreSpot");
            $spotMessage = str_replace("FILLREMAININGHERE", $spotsCount, $spotMessage);
            $spotMessage = str_replace("FILLTOTALHERE", $totalSpots, $spotMessage);
        }
        return $spotMessage;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getSpotMessage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    
    static function getGroupAccessibleUserStatusByGroupId($groupId,$lemail=""){
        try{
            return ServiceFactory::getSkiptaGroupServiceInstance()->getGroupAccessibleUserStatusByGroupId($groupId,$lemail);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getGroupAccessibleUserStatusByGroupId::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->getGroupAccessibleUserStatusByGroupId==".$ex->getMessage());
        }
    }
    static function downloadAfile($file,$folder){
        try{
            $webroot = Yii::app()->params['WebrootPath'];
            $file = $webroot.$folder.$file;
            if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }

        } catch (Exception $ex) {
            Yii::log("CommonUtility:downloadAfile::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->downloadAfile==".$ex->getMessage());
        }
    }
    
   public static   function getUserSaveItForLaterStream($userId,$condition,$type)
    {
         try {

          
           if($type=='stream')
               $condition=array('notIn'=>$condition);
           else if($type=='curbside')
               $condition=array('In'=>$condition);
        
            $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                'pagination' => array('pageSize' => 10),
                'criteria' => array(
                    'conditions' => array(
                       // "saveItForLaterUserIds" => array('In'=>array($userId)),
                        'UserId' => array('==' => $userId),
                        'CategoryType' => $condition,
                        'IsDeleted' => array('!=' => 1),
                        'IsAbused' => array('notIn' => array(1, 2)),
                         'IsSaveItForLater'=>array('==' => 1),
                    ),
                    
                    
                    'sort' => array('IsSaveItForLater' => EMongoCriteria::SORT_DESC),
                )
            ));

            $dataArray = $provider->getData();

            return $dataArray;
        } catch (Exception $ex) {
           Yii::log("CommonUtility:getUserSaveItForLaterStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
     public static function getUserSaveItForLaterNewsStream($userId)
    {
         try {

              $pageSize = 10;
                $mongoCriteria = new EMongoCriteria;
                
            $orCondition=array(
                   
               'CategoryType' =>array('==' => 8) ,
                 'UserId' => array('==' => $userId),
                'Released' =>array('==' => 1),
                'saveItForLaterUserIds' => array('In'=>array($userId)),
                 'IsSaveItForLater'=>array('==' => 1),
               //  'CategoryType' =>array('In' => array(0,$userId)) , 
                 'IsDeleted' =>array('==' => 0),
                'IsAbused' =>array('==' => 0),
                                );
                       
               

               
              
             
               $provider = new EMongoDocumentDataProvider('StreamPostDisplayBean', array(
                   'pagination' => array('pageSize' => $pageSize),
                   'criteria' => array(
                    'conditions' => $orCondition,
                    'sort' => array('IsSaveItForLater' => EMongoCriteria::SORT_DESC)
                )
               ));

            $dataArray = $provider->getData();
            return $dataArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getUserSaveItForLaterNewsStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    static function prepateSurveyTakenUsersInfoData($surveyId, $scheduleId) {
        try {

            $surveyTakenUsersInfo = UserTaxAndRegulatoryInfo::model()->getSurveyTakenUsersInfoData($surveyId, $scheduleId);
            $scheduleObject = ScheduleSurveyCollection::model()->getScheduleSurveyDetailsObject("Id", $scheduleId);



            if ($surveyTakenUsersInfo == "failure") {
                $surveyTakenUsersInfo = array();
            }
            $surveyUsers = array();
            foreach ($surveyTakenUsersInfo as $key => $value) {
                $pagesAnalyticsData = SurveyInteractionCollection::model()->getSurveyPageAnalyticsbyUserId($scheduleId, $surveyId, $value['UserId']);
                if (isset($pagesAnalyticsData[0]['SurveyTimeSpent_Sum'])) {
                    $timeSpentString = gmdate("H:i:s", $pagesAnalyticsData[0]['SurveyTimeSpent_Sum']);
                }
                $surveyTakenUsersInfo[$key]['SurveyTimeSpent'] = (String) $timeSpentString;
                $surveyTakenUsersInfo[$key]['UserStatus'] = "Completed";
            }

            if (sizeof($scheduleObject->SurveyTakenUsers) == sizeof($surveyTakenUsersInfo)) {

                $resultArray = array("surveyTakenUsersInfo" => $surveyTakenUsersInfo, "scheduleObject" => $scheduleObject);
            } else {

                $surveyTakenUserIds = array();
                $surveyTakenUserIds = UserTaxAndRegulatoryInfo::model()->getSurveyTakenUserIds($surveyId, $scheduleId);
                $uniqueUserIds = array();
                $uniqueUserIds = array_values(array_diff($scheduleObject->SurveyTakenUsers, $surveyTakenUserIds));
                $surveyUsers = User::model()->getDetailsByUserIds($uniqueUserIds);
                $resultantArr = array();

               if(is_array($surveyUsers)&& sizeof($surveyUsers)>0){
                foreach ($surveyUsers as $key => $value) {
                    $pagesAnalyticsData = SurveyInteractionCollection::model()->getSurveyPageAnalyticsbyUserId($scheduleId, $surveyId, $value['UserId']);
                    $timeSpentString = "";
                    if (isset($pagesAnalyticsData[0]['SurveyTimeSpent_Sum'])) {
                        $timeSpentString = gmdate("H:i:s", $pagesAnalyticsData[0]['SurveyTimeSpent_Sum']);
                    }
                    $surveyUsers[$key]['SurveyTimeSpent'] = $timeSpentString;
                    $surveyUsers[$key]['UserStatus'] = "Completed - Not Filled Tax Form";
                }
            }
            }
            $resumeUsers = array();
            if (is_array($scheduleObject->ResumeUsers) && sizeof($scheduleObject->ResumeUsers) > 0) {

                $resumeUsers = User::model()->getDetailsByUserIds($scheduleObject->ResumeUsers);


                foreach ($resumeUsers as $key => $value) {
                    $pagesAnalyticsData = SurveyInteractionCollection::model()->getSurveyPageAnalyticsbyUserId($scheduleId, $surveyId, $value['UserId']);
                    $timeSpentString = "";
                    if (isset($pagesAnalyticsData[0]['SurveyTimeSpent_Sum'])) {
                        $timeSpentString = gmdate("H:i:s", $pagesAnalyticsData[0]['SurveyTimeSpent_Sum']);
                    }
                    $resumeUsers[$key]['SurveyTimeSpent'] = $timeSpentString;
                    $resumeUsers[$key]['UserStatus'] = "Abandoned";
                }
            }

            $resultantArr = array_merge($surveyTakenUsersInfo, $surveyUsers, $resumeUsers);

            $resultArray = array("surveyTakenUsersInfo" => $resultantArr, "scheduleObject" => $scheduleObject);




            return $resultArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepateSurveyTakenUsersInfoData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepateSurveyTakenUsersInfoData==".$ex->getMessage());
        }
    }

    static function getAnswerForQuestion($questionId,$bufferAnswers){
        try{
        $finalAnswer = array();
        foreach ($bufferAnswers as $answer) {
            if($questionId == $answer["QuestionId"]){
                $finalAnswer = $answer;
                break;
            }

        }
        return $finalAnswer;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getAnswerForQuestion::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
   static function updateCommentsForSuspendedUser($userId,$db,$collectionName)    {  
       try{
//        $collection = $db->selectCollection('system.js');
//
////$proccode = 'function updateSubDocumentForSuspendedUsers(userId,collectionName) {var collectionObj=db.getCollection(collectionName);
////    collectionObj.find({"Comments" :{$elemMatch:{"UserId":userId,"IsAbused":NumberInt(0)}}}).forEach( function(article) {for(var i in article.Comments){
////    article.Comments[i].IsAbused=NumberInt(3)}
////       collectionObj.save(article);}); return "success"}';
////
////$collection->save(
////               array(
////                   '_id'   => 'updateSubDocumentForSuspendedUsers',
////                   'value' => new MongoCode($proccode),
////));
        $toexec = 'function(userId,collectionName) { return updateSubDocumentForSuspendedUsers(userId,collectionName) }';
         $args=array($userId,$collectionName);
         $response=$db->execute($toexec, $args);
      } catch (Exception $ex) {
            Yii::log("CommonUtility:updateCommentsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }  
       
    }
    
    static function releaseCommentsForSuspendedUser($userId,$db,$collectionName)    {  
        try{
//        $collection = $db->selectCollection('system.js');
//
//$proccode = 'function releaseSubDocumentForSuspendedUsers(userId,
//  collectionName) {
//    var collectionObj=db.getCollection(collectionName);
//    collectionObj.find({
//      "Comments" : { $elemMatch:{"UserId":NumberInt(userId),
//"IsAbused":NumberInt(3)
//        }}
//    }).forEach( function(article) {
//      for(var i in article.Comments){
//        if(article.Comments[i        
//        ].UserId==NumberInt(userId)){
//    article.Comments[i         
//          ].IsAbused=NumberInt(0)}
//       collectionObj.save(article);} 
//    
//    }); return "success"
//  }
//';
//$collection->save(
//               array(
//                   '_id'   => 'releaseSubDocumentForSuspendedUsers',
//                   'value' => new MongoCode($proccode),
//));
        $toexec = 'function(userId,collectionName) { return releaseSubDocumentForSuspendedUsers(userId,collectionName) }';
         $args=array($userId,$collectionName);
         $response=$db->execute($toexec, $args);
         
      } catch (Exception $ex) {
            Yii::log("CommonUtility:releaseCommentsForSuspendedUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        } 
    }
    
    static function trackSurvey($userId, $scheduleId, $surveyId, $page, $type) {
      try{
          
          if ($type == "next") {
                //perform next action
                $currentPage = $page;
                $previousPage = $page - 1;
            } else {
                $currentPage = $page;
                $previousPage = $page + 1;
            }

           SurveyInteractionCollection::model()->trackSurveyLogout("", $userId, $scheduleId, $surveyId, $previousPage, $type);
            SurveyInteractionCollection::model()->saveSurveyLogin($userId, $scheduleId, $surveyId, $currentPage);
//          SurveyInteractionCollection::model()->saveSurveyLogin($userId, $scheduleId, $surveyId, $currentPage);
//           if ($type == "refresh") {
//            $latestRecord = SurveyInteractionCollection::model()->getTrackRecord($userId, $scheduleId, $surveyId, $page, "LatestOne");
//            if ($latestRecord == "norecord") {
//                SurveyInteractionCollection::model()->saveSurveyLogin($userId, $scheduleId, $surveyId, $page);
//            } else {
//                if ($latestRecord->ActionType == "SurveyLogin") {
//                    SurveyInteractionCollection::model()->trackSurveyLogout($latestRecord, $userId, $scheduleId, $surveyId, $page, $type);
//                } else {
//
//                    SurveyInteractionCollection::model()->saveSurveyLogin($userId, $scheduleId, $surveyId, $page);
//                }
//            }
//        } else {
//            if ($type == "next") {
//                //perform next action
//                $currentPage = $page;
//                $previousPage = $page - 1;
//            } else {
//                $currentPage = $page;
//                $previousPage = $page + 1;
//            }
//
//           SurveyInteractionCollection::model()->trackSurveyLogout("", $userId, $scheduleId, $surveyId, $previousPage, $type);
//            SurveyInteractionCollection::model()->saveSurveyLogin($userId, $scheduleId, $surveyId, $currentPage);
//        }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:trackSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
       
    }

/**
 * @develoepr sureresh redy #1500
 * @usage change display language based on  lang, soucelnag
 * @param type $language
 * @param type $souceLang
 * @return string
 * 
 */
     static function changeLanguage($language,$souceLang="") {
        try {
          Yii::app()->session['language'] = $language;
          //Yii::app()->session['sourceLanguage'] =$souceLang;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:changeLanguage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->changeLanguage==".$ex->getMessage());
        }
        return '';
    }

    
    /**
 * @develoepr sureresh redy #1500
 * @usage change display language based on  lang, soucelnag
 * @param type $language
 * @param type $souceLang
 * @return string
 * 
 */
     static function changeLanguagefromCommand($language,$souceLang="") {
        try {
             Yii::app()->language =$language;
            //Yii::app()->sourceLanguage = $souceLang;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:changeLanguagefromCommand::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->changeLanguagefromCommand==".$ex->getMessage());
        }
        return '';
    }
        static function setLanguagefromConfig($tinyOriginalUser) {
        try {
       $attributeArray = array("Language" => $tinyOriginalUser->Language);
        $languageObj = ServiceFactory::getSkiptaUserServiceInstance()->getLanguageByAttributes($attributeArray);
        if (is_array($languageObj) || is_object($languageObj)) {
            CommonUtility::changeLanguagefromCommand($tinyOriginalUser->Language, $languageObj["SourceLanguage"]);
        }
           } catch (Exception $ex) {
            Yii::log("CommonUtility:setLanguagefromConfig::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->setLanguagefromConfig==".$ex->getMessage());
        }
        return '';
    }
    static function translateData($data, $fromLang="en", $toLang="ru") {
        try {
              if(isset(Yii::app()->params['IsMultipleSegment'])&&Yii::app()->params['IsMultipleSegment']==1){
            $apiKey = "trnsl.1.1.20141125T052501Z.f9dbf520442f61e0.9ccf1dc70f5cf19dc2a308a6247acc47e50b1555";
            $url = "https://translate.yandex.net/api/v1.5/tr.json/translate";
            $postdata = http_build_query(
                    array(
                        'key' => $apiKey,
                        'lang' => "$fromLang-$toLang",
                        'text' => $data
                    )
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            $context = stream_context_create($opts);
            $details = file_get_contents($url, false, $context);
            $decode = CJSON::decode($details);
            return $decode['text'][0];
              }else{
                return $data;  
              }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:translateData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->translateData==".$ex->getMessage());
        }
    }
    
      static function detectLanugage($data) {
        try {
            if(isset(Yii::app()->params['IsMultipleSegment'])&&Yii::app()->params['IsMultipleSegment']==1){
            $apiKey = "trnsl.1.1.20141125T052501Z.f9dbf520442f61e0.9ccf1dc70f5cf19dc2a308a6247acc47e50b1555";
            $url = "https://translate.yandex.net/api/v1.5/tr.json/detect";
            $postdata = http_build_query(
                    array(
                        'key' => $apiKey,
                        'text' => $data,
                        'format'=>'html'
                    )
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            $context = stream_context_create($opts);
            $details = file_get_contents($url, false, $context);
            $decode = CJSON::decode($details);
            return $decode['lang'];
            }
            return 'en';
        } catch (Exception $ex) {
            Yii::log("CommonUtility:detectLanugage::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->detectLanugage==".$ex->getMessage());
        }
    }

        static function getStreamNoteMessages($streamNote ,$toLang) {
        try {
            $text = $streamNote;
            $fromLanguage = "en";
            $toLanguage = $toLang;
            $translatedText="";
      
                $translatedText = ServiceFactory::getSkiptaTranslatedDataService()->isStreamNoteTranslated($text, $toLanguage);
                if($translatedText=="false"){
                    $translatedText = CommonUtility::translateData($text, $fromLanguage, $toLanguage);
                    ServiceFactory::getSkiptaTranslatedDataService()->saveStreamNoteTranslatedData($text, $fromLanguage, $toLanguage, $translatedText);
                }
            
        //    $obj = array("html"=>$translatedText);


            return $translatedText;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getStreamNoteMessages::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->getStreamNoteMessages==".$ex->getMessage());
        }
        return $translatedText;
    }
    
        /**
     * @author Sagar pathepalli 
     * @param type $streamPostData
     * @return array
     * 
     */
     static function preparePostDetailObject($data) {

        try {
            $streamIdArray = array();
             $zeroRecordArray=array();
             $oneRecordArray=array();
             $currentStreamIdArray = array();
             $totalStreamIdArray = array();
       
              $PostOn=$createdOn;
    
    
           // $PostOn = CommonUtility::styleDateTime($createdOn->sec);
          $UserId = isset($UserId)?$UserId:$this->tinyObject->UserId;
          $PostTypeString = CommonUtility::postTypebyIndex($data->Type);
          $actionText = CommonUtility::actionTextbyActionType($data->Type);
          if($categoryType == 3){
          $PostTypeString = "Group $PostTypeString";
          }
          if($categoryType == 10){
          $actionText = "unlocked";
          }
          $ShareCount = 0;
          $FbShareCount = isset($data->FbShare) && is_array($data->FbShare)?sizeof($data->FbShare):0;
          $TwitterShareCount = isset($data->TwitterShare) && is_array($data->TwitterShare)?sizeof($data->TwitterShare):0;
          $ShareCount = $FbShareCount+$TwitterShareCount;
          
          

             
             
            //if($isHomeStream == 1){
                                        
                return $object;
//            }else{
//                return $streamPostData;
//            }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:preparePostDetailObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->preparePostDetailObject==".$ex->getMessage());
        }
    }

        
    public static function translatedPostDetailObject($object, $tinyUserProfileObject) {
        try{
        $postLanguage = $object->Language;
        $userLanguage = $tinyUserProfileObject->Language;
        if ($postLanguage != $userLanguage) {
            $fromLanguage = $postLanguage;
            $toLanguage = $userLanguage;
            $object->Language = $toLanguage;
            $translatedBean = new TranslatedDataBean();
            $translatedBean->PostId = $object->PostId;
            $translatedBean->PostType = $object->PostType;
            $translatedBean->CategoryType = $object->CategoryType;
            $translatedBean->Language = $toLanguage;
            $postType = $object->PostType;
            $translatedObj = ServiceFactory::getSkiptaTranslatedDataService()->isTranslated($translatedBean);
            if (!(isset($translatedObj["PostText"]))) {
                $translatedText = CommonUtility::translateData($object->Description, $fromLanguage, $toLanguage);
                $object->Description = $translatedBean->PostText = $translatedText;
                if ($postType == 3) {
                    $object->Title = $translatedBean->Title = CommonUtility::translateData($object->Title, $fromLanguage, $toLanguage);
                    $object->OptionOne = $translatedBean->OptionOne = CommonUtility::translateData($object->OptionOne, $fromLanguage, $toLanguage);
                    $object->OptionTwo = $translatedBean->OptionTwo = CommonUtility::translateData($object->OptionTwo, $fromLanguage, $toLanguage);
                    $object->OptionThree = $translatedBean->OptionThree = CommonUtility::translateData($object->OptionThree, $fromLanguage, $toLanguage);
                    $object->OptionFour = $translatedBean->OptionFour = CommonUtility::translateData($object->OptionFour, $fromLanguage, $toLanguage);
                } else if ($postType == 2) {
                    $object->Title = $translatedBean->Title = CommonUtility::translateData($object->Title, $fromLanguage, $toLanguage);
                    ;
                    $object->Location = $translatedBean->Location = CommonUtility::translateData($object->Location, $fromLanguage, $toLanguage);
                    ;
                }
                ServiceFactory::getSkiptaTranslatedDataService()->saveTranslatedData($translatedBean);
            } else {
                $object->Description = $translatedObj["PostText"];
                if ($postType == 3) {
                    $object->Title = $translatedObj["Title"];
                    $object->OptionOne = $translatedObj["OptionOne"];
                    $object->OptionTwo = $translatedObj["OptionTwo"];
                    $object->OptionThree = $translatedObj["OptionThree"];
                    $object->OptionFour = $translatedObj["OptionFour"];
                } else if ($postType == 2) {
                    $object->Title = $translatedObj["Title"];
                    $object->Location = $translatedObj["Location"];
                }
            }
        }
        return $object;
        }catch(Exception $ex){
           Yii::log("CommonUtility:translatedPostDetailObject::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
           error_log("Exception Occurred in CommonUtility->translatedPostDetailObject==".$ex->getMessage());
        }
    }
    /***********Methods for Notification string preperation*******Start**********/
    public static function notificationStringForLove($who, $action, $postType, $actionedUserCount, $isAnonymous=0, $isMine=0, $whose=""){
        try{
            $message = "";
            $arr = array("{who}"=>$who,"{action}"=>$action, "{postType}"=>$postType,"{whose}"=>$whose);
            if($isMine==1){
                if($actionedUserCount<=2){
                    $message = Yii::t('notifications',"{who} {action} your {postType}", $arr); 
                }else{
                    $message = Yii::t('notifications',"{who} and other {action} your {postType}", $arr);
                }
            }else{
                if($isAnonymous==1){
                    if($actionedUserCount<=2){
                        $message = Yii::t('notifications',"{who} {action} anonymous {postType}", $arr); 
                    }else{
                        $message = Yii::t('notifications',"{who} and other {action} anonymous {postType}", $arr);
                    }
                }else{
                    if($actionedUserCount<=2){
                        $message = Yii::t('notifications',"{who} {action} {whose}'s {postType}", $arr); 
                    }else{
                        $message = Yii::t('notifications',"{who} and other {action} {whose}'s {postType}", $arr);
                    }
                }
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:notificationStringForLove::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->notificationStringForLove==".$ex->getMessage());
        }
    }
    public static function notificationStringForComment($who, $action, $postType, $actionedUserCount, $isAnonymous=0, $isMine=0, $whose="", $hashtag=""){
        try{
            $message = "";
            if($hashtag!=""){
                $arr = array("{who}"=>$who,"{hashtag}"=>$hashtag, "{postType}"=>$postType);
                $message = Yii::t('notifications',"{who} made a {postType} using a {hashtag} that you are following", $arr); 
            }else{
                $arr = array("{who}"=>$who,"{action}"=>$action, "{postType}"=>$postType,"{whose}"=>$whose);
                if($isMine==1){
                    if($actionedUserCount<=2){
                        $message = Yii::t('notifications',"{who} {action} on your {postType}", $arr); 
                    }else{
                        $message = Yii::t('notifications',"{who} and other {action} on your {postType}", $arr);
                    }
                }else{
                    if($isAnonymous==1){
                        $arr = array("{who}"=>$who,"{action}"=>$action, "{postType}"=>$postType);
                        if($actionedUserCount<=2){
                            $message = Yii::t('notifications',"{who} {action} on anonymous {postType}", $arr); 
                        }else{
                            $message = Yii::t('notifications',"{who} and other {action} on anonymous {postType}", $arr);
                        }
                    }else{
                        if($actionedUserCount<=2){
                            $message = Yii::t('notifications',"{who} {action} on {whose}'s {postType}", $arr); 
                        }else{
                            $message = Yii::t('notifications',"{who} and other {action} on {whose}'s {postType}", $arr);
                        }
                    }
                }
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:notificationStringForComment::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->notificationStringForComment==".$ex->getMessage());
        }
    }
    public static function notificationStringForFollow($who, $action, $postType, $actionedUserCount, $isAnonymous=0, $isMine=0, $whose=""){
        try{
            $message = "";
            $arr = array("{who}"=>$who,"{action}"=>$action, "{postType}"=>$postType,"{whose}"=>$whose);
            if($isMine==1){
                if($actionedUserCount<2){
                    $message = Yii::t('notifications',"{who} is {action} your {postType}", $arr); 
                }else if($actionedUserCount==2){
                    $message = Yii::t('notifications',"{who} are {action} your {postType}", $arr); 
                }else{
                    $message = Yii::t('notifications',"{who} and other are {action} your {postType}", $arr);
                }
            }else{
                if($isAnonymous==1){
                    if($actionedUserCount<2){
                        $message = Yii::t('notifications',"{who} is {action} anonymous {postType}", $arr); 
                    }else if($actionedUserCount==2){
                        $message = Yii::t('notifications',"{who} are {action} anonymous {postType}", $arr); 
                    }else{
                        $message = Yii::t('notifications',"{who} and other are {action} anonymous {postType}", $arr);
                    }
                }else{
                    if($actionedUserCount<2){
                        $message = Yii::t('notifications',"{who} is {action} {whose}'s {postType}", $arr); 
                    }else if($actionedUserCount==2){
                        $message = Yii::t('notifications',"{who} are {action} {whose}'s {postType}", $arr); 
                    }else{
                        $message = Yii::t('notifications',"{who} and other are {action} {whose}'s {postType}", $arr);
                    }
                }
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:notificationStringForFollow::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->notificationStringForFollow==".$ex->getMessage());
        }
    }
    public static function notificationStringForInvite($who, $action, $postType, $postTypeId){
        try{
            $message = "";
            $arr = array("{who}"=>$who,"{action}"=>$action, "{postType}"=>$postType);
            if($postTypeId==2){
                $message = Yii::t('notifications',"{who} is {action} you to an {postType}", $arr);
            }else{
                $message = Yii::t('notifications',"{who} is {action} you to a {postType}", $arr);
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:notificationStringForInvite::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->notificationStringForInvite==".$ex->getMessage());
        }
    }
    public static function notificationStringForMention($who, $action, $postType, $postTypeId){
        try{
            $message = "";
            $arr = array("{who}"=>$who,"{action}"=>$action, "{postType}"=>$postType);
            if($postTypeId==2){
                $message = Yii::t('notifications',"{who} {action} you on an {postType}", $arr); 
            }else{
                $message = Yii::t('notifications',"{who} {action} you on a {postType}", $arr); 
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:notificationStringForMention::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->notificationStringForMention==".$ex->getMessage());
        }
    }
    public static function notificationStringForUserFollow($who, $action, $actionedUserCount){
        try{
            $message = "";
            $arr = array("{who}"=>$who,"{action}"=>$action);
            if($actionedUserCount<2){
                $message = Yii::t('notifications',"{who} is {action} you", $arr); 
            }else if($actionedUserCount==2){
                $message = Yii::t('notifications',"{who} are {action} you", $arr); 
            }else{
                $message = Yii::t('notifications',"{who} and other are {action} you", $arr);
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:notificationStringForUserFollow::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->notificationStringForUserFollow==".$ex->getMessage());
        }
    }
    public static function notificationStringForPost($who, $postType, $hashtag="", $curbsideCategory=""){
        try{
            $message = "";
            $arr = array("{who}"=>$who, "{postType}"=>$postType,"{hashtag}"=>$hashtag,"{curbsideCategory}"=>$curbsideCategory);
            if($curbsideCategory==""){
                $message = Yii::t('notifications',"{who} made a {postType} using a {hashtag} that you are following", $arr);
            }else if($hashtag==""){
                $message = Yii::t('notifications',"{who} posted a curbside consult using a {curbsideCategory} that you are following", $arr);
            }else{
                $message = Yii::t('notifications',"{who} posted a curbside consult using a {curbsideCategory} and a {hashtag} that you are following", $arr);
            }
            
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:notificationStringForPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->notificationStringForPost==".$ex->getMessage());
        }
    }
    /***********Methods for Notification string preperation********End*********/
    static function getTranslatedPostTypebyIndex($type, $isGroupCategory = 0) {
        try {

            $returnValue = 0;
             if ($type == 9) {
                $returnValue = Yii::t('posttypes', 'Group');
            } else if ($type == 10) {
                $returnValue = Yii::t('posttypes', 'SubGroup');
            }
           else if ($isGroupCategory == 3) {
                if ($type == 1) {
                    $returnValue = Yii::t('posttypes', 'GroupPost');
                } else if ($type == 2) {
                    $returnValue = Yii::t('posttypes', 'GroupEvent');
                } else if ($type == 3) {
                    $returnValue = Yii::t('posttypes', 'GroupSurvey');
                }
            } else if ($isGroupCategory == 7) {
                if ($type == 1) {
                    $returnValue = Yii::t('posttypes', 'SubGroupPost');
                } else if ($type == 2) {
                    $returnValue = Yii::t('posttypes', 'SubGroupEvent');
                } else if ($type == 3) {
                    $returnValue = Yii::t('posttypes', 'SubGroupSurvey');
                }
            } else if ($type == 1) {
                $returnValue = Yii::t('posttypes', 'Post');
            } else if ($type == 2) {
                $returnValue = Yii::t('posttypes', 'Event');
            } else if ($type == 3) {
                $returnValue = Yii::t('posttypes', 'Survey');
            } else if ($type == 4) {
                // Anonymous Post
                $returnValue = Yii::t('posttypes', 'Post');
            } else if ($type == 11) {
                $returnValue = Yii::t('posttypes', 'News');
            } 
             else if ($type == 7) {
                $returnValue = Yii::t('posttypes', 'Hash Tag');
            }
            else if ($type == 5) {
                $returnValue = Yii::t('posttypes', 'CurbsideConsult');
            } 
            
            else if ($type == 12) {
                $returnValue = Yii::t('posttypes', 'Game');
            } else if ($type == 13) {
                $returnValue = Yii::t('posttypes', 'Badge');
            } else if ($type == 14) {
                $returnValue = Yii::t('posttypes', 'Network');
            } else if ($type == 16) {
                $returnValue = Yii::t('posttypes', 'Advertisement');
            } else if ($type == 15) {
                $returnValue = Yii::t('posttypes', 'CV');
            }
             else if ($type == 8) {
                $returnValue = Yii::t('posttypes', 'Curbside Category');
            }
             else if ($type == 19) {
                $returnValue = Yii::t('posttypes', 'Market Research');
            }
           
            return $returnValue;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getTranslatedPostTypebyIndex::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
    /***
     * This method should be called for the events which are created in stream, bt not for groups and subgroups
     */
    public static function streamNoteForNormalEventPost($recentActivity, $postType, $isMine=0, $invitedUsers="", $isInvited="", $isInteractions=0){
        try{
            $message = "";
            $arr = array("{postType}"=>$postType);
            if($recentActivity=="Post"){
                $message = Yii::t('streamnotes',"created an {postType}", $arr);
            }else if($recentActivity=="Comment"){
                $message = Yii::t('streamnotes',"commented on an {postType}", $arr);
            }else if($recentActivity=="UserMention"){
                $message = Yii::t('streamnotes',"mentioned you in an {postType}", $arr);
            }else if($recentActivity=="Invite"){
                $arr = array("{postType}"=>$postType,"{invitedUsers}"=>$invitedUsers);
                if(!$isInteractions){
                    $message = Yii::t('streamnotes',"has been invited you to a {postType}", $arr);
                }else if($isInvited){
                    if($isMine){
                        $message = Yii::t('streamnotes',"have been invited to an {postType}", $arr);
                    }else{
                        $message = Yii::t('streamnotes',"has been invited to an {postType}", $arr);
                    }
                }else{
                    if($isMine){
                        $message = Yii::t('streamnotes',"have invited {invitedUsers} to an {postType}", $arr);
                    }else{
                        $message = Yii::t('streamnotes',"has invited {invitedUsers} to an {postType}", $arr);
                    }
                }
            }else if($recentActivity=="EventAttend"){
                $attending = "attending";
                if($isMine){
                    $message = Yii::t('streamnotes',"are attending an {postType}", $arr);
                }else{
                    $message = Yii::t('streamnotes',"is attending an {postType}", $arr);
                }
            }else if($recentActivity=="Follow"){
                $attending = "following";
                if($isMine){
                    $message = Yii::t('streamnotes',"are following an {postType}", $arr);
                }else{
                    $message = Yii::t('streamnotes',"is following an {postType}", $arr);
                }
            }
              else if($recentActivity=="Love"  ){
                 
                  if($isMine){
                        $message = Yii::t('streamnotes',"loved an {postType}", $arr);
                    }else{
                         $message = Yii::t('streamnotes',"loved an {postType}", $arr);
                    }
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:streamNoteForNormalEventPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->streamNoteForNormalEventPost==".$ex->getMessage());
        }
    }
    public static function streamNoteForGames($recentActivity, $postType){
        try{
            $message = "";
            $arr = array("{postType}"=>$postType);
            if($recentActivity=="GameSchedule" || $recentActivity=="Post"){
                $message = Yii::t('streamnotes',"scheduled a {postType}", $arr);
            }else{
                $message = Yii::t('streamnotes',"have Played a {postType}", $arr);
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:streamNoteForGames::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->streamNoteForGames==".$ex->getMessage());
        }
    }
    public static function streamNoteForBadges($recentActivity, $badgeName){
        try{
            $message = "";
            $arr = array("{badgeName}"=>$badgeName);
            if($recentActivity=="Comment"){
                $message = Yii::t('streamnotes',"commented on {badgeName}", $arr);
            }else{
                $message = Yii::t('streamnotes',"unlocked {badgeName}", $arr);
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:streamNoteForBadges::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->streamNoteForBadges==".$ex->getMessage());
        }
    }
    public static function streamNoteForCV($recentActivity, $postType, $cvType, $isMine=""){
        try{
            $message = "";
            $arr = array("{type}"=>$cvType);
            if($recentActivity=="Post"){
                if($isMine){
                    $message = Yii::t('streamnotes',"have updated your {type} in CV", $arr);
                }else{
                    $message = Yii::t('streamnotes',"updated their {type} in CV", $arr);
                }
            }else if($recentActivity=="Comment"){
                if($isMine){
                    $message = Yii::t('streamnotes',"have commented on {type} in CV", $arr);
                }else{
                    $message = Yii::t('streamnotes',"commented on {type} in CV", $arr);
                }
            }else if($recentActivity=="Invite"){
                $message = Yii::t('streamnotes',"has been invited you to their {type} in CV", $arr);
            }else if($recentActivity=="Love"){
                if($isMine){
                    $message = Yii::t('streamnotes',"loved on {type} in CV", $arr);
                }else{
                    $message = Yii::t('streamnotes',"loved on {type} in CV", $arr);
                }
            }else if($recentActivity=="Invite"){
                if($isMine){
                    $message = Yii::t('streamnotes',"are following on your {type} in CV", $arr);
                }else{
                    $message = Yii::t('streamnotes',"is following on their {type} in CV", $arr);
                }
            }
            
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:streamNoteForCV::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->streamNoteForCV==".$ex->getMessage());
        }
    }
    public static function prepareStreamNotes($postTypeId, $categoryType, $recentActivity, $postType, $isAnonymous=0, $isMine=0, $invitedUsers="", $isInvited=0, $isInteractions=0){
        try{
            $message = "";
            $arr = array("{postType}"=>$postType);
            if($isAnonymous && $recentActivity=="Post"){//Anonymous Post
                $message = Yii::t('streamnotes',"A new {postType} has been created", $arr);
            }else if($postTypeId==1 && $recentActivity=="Post"){//Stream Normal Post
                $message = $message = Yii::t('streamnotes',"made a {postType}", $arr);
            }else if($categoryType==1 && $postTypeId==2){//Stream Event
                $message = CommonUtility::streamNoteForNormalEventPost($recentActivity, $postType, $isMine, $invitedUsers, $isInvited, $isInteractions);
            }else if($recentActivity=="Survey"){
                if($isMine){
                    $message = Yii::t('streamnotes',"have answered a Survey", $arr);
                }else{
                    $message = Yii::t('streamnotes',"has answered a Survey", $arr);
                }
            }else if($recentActivity=="Comment"){
                $message = Yii::t('streamnotes',"commented on a {postType}", $arr);
            }else if($recentActivity=="UserMention"){
                $message = Yii::t('streamnotes',"mentioned you in a {postType}", $arr);
            }else if($recentActivity=="ExtendedSurveyFinished"){
                $message = Yii::t('streamnotes',"has answered a Market Research Survey", $arr);
            }
            else if($recentActivity=="Invite"){
                $arr = array("{postType}"=>$postType,"{invitedUsers}"=>$invitedUsers);
                if(!$isInteractions){
                    $message = Yii::t('streamnotes',"has been invited you to a {postType}", $arr);
                }else if($isInvited){
                    if($isMine){
                        $message = Yii::t('streamnotes',"have been invited to a {postType}", $arr);
                    }else{
                        $message = Yii::t('streamnotes',"has been invited to a {postType}", $arr);
                    }
                }else{
                    if($isMine){
                        $message = Yii::t('streamnotes',"have invited {invitedUsers} to a {postType}", $arr);
                    }else{
                        $message = Yii::t('streamnotes',"has invited {invitedUsers} to a {postType}", $arr);
                    }
                }
            }
            else if($recentActivity=="SubGroupFollow"  || $recentActivity=="GroupFollow" || $recentActivity=="HashTagFollow" ||$recentActivity=="CurbsideCategoryFollow" || $recentActivity=="PostFollow" ||$recentActivity=="Follow" ){
                 
                  if($isMine){
                        $message = Yii::t('streamnotes',"are following a {postType}", $arr);
                    }else{
                         $message = Yii::t('streamnotes',"is following a {postType}", $arr);
                    }
            }
              
            else if($recentActivity=="Love"  ){
                 
                  if($isMine){
                        $message = Yii::t('streamnotes',"loved a {postType}", $arr);
                    }else{
                         $message = Yii::t('streamnotes',"loved a {postType}", $arr);
                    }
            }
            
            else{
                $message = Yii::t('streamnotes',"posted a {postType}", $arr);
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:prepareStreamNotes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareStreamNotes==".$ex->getMessage());
        }
    }
    
    public static function getStreamNote($categoryType, $postTypeId, $recentActivity, $isAnonymous, $isMine=0, $badgeName = "", $cvType="", $invitedUsers="", $isInvited=0, $isInteractions=0){
        try{
            $streamMessage = "";
            $postType = CommonUtility::getTranslatedPostTypebyIndex($postTypeId, $categoryType);
            $postType = str_replace("Survey",Yii::t("translation","Survey"),$postType);
            if ($categoryType == 9 && ($recentActivity=="GameSchedule" || $recentActivity=="Post" || $recentActivity=="Play")) {//Games
                $streamMessage = CommonUtility::streamNoteForGames($recentActivity, $postType);
            }else if ($categoryType == 10) {//Badges
                $streamMessage = CommonUtility::streamNoteForBadges($recentActivity, $badgeName);
            }else if ($categoryType == 12) {//CV
                $streamMessage = CommonUtility::streamNoteForCV($recentActivity, $postType, $cvType, $isMine);
            }else{
                $streamMessage = CommonUtility::prepareStreamNotes($postTypeId, $categoryType, $recentActivity, $postType, $isAnonymous, $isMine,$invitedUsers, $isInvited, $isInteractions);
            }
            return $streamMessage;
        }catch(Exception $ex){
            Yii::log("CommonUtility:getStreamNote::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->getStreamNote==".$ex->getMessage());
        }
    }
     /*
     * Here we calculate time spent on particular schedule
     */
    static function calculateTimeSpentOnSurvey($scheduleId,$surveyId){
        try{
          
            return SurveyInteractionCollection::model()->calculateTimeSpentOnSurvey($scheduleId,$surveyId);
            
        } catch (Exception $ex) {
            Yii::log("CommonUtility:calculateTimeSpentOnSurvey::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    static function getSurveyPageAnalytics($scheduleId,$surveyId){
       try{
          
           
            $result = SurveyInteractionCollection::model()->getSurveyPageAnalytics($scheduleId,$surveyId);
           $finalArray = array();
           $totalTimeSpent = 0;
           $pageTimesArray = array();
           $flag = "Minutes";
         foreach ($result as $value) {
              $totalTimeSpent = $totalTimeSpent+$value['SurveyTimeSpent_Sum'];
              $timeInMinutes = $value['SurveyTimeSpent_Sum']/60;
               $timeInHours = $value['SurveyTimeSpent_Sum']/(60*60);
               if($timeInHours>=1){
                   $flag = "Hours";
               }
               $pageTimeSpentInSeconds = $value['SurveyTimeSpent_Sum'];
              array_push($pageTimesArray,$value['SurveyTimeSpent_Sum']);
              $timeSpentString= gmdate("H:i:s", $value['SurveyTimeSpent_Sum']);
              array_push($finalArray, array("PageNumber"=>"Page-".$value['_id']["SurveyPage"],"PageTimeSpentInSeconds"=>$pageTimeSpentInSeconds,"TimeSpentInMinutes"=>round($timeInMinutes,1),"TimeSpentInHours"=>round($timeInHours,1),"timeSpentString" => $timeSpentString));
              };
             // $maxValue = max($pageTimesArray);
              
               $totalTimeSpentString= gmdate("H:i:s", $totalTimeSpent);
          return array("PagesAnalyticsData"=>$finalArray,"totalTimeSpentString"=>$totalTimeSpentString,"totalTimeSpent"=>$totalTimeSpent,"flag"=>$flag);  
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getSurveyPageAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    static function prepareJustificationData($surveyId,$questionId,$justificatonData,$questionType){
        try{
            $usersArray = $justificatonData["UsersArray"];
            $optionCommentsArray = $justificatonData["OptionCommentsArray"];
            $selectedOptionsArray = $justificatonData["SelectedOptionsArray"];
           $finalDataArray = array();
           for($i=0;$i<count($usersArray);$i++){
               if($questionType == 8){
                   if ($optionCommentsArray[$i]!="") {
                $justificationDisplayBean = new JustificationDisplayBean();
                
               $userObj =  UserCollection::model()->getTinyUserCollection($usersArray[$i]);
               $justificationDisplayBean->UserId = $userObj->UserId;
               $justificationDisplayBean->DisplayName = $userObj->DisplayName;
               $justificationDisplayBean->UniqueHandle = $userObj->uniqueHandle;
               $justificationDisplayBean->ProfilePicture = $userObj->profile70x70;
               $justificationDisplayBean->JustficationsArray = $optionCommentsArray[$i];
               $justificationDisplayBean->SelectedOptions = $selectedOptionsArray[$i];
               array_push($finalDataArray, $justificationDisplayBean);
           }  
               }else{
                   if (array_filter($optionCommentsArray[$i])) {
                $justificationDisplayBean = new JustificationDisplayBean();

               $userObj =  UserCollection::model()->getTinyUserCollection($usersArray[$i]);
               $justificationDisplayBean->UserId = $userObj->UserId;
               $justificationDisplayBean->DisplayName = $userObj->DisplayName;
               $justificationDisplayBean->UniqueHandle = $userObj->uniqueHandle;
               $justificationDisplayBean->ProfilePicture = $userObj->profile70x70;
               $justificationDisplayBean->JustficationsArray = $optionCommentsArray[$i];
               $justificationDisplayBean->SelectedOptions = $selectedOptionsArray[$i];
               array_push($finalDataArray, $justificationDisplayBean);
           }  
               }
              
           }
           
           
            $question = ExtendedSurveyCollection::model()->getQuestionOfSurvey($surveyId,$questionId);
            if($questionType == 8){
             $optionNames = $question["Options"]; 
             $labelName = array();
            }else{
               $optionNames = $question["OptionName"]; 
                $labelName = $question["LabelName"]; 
            }
           
            return array("finalArray"=>$finalDataArray,"OptionName"=>$optionNames,"LabelName"=>$labelName);   
            
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareJustificationData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


    public function actionSendmailForHdsUsersAnalytics($view, $params, $subject, $recipients,$file) {

        try {
            $fromAddress = Yii::app()->params['SendGridFromEmail'];
            $fromName = Yii::app()->params['NetworkName'];
            if (DEPLOYMENT_MODE == 'PRODUCTION') {
                $controller = new CController('YiiMail');
                if (isset(Yii::app()->controller)) {
                    $controller = Yii::app()->controller;
                }
                $resultantPreparedHtml= Yii::app()->params['NetworkName']." Hds Users analytics report";
                //$resultantPreparedHtml = $controller->renderInternal(Yii::app()->basePath . '/views/mail/' . $view . '.php', $params, 1);
                $result = Yii::app()->sendgrid->sendMail($recipients, '', '', $subject, $resultantPreparedHtml, '', $fromAddress, '', $fromName, '','',$file);
                if ($result['message'] == 'success') {
                    return true;
                } else {
                    return false;
                }
            } else {
                Yii::import('ext.yii-mail.YiiMailMessage');
                Yii::app()->mail->transportOptions = array(
                    'host' => 'smtp.gmail.com',
                    'username' => 'mikeaaron8@gmail.com',
                    'password' => 'test@123',
                    'port' => '465',
                    'encryption' => 'ssl',
                );
                Yii::app()->mail->transportType = "smtp"; // Uncomment these when email is configured in admin section for Template management
                $message = new YiiMailMessage;
                $message->view ="";
                //$message->setBody($params, 'text/html');
                $message->subject = $subject;
                if(is_array($file) && sizeof($file)>0){
                    for($i=0;$i< sizeof($file);$i++){
                       // $swiftAttachment."_".$i = Swift_Attachment::fromPath($file[$i]);
                        $message->attach(Swift_Attachment::fromPath($file[$i]));
                    }
                }else{
                    $message->attach(Swift_Attachment::fromPath($file));
                }
//                $swiftAttachment = Swift_Attachment::fromPath($file);
//                $message->attach(Swift_Attachment::fromPath($file));
                $message->addTo($recipients);
                $message->from = 'mikeaaron8@gmail.com';

                if (Yii::app()->mail->send($message)) {
                    error_log("========Message sent==============");
                    return true;
                } else {
                    error_log("==========Message send failed============");
                    return false;
                }
            }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:actionSendmailForHdsUsersAnalytics::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->actionSendmailForHdsUsersAnalytics==".$ex->getMessage());
        }
    }
    
    static function prepareSeeAnswersData($surveyId,$questionId,$seeAnswersData,$questionType){
        try{
            $usersArray = $seeAnswersData["UsersArray"];
            $userAnswerArray = $seeAnswersData["UserAnswerArray"];
            $usergeneratedRankingOptions = $seeAnswersData["UsergeneratedRankingOptions"];
            $finalDataArray = array();
           
           for($i=0;$i<count($usersArray);$i++){
               if($questionType == 6){
               if($userAnswerArray[$i] != ""){
                    $seeAnswersDisplayBean = new SeeAnswersDisplayBean();
                    $userObj =  UserCollection::model()->getTinyUserCollection($usersArray[$i]);
                    $seeAnswersDisplayBean->UserId = $userObj->UserId;
                    $seeAnswersDisplayBean->DisplayName = $userObj->DisplayName;
                    $seeAnswersDisplayBean->UniqueHandle = $userObj->uniqueHandle;
                    $seeAnswersDisplayBean->ProfilePicture = $userObj->profile70x70;
                    $seeAnswersDisplayBean->SeeAnswersArray = $userAnswerArray[$i];

                    array_push($finalDataArray, $seeAnswersDisplayBean);
              }
               }else if($questionType == 7){
                   if($usergeneratedRankingOptions[$i] != ""){
                        $seeAnswersDisplayBean = new SeeAnswersDisplayBean();
                        $userObj =  UserCollection::model()->getTinyUserCollection($usersArray[$i]);
                        $seeAnswersDisplayBean->UserId = $userObj->UserId;
                        $seeAnswersDisplayBean->DisplayName = $userObj->DisplayName;
                        $seeAnswersDisplayBean->UniqueHandle = $userObj->uniqueHandle;
                        $seeAnswersDisplayBean->ProfilePicture = $userObj->profile70x70;
                        $seeAnswersDisplayBean->UsergeneratedRankingOptions = $usergeneratedRankingOptions[$i];

                        array_push($finalDataArray, $seeAnswersDisplayBean);
                   }
               }
           }          
           

            return array("finalArray"=>$finalDataArray);   
            
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareSeeAnswersData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }


     
    
    public static function getNotificationTypeByName($name){
        try{
            $returnIndex = 1;
            $name = strtolower($name);
            if($name == "system"){
                $returnIndex = 2;
            }else if($name == "Application"){
                $returnIndex = 3;
            }
            return $returnIndex;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getNotificationTypeByName::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->getNotificationTypeByName==".$ex->getMessage());
        }
    }
    
    public static function sendNotificationsToUsers($pendingUsers){
        try{
            if(sizeof($pendingUsers)>0){
                foreach($pendingUsers as $user){
                    if(!is_array($user['UserId'])){
                        error_log("\n Trying to push User = ".$user['UserId']);
                        $notificationObj = new Notifications();
                        $notificationObj->UserId = (int) $user['UserId'];
                        //$notificationObj->RedirectUrl = $user['Url'];
                        $notificationObj->NotificationType = $user['NType'];
                        $notificationObj->CategoryType = $user['CategoryType'];
                        $notificationObj->PostType = $user['PostType'];
                        $notificationObj->PostId = $user['PostId']; // here PostId means ScheduleId...
                        $notificationObj->SegmentId = $user['SegmentId'];
                        $notificationObj->Language = $user['Language'];
                        $notificationObj->isRead = 0; // unread
                        $notificationObj->NetworkId = $user['NetworkId'];
                        $notificationObj->NotificationNote = $user['NotificationNote'];
                        $notificationObj->RecentActivity = $user['RecentActivity'];                          
                        $notificationObj->CreatedOn = new MongoDate(strtotime(date('Y-m-d H:i:s', time())));

                        $object = Notifications::model()->getNotificationsForUserWithPost($notificationObj->UserId,$notificationObj->PostId,$notificationObj->NetworkId,$notificationObj->CategoryType,$notificationObj->RecentActivity);
                        if(sizeof($object) > 0 && $object != "failure"){
                            error_log(" Object exist with userId = $notificationObj->UserId, PostId = $notificationObj->PostId and update IsRead as 0");
                           Notifications::model()->updateNotificationAsUnRead($object->_id);
                        }else{
                            error_log(" Object not exist with UserId = $notificationObj->UserId and PostId = $notificationObj->PostId \n");
                            Notifications::model()->saveNotifications($notificationObj);
                        }
    //                    Notifications::model()->saveNotifications($notificationObj);
                    }
                }
            }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:sendNotificationsToUsers::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->sendNotificationsToUsers==".$ex->getMessage());
        }
    }
    
    public static function prepareNotificationMessageForAdminSystem($data,$reqUserId, $notifications, $deviceType,$totalArray){
        try{
            $notificationMessage = "";
            $who = "";
            $action = "";
            $postType = "";
            $actionedUserCount = 1;            
            $isMine = 1;
            $whose = "";
            
            $recentActivity = $data->RecentActivity;
            if($data->NotificationType == 1){
               
                 // admin generated....

              if(in_array($reqUserId, $data->ReadUsers)){
                 $notifications->IsRead = 1;  
              }
              $notificationMessage=$data->NotificationNote;
              $user_data = UserCollection::model()->getTinyUserCollection($reqUserId);
               if(Yii::app()->params['IsMultipleSegment'] && Yii::app()->params['IsMultipleSegment']==1){ 
              $notificationMessage=CommonUtility::translateData($notificationMessage, "en", $user_data->Language);
               }

           
                         
            }else if($data->NotificationType == 2){ // system generated...
                if($recentActivity == "Survey"){                    
                    $action = Yii::t('posttypes', "Survey");
                    $postTypeId = $data->PostType;
//                    $notificationMessage = CommonUtility::notificationStringForSurvey($who, $action, $postType, $postTypeId);                    
                    $notificationMessage = CommonUtility::notificationStringForAdminSystem($data->NotificationType,$data->NotificationNote);
                }
                $notifications->IsRead = $data->isRead;
            }            
            if (!empty($notificationMessage)) {
                $createdOn = $data->CreatedOn;
                $notifications->CreatedOn = CommonUtility::styleDateTime($createdOn->sec, $deviceType);
                $notifications->_id = $data->_id;
                $notifications->NotificationString =$notificationMessage;
                $notifications->PostId = $data->PostId;
                $notifications->PostType = $data->PostType;
                $notifications->CategoryType = $data->CategoryType;
                $notifications->NotificationType = $data->NotificationType;
                $notifications->RedirectUrl = $data->RedirectUrl;
                array_push($totalArray, $notifications);
                }

            return $totalArray;
            
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareNotificationMessageForAdminSystem::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }   
    
    public static function notificationStringForAdminSystem($type,$htmlString){
        try{
            $message = "";                        
            //$urlString = CommonUtility::findUrlInStringAndMakeLink($htmlString);
            
            $arr = array("{title}"=>$htmlString);
            
            if($type == 1){
                $message = "";
            }else{
                $message = Yii::t('notifications',"The market research survey, {title} is left incomplete and is waiting for your inputs! Please complete the survey", $arr);
            }
            return $message;
        }catch(Exception $ex){
            Yii::log("CommonUtility:notificationStringForAdminSystem::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->notificationStringForAdminSystem==".$ex->getMessage());
        }
    }
    


  // Sign a URL with a given crypto key
// Note that this URL must be properly URL-encoded
function signUrl($address){
    try{
    $myUrlToSign="http://maps.googleapis.com/maps/api/geocode/json?address=$address&client=gme-medimediamanaged";
    $privateKey="NcAtHylxHk5rWJgyqLqemmwQ0-A=";
  // parse the url
  $url = parse_url($myUrlToSign);

  $urlPartToSign = $url['path'] . "?" . $url['query'];

  // Decode the private key into its binary format
  $decodedKey = CommonUtility::decodeBase64UrlSafe($privateKey);

  // Create a signature using the private key and the URL-encoded
  // string using HMAC SHA1. This signature will be binary.
  $signature = hash_hmac("sha1",$urlPartToSign, $decodedKey,  true);

  $encodedSignature = CommonUtility::encodeBase64UrlSafe($signature);

  return $myUrlToSign."&signature=".$encodedSignature;
} catch (Exception $ex) {
            Yii::log("CommonUtility:signUrl::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}

// Encode a string to URL-safe base64
function encodeBase64UrlSafe($value){
  try{
    return str_replace(array('+', '/'), array('-', '_'),
    base64_encode($value));
  } catch (Exception $ex) {
            Yii::log("CommonUtility:encodeBase64UrlSafe::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}

// Decode a string from URL-safe base64
function decodeBase64UrlSafe($value){
  try{
    return base64_decode(str_replace(array('-', '_'), array('+', '/'),
    $value));
  } catch (Exception $ex) {
            Yii::log("CommonUtility:actionUserLoveToPost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
}






 static function getLntFromAddress($address){
     try{ 
     $key = Yii::app()->params['GeoApIKey'];
      if(trim($key)==""){
         $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";  
      }else{
          $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&key=".$key;
      }
     
   
/*
// $result_string = file_get_contents($url);
   // $result = json_decode($result_string);
    //$result1[]=$result['results'][0];
    //$result2[]=$result1[0]['geometry'];
    //$result3[]=$result2[0]['location'];
 * 
 */
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $result = json_decode(curl_exec($ch));
  
    return $result;
    } catch (Exception $ex) {
            Yii::log("CommonUtility:getLntFromAddress::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
   }
static function getGeocodes($addressArray){
    
   try{
    $flag="";
    $address = "";
    $zip = "";
    $location = "";
    $priority="";
    $geoCode =  array("Latitude"=>"","Longitude"=>"","Status"=>0);
      if(isset($addressArray['Address1']) && $addressArray['Address1'] != "" ){
            $address =  ucwords(strtolower($addressArray['Address1']));
            $priority = "address";
        }
        if(isset($addressArray['Address2']) && $addressArray['Address2'] != "" ){
           if($address != ""){
               $address = $address .  ", ";
          }
           $priority = "address";
            $address = $address . ucwords(strtolower($addressArray['Address2'])); 
        }
         if(isset($addressArray['Zip']) && $addressArray['Zip'] != "") {
            $zip = strlen($addressArray['Zip']) == 4 ? ('0' . $addressArray['Zip']) : $addressArray['Zip'];
            if($address != ""){
               $address = $address .  ", ";
          }
           $priority = "address";
           $address = $address . $zip;
        }
        if(isset($addressArray['City']) && $addressArray['City'] != ""){
          if($address != ""){
               $address = $address .  ", ";
          }else{
               $priority = "zip";
          }
            $address = $address . ucwords(strtolower($addressArray['City'])); 
        }
        if(isset($addressArray['State']) && $addressArray['State'] != ""){
          if($address != ""){
               $address = $address .  ", ";
          }else{
               $priority = "zip";
          }
            $address = $address .  $addressArray['State']; 
        }
        if($address != "" &&  $priority == "address"){
            $location = $address;
            $flag = "address";
        }else if($zip != ""){
            $location = $zip;
            $flag = "zip";
        }else{
             $location = $address;
              $flag = "address";
        }
    
  if($flag != ""){
      $geoCode = GeoCodes::model()->getGeoCodeFromLocalDB($addressArray,$flag);
       if($geoCode["Status"] == 0){
        $geoCodeDetails = CommonUtility::getLntFromAddress($location);
        $geoCode = array("Latitude"=>"","Longitude"=>"","Status"=>0);
      
        if (is_object($geoCodeDetails) && $geoCodeDetails->status != "OK") {
          if($flag == "address"){
               $flag = "zip"; 
               $geoCode = GeoCodes::model()->getGeoCodeFromLocalDB($addressArray,$flag);
                if($geoCode["Status"] == 0){
                    $geoCodeDetails = CommonUtility::getLntFromAddress($zip);
                    if (is_object($geoCodeDetails) && $geoCodeDetails->status == "OK"){
                         $latitude = $geoCodeDetails->results[0]->geometry->location->lat;
                         $longitude = $geoCodeDetails->results[0]->geometry->location->lng;
                         $geoCode =  array("Latitude"=>$latitude,"Longitude"=>$longitude,"Status"=>200);
                         GeoCodes::model()->saveGeoCode($addressArray,$geoCode,$flag); 
                    }
                    
                    return $geoCode;
                    
                }else{
                    return $geoCode; 
                }
             
          }
        }else  if (is_object($geoCodeDetails) && $geoCodeDetails->status == "OK") {
          $latitude = $geoCodeDetails->results[0]->geometry->location->lat;
          $longitude = $geoCodeDetails->results[0]->geometry->location->lng;
          $geoCode =  array("Latitude"=>$latitude,"Longitude"=>$longitude,"Status"=>200);
          GeoCodes::model()->saveGeoCode($addressArray,$geoCode,$flag);   
        }else{
            
           // error_log("geo code failed to get--for-----".$flag."---address---".print_r($addressArray,1))  ;
        }
         
       }
  }
        return $geoCode;
}catch(Exception $ex){
   Yii::log("CommonUtility:getGeocodes::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
}  
    }
    
    
    static function updateGeoCoordinates($obj,$flag){
       try{ 
       $address1 = "";
       $address2 = "";
       if($flag == "User"){
            $countryObj =Countries::model()->getCountryById($obj['Country']);
            $obj['Country'] = $countryObj->Code;
       }
       if($flag == "Career"){
           if($obj["Source"] !="hec"){
                $jobTitle = $obj['JobTitle'];
                $jobTitleArray = explode("-", $jobTitle);
                if(count($jobTitleArray)>2){
                      $location = end($jobTitleArray);
                      $locationArray = explode(",", $location);
                    if(count($locationArray)>0){
                         if(count($locationArray)>1){
                            $obj['City'] = $locationArray[0];
                         $obj['State'] = $locationArray[1];  
                         }else{
                            $obj['State'] = $locationArray[0];

                         } 
                }
                } 
           }
       }
       if(isset($obj['Address1'])){
           $address1 = $obj['Address1'];
       }
        if(isset($obj['Address2'])){
           $address2= $obj['Address2'];
       }
        $addressArray = array("Zip" => $obj['Zip'], "City" => $obj['City'], "State" => $obj['State'], "Country" => $obj['Country'], "Address1" => $address1, "Address2" => $address2);
        $geocode = CommonUtility::getGeocodes($addressArray);
        if ($geocode["Status"] == 200) {
            if ($flag == "User") {
                $resultValue = User::model()->updateUserGeoCoordinates($geocode['Latitude'], $geocode['Longitude'], $obj["UserId"]);
                if($resultValue == "success"){
                    
                    CommonUtility::triggerRecommendationsForUser($obj["UserId"]);
                  
                }
            } else {
                Careers::model()->updateCareerGeoCoordinates($geocode['Latitude'], $geocode['Longitude'], $obj["id"]);
            }
        }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:updateGeoCoordinates::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }




    
    
    public static function checkJoyrIdeStatus($userId,$opportunityId,$joyrideInfoObj)
    {
        try
        {
           
            
             $userClassification=1;
             $opportunityGoal=0;
             $goalStatus=false;
             $opportunityObjResult=OpportunitiesCollection::model()->getOpportunitiesByOpportunityType($userClassification,$joyrideInfoObj['OpportunityType']);
             $userAchivementsObjResult=UserAchievementsCollection::model()->getUserAchievementsByOpportunityType($userId,$userClassification,$joyrideInfoObj['OpportunityType']);
             if(sizeof($opportunityObjResult)>0 && sizeof($userAchivementsObjResult)>0)
             {
                
                 $opportunityObj=$opportunityObjResult['result'][0];
                  $userAchivementsObj=$userAchivementsObjResult['result'][0];
                  if($joyrideInfoObj['GoalCalculationType']==1)
                   $goalStatus=  CommonUtility::calculateGoalAtOpportunityLevel($opportunityObj['Opportunities'][0],$userAchivementsObj['Opportunities'][0]);//Goal calculation at opportunity level
                  else
                   $goalStatus=  CommonUtility::calculateGoalAtEngagementDriverLevel($opportunityObj['Opportunities'][0],$userAchivementsObj['Opportunities'][0],$joyrideInfoObj['EngagementDriverName']);//Goal calculation at engagement driver level
                  return $goalStatus;
                  
             }
             else
                 return $goalStatus;
             
             
             echo "=================checkJoyrIdeStatus======end======1\n";
             
          
            
            
        } catch (Exception $ex) {
            Yii::log("CommonUtility:checkJoyrIdeStatus::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->checkJoyrIdeStatus==".$ex->getMessage());
        }
    }
    
    
    
    
    public static function calculateGoalAtOpportunityLevel($opportunity,$userAchievementOpportunity)
    {
        try
        {
            $returnVal = false;
            $opportunityGoal = $userAchievementOpportunity["OpportunityGoal"];
            $userEngagementDrivers = $userAchievementOpportunity["EngagementDrivers"];
            $opportunityEngagementDrivers = $opportunity["EngagementDrivers"];
            
            $totalWeight = 0;
            for($i=0; $i<count($userEngagementDrivers); $i++){
                $engagementDriver = $opportunityEngagementDrivers[$i]['Type'];
                if($userEngagementDrivers[$i]['Type']==$engagementDriver){
//               
                    $isGoalInPercentage = (int)$opportunityEngagementDrivers[$i]['IsGoalInPercentage'];
                    $goal = (int)$opportunityEngagementDrivers[$i]['Goal'];
                    $weight = (int)$opportunityEngagementDrivers[$i]['Weight'];
                    
                    $achieved = (float)$userEngagementDrivers[$i]['Achieved'];
                    
                    $available = empty($userEngagementDrivers[$i]['Available'])?"":(int)$userEngagementDrivers[$i]['Available'];
                    if($isGoalInPercentage==0)
                    {
                        if($achieved>=$goal){
                            $totalWeight += $weight;
                        }else{
                            if($goal>0){
                                $weight = ($achieved/$goal)*$weight;
                                $totalWeight += $weight;
                            }
                        }
                    }
                    else
                    {
                        $needToAchieve = ($goal/100)*$available;
                        if($achieved>=$needToAchieve){
                            $totalWeight += $weight;
                        }else{
                            if($needToAchieve>0){
                                $weight = ($achieved/$needToAchieve)*$weight;
                                $totalWeight += $weight;
                            }
                        }
                    }
                }
           }
            if($totalWeight>=$opportunityGoal ){
                $returnVal = true;
            }
            return $returnVal;
            
        } catch (Exception $ex) {
            Yii::log("CommonUtility:calculateGoalAtOpportunityLevel::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }

    public static function calculateGoalAtEngagementDriverLevel($opportunity,$userAchievementOpportunity, $engagementDriver)
    {
        try
        {
            $returnVal = false;
            $opportunityGoal = $userAchievementOpportunity["OpportunityGoal"];
            $userEngagementDrivers = $userAchievementOpportunity["EngagementDrivers"];
            $opportunityEngagementDrivers = $opportunity["EngagementDrivers"];
            
            $totalWeight = 0;
            for($i=0; $i<count($userEngagementDrivers); $i++){
                if($userEngagementDrivers[$i]['Type']==$engagementDriver){
                    $isGoalInPercentage = (int)$opportunityEngagementDrivers[$i]['IsGoalInPercentage'];
                    $goal = (int)$opportunityEngagementDrivers[$i]['Goal'];
                    $weight = (int)$opportunityEngagementDrivers[$i]['Weight'];
                    
                    $achieved = (float)$userEngagementDrivers[$i]['Achieved'];
                    
                    $available = empty($userEngagementDrivers[$i]['Available'])?"":(int)$userEngagementDrivers[$i]['Available'];
                    if($isGoalInPercentage==0)
                    {
                        if($achieved>=$goal){
                            $totalWeight = $opportunityGoal;
                        }else{
                            if($goal>0){
                                $weight = ($achieved/$goal)*100;
                                $totalWeight = $weight;
                            }
                        }
                    }
                    else
                    {
                        $needToAchieve = ($goal/100)*$available;
                        if($achieved>=$needToAchieve){
                            $totalWeight = $opportunityGoal;
                        }else{
                            if($needToAchieve>0){
                                $weight = ($achieved/$needToAchieve)*100;
                                $totalWeight = $weight;
                            }
                        }
                    }
                    break;
                }
           }
            if($totalWeight>=$opportunityGoal ){
                $returnVal = true;
            }
            return $returnVal;
            
        } catch (Exception $ex) {
            Yii::log("CommonUtility:calculateGoalAtEngagementDriverLevel::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
        
    }
    public static function getRecommendationType($recommendation){
       try{
        if($recommendation == "Interest"){
           $type = 1;
       }
        else if($recommendation == "Location"){
           $type = 2;
       }else if($recommendation == "Classification"){
           $type = 3;
       }
       return $type;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getRecommendationType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    public static function pushToRecommendation($userId,$recommendeduserId,$recommendationItem,$recommendationType){
        try{
        $recommendationType = CommonUtility::getRecommendationType($recommendationType);
        UserRecommendations::model()->pushToRecommendation($userId,$recommendeduserId,$recommendationItem,$recommendationType);
        } catch (Exception $ex) {
            Yii::log("CommonUtility:pushToRecommendation::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function prepareImpressionObj($type, $tinyOriginalUser, $obj) {
        try{
            $activityObj = new UserInteractionCollection();
            $activityObj->UserId = (int) $tinyOriginalUser->UserId;
            $activityObj->ActionType = "Impression";
            $activityObj->RecentActivity = $type."Impression";
            $activityObj->NetworkId = (int)$tinyOriginalUser->NetworkId;
            $activityObj->SegmentId = (int)$tinyOriginalUser->SegmentId;
            $activityObj->Language = $tinyOriginalUser->Language;
            if(isset($obj["postType"])){
                $activityObj->PostId = $obj["postId"];
                $activityObj->PostType = (int)$obj["postType"];
                $activityObj->CategoryType = (int)$obj["categoryType"];
            }else if(isset($obj["webLinkId"])){
                $activityObj->WebLinkId = (int)$obj["webLinkId"];
                $activityObj->LinkGroupId = (int)$obj["linkGroupId"];
                $activityObj->WebUrl = $obj["webUrl"];
                $activityObj->CategoryType = (int)$obj["categoryType"];
            }else if(isset($obj["jobId"])){
                $activityObj->JobId = (int)$obj["jobId"];
                $activityObj->CategoryType = (int)$obj["categoryType"];
            }else if(isset($obj['groupId'])){
                $activityObj->GroupId = $obj["groupId"];
                $activityObj->CategoryType = (int)$obj["categoryType"];
                if(isset($obj["groupPostId"])){
                    $activityObj->PostId = $obj["groupPostId"];
                }
                else if(isset($obj["postId"])){
                    $activityObj->PostId = $obj["postId"];
                }

                if(isset($obj["subgroupId"])){
                    $activityObj->SubGroupId = $obj["subgroupId"];
                }

            }else if(isset($obj["adId"])){
                $activityObj->AdId = (int)$obj["adId"];
                $activityObj->Position = $obj["position"];
                $activityObj->Page = $obj["page"];
                $activityObj->CategoryType = (int)CommonUtility::getIndexBySystemCategoryType('Ads');
            }

            return $activityObj;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareImpressionObj::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    } 

    
       public static function runLocationRecommendationsForUser($userId) {
        try{
           $user = User::model()->getUserDetailsByUserId($userId);
        $radius = Yii::app()->params['RecomendedJobsRadius'];
        if ($user != "NoUser" && is_object($user)) {

            $userFollowingArray = UserProfileCollection::model()->getUserFollowingById($userId);
            if ($userFollowingArray == "failure") {
                $userFollowingArray = array();
            }
            $userId = $user["UserId"];
            $latitude = $user["Latitude"];
            $longitude = $user["Longitude"];
            $myNearUsers = User::model()->getMyLocationRecommendations($userId, $latitude, $longitude, $radius);
            if (count($myNearUsers) > 0) {
                foreach ($myNearUsers as $nearUser) {
                    if (!in_array($nearUser["UserId"], $userFollowingArray)) {
                        CommonUtility::pushToRecommendation($user["UserId"], $nearUser["UserId"], preg_replace('/\t/', '', (trim($user["City"]) . "-" . trim($user["State"]))), "Location");
                    }
                }
            }
        }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:runLocationRecommendationsForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function runClassificationRecommendationsForUser($userId) {
        try{
        $user = User::model()->getUserClassfication($userId);

        if ($user != "NoUser") {

            $userFollowingArray = UserProfileCollection::model()->getUserFollowingById($userId);
            if ($userFollowingArray == "failure") {
                $userFollowingArray = array();
            }
            $userId = $user["UserId"];
            $userClassification = $user["UserClassification"];
            if (isset($user["PrimaryAffiliation"]) && !empty($user["PrimaryAffiliation"])) {
                $primaryAffiliation = $user["PrimaryAffiliation"];
                $otherAffiliation = $user["OtherAffiliation"];

                if (isset($otherAffiliation) && $otherAffiliation != "") {
                    $recommendationItem = $userClassification . "-" . $primaryAffiliation . "-" . $otherAffiliation;
                } else {
                    $recommendationItem = $userClassification . "-" . $primaryAffiliation;
                }


                $myClassficationUsers = User::model()->getMyClassficationRecommendations($userId, $userClassification, $primaryAffiliation, $otherAffiliation);
                if (count($myClassficationUsers) > 0) {
                    foreach ($myClassficationUsers as $classificationUser) {
                        if (!in_array($classificationUser["UserId"], $userFollowingArray)) {
                            CommonUtility::pushToRecommendation($user["UserId"], $classificationUser["UserId"], $recommendationItem, "Classification");
                        }
                    }
                }
            }
        }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:runClassificationRecommendationsForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function runInterestRecommendationsForUser($userId) {
        try{
        $user = User::model()->getUserInterests($userId);
        if ($user != "NoUser") {

            $userFollowingArray = UserProfileCollection::model()->getUserFollowingById($userId);
            if ($userFollowingArray == "failure") {
                $userFollowingArray = array();
            }
            $userId = $user["UserId"];
            $tags = $user["Interests"];
            $interestsArray = explode(",", $tags);
            if (count($interestsArray) > 0) {
                foreach ($interestsArray as $interest) {

                    if (trim($interest) != "") {
                        $myInterestUsers = User::model()->getMyInterestRecommendations($userId, $interest);
                        if (count($myInterestUsers) > 0) {
                            foreach ($myInterestUsers as $interestUser) {
                                if (!in_array($interestUser["UserId"], $userFollowingArray)) {
                                    CommonUtility::pushToRecommendation($user["UserId"], $interestUser["UserId"], $interest, "Interest");
                                }
                            }
                        }
                    }
                }
            }
        }
        } catch (Exception $ex) {
            Yii::log("CommonUtility:runInterestRecommendationsForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function triggerRecommendationsForUser($userId){
        try{
         
              CommonUtility::runLocationRecommendationsForUser($userId);
              CommonUtility::runClassificationRecommendationsForUser($userId);
              CommonUtility::runInterestRecommendationsForUser($userId);
              return "success";
        } catch (Exception $ex) {
            Yii::log("CommonUtility:triggerRecommendationsForUser::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    
  static function prepareSurveyUsersData($surveyUserIdsArray, $pageIndex, $pageLimit){
        try{
            $finalDataArray = array();
            
            if(isset($surveyUserIdsArray) && is_array($surveyUserIdsArray)){
            
                $surveyUserIdsArray = array_chunk($surveyUserIdsArray, $pageLimit);
            
                if(isset($surveyUserIdsArray[$pageIndex]) && is_array($surveyUserIdsArray[$pageIndex])){      
                foreach($surveyUserIdsArray[$pageIndex] as $value){
                   $userId = explode("_", $value);
                   
                   if(count($userId) > 1){
                       $Id = $userId[1];
                       $dates = $userId[0];
                   }else{
                       $Id = $value;
                       $dates = "";
                   }
                    
                   if($Id != ""){
                        $surveyUsersDisplayBean = new SurveyUsersDisplayBean();
                        $userObj =  UserCollection::model()->getTinyUserCollection($Id);
                        $surveyUsersDisplayBean->UserId = $userObj->UserId;
                        $surveyUsersDisplayBean->DisplayName = $userObj->DisplayName;
                        $surveyUsersDisplayBean->UniqueHandle = $userObj->uniqueHandle;
                        $surveyUsersDisplayBean->ProfilePicture = $userObj->profile70x70;
                        $surveyUsersDisplayBean->ScheduleDates = $dates;
                        
                        array_push($finalDataArray, $surveyUsersDisplayBean);
                  }               
               }
                }
           }
           
           return array("finalArray"=>$finalDataArray);   
            
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareSurveyUsersData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function insertDataDynamicallyInExcelSheetForRaw($r, $initialRowVal, $labelArray, $dataArray) {
        try {
            $str = "";
            $alphabetsArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ','BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK',  'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV','BW','BX','BY','BZ','CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ','DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK',  'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV','DW','DX','DY','DZ');
            $alphasize = sizeof($alphabetsArray);
            for($i=0; $i<= $alphasize;$i++){
                if($i == $alphasize){
                    for($j=0,$m=0;$j<$alphasize;$j++){
                       if($m == $alphasize){
                           
                       }
                       $str = $str.","."'".$alphabetsArray[$m].$alphabetsArray[$j]."'";
                    }
                }else{
                    if(empty($str))
                            $str = "'".$alphabetsArray[$i]."'";
                        else
                            $str = $str.","."'".$alphabetsArray[$i]."'";
                }
                
                
                
            }
            $activeSheet = $dataArray["activeSheet"];
            $r->createSheet($activeSheet);
            $r->setActiveSheetIndex($activeSheet);
            $objWorksheet = $r->getActiveSheet();
            $rowsWidth = array();
            //-----------inserting headers----------------
            if (count($labelArray) > 0) {
                for ($i = 0; $i < count($labelArray); $i++) {
                    $celval = (string) ($alphabetsArray[$i] . $initialRowVal);
                    $r->getActiveSheet()->setCellValue($celval, $labelArray[$i]);
                    //setting column width
                    $headerLength = strlen($labelArray[$i]) + 4;
                    $headerLength = $headerLength < 8 ? 8 : $headerLength; //--minimum width of column is 8
                    $r->getActiveSheet()->getColumnDimension($alphabetsArray[$i])->setWidth($headerLength);
                    $rowsWidth[$alphabetsArray[$i]] = $headerLength;
                }
            }
            //------------inserting data-----------------
            if (count($dataArray) > 0) {
                $rowVal = $initialRowVal;
                for ($j = 0; $j < count($dataArray); $j++) {
                    $rowVal = $rowVal + 1;
                    $objWorksheet->insertNewRowBefore($rowVal + 1, 1);
                    for ($k = 0; $k < count($dataArray[$j]); $k++) {
                        if(!isset($dataArray[$j][$k])){
                            $dataArray[$j][$k] = "";
                        }
                        $celval = (string) ($alphabetsArray[$k] . $rowVal);
                        $r->getActiveSheet()->setCellValue($celval, $dataArray[$j][$k]);

                        $datalength = strlen($dataArray[$j][$k]);
                        $datalength = $datalength + 4;
                        if ($datalength > $rowsWidth[$alphabetsArray[$k]]) {
                            //updating column width
                            $r->getActiveSheet()->getColumnDimension($alphabetsArray[$k])->setWidth($datalength);
                            $rowsWidth[$alphabetsArray[$k]] = $datalength;
                        }
                    }
                }
            }
        } catch (Exception $ex) {
           Yii::log("CommonUtility:insertDataDynamicallyInExcelSheetForRaw::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
/**
* Author Haribabu
* @param type $String
 * This method is used to Prepare the SEO keywords.
*/    
    
    
     public static function PrepareDataForMetatags($type,$data) {
        try {
            
             $keywords="";
           if($type='profile'){
               $keywords="";
               $profileName=(isset($data->DisplayName))?$data->DisplayName:"";
               $PrimaryUser=Yii::app()->params['PrimaryUser'];
               $PracticeName=(isset($data->PracticeName))? $profileName.' '.$data->PracticeName:"";
               $City=(isset($data->City))?$profileName.' '.$data->City:"";
               $State=(isset($data->State))?$profileName.' '.$data->State:"";
               $Specialty=(isset($data->UserSubSpeciality))?$profileName.' '.$data->UserSubSpeciality:"";
                $Title=(isset($data->Title))?$profileName.' '.$data->Title:"";
               $keywords=$profileName.', '. $profileName ."  ". $PrimaryUser.', '.  $profileName . " published articles".', '. $profileName ." profile".', '.$City.', '.$State.', '. $Specialty.', '. $Title.', '.$PracticeName.', '. $PrimaryUser.', '. "education ". $profileName.', '."profile".', '. $PrimaryUser ." interactions".', '." CV ".', '. $PrimaryUser." profile".', '. $PrimaryUser." profile".', '.  Yii::app()->params['NetworkName']." public".', '. $PrimaryUser."  published articles";
   
           }
            
            return $keywords;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:PrepareDataForMetatags::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function getMiscellaneousType($type){
        try{
            $return = 0;
            if($type == "KOL"){
                $return = 1;
            }
            return $return;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:getMiscellaneousType::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
/**
 * @developer suresh reddy
 * @usage curl execute
 */
    static function executecurl($url, $intobj,$analyticsType='Interaction') {
        try{
          
            $url="https://apoc.skiptaneo.com";
        $curl = curl_init();
// Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => "https://apoc.skiptaneo.com/analytics/processInteractionObj",
            CURLOPT_USERAGENT => 'Hec job curl curl',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => array(
                'InteractionObject' => $intobj,
                'AnalyticsType'=>$analyticsType
            )
        ));
        
// Send the request & save response to $resp
        $resp = curl_exec($curl);
      
// Close request to clear up some resources
        curl_close($curl);
   
    } catch (Exception $ex) {
        echo $ex->getMessage();
            Yii::log("CommonUtility:executecurl::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }
    /**
     * @developer Sagar
     * @param type $file
     * @param type $mime
     * @return type
     */
     public static function data_uri($file, $mime) 
    {  try{
      if(file_exists($file)){
        $contents = file_get_contents($file);
        $base64   = base64_encode($contents); 
        return ('data:' . $mime . ';base64,' . $base64);
      }else{
         return $file; 
      }
      } catch (Exception $ex) {
       return ('data:' . '' . ';base64,' . '');
            Yii::log("CommonUtility:data_uri::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    public static function sendDataToZionRestCall($url,$data){
         try{     


            $data = json_encode($data);            
            error_log($data);
            $ch = curl_init($url);            
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
            $headers = array('Content-Type:application/json');
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false); 
            # Return response instead of printing.
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            # Send request.
            $result = curl_exec($ch);
            curl_close($ch);
       }catch(Exception $exc){
             Yii::log("=====AMQPCommand/sendRequestToPictoCV=====".$exc->getMessage(), 'error', 'application');
       }
    }
    
    
    public static function prepareTestPaperDashboradData($surveyObject) {
        try {

            $totalBeansArray = array();            
            foreach ($surveyObject as $data) {
                $extendedBean = new TestPreparationCollection();
                $extendedBean->_id = $data->_id;
                $extendedBean->Title = $data->Title;
                $extendedBean->Description = $data->Description;
                $extendedBean->Category = $data->Category;
                $extendedBean->InviteUsers = $data->InviteUsers;
                $extendedBean->TestTakenUsers = $data->TestTakenUsers;
                
                $TotalQuestions = 0;
                foreach($data->Category as $rw){
                    $TotalQuestions += $rw['NoofQuestions'];
                }
                $extendedBean->NoofQuestions = $TotalQuestions;
                array_push($totalBeansArray, $extendedBean);
                //$i++;
            }
            //error_log("----------------------".print_r($totalBeansArray,true));
            return $totalBeansArray;
        } catch (Exception $ex) {
            Yii::log("CommonUtility:prepareSurveyDashboradData::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
            error_log("Exception Occurred in CommonUtility->prepareSurveyDashboradData==".$ex->getMessage());
        }
    }
    public static function getAnswersByQuestionId($catId=0,$qId=0){
        try{
            return ExtendedSurveyCollection::model()->getAnswersByQuestionId($catId,(string)$qId);
        } catch (Exception $ex) {
            error_log("Exception Occurred in CommonUtility->getAnswersByQuestionId==".$ex->getMessage());
        }
    }
}   
