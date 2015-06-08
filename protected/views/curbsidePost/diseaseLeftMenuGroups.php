<!-- Pop up  Content -->

<?php
try {
    ?>
         <script type="text/javascript">
               if('<?php echo count($groups) ?>'>0)
                   {
                       $("#groupsMenu").show();


                       }
                       else
                       {
                           $("#groupsMenu").hide();

                       }
         </script>
          
                   
               <?php if(count($groups) > 0){ ?>
                   <div>

                        <?php foreach ($groups as $group) {$i=0;
                           
                       ?>
  <div class="disease_topicssectiondiv topicsClassAdmin " id="<?php echo  $group['_id']?>Mgmnt" onclick="sessionStorage.objclicked='<?php echo  $group['_id']?>Mgmnt';">
                                                <div class="disease_topic_icon">
                                                    
<div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                      <img src="<?php echo$group['GroupProfileImage'] ?>"> 
                  
                  </a>
                     </div>
                                                  
                                                </div>
                                                <div class="disease_topic_menutitle">
                                               <a href="/<?php echo  $group['GroupName'] ?> "><?php echo $group['GroupName'] ?></a>      
                                              
                         
                                                </div>
                                                </div>
                          
                          
                     
               <?php $i=$i+1;} ?> 
                       
                       
            
                      <?php } else {?>
                    <div style="text-align:center;">
                   <?php echo Yii::t('translation','No_data_found'); ?>
                   </div>
               <?php } ?> </div>
                <?php if($groupsCount>5) { ?>
                           
                             <div class="alignright clearboth paddingr10"> <a class="more" href="/groups"><?php echo Yii::t('translation','more'); ?> <i class="fa fa-youtube-play"></i></a></div>
                           
                       <?php } ?>

             
           
          

    <?php
} catch (Exception $exc) {
    
}
?>

