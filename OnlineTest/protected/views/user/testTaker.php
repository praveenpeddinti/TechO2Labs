<div id="enrollmentPopupId" >
    <div class="alert alert-success" id="sucmsg" style='text-align:center;display:none;'></div>
    <div class="form-inline" id="defaultView"> 
        <div class="row-fluid">
            <div class="span6">
                 <div class="form-group">
                    <label class="radioaalignment"> <input class="styled" type="radio" id="csvUpload" name="change" onclick="changeViewInPopu(this)" class=""/> Multiple users </label>
                </div>
            </div>
            <div class="span6">
               <div class="form-group">
                    <label class="radioaalignment"><input class="styled" type="radio" id="manually" name="change" onclick="changeViewInPopu(this)" class=""/> Single user</label>
                </div> 
            </div>
        </div>
    </div>

    <!-- Single Entry Test Taker Form---->
    <div id="enrollmentFormDiv" style="display: none;">
        <div class="form-inline"  >
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'testtaker-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array(
                    'style' => 'margin: 0px; accept-charset=UTF-8',
                ),
            ));
            ?>
            <div id="reg_error" class="alert-error"></div> 
            <div class="form-group loginform" >
            <div class="row-fluid">
                <div class="span12">
                    <div class="span6">
                          <label class="usernamelbl" for="userName" >First Name</label>
                    <?php echo $form->textField($takerForm, 'FirstName', array('id' => 'TestTakerForm_FirstName', 'maxlength' => 50, 'class' => 'span12')); ?>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($takerForm, 'FirstName'); ?>
                    </div>
                    </div>
                    <div class="span6">
                        <label class="usernamelbl" for="userName" >Last Name</label>
                    <?php echo $form->textField($takerForm, 'LastName', array('id' => 'TestTakerForm_LastName', 'maxlength' => 50, 'class' => 'span12')); ?>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($takerForm, 'LastName'); ?>
                    </div>
                    </div>
                </div>
                </div>
                 </div>
            
            <div class="form-group loginform" >
                  <div class="row-fluid">
                    <div class="span12">
                    <div class="span12">
                        <label class="usernamelbl" for="userName" >Email</label>
                    <?php echo $form->textField($takerForm, 'Email', array('id' => 'TestTakerForm_Email', 'maxlength' => 50, 'class' => 'span12')); ?>
                    <div class="control-group controlerror">  
                        <?php echo $form->error($takerForm, 'Email'); ?>
                    </div>
                    </div>
                   
                </div>
                  </div>
                  </div>
                 <div class="form-group loginform" >
                     <div class="row-fluid">
                    <div class="span12">
                    <div class="span6">
                        <label class="usernamelbl" for="userName" >Phone</label>
                    <?php echo $form->textField($takerForm, 'Phone', array('id' => 'TestTakerForm_Phone', 'maxlength' => 10, 'class' => 'span12','onkeypress' => "return isNumberKey(event)")); ?>
                    <div class="control-group controlerror"> 
                        <?php echo $form->error($takerForm, 'Phone'); ?>
                    </div>
                    </div>
                    <div class="span6">
                        <label class="usernamelbl" for="userName" >Qualification</label>
                        <?php echo $form->dropdownlist($takerForm, 'Qualification', array('' => 'Select', 'MCA' => 'MCA', 'MBA' => 'MBA', 'B.Tech' => 'B.Tech', 'MS' => 'MS'), array('id' => 'TestTakerForm_Qualification')); ?>
                        <div class="control-group controlerror"> 
                            <?php echo $form->error($takerForm, 'Qualification'); ?>
                        </div>
                    </div>
                </div>
                </div>                   
                </div>
        <div  class="row-fluid">
            <div class="span12" style="padding:5px;text-align:right">
                <?php echo CHtml::Button('Save', array('onclick' => 'saveEnrollmentForm()', 'class' => 'btn btn-warning', 'id' => 'enrollmentButtonId')); ?> 
                <?php echo CHtml::resetButton('Clear', array("id" => 'enrollmentResetId', 'class' => 'btn btn-primary btn-info', "style" => 'display:none;')); ?>
            </div>	
        </div>
            <?php $this->endWidget(); ?> 
            </div>
    </div>

    <!-- Bulk uploaded Test Taker Form---->
    <div id="uploadCsvForm" style="display: none;">
        <div class="form"  >
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'CSV-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array('enctype' => 'multipart/form-data'
                ),
            ));
            ?>
            <div class="alert-error fade in" id="csv_error" style='position: relative;padding: 10px;word-wrap:break-word'></div>
            <div class="form-inline" id="defaultView"> 
                <div class="form-group">
                    <label>Upload CSV File</label>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <span class=""><span class="fileupload-new">Select file</span><input type="file" name="csvfiletype[]" id="csvfiletype" onchange="checkCSVFile(this, 'csv_error')"/></span>
                        <div id="uploadedfilename" style="font-size: 14px;"></div>
                <!--        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>-->
                    </div>
                </div>
                <div class="form-group" style="padding-top:10px">
                    <label>Delimeter</label>
                    <?php echo $form->dropdownlist($csvModel, 'delimeter', array('2' => 'Comma(,)', '1' => 'Tab(\t)', '3' => 'Semicolon(;)'), array('id' => 'CSVForm_delimeter')); ?>
                </div>
                <div class="form-group" >
                    <?php
                        $link = '<div id="schedule_download" style="text-align:right">Download sample CSV file</div>';
                        echo CHtml::link($link, array('/user/downloadCSVFile'));
                    ?>
                </div>
            </div>
        </div>
        <div  class="row-fluid">
            <div class="span12 alignright" style="padding:5px;">
                <?php echo CHtml::resetButton('Clear', array("id" => 'csvResetId', "style" => 'display:none;')); ?>
                <?php echo CHtml::Button('Import', array('onclick' => 'ajaxCSVUpload()', 'class' => 'btn btn-warning', 'id' => 'csvButtonId')); ?> 
            </div>
        </div>
            <?php $this->endWidget(); ?>
    </div>
