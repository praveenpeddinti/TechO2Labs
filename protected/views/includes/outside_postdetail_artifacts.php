 <?php  if(sizeof($data->Resource)>0){  ?>    
        <div class="postartifactsdiv padding5">
        
            <div class="chat_subheader "><?php echo Yii::t('translation','Artifacts'); ?></div>

        <div class="row-fluid padding8top detailed_media">
                            <div class="span12">
                               <?php  
                    foreach($data->Resource as $res){
                         if(isset($res['Extension'])){
                        $ext = strtolower($res['Extension']);
                         //                        if($ext=='ppt'||$ext=='pptx'){
//                         $image="/images/system/PPT-File-icon.png";
//                    }else if($ext=='pdf'){
//                         $image="/images/system/pdf.png";
//                    }else if($ext=='doc' || $ext=='docx'){
//                         $image="/images/system/MS-Word-2-icon.png";
//                    }else if($ext=='exe' || $ext=='xls'|| $ext=='xlsx'|| $ext=='ini'){
//                         $image="/images/system/Excel-icon.png";
//                    } else if ($ext == 'txt') {
//                            $image = "/images/system/notepad-icon.png";
//                    }
                        if(isset($res['ThumbNailImage'])){
                               $image=$res['ThumbNailImage'];
                           }else{
                               $image="";
                           }
    
                    if($ext == "mp3"){?>
                            <div class="span3"> 

                                <div class="d_img_outer_video_play" >

                                <img style="cursor:pointer;" src="/images/system/audio_img.png" data-uri="<?php  echo $res['Uri'];?>" data-format="<?php  echo $ext;?>" id="videodivid"/>
                            </div>
                            </div>
                    
                      <?php  }else if($ext == "mp4" || $ext == 'flv' || $ext == 'mov'){
                         if($categoryType!=3){
                             $videoclassName = 'PostdetailvideoThumnailDisplay';
                         }else{
                              $videoclassName = 'GroupPostdetailvideoThumnailDisplay';
                         }
                            
                          
                          
                          ?>
                            <div class="span3"> 

                                <div class="d_img_outer_video_play" style="cursor:pointer;" ><div  class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div>

                                <img style="cursor:pointer;" src='<?php echo $image; ?>' data-uri="<?php  echo $res['Uri'];?>" data-format="<?php  echo $ext;?>" id="videodivid"/>
                            </div>
                            </div>
                        <?php  }else  if($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif"){?>
                            <div class="span3">
                                <div class="d_img_outer_video_play" >
                                <img style="cursor:pointer;" src="<?php  echo $res['Uri'];?>" data-uri="<?php echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$res['Uri']);?>" id="imageimgdivid" data-format="<?php  echo $ext;?>" class="imageimgdivid"/>
                                </div>
                            </div>
                    <?php  }else  if($ext == "pdf" || $ext == "txt"){                   
                    ?>
                            <div class="span3"> 
                                <div class="d_img_outer_video_play" >
                                     <img  id="artifactOpen" style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $res['Uri'];?>" data-format="<?php  echo $ext;?>" id="pdfdivid"/>
        
                                </div>  
                            </div>
                    <?php }else{ ?> 
                            <div class="span3"> 
                                <div class="">
                                     <a href="/post/fileopen/?file=<?php  echo $res['Uri'];?>"  id="downloadAE"><img  id="artifactOpen" style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $res['Uri'];?>" data-format="<?php  echo $ext;?>" id="pdfdivid"/> </a>    
        
        </div>
                            </div>
                            
                        <?php  }
                    
                    
                        } }?>
                    
                            </div>
                            </div>
        </div>
                 <?php  } ?>