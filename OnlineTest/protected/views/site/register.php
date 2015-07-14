<section class="login_bg" style="clear:both; height:370px; "> </section >
<section style="clear:both;" >
    <div class="container"  >
<div class="customLoginform customLoginformwidth positionlogin " style=" padding-bottom:50px; margin-bottom:120px; " >
            <div class="customLoginbg marginlr0">
<div class=" pagetitlebg marginlr0 paddingbottom8 pagetitleloginbg" >
    <div class="section_pagetitle_padding padgetitle">
        <h4 class="padding-left12">Registration</h4>
        <p>Register here to start your Online Test</p>
    </div>
  
    <div class="upload_profile  ">
<div class="generalprofileicon skiptaiconwidth190x190">
<video id="video" autoplay></video>    

   
	<canvas id="canvas" width="200" height="200"></canvas>
    
</div>
         <button onclick="Captureimage()"  id="new">New</button>
     <button id="snap">Capture</button>
    <button id="upload" style="display:none;">Upload</button>
<p>Upload your Picture</p>
 </div>
    <div class="row">
        <div class="col-xs-12 ">
            <div class="reg_area">      
                <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'register-form',
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
                <div id="error" class="errorMessage" style="display: none;"></div>
                <div class="form-group loginform" id="fnamediv">
                    <label class="usernamelbl" for="FirstName" >First Name</label>
                    <?php echo $form->textField($model,'FirstName',array('maxlength' => 40, 'class' => 'form-control email')); ?>
                </div>
                <div class="control-group controlerror"> 
                    <?php echo $form->error($model, 'FirstName'); ?>
                </div>
                <div class="form-group loginform" id="lnamediv">
                    <label class="lnamelbl" for="LastName" >Last Name</label>
                    <?php echo $form->textField($model,'LastName',array('maxlength' => 40, 'class' => 'form-control email')); ?>
                </div>
                <div class="control-group controlerror"> 
                    <?php echo $form->error($model, 'LastName'); ?>
                </div>
                <div class="form-group loginform" id="emaildiv">
                    <label class="emailbl" for="Email" >Email</label>
                    <?php echo $form->textField($model,'Email',array('maxlength' => 40, 'class' => 'form-control email')); ?>
                </div>
                <div class="control-group controlerror"> 
                    <?php echo $form->error($model, 'Email'); ?>
                </div>
                <div class="form-group loginform" id="phonediv">
                    <label class="phonelbl" for="Phone" >Phone</label>
                    <?php echo $form->textField($model,'Phone',array('maxlength' => 10, 'class' => 'form-control email','onkeypress' => "return isNumberKey(event)")); ?>
                </div>
                <div class="control-group controlerror"> 
                    <?php echo $form->error($model, 'Phone'); ?>
                </div>
                  <?php echo $form->hiddenField($model,'Imagesrc'); ?>
                
                <div class="form-group loginform" id="idproofdiv" >
                <label class="idproof" for="idproof" >Select Id Proof</label>
                    <input type="hidden" name="UserRegistrationForm[IdentityProof]" id="UserRegistrationForm_IdentityProof" />
                 <div class="customselectformdiv" style="position: relative">
                    <select class="form-control styled" style="width: 100%;height:43px;margin-bottom:0" name="IdentityProof" id="IdentityProof"  >
                    <option value=""> </option>
                    <option value="Pancard">Pancard</option>                                      
                    <option value="Passport">Passport</option>
                    <option value="Driving Licence">Driving Licence</option> 
                </select>
                 </div>
                </div>
                <div class="control-group controlerror">
                      <?php echo $form->error($model, 'IdentityProof'); ?>
                </div>
                
                <div class="form-group loginform" id="pancarddiv" style="display:none">
                    <label class="pancardlbl" for="Pancard" >Card Number</label>
                    <?php echo $form->textField($model,'CardNumber',array('maxlength' => 40, 'class' => 'form-control email')); ?>
                </div>
                <div class="control-group controlerror"> 
                    <?php echo $form->error($model, 'CardNumber'); ?>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                    <?php
                    echo CHtml::ajaxSubmitButton('Register', array('site/registration'),array(
                        'type'=>'POST',
                        'dataType' => 'json',
                        'error'=>'function(error){
                        }',
                        'beforeSend' => 'function(){
                              
                                                     

                           
                            
                        }',
                        'complete' => 'function(){
                        }',
                        'success' => 'function(data,status,xhr) { testInviteLogincallback(data,status,xhr);}'),
                            array('type' => 'submit','class'=>'btn btn-primary btn-raised btn-custom')
                        );
                    ?> 
                    </div><!--end .col -->
                </div><!--end .row -->
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
    </div>
