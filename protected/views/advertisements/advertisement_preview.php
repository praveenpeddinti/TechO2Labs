<?php
$date = date('Y-m-d');
$sdate =$data->StartDate;
$exdate=$data->ExpiryDate;
$sdate =date("Y-m-d",$sdate->sec);
$exdate =date("Y-m-d",$exdate->sec);
$redirectUrl = $data->RedirectUrl;
$adtype=$data->DisplayPage == "Home"?"Stream":($data->DisplayPage == "Curbside"?"Curbside Consult":"Stream"); 
if ($data->AdType == 3) {

    $requestedFieldsArray = explode(",", $data->RequestedFields);
    $QueryParms;
    $md5 = md5($this->tinyObject->UserId . "_" . $data->AdvertisementId);
    foreach ($requestedFieldsArray as $value) {

        $QueryParms = ($QueryParms == "" ? $QueryParms : $QueryParms . "&");
        if ($value == "UserId") {
            $QueryParms.=trim($value) . "=" . $md5;
        }
        if (trim($value) == "Display Name") {
            $QueryParms.=trim($value) . "=" . $this->tinyObject->DisplayName;
        }
        if (trim($value) == "Email") {
            $QueryParms.=trim($value) . "=" . Yii::app()->session['Email'];
        }
    }
    $QueryParms = str_replace(' ', '', $QueryParms);

    $redirectUrl.="?" . $QueryParms . "&ReferenceId=" . $md5;
}
$bannerTemplateId=null;
if($data->BannerTemplate!=null && $data->BannerTemplate!=""){
    $bannerTemplateId=$data->BannerTemplate;
}
?>
<section class="streamsection" id="streamsection">
    <div class="container">
        <div id="menu_bar" class="sidebar-nav">
            <ul id="menu">

                <li id="homestream"><a class="left_home-icon" href="#" > <span>Home</span></a></li>
                <li id="curbsidepost"><a class="left_curbside-icon" href="#"><span>Curbside</span></a></li>
                <li id="grouppost"><a class="left_groups-icon" id="groupmainmenu" href="#"><span>Groups</span></a>



                    <ul class="subnavinner  " id="GroupDiv" style="width: 308px;">
                        <li style="display: none;" id="mobiles_li"><a href="#">Groups Home</a>
                    </ul>

                </li>
                <li id="news"><a class="left_news-icon" href="#"><span>News</span></a></li>



                <li id="games"><a class="left_games-icon" href="#"><span>Games</span></a></li>

                <li id="careers" class="active"><a class="left_career-icon" href="#"><span>Careers</span></a></li>

                <li id="analytics"><a class="left_analytics-icon" href="#"><span>Analytics</span></a></li>




                <li id="admin"><a class="left_admin-icon"><span>Admin</span></a>
                    
                </li>    
            </ul>
        </div>
       
        <div  class="sidebar-nav_right">
            <div id="sidebarnavrightId" style="text-align: left" class="paddingt12">

                <img src="/images/system/DOT_Banner_160x600.jpg" style="width:160px" />
            </div>
        </div> 
         
        <div  class="streamsectionarea streamsectionarearightpanel">
            <div class="padding10">
                <div class="groupseperator">
                    <div id="numero1"><!-- This id numero1 is used for Joyride help -->
                        <h2 class="pagetitle positionrelative searchfiltericon"><?php echo $adtype; ?>   
                            <!--replace class "fa fa-question" with  "fa fa-video-camera videohelpicon" if we have description and video remaining will be same-->
                            <i style="font-weight: normal" class="fa fa-question helpmanagement helpicon top10  tooltiplink"></i></h2>
                    </div>
                </div>
            <div class="post item"   id="postitem_<?php echo $data->_id; ?>" data-postid="<?php echo $data->PostId; ?>">
                <div class="stream_widget marginT10 positionrelative" >
                    <div class="generalprofileicon skiptaiconwidth80x80 generalzindex2 positionabsolutediv ">
                        <div class="skiptaiconinner ">            
                            <img src="<?php echo $data->NetworkLogo; ?>" /> 
                         </div> 
                     </div>
                    <div class="post_widget" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>">
                        <div class="stream_msg_box">
                            
                            <div class="stream_title paddingt5lr10" style="position: relative"  >
                                <?php echo $data->Title ?>
                                <div class="postmg_actions">
                                    <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
                                    <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
                                    
                                </div>
                            </div>
                            
                            <div class="padding10"  > 
                            <?php if($data->BannerOptions =="OnlyImage"){ ?>
                              <?php if($data->Resource['ImpressionTag']!=null && $data->Resource['ImpressionTag']!=""){?> <img src="<?php echo $data->Resource['ImpressionTag'].replace("<%RandomNumber%>", num) ?>" id="InpressionImage" border="0" height="1" width="1" alt="Advertisement" /><?php }?>
                                <?php 
                                    $BannerImage = "";
                                    foreach ($data->Uploads as $upload) {
                                        $BannerImage = $upload['Url'];
                                        break;
                                    }
                                 ?>
                             <img src="<?php echo $BannerImage ?>" /> 
                           
                           <?php }  else if(isset($data->BannerOptions) && $data->BannerOptions =="ImageWithText"){ ?> 
                             
                             <div class="addbanner addbannersection<?php echo $bannerTemplateId; ?>">
                                         <div class="addbannercontentarea">
                                             <div class="addbannertable">
                                                 <div class="addbannercell addbannerbottom">
                                                     <div class="addbannerpadding">
                                                         
                                                         <?php echo $data->BannerTitle; ?>
                                                     </div>
                                                     <div class="addbannerpadding">
                                                         
                                                         <?php echo $data->BannerContent; ?>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         
                                         <div class="boxborder boxborder_active">
                                             <?php if($data->Resource['ImpressionTag']!=null && $data->Resource['ImpressionTag']!=""){?> <img src="<?php echo $data->Resource['ImpressionTag'].replace("<%RandomNumber%>", num); ?>" id="InpressionImage" border="0" height="1" width="1" alt="Advertisement" /><?php }?>
                                           <?php 
                                                $BannerImage = "";
                                                foreach ($data->Banners as $upload) {
                                                    $BannerImage = $upload['Url'];
                                                    break;
                                                }
                                             ?>
                                             <img src="<?php echo $BannerImage ?>"   />
                                     </div>
                                 
                    </div> <?php } else if(isset($data->BannerOptions) && $data->BannerOptions =="OnlyText"){ ?> 
                        
                            <div class="addbanner addbannersection" style="height: auto">
                                         <div class="">
                                             <div class="addbannertable">
                                                 <div  class="addbannercell addbannerbottom">
                                                     <div class="addbannerpadding">
                                                         
                                                         <?php echo $data->BannerTitle; ?>
                                                     </div>
                                                     <div class="addbannerpadding">
                                                         
                                                         <?php echo $data->BannerContent; ?>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         
                                         <div class="boxborder boxborder_active">
                                             <?php if($data->Resource['ImpressionTag']!=null && $data->Resource['ImpressionTag']!=""){?> <img src="#" id="InpressionImage" border="0" height="1" width="1" alt="Advertisement" /><?php }?>
                                     </div>
                                 
                    </div>
                        <?php }else{
                             $num = rand(0,100000000000000) + "";
                              $streamBund = $data->StreamBundle;
                              $replaceStr = str_replace("<%RandomNumber%>", $num, $streamBund);
                            ?> 
                             
                             <div  id="StreamBundleAds" onclick="trackAd(this)"> 
                                 <?php if(stristr($data->StreamBundle,"<iframe")==""){  ?> 
                                 <center>
                                 <iframe width="300" height="250" marginwidth="0" marginheight="0" hspace="0" vspace="0"
frameborder="0" scrolling="no" bordercolor='#000000' src="/advertisements/renderscriptad?id=<?php echo $data->_id?>" onload="SetHeightforIframe('<?php echo $data->_id?>',this);"></iframe>
                                 </center>
                                 <?php }else{
                                   echo $replaceStr;  
                                 }?>
                              </div>
                             
                          <?php }?>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
             </div>
    </div>
</section>

