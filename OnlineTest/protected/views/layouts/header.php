<?php

 
$url =  Yii::app()->request->url;
if($url == "/site/privacyPolicy"){
   include 'header_prelogin.php'; 
}
else{
     $user_present = Yii::app()->session->get('TinyUserCollectionObj');
  if(isset($user_present))
     { 
                  
     include 'header_postlogin.php';
     }
     else 
     { ?> 
     <?php include 'header_prelogin.php';
     }  
}
    
     
     ?>
