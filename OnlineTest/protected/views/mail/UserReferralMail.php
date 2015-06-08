
<div style="width:600px; padding: 0; margin:0 auto;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td>
            <?php include 'mailContentHeaderTheme.php';  ?>
        </td>
    </tr>
    
    <tr>
        <td>
            <div style="padding:10px">
            <p style="font-size:12px; font-weight:normal; padding-top: 20px"><?php echo $message; ?></p>            
            </div>
        </td>
    </tr>
    
    <tr>
        <td >
            <div style=" background:#F5F6F6; padding:5px 15px 5px 15px; font-size:12px; color:#777; line-height:14px; position:relative">
                <p> <?php echo Yii::app()->params['NetworkName']; ?> is a verified social network designed by <?php echo Yii::app()->params['PrimaryUser']; ?> for <?php echo Yii::app()->params['PrimaryUser']; ?>. 
                    <?php echo Yii::app()->params['NetworkName']; ?>  allows users to safely share cases, solicit feedback from other specialists and access a wealth of resources specific to the profession.
                    <a target="_blank" href="<?php echo $link; ?>">Join today!</a></p>
            
            
        </div>
        </td>
    </tr>
    
    <tr>
        <td >
            <div style="padding:10px">
                <p style="font-size:12px; font-weight:normal; padding-top: 30px">Thanks,</p>
                <p style="font-size:14px; font-weight:bold; padding: 0px 0 40px 0"><?php echo $userName; ?></p>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div style="clear:both; display:block; border-bottom:1px solid #ccc; marging:2px 0px"></div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f5f6f6" align="center" style=" margin-top:3px;" >
                <tr>
                    <td style="text-align: left; white-space: nowrap;font-size:14px; line-height:24px;"><?php echo YII::app()->params['COPYRIGHTS']; ?></td>
                    <td style="text-align: right;padding-top:3px; "><a href="<?php echo Yii::app()->params['ServerURL']; ?>" target="_blank" style="border:none;"> <img alt="skipta" src="<?php echo YII::app()->params['ServerURL']; ?>/images/system/poweredbyskipta.png" style="width:220px; height:29px;"> </a></td>
                    <td style="text-align: right; width:30px;margin-top:3px;margin-right:3px; border-left:1px solid #ccc;"><a style="border:none;" href="https://www.facebook.com/SkiptaTechnology" target="_blank"><img alt="skipta facebook" src="<?php echo YII::app()->params['ServerURL']; ?>/images/system/fb.png" style="width:24px; height:24px;"> </a></td>
                </tr>
            </table>
            
        </td>
        
    </tr>
    </table>
    </div>