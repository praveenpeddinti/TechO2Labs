<?php if(is_array($webLinks)){
    
    ?>   
    <div id='SaveAndCancelDND' class="searchgroups searchgroupswl" >  
<input onclick="saveDrragAndDrop()" class="btn " id='SaveDND' name="commit" type="submit" data-toggle="dropdown" value="Save" /> 
<input onclick="cancelDND()" class="btn btn_gray " id='CancelDND' name="commit" type="submit" data-toggle="dropdown" value="Cancel" /> 
</div>
<div class="row-fluid customrow-fluidwl" id="rowfluid">
   


            <li class="span6 column" id="s41">
                 <?php foreach($webLinks as $webLink){?>
                
                <?php if($webLink['Xcol']==1){?>
                    <div  class="t_story_div dragbox"  id="<?php echo $webLink['DivCol']?>">
                        <div class="boxpadding dragbox-content">
                          
    
     
    
        <div class="mediaartifacts"><a href="<?php echo $webLink['WebUrl']?>" target="_blank" class="group" ><b style="word-wrap: break-word"><?php echo $webLink['WebUrl']?></b></a></div>
        <div class="stream_content " style="padding-bottom:0">
              <?php if(isset($webLink['WebUrl'])){    ?>
                           
                                <div id="snippet_main" style="clear:both;">
                                    <div class="Snippet_div" >
                                        <a href="<?php echo $webLink['WebUrl']; ?>" target="_blank" class="pull-left">
                                            <?php if ($webLink['WebImage'] != "") { ?>
                                                <span  class=" pull-left img_single e_img margin-right10 " style="width:100px;" ><img src="<?php echo $webLink['WebImage']; ?>"></span>
                                            <?php } ?>  </a>   
                                        <div class="media-body">                                   

                                            <a class="websniplink" href="<?php echo $webLink['WebUrl']; ?>" target="_blank"> <label style="padding-left: 10px;cursor: pointer" class="websnipheading"><?php echo $webLink['WebTitle'] ?></label></a>

                                            <a class="websniplink" href="<?php echo $webLink['WebUrl']; ?>" target="_blank"> <?php echo $webLink['WebUrl'] ?></a>
                                            <p><?php echo $webLink['WebDescription'] ?></p>

                                        </div>

                                    </div>
                                </div>
                          
                           <?php  }?> 
                   <div class="media-body" style="background: #f0f0f0;padding-top:10px;padding-bottom: 10px;clear:both" data-id="<?php echo $webLink['id'] ?>">
                            <div class="">
                           <?php echo $webLink['Description']?>
                            </div>
                   </div>
                    
                </div>
       
        
   
                            </div>
                    </div>
                <?php }?>
               <?php }?>
                </li>
    <li class="span6 column" id="s42">
         <?php foreach($webLinks as $webLink){?>
                    <?php if($webLink['Xcol']==2){?>
                    <div  class="t_story_div dragbox"  id="<?php echo $webLink['DivCol']?>">
                        <div class="boxpadding dragbox-content">
                          
        <div class="mediaartifacts"><a href="<?php echo $webLink['WebUrl']?>" target="_blank" class="group" ><b style="word-wrap: break-word"><?php echo $webLink['WebUrl']?></b></a></div>
        <div class="stream_content " style="padding-bottom:0">
              <?php if(isset($webLink['WebUrl'])){    ?>
                           
                                <div id="snippet_main" style="clear:both;">
                                    <div class="Snippet_div" >
                                        <a href="<?php echo $webLink['WebUrl']; ?>" target="_blank" class="pull-left">
                                            <?php if ($webLink['WebImage'] != "") { ?>
                                                <span  class=" pull-left img_single e_img margin-right10 " style="width:100px;" ><img src="<?php echo $webLink['WebImage']; ?>"></span>
                                            <?php } ?>  </a>   
                                        <div class="media-body">                                   

                                            <a class="websniplink" href="<?php echo $webLink['WebUrl']; ?>" target="_blank"> <label style="padding-left: 10px;cursor: pointer" class="websnipheading"><?php echo $webLink['WebTitle'] ?></label></a>

                                            <a class="websniplink" href="<?php echo $webLink['WebUrl']; ?>" target="_blank"> <?php echo $webLink['WebUrl'] ?></a>
                                            <p><?php echo $webLink['WebDescription'] ?></p>

                                        </div>

                                    </div>
                                </div>
                          
                           <?php  }?> 
                    <div class="media-body" style="background: #f0f0f0;padding-top:10px;padding-bottom: 10px;clear:both" data-id="<?php echo $webLink['id'] ?>">
                            <div class="">
                           <?php echo $webLink['Description']?>
                            </div>
                   </div>
                    
                </div>
       
        
   
                            </div>
                    </div>
               <?php }?>
                
               
   
<?php }?>
         </li>
 </div>
<?php } else {
echo '-1' ;
        
}?>

<script type="text/javascript" src="<?php echo YII::app()->getBaseUrl()?>/js/jquery-ui.min.js" ></script>
<script type="text/javascript" src="<?php echo YII::app()->getBaseUrl()?>/js/jquery.ui.touch-punch.min.js"></script>

<script type="text/javascript">
       $(function(){
        $('.dragbox')
        .each(function(){
	
        });
        $('.column').sortable({
            connectWith: '.column',
            handle: 'div',
            cursor: 'move',
        //  placeholder: 'placeholder',
            forcePlaceholderSize: true,
            opacity: 0.4,
            stop: function(event, ui){
                $(ui.item).find('div').click();
                var sortorder='';
                $('.column').each(function(){
                    var itemorder=$(this).sortable('toArray');                    
                                              
                    sortorder+=itemorder.toString()+'#';
                });
                //alert('SortOrder: '+sortorder);
                //dragupdate(sortorder);
                
                dragcomplete=sortorder;
  
            }
        })
        .disableSelection();
    });
    </script>
    
