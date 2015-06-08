<?php if($page=="News"||$page=="Games" ||$page=="Careers"){?>
<ul  class="listnone newsbox" >
<li  class="woomarkLi gamelist jobsList fromHec" id="<?php echo $data->_id?>"> <?php } ?>
<?php if(is_array($loadAds) && count($loadAds)>0){ $margintop=($position=="Top"?"":"margin-top: 5px")?> 
<div id="rightSideSectionSeperation3_<?php echo $position?>" class="rightwidget  padding-bottom10" style="display:none" data-page="<?php echo $page ?>">
    
   
    <a id="vd_id_<?php echo $position?>" target="_blank" data-adid="" onclick="trackAd(this)" href="" data-type="video" style="display: none"><div id="videoPlay_<?php echo $position?>"> </div></a>
    <a id="aId_<?php echo $position?>" target="_blank" data-adid="" onclick="trackAd(this)" data-type="img" href=""><img id="imgDiv_<?php echo $position?>"  src="" style="width:auto;display: none;<?php echo $margintop?>" /></a>
    <a id="aIdSwf_<?php echo $position?>" data-adid=""  onmousedown="trackAd(this)" target="_blank" data-type="swf" href="">
    <div id="swfTopDiv_<?php echo $position?>"  data-adid=""  style="margin: auto; height: auto;display: none;" >
 
    <div  style="min-height: 250px;">
   <object id="swfId_<?php echo $position?>" type="application/x-shockwave-flash" data=""
           width="300" height="250">
           <param name="movie" value="/upload/advertisements/Option2_300x250.swf" />
           <param name="quality" value="high" />
           <param name="bgcolor" value="#ffffff" />
           <param name="play" value="true" />
           <param name="loop" value="true" />
           <param name="wmode" value="transparent" />
           <param name="scale" value="showall" />
           <param name="menu" value="true" />
           <param name="devicefont" value="false" />
           <param name="salign" value="" />
           <param name="allowScriptAccess" value="sameDomain" />
           <embed  wmode="transparent" allowfullscreen="true" allowscriptaccess="always" src="/upload/advertisements/Option2_300x250.swf"></embed>

       </object>
  
</div>
     
</div>
      </a> 
  
    
   
   </div> 

   <div id="StreamBundleAds_<?php echo $position?>" style="display:none" data-page="<?php echo $page ?>">


    </div>
   <div id="AddServerAds_<?php echo $position?>" onclick="trackAd(this)" data-adid="" style="display:none" data-page="<?php echo $page ?>">
          <img id="InpressionImage_<?php echo $position?>" border="0" height="1" width="1" alt="Advertisement" />
          <a  target="_blank" id="clickTagA_<?php echo $position?>">
            <img id="clickTagImage_<?php echo $position?>"  src="/images/04-13642_Banner_Aubagio_300x250_Unbranded-L02.gif" alt="Advertisement" border="0" />
           </a>
    </div>
     <?php }else{
         echo '0';
     }?>
<?php if($page=="News"||$page=="Games"||$page=="Careers"){?>
  </li>

 </ul><?php } ?>