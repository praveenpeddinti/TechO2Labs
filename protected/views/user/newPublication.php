<div id="publicationdiv_<?php echo $PublicationId; ?>" class="publicationschild">
    
      <input id="UserCVForm_Publicationfile_<?php echo $PublicationId; ?>" type="hidden" name="UserCVForm[Publicationfile][<?php echo $PublicationId; ?>]">
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle PublicationClass" data-toggle="collapse" data-parent="#accordion2" href="#collapse_<?php echo $PublicationId; ?>">
                <?php echo Yii::t('translation','Publications'); ?>
            </a>
            <div class="sectionremove" onclick="removePublication('<?php echo $PublicationId; ?>')"><i class="fa fa-times"></i>
            </div>
        </div>
        <div id="collapse_<?php echo $PublicationId; ?>" class="accordion-body collapse in">
            <div class="accordion-inner">

<div class="row-fluid padding8top">
    <div class="span12">
        <div class="span4">
            <label><?php echo Yii::t('translation', 'User_Publication_Name'); ?></label>
            <div class="control-group controlerror marginbottom10">
                <input type="text" name="UserCVForm[PublicationName][<?php echo $PublicationId; ?>]" class="tooltiplink span12 textfield SpecialCh" maxlength="30" id="UserCVForm_Name_<?php echo $PublicationId; ?>">   

                <div id="UserCVForm_PublicationName_<?php echo $PublicationId; ?>_em_" class="errorMessage" style="display:none"></div>
            </div>
        </div>
        <div class="span4">

            <label><?php echo Yii::t('translation', 'User_Publication_Date'); ?></label>
            
            <div id="publication_Date_<?php echo $PublicationId; ?>" class="input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">

                  <input type="text" name="UserCVForm[PublicationDate][<?php echo $PublicationId; ?>]" class="tooltiplink span12 textfield SpecialCh" maxlength="30" id="UserCVForm_Date_<?php echo $PublicationId; ?>">   
                  
                  <div class="control-group controlerror" > 
                      
                      <div id="UserCVForm_PublicationDate_<?php echo $PublicationId; ?>_em_" class="errorMessage" style="display:none"></div>
                  </div>

              </div>       
            

        </div>
        <div class="span4">

            <label><?php echo Yii::t('translation', 'User_Publication_Title'); ?></label>
            <div class="control-group controlerror marginbottom10">
                <input type="text" name="UserCVForm[PublicationTitle][<?php echo $PublicationId; ?>]" class="tooltiplink span12 textfield SpecialCh" maxlength="30" id="UserCVForm_Title_<?php echo $PublicationId; ?>">   

                <div id="UserCVForm_PublicationTitle_<?php echo $PublicationId; ?>_em_" class="errorMessage" style="display:none"></div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid padding8top">
    <div class="span12">
            <div class="padding-bottom5">
                <span class="authortext"><?php echo Yii::t('translation', 'User_Publication_Authors'); ?> <i data-original-title=" <?php echo Yii::t('translation','Type_And_Press_Enter_Button'); ?>" rel="tooltip" data-placement="bottom" data-id="id" style="font-weight: normal;top:81px;right:auto;float:left;margin-left:12px;" class="fa fa-question helpmanagement helpicon top10  tooltiplink"></i> </span>
                <span id="UserCVForm_PublicationAuthors_<?php echo $PublicationId; ?>_currentMentions"></span>
            </div>
            <div class="control-group controlerror marginbottom10">
                <input value="" type="text" name="UserCVForm[PublicationAuthors][<?php echo $PublicationId; ?>]" class="tooltiplink span12 textfield" onblur="setAuthorsStyle(this.id)" onkeyup = "PublicationAuthors(event,this,'Authors')" maxlength="30" id="UserCVForm_PublicationAuthors_<?php echo $PublicationId; ?>">   

                <div id="UserCVForm_PublicationAuthors_<?php echo $PublicationId; ?>_em_" class="errorMessage" style="display:none"></div>
              <div id="UserCVForm_PublicationAuthors_0_error" class="errorMessage" style="display:none;"></div>
            </div>
        
        
    </div>
