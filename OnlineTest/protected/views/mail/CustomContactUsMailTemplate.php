
<html>
        <head>
            
        </head>
        <body>
            <div style="margin:auto; width:600px;">
            <div style=" background:#e6e4e4; padding:10px; text-align:left;border-bottom:4px solid "> <img src="<?php echo YII::app()->params['ServerURL'].YII::app()->params['Logo']; ?>" style="border:none	" /></div>
<!--            <p style="font-size:18px; padding-left:5px; font-weight:bold; ">"Hi Skipta @ <?php //echo YII::app()->params['NetworkName']; ?>"</p>-->
            <table cellpadding="0" cellspacing="0" width="100%" border="0" style="padding:5px;">
                <tr>
        <td>
            <?php include 'mailContentHeaderTheme.php';  ?>
        </td>
    </tr>
<tr>
<td style="text-align:left; font-size:14px; width:100px; vertical-align:top; padding-bottom:10px; padding-right:10px">Name :</td>
<td style="text-align:left; font-size:14px; vertical-align:top; font-weight:bold;padding-bottom:10px; "><?php echo $name?></td>
</tr>
<tr>
<td style="text-align:left; font-size:14px; vertical-align:top; padding-bottom:10px; padding-right:10px">Phone :</td>
<td style="text-align:left; font-size:14px; vertical-align:top; font-weight:bold;padding-bottom:10px; "><?php echo $phone?></td>
</tr>
<td style="text-align:left; font-size:14px; vertical-align:top; padding-bottom:10px; padding-right:10px">Email :</td>
<td style="text-align:left; font-size:14px; vertical-align:top; font-weight:bold;padding-bottom:10px; "><?php echo $email?></td>
</tr>
<tr>
<td style="text-align:left; font-size:14px;  vertical-align:top; padding-bottom:10px; padding-right:10px">Preferred Contact Method :</td>
<td style="text-align:left; font-size:14px; vertical-align:top; font-weight:bold;padding-bottom:10px; "><?php echo $contactMethod?></td>
</tr>
</table>
            
     <p style=" padding:25px 0 5px 5px; margin:0px; font-size:14px; font-weight:bold;">Thank you,</p>
<p style=" padding:5px 0 20px 5px; margin:0px; font-size:14px; font-weight:bold;">Skipta Neo  </p>
<div style=" background:#ccc; padding:5px; font-size:14px; color:#777"><?php echo YII::app()->params['COPYRIGHTS']; ?></div>
</div>     

        </body>
        
        
        

       </html>

 