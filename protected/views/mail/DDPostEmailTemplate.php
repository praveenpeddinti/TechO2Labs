
<!--Post divider starts -->

<tr>
    <td style="font-family:arial; font-size: 12px; color: #5a5e65; line-height: 16px;padding-left:10px;padding-right:10px;padding-top:5px;padding-bottom:5px">
        
        <table width="100%"  cellpadding="0" cellspacing="0" border="0">
            <tr> 
                <?php if ((isset($streamObject->Resource) && isset($streamObject->Resource['ThumbNailImage'])  && $streamObject->Resource['ThumbNailImage'] != "" && (!$streamObject->IsSurveyTaken))||$streamObject->HtmlFragment != '' ) { ?>
                    <td style="width:200px;padding:5px 10px 5px 0;vertical-align:top">
                        <table width="100%"  cellpadding="0" cellspacing="0" border="0" >
                            <tr>
                                <td style="border:1px solid #ccc;padding:3px;vertical-align:top;">
                                    <a style="cursor: pointer;text-decoration: none" href="<?php echo $redirectUrl ?>" target="_blank">
                                    <div style="border:4px solid #<?php echo $isMultiImage; ?>;min-height:70px;text-align:center">
 				       <?php if ($streamObject->HtmlFragment != '' ) { ?>
				         <?php    
				              echo $newsImage;
                                        ?>
                                        <?php }else{ 
                                            $imageurl=$streamObject->Resource['ThumbNailImage'];
                                            $extension=$streamObject->Resource['Extension'];
                                        if ($extension == "mp4" || $extension == "avi" || $extension == "flv" || $extension == "mov" || $extension == "mp3") {
                                            $imageurl="/images/system/dailydigest/noviedoimage.png";
                                        }
                                        ?>
                                        <img style="max-width:183px;" src="<?php echo $absolutePath .$imageurl;  ?>" />
					<?php } ?>
                                    </div></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                <?php }?>
                   
                <!--normal post divider starts -->
                <?php  if ($streamObject->PostType != 2) { ?>
                    <td style="vertical-align:top;color:#000">
                        <a style="cursor: pointer;text-decoration: none;color:#000" href="<?php echo $redirectUrl ?>" target="_blank">
                        <?php echo $streamObject->PostType != 12?'':$streamObject->GameName."<br/>"; ?>
                        <?php echo $streamObject->PostText ?>    
                    <?php if($streamObject->PostType==5){ ?><div style="font-family:arial; font-size: 12px; color: #336699;font-weight:bold;text-align:right;padding-top:5px;"><?php echo strip_tags($streamObject->CurbsideConsultCategory); ?></div><?php }?> </a> 
                     <?php if($streamObject->PostType==12){ ?>
                          <?php $gameimg="mail_g_playnow.png";
                                 if ($streamObject->GameStatus == "resume") {
                                  $gameimg="mail_g_resume.png"; 
                                } else if ($streamObject->GameStatus == "view") {
                                    $gameimg="mail_g_view.png"; 
                                }
                                ?> <?php if ($streamObject->GameStatus != "future") { ?>
                        <br/><div style="text-align:right;padding-top:5px;"><a href="<?php echo $redirectUrl ?>" target="_blank">
                                        <img  src="<?php echo "https://skiptaneo.com"."/images/system/dailydigest/".$gameimg ?>" />
                                        </a></div>
                <?php } ?>
                         <?php }?>
                      </td><?php }?>
                <!--normal post divider ends -->

                <!--event post divider starts -->
                    <?php if ($streamObject->PostType == 2) { ?>
                <td style="vertical-align:top">
                    <?php if (isset($streamObject->Resource) && isset($streamObject->Resource['ThumbNailImage']) && $streamObject->Resource['ThumbNailImage'] != "") { ?>
                    <a style="cursor: pointer;text-decoration: none;color:#000" href="<?php echo $redirectUrl ?>" target="_blank">
                    <div style="padding-bottom:5px;color:#000"><?php echo $streamObject->PostText; ?>
                   </div></a> <?php }?>
                    
                    <table  cellpadding="0" cellspacing="0" style="border:4px solid #e8e8e8;">
                        <tr>
                            <td style="vertical-align: top">
                             <table  cellpadding="5px" cellspacing="0" style="width:100%" >
                            <tr>
                                <td style="text-align:center;padding:5px;width:<?php if ($streamObject->StartDate != $streamObject->EndDate) { ?>50%  <?php }?>">
                                    <table  cellpadding="0" cellspacing="0" style="margin:auto;width:100%" >
                                        <tr>
                                            <td style="text-align:center;">
                                                <!-- -->
                                                <table cellpadding="0" cellspacing="0" style="border:1px solid #fd9f1b;width:100%">
                                                    <tr>
                                                        <td style="padding:5px;text-align:center;font-size:12px;color:#fff;font-family:arial;font-weight:bold;background:#fd9f1b">
                                                             
                                                             <?php echo $streamObject->EventStartMonth; ?><?php echo $streamObject->StartDate != $streamObject->EndDate ? " " : "-"; ?><?php echo $streamObject->EventStartYear; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px;text-align:center;font-size:16px;color:#333;font-family:arial;font-weight:bold;background:#fff">
                                                            <div style="color:#333;font-size:16px"><?php echo $streamObject->EventStartDay; ?></div>
                                                                <div style="color:#fd9f1b;font-size:14px"><?php echo strip_tags($streamObject->EventStartDayString); //day name ?></div>
                                                        </td>
                                                    </tr>

                                                </table>
                                                <!-- -->
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                                <?php if ($streamObject->StartDate != $streamObject->EndDate) { ?>
                                <td style="text-align:center;width:50%">
                                    <table cellpadding="0" cellspacing="0" style="border:1px solid #fd9f1b;width:100%">
                                                    <tr>
                                                        <td style="padding:5px;text-align:center;font-size:12px;color:#fff;font-family:arial;font-weight:bold;background:#fd9f1b"><?php echo $streamObject->EventStartMonth; ?><?php echo $streamObject->StartDate != $streamObject->EndDate ? " " : "-"; ?><?php echo $streamObject->EventStartYear; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:5px;text-align:center;font-size:16px;color:#333;font-family:arial;font-weight:bold;background:#fff">
                                                            <div style="color:#333;font-size:16px"><?php echo $streamObject->EventEndDay; ?></div>
                                                            <div style="color:#fd9f1b;font-size:14px"><?php echo strip_tags($streamObject->EventEndDayString); ?></div>
                                                        </td>
                                                    </tr>

                                                </table>
                                    </td>
                                   <?php } ?>
                            </tr>
                        </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">
                                <table  cellpadding="0" cellspacing="0" style="margin:auto;width:100%" >
                            <tr>
                                    <?php if (trim($streamObject->StartTime) != "" && trim($streamObject->EndTime) != "" && $streamObject->StartTime != $streamObject->EndTime) { ?>
                                        <td style="padding:5px;text-align:center;font-size:12px;color:#5a5e65;font-family:arial;font-weight:bold;background:#e8e8e8">
                                            <?php echo $streamObject->StartTime ?> - <?php echo $streamObject->EndTime ?>
                                        </td>
                                    <?php } ?>

                                </tr>
                        </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">
                                <table  cellpadding="0" cellspacing="0" style="margin:auto" >
                            <tr>
                                <td style="padding:5px">
                                    <table cellspacing="0" cellpadding="0" style="background:#fff">
                                        <tbody><tr>
                                                <td><img src="<?php echo $absolutePath?>/images/system/dailydigest/map.png"></td>
                                                <td style="background:url(<?php echo $absolutePath?>/images/system/dailydigest/bluearrowbg.png) repeat-y right top;text-align:right;vertical-align:middle">
                                                    <img src="<?php echo $absolutePath?>/images/system/dailydigest/bluearrow.png"></td>
                                                <td style="border-top:1px solid #1a95d6;border-right:1px solid #1a95d6;border-bottom:1px solid #1a95d6;padding:5px;font-size:12px;color:#1a95d6;font-family:arial">
                                                    <?php echo $streamObject->Location ?>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                </td>
                            </tr>
                        </table>
                            </td>
                        </tr>
                    </table>
                        
                     
                     
                   <?php  if(!$streamObject->IsEventAttend && (isset($streamObject->Resource) && isset($streamObject->Resource['ThumbNailImage']) && $streamObject->Resource['ThumbNailImage'] != "")) { ?>
                        
                    <div style="text-align:right;padding-top:5px;"><a style="cursor: pointer;text-decoration: none" href="<?php echo $redirectUrl ?>" target="_blank"><img src="<?php echo $absolutePath?>/images/system/dailydigest/attendbutton.png" /> </a> </div><?php } ?>
                 
                </td>
                   <?php if (!isset($streamObject->Resource) || !isset($streamObject->Resource['ThumbNailImage']) || $streamObject->Resource['ThumbNailImage'] == "") { ?>
                <td style="vertical-align:top;padding-left:5px"> 
                   <div style="padding-bottom:5px;color:#000"><a style="cursor: pointer;text-decoration: none;color:#000" href="<?php echo $redirectUrl ?>" target="_blank"><?php echo $streamObject->PostText; ?></a></div>
                   <?php  if(!$streamObject->IsEventAttend){ ?>
                    
                   <div style="text-align:right;padding-top:5px;">
                       <a style="cursor: pointer;text-decoration: none;color:#000" href="<?php echo $redirectUrl ?>" target="_blank">
                       <img src="<?php echo $absolutePath?>/images/system/dailydigest/attendbutton.png" /></a></div> <?php }?>
                   </td> <?php }?>
                  <?php } ?>                                        
                 <!--event post divider ends --> 
            </tr>
            <tr>
                <td colspan="2">
                    <a style="cursor: pointer;text-decoration: none;color:#000" href="<?php echo $redirectUrl ?>" target="_blank">
                    <div style="padding-bottom:5px;color:#000"> <?php include 'stream_webSnippet.php'; ?></div></a>
                </td>
            </tr>
        </table>
        <!--survey post divider starts -->
        <?php if ($streamObject->PostType == 3) { ?>
                 
         <table width="100%"  cellpadding="0" cellspacing="0" border="0"  style="margin-top:10px">
                <tr>
                    <td style="background:#e8e8e8;padding:5px;">
                        <table width="100%"  cellpadding="0" cellspacing="0" border="0" >
                            <tr>
                               <?php if($streamObject->IsSurveyTaken){  ?>
                                <td style="padding:5px;width:60%"><a style="cursor: pointer;text-decoration: none" href="<?php echo $redirectUrl ?>" target="_blank">
                                    <img src="<?php echo $absolutePath?>/images/system/dailydigest/surveyfinished.png"/></a></td> <?php } ?> 
                                <td style="padding:5px;vertical-align:middle;font-family:arial;font-size:14px">
                                    <a style="color:#333;cursor: pointer;text-decoration: none" href="<?php echo $redirectUrl ?>" target="_blank">
                                    <?php if(!empty($streamObject->OptionOne)){ ?> <div style="padding:5px 0;"> A) <?php  echo $streamObject->OptionOne ?></div><?php } ?> 
                                    <?php if(!empty($streamObject->OptionTwo)){ ?><div style="padding:5px 0;"> B) <?php  echo $streamObject->OptionTwo ?></div><?php } ?> 
                                    <?php if(!empty($streamObject->OptionThree)){ ?><div style="padding:5px 0;"> C) <?php  echo $streamObject->OptionThree ?></div><?php } ?> 
                                    <?php if(!empty($streamObject->OptionFour)){ ?><div style="padding:5px 0;"> D) <?php  echo $streamObject->OptionFour ?></div><?php } ?> 
                                    </a>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>        
                 
        <?php } ?>
      <!--survey post divider ends -->
    </td>
</tr>

<!-- Post divider ends --> 