</section>
 
<script type="text/javascript">
    Custom.init();
   /*$("#loginId").bind("click",function(){
       var data = $("#login-form").serialize();
        $.ajax({
                type: 'POST',
                url: 'site/login',
                data: data,
                success: logincallback,
                error: function(data) { // if error occured
                     
                    // alert(data.toSource());
                },
                dataType: 'json'
            });
   });*/
   
   $("#IdentityProof").change(function(){
       
        var val = $(this).val();
        if(val==''){$("#pancarddiv").hide()}else{$("#pancarddiv").show();};
        $("#UserRegistrationForm_IdentityProof").val(val);
        //alert("-----"+$("#UserRegistrationForm_IdentityProof").val());
    });
    function testInviteLogincallback(data, txtstatus, xhr) {
        var data = eval(data);
        alert(data.toSource())
        if (data.status == 'success') {
                    window.location = '/site/privacyPolicy';
        }else {
            var lengthvalue = data.error.length;
            var msg = data.data;
            var error = [];
            if (msg != "") {
                if (data.error == "Test taker doesnot exist."){ 
                    $("#error").text(data.error);
                    $("#error").show();
                    $("#error").fadeOut(5000);
                    $("#error").parent().addClass('error');
                }
                if (data.error == "Test taker already taken Test."){ 
                    $("#error").text(data.error);
                    $("#error").show();
                    $("#error").fadeOut(5000);
                    $("#error").parent().addClass('error');
                }
                if (data.error == "Test taker not allowed."){ 
                    $("#error").text(data.error);
                    $("#error").show();
                    $("#error").fadeOut(5000);
                    $("#error").parent().addClass('error');
                }
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
                        $("#" + key).parent().addClass('error');
                    }

                });
            }
        }
    }
    

    function Captureimage(){
        
     var canvas = document.getElementById("canvas"),
				context = canvas.getContext("2d"),
				video = document.getElementById("video"),
				videoObj = { "video": true },
				errBack = function(error) {
					console.log("Video capture error: ", error.code); 
				};

			// Put video listeners into place
			if(navigator.getUserMedia) { // Standard
				navigator.getUserMedia(videoObj, function(stream) {
					video.src = stream;
					video.play();
				}, errBack);
			} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
				navigator.webkitGetUserMedia(videoObj, function(stream){
					video.src = window.webkitURL.createObjectURL(stream);
					video.play();
				}, errBack);
			} else if(navigator.mozGetUserMedia) { // WebKit-prefixed
				navigator.mozGetUserMedia(videoObj, function(stream){
					video.src = window.URL.createObjectURL(stream);
					video.play();
				}, errBack);
			}

			// Trigger photo take
			document.getElementById("snap").addEventListener("click", function() {
				//context.drawImage(video, 0, 0, 250, 250);
                                context.drawImage(video, 0, 0, 640, 480);
				// Littel effects
				$('#video').fadeOut('slow');
				$('#canvas').fadeIn('slow');
				$('#snap').hide();
				$('#new').show();
                                  $("#UserRegistrationForm_Imagesrc").val(canvas.toDataURL());
				// Allso show upload button
				//$('#upload').show();
			});
			
			// Capture New Photo
			document.getElementById("new").addEventListener("click", function() {
				$('#video').fadeIn('slow');
				$('#canvas').fadeOut('slow');
				$('#snap').show();
				$('#new').hide();
			});
			// Upload image to sever 
			document.getElementById("upload").addEventListener("click", function(){
				var dataUrl = canvas.toDataURL();
				$.ajax({
				  type: "POST",
				  url: "camsave.php",
				  data: { 
					 imgBase64: dataUrl
				  }
				}).done(function(msg) {
				  console.log('saved');
				 // Do Any thing you want
				});
			});   
    }
    
 sessionStorage.clear();
    </script>