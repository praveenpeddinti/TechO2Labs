<div class=""> 
    <div id="changelanguageSpinLoader"></div>
    <div class="signdiv">
        <div style="display: none" id="errmsgForChangelanguage" class="alert-error"></div>
        <div style="display: none" id="sucmsgForChangelanguage" class="alert-success"></div>          
        <div class="row-fluid">
            <div class="span6 error">
                <label><?php echo Yii::t('translation', 'Change_Language'); ?></label>
                <select id="LanguageId" class="span12 textfield">
                    <?php foreach ($languages as $language) {?>
                    <option value="<?php echo $language["Language"]; ?>" <?php echo $userLanguage==$language["Language"]?"selected":""; ?> > <?php echo $language["Name"]; ?> </option>         
                    <?php  } ?>
                </select>

            </div>
        </div>
       
<div class="row-fluid">
            <div class="span6" >
        <div class="headerbuttonpopup padding8top">
            <div class="alignright clearboth">
                <?php echo CHtml::Button(Yii::t('translation', 'Submit'),array('class' => 'btn pull-right','onclick'=>'changeLanguage();')); ?>
            </div> 
        </div>
            </div>
</div>
    </div>                         
</div>