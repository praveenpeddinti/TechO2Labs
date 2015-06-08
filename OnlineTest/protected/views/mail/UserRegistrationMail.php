
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
            <p style="font-size:14px;">Hello <b style="font-size:14px; font-weight:bold;"><?php echo $myMail ?></b>,</p>
            <p style="font-size:12px; font-weight:normal; padding-top: 20px">Thank you for registering for <b> <?php echo YII::app()->params['NetworkName']; ?> </b> Network. We are currently validating your credentials. This process typically takes 1 to 2 business days. </p>
            <p style="font-size:12px; font-weight:normal; padding-top: 15px">We will notify you regarding the activation of your account on <?php echo YII::app()->params['NetworkName']; ?> as soon as the verification process is complete.</p>
            <p style="font-size:12px; font-weight:normal; padding-top: 15px">If you have any questions regarding your registration, please contact us at <a target="_blank" href="<?php echo YII::app()->params['SendGridFromEmail']; ?>"><?php echo YII::app()->params['SendGridFromEmail']; ?></a></p>
        
        <p style="font-size:12px; font-weight:normal; padding-top: 25px">Thanks,</p>
        <p style="font-size:14px; font-weight:bold; padding: 0px 0 40px 0">The Skipta Team</p>
        </div>
        </td>
    </tr>
    <tr>
        <td >
            <div style=" background:#F5F6F6; padding:5px 15px 5px 15px; font-size:10px; color:#777; line-height:12px; position:relative">
            <p>Skipta develops verified medical specialist communities to enhance real-time collaboration and communication among medical practitioners. We work directly with these communities to create networks by the professional, for the professional.</p>
            <div style="clear:both; display:block; border-bottom:1px solid #ccc; marging:2px 0px"></div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f5f6f6" align="center" style=" margin-top:3px;" >
                <tr>
                    <td style="text-align: left; white-space: nowrap;font-size:14px; line-height:24px;"><?php echo YII::app()->params['COPYRIGHTS']; ?></td>
                    <td style="text-align: right;padding-top:3px; "><a href="http://skipta.com/" target="_blank" style="border:none;"> <img alt="skipta" src="<?php echo YII::app()->params['ServerURL']; ?>/images/system/poweredbyskipta.png" style="width:220px; height:29px;"> </a></td>
                    <td style="text-align: right; width:30px;margin-top:3px;margin-right:3px; border-left:1px solid #ccc;"><a style="border:none;" href="https://www.facebook.com/SkiptaTechnology" target="_blank"><img alt="skipta" src="<?php echo YII::app()->params['ServerURL']; ?>/images/system/fb.png" style="width:24px; height:24px;"> </a></td>
                </tr>
            </table>
        </div>
        </td>
    </tr>
    
    </table>
    </div>