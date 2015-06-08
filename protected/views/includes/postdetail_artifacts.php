                         <?php 
                         
                          $ResourceArray=array();
                          $ResourceUriArray=array();
                          $ResourceDetails=array();
                         foreach($data->Resource as $key => $res){
                             
                             if (isset($res['Extension'])) {
                                 $ext = strtolower($res['Extension']);

                                 if (isset($res['ThumbNailImage'])) {
                                     $image = $res['ThumbNailImage'];
                                 } else {
                                     $image = "";
                                 }
                                 
                             
                                if ($ext == "mp3") {

                                    $ResourceArray[$key] = "/images/system/audio_img.png";
                                     $ResourceUriArray[$key]=$res['Uri'];
                                } else if ($ext == "mp4" || $ext == 'flv' || $ext == 'mov') {

                                    $ResourceArray[$key] = $image;
                                     $ResourceUriArray[$key]=$res['Uri'];
                                } else if ($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif") {
                                    $ResourceArray[$key] = $res['Uri'];
                                    if( $data->CategoryType==3){
                                        $ResourceUriArray[$key]=str_replace('/upload/public/thumbnails/','/upload/group/images/',$res['Uri']);
                                    }else{
                                        $ResourceUriArray[$key]=str_replace('/upload/public/thumbnails/','/upload/public/images/',$res['Uri']);
                                    }
                                     
                                } else if ($ext == "pdf" || $ext == "txt" || $ext == 'doc' || $ext == 'xls' || $ext == "ppt" || $ext == 'docx' || $ext == 'xlsx') {
                                    $ResourceArray[$key] = $image;
                                     $ResourceUriArray[$key]=$res['Uri'];
                                } else {
                                    $ResourceArray[$key] = $image;
                                     $ResourceUriArray[$key]=$res['Uri'];
                                }
                               
                         }
                         }

                         ?>
                        
 


       
        <div class="pull-left multiple "> 
            <?php   if (sizeof($data->Resource) > 1) { ?>
            <div class="img_more1"></div>
            <div class="img_more2"></div>
            <?php } ?>
            <a  class="pull-left pull-left1 img_more ">
              <?php                     
 
     if(isset($data->Resource[0]['Extension'])){
                $ext = strtolower($data->Resource[0]['Extension']);

                if(isset($res['ThumbNailImage'])){
                       $image=$data->Resource[0]['ThumbNailImage'];
                   }else{
                       $image="";
                   }

            if($ext == "mp3"){?>
                        <div class="d_img_outer_video_play_postdetail" >

                        <img style="cursor:pointer;" src="/images/system/audio_img.png" data-src="<?php echo implode(',', $ResourceArray); ?>" data-srcuri="<?php echo implode(',', $ResourceUriArray); ?>" data-uri="<?php  echo $data->Resource[0]['Uri'];?>" data-format="<?php  echo $ext;?>" id="videodivid" />
                    </div>
              <?php  }else if($ext == "mp4" || $ext == 'flv' || $ext == 'mov'){
                 if($categoryType!=3){
                     $videoclassName = 'PostdetailvideoThumnailDisplay artifactdetailPV';
                 }else{
                      $videoclassName = 'GroupPostdetailvideoThumnailDisplay artifactdetailGPV';
                 }

                  ?>
                        <div class="d_img_outer_video_play_postdetail" style="cursor:pointer;" ><div  class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div>

                        <img style="cursor:pointer;"  data-src="<?php echo implode(',', $ResourceArray); ?>" data-srcuri="<?php echo implode(',', $ResourceUriArray); ?>" src='<?php echo $image; ?>' data-uri="<?php  echo $data->Resource[0]['Uri'];?>" data-format="<?php  echo $ext;?>" id="videodivid"/>
                    </div>
                  
                <?php  }else  if($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif"){?>
                  
                        <div class="d_img_outer_video_play_postdetail" >
                        <img style="cursor:pointer;" src="<?php  echo $data->Resource[0]['Uri'];?>" data-src="<?php echo implode(',', $ResourceArray); ?>" data-srcuri="<?php echo implode(',', $ResourceUriArray); ?>" data-uri="<?php echo str_replace('/upload/public/thumbnails/','/upload/public/images/',$data->Resource[0]['Uri']);?>" id="imageimgdivid" data-format="<?php  echo $ext;?>" class="imageimgdivid"/>
                        </div>
                   
            <?php  }else  if($ext == "pdf" || $ext == "txt" || $ext=='doc' || $ext=='xls' || $ext == "ppt" || $ext=='docx' || $ext=='xlsx'){                   
            ?>
                    
                        <div class="d_img_outer_video_play_postdetail" >
                             <img  style="cursor:pointer;" src="<?php echo $image;?>" data-src="<?php echo implode(',', $ResourceArray); ?>" data-srcuri="<?php echo implode(',', $ResourceUriArray); ?>" data-uri="<?php  echo $data->Resource[0]['Uri'];?>" data-format="<?php  echo $ext;?>" id="pdfdivid"/>

                        </div>  
                   
            <?php }else{ ?> 
                   
                        <div class="">
                             <a href="/post/fileopen/?file=<?php  echo $res['Uri'];?>"  id="downloadAE"><img  id="artifactOpen" style="cursor:pointer;" src="<?php echo $image;?>" data-uri="<?php  echo $data->Resource[0]['Uri'];?>" data-format="<?php  echo $ext;?>" id="pdfdivid"/> </a>    

</div>
                <?php  }


                } ?>
  
            </a>
        </div>

