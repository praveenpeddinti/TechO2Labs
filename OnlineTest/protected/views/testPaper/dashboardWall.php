<?php if(is_array($surveyObject)){    
    $dateFormat =  CommonUtility::getDateFormat();
    ?>   
      <?php foreach($surveyObject as $data){?>
   <li class="surveylist printrest_box " style="display: list-item; " id="survey_<?php echo $data->_id;?>">
       
       
       <div class="printrest_box_style" >
        	<!-- PAGE TITLE AREA START -->
            <div class="title_area">
                <p><?php echo $data->Title; ?></p> 
                <span class="badge_count" rel="tooltip" data-original-title="Question(s)"><?php echo $data->NoofQuestions; ?></span>
            </div>
            <!-- PAGE TITLE AREA END -->
            <p class="description"><?php echo $data->Description; ?></p>
            <div class="category">
            	<ul>
                    <?php foreach($data->Category as $categoryDetails){?>
                    <li>
                        <div class="inner_li">
                            <label><?php echo $categoryDetails['NoofQuestions']; ?></label>
                            <p><?php echo $categoryDetails['CategoryName']; ?></p>
                        </div>
                    </li>
                    <?php }?>
                    
                </ul>
            </div>
            <!-- -->
            
            <div class="users_info">
            	<ul>
                    
                    <li>
                        <div class="user_inner_li">
                            <label><?php echo $data->InviteUsers; ?></label>
                            <p># Users Registered</p>
                        </div>
                    </li>
                    
                    <li>
                        <div>
                            <label><?php echo $data->TestTakenUsers; ?></label>
                            <p># Users taken Test</p>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- -->
            <div class="actions_area">
            	<ul>
                	<li id="invite_<?php echo $data->_id;?>" >  <a href="#" class="invite" data-testpaperId="<?php echo $data->_id;?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/spacer.png" rel="tooltip"  data-original-title="Invite"></a></li>
                    <li> <a href="#" class="view"><img src="images/spacer.png" rel="tooltip"  data-original-title="View"></a></li>
                    <li> <a href="#" class="edit"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/spacer.png" rel="tooltip"  data-original-title="Edit"></a></li>
                    <li> <a href="#" class="deledte"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/spacer.png" rel="tooltip"  data-original-title="Suspend"></a></li>
                </ul>
            </div>
            
        </div>
       
       
       
      
    
    
</li>
<script type="text/javascript">
$("[rel=tooltip]").tooltip();
</script>
 <?php }?>
<?php } else {
echo $surveyObject ;
        
}?>


    
