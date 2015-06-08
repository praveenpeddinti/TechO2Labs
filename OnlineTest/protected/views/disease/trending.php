<?php include 'CategoriesAndHashtags.php'?> 
 <?php include 'miniProfileScript.php'; ?>
<?php include 'hashTagProfileScript.php'; ?>
<?php include 'snippetDetails.php'?>
<?php include 'commentscript.php'; ?>
<?php include 'detailedcommentscript.php'; ?>
<?php include 'inviteScript.php'; ?>
<?php include 'commentscript_instant.php'; ?>

<!--  <div id="trendingposts">
      
  </div>-->
<div id="curbsidePostCreationdiv">
 <div id="curbsidePostsDiv" style="display:block;margin-top:20px"> </div>
</div>
     <!-- curbside detailed page-->
    <div id="curbsideStreamDetailedDiv" style="display: none"></div>
    <!-- end curbside detailed -->
<script type="text/javascript">
    pF1 = 1;
    pF2 = 1;
    $(window).unbind("scroll");
//    if(typeof socketCurbside !== "undefined")
//        socketCurbside.emit('clearInterval',sessionStorage.old_key);
    gPage = "TrendingStream";
   
    getCollectionData('/disease/getTrendingDetails', 'StreamPostDisplayBean', 'curbsidePostsDiv', '<?php echo Yii::t('translation','No_Data_Found'); ?>',"<?php echo Yii::t('translation','Thas_all_folks'); ?>");
    
        //ClearPostNodeIntervals();

     Custom.init();  
     

 </script>  
 <?php  include_once(getcwd()."/protected/views/curbsidePost/curbsideNodePost.php");?>
<script type="text/javascript">
       initializationForHashtagsAtMentions('div#editable');
    initializationForArtifacts();    
    if(!detectDevices()){ // only for web
        curbsideOnloadEvents();
    }
    
     trackEngagementAction("Loaded"); 
    getCategories();
    bindEventsForStream('curbsidePostsDiv');
    bindEventsForStream('CategoryPostsDiv');
    var extensions='"jpg","jpeg","gif","mov","mp4","mp3","txt","doc","docx","pptx","pdf","ppt","xls","xlsx","avi","png","tiff","mov","flv","tif","TIF"';
    initializeFileUploader('uploadfile', '/post/upload', '10*1024*1024', extensions,4, 'CurbsidePostForm' ,'',previewImage,appendErrorMessages,'uploadlist');
  function CloseFilterData(activeid,divid){
     
       $('#'+divid).css('display', 'none');
       $("#curbsidePostsDiv").show();
        $("#CategoryPostsDiv").hide();
        $('#CategoryPostsDiv').empty();

        $('#'+activeid).removeClass('active');
        g_curbside_categoryID="";
        g_curbside_hashtagID="";
         $(window).unbind("scroll");
        page = 1;
        isDuringAjax=false;
         getCollectionData('/disease/getcurbsideposts', 'StreamPostDisplayBean', 'curbsidePostsDiv', '<?php echo Yii::t('translation','No_Posts_found'); ?>',"<?php echo Yii::t('translation','Thas_all_folks'); ?>");
        //$('.categorymemenuhelp').css('display','none');
         if(!detectDevices())
               $("[rel=tooltip]").tooltip();
            
  }      
        
        ClearPostNodeIntervals();
        
         if(!detectDevices())
              $("[rel=tooltip]").tooltip();
         else{
            //$("#CurbsidePostForm_Category").attr("style","width:200px");
         }
     Custom.init();  
     
     
     $(document).ready(function(){
        
         if(sessionStorage.categoryId!="" && sessionStorage.categoryId!='undefined')
         {  
             setTimeout(function(){
                
                    getCategoryPosts(sessionStorage.categoryId,sessionStorage.categoryName);
                    // $(".topicsClass").attr("class","disease_topicssectiondiv topicsClass");
       //  $(".category_"+sessionStorage.categoryId).removeClass("disease_topicssectiondiv");           
      //  $(".category_"+sessionStorage.categoryId).addClass("disease_topicssectiondiv_active"); 
    $(".category_"+sessionStorage.categoryId).attr("class","disease_topicssectiondiv disease_topicssectiondiv_active topicsClass category_"+sessionStorage.categoryId);
                   
                  sessionStorage.categoryId='';
                  sessionStorage.categoryName='';
             },1000)
          
         }
     });
 </script> 