<?php ?>



<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'reset-form',
    'enableClientValidation' => true,
    //'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,),
    'htmlOptions' => array(
        'class' => 'form-horizontal loginfields',
    ),
        ));
?>
<div class="alert-error" id="errmsgForReset" style='padding-top: 5px;display: none'></div>
<div class="alert-success" id="sucmsgForReset" style='padding-top: 5px;display: none'></div>  

<div class="row-fluid" >
    <div class="span12" style="margin: auto">
        <div  style="margin: auto;">
            <label><?php echo Yii::t('translation', 'Password_Rule_Message'); ?><div class="tooltip-options pull-right"  style="margin-bottom:3px">
    <i data-toggle="tooltip" title="<div class=repwddiv> Your password must adhere to the following rules: <ol ><li type=numbers> It cannot contain your first name.</li><li> It cannot contain your email address.</li><li>  It cannot contain the domain name of this network.</li>
       <li>  It has to contain at least one special character, one lowercase letter, one numeric and one capital letter.</li>
       <li>  It has to be at least 8 characters long.</li>

       </ol></div>"   data-placement="left" class="fa fa-question  helpicon helprelative tooltiplink" data-id=""></i>

</div></label>
            <div class="control-group controlerror marginbottom10 ">
                <?php echo $form->passwordField($this->resetForm, 'resetPass', array('maxlength' => 40, 'class' => 'span12 pwd')); ?>        
                <?php echo $form->error($this->resetForm, 'resetPass'); ?>
            </div>     
        </div>   
    </div>
</div>
<div class="row-fluid" >
    <div class="span12" style="margin: auto">
        <div style="margin: auto;">
            <label><?php echo Yii::t('translation', 'resetpassword'); ?></label>
            <div class="control-group controlerror marginbottom10 ">
                <?php echo $form->passwordField($this->resetForm, 'resetConfirmPass', array('maxlength' => 40, 'class' => 'span12 pwd')); ?>        

                <?php echo $form->error($this->resetForm, 'resetConfirmPass'); ?>
            </div> 
        </div>
    </div>
</div>
<div class="row-fluid" >
    <div class="span12" style="margin: auto">
        <div class="pull-righ">
            <?php echo $form->hiddenField($this->resetForm, 'email'); ?>
            <?php echo $form->hiddenField($this->resetForm, 'md5UserId'); ?>

            <?php
            echo CHtml::ajaxSubmitButton('Reset Password', array('site/reset'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'error' => 'function(error){
                                           
                                        }',
                'beforeSend' => 'function(){                                                   
                                                }',
                'complete' => 'function(){
                                                    }',
                'success' => 'function(data,status,xhr) {resetPassHandler(data,status,xhr);}'), array('type' => 'submit', 'id' => 'resetBtnId', 'class' => 'btn btn-2 btn-2a pull-right')
            );
            ?>

            <?php echo CHtml::resetButton(Yii::t('translation', 'Clear'), array("id" => 'forgotReset2', "style" => "display:block", 'class' => 'btn btn-2 btn-2a btn_gray pull-right margin-right10')); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>  
<script type="text/javascript">
    $('input[type=password]').focus(function(){
   clearerrormessage(this);
});
    /*
     * Handler for updating the pass
     */
    function resetPassHandler(data, txtstatus, xhr) {
        var data = eval(data);
        if (data.status == 'success') {
            var msg = data.data;
            $("#sucmsgForReset").html(msg);
            $("#sucmsgForReset").css("display", "block");
            $("#errmsgForReset").css("display", "none");
            $("#forgotReset2").click();
            $("#sucmsgForReset").fadeOut(5000, function(){
                $('#resetPasswordModal').modal("hide");
            });
            //$("#forgotReset2").click();
            //$("form").serialize()
        } else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {

                $("#errmsgForReset").html(msg);
                $("#sucmsgForReset").css("display", "none");
                $("#errmsgForReset").css("display", "block");            
                $("#errmsgForReset").fadeOut(5000);
            } else {

                if (typeof (data.error) == 'string') {

                    var error = eval("(" + data.error.toString() + ")");

                } else {
                    var error = eval(data.error);
                }


                $.each(error, function(key, val) {

                    if ($("#" + key + "_em_")) {

                        // alert(key);
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                           $("#"+key+"_em_").fadeOut(5000);
                        $("#" + key).parent().addClass('error');
                    }

                });
            }
        }
    }

function openpopup(){ 
     $('#PassPolicies').modal('show');
}

$(".policiesHelp").live('click',function(){
    $('#PassPolicies').modal('show');
});
 $(function () { $(".tooltip-options i").tooltip({html : true });});
</script>

