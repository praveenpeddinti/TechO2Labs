<?php include 'miniProfileScript.php'; ?>
<?php include 'hashTagProfileScript.php'; ?>
<?php include 'commentscript.php'; ?>
<?php include 'detailedcommentscript.php'; ?>
<?php include 'commentscript_instant.php'; ?>
<?php include 'inviteScript.php'; ?>
<?php include 'newNode.php'; ?>
<?php include 'snippetDetails.php'?>
<div id="numeroNews"><h2 class="pagetitle" id="numero1"><?php echo Yii::t('translation','News'); ?></h2></div><!-- This id numero1 is used for Joyride help -->
<div id="newsfunnyspinner" style="position: relative;"></div>
<div id='ProfileInteractionDivContent' style="padding-bottom:40px;"> 
    <div  id="loadTopAds" style="display: none" ></div>
    <div id="loadMiddleAds" style="display: none"></div>
    <div id="loadBottomAds"  style="display: none"></div>
</div>
<!-- news detailed page-->
    <div id="streamDetailedDiv" style="display: none"></div>
    <!-- end news detailed -->

    <div id="promoteCalcDiv" style="display: none">    
        <div class="promoteCalc input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">
            <label>Promote till this date</label>
            <input type="text" class="promoteInput" readonly />
            <span class="add-on">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
<script type="text/javascript">
pF1 = 1;
pF2 = 1;

 gPage = "News";
$(document).ready(function(){  
  loadTopAds("top","News");
  loadTopAds("middle","News");
  loadTopAds("bottom","News");
  var pictocvTime = 30000;
  loadUserAchievementProgressByOppertunityType("News", '/views/news/userAchievementProgress.php');
  getCollectionData('/news/index', 'StreamPostDisplayBean', 'ProfileInteractionDivContent', '<?php echo Yii::t('translation','No_News_available'); ?>', '<?php echo Yii::t('translation','No_more_News'); ?>');
        $(window).scrollEnd(function() {
            trackViews($("#ProfileInteractionDivContent ul.listnone.impressionUL li.woomarkLi:not(.tracked)"), "News");
       }, 1000);
    });
    <?php if(Yii::app()->params['Pictocv']=='ON'){?>
        var pictocvTime = 30000;
        var pivtocvObj = {uniquekey:sessionStorage.old_key,pageName:gPage,pictocvTime:pictocvTime};
        socketNotifications.emit('getPictocvObjectByOppertunity', loginUserId, "News", '/views/news/userAchievementProgress.php', JSON.stringify(pivtocvObj),"sSetInterval");
    <?php } ?>
    var handler = null;
     var optionsC = {
          itemWidth: '100%', // Optional min width of a grid item
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#ProfileInteractionDivContent'), // Optional, used for some extra CSS styling
          offset: 20, // Optional, the distance between grid items
          outerOffset: 20, // Optional the distance from grid to parent
          flexibleWidth: '50%', // Optional, the maximum width of a grid item
          align: 'left'
        };
    var $window = $(window);
  
    function applyLayoutContent() {
        optionsC.container.imagesLoaded(function() {
            optionsC.container.imagesLoaded(function() {
            // Create a new layout handler when images have loaded.
            handler = $('#ProfileInteractionDivContent li.woomarkLi');
            
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
            
           if($("#minChatWidgetDiv").css("display")=="none"){
           $(".joyride-tip-guide").show();
       }
           
           // adjustJoyRidePosition($(".joyride-tip-guide"),"right", $("#ProfileInteractionDivContent ul li:first"));;    
            trackViews($("#ProfileInteractionDivContent ul.listnone.impressionUL li.woomarkLi:not(.tracked)"), "News");
        });
        });
       
    }
    $window.resize(function() {
    
     setTimeout(function(){
         applyLayoutContent(); 
     },200);
  
   
        });
    $('.showmore').live('click', function() {
        showMoreEditorial($(this).data('id'));
    });
    $('.minimize').live('click', function() {
        minimizeEditorial($(this).data('id'), $('.EDCRO' + $(this).data('id')).html());
    });
     $('.showmoreC').live('click', function() {
        showMoreEditorialC($(this).data('id'));
    });
    $('.minimizeC').live('click', function() {
        minimizeEditorialC($(this).data('id'), $('.HTMLC' + $(this).data('id')).html());
    });
   initializationForHashtagsAtMentions('div#editable');
   initializationForArtifacts();
   bindEventsForStream('ProfileInteractionDivContent');
   initializationEvents();
    trackEngagementAction("Loaded","",8);  
   

</script>

