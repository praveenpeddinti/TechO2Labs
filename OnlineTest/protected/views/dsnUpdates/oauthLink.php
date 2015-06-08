<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

 <div class=' alignright clearboth'>
 <?php $oauthLink="<a onclick='loginOauthOnProvider(".'"'.$oauthLinkInfo['NetworkName'].'",'.'"'.Yii::app()->params['ServerURL'].'",'.'"'.$oauthLinkInfo['NetworkRedirectUrl'].'",'.'"'.'"'.")'> Go to dsn</a>"; ?>
    
     <?php echo $oauthLink; ?>
     <a onclick='loginOauthOnProvider("<?php echo  $oauthLinkInfo['NetworkName'] ?>","<?php echo Yii::app()->params['ServerURL'] ?>","<?php echo  $oauthLinkInfo['NetworkRedirectUrl']; ?>","")'  >GO To DSN</a>
</div>

