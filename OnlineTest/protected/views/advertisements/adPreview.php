

<div id="rightSideSectionSeperation3" class="rightwidget  padding-bottom10">
     <div class="container">
          <div style='position: absolute;<?php echo $displayPage!="Group"?"top:0px;":"top:565px;"?> right: 0px;bottom: 0px;width: 306px'>             
                 
             <?php if($displayPage!="Group"){ ?>
              <?php if($position=="Top"){ ?>
              
              <img id="imgDiv_<?php echo $position?>"  src="<?php echo $url?>"/>
              <div id="videoPlay_<?php echo $position?>" style="display:none"> </div>
              <div id="swfTopDiv" style="margin: auto; height: 250px;display: none;" >
  <a id="aIdSwf_" target="_blank" href="">
    <div  style="min-height: 250px;">
   <object id="swfId_" type="application/x-shockwave-flash" data="<?php echo $url?>"
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
           <!--<![endif]-->
       </object>
  
</div>
    </a>
</div>
              <?php }?>
              <img id="imgDiv"  src="/images/system/newfollowers_preview.jpg"  />
              <img id="imgDiv"  src="/images/system/eventspreview.jpg"  /> 
              <?php if($position=="Middle"){ ?>
              <img id="imgDiv_<?php echo $position?>"  src="<?php echo $url?>"  />
              <div id="videoPlay_<?php echo $position?>" style="display:none"> </div>
              <div id="swfTopDiv" style="margin: auto; height: 250px;display: none;" >
<a id="aIdSwf_" target="_blank" href="">
    <div  style="min-height: 250px;">
   <object id="swfId_" type="application/x-shockwave-flash" data="<?php echo $url?>"
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
       </object>
  
</div>
    </a>
</div>
              <?php }?>
               <img id="imgDiv"  src="/images/system/featuredpreview.jpg"  />
               <?php if($position=="Bottom"){ ?>
               <img id="imgDiv_<?php echo $position?>"  src="<?php echo $url?>"  />
               <div id="videoPlay_<?php echo $position?>" style="display:none"> </div>
               <div id="swfTopDiv" style="margin: auto; height: 250px;display: none;" >
<a id="aIdSwf_" target="_blank" href="">
    <div  style="min-height: 250px;">
   <object id="swfId_" type="application/x-shockwave-flash" data="<?php echo $url?>"
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
          
       </object>
  
</div>
    </a>
</div>
                 <?php }?>
              <?php }else{?>
               <img id="imgDiv"  src="<?php echo $url?>" style="margin-top: 5px"  />
                 <?php } ?>
                  
                 
      </div>
         <img id="imgDiv"  src=<?php echo $src?> />
    </div>    
    
 
    
   
   </div> 