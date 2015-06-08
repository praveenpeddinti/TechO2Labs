<?php

if(count($surveyUsersData['finalArray'])> 0){ ?>
    
    <div class="row-fluid " id="userFollowUnfollowid">
    <?php
    $i=0;
    foreach($surveyUsersData['finalArray'] as $data){
        if($i == 0){
        ?>
            <div class="span12" style='margin-left: 0;margin-bottom:10px'>
        <?php } ?>
            <div class="span6">
                <div class="media ">
                    <a data-userid="<?php echo $data->UserId; ?>" data-name="<?php echo $data->UniqueHandle; ?>" style="cursor:pointer" class="pull-left marginzero smallprofileicon"><img src="<?php echo $data->ProfilePicture; ?>"></a>
                    <div class="media-body" <?php if($data->ScheduleDates == ""){ ?>style="padding-top:10px;"<?php } ?>>
                        <div data-name="<?php echo $data->UniqueHandle; ?>" data-userid="<?php echo $data->UserId; ?>" style="cursor:pointer" class="m_title justificationUser"><?php echo $data->DisplayName; ?></div>
                        <?php if(isset($data->ScheduleDates) && $data->ScheduleDates != ""){ ?>
                        <div style="cursor:pointer;font-size: 9px;font-style: italic;" class="m_title"><?php echo $data->ScheduleDates; ?></div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        <?php
        $i++; 
        if($i>1){$i = 0;?>
        </div>                        
        <?php }
    }?>        
    </div>
<?php

 }else {
    echo 0;
 }
 
 ?>
