

<div class="row-fluid " id="postDetailedTitle">
     <div class="span6 "><h2 class="pagetitle"><?php echo Yii::t('translation','JobDetail');?></h2>
    
     </div>
          <div class="span6 ">
          <div class="grouphomemenuhelp alignright tooltiplink"> <a class="detailed_close_page" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','close'); ?>" data-placement="bottom" data-toggle="tooltip"> <i class="fa fa-times"></i></a> </div>
          </div>
     </div>
<?php
foreach($jobDetails as $jobDetail){
    if($jobDetail['Source'] != "hec"){
    ?>

<div  id="newsDetailedwidget">

<div class="customwidget_outer">
<div class="customwidget customwidgetdetail stream_contentjobs">
<div class="careersbox stream_career_box stream_lineheight">
<div class="stream_title stream_titlenews paddingt5lr10" style="cursor: pointer;position:relative;padding-right:30px">
    <b><?php echo $jobDetail['JobTitle']?> - </b><i> <?php echo $jobDetail['JobPosition'] ?></i> 
<div style="position: absolute;right:5px;top:4px">
        <div style="margin-right:0;"  class="postmg_actions" data-jobid="<?php echo $jobDetail['id']; ?>">
                    <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
                    <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
                    <div class="dropdown-menu margindropdown">
                         <ul class="PostManagementActions" data-jobid="<?php echo $jobDetail['id']; ?>"  >

                            <?php if (Yii::app()->session['IsAdmin'] == 1) { ?><li class="career_droplist"><a class="copyurl"><span class="copyicon"><img src="/images/system/spacer.png" /></span> Copy URL</a></li><?php } ?>

                         </ul>
                        </div>
        </div>
        </div>  
</div>
</div>
<div class="customcontentarea customwidgetdetailcontent media " style="margin:0;padding:0;">
    <div class="cust_content media-body" style="padding-right:10px;padding-left:10px" ><?php echo $jobDetail['Industry']?></div>
 
    <div class="stream_content stream_contentjobs">
            
                   
            <div class="media" data-id="<?php echo $jobDetail['id'] ?>">
            <div class="media-body">
                   <b><?php echo $jobDetail['Category']?></b> -      <?php echo $jobDetail['Industry']?>
                            </div>
                <div class="media-body">
                    <?php if(isset($jobDetail['IframeUrl'])) {?>
                    <?php if(isset($jobDetail['SnippetDescription']) && !empty($jobDetail['SnippetDescription'])){?>
                        <a href="<?php echo $jobDetail['IframeUrl']?>" target="_blank"> <?php echo $jobDetail['SnippetDescription']?></a>
                   <?php }else{?>
                        <a href="<?php echo $jobDetail['IframeUrl']?>" target="_blank"> <?php echo $jobDetail['IframeUrl']?></a>
                   <?php }?>
                        <?php } else{
                          echo $jobDetail['JobDescription']; 
                        }?>
                            </div>
            
             <div class="media-body">
                  <div>
                      <span class="m_day"><?php echo CommonUtility::styleDateTime(strtotime($jobDetail['PostedDate'])); ?></span>
                     
                 </div>
                           
                           
                            </div>
            </div> 
                </div>
       
        
 </div>

<?php?>
 
</div>
</div>
                        
          </div>








    <?php }else{ ?>
 <?php $strtime=strtotime($jobDetail['PostedDate'])?>
        <div class="jobsList fromHec" id="<?php echo $jobDetail['id']; ?>" data-jobid="<?php echo $jobDetail['id']; ?>">
<div class="post item" style="">
    <span class="grouppostspinner" id="groupfollowSpinLoader_<?php echo $jobDetail['id']; ?>"></span>
<div class="careersbox stream_career_box stream_lineheight">
<div class="stream_title stream_titlenews paddingt5lr10" style="cursor: pointer;position:relative;padding-right:30px">
<b data-id="<?php echo $jobDetail['id'] ?>"   class="group"><?php echo $jobDetail['JobTitle'] ?> - <?php echo $jobDetail['JobId']; ?></b>
<i style="white-space: nowrap;display: block;clear:both;padding-left:0"> <?php echo $jobDetail['JobPosition']; ?></i>
  <div style="position: absolute;right:5px;top:4px">
        <div style="margin-right:0;"  class="postmg_actions" data-jobid="<?php echo $jobDetail['id']; ?>">
                    <i class="fa fa-chevron-down" data-toggle="dropdown" data-placement="right"></i>
                    <i class="fa fa-chevron-up" data-toggle="dropdown" data-placement="right"></i>
                    <div class="dropdown-menu margindropdown">
                         <ul class="PostManagementActions" data-jobid="<?php echo $jobDetail['id']; ?>"  >

                            <?php if (Yii::app()->session['IsAdmin'] == 1) { ?><li class="career_droplist"><a class="copyurl"><span class="copyicon"><img src="/images/system/spacer.png" /></span> Copy URL</a></li><?php } ?>

                         </ul>
                        </div>
        </div>
        </div>  
</div>

</div>

<div class="stream_content stream_contentjobs">
<div data-id="<?php echo $jobDetail['id'] ?>" class="media">

<div class="media-body ">
   

    <?php 
$location = "";
if(!empty($jobDetail['City'])){
    $location = $jobDetail['City'];
}
if(!empty($jobDetail['State'])){
    if(!empty($location))
        $location = "$location, ".$jobDetail['State'];
    else
        $location = $jobDetail['State'];
}
if(!empty($jobDetail['Zip'])){
    if(!empty($location))
        $location = "$location, ".$jobDetail['Zip'];
    else
        $location = $jobDetail['Zip'];
}
?>

<div class="row-fluid">
<div class="span12">
     <?php if(!empty($jobDetail['EmployerName'])){ ?>
    <div class="span6"><div class="jobsemployer"><?php echo $jobDetail['EmployerName']; ?></div> </div>
    <?php } ?>
    <?php if(!empty($location)){ ?>
<div class="span6"><div class="jobslocation pull-right"><?php echo $location; ?></div> </div>
    <?php } ?>

</div>
</div>
    
</div>
<?php if(!empty($jobDetail['JobDescription'])) { 
    $jDescription = $jobDetail['JobDescription'];    
    ?>
<div class="media-body">    
<div class="lineheight17">    
<?php echo ($jobDetail['JobDescription']); ?>

</div>
</div>
     <?php } ?>
    
    
    <div class="media-body" style="padding-top:0; padding-bottom: 0">
<div class="row-fluid">
    <div class="span12">
        <div class="span5" style="padding-top:8px;" > <span class="m_day"><?php echo CommonUtility::styleDateTime($strtime); ?></span></div>
        <div class="span7 alignright " style="padding-top:5px;">
            <img alt="Powered by HealtheCareers" src="/images/system/poweredbyhec.png" style="width:auto;display: inline-block"/>
            <input data-uri="<?php echo $jobDetail['InternalApplyUrl']; ?>" data-jobid="<?php echo $jobDetail['id']; ?>" data-categorytype="15" type="button" value="Learn More & Apply" name="commit" class="btn btn-mini jobsapplybutton" >
        </div>
    </div>
</div>
</div>

</div>
</div>
</div>
</div>
        

    <?php } ?>
<?php }?>
 <script type="text/javascript">
 $( ".detailed_close_page" ).unbind( "click" );
        $(".detailed_close_page").bind('click',function(){ 

              <?php  if(isset($_REQUEST['layout'])){ ?>
                window.location.href = "/";
              <?php } ?>
                });
    $(".jobsapplybutton").die().live("click",function(){
        var dataId = $(this).attr('data-jobid');
        var categoryType = $(this).attr('data-categorytype');
        trackEngagementAction("JobsLinkOpen",dataId,categoryType);
    var url = $(this).data("uri");
    window.open(url,"_blank");

    });
    
    $(" .PostManagementActions a.copyurl").live("click",function(){
//    alert($(this).html())
    var jobId = $(this).closest('ul.PostManagementActions').attr('data-jobid');
    loadPostSnippetWidget(jobId,'career');
});
                
</script>