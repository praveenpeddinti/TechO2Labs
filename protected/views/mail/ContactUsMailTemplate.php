
<html>
        <head>
            
        </head>
        <body>
            <div style="margin:auto; width:600px;">
            <div style=" background:#e6e4e4; padding:10px; text-align:left;border-bottom:4px solid "> <img src="<?php echo YII::app()->params['ServerURL'].YII::app()->params['Logo']; ?>" style="border:none	" /></div>
            <p style="font-size:18px; padding-left:5px; font-weight:bold; ">"Hi Skipta @ <?php echo YII::app()->params['NetworkName']; ?>"</p>
            <table cellpadding="0" cellspacing="0" width="100%" border="0" style="padding:5px;">
<tr>
<td style="text-align:left; font-size:14px; width:100px; vertical-align:top; padding-bottom:10px; padding-right:10px">First Name :</td>
<td style="text-align:left; font-size:14px; vertical-align:top; font-weight:bold;padding-bottom:10px; "><?php echo $firstName?></td>
</tr>
<tr>
<td style="text-align:left; font-size:14px; vertical-align:top; padding-bottom:10px; padding-right:10px">Last Name :</td>
<td style="text-align:left; font-size:14px; vertical-align:top; font-weight:bold;padding-bottom:10px; "><?php echo $lastName?></td>
</tr>
<td style="text-align:left; font-size:14px; vertical-align:top; padding-bottom:10px; padding-right:10px">Occupation :</td>
<td style="text-align:left; font-size:14px; vertical-align:top; font-weight:bold;padding-bottom:10px; "><?php echo $occupation?></td>
</tr>
<tr>
<td style="text-align:left; font-size:14px;  vertical-align:top; padding-bottom:10px; padding-right:10px">Address :</td>
<td style="text-align:left; font-size:14px; vertical-align:top; font-weight:bold;padding-bottom:10px; "><?php echo $address?></td>
</tr>
<tr>
<td style="text-align:left; font-size:14px;  vertical-align:top; padding-bottom:10px; padding-top:10px" colspan="2">Message  :<?php echo $message?></td>
</tr>
</table>
            
     <p style=" padding:25px 0 5px 5px; margin:0px; font-size:14px; font-weight:bold;">Thank you</p>
<p style=" padding:5px 0 20px 5px; margin:0px; font-size:14px; font-weight:bold;"><?php echo $firstName?>   </p>
<div style=" background:#ccc; padding:5px; font-size:14px; color:#777"><?php echo YII::app()->params['COPYRIGHTS']; ?></div>
</div>     

        </body>
        
        
        

       </html>

 