<ul  class="listnone newsbox" >
<?php foreach($stream as $data){?>
 
<?php        $displayStream="news";

 $bannerTemplateId=null;
if($data->BannerTemplate!=null && $data->BannerTemplate!=""){
    $bannerTemplateId=$data->BannerTemplate;
}
if($data->IsNotifiable){
?><li class="woomarkLi gamelist jobsList fromHec" id="<?php echo $data->_id?>"> 
    <div class="stream_widget positionrelative <?php if(!empty($displayStream)){ echo "news_advt";} ?>" >

           <div class="post_widget" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>"> 
                <div class="stream_msg_box">
                  
                    <div class="padding10"> 
                           <?php if($data->BannerOptions =="OnlyImage"){ ?>
                              <?php if($data->Resource['ImpressionTag']!=null && $data->Resource['ImpressionTag']!=""){?> <img src="<?php echo $data->Resource['ImpressionTag'].replace("<%RandomNumber%>", num) ?>" id="InpressionImage" border="0" height="1" width="1" alt="Advertisement" /><?php }?>
                             <a id="aId" <?php if(stristr($data->RedirectUrl,YII::app()->params['ServerURL'])==""){echo 'target="_blank"'; }  ?> data-adid="" onclick="treackAdUser('<?php echo $data->PostId ?>')" data-type="img" href="<?php echo $data->RedirectUrl ?>" style="text-decoration:none">
                             <img src="<?php echo $data->Resource['Uri'] ?>" <?php if($data->Resource['ClickTag']!=null && $data->Resource['ClickTag']!=""){?>onclick="GenzymeSquareClickTag('<?php echo $data->Resource['ClickTag'] ?>');" ><?php }?> /></a>
                           
                           <?php } else if($data->BannerOptions =="ImageWithText"){ ?> 
                             <a id="aId" <?php if(stristr($data->RedirectUrl,YII::app()->params['ServerURL'])==""){echo 'target="_blank"'; }  ?> data-adid="" onclick="treackAdUser('<?php echo $data->PostId ?>')" data-type="img" href="<?php echo $data->RedirectUrl ?>"> 
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
                                           
                                             <img src="<?php echo $data->Resource['Uri'] ?>" <?php if($data->Resource['ClickTag']!=null && $data->Resource['ClickTag']!=""){?>onclick="GenzymeSquareClickTag('<?php echo $data->Resource['ClickTag'] ?>');" ><?php }?> />
                                     </div>
                                 
                    </div> </a><?php } else if($data->BannerOptions =="OnlyText"){ ?> 
                        <a id="aId" <?php if(stristr($data->RedirectUrl,YII::app()->params['ServerURL'])==""){echo 'target="_blank"'; }  ?> data-adid="" onclick="treackAdUser('<?php echo $data->PostId ?>')" data-type="img" href="<?php echo $data->RedirectUrl ?>" style="text-decoration:none"> 
                        <div class="addbanner addbannersection">
                                         <div class="">
                                             <div class="addbannertable">
                                                 <div <?php if($data->Resource['ClickTag']!=null && $data->Resource['ClickTag']!=""){?>onclick="GenzymeSquareClickTag('<?php echo $data->Resource['ClickTag'] ?>');"<?php }?> class="addbannercell addbannerbottom">
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
                                     </div>
                                 
                    </div></a>
                        <?php }else{
                             $num = rand(0,100000000000000) + "";
                              $streamBund = $data->StreamBundle;
                              $replaceStr = str_replace("<%RandamNumber%>", $num, $streamBund);
                            ?> 
                              <center>
                              <div  id="StreamBundleAds_<?php echo $data->_id ?>" onclick="trackAd(this)" class="news_v" >
                                 <?php echo $replaceStr; ?>
                                

                              </div>
                             </center>
                             
                          <?php }?>  
                </div>
            </div>
      </div>
      </div>

<?php } ?>

</li>
<?php }?>
</ul>
