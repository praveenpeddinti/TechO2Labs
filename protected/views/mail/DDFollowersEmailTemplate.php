<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr >
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/tl_box_s.png) repeat left bottom; height:5px;"></td>
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/t_box_s.png) repeat left bottom; height:5px;"></td>
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/tr_box_s.png) repeat left bottom; height:5px;"></td>
</tr>
<tr >
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/l_box_s.png) repeat left top; width:5px;"></td>
<td style="background:#fff;">

<table width="100%"  cellpadding="0" cellspacing="0" border="0" style="border:1px solid #dddddd;">
    <tr>
        <td ><table width="100%"  cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td >
                        
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                
                                <td style="font-family:arial; font-size: 15px; font-weight: bold; color: #5F6468; padding-bottom: 5px;border-bottom:1px solid #D9D9D9;padding-left:10px;padding-right:10px;padding-top:5px">
                                    <a style="font-family:arial; font-size: 15px;display:inline-block;cursor:pointer;text-decoration:none;;color:#535353" target="_blank" href="<?php echo $redirectUrl ?>" >
                                    The Below users<span style="color:#87898a;font-weight:bold;font-size:15px">  are currently following you</span></a></td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-family:arial; font-size: 12px; color: #5a5e65; line-height: 16px;padding-left:10px;padding-right:10px;text-align:center ;padding-top:5px;padding-bottom:5px">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <?php
                                $ppic = 1;
                                foreach ($streamObject as $userCObj) {
                                    $redirecturl=Yii::app()->params['ServerURL']."/profile/".$userCObj->DisplayName;
                                    ?> 
                                    <td style="padding:5px 20px 5px 5px;vertical-align:top;" align="center">
                                        
                                        <table cellpadding="0" cellspacing="0" border="0" >
                                            
                                            <tr>
                                                <td style="border:1px solid #ccc;padding:3px;vertical-align:top;">
                                                    <div style="min-height:30px;;width:45px">
                                                        <a style="cursor: pointer;text-decoration: none" target="_blank" href="<?php echo $redirecturl;?>">
                                                        <img style="width:45px;height: 34px" src="<?php echo $userCObj->profile45x45 ?>" /></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <a style="cursor: pointer;text-decoration: none" target="_blank" href="<?php echo $redirecturl;?>">
                                        <div style="font-family:arial; font-size: 12px; color: #5a5e65;font-weight:bold"><?php echo $userCObj->DisplayName ?></div> </a>
                                        
                                     </td>
                                    <?php if (($ppic % 6) == 0) { ?></tr><tr><?php
                                    } $ppic++;
                                }
                                ?>
                                

                            </tr>
                        </table>                                                      </td>
                </tr>

            </table>



        </td></tr>
    <tr>
        <td style="text-align:right;padding:5px;border-top:1px solid #D9D9D9">
            <a style="display:inline-block;text-align:left;background:#6abf40;border:1px solid #57a52b;padding:0px;color:#fff;font-size:13px;font-family:arial;font-weight:normal;cursor:pointer;text-decoration:none;padding-right:3px" href="<?php echo $redirectUrl ?>" target="_blank">    
                <img src="<?php echo $absolutePath ?>/images/system/dailydigest/button_arrow.png" style="vertical-align:middle;border:0;padding-right:5px" />Add followers to your network!   </a>    
        </td>
    </tr>
</table>
    </td>
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/r_box_s.png) repeat left top; width:5px;"></td>
</tr>
<tr >
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/bl_box_s.png) repeat left top; width:5px;"></td>
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/b_box_s.png) repeat left top; height:5px;"></td>
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/br_box_s.png) repeat left top; width:5px;"></td>
</tr>
</table>