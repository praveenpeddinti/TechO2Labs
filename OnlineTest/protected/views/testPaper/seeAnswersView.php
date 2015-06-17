<?php
if(count($seeAnswersData)> 0){
    $seeAnswersData = $seeAnswersData["finalArray"];
    foreach($seeAnswersData as $data){ ?>

<div class="media ">
    <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner justificationUser" style="cursor:pointer" data-userid="<?php echo $data->UserId; ?>" data-name="<?php echo $data->UniqueHandle; ?>" >
                    <img src="<?php echo $data->ProfilePicture; ?>">
                  
                  </a>
                     </div>
        
         <div class="media-body">
             <div data-name="<?php echo $data->UniqueHandle; ?>" data-userid="<?php echo $data->UserId; ?>" style="cursor:pointer" class="m_title justificationUser"><?php echo $data->DisplayName; ?> says</div>
             <span id="profile_aboutme" class="m_day italicnormal justifications">

                <?php if($QuestionType ==6){ ?>                 
                       <p><b>"<?php echo $data->SeeAnswersArray;?>"</b></p>
                  <?php
                   }else if($QuestionType == 7){ ?>
                       <p class="selected_opt">User generated Ranking Options: <b>
                       <?php foreach($data->UsergeneratedRankingOptions as $Rankdata){
                           if($Rankdata!=""){
                            echo '<p><b>"'.$Rankdata.'"</b></p>';
                           }
                       } ?>
                           </b></p>
                           <?php 
                   }
                ?>
                   
             </span>
         </div>
    </div>
<?php
    }
 }else {
    echo 0;
 }
 
 ?>
