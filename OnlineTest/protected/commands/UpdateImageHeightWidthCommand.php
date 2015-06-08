<?php

/**
 * DocCommand class file.
 *
 * @author Moin Hussain
 * @usage Updating User Handler in TinyUserCollection server version
 *  @version 1.0
 */
class UpdateImageHeightWidthCommand extends CConsoleCommand {

    public function run($args) {
         $mongoCriteria = new EMongoCriteria;
         $mongoCriteria->sort("_id", EMongoCriteria::SORT_ASC);
        if ($args[0] == "posts") {
      
       // $mongoCriteria->addCond("_id", "==", new MongoId("545895f39f8ccbca328b458f"));
           $posts = PostCollection::model()->findAll($mongoCriteria);
           $this->updateImageHeightWidth($posts,'post');
    
        }
         if ($args[0] == "curbside") {
          //   $mongoCriteria->addCond("_id", "==", new MongoId("545895f39f8ccbca328b458f"));
             $posts = CurbsidePostCollection::model()->findAll($mongoCriteria);
             $this->updateImageHeightWidth($posts,'curbside');
            // $this->updateResource("53e350d2cec9fee5118b45d2");
           // $this->updateStream("545895f39f8ccbca328b458f");
        }
         if ($args[0] == "group") {
             
            // $mongoCriteria->addCond("_id", "==", new MongoId("5458a3159f8ccb0e788b4567"));
             $posts = GroupPostCollection::model()->findAll($mongoCriteria);
             $this->updateImageHeightWidth($posts,'group');
        }
         if ($args[0] == "all") {
            $posts = PostCollection::model()->findAll($mongoCriteria);
            $this->updateImageHeightWidth($posts,'posts');
            $curbposts = CurbsidePostCollection::model()->findAll($mongoCriteria);
            $this->updateImageHeightWidth($curbposts,'curbside');
            $groupposts = GroupPostCollection::model()->findAll($mongoCriteria);
            $this->updateImageHeightWidth($groupposts,'group');
        }
        
    }

