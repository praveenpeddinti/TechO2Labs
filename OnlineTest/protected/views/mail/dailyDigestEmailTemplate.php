<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>email</title>

</head>
<body  style="background:#fff">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="100%" valign="top" style="padding-top:10px">
       
         <!-- Borderboxarea start here -->
         <table  cellpadding="0" cellspacing="0" border="0" style="width:600px;margin:auto;border:1px solid #e7e7ea">
         <tr>
         <td>
           <!-- Logo area start -->
           <table  width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
				  <td class="content-wrapper" width="100%" style="padding-top: 0px; padding-right: 30px; padding-bottom: 0px; padding-left: 30px;background:#bfd819" >
					<!-- Start Logo -->
					<table align="center" cellpadding="0" cellspacing="0" border="0">
							<tr>
                                                            <td class="center" style="padding: 5px"><img src="<?php echo $absolutePath ?>/images/system/trinity_logo.png" /></td>
							</tr>
					</table>
							<!-- End Logo -->
                    </td>
				</tr>
                </table>
         <!-- Logo area end -->
         <!-- hello area-->
          <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="font-size:13px;font-weight:bold;padding-top:10px;padding-left:10px;padding-right:10px;font-family:arial;color:#5A5E65"> Hello <?php echo $name?>, <br>
                                                We have compiled a digest of recent activity from your <?php echo YII::app()->params['NetworkName']; ?>  account. This digest is specific to you and your activities on the network.
                                        </td>
				</tr>
			</table>
         <!-- hello area end -->
         <!--Featured Items -->
         
        <?php if (isset($featuredDisplayBean->PostId)){?> 
          <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;">
                     <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e7e7ea">
                          <tr>
                            <td ><table width="100%"  cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                  <td ><table width="100%" cellpadding="0" cellspacing="0" border="0">
                                      <tr>
                                      <?php if($featuredDisplayBean->Type==5){?> 
                                          <td style="font-family:arial; font-size: 11px; font-weight: bold; color: #5F6468; padding-bottom: 5px;border-bottom:1px solid #D9D9D9;padding-left:10px;padding-right:10px;padding-top:5px"><?php echo $featuredDisplayBean->PostBy ?> has posted a Curbside Consult <?php echo  $featuredDisplayBean->StreamNote ?> </td>
                                      <?php }else {?>
                                           <td style="font-family:arial; font-size: 11px; font-weight: bold; color: #5F6468; padding-bottom: 5px;border-bottom:1px solid #D9D9D9;padding-left:10px;padding-right:10px;padding-top:5px"><?php echo $featuredDisplayBean->PostBy ?> has posted featured Item </td>
                                      <?php }?>   
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td style="font-family:arial; font-size: 12px; color: #5a5e65; line-height: 14px;padding-left:7px;padding-right:7px;padding-top:3px;padding-bottom:3px"><table width="100%"  cellpadding="0" cellspacing="0" border="0">
                                      <tr>
                                          <?php if($featuredDisplayBean->ArtifactIcon!='No'){?>
                                          <td style="width:150px;padding:5px 10px 5px 0;vertical-align:top"><a href="<?php echo $featuredDisplayBean->WebUrls ?>"><img style="width:150px" src="<?php echo $featuredDisplayBean->ArtifactIcon?>" /></a></td>
                                          <?php }?> 
                                        <td style="vertical-align:top;font-size:11px;font-family:arial; font-size: 11px; "><?php echo $featuredDisplayBean->PostText ?>
                                            <a href="<?php echo $featuredDisplayBean->WebUrls ?>"><img alt="see more" title="see more" src=<?php echo $absolutePath ?>"/DailyDigestImages/seemore.png" style="border:0" /></a> 
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            
                                       <?php if($featuredDisplayBean->Type==5){?>     
                                      <td align="right" style="text-align:right;padding-top:10px"><a href="#" style="color:#0068b4;font-family:arial; font-size: 11px; font-weight:bold;text-decoration:none"><?php echo $featuredDisplayBean->CategoryType?></a></td>
                                       <?php }?>
                                      </tr>
                                        </table>
                                        </td>
                                      </tr>
                                      
                                  </table></td>
                                </tr>
                            </table></td>
                          </tr>
                      </table>
                    </td>
				</tr>
			</table>
        <?php }?>
    <!--Featured Items Ends-->     
             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
				  <td style="padding-left:10px;padding-right:10px;padding-bottom:10px;vertical-align:top">
           <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
            <?php if($commentBeanForLove->Comments!='NoLove'){?>
            <td style="width:284px;vertical-align:top;border:1px solid #D9D9D9" width="284">
            <!-- -->
            
           
                 <!-- Love starts -->                  
             <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
             <tr>
             <td style="border-bottom:1px solid #D9D9D9;">
              <table cellpadding="0" cellspacing="0" border="0" >
             <tr>
             <td style="padding:5px;height:24px"><img src="<?php echo $absolutePath ?>/DailyDigestImages/social_icons.png" alt="Love" /></td>
             <td style="font-size:14px;font-weight:bold;font-family:arial;color:#5A5E65;">Love</td>
             </tr>
             </table>
             <!-- -->
             
             <!-- -->
             </td>
             </tr>
          
             <tr>
             <td>
             <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                  <td style="font-family:arial; font-size: 12px; color: #5a5e65; line-height: 14px;padding-left:7px;padding-right:7px;padding-top:3px;padding-bottom:3px"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                      <tbody><tr>
                                              
                                              <?php if(isset($commentBeanForLove->Artifacts)){?>
                                              <td style="width:80px;padding:5px 10px 5px 0;vertical-align:top"><a href="<?php echo $commentBeanForLove->WebUrls ?>"><img src="<?php echo $absolutePath ?><?php echo $commentBeanForLove->Artifacts ?>" style="width:80px"></a></td>
                                              <?php }?>
                                        <td style="vertical-align:top;font-size:11px;font-family:arial; font-size: 11px;color: #5a5e65; "><?php echo $commentBeanForLove->Comments ?>
                                        <a href="<?php echo $commentBeanForLove->WebUrls ?>"><img style="border:0" src="<?php echo $absolutePath ?>/DailyDigestImages/seemore.png" title="see more" alt="see more"></a> 
                                       
                                        </td>
                                      </tr>
                                      
                                  </tbody></table></td>
                                </tr>
                            </tbody></table>
                            <!-- -->
                           <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            <td style="padding:5px 7px">
                             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            <td style="border-top:1px dotted #ccc;border-bottom:1px dotted #ccc;padding:4px 2px;font-size:11px;font-family:arial;font-weight:bold;color: #5a5e65;"><?php echo $commentBeanForLove->CommentText ?><span style="color:#9a9a9a"> loved</span> <span style="font-weight:normal">your post</span> </td>
                            </tr>
                            </table>
                            
                            </td>
                            </tr>
                            <tr>
                                <td  style="padding:0px 7px 5px">
                             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <?php if($commentBeanForLove->CommentMoreText!='No'){?>
                                
                            <td style="padding:0px 2px;font-size:11px;font-family:arial;font-weight:bold;color: #5a5e65;"><?php echo $commentBeanForLove->CommentMoreText ?>  
                                
                                and  others  also 
                                
                                <span style="color:#9a9a9a">loved</span> <span style="font-weight:normal">
                                    <?php if($commentBeanForLove->CommentMoreUsersCount!=0){
                                    echo $commentBeanForLove->CommentMoreUsersCount;
                                  }?>
                                    your activities</span> 
                            
                            
                            </td>
                                <?php }?>
                            </tr>
                            </table>
                            
                            </td>
                            </tr>
                            </table>
                            <!-- -->
             </td>
             </tr>
             </table>
           
            <!-- -->
           <!-- Love Ends -->  
            </td>
                 <?php }?>    
            <td style="width:10px;" width="10" >
            </td>
                 <?php if($commentArray->Comments!='NoComments'){?>       
             <td style="width:284px;vertical-align:top;border:1px solid #D9D9D9" width="284"><!-- -->
                 
                      <!-- Comment starts -->  
              
             <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
             <tr>
             <td style="border-bottom:1px solid #D9D9D9;">
              <table cellpadding="0" cellspacing="0" border="0" >
             <tr>
             <td style="padding:5px;height:24px"><img src="<?php echo $absolutePath ?>/DailyDigestImages/comments.png" alt="Comments" /></td>
             <td style="font-size:14px;font-weight:bold;font-family:arial;color:#5A5E65;">Comments</td>
             </tr>
             </table>
             <!-- -->
             
             <!-- -->
             </td>
             </tr>
             <tr>
             <td>
             <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                  <td style="font-family:arial; font-size: 12px; color: #5a5e65; line-height: 14px;padding-left:7px;padding-right:7px;padding-top:3px;padding-bottom:3px"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                      <tbody><tr>
                                              <?php if(isset($commentArray->Artifacts)){?>
                                              <td style="width:80px;padding:5px 10px 5px 0;vertical-align:top">
                                                  <a href="<?php echo $commentArray->WebUrls ?>">
                                                      <img src="<?php echo $absolutePath ?><?php echo $commentArray->Artifacts ?>" style="width:80px"/>
                                              </a></td><?php }?>
                                        <td style="vertical-align:top;font-size:11px;font-family:arial; font-size: 11px;color: #5a5e65; "><?php echo $commentArray->Comments ?>
                                        <a href="<?php echo $commentArray->WebUrls ?>"><img style="border:0" src="<?php echo $absolutePath ?>/DailyDigestImages/seemore.png" title="see more" alt="see more"></a> 
                                       
                                        </td>
                                      </tr>
                                      
                                  </tbody></table></td>
                                </tr>
                            </tbody></table>
                            <!-- -->
                           <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            <td style="padding:5px 7px">
                             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            <td style="border-top:1px dotted #ccc;border-bottom:1px dotted #ccc;padding:4px 2px;font-size:11px;font-family:arial;font-weight:bold;color: #5a5e65;"><?php echo $commentArray->CommentText ?>  <span style="color:#9a9a9a">  commented </span> <span style="font-weight:normal">on your activity</span> </td>
                            </tr>
                            </table>
                            
                            </td>
                            </tr>
                            <tr>
                            <td style="padding:0px 7px 5px">
                             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <?php if($commentArray->CommentMoreText!='No'){?>
                                
                            <td style="padding:0px 2px;font-size:11px;font-family:arial;font-weight:bold;color: #5a5e65;"><?php echo $commentArray->CommentMoreText ?>  
                                <?php if($commentArray->CommentMoreUsersCount!=0){?>
                                and <?php echo $commentArray->CommentMoreUsersCount ?> others 
                                <?php }?>
                                also 
                                <span style="color:#9a9a9a">commented </span> <span style="font-weight:normal">on  your activities </span>
                               
                            </td>
                                <?php }?>
                            </tr>
                            </table>
                            
                            </td>
                            </tr>
                            </table>
                            <!-- -->
             </td>
             </tr>
             </table>
         
                      <!-- Comment Ends -->  
            <!-- -->
            </td>
                   <?php }?>       
            </tr>
            </table>
            </td>
				</tr>
			</table>
             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="padding-left:10px;padding-right:10px;padding-bottom:10px;vertical-align:top">
           <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
            <?php if($commentBeanForFollowed->Comments!='NoActivityFollowed'){?>  
            <td style="width:284px;vertical-align:top;border:1px solid #D9D9D9" width="284">
            <!-- -->
            <!-- Activity Followed starts -->  
             
             <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
             <tr>
             <td style="border-bottom:1px solid #D9D9D9;">
              <table cellpadding="0" cellspacing="0" border="0" >
             <tr>
             <td style="padding:5px;height:24px"><img src="<?php echo $absolutePath ?>/DailyDigestImages/followers.png" alt="Followers" /></td>
             <td style="font-size:14px;font-weight:bold;font-family:arial;color:#5A5E65;">Followers</td>
             </tr>
             </table>
             <!-- -->
             
             <!-- -->
             </td>
             </tr>
             <tr>
             <td>
             <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                  <td style="font-family:arial; font-size: 12px; color: #5a5e65; line-height: 14px;padding-left:7px;padding-right:7px;padding-top:3px;padding-bottom:3px"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                      <tbody><tr>
                                               <?php if(isset($commentBeanForFollowed->Artifacts)){?>
                                        <td style="width:80px;padding:5px 10px 5px 0;vertical-align:top"><img src="<?php echo $absolutePath ?><?php echo $commentBeanForFollowed->Artifacts ?>" style="width:80px"/></td>
                                               <?php }?>
                                        <td style="vertical-align:top;font-size:11px;font-family:arial; font-size: 11px;color: #5a5e65; "><?php echo $commentBeanForFollowed->Comments ?>
                                        <a href="<?php echo $commentBeanForFollowed->WebUrls ?>"><img style="border:0" src="<?php echo $absolutePath ?>/DailyDigestImages/seemore.png" title="see more" alt="see more"></a> 
                                       
                                        </td>
                                      </tr>
                                      
                                  </tbody></table></td>
                                </tr>
                            </tbody></table>
                            <!-- -->
                           <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            <td style="padding:5px 7px">
                             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            <td style="border-top:1px dotted #ccc;border-bottom:1px dotted #ccc;padding:4px 2px;font-size:11px;font-family:arial;font-weight:bold;color: #5a5e65;"><?php echo $commentBeanForFollowed->CommentText ?> is   <span style="color:#9a9a9a">following </span> <span style="font-weight:normal">your activity</span> </td>
                            </tr>
                            </table>
                            
                            </td>
                            </tr>
                            <tr>
                            <td style="padding:0px 7px 5px">
                             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                               <?php if($commentBeanForFollowed->CommentMoreText!='No'){?>
                                
                            <td style="padding:0px 2px;font-size:11px;font-family:arial;font-weight:bold;color: #5a5e65;"><?php echo $commentBeanForFollowed->CommentMoreText ?> 
                                
                               <?php if($commentBeanForFollowed->CommentMoreUsersCount!=0) {?>
                                and <?php echo $commentBeanForFollowed->CommentMoreUsersCount ?> 
                                others  are  
                                <span style="color:#9a9a9a">following </span> <span style="font-weight:normal">                                   
                                    your activities                                 
                                </span>
                               <?php }else{?>
                                  <span style="color:#9a9a9a">is also following </span> <span style="font-weight:normal">                                   
                                    your other activity                                 
                                </span> 
                              <?php }?>
                            </td>
                               <?php }?>
                            </tr>
                            </table>
                            
                            </td>
                            </tr>
                            </table>
                            <!-- -->
             </td>
             </tr>
             </table>
           
            <!-- Activity Followed Ends -->  
            <!-- -->
           
            </td>
                
              <?php }?>   
            <td style="width:10px;" width="10" >
            </td>
             <?php if($commentBeanForMention->Comments!='NoMentions'){?>     
             <td style="width:284px;vertical-align:top;border:1px solid #D9D9D9" width="284"><!-- -->
         <!-- Mention starts -->   
        
             <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
             <tr>
             <td style="border-bottom:1px solid #D9D9D9;">
              <table cellpadding="0" cellspacing="0" border="0" >
             <tr>
             <td style="padding:5px;height:24px"><img src="<?php echo $absolutePath ?>/DailyDigestImages/atmentions.png" alt="Mentions" /></td>
             <td style="font-size:14px;font-weight:bold;font-family:arial;color:#5A5E65;">Mentions</td>
             </tr>
             </table>
             <!-- -->
             
             <!-- -->
             </td>
             </tr>
             <tr>
             <td>
             <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                <tr>
                                  <td style="font-family:arial; font-size: 12px; color: #5a5e65; line-height: 14px;padding-left:7px;padding-right:7px;padding-top:3px;padding-bottom:3px"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                                      <tbody><tr>
                                              <?php if(isset($commentBeanForMention->Artifacts)){?>                                              
                                              <td style="width:80px;padding:5px 10px 5px 0;vertical-align:top"><a href="<?php echo $commentBeanForMention->WebUrls ?>"><img src="<?php echo $absolutePath ?><?php echo $commentBeanForMention->Artifacts ?>" style="width:80px"/></a></td>
                                              <?php }?>
                                        <td style="vertical-align:top;font-size:11px;font-family:arial; font-size: 11px;color: #5a5e65; "><?php echo $commentBeanForMention->Comments ?>
                                        <a href="<?php echo $commentBeanForMention->WebUrls ?>"><img style="border:0" src="<?php echo $absolutePath ?>/DailyDigestImages/seemore.png" title="see more" alt="see more"></a> 
                                       
                                        </td>
                                      </tr>
                                      
                                  </tbody></table></td>
                                </tr>
                            </tbody></table>
                            <!-- -->
                           <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            <td style="padding:5px 7px">
                             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            <td style="border-top:1px dotted #ccc;border-bottom:1px dotted #ccc;padding:4px 2px;font-size:11px;font-family:arial;font-weight:bold;color: #5a5e65;"><?php echo $commentBeanForMention->CommentText ?>  <span style="color:#9a9a9a">Mentioned  </span> <span style="font-weight:normal">In a Post</span> </td>
                            </tr>
                            </table>
                            
                            </td>
                            </tr>
                            <tr>
                            <td style="padding:0px 7px 5px">
                             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                             <?php if($commentBeanForMention->CommentMoreText!='No'){ ?>   
                            <td style="padding:0px 2px;font-size:11px;font-family:arial;font-weight:bold;color: #5a5e65;"><?php echo  $commentBeanForMention->CommentMoreText ?>   have  <span style="color:#9a9a9a">invited or mentioned </span> <span style="font-weight:normal">
                                    
                              in 
                              <?php  if($commentBeanForMention->CommentMoreUsersCount!=0){
                                   echo $commentBeanForMention->CommentMoreUsersCount;
                              } else{ ?>
                                other
                              <?php }?>
                                  
                              activities  </span> </td>
             <?php }?>
                            </tr>
                            </table>
                            
                            </td>
                            </tr>
                            </table>
                            <!-- -->
             </td>
             </tr>
             </table>
       
          <!-- Mention Ends -->
            <!-- -->
            </td>
                  <?php }?>  
            </tr>
            </table>
            </td>
				</tr>
			</table>
             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
               <tr>
                 <td style="font-size:12px;font-weight:bold;padding-bottom:5px;padding-left:10px;padding-right:10px;font-family:arial;color:#5A5E65">If you would like to opt out of receiving daily digest emails, you are able to do so within the settings of your <?php echo YII::app()->params['NetworkName']; ?> account. </td>
               </tr>
             </table>
             <table  style="width:100%" cellpadding="0" cellspacing="0" border="0">
               <tr>
                   <td style="font-size:12px;font-weight:normal;padding-bottom:10px;padding-left:10px;padding-right:10px;font-family:arial;color:#5A5E65">Regards,<br> The Skipta Team</td>
               </tr>
             </table>
             </td>
         </tr>
         </table>
         <br><br>
        <!--Borderboxarea end here -->
        <!--footer Bar --><div style=" background:#F5F6F6; padding:5px 15px 5px 15px; font-size:10px; color:#777; line-height:12px; position:relative">
            <p>Skipta develops verified medical specialist communities to enhance real-time collaboration and communication among medical practitioners. We work directly with these communities to create networks by the professional, for the professional.</p>
            <div style="clear:both; display:block; border-bottom:1px solid #ccc; marging:2px 0px"></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f5f6f6" align="center" style=" margin-top:3px;" >
                <tr>
                    <td style="text-align: left; white-space: nowrap;font-size:14px; line-height:24px;"><?php echo YII::app()->params['COPYRIGHTS']; ?></td>
                    
                </tr>
            </table>
        </div>
        <table  style="width:600px" align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td height="7"  style="height:4px;font-size: 5px; line-height: 4px;background:#bfd819">&nbsp;</td>
				</tr>
			</table>
         <!-- footer bar end -->
        </td>
        </tr>
        </table>

</body>
</html>