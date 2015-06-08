<div class="row-fluid padding10top">
             
         <div class="span12">
         
             <div id="profilesuccess" class="alert alert-success margintop5 " style="display: none"></div>
                
            <div class="tab-content" id="myTabContent">
                
              <div id="home" class="tab-pane fade in active">
                   <?php
                  
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'userregistration-form',
                            'method'=>'post',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'htmlOptions' => array('enctype' => 'multipart/form-data'),
                                ));
                        ?>
               
                     <div class="alert-error" id="login_error">
                      <?php echo $form->error($UserRegistrationModel, 'firstName', array("inputID" => "UserRegistrationForm_firstName")); ?>
                      <?php echo $form->error($UserRegistrationModel, 'lastName', array("inputID" => "UserRegistrationForm_lastName")); ?>
                       <?php echo $form->error($UserRegistrationModel, 'email', array("inputID" => "UserRegistrationForm_email")); ?>
                      
                         <?php echo $form->error($UserRegistrationModel, 'password', array("inputID" => "UserRegistrationForm_password")); ?>
                         <?php echo $form->error($UserRegistrationModel, 'confirmpassword', array("inputID" => "UserRegistrationForm_confirmpassword")); ?>
                         <?php echo $form->error($UserRegistrationModel, 'zip', array("inputID" => "UserRegistrationForm_zip")); ?>
                       
                      <?php echo $form->error($UserRegistrationModel, 'field1', array("inputID" => "UserRegistrationForm_field1")); ?>
                      <?php echo $form->error($UserRegistrationModel, 'field2', array("inputID" => "UserRegistrationForm_field2")); ?>
                      
                  </div>
                  <?php
                    if($message !=""){
                        echo $message;
                    }
                  ?>

                  
              <div class="row-fluid">
                 
              <div class="span12">
                  
              
              <div class="span8">
                  <div class="row-fluid">
                       <div class="span12">
                  <div class="span6">
                        <div class="control-group">
                        <label>Fisrtname</label>
                         <?php echo $form->textField($UserRegistrationModel, 'firstName', array("id" => "UserRegistrationForm_firstName", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
        <!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                      </div>
                  </div>
                    <div class="span6">
                        <div class="control-group">
                  <label>Lastname</label>
                  <?php echo $form->textField($UserRegistrationModel, 'lastName', array("id" => "UserRegistrationForm_lastName", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
<!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                        </div>
                    </div>
                      
                      </div></div>
                  <div class="row-fluid">
                       <div class="span12">
                  <div class="span6">
                        <div class="control-group">
                        <label>City</label>
                         <?php echo $form->textField($UserRegistrationModel, 'city', array("id" => "UserRegistrationForm_city", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
        <!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                      </div>
                  </div>
                    <div class="span6">
                        <div class="control-group">
                  <label>State</label>
                  <?php echo $form->textField($UserRegistrationModel, 'state', array("id" => "UserRegistrationForm_state", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
<!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                        </div>
                    </div>
                      
                      </div></div>
                  <div class="row-fluid">
                       <div class="span12">
                  <div class="span6">
                        <div class="control-group">
                        <label>Zip</label>
                         <?php echo $form->textField($UserRegistrationModel, 'zip', array("id" => "UserRegistrationForm_zip", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
        <!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                      </div>
                  </div>
                   <div class="span6">
                        <div class="control-group">
                        <label>Select Country:</label>
                       <select id="UserRegistrationForm_country"  class="input-username big span12"  name="UserRegistrationForm[country]" > 
             
                            <option   value="PleaseSelect">Please Select Country</option>
                            <?php 

                                       foreach ($countries as $value) {
                                                   echo '<option   value='.$value->name.'>'.$value->name.'</option>';      
                                                   }
                            ?>

                        </select>
                        
        <!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                      </div>
                  </div>
                      
                      </div></div>
                   <div class="row-fluid">
                       <div class="span12">
                  <div class="span6">
                        <div class="control-group">
                        <label>Display Name</label>
                         <?php echo $form->textField($UserRegistrationModel, 'displayName', array("id" => "UserRegistrationForm_displayName", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
        <!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                      </div>
                  </div>
                           
                     <div class="span6">
                        <div class="control-group">
                        <label>Email</label>
                         <?php echo $form->textField($UserRegistrationModel, 'email', array("id" => "UserRegistrationForm_email", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
        <!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                      </div>
                  </div>      
                      </div></div>
                  
                
               
                   <div class="row-fluid">
                       <div class="span12">
                            <div class="span6">
                        <div class="control-group">
                        <label>Password</label>
                         <?php echo $form->passwordField($UserRegistrationModel, 'password', array("id" => "UserRegistrationForm_password", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
        <!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                      </div>
                  </div> 
                           
                       <div class="span6">
                        <div class="control-group">
                        <label>Confirm Password</label>
                         <?php echo $form->passwordField($UserRegistrationModel, 'confirmpassword', array("id" => "UserRegistrationForm_confirmpassword", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
        <!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                      </div>
                  </div> 
                      </div></div>

                  <div class="row-fluid">
                       <div class="span12">
                  <div class="span6">
                        <div class="control-group">
                        <label>Are you a pharmacist</label>
                         <?php 
                        
                   //   echo    $form->radioButton($UserRegistrationModel,'isPharmacist',array('label' => 'YES',"id"=>"UserRegistrationForm_isPharmacist", 'value'=>'1'));
                         echo $form->radioButton($UserRegistrationModel,'isPharmacist',array('value'=>1,"id"=>"UserRegistrationForm_isPharmacist",'uncheckValue'=>null));     
                      ?>
                        Yes
                        <?php 
                        
                      echo $form->radioButton($UserRegistrationModel,'isPharmacist',array('value'=>0,"id"=>"UserRegistrationForm_isPharmacist",'uncheckValue'=>null));     
                         
                      
                      
                      ?>No
        <!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                      </div>
                  </div>
                    <div class="span6">
                        <div class="control-group">
                  <label>State License Number</label>
                  <?php echo $form->textField($UserRegistrationModel, 'statelicensenumber', array("id" => "UserRegistrationForm_statelicensenumber", 'maxlength' => '50', 'class' => 'input-username big span12', 'placeholder' => "Dr.Theodore Search, Ted")); ?>
<!--                <input type="text" placeholder="Dr.Theodore Search, Ted" id="inputEmail" class="span9">-->
                        </div>
                    </div>
                      
                      </div></div>
                  
                 
              	 <div class="row-fluid">
                     <div class="span12">
                         <div class="text-right1 ">
                            
<!--              <input name="" type="button" value="Clear" class="btn btn-info "> -->
              <input name="userregistration"  id="userregistration" type="submit" value="Submit" class="btn btn-info ">
                   
               
              </div> 
                         
                     </div>
                 </div>
              </div>
           
              </div>
          

               </div>
          
              
                  <?php $this->endWidget(); ?>
                
       </div>
              
            </div>
             
         
        
                

       
               
             
             
             
             
             
         </div>
       
          </div>
  