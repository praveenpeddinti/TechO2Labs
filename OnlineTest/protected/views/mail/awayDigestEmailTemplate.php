<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo YII::app()->params['NetworkName']; ?> Newsletter </title>
</head>
<body style="font-family:arial; margin:0 auto">
    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
    	<!-- header -->
        <tr>
        	<td>
            	 <?php 
                 include 'mailContentHeaderTheme.php'
                    ?>
                </td>
           
          </tr>
          <!-- header end -->
          <!-- body content start -->
          <tr>
           <td style="vertical-align:top; padding-bottom: 4px;">
            <table class="device-width" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                                           <tr>
                            <td height="4"  style="font-size:4px;line-height:4px">&nbsp;</td>
                        </tr>
                         <tr>
                             <td style="font-size:12px;padding-top:10px;padding-left:10px;padding-right:10px;font-weight:bold;font-family:arial;color:#535353"> Hello <b style="color:#222222"><?php echo $name ?></b>, 
                             </td>
                         </tr>
                         <tr>
                             <td style="font-size:12px;padding-top:6px;padding-left:10px;padding-right:10px;font-family:arial;color:#535353">
                                     It's been awhile since you've leveraged your specialty community in <?php echo YII::app()->params['NetworkName']; ?>. We've put together a custom feed of recent happenings that you've missed. Take a peak and contribute to the conversation.
                             </td>
                         </tr>
                          <tr>
                            <td height="10" style="font-size:4px;line-height:10px">&nbsp;</td>
                        </tr>
                     </table>   
               
            
           
            
             <?php foreach ($streamObjectList as $streamObject) { 
                                        $moreText='<i class="fa  moreicon moreiconcolor">Read more</i>';
                                        $moreTextwithcss='<i style="color: #fff; background:#474747; border-radius: 3px;font-family: arial !important;font-size: 10px;line-height: 18px !important;padding: 0 5px;line-height: 1;vertical-align: bottom;cursor: pointer;display: inline-block;font-family: FontAwesome;font-style: normal;font-weight: normal;line-height: 1;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;">Read more</i>';
                                        $streamObject->PostText=$newsImage = str_replace($moreText, $moreTextwithcss, $streamObject->PostText);
             
                                        $commonButtonString = "Contribute to the conversation!";
                                        $isMultiImage = $streamObject->IsMultiPleResources > 1 ? "ccc" : "fff";
                                         $redirectUrl=$streamObject->RedirectUrl;
                                            if (isset($streamObject->HtmlFragment) && $streamObject->HtmlFragment != '' ) {
						$pattern = '/(width)="[0-9]*"/';
                                                $newsImage = $streamObject->HtmlFragment;
                                                $newsImage = preg_replace($pattern, "max-width:183px", $newsImage);
			                        $newsImage = str_replace('width:auto', "max-width:183px", $newsImage);
                                                $pattern = '/(height)="[0-9]*"/';
                                                $newsImage = preg_replace($pattern, "height:auto", $newsImage);
                                                 }
                                        ?> 
             
             <table class="device-width" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td class="content-wrapper"  valign="top">
   <!-- post-1curbsid post start  -->
   <table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr >
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/tl_box_s.png) repeat left bottom; height:5px;"></td>
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/t_box_s.png) repeat left bottom; height:5px;"></td>
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/tr_box_s.png) repeat left bottom; height:5px;"></td>
</tr>
<tr >
<td style="background:url(<?php echo $absolutePath ?>/images/system/dailydigest/l_box_s.png) repeat left top; width:5px;"></td>
<td style="background:#fff; height:8px; ">
 <table width="100%"  cellpadding="0" cellspacing="0" border="0" style="border:1px solid #dddddd;">
                             <tr>
                                 <td ><table width="100%" cellpadding="0" cellspacing="0" border="0" style="">
                                 <tr>
                                   <td style="font-family:arial; font-size: 15px; font-weight: bold; color: #5F6468; padding-bottom: 5px;border-bottom:1px solid #D9D9D9;padding-left:10px;padding-right:10px;padding-top:5px">
                                  <a style="font-family:arial; font-size: 15px;display:inline-block;cursor:pointer;text-decoration:none;;color:#535353" href="<?php echo $redirectUrl ?>" target="_blank">
                                                                                         <?php
                                                                                                     if ($streamObject->isGroupAdminPost == 'true' && $streamObject->ActionType == 'Post') {
                                                                                                         echo $streamObject->GroupName;} else {echo $streamObject->FirstUserDisplayName;}
                                                                                                     ?>
                                                                                                 <span style="color:#87898a;font-weight:bold;font-size:15px"> 
                                                                                                 <?php  echo " ".$streamObject->StreamNote ;?></span>
                                                                                                
                                                                                    </a>
                                   </td>
                                   </tr>
                                 </table></td>
                               </tr>
                          
                              <?php include 'DDPostEmailTemplate.php'; ?>
                             <tr><td style="font-family:arial; font-size: 15px; font-weight: bold; color: #5F6468; padding-bottom: 5px;border-top:1px solid #D9D9D9;padding-left:10px;padding-right:10px;padding-top:5px">
                                                                            <table width="100%"  cellpadding="0" cellspacing="0" border="0">
                                                                                <tr>
                                                                                    <td style=";font-size:14px;font-size:arial;font-weight:bold;width:40%">
                                                                                        
                                                                                        <table  cellpadding="0" cellspacing="0" border="0">
                                                                                            <tr>
                                                                                                <td style="width:26px">
                                                                                                    <a style="cursor: pointer;text-decoration: none" href="<?php echo $redirectUrl ?>" target="_blank">
                                                                                                    <img src="<?php echo $absolutePath ?>/images/system/dailydigest/follow.png" alt="Follow" /></a></td>
                                                                                                <td style="vertical-align:middle;padding-right:8px"><?php echo $streamObject->FollowCount ?></td>
                                                                                                <td style="width:26px">
                                                                                                    <a style="cursor: pointer;text-decoration: none" href="<?php echo $redirectUrl ?>" target="_blank">
                                                                                                    <img src="<?php echo $absolutePath ?>/images/system/dailydigest/invite.png" alt="Invite" style="vertical-align:middle"/></a></td>
                                                                                                <td style="vertical-align:middle;padding-right:8px"><?php echo $streamObject->InviteCount ?></td>
                                                                                                <td style="width:26px">
                                                                                                    <a style="cursor: pointer;text-decoration: none" href="<?php echo $redirectUrl ?>" target="_blank"><img src="<?php echo $absolutePath ?>/images/system/dailydigest/love.png" alt="Love" style="vertical-align:middle"/></a></td>
                                                                                                <td style="vertical-align:middle;padding-right:8px"><?php echo $streamObject->LoveCount ?></td>
                                                                                                <td style="width:26px">
                                                                                                    <a style="cursor: pointer;text-decoration: none" href="<?php echo $redirectUrl ?>" target="_blank">
                                                                                                    <img src="<?php echo $absolutePath ?>/images/system/dailydigest/share.png" alt="Share" style="vertical-align:middle"/></a></td>
                                                                                                <td style="vertical-align:middle;padding-right:8px"><?php echo $streamObject->ShareCount ?></td>
                                                                                                <td style="width:26px">
                                                                                                    <a style="cursor: pointer;text-decoration: none" href="<?php echo $redirectUrl ?>" target="_blank"><img src="<?php echo $absolutePath ?>/images/system/dailydigest/comment.png" alt="Comments" style="vertical-align:middle"/></a></td>
                                                                                                <td style="vertical-align:middle;padding-left:2px"><?php echo $streamObject->CommentCount ?></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                        </a>
                                                                                    </td>
                                                                                   
                                                                                </tr>

                                                                            </table>


                                                                        </td></tr>
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
           </td>
          </tr>
    </table>
             <?php }?>
      <!-- post-1 curbsid post end  -->

                             
           </td>
          </tr>
          <!-- footer start -->
          
          
            
          <tr>
              <td height="4" bgcolor="#e5e5e5" style="font-size: 4px; line-height: 4px;">&nbsp;</td>
          </tr>
          <tr>
              <tr>
                            <td height="22" bgcolor="#f5f6f6" style="font-size: 11px; line-height: 22px;font-family:arial;color:#535353;padding:5px 10px "><div style="font-size: 12px; line-height: 13px;font-family:arial;color:#535353;padding:3px 5px 7px 5px ;font-weight:normal"> There's a lot more happening in <?php echo YII::app()->params['NetworkName']; ?>. Stay Connected! </div>
                                <div style="font-size: 12px; line-height: 12px;font-family:arial;color:#535353;padding:5px 5px ;font-weight:bold">Your <?php echo YII::app()->params['NetworkName']; ?> Team.</div></td>
                        </tr>
              
          		 
          </tr>
          <tr>
          <td>
              <table class="device-width" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td height="4" bgcolor="#e5e5e5" style="font-size: 4px; line-height: 4px;">&nbsp;</td>
                        </tr>
                    </table>
                        <!-- Start Footer Bottom Cap -->
                    <table class="device-width" bgcolor="#f5f6f6"  width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            
                            <td style="text-align: left;font-size: 12px; line-height: 24px;padding-left:10px">