</div>
<div class="row-fluid padding8top">
    <div class="span12">
        <div class="span4">
            <label><?php echo Yii::t('translation', 'User_Publication_Location'); ?></label>
            <div class="control-group controlerror marginbottom10">
                <input type="text" name="UserCVForm[PublicationLocation][<?php echo $PublicationId; ?>]" class="tooltiplink span12 textfield SpecialCh" maxlength="50" id="UserCVForm_Location_<?php echo $PublicationId; ?>">   

                <div id="UserCVForm_PublicationLocation_<?php echo $PublicationId; ?>_em_" class="errorMessage" style="display:none"></div>
            </div>
        </div>
        
        <div class="span4">      
                            <label><?php echo Yii::t('translation', 'User_Cv_FileorLink'); ?></label>
                            <div class="lineheight25 pull-left radiobutton ">
                                <div class="control-group controlerror marginbottom20 " >

                                    <input type="radio" id="<?php echo $PublicationId; ?>" name="UserCVForm[UploadFileORLink][<?php echo $PublicationId; ?>]"  value="1" class="styled"  checked=checked  onClick="setPublicationFile(this.value,'<?php echo $PublicationId; ?>')">
                                    <label for="UserCVForm_UploadFileORLink_<?php echo $PublicationId; ?>">Link</label>
                                    <input type="radio"  id="<?php echo $PublicationId; ?>" name="UserCVForm[UploadFileORLink][<?php echo $PublicationId; ?>]"  value="0" class="styled"  onClick="setPublicationFile(this.value,'<?php echo $PublicationId; ?>')" >
                                    <label for="UserCVForm_UploadFileORLink_<?php echo $PublicationId; ?>">File</label>
                                </div>
                            </div>

                        </div>
        
        <div class="span4">
            
             <input id="UserCVForm_PublicationFIleType_<?php echo $PublicationId; ?>" type="hidden" name="UserCVForm[PublicationFIleType][<?php echo $PublicationId; ?>]">
                <div id='publication_link_div_<?php echo $PublicationId; ?>' style='display:block;'>
                <label><?php echo Yii::t('translation', 'User_Publication_Link'); ?></label>
                <div class="control-group controlerror marginbottom10">
                    <input type="text" name="UserCVForm[PublicationLink][<?php echo $PublicationId; ?>]" class="tooltiplink span12 textfield" maxlength="250" id="UserCVForm_PublicationLink_<?php echo $PublicationId; ?>">   

                    <div id="UserCVForm_PublicationLink_<?php echo $PublicationId; ?>_em_" class="errorMessage" style="display:none"></div>
                </div>
            </div>
                <div id='publication_pdf_div_<?php echo $PublicationId; ?>' style='display:none;'>
                <input id="UserCVForm_PublicationPdf_<?php echo $PublicationId; ?>" type="hidden" name="UserCVForm[PublicationPdf][<?php echo $PublicationId; ?>]">
                    
                        <label><?php echo Yii::t('translation','Upload_PDF_DOC'); ?></label>
                        <div id='PublicationImage_<?php echo $PublicationId; ?>' ></div>
                    
                    
                        <div id="PublicationPreviewdiv_<?php echo $PublicationId; ?>" class="preview span4" style="display:none;" >

                            <img class="qpreview" id="PublicationPreview_<?php echo $PublicationId; ?>" name=""  src=""/>
                        </div>
                    
                    <div ><ul class="qq-upload-list" id="uploadlist_<?php echo $PublicationId; ?>"></ul></div>
                    <div class="control-group controlerror "   style="padding-bottom:30px;">
                        <div id="PublicationImage_<?php echo $PublicationId; ?>_error"  class="errorMessage marginbottom10 error"  style="display:none"></div>

                    </div>
            </div>
            <div class="control-group controlerror "  style="padding-bottom:30px;" >
                 <div id="UserCVForm_Publicationfile_<?php echo $PublicationId; ?>_em_"  class="errorMessage marginbottom10 error"  style="display:none"> </div>

              </div>
            </div>
        
    </div>
</div>       
                
                
                
<div class="row-fluid padding8top" style="display:none;">
    <div class="span12">
 <div class="span6">
                    <div class="span2">
                       <label><?php echo Yii::t('translation','Upload_PDF_DOC'); ?></label>
                        <div id='PublicationImage_' ></div>
                    </div>
                    <div class="span3">
                        <div id="PublicationPreviewdiv_" class="preview" style="display:none;" >

                            <img class="qpreview" id="PublicationPreview_" name=""  src=""/>
                        </div>
                    </div>
                    <div ><ul class="qq-upload-list" id="uploadlist_"></ul></div>
                    <div class="control-group controlerror " >
                        <div id="PublicationImage_<?php echo $PublicationId; ?>_error"  class="errorMessage marginbottom10 error"  style="display:none"></div>

                    </div>
                </div>
    </div>
</div>
                
 </div>

        </div>
    </div>
</div>

<script type="text/javascript">
Custom.init();  
        $('#UserCVForm_UploadFileORLink_<?php echo $PublicationId?>').live('click', function() { 


        var radios = document.getElementsByTagName('input');
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].type === 'radio' && radios[i].checked) {
                // get value, set checked flag or do whatever you need to                
                current_value= radios[i].value;  
                if (current_value == "1"){
                     $('#publication_location_div_<?php echo $PublicationId;?>').show();
                 } else {
                      $('#publication_pdf_div_<?php echo $PublicationId; ?>').hide();
                 }
            }
        }
    });
    </script>