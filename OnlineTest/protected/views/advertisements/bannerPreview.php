<?php 
foreach ($banners as $banner) {
      $id = $banner["Language"];
?>
<div id="imageWithTextDiv_<?php echo $id ?>" class="modal-body banner_modaldialog imageWithTextDiv" data-language="<?php echo $banner["Language"]; ?>">
    <div style="" id="bannerTemplateDiv2_<?php echo $id ?>" class="bannerTemplateDiv2 row-fluid" data-language="<?php echo $banner["Language"]; ?>">
        <div class="span12 positionrelative">

            <label for="AdvertisementForm_Banner_Template">Banner  Template - <?php echo $banner["Language"] ?></label>                        
            <div class="control-group controlerror marginbottom20 " id="uploadBanner">
                <span id="AdvertisementForm_BannerTemplate_<?php echo $id ?>">
                    <input type="radio" name="AdvertisementForm_BannerTemplate_<?php echo $id ?>" value="1" class="styled" id="AdvertisementForm_BannerTemplate_0_<?php echo $id ?>" <?php echo $banner["BannerTemplate"]==1?'checked="checked"':'' ?>> 
                    <label for="AdvertisementForm_BannerTemplate_0_<?php echo $id ?>">
                        <img data-placement="bottom" rel="tooltip" data-original-title="Banner template text align bottom." src="/images/system/ad_banner_theme3.png">
                    </label>
                    <input type="radio" name="AdvertisementForm_BannerTemplate_<?php echo $id ?>" value="2" class="styled" id="AdvertisementForm_BannerTemplate_1_<?php echo $id ?>" <?php echo $banner["BannerTemplate"]==2?'checked="checked"':'' ?>> 
                    <label for="AdvertisementForm_BannerTemplate_1_<?php echo $id ?>">
                        <img data-placement="bottom" rel="tooltip" data-original-title="Banner template text align top." src="/images/system/ad_banner_theme5.png">
                    </label>
                    <input type="radio" name="AdvertisementForm_BannerTemplate_<?php echo $id ?>" value="3" class="styled" id="AdvertisementForm_BannerTemplate_2_<?php echo $id ?>" <?php echo $banner["BannerTemplate"]==3?'checked="checked"':'' ?>> 
                    <label for="AdvertisementForm_BannerTemplate_2_<?php echo $id ?>">
                        <img data-placement="bottom" rel="tooltip" data-original-title="Banner template text align left." src="/images/system/ad_banner_theme1.png">
                    </label>
                    <input type="radio" name="AdvertisementForm_BannerTemplate_<?php echo $id ?>" value="4" class="styled" id="AdvertisementForm_BannerTemplate_3_<?php echo $id ?>" <?php echo $banner["BannerTemplate"]==4?'checked="checked"':'' ?>> 
                    <label for="AdvertisementForm_BannerTemplate_3_<?php echo $id ?>">
                        <img data-placement="bottom" rel="tooltip" data-original-title="Banner template text align right." src="/images/system/ad_banner_theme2.png">
                    </label>
                    <input type="radio" name="AdvertisementForm_BannerTemplate_<?php echo $id ?>" value="5" class="styled" id="AdvertisementForm_BannerTemplate_4_<?php echo $id ?>" <?php echo $banner["BannerTemplate"]==5?'checked="checked"':'' ?>> 
                    <label for="AdvertisementForm_BannerTemplate_4_<?php echo $id ?>">
                        <img data-placement="bottom" rel="tooltip" data-original-title="Banner template text align center." src="/images/system/ad_banner_theme4.png">
                    </label>
                </span>

                <div class="control-group controlerror">
                    <div style="display:none" id="AdvertisementForm_BannerTemplate_em_" class="errorMessage"></div>                    </div>
            </div>  

        </div>
    </div>
    <div id="imageWithTextBanner_<?php echo $id ?>" class="modal-body banner_modaldialog" style="<?php echo $banner['Url']==''?'display:none':'' ?>">
        <div class="uploadimage">
            <div data-original-title="Upload" rel="tooltip" data-placement="bottom" id="uploadfile1_<?php echo $id ?>">

                <div id="uploadBannerImage_<?php echo $id ?>">
                    <div id="BannerImage_<?php echo $id ?>"  class="uploadicon"><img src="/images/system/spacer.png"></div>

                </div>    
            </div>
        </div>

        <div id="templateBannerChangeClass_<?php echo $id ?>" class="addbanner addbannersection<?php echo $banner['BannerTemplate']==''?1:$banner['BannerTemplate'] ?>">
            <div class="addbannercontentarea">
                <div class="addbannertable">
                    <div class="addbannercell addbannerbottom">
                        <div id="titleBanner45_<?php echo $id ?>"  class="addbannerpadding">
                            <div  class="pickericon bfh-colorpicker " data-name="colorpicker1">
                                <div class="demo1_<?php echo $id ?>"></div>
                            </div>
                            <div id="AdBannerTitle_<?php echo $id ?>" class="addbannaertitle  addbannerhighlight aligncenter" contentEditable="true"><?php echo $banner['BannerTitle'] ?></div> 
                        </div>
                        <div id="contentBanner45_<?php echo $id ?>" class="addbannerpadding">
                            <div class="pickericon">
                                <div class="demo2_<?php echo $id ?>"></div></div>
                            <div id="AdBannerContent_<?php echo $id ?>" class="addbannerdescription addbannerhighlight aligncenter" contentEditable="true"><?php echo $banner['BannerContent'] ?> </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="boxborder boxborder_active">
                <img id="Preview_BannerImage_<?php echo $id ?>"   alt="banner" src="<?php echo $banner['Url'] ?>" ></div>
        </div>
    </div>
    <div style="display:none" id="Error_BannerImage_<?php echo $id ?>" class="alert alert-error"></div>
    <ul class="qq-upload-list" id="Upload_BannerImage_<?php echo $id ?>"></ul>
</div>
<script type="text/javascript">
    $(function(){
         Custom.init();
         <?php if($banner['Url']!=''){ ?>
            bannerTemplateEvents();
            initializeFileUploader('BannerImage_<?php echo $banner["Language"] ?>', '/advertisements/UploadAdvertisementImage', '10*1024*1024', bannerextensions,1, 'BannerImage_<?php echo $banner["Language"] ?>' ,'',BannerDLPreviewImage,displayErrorForBannerAndLogo,"Upload_BannerImage_<?php echo $banner["Language"] ?>");
         <?php } ?>
     });
</script>    
<?php } ?>