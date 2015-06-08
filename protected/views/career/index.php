<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.wookmark.js"></script>
<div class="row-fluid " id="postDetailedTitle">
     <div class="span6 " id="numeroCareer"><h2 class="pagetitle"><?php echo Yii::t('translation','CareerDetail');?></h2>
    
     </div>
   </div>
<div role="main" id="main" >
    
    <ul id="jobsListIndex" class="profilebox" >
     <div  id="loadTopAds" style="display: none" ></div>
     <div id="loadMiddleAds" style="display: none"></div>
     <div id="loadBottomAds"  style="display: none"></div>
    </ul>
</div>

<div id="careerDetail" style="display:none">
    </div>
<script type="text/javascript" >
    $(document).ready(function(){ 
        $(window).scrollEnd(function() {
            trackViews($("ul#jobsListIndex li.jobsList:not(.tracked)"), "Career");
       }, 1000);
    });
    var optionsC = {
          itemWidth: '100%', // Optional min width of a grid item
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#jobsListIndex'), // Optional, used for some extra CSS styling
          offset: 20, // Optional, the distance between grid items
          outerOffset: 20, // Optional the distance from grid to parent
          flexibleWidth: '50%', // Optional, the maximum width of a grid item
          align: 'left'
        };
    var $window = $(window);
     loadTopAds("top","Careers");
    loadTopAds("middle","Careers");
    loadTopAds("bottom","Careers");   
    <?php if(Yii::app()->params['Pictocv']=='ON'){?>
    loadUserAchievementProgressByOppertunityType("Career", '/views/career/userAchievementProgress.php');
    <?php } ?>
getCollectionData('/career/loadJobs', 'StreamPostDisplayBean', 'jobsListIndex', '<?php echo Yii::t('translation','No_jobs_found'); ?>',"<?php echo Yii::t('translation','Thas_all_folks'); ?>");  

$("#careers").addClass('active');
$(".jobsListDetail").live("click", function() {
    var id=$(this).attr('data-id');
    var isIframe=$(this).attr('data-IsIframe');
    if(isIframe==0){
        Global_ScrollHeight = $(document).scrollTop();
     renderPostDetailForCareer(id)
     gPage = "CareerDetail";
     trackEngagementAction("CareerDetailOpen",id,15);
    }
    
    
});
$(".careerpostdetail").live("click", function() {
    
    var id=$(this).attr('data-id');
        Global_ScrollHeight = $(document).scrollTop();
     renderPostDetailForCareer(id)
     gPage = "CareerDetail";
     trackEngagementAction("CareerDetailOpen",id);
    
    
    
});

function renderPostdetailforCareer(){
     
    var id=$(this).attr('id');
    var isIframe=$(this).attr('data-IsIframe');
    if(isIframe==0){
        Global_ScrollHeight = $(document).scrollTop();
     renderPostDetailForCareer(id)
     gPage = "CareerDetail";
     trackEngagementAction("CareerDetailOpen",id);
    }
    
}


$(".detailed_close_page").live("click", function() {        
    $('#postDetailedTitle').show();
    $('#main').show();    
    
    applyLayout();
     $("html,body").scrollTop(Global_ScrollHeight);
    $('#careerDetail').html('').hide();
   // applyLayout();
    
});

 

var handler = null;
//    pF1 = 1;
//    pF2 = 1;
//    socket4Game.emit('clearInterval',sessionStorage.old_key);    
    gPage = "Career";
   
   $(" .PostManagementActions a.copyurl").live("click",function(){
//    alert($(this).html())
    var jobId = $(this).closest('ul.PostManagementActions').attr('data-jobid');
    loadPostSnippetWidget(jobId,'career');
});
 <?php if(Yii::app()->params['Pictocv']=='ON'){?>
 var pictocvTime = 30000;
  var pivtocvObj = {uniquekey:sessionStorage.old_key,pageName:gPage,pictocvTime:pictocvTime};
  socketNotifications.emit('getPictocvObjectByOppertunity', loginUserId, "Career", '/views/career/userAchievementProgress.php', JSON.stringify(pivtocvObj),"sSetInterval");
 <?php } ?>    
     
function applyLayout() {
        optionsC.container.imagesLoaded(function() {
            optionsC.container.imagesLoaded(function() {
            // Create a new layout handler when images have loaded.
            handler = $('#jobsListIndex li.jobsList');              
            
        if ($window.width() < 753) {
            optionsC.itemWidth = '100%';
            optionsC.flexibleWidth='100%';

        }
           else if ($window.width() > 753 && $window.width() < 1000) {
            optionsC.itemWidth = '100%';
        }else{
           
            optionsC.itemWidth = '40%'; 
        }
       
            handler.wookmark(optionsC);
          if($('#jobsListIndex li').length>0){ if($("#minChatWidgetDiv").css("display")=="block"){ adjustJoyRidePosition($(".joyride-tip-guide"),"right", $('#jobsListIndex li:first'));;}    }else{$(".joyride-tip-guide").hide();}
            
            trackViews($("ul#jobsListIndex li.jobsList:not(.tracked)"), "Career");
        });
        });

    } 
    $window.resize(function() {
     $("#jobsListIndex").hide()
     setTimeout(function(){
         applyLayout();    
         $("#jobsListIndex").show()
     },200);
  
   
        });
     
     
     trackEngagementAction("Loaded","",15);

</script>