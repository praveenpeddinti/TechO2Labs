<?php if(is_array($webLinks)){
    
    ?>   
      <?php foreach($webLinks as $webLink){?>
<div class="row-fluid  customrow-fluidwl" id="rowfluid">
   


            <li class="span6 ImpressionLI" id="weblink_<?php echo $webLink['id']; ?>" data-weblinkid="<?php echo $webLink['id']; ?>" data-postid="<?php echo $webLink['id']; ?>" data-linkgroupid="<?php  echo $webLink['LinkGroupId'];?>" data-weburl="<?php  echo $webLink['WebUrl'];?>" data-categorytype="16">
               
                
                <?php //if($webLink['Xcol']==1){?>
                    <div  class="t_story_div"  id="<?php echo $webLink['DivCol']?>">
                        <div class="boxpadding">
                          
    
     
    
        <div class="mediaartifacts mediaartifactswl">
            <b style="word-wrap: break-word"><?php echo $webLink['Title']?></b>
        
           <?php if(Yii::app()->session['IsAdmin']==1){?>
       <div class="editdivwl" style='cursor: pointer'  data-id="<?php echo $webLink['id']; ?>">    
           
           <span id="EWL"  data-id="<?php echo $webLink['id']; ?>" class="fa fa-pencil-square" style="min-width:0;font-size:25px;color:#868686"></span>
                            </div>
           
                <?php }?>
        </div>
                            <div id="spinner_weblink_<?php echo $webLink['id']; ?>" style="position: relative;" class="grouppostspinner"></div>
        <div class="stream_content impressionDiv " style="padding-bottom:0">
              <?php if(isset($webLink['WebUrl'])){    ?>
                           
                                <div id="snippet_main" style="clear:both;">
                                    <div class="Snippet_div" data-weblinkid="<?php echo $webLink['id']; ?>">
                                        <a href="<?php echo $webLink['WebUrl']; ?>" target="_blank" class="pull-left quickLinkTrack">
                                            <?php if ($webLink['WebImage'] != "") { ?>
                                                <span  class=" pull-left img_single e_img margin-right10 " style="width:100px;" ><img src="<?php echo $webLink['WebImage']; ?>"></span>
                                            <?php } ?>  </a>   
                                        <div class="media-body">                                   

                                            <a class="websniplink quickLinkTrack" href="<?php echo $webLink['WebUrl']; ?>" target="_blank"> <label style="cursor: pointer" class="websnipheading"><?php echo $webLink['WebTitle'] ?></label></a>

                                            <a class="websniplink quickLinkTrack" href="<?php echo $webLink['WebUrl']; ?>" target="_blank"> <?php echo $webLink['WebUrl'] ?></a>
                                            <p><?php echo $webLink['WebDescription'] ?></p>

                                        </div>

                                    </div>
                                </div>
                          
                           <?php  }?> 
                     <div class="media-body" style="background: #f0f0f0;padding-top:10px;padding-bottom: 10px;clear:both" data-id="<?php echo $webLink['id'] ?>">
                            <div class="">
                           <?php echo $webLink['Description']?>
                                        <div class="row-fluid"><div class="span12">
                                                <b class="pull-right" style="color:#000" ><?php echo $webLink['LinkGroupName'] ?></b>
                                    </div>
                                        </div>
                               
                            </div>
                          
                   </div>
                    
                </div>
       
       
   
                            </div>
                       
                    </div>
               
                <?php // }?>
              
                </li>
    
 </div>
 <?php }?>
<?php } else {
echo $webLinks ;
        
}?>


    
