 <?php
 if(count($justficationData)> 0){
  $OptionName = $justficationData["OptionName"];
  $LabelName = $justficationData["LabelName"];
  $justficationData = $justficationData["finalArray"];
 foreach($justficationData as $data){
     
if($QuestionType !=8){
     
     ?>



<div class="media ">
    <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner justificationUser" style="cursor:pointer" data-userid="<?php echo $data->UserId?>" data-name="<?php echo $data->UniqueHandle?>" >
                       <img src="<?php echo $data->ProfilePicture?>"> 
                  
                  </a>
                     </div>
            
            <div class="media-body">
                <div data-name="<?php echo $data->UniqueHandle?>" data-userid="<?php echo $data->UserId?>" style="cursor:pointer" class="m_title justificationUser"><?php echo $data->DisplayName?> says</div>
                <span id="profile_aboutme" class="m_day italicnormal justifications">
                    
                    <?php 
                    
                    
                    foreach ($data->JustficationsArray as $key=>$value) {
                        
                        if(!empty($value)){
                        ?>
                   
                    <p><?php echo $OptionName[$key];?> <b>: "<?php echo $value;?>"</b></p>
                            
                        <?php    }}?>
                    
                    
<!--                    <p class="selected_opt">Selected Options: <b> <?php 
//foreach ($data->SelectedOptions as $key=>$v) {
//    echo "<br/>".$OptionName[$key]." - ".$LabelName[$v-1]."";
//}
                  //  echo implode(",",$data->SelectedOptions) 
                            
                            
                            
                            
                            ?></b></p> -->
                </span>
            </div>
        </div>

 <?php }else{
     ?>
<div class="media ">
    <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner justificationUser" style="cursor:pointer" data-userid="<?php echo $data->UserId?>" data-name="<?php echo $data->UniqueHandle?>">
                       <img src="<?php echo $data->ProfilePicture?>"> 
                  
                  </a>
                     </div>
            
            <div class="media-body">
                <div data-name="<?php echo $data->UniqueHandle?>" data-userid="<?php echo $data->UserId?>" style="cursor:pointer" class="m_title justificationUser"><?php echo $data->DisplayName?> says</div>
                <span id="profile_aboutme" class="m_day italicnormal justifications">
                    
                  
                    
                      <p><b>"<?php echo $data->JustficationsArray;?>"</b></p>
                  
                 
                            
                       
                    
                    
                    <p class="selected_opt">Selected Options: <b> <?php 
                    $selectedOptions = array();
         foreach ($data->SelectedOptions as $v) {
             array_push($selectedOptions,$OptionName[$v-1]) ;
         }
               echo implode(",", $selectedOptions);   
                            
                            ?></b></p> 
                </span>
            </div>
        </div>
<?php
 }
 }
 }else {
     echo 0;
 }
 
 ?>