    function updateImageHeightWidth($posts,$type) {
        try{
            foreach ($posts as $post) {
                if (isset($post->Resource)) {
                    $resources = $post->Resource;
                    $newResourcesArray = array();
                    $updateResource = 0;
                    foreach ($resources as $resource) {
                        if (!isset($resource['Height'])) {
                            $updateResource = 1;
                            if (isset($resource['ThumbNailImage']) && !empty($resource['ThumbNailImage'])) {
                                $ThumbNailImage = Yii::app()->params['WebrootPath'] . $resource['ThumbNailImage'];

                                if (file_exists($ThumbNailImage)) {
                                    $image_info = getimagesize($ThumbNailImage);
                                    $image_width = $image_info[0];
                                    $image_height = $image_info[1];
                                    $resource["Height"] = (int) $image_height;
                                    $resource["Width"] = (int) $image_width;
                                    array_push($newResourcesArray, $resource);
                                }
                            }
                        } else {
                        }
                    }

                    $comments = $post->Comments;
                    $commentsModifiedArray = array();
                    $updateArtifact = 0;
                    foreach ($comments as $comment) {
                        $artifacts = $comment["Artifacts"];
                        $newArtifactsArray = array();
                        foreach ($artifacts as $artifact) {
                            if (!isset($artifact['Height'])) {

                                if (isset($artifact['ThumbNailImage']) && !empty($artifact['ThumbNailImage'])) {
                                    $ThumbNailImage = Yii::app()->params['WebrootPath'] . $artifact['ThumbNailImage'];

                                    if (file_exists($ThumbNailImage)) {
                                        $image_info = getimagesize($ThumbNailImage);
                                        $image_width = $image_info[0];
                                        $image_height = $image_info[1];
                                        $artifact["Height"] = (int) $image_height;
                                        $artifact["Width"] = (int) $image_width;
                                        array_push($newArtifactsArray, $artifact);
                                    }
                                }
                            } else {
                            }
                        }
                        if (count($newArtifactsArray) > 0) {
                            $updateArtifact = 1;
                            $comment["Artifacts"] = $newArtifactsArray;
                            array_push($commentsModifiedArray, $comment);
                        }
                    }




                    if ($updateResource == 1 || $updateArtifact == 1) {
                        $this->updatePost($type,$post->_id, $newResourcesArray, $commentsModifiedArray, $updateResource, $updateArtifact);
                    } else {
                    }
    //          if($c==1){
    //              break;  
    //          }
    //        $c++;
                }
            }
        } catch (Exception $ex) {
            Yii::log("UpdateImageHeightWidthCommand:updateImageHeightWidth::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    function updatePost($type,$postId, $newResourcesArray, $commentsModifiedArray, $updateResource, $updateArtifact) {
        try{
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($updateResource == 1) {
                $mongoModifier->addModifier('Resource', 'set', $newResourcesArray);
            }
            if ($updateArtifact == 1) {
                $mongoModifier->addModifier('Comments', 'set', $commentsModifiedArray);
            }

            $mongoCriteria->addCond('_id', '==', new MongoId($postId));
            if($type == "post"){
               $update = PostCollection::model()->updateAll($mongoModifier, $mongoCriteria); 
            }
            if($type == "curbside"){
               $update = CurbsidePostCollection::model()->updateAll($mongoModifier, $mongoCriteria); 
            }
            if($type == "group"){
               $update = GroupPostCollection::model()->updateAll($mongoModifier, $mongoCriteria); 
            }

            if ($update) {
                $this->updateResource($postId);
                $this->updateStream($postId);
            }
        } catch (Exception $ex) {
            Yii::log("UpdateImageHeightWidthCommand:updatePost::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    function updateResource($postId) {
        try{
            $mongoCriteria = new EMongoCriteria;
            $mongoCriteria->addCond('PostId', '==', new MongoId($postId));
            $resources = ResourceCollection::model()->findAll($mongoCriteria);
            foreach ($resources as $resource) {
                if (empty($resource['Height'])) {
                    if (isset($resource['ThumbNailImage']) && !empty($resource['ThumbNailImage'])) {
                        $ThumbNailImage = Yii::app()->params['WebrootPath'] . $resource["ThumbNailImage"];
                        if (file_exists($ThumbNailImage)) {
                            $image_info = getimagesize($ThumbNailImage);
                            $image_width = $image_info[0];
                            $image_height = $image_info[1];
                            $resource["Height"] = (int) $image_height;
                            $resource["Width"] = (int) $image_width;


                            $mongoCriteria = new EMongoCriteria;
                            $mongoModifier = new EMongoModifier;
                            $mongoModifier->addModifier('Height', 'set', (int) $image_height);
                            $mongoModifier->addModifier('Width', 'set', (int) $image_width);
                            $mongoCriteria->addCond('PostId', '==', new MongoId($postId));
                            $mongoCriteria->addCond('_id', '==', new MongoId($resource['_id']));

                            $update = ResourceCollection::model()->updateAll($mongoModifier, $mongoCriteria);
    //              if($update){
    //                    $this->updateStream($postId);
    //              }  
                        }
                    }
                } else {
                }
            }
        } catch (Exception $ex) {
        Yii::log("UpdateImageHeightWidthCommand:updateResource::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    function updateStream($postId) {
        try{
        $mongoCriteria = new EMongoCriteria;
        $mongoCriteria->addCond('PostId', '==', new MongoId($postId));
        //  $mongoCriteria->addCond('_id', '==', new MongoId("5458731a9f8ccb5a4c8b4578")); 
        $stream = UserStreamCollection::model()->find($mongoCriteria);
        if(isset($stream) && !empty($stream)){
        $resource = $stream["Resource"];
        $updateResource = 0;
        if (is_array($resource) && empty($resource['Height'])) {
            $updateResource = 1;
            if (isset($resource['ThumbNailImage']) && !empty($resource['ThumbNailImage'])) {
                $ThumbNailImage = Yii::app()->params['WebrootPath'] . $resource['ThumbNailImage'];
                if (file_exists($ThumbNailImage)) {
                    $image_info = getimagesize($ThumbNailImage);
                    $image_width = $image_info[0];
                    $image_height = $image_info[1];
                    $resource["Height"] = $image_height;
                    $resource["Width"] = $image_width;
                }
            }
        }else{
        }


        $comments = $stream["Comments"];
        $commentsModifiedArray = array();
        $updateArtifact = 0;
        foreach ($comments as $comment) {
            $artifact = $comment["Artifacts"];
            // $newArtifactsArray = array();
            // foreach ($artifacts as $artifact){
            if (empty($artifact['Height'])) {
                $updateArtifact = 1;
                if (isset($artifact['ThumbNailImage']) && !empty($artifact['ThumbNailImage'])) {
                    $ThumbNailImage = Yii::app()->params['WebrootPath'] . $artifact['ThumbNailImage'];

                    if (file_exists($ThumbNailImage)) {
                        $image_info = getimagesize($ThumbNailImage);
                        $image_width = $image_info[0];
                        $image_height = $image_info[1];
                        $artifact["Height"] = (int) $image_height;
                        $artifact["Width"] = (int) $image_width;
                        //  array_push($newArtifactsArray, $artifact);
                    }
                }
            } else {
            }
            // }
            // if(count($newArtifactsArray)>0){
            //   $updateArtifact = 1;
            $comment["Artifacts"] = $artifact;
            array_push($commentsModifiedArray, $comment);
            // }
        }

        if ($updateResource == 1 || $updateArtifact == 1) {
            $mongoCriteria = new EMongoCriteria;
            $mongoModifier = new EMongoModifier;
            if ($updateResource == 1) {
                $mongoModifier->addModifier('Resource', 'set', $resource);
            }
            if ($updateArtifact == 1) {
                $mongoModifier->addModifier('Comments', 'set', $commentsModifiedArray);
            }

            $mongoCriteria->addCond('PostId', '==', new MongoId($postId));
            $update = UserStreamCollection::model()->updateAll($mongoModifier, $mongoCriteria);
        }
    }
    } catch (Exception $ex) {
        Yii::log("UpdateImageHeightWidthCommand:updateStream::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
    }
    }
   

}
