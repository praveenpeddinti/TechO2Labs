<div id="PreferencesDiv">
<div>
        <h4 class="modal-title"><?php echo Yii::t('translation', 'Preferences'); ?></h4>
    </div>
<div class="padding8top">
    
 
    

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'PreferenceForm-form',
        'method' => 'post',
        'enableClientValidation' => TRUE,
        'htmlOptions' => array(
            'style' => 'margin: 0px; accept-charset=UTF-8', 'enctype' => 'multipart/form-data', 'class' => 'marginzero'
        )
    ));
    ?>                               


    <div id="preferenceSpinLoader"></div>
    <div class="signdiv">
        <div style="display: none" id="errmsgForPreference" class="alert alert-error"></div>
        <div style="display: none" id="sucmsgForPreference" class="alert alert-success"></div> 
        <?php if($countryRequest==1){ ?>
        <div role="alert" class="alert alert-warning" >
            <?php echo $message; ?>
        </div>
        <?php }else if($countryRequest==2){ ?>
        <div role="alert" class="alert alert-danger" >
            <?php echo $message; ?>
        </div>
        <?php } ?>
        
        <div class="row-fluid">
            <div class="span6 error">
                <label><?php echo Yii::t('translation', 'Change_Country'); ?></label>
                <?php
                echo $form->dropDownList($model, 'CountryId', CHtml::listData($countries, 'Id', 'CountryNetwork'), array(
                    'class' => "span12 textfield",
                    'empty' => "Please Select country",
                    'options' => array($model->CountryId=>array('selected'=>true))
                )
                    
                        );
         
                ?>
                


            </div>
        </div>


<div class="row-fluid">
            <div class="span6" >
        <div class="headerbuttonpopup padding8top">
            <div class="alignright clearboth">
             <?php echo CHtml::Button(Yii::t('translation', 'Submit'),array('id' => 'newHelpIconId','class' => 'btn pull-right','onclick'=>'changeSegment();')); ?> 
             
            </div>  
        
</div>
</div>
            <?php $this->endWidget(); ?>
        </div>

    </div>
</form>                            
</div>
</div>
<div id="LanguagesDiv">
    <div>
        <h4 class="modal-title"><?php echo Yii::t('translation', 'Languages'); ?></h4>
    </div>
    <div class="padding8top" id="LanguageChangeDiv">
        
    </div>
</div>
<script  type="text/javascript">
$(document).ready(function(){
    ajaxRequest('/user/getLanguages', "",getLanguagesHandler,"html");
});
function getLanguagesHandler(data){
    $("#LanguageChangeDiv").html(data);
}
function changeSegment(){
    
         var data = $("#PreferenceForm-form").serialize();
       // alert("****"+data.toSource());
         ajaxRequest('/user/requestForChangeCountry', data,changeSegmentHandler ,"json")
}

function changeSegmentHandler(data){
    if (data.status == 'success') {
            var msg = data.data;
            $("#sucmsgForPreference").html(msg);
            $("#errmsgForPreference").css("display", "none");
            $("#sucmsgForPreference").css("display", "block");
           // $("#forgot-form")[0].reset();
             $("#sucmsgForPreference").fadeOut(5000,function(){
           
            }); 
            //$("form").serialize()
        }else if (data.status == 'same') {
            var msg = data.data;
            $("#errmsgForPreference").html(msg);
            $("#errmsgForPreference").css("display", "block");
            $("#sucmsgForPreference").css("display", "none");
            $("#errmsgForPreference").fadeOut(5000);
        } else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {
                $("#errmsgForPreference").html(msg);
                $("#errmsgForPreference").css("display", "block");
                $("#sucmsgForPreference").css("display", "none");
                $("#errmsgForPreference").fadeOut(5000);

            } else {

                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {

                    var error = eval(data.error);
                }
                $.each(error, function(key, val) {
                    if ($("#" + key + "_em_")) {
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(5000);
                        //  $("#"+key).parent().addClass('error');
                    }
                });
            }
        }
}

</script>