</div>  
<script type="text/javascript">
    Custom.init();
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
    function changeViewInPopu(obj){ 
        $("#enrollmentResetId").click();         
        $("#csvResetId").click();
        if(obj.id == "manually"){
            $("#statusFields,#familyFields").hide();
            $("#enrollmentFormDiv").show();
            $("#uploadCsvForm").hide();
            $("#employeeId_enrollment").show();
        }else{
            $("#csv_error").html("");
            $("#csv_error").hide();
            $("#csvUpload").is("checked");
            $("#enrollmentFormDiv").hide();
            $("#uploadCsvForm").show();
        }
    }
    
    function saveEnrollmentForm(){
        $("#enrollmentButtonId").val("Please wait...");
        var data=$("#testtaker-form").serialize();
        $.ajax({
            type: 'POST',
            dataType:'json',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/user/saveEnrollmentData"); ?>',
            data:data,
            success:enrollmentFormHandler,
            error: function(data) { // if error occured
                console.log("Error occured.please try again");
            }
        });
    }
    
    function enrollmentFormHandler(data){ 
        $("#enrollmentButtonId").val("Save");
        if(data.status=='success'){
            $("#sucmsg").css("display", "block");
            $("#sucmsg").html("New Test taker added Successfully.").fadeOut(8000,"linear",function(){
                getUsermanagementDetails(0, '', '');
            });
        $("#employeeId_enrollment").hide();
        }else{
            var lengthvalue = data.error.length;            
            var error = [];
            if (typeof (data.error) == 'string') {
                var error = eval("(" + data.error.toString() + ")");
            } else {
                var error = eval(data.error);
            }
            $.each(error, function(key, val) {                
                    if ($("#" + key + "_em_")) {
                        $("#" + key + "_em_").text(val);
                        $("#" + key + "_em_").show();
                        $("#" + key + "_em_").fadeOut(10000);
                        $("#" + key).parent().addClass('error');
                    }
            });
        }   
    }
    
   
    function importCSVFile(){
        var data=$("#CSV-form").serialize();
        $("#csv_error").html("");
        $("#csv_error").hide();
        var queryString = "file"
        
        $.ajax({
            type: 'POST',
            dataType:'json',
            url: '<?php echo Yii::app()->createAbsoluteUrl("/user/manageFile"); ?>',
            data:data,
            success:CSVFileHandler,
            error: function(data) { // if error occured
                alert("Error occured.please try again");
                //                alert(data.toSource());
            }
        });
    }
    function CSVFileHandler(data){
        //        alert(data.toSource())
    }
    
    function checkCSVFile(obj,errId) {
        $("#errId").html("");
        var fup = obj;
        var fileName = fup.value;
        var id = fup.id;
        var msg = "";
        var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
        if(ext == "csv" || ext == "CSV")
        {
            
            msg = GetFileSize(id);
            if(msg == ""){
                $("#"+errId).text();                                    
                $("#"+errId).hide();
                $("#"+id).parent().removeClass('error'); 
                return true;
            }else if(msg != ""){
                setErrorMsg(id,errId,msg);
                fup.focus();
                $("#uploadedfilename").html("").hide();
                return false;
            }
        } 
        else {
            msg = "Invalid file format. Only CSV is allowed";     
            setErrorMsg(id,errId,msg); 
            $("#csv_error").fadeOut(5000,'');
            $("#csvResetId").click();
            $("#csvButtonId").val("Import");
            $("#uploadedfilename").html("").hide();
            fup.focus();
            return false;
        }
    }
    
    function ajaxCSVUpload(){ 
        var fileId = "csvfiletype";
        var delimiter = $("#CSVForm_delimeter").val();
        $("#csvButtonId").val("Please wait...");
        $("#uploadedfilename").html("").hide();
        //        alert($("#"+fileId).val())
        if($("#"+fileId).val() != "" && delimiter != ""){
            //scrollPleaseWait();
            $.ajaxFileUpload(
            {
                type:'POST',
                data :{},
                url:'/user/manageFile?max_size=100&delimiter='+delimiter,
                secureuri:false,
                dataType:'json',
                fileElementId:fileId,
                success: function(data1){
                                        
                    $("#csvButtonId").val("Import");
                    if(data1.status == "success"){
                        $("#csvResetId").click();
                        $("#enrollmentPopupId").modal('hide');
                        $("#uploadedfilename").html("").hide();
                        //getEnrollments(0);
                        $("#sucmsg").css("display", "block");
                        $("#sucmsg").html("New Test taker added Successfully.").fadeOut(10000,"linear",function(){
                        getUsermanagementDetails(0, '', '');
                        });
            
                         
                    }else{
                        scrollPleaseWaitClose();
                        $("#csvResetId").click();
                        var error = [];
                        if(typeof(data1.error)=='string'){
                            var error=eval("("+data1.error.toString()+")");
                        }else{
                            var error=eval(data1.error);
                        }
                        //                    for(var i=0; i<(data1.error).length;i++){
                        //                        
                        //                    }
                        $("#csv_error").html("<b>Error(s) while uploading csv file.</b> <br/> ");
                        $.each(error, function(key, val) {
                            //                            commonErrorDiv(val,'csv_error')
                            $("#csv_error").append(val+'<br/><br/>');
                            $("#csv_error").show();                        
                            $("#csv_error").parent().addClass('error');
                            $("#csv_error").fadeOut(5000,'');

                        }); 
                        // error section..
                    }
                
                },
                error: function (data)
                {
                    alert('error');
                }
            }
        );
        }else{
            $("#csv_error").html("Please choose .csv file");
            $("#csv_error").show();                        
            $("#csv_error").parent().addClass('error');
            $("#csv_error").fadeOut(5000,'');
            $("#csvButtonId").val("Import");
        }
        
           
    }
</script>