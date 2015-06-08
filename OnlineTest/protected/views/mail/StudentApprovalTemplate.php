
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td style="vertical-align:top">
<table cellpadding="0" cellspacing="0" border="0" style="width:600px;margin:auto">
<tr>
<td style="vertical-align:top">
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<!-- Banner -->
 <?php include 'HdsUsermailContentHeaderTheme.php';  ?>
<!-- Banner End -->
<!-- content area -->
<tr>
<td style="vertical-align:top">
<div style="padding-top:30px;padding-right:50px;padding-bottom:30px;padding-left:50px;">
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">

<tr>
<td style="vertical-align:top;font-family:Myriad Pro,Arial, Helvetica, sans-serif;font-size:15px;font-weight:normal;color:#333;padding-bottom:15px">
Hello <?php echo $myMail; ?>,
</td>
</tr>
<tr>
<td style="vertical-align:top;font-family:Myriad Pro,Arial, Helvetica, sans-serif;font-size:15px;font-weight:normal;color:#333;padding-bottom:25px">
Thank you for your interest in <?php echo YII::app()->params['NetworkName'] ;?>! You’re one step away from having full access to an online medical community for verified <?php echo Yii::app()->params['Specialists']; ?> that enables communication, consultation and information exchange within a private and secure platform.  

</td>
</tr>

<tr>
    <td style="vertical-align:top;font-family:Myriad Pro,Arial, Helvetica, sans-serif;font-size:15px;font-weight:normal;color:#333;padding-bottom:15px">
        To activate your membership, please use the following link:
    </td>
</tr>
<tr>
    <td style="vertical-align:top;font-family:Myriad Pro,Arial, Helvetica, sans-serif;font-size:15px;font-weight:normal;color:#333;padding-bottom:25px">
<a href="<?php echo YII::app()->params['ServerURL']; ?>/common/verifyStudentAccount?linkcode=<?php echo $code; ?>&em=<?php echo $email ?>" target="_blank" style="font-family:Myriad Pro,Arial, Helvetica, sans-serif;font-size:20px;font-weight:bold;color:#1f93cc;text-decoration:none;line-height:20px">
    Activation link</a>
    </td>
</tr>
<tr>
    <td style="vertical-align:top;font-family:Myriad Pro,Arial, Helvetica, sans-serif;font-size:15px;font-weight:normal;color:#333;padding-bottom:25px">
        You will be notified when the verification process is complete and your membership is active.  Membership in <?php echo YII::app()->params['NetworkName'] ;?> is provided completely free of charge to all <?php echo Yii::app()->params['Specialists']; ?>.
    </td>
</tr>
<tr>
<td style="vertical-align:top;font-family:Myriad Pro,Arial, Helvetica, sans-serif;font-size:15px;font-weight:normal;color:#333;padding-bottom:25px">
If you feel you have received this message in error or if you have any questions, please contact us at <a href="mailto:<?php echo YII::app()->params['NetworkAdminEmail'] ;?>" target="_top"><?php echo YII::app()->params['NetworkAdminEmail'] ;?></a>.
</td>
</tr>
<tr>
<td  style="vertical-align:top;font-family:Myriad Pro,Arial, Helvetica, sans-serif;font-size:15px;font-weight:normal;color:#333">
Thanks,
</td>
</tr>
<tr>
<td  style="vertical-align:top;font-family:Myriad Pro,Arial, Helvetica, sans-serif;font-size:15px;font-weight:normal;color:#333">
<?php echo YII::app()->params['NetworkName'] ;?>

</td>
</tr>
<!----------Footer------------------------------>
<?php include 'HdsUsermailContentFooterTheme.php';  ?>
<!----------Footer------------------------------>

</table>


</div>
</td>
</tr>
<!-- content area End -->

</table>

</td>
</tr>
</table>
</td>
</tr>
</table>