<div class="pull-left " style="font-family:arial;">&copy; 2014-2015 </div>
</td>
<td style="text-align: right; padding-top: 3px;" bgcolor="#f5f6f6"><a target="_blank" href="http://skipta.com/" style="border: none;"> <img alt="skipta" src="https://plasticoneworld.com/images/system/poweredbyskipta.png" style="width: 220px; height: 29px;"></a></td>
<td bgcolor="#f5f6f6" style="padding-right:10px;text-align: right; width: 30px; margin-top: 3px; margin-right: 3px; border-left: 1px   solid   #ccc;"><a target="_blank" href="https://www.facebook.com/SkiptaTechnology" style="border: none;"><img alt="skipta" src="https://plasticoneworld.com/images/system/fb.png" style="width: 24px; height: 24px;"></a></td>
                        </tr>
                    </table>

                    <!-- End Footer Bottom Cap -->

                    <!-- Start Footer Meta -->
                    <table class="device-width" width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding-bottom: 10px; font-family:arial; font-size: 14px; color: #ffffff; line-height: 21px; text-align: center;">&nbsp;</td>
                        </tr>
                    </table>
                    <!-- End Footer Meta -->
                        </td>
          
          </tr>
          
          <!-- footer end -->
    </table>
</body>

<body>
</body>
</html>