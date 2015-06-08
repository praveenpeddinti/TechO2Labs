<div id="EventpostDescription" style="<?php if ($data->ArtifactIcon != "") {
    echo 'display:block';
} else {
    echo 'display:none';
} ?>" >
    <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>"  data-id="<?php echo $data->_id; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_total_<?php echo $data->_id; ?>" style="display:none" >

<?php
echo $data->PostCompleteText;
?>
    </div>
    <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>"  data-id="<?php echo $data->_id; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_<?php echo $data->_id; ?>" <?php if ($data->PostType == 5) { ?> class="postdetail" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>" <?php } ?> >

<?php
echo $data->PostText;
?>
    </div>

</div>                          
<!----------------------------------------Event calender Start----------------------------------------------------------------------->               

<div class="pull-left" >

    <div class="timeshow pull-lefts"  > 
        <!-- spinner -->
        <div id="stream_view_spinner_<?php echo $data->_id; ?>"></div>

        <div id="stream_view_detailed_spinner_<?php echo $data->PostId; ?>"></div>
        <!-- end spinner -->
        <ul>
            <li class="clearboth">
                <ul class="<?php echo $data->StartDate == $data->EndDate ? '' : "doubleul" ?>">
                    <li class="doubledate">
                        <time class="icon" datetime="<?php echo $data->StartDate; ?>">
                            <strong><?php echo $data->EventStartMonth; ?><?php echo $data->StartDate != $data->EndDate ? "<br/>" : "-"; ?><?php echo $data->EventStartYear; ?></strong>
                            <span><?php echo $data->EventStartDay; ?></span>
                            <em><?php echo $data->EventStartDayString; //day name  ?></em>

                        </time>

                    </li>

<?php if ($data->StartDate != $data->EndDate) { ?>
                        <li style="width:80px;float:left"><time class="icon" datetime="<?php echo $data->EndDate; ?>">
                                <strong><?php echo $data->EventEndMonth; ?><br/><?php echo $data->EventEndYear; ?></strong>
                                <span><?php echo $data->EventEndDay; ?></span>
                                <em><?php echo $data->EventEndDayString; ?></em>
                            </time>

                        </li>
            <?php } ?>
                </ul>
            </li>

<?php if (trim($data->StartTime) != "" && trim($data->EndTime) != "" && $data->StartTime != $data->EndTime) { ?>
                <li class="clearboth e_datelist"><div class="e_date"><?php echo $data->StartTime ?> - <?php echo $data->EndTime ?></div></li>
<?php } ?>
        </ul>
        <div class="et_location clearboth"><span><i class="fa fa-map-marker"></i><?php echo $data->Location ?></span> </div>


    </div>
</div>
<!------------------------------------- EVENT CALENDER END -------------------------------------------------------------------------->
<div id="EventpostDescriptionArtifact" style="<?php if ($data->ArtifactIcon != "") {
    echo 'display:none';
} else {
    echo 'display:block';
} ?>" >
    <div class="media-body">
        <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>"  data-id="<?php echo $data->_id; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_total_<?php echo $data->_id; ?>" style="display:none" >

            <?php
            echo $data->PostCompleteText;
            ?>
        </div>
        <div class="bulletsShow" data-postid="<?php echo $data->PostId; ?>"  data-id="<?php echo $data->_id; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" id="post_content_<?php echo $data->_id; ?>" <?php if ($data->PostType == 5) { ?> class="postdetail" data-postid="<?php echo $data->PostId; ?>" data-categoryType="<?php echo $data->CategoryType; ?>" data-postType="<?php echo $data->PostType; ?>" <?php } ?> >

<?php
echo $data->PostText;
?>
        </div>

    </div>
</div>



<?php if ((int) $data->FirstUserId != (int) $data->OriginalUserId) { 
     include Yii::app()->basePath . '/views/includes/stream_originalUser.php';
 } ?>


<div class="alignright clearboth " >
<?php if (!$data->IsEventAttend) { ?>
        <button class="eventAttend btn btn-small editable_buttons " name="Attend" data-postid="<?php echo $data->PostId ?>" data-postType="<?php echo $data->PostType; ?>" data-categoryType="<?php echo $data->CategoryType; ?>"><i class="fa fa-check-square-o  "></i> Attend</button> 
<?php } ?>
</div>
