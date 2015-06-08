<?php

class PostTest extends CDbTestCase {

    public function testNormalPost() {
        try {
            $normalPost = new NormalPost();
            $normalPost->Description = 'This is to test the post';
            $normalPost->UserId = 1;
            $this->assertEquals('success', NormalPost::model()->SaveNormalPost($normalPost));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), 'error', 'application');
        }
    }

    public function testEventPost() {
        try {
            $eventPost = new EventPost();
            $eventPost->UserId = 1;
            $eventPost->Description = 'This is to test the Event post';
            $eventPost->StartDate = '2014-01-17 20: 11: 22';
            $eventPost->EndDate = '2014-01-20 20: 11: 22';

            $this->assertEquals('success', EventPost::model()->SaveEventPost($eventPost));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), 'error', 'application');
        }
    }

    public function testGetUserCollectionByUserId($userid = 2, $loggedUserId = 1) {
        try {
            $this->assertLessThanOrEqual(array(), UserProfileCollection::model()->getUserCollectionByUserId($userid, $loggedUserId));
        } catch (Exception $ex) {

            Yii::log($ex->getMessage(), 'error', 'application');
        }
    }

    public function testsaveHashTagTest() {
        try {
            $normalPost = new NormalPost();
            $normalPost->Description = 'This is to test the hashtag in post whciha already exists ';
            $normalPost->UserId = 1;
            $normalPost->Type = 'NormalPost';
            $skiptaPostService = new SkiptaPostService();
            $hashTagArray = array("twitter", "facebook", "techo2", "skipta");
            $this->assertEquals('success', $skiptaPostService->savePost($normalPost, $hashTagArray));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), 'error', 'application');
        }
    }

    public function testSaveComment() {
        try {
            $skiptaPostService = new SkiptaPostService();
            
            $commentBean=new CommentBean();
            $commentBean->CommentText='hey guys whats happ';
            $commentBean->PostId='52ea13b8b96c3d33048b45b8';
            $commentBean->PostType='Normal Post';
            $commentBean->UserId=2;
            $this->assertEquals('success', $skiptaPostService->saveComment($commentBean));
        } catch (Exception $exc) {

            Yii::log($exc->getMessage() . "In test save comment", 'error', 'application');
        }
    }

    public function testsaveFollowOrUnfollowToPost() {
        try {
            $skiptaPostService = new SkiptaPostService();
            //   $this->assertEquals('success', $skiptaPostService->saveFollowToPost('Normal Post','52e60b23c95dbbe64f8b4569',2,'Follow'));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage() . "In test save comment", 'error', 'application');
        }
    }

    public function testloveNormalPost() {
        try {
            $skiptaPostService = new SkiptaPostService();
            $this->assertEquals('success', $skiptaPostService->saveLoveToPost(1,'52ea77d066bc5cc72b8b45f1',2));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage() . "testloveNormalPost", 'error', 'application');
        }
    }
    public function testSaveOrRemoveAttende() {
        try {
           $skiptaPostService = new SkiptaPostService();
           $this->assertEquals('success', $skiptaPostService->saveOrRemoveEventAttende('52e7c12566bc5cc82b8b4567',2,'Attend')); 
        } catch (Exception $exc) {
            Yii::log($exc->getMessage() . "testSaveOrRemoveAttende", 'error', 'application');
        }
    }
    
   public function testSurveyPost(){
       try {
           $surveyPostObj=new SurveyPost();
           $surveyPostObj->Description='This is to test Survey Post';
           $surveyPostObj->OptionOne='option 1';
           $surveyPostObj->OptionTwo='option 2';
           $surveyPostObj->OptionThree='option 3';
           $surveyPostObj->OptionFour='option 4';
           $surveyPostObj->Status=1;
           $surveyPostObj->Type=3;
           $surveyPostObj->UserId=2;
           $surveyPostObj->ExpiryDate=new MongoDate(strtotime(date('Y-m-d H:i:s', time())));
           $this->assertEquals('success', SurveyPost::model()->saveSurveyPost($surveyPostObj));
       } catch (Exception $exc) {
           echo '_______in test___________________'.$exc->getMessage();
           Yii::log($exc->getMessage()."In Exception test",'error','application');
       }
      } 

}
