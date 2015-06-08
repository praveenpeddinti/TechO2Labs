
<?php if (is_array($stream)) { ?>

    <?php
    foreach ($stream as $data) {
     //  print_r($data);
        ?>
        <li class="woomarkLi1" id="<?php echo $data->TopicId; ?>">
         <div  onClick="   if(window.location.pathname!='/stream') { setLocalStorage('categoryId','<?php echo $data->TopicId;?>');setLocalStorage('categoryName','<?php echo $data->TopicName;?>');  window.location='/stream';}
getTopicPosts('<?php echo $data->TopicId?>','<?php echo $data->TopicName?>')">
            <div class="topictitle paddingt5lr10 borderbottomtopic">
                <div class="media">
                    <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner postdetail" data-id="53ece3a87f8b9a987c3a47e6" data-postid="53ece3667f8b9a8406966000" data-categorytype="2" data-posttype="5" >
                        <img src="<?php echo $data->ProfileImage; ?>">
                  </a>
                     </div>
                   
                    <div class="media-body">                                   
        <?php echo $data->TopicName; ?>
                    </div>
                </div>

            </div>

        <?php if (is_object($data->Post)) { ?>
                <div style="position: relative" class="stream_title_topic paddingt5lr10">
                    <a style="cursor:pointer" data-id="1" data-streamid="540effd1b96c3d90408b4577" class="userprofilename">
                        <b><?php if( $data->Post->isGroupAdminPost == 'true' &&  $data->Post->ActionType=='Post') {
                           echo  $data->Post->GroupName; 
                        }else{
                            echo  $data->Post->FirstUserDisplayName;
                        } ?></b>
                    </a><?php echo $data->Post->SecondUserData?> <?php echo $data->Post->StreamNote."  ".$data->Post->PostTypeString ?> <?php echo $data->Post->CurbsideConsultTitle ?>               
                </div>
             <?php  if($data->Post->ArtifactIcon!=""){ ?>
       <div class="artifactdiv borderbottomtopic paddingt5lr10">  
            <div class="artifactinnerdiv"> 
            <?php
                            $extension = "";
                           $videoclassName="";
                           $extension = strtolower($data->Post->Resource["Extension"]);
                           if($extension == 'mp4' || $extension == 'flv' || $extension == 'mov') {
                                $videoclassName = 'videoThumnailDisplay';

                          }else {
                              $videoclassName='videoThumnailNotDisplay';
                          }
                           
                           if($data->Post->IsMultiPleResources==1){?>
                        <?php
                                $className = ""; 
                                $uri = "";
                               
                                $imageVideomp3Id = "";
                                
                                if($extension == "mp4" || $extension == "avi" || $extension == "flv" || $extension == "mov" || $extension == "mp3" ){ 
                                    $className = "videoimage";
                                    $uri = $data->Post->Resource["Uri"];
                                    $imageVideomp3Id = "imageVideomp3_".$data->Post->_id;
                                }else{
                                    $className = "postdetail";                                
                                }
                                
                            ?>
                            <?php if(!empty($imageVideomp3Id)){ ?>
                            <div id="playerClose_<?php echo $data->Post->_id; ?>"  style="display: none;">
                                <div class="videoclosediv alignright"><button aria-hidden="true"  data-dismiss="modal" onclick="closeVideo('<?php echo $data->Post->_id; ?>');" class="videoclose" type="button">×</button></div>
                                <div class="clearboth"><div id="streamVideoDiv<?php echo $data->_id; ?>"></div></div></div>
                            <?php } ?>  
                                <a id="imgsingle_<?php echo $data->Post->_id; ?>" class="pull-left img_single <?php echo $className; ?>" data-id="<?php echo $data->Post->_id; ?>" data-postid="<?php echo $data->Post->PostId;?>" data-categoryType="<?php echo $data->Post->CategoryType;?>" data-postType="<?php echo $data->Post->PostType;?>" data-videoimage="<?php echo $uri; ?>" data-vimage="<?php  echo $data->Post->ArtifactIcon ?>"><div id='img_streamVideoDiv<?php echo $data->Post->_id; ?>' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php  echo $data->Post->ArtifactIcon ?>" <?php if(!empty($imageVideomp3Id)){ echo "id=$imageVideomp3Id"; }?>  ></a>
                        <!--<a  class="pull-left img_single postdetail"  data-postid="<?php echo $data->PostId;?>" data-categoryType="<?php echo $data->Post->CategoryType;?>" data-postType="<?php echo $data->Post->PostType;?>"><img src="<?php  echo $data->Post->ArtifactIcon ?>"  ></a>-->
                        <?php  }else{ ?>
                                <div class="pull-left multiple "> 
                                    <div class="img_more1"></div>
                                    <div class="img_more2"></div>
                             <a  class="pull-left  pull-left1 img_more postdetail" data-id="<?php echo $data->Post->_id;?>" data-postid="<?php echo $data->Post->PostId;?>" data-categoryType="<?php echo $data->Post->CategoryType;?>" data-postType="<?php echo $data->Post->PostType;?>"><div id='img_streamVideoDiv<?php echo $data->Post->_id; ?>' class='<?php echo $videoclassName; ?>'><img src="/images/icons/video_icon.png"></div><img src="<?php  echo $data->Post->ArtifactIcon ?>"></a>  
                                
                                </div>
                            
                        <?php  } ?>
            
            </div>
       </div>
               <?php  } ?>  
              <div class="topicdescription paddingt5lr10"><?php echo $data->Post->PostText; ?>


                </div>
            
            
            
            
            <div class="paddingt5lr10">
                <div class="media">
                    <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner postdetail" data-posttype="5" data-categorytype="2" >
                        <img src="<?php  echo $data->Post->OriginalUserProfilePic ?>">
                  </a>
                     </div>
                    
                    <div class="media-body paddingt5lr10">                                   
                        <span class="m_day"><?php  echo $data->Post->OriginalPostPostedOn ?></span>
                        <div class="m_title"><a style="cursor:pointer"  class="userprofilename"><?php  echo $data->Post->OriginalUserDisplayName ?></a></div>

                    </div>
                </div>

         </div>
        <?php } else { ?>

                <div class="topicnoconversationfound ">
                    <?php echo Yii::t('translation','No_Conversations_Found'); ?>
                </div>

        <?php } ?>
         </div>
            <div class="social_bar" style="padding:10px" >	

                <a   class="tooltiplink cursor " onclick="followUnfollowTopic('<?php echo $data->TopicId; ?>','curbsideCategoryIdFollowUnFollowImg_<?php echo $data->TopicId; ?>',0)"><i><img id="curbsideCategoryIdFollowUnFollowImg_<?php echo $data->TopicId; ?>" src="/images/system/spacer.png"  rel="tooltip" data-action="<?php if($data->IsFollow){ echo "unfollow"; }else{ echo "follow";} ?>" data-placement="bottom" class=<?php echo $data->IsFollow ? 'follow' : 'unfollow' ?> ></i></a>
                <a onClick="   if(window.location.pathname!='/stream') { setLocalStorage('categoryId','<?php echo $data->TopicId;?>');setLocalStorage('categoryName','<?php echo $data->TopicName;?>');  window.location='/stream';}
getTopicPosts('<?php echo $data->TopicId?>','<?php echo $data->TopicName?>')" ><span><i><img src="/images/system/spacer.png" class="tooltiplink d_conversations" data-placement="bottom" rel="tooltip"  data-original-title="Conversations" ></i><b><?php echo $data->NumberOfPosts ?></b></span></a>
                <a onClick="   if(window.location.pathname!='/stream') { setLocalStorage('categoryId','<?php echo $data->TopicId;?>');setLocalStorage('categoryName','<?php echo $data->TopicName;?>');  window.location='/stream';}
getTopicPosts('<?php echo $data->TopicId?>','<?php echo $data->TopicName?>')" ><span><i><img src="/images/system/spacer.png" class="tooltiplink d_followers" data-placement="bottom" rel="tooltip"  data-original-title="Following" ></i><b id="curbsidecategoryFollowresCount_<?php echo $data->TopicId; ?>"><?php echo $data->Followers ?></b></span> </a>              

            </div>
            <!-- spinner -->
            <div id="stream_view_spinner"></div>
            <div id="PostdetailSpinLoader_streamDetailedDiv"></div>
            <!-- End spinner -->

        </li>

        <?php
        }
    } else {
        echo $stream;
    }
    ?>


