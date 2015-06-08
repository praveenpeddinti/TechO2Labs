<?php if(is_array($jobs))
{
foreach ($jobs as $job ){?>
<?php $time=strtotime($job['PostedDate'])?>
<?php if($job['Source'] != "hec"){?>
<li class="jobsList jobsLis" id="<?php echo $job['id']; ?>" data-jobid="<?php echo $job['id']; ?>" data-IsIframe="<?php echo isset($job['IframeUrl'])?1:0 ?>" data-postid="<?php echo $job['id']; ?>" data-categorytype="15">


        <div class="post item positionrelative impressionDiv" >
            <?php if($job['recommended']==1){?>
  <div class="recommended_icon"></div>
            <?php }?>
  

 <span class="grouppostspinner" id="groupfollowSpinLoader_<?php echo $job['id']; ?>"></span>

 <div class="stream_career_box">


        <div  style="cursor: pointer;position:relative;;padding-right:30px" class="stream_title stream_titlenews paddingt5lr10"> <b id="groupName" data-id="<?php echo $job['id'] ?>"   class="group"><?php echo $job['JobTitle'] ?> - </b><i> <?php echo $job['JobPosition'] ?></i>
        <div style="position: absolute;right:5px;top:4px">
        <?php if (Yii::app()->session['IsAdmin'] == 1) { ?>
            <div style="margin-right:0;"  class="postmg_actions" data-jobid="<?php echo $job['id']; ?>">
                        <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
                        <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
                        <div class="dropdown-menu margindropdown">
                             <ul class="PostManagementActions" data-jobid="<?php echo $job['id']; ?>"  >

                                <?php if (Yii::app()->session['IsAdmin'] == 1) { ?><li class="career_droplist"><a class="copyurl"><span class="copyicon"><img src="/images/system/spacer.png" /></span> Copy URL</a></li><?php } ?>

                             </ul>
                            </div>
            </div>
        <?php } ?>
        </div>
            </div>
     </div>

        <div class="stream_content stream_contentjobs impressionDiv">


            <div class="media jobsListDetail" data-id="<?php echo $job['id'] ?>"  data-IsIframe="<?php echo isset($job['IframeUrl'])?1:0 ?>">
            <div class="media-body">
                   <b><?php echo $job['Category']?></b> -      <?php echo $job['Industry']?>
                            </div>
                <div class="media-body">
                    <?php if(isset($job['IframeUrl'])) {?>
                    <?php if(isset($job['SnippetDescription']) && !empty($job['SnippetDescription'])){?>
                        <a href="<?php echo $job['IframeUrl']?>" target="_blank"> <?php echo $job['SnippetDescription']?></a>
                   <?php }else{?>
                        <a href="<?php echo $job['IframeUrl']?>" target="_blank"> <?php echo $job['IframeUrl']?></a>
                   <?php }?>
                        <?php } else{
                            ?>
                        <span style="color: #000;font-family:Arial;font-size: 15px;display:block;text-align:center;line-height:20px">
                        <?php
                          $appendData = ' <span class="careerpostdetail tooltiplink" data-id=' .  $job['id']. 'data-postid="' . $job['JobId'] . '" data-categoryType="12" data-postType="12"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';
                          if (strlen($job['JobDescription']) > 330) {
                            
                    $description = CommonUtility::truncateHtml(htmlspecialchars_decode($job['JobDescription']), 330, 'Read more', true, true, $appendData);

                    $text = $description;
                    echo $text;
                }else{
                   echo htmlspecialchars_decode($job['JobDescription']);
                }
                        }?>
                            </span>
                    </div>

             <div class="media-body">
                 <div>
                     <span class="m_day"><?php echo CommonUtility::styleDateTime($time); ?></span>

                 </div>


                            </div>
            </div>
                </div>




        </div>

     </li>
<?php }else { ?>
     <?php $strtime=strtotime($job['PostedDate'])?>

    <li class="jobsList fromHec jobsLis" id="<?php echo $job['id']; ?>" data-jobid="<?php echo $job['id']; ?>" data-postid="<?php echo $job['id']; ?>" data-categorytype="15">
 <div class="post item positionrelative impressionDiv" >
  <?php if($job['recommended']==1){?>
  <div class="recommended_icon"></div>
            <?php }?>
    <span class="grouppostspinner" id="groupfollowSpinLoader_<?php echo $job['id']; ?>"></span>
<div class="stream_career_box">
<div class="stream_title stream_titlenews paddingt5lr10" style="cursor: pointer;position:relative;padding-right:30px">
    <b data-id="<?php echo $job['id'] ?>" class="group"><?php echo $job['JobTitle'] ?> - <span><?php echo $job['JobId']; ?></span></b>
    <i style="white-space: nowrap;display: block;clear:both;padding-left:0"> <?php echo $job['JobPosition']; ?></i>
<div style="position: absolute;right:5px;top:4px">
    <?php if (Yii::app()->session['IsAdmin'] == 1) { ?>
        <div style="margin-right:0;" class="postmg_actions" data-jobid="<?php echo $job['id']; ?>">
                    <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
                    <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
                    <div class="dropdown-menu margindropdown">
                         <ul class="PostManagementActions" data-jobid="<?php echo $job['id']; ?>"  >

                            <?php if (Yii::app()->session['IsAdmin'] == 1) { ?><li class="career_droplist"><a class="copyurl"><span class="copyicon"><img src="/images/system/spacer.png" /></span> Copy URL</a></li><?php } ?>

                         </ul>
                        </div>
        </div>
    <?php } ?>
    </div>
</div>
</div>

<div class="stream_content stream_contentjobs">
<div data-id="<?php echo $job['id'] ?>"  data-IsIframe="<?php echo isset($job['IframeUrl'])?1:0 ?>" class="media jobsListDetail">

<div class="media-body ">


    <?php
$location = "";
if(!empty($job['City'])){
    $location = $job['City'];
}
if(!empty($job['State'])){
    if(!empty($location))
        $location = "$location, ".$job['State'];
    else
        $location = $job['State'];
}
if(!empty($job['Zip'])){
    if(!empty($location))
        $location = "$location, ".$job['Zip'];
    else
        $location = $job['Zip'];
}
?>


<div class="row-fluid">
<div class="span12">
     <?php if(!empty($job['EmployerName'])){ ?>
    <div class="span6"><div class="jobsemployer"><?php echo $job['EmployerName']; ?></div> </div>
    <?php } ?>
    <?php if(!empty($location)){ ?>
<div class="span6"><div class="jobslocation"><?php echo $location; ?></div> </div>
    <?php } ?>

</div>
</div>

</div>
<?php if(!empty($job['JobDescription'])) {
    $jDescription = $job['JobDescription'];

    ?>
<div class="media-body">
<div class="lineheight17">
<?php 



                    $appendData = ' <span class="careerpostdetail tooltiplink" data-id=' .  $job['id']. '  data-postid="' . $job['JobId'] . '" data-categoryType="12" data-postType="12"> <i class="fa  moreicon moreiconcolor">'.Yii::t('translation','Readmore').'</i></span>';



                if (strlen($job['JobDescription']) > 330) {
                    $description = CommonUtility::truncateHtml(htmlspecialchars_decode($job['JobDescription']), 330, 'Read more', true, true, $appendData);

                    $text = $description;
                    echo $text;
                }else{
                   echo htmlspecialchars_decode($job['JobDescription']); 
                }
?>

</div>
</div>
     <?php } ?>
    <?php //if(!empty($job['EAdditionalInfo'])){ ?>
<!--<div class="media-body"> <?php //echo ($job['EAdditionalInfo']); ?></div>-->
    <?php //} ?>
    <div class="media-body" style="padding-top:0; padding-bottom: 0">
<div class="row-fluid">
    <div class="span12">
        <div class="span5" style="padding-top:8px;" > <span class="m_day"><?php echo CommonUtility::styleDateTime($strtime); ?></span></div>
        <div class="span7 alignright " style="padding-top:5px;">
            <img alt="Powered by HealtheCareers" src="/images/system/poweredbyhec.png" style="width:auto;display: inline-block"/>
            <input data-uri="<?php echo $job['InternalApplyUrl']; ?>" data-jobid="<?php echo $job['JobId']; ?>" data-categorytype="15" type="button" value="Learn More & Apply" name="commit" class="btn btn-mini jobsapplybutton" >
        </div>
    </div>
</div>
</div>
</div>
</div>




</div>

</li>
<?php } ?>


<?php }  ?>
<script type="text/javascript">
$(".jobsapplybutton").die().live("click",function(){
    var dataId = $(this).attr('data-jobid');
    var categoryType = $(this).attr('data-categorytype');
    trackEngagementAction("JobsLinkOpen",dataId,categoryType);
    var url = $(this).data("uri");
    window.open(url,"_blank");

});
if(detectDevices()){
$('.postmg_actions').removeClass().addClass("postmg_actions postmg_actions_mobile");
        }
</script>

    <?php }else {
     echo $jobs;
 }?>