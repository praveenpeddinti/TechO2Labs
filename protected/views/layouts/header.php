<?php
     $user_present = Yii::app()->session->get('TinyUserCollectionObj');
     if(isset($user_present))
     {
     include 'header_postlogin.php';
     }
     else 
     {
     include 'header_prelogin.php';
     }
     ?>
