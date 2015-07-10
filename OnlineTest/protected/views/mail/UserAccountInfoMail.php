
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
            <p style="font-size:14px;">Hello <b style="font-size:14px; font-weight:bold;"><?php echo $email ?></b>,</p>
            <p style="font-size:12px; font-weight:normal; padding-top: 20px">Congratulations! Test Date is <?php echo $date ?></p>
            
            <p style="font-size:12px; font-weight:normal; padding-top: 20px">If you have any questions, please contact us at <?php echo YII::app()->params['SendGridFromEmail']; ?>.</p>
        <p style="font-size:12px; font-weight:normal; padding-top: 30px">Thanks,</p>
        <p style="font-size:14px; font-weight:bold; padding: 0px 0 40px 0">Techo2.</p>
        </div>
        </td>
    </tr>
    <tr>
        <td >
            <div style=" background:#F5F6F6; padding:5px 15px 5px 15px; font-size:10px; color:#777; line-height:12px; position:relative">
            <div style="clear:both; display:block; border-bottom:1px solid #ccc; marging:2px 0px"></div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f5f6f6" align="center" style=" margin-top:3px;" >
                <tr>
                    <td style="text-align: left; white-space: nowrap;font-size:14px; line-height:24px;"><?php echo YII::app()->params['COPYRIGHTS']; ?></td>
                    <td style="text-align: right;padding-top:3px; "><a href="http://www.techo2.com" target="_blank" style="border:0;"> <img alt="techO2" src="<?php echo YII::app()->params['ServerURL']; ?>/images/inner_techo2logo.png" style="width:220px; height:29px;"> </a></td>
                    
                </tr>
            </table>
        </div>
        </td>
    </tr>
    
    </table>
    </div>