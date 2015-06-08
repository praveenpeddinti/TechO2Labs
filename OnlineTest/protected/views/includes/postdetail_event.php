<!-- spinner -->
<!--<div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>    
<span id="detailed_followUnfollowSpinLoader_<?php echo $data->_id; ?>"></span>-->
<!-- end spinner -->
<div class="media-body postDetail bulletsShow" id="postDetailPage">

<p  id="postdetail_postText"><?php echo ($data->Description); ?></p>
<div class="timeshow"> 

  <ul class="bulletnotShow">
              <li class="clearboth">
          <ul class="<?php  echo $data->StartDate==$data->EndDate?'bulletnotShow':"doubleul bulletnotShow" ?>">
              <li class="doubledate">
                  <time class="icon" datetime="<?php   echo $data->StartDate; ?>">
                      <strong><?php   echo $data->EventStartMonth; ?><?php   echo $data->StartDate!=$data->EndDate?"<br/>":"-"; ?><?php   echo $data->EventStartYear;?></strong>
                      <span><?php   echo $data->EventStartDay;?></span>
                      <em><?php   echo $data->EventStartDayString;//day name?></em>

                  </time>

              </li>

              <?php   if($data->StartDate!=$data->EndDate){ ?>
              <li style="width:80px;float:left"><time class="icon" datetime="<?php   echo $data->EndDate; ?>">
                      <strong><?php   echo $data->EventEndMonth;?><br/><?php   echo $data->EventEndYear;?></strong>
                      <span><?php   echo $data->EventEndDay;?></span>
                      <em><?php   echo $data->EventEndDayString;?></em>
                  </time>

              </li>
              <?php   } ?>
          </ul>
                    </li>
                     <?php if(trim($data->StartTime)!="" && trim($data->EndTime)!="" ){ ?>
                    <li class="clearboth e_datelist"><div class="e_date"><?php   echo $data->StartTime ?> - <?php   echo $data->EndTime ?></div></li>
                     <?php } ?>
                </ul>
          <div class="et_location clearboth"><span  id="Location_<?php echo $data->_id ?>"><i class="fa fa-map-marker"></i><?php   echo $data->Location ?></span> </div>


      </div>
          <div class="alignright paddingtb clearboth">
              <?php   if(!$data->IsEventAttend){ ?>
                  <button class="eventAttend_detailed btn btn-small editable_buttons" id="eventAttendDetailed" name="Attend" data-postid="<?php   echo $data->_id ?>" data-postType="<?php   echo $data->Type;?>" data-categoryType="<?php   echo $data->CategoryType;?>"><i class="fa fa-check-square-o  "></i> Attend</button> 
              <?php   } ?>
          </div>
</div>