
<?php include 'inviteScript.php'; ?>
<?php   include 'commentscript.php'; ?>
<?php include 'miniProfileScript.php'; ?>
<?php include 'snippetDetails.php'?>
<?php include 'hashTagProfileScript.php'; ?>


<div  class="paddingtop6" >
 <?php if(!is_string($currentScheduleGame) && $currentScheduleGame->IsDeleted==0){?>
    <div id="numero1"> <h2 class="pagetitle"><?php echo Yii::t('translation','Games'); ?> </h2></div><!-- This id numero1 is used for Joyride help -->
<div id="GameBanner" class="collapse in">
  <div  class="groupbanner positionrelative " > 
      <div class="gamebannerTitle">
          <div class="padding20">          
          
          
          <div class="gamebutton" id="gameIndex">
             
            <?php
            
            
            if($currentScheduleGame->GameStatus=="play"){
                $class = "btn btnplay";
                $label = Yii::t('translation','Play_Now')." <i class='fa fa-chevron-circle-right'></i>";
            }
            else if($currentScheduleGame->GameStatus=="resume"){
                 $class = "btn btnresume";
                  $label = Yii::t('translation','Resume')." <i class='fa fa-chevron-circle-right'></i>";
            }
            else{
               $class = "btn btnviewanswers";
                $label = Yii::t('translation','View')." <i class='fa fa-chevron-circle-right'></i>";
            }
                ?>
              <button type="button" class="<?php echo $class?> " id="gameBtn" data-mode="<?php echo $currentScheduleGame->GameStatus?>" data-gameName="<?php echo $currentScheduleGame->GameName; ?>" data-gameId="<?php echo $currentScheduleGame->GameId; ?>" data-gameScheduleId="<?php  echo $currentScheduleGame->ScheduleId; ?>"><?php echo $label?> </button>
            
          </div>
          
          
          
          
         
          </div>
      </div>
<a href="/<?php echo $currentScheduleGame->GameName ?>/<?php echo $currentScheduleGame->ScheduleId ?>/detail/game "><img style="max-width:100%" src="<?php echo $currentScheduleGame->GameBannerImage?>"></a>
</div>
</div>
    <div id="groupProfileDiv" class="row-fluid">
        
     <div class="span6">
         <div class="statusminibox">
         <div class="gameNameBold" id="header_gameName_<?php echo $currentScheduleGame->GameId ?>"><?php echo $currentScheduleGame->GameName; ?><?php if(isset($currentScheduleGame->IsSponsored) && $currentScheduleGame->IsSponsored == 1){ ?>
            <span  class="brand_box" style="font-weight:normal;"><?php echo $currentScheduleGame->BrandName; ?></span> 
            <?php } ?></div>
         </div>
     <div class="padding8top">
         
          
     <div id="profile" class="collapse in">
    <div class="" id="gameShortDescription">
        <div id="groupProfileDiv_spinner"></div>
        <div id="descriptioToshow" class="e_descriptiontext">
                <?php echo $currentScheduleGame->ShortDescription; ?>
                 </div>
     </div>
                 <div  style="display:none;padding: 5px" id="gameDetailDescription"><div id="detailDescriptioToshow" class="e_descriptiontext">
              <?php echo $currentScheduleGame->GameDescription; ?>
             </div>
     
     </div>
          <div class="alignright clearboth" id="game_descriptionMore" style="display:<?php echo strlen($currentScheduleGame->GameDescription)>240?'block':'none'; ?>"> <a id="more" class="more">more <i class="fa fa-chevron-circle-right"></i></a></div>
     <div class="alignright clearboth" > <a style="display:none"  class="moreup" id="moreup">close <i class="fa fa-chevron-circle-up"></i></a></div>
     </div>
    <?php 
        $translate_fromLanguage = $currentScheduleGame->Language;
        $translate_class = "translatebutton";
        $translate_id = $currentScheduleGame->GameId;
        $translate_postId = $currentScheduleGame->GameId;
        $translate_postType = $currentScheduleGame->PostType;
        $translate_categoryType = $currentScheduleGame->CategoryType;
        $translate_location = 'header';
        include Yii::app()->basePath . '/views/common/translateButton.php'; 
    ?>
         <div id="socialBar" class="detailpage collapse in" style="position: inherit">  
         <div  class="social_bar g_social_bar " data-id="<?php  echo $currentScheduleGame->GameId ?>" data-postid="<?php  echo $currentScheduleGame->GameId ?>" data-postType="<?php  echo $currentScheduleGame->PostType;?>" data-categoryType="<?php  echo $currentScheduleGame->CategoryType;?>" data-networkId="<?php  echo $currentScheduleGame->NetworkId; ?>">
                             
                          <a class="follow_a"><i><img class="tooltiplink <?php echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $currentScheduleGame->Followers)?'follow':'unfollow' ?>" src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  data-original-title="<?php  echo in_array(Yii::app()->session['TinyUserCollectionObj']['UserId'], $currentScheduleGame->Followers)?Yii::t('translation','UnFollow'):Yii::t('translation','Follow') ?>"></i><b class="dFollowers"  data-categoryId="<?php  echo $currentScheduleGame->CategoryType;?>" data-actiontype='Followers' data-id='<?php echo $currentScheduleGame->GameId?>' data-count="<?php echo count($currentScheduleGame->Followers)?>"><span id="streamFollowUnFollowCount_<?php  echo $currentScheduleGame->GameId; ?>"><?php echo count($currentScheduleGame->Followers) ?></span>

                                 
                            <div class="userView userFollowView"   data-postId='<?php echo $currentScheduleGame->GameId?>' style="display:none" data-count="<?php echo count($currentScheduleGame->Followers)?>">
                         <?php 
                                 foreach ($lovefollowArray["followUsersArray"] as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if(count($currentScheduleGame->Followers)>10){
                                         echo "<div data-actiontype='Followers' data-postid='$currentScheduleGame->GameId' data-id='$currentScheduleGame->GameId' data-categoryId='$currentScheduleGame->CategoryType' class='moreUsers'>more...</div>" ;
                                      } 
                                 ?>
                         </div>
                          
                  </b></a>
             <?php if($currentScheduleGame->IsEnableSocialActions == 1){ ?>
              <a><i><img data-original-title="<?php echo Yii::t('translation','Invite'); ?>" rel="tooltip" data-placement="bottom" class=" tooltiplink cursor invite_frds" src="/images/system/spacer.png"></i></a>
               <span class="cursor"><i><img  class=" tooltiplink cursor <?php  echo $currentScheduleGame->IsLoved?'likes':'unlikes' ?>"   data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Love'); ?>" src="/images/system/spacer.png"></i><b class="dLoves"  data-actiontype='Love' data-id='<?php echo $currentScheduleGame->GameId?>' data-categoryId="<?php  echo $currentScheduleGame->CategoryType;?>" data-count="<?php echo count($currentScheduleGame->Love)?>" ><span id="streamLoveCount_<?php  echo $currentScheduleGame->GameId; ?>"><?php  echo $currentScheduleGame->Love?></span>
                                    
                <div  class="userLoveView"  data-postId='<?php echo $currentScheduleGame->GameId?>' data-count="<?php echo count($currentScheduleGame->Love)?>">
                         <?php 
                                 foreach ($lovefollowArray["loveUsersArray"] as $value) {
                                    echo $value."<br/>";
                                       }
                                   
                                      if(count($currentScheduleGame->Love)>10){
                                         echo "<div data-actiontype='Love' data-categoryId='$categoryType' data-postid='$currentScheduleGame->GameId' data-id='$currentScheduleGame->GameId' data-categoryId='$currentScheduleGame->CategoryType' class='detailMoreUsers'>more...</div>" ;
                                      } 
                                 ?>
                         </div>
               
                   </b></span>

             <span><i ><a href="/<?php echo $currentScheduleGame->GameName ?>/<?php echo $currentScheduleGame->ScheduleId ?>/detail/game "><?php echo $group['GroupName'] ?><img src="/images/system/spacer.png"  data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','Comment'); ?>" class=" cursor tooltiplink  <?php  if($currentScheduleGame->PostType!=5){?><?php echo $data->IsCommented?'commented':'comments'?><?php }else{?>comments1 postdetail<?php }?>" <?php  if($currentScheduleGame->PostType ==5){?> data-id="<?php echo $currentScheduleGame->GameId;?>" data-postid="<?php  echo $currentScheduleGame->GameId ?>" data-postType="<?php  echo $currentScheduleGame->PostType;?>" data-categoryType="<?php  echo $currentScheduleGame->CategoryType;?>" <?php } ?> ></a></i><b id="commentCount_<?php  echo $currentScheduleGame->GameId; ?>"><?php  echo $currentScheduleGame->CommentCount?></b></span>
              
             <?php } ?>
                        </div>
              </div>
     </div>
     </div>
     
          <div class="span6 ">
          <div id="gamemenu" class="collapse in">
              <div class="grouphomemenuhelp alignright"></div>
         <div class="grouphomemenu">
             
     <ul>
     <li class="normal">
         <div class="menubox leadingindividuals">
             <div class="menuboxpopupHeader"><?php echo Yii::t('translation','Leading_Individuals'); ?></div>
     
     <div class="media">
         <?php if($currentScheduleGame->HighestScore>0){?>
         <div  class="pull-left marginzero generalprofileicon  skiptaiconwidth36x36 generalprofileiconborder3" >
                  <a   class="skiptaiconinner ">
                     <img src="<?php echo $currentScheduleGame->HighestUserProfilePicture?>">
                  </a>
                     </div>
                                <div class="media-body">                                   
                                    
                                    <div class="m_title"><a style="cursor:pointer" data-id="<?php echo $currentScheduleGame->HighestUserId?>" data-streamid="538eed781d8dcb4a0c8b45d1" class="userprofilename"><?php echo $currentScheduleGame->HUserName?></a></div>
                                    <div class="m_day"><?php echo $currentScheduleGame->HighestScore?> <span>points</span></div>
                                </div>
          <?php }else{?>  
              <div class="menuboxpopupHeader"><?php echo Yii::t('translation','No_Highest_Score_Yet'); ?></div>
              <?php }?> 
                             </div>
     
     
     </div>
     
     </li>
         
       
     
        <li class="normal" id="questions">
      
     <div class="menubox" >
         <div class="menuboxpopup"><span>#<?php echo Yii::t('translation','Questions'); ?></span></div>
     <div id="GroupPostCount" class="groupmenucount"><?php echo $currentScheduleGame->QuestionsCount?></div>
     <div class="conversationmenu questionsmenu"><img src="/images/system/spacer.png"></div>

     </div>

     </li>
       <li class="normal" id="conversations">
     <div class="menubox">
         <div class="menuboxpopup"><span>#<?php echo Yii::t('translation','Players'); ?></span></div>
     <div id="GroupPostCount" class="groupmenucount"><?php echo $currentScheduleGame->PlayersCount?></div>
     <div class="conversationmenu playersmenu"><img src="/images/system/spacer.png"></div>

     </div>

     </li>
     </ul>
     </div>
          </div>
              </div>
          <div class="alignright padding8top ">
          <button type="button" class="btn btn_gray btn_toggle" data-toggle="collapse" data-target="#profile, #gamemenu, #Hide, #Show, #GameBanner, #socialBar">
              <span id="Hide" class="collapse in"> <?php echo Yii::t('translation','Hide'); ?> <i class="fa fa-caret-up"></i></span>
   <span id="Show" class="collapse "><?php echo Yii::t('translation','Show'); ?> <i class="fa fa-caret-down"></i></span>
</button>
</div>
          </div>
     
     </div>
 <?php }else{?>
   

 <?php }?>
     <div class="row-fluid groupseperator">
     <div class="span12 paddingtop10 border-bottom">
         <div class="span6"><h2 class="pagetitle" id="pagetitle"><?php echo Yii::t('translation','Game_Wall'); ?> </h2></div>
         <div class="span6">
              <?php if (Yii::app()->session['IsAdmin'] == 1) { ?>
             <div class="gamefloatingmenu pull-right positionrelative" >                    
                    <ul>
            <li class="gamerightlist"><a href="#" class="gameanalytics"  ><img id="gameAnalytics" class=" tooltiplink cursor" rel="tooltip" data-type="Analytics" data-original-title="<?php echo Yii::t('translation','Analytics'); ?>" src="/images/system/spacer.png" /></a></li>

                        <li class="gamerightlist positionrelative"><a href="#" class="filter" data-toggle="dropdown" ><img id="filter" class=" tooltiplink cursor" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','FilterLabel'); ?>" src="/images/system/spacer.png" /></a>
                            <div class="dropdown dropdown-menu actionmorediv actionmoredivtop newgrouppopup newgrouppopupdivtop preferences_popup paddingzero gamefiltermenu">
                              
                                <ul class="GameManagementActionsFilter">
                                    <li><a class="Filter" style="cursor: pointer"><?php echo Yii::t('translation', 'Show_My_Game_Wall'); ?></a></li> 
                                    <!--<li><a class="NewGames" style="cursor: pointer"><?php // echo Yii::t('translation', 'NewGames'); ?></a></li>--> 
                                    <li><a class="FutureSchedule" style="cursor: pointer" ><?php echo Yii::t('translation', 'Future_Schedule_Games'); ?></a></li>      
                                    <li><a class="SuspendedGames" style="cursor: pointer"><?php echo Yii::t('translation', 'Suspended_Games'); ?></a></li>
                                </ul>
                               

                            </div>
                        </li>
                    
                        <li class="gamerightlist"><a href="/game/newgame" class="newgame"  ><img id="newgame" class=" tooltiplink cursor" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','New_Game'); ?>" src="/images/system/spacer.png" /></a></li>
                        
                    	
                        
                      
                    </ul>
                </div>
                  <?php }?>  
         </div>
         </div>
          </div>
<div role="main" id="main" >
    <div id="gamesSelect">
     
    </div>
    <div id="gameCumAnalyticsBody">
        
    </div>
      <div id="gameDetailAnalyticsBody">
        
    </div>
    <ul id="gameprofilebox" class="gameprofilebox" >
     <div  id="loadTopAds" style="display: none" ></div>
     <div id="loadMiddleAds" style="display: none"></div>
     <div id="loadBottomAds"  style="display: none"></div>
    </ul>
</div>
          <div id="promoteCalcDiv" style="display: none">    
        <div class="promoteCalc input-append date" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" data-date="">
            <label><?php echo Yii::t('translation','Promote_till_this_date'); ?></label>
            <input type="text" class="promoteInput" readonly />
            <span class="add-on">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.wookmark.js"></script>
    
         <script type="text/javascript">
//               var optionsC = {
//          itemWidth: '100%', // Optional min width of a grid item
//          autoResize: true, // This will auto-update the layout when the browser window is resized.
//          container: $('#gameprofilebox'), // Optional, used for some extra CSS styling
//          offset: 20, // Optional, the distance between grid items
//          outerOffset: 20, // Optional the distance from grid to parent
//          flexibleWidth: '50%', // Optional, the maximum width of a grid item
//          align: 'left'
//        };
    var $window = $(window);
            // loadEvents()
              var optionsC = {
          itemWidth: '100%', // Optional min width of a grid item
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#gameprofilebox'), // Optional, used for some extra CSS styling
          offset: 20, // Optional, the distance between grid items
          outerOffset: 20, // Optional the distance from grid to parent
          flexibleWidth: '50%', // Optional, the maximum width of a grid item
          align: 'left'
        };
    var $window = $(window);
            g_postIds = "";
             Custom.init();
             var pGameScheduleId='';
          var extensions ='"jpg","jpeg","gif","png","tiff"';
    loadTopAds("top","Games");
    loadTopAds("middle","Games");
    loadTopAds("bottom","Games");
    
     
      $("#gameIndex").live("click",
            function() {
                 var gameName = $('#gameBtn').attr('data-gameName');
                 var scheduleId = $('#gameBtn').attr('data-gameScheduleId');
                 var mode = $('#gameBtn').attr('data-mode');
                 
                window.location='/'+gameName+'/'+scheduleId+'/'+mode+'/game';
                
            });
            $("#questions").live("click",
            function() {
                 var gameName = $('#gameBtn').attr('data-gameName');
                 var scheduleId = $('#gameBtn').attr('data-gameScheduleId');  
                 var mode ='detail';   

                 if('<?php echo $currentScheduleGame->GameAdminUser ?>'==1){

                  mode ='questions';   
                 }
                window.location='/'+gameName+'/'+scheduleId+'/'+mode+'/game';
                
            });
            
              $(".GW_questions").live("click",
            function() {
                 var gameName =  $(this).attr('data-gameName');
                 var scheduleId = $(this).attr('data-gameScheduleId');
                 var isAdmin = $(this).attr('data-isAdmin');
                 var mode='detail';
                 if(isAdmin==1){
                  mode ='questions';   
                 }
                window.location='/'+gameName+'/'+scheduleId+'/'+mode+'/game';
                
            });
             $("#gameWallButton").live("click",
            function() {
                var streamId=$(this).attr("data-id");                
                 var gameName = $('#gameBtnWall_'+streamId).attr('data-gameName');
                 var scheduleId = $('#gameBtnWall_'+streamId).attr('data-gameScheduleId');
                 var mode = $('#gameBtnWall_'+streamId).attr('data-mode');
                 
                window.location='/'+gameName+'/'+scheduleId+'/'+mode+'/game';
                
            });
            $(".openSchedule").live("click",function(){
                var gameId=$(this).attr('data-postid');                      
                var streamId=$(this).attr('data-streamId');  
                var data = {gameId:gameId,streamId:streamId};                
                ajaxRequest("/game/loadGameSchedule",data,loadScheduleHandler,"html");
            });
//          $(".openSchedule").live("click",
//                  function(){
//                      
//                      if(pGameScheduleId!=undefined || pGameScheduleId!=null ){
//                       $("#game_"+pGameScheduleId).show();    
//                      }
//                      
//                      var gameId=$(this).attr('data-postid');                      
//                      var streamId=$(this).attr('data-streamId');  
//                      pGameScheduleId=streamId;
//                      //$(".scheduleGameDiv").html('');
//                      var data = {gameId:gameId,streamId:streamId};
//                      ajaxRequest("/game/loadGameSchedule",data,function(html){loadScheduleHandler(html,streamId)},"html");
////                $("#schedule_"+streamId).load("/game/loadGameSchedule",{gameId:gameId,streamId:streamId},loadScheduleHandler);  
////                 $("#schedule_"+streamId).show();
//                
//                 //$("#game_"+streamId).hide();
//               
//                 //applyLayout();
//                  });
 function loadScheduleHandler(html){
//     alert(html);
     $("#newModal").modal('show');
     //scrollPleaseWaitClose("spinner_survey_" + streamId);
        $("#newModal .modal-dialog").removeClass('info_modal');
        $("#newModal .modal-dialog").removeClass('alert_modal');
        $("#newModal .modal-dialog").removeClass('error_modal');
        $("#newModalLabel").html("<?php echo Yii::t('translation','ScheduleGame'); ?>");
        $("#newModal_footer").hide();
        $("#newModal_body").html(html);
        
        
 }    
function GameDLPreviewImage(id, fileName, responseJSON, type)
{
    var data = eval(responseJSON);
    g_gamethankyouIcon = '/upload/game/thankyou/' + data.savedfilename;
    var preferences='';
    if(type=='GroupLogoInPreferences'){
        preferences = 'InPreferences';
    }
    $('#updateAndCancelGroupIconUploadButtons'+preferences).show();
    $('#groupIconPreviewId'+preferences).val('/upload/game/thankyou/' + data.savedfilename);
    $('#groupIconPreviewId'+preferences).attr('src', g_gamethankyouIcon);
    $('#ScheduleGameForm_ThankYouArtifact').val('/upload/game/thankyou/' + data.savedfilename);

}
function displayErrorForBannerAndLogo(message,type){
     if(type=='GroupLogo'){
        $('#GroupLogoError').html(message);
        $('#GroupLogoError').css("padding-top:20px;");
        $('#GroupLogoError').show();
        $('#GroupLogoError').fadeOut(6000)
     }else if(type=='GroupLogoInPreferences'){
         $('#GroupLogoErrorInPreferences').html(message);
        $('#GroupLogoErrorInPreferences').css("padding-top:20px;");
        $('#GroupLogoErrorInPreferences').show();
        $('#GroupLogoErrorInPreferences').fadeOut(6000)
     } else{
        $('#GroupBannerError').html(message);
        $('#GroupLogoError').css("padding-top:20px;");
        $('#GroupBannerError').show();
        $('#GroupBannerError').fadeOut(6000)
     }  
}
function loadGameDescription(){       
    var selectedGameId=$('#gamesName').find(":selected").val();   
    var data = "selectedGameId="+selectedGameId;
     ajaxRequest("/game/getGameDetailsById",data,loadGameDescriptionHandler,"json");

}
function loadGameDescriptionHandler(data){   
    $('#S_GameTitle').html(data.GameName);
    $('#S_GameDescription').html(data.GameDescription);
}


function gameScheduleHandler(data,txtstatus,xhr){ 
    
          var data=eval(data);              
        if(data.status =='success'){            
           var msg=data.data;
           var gameId=data.gameId;
           var streamId=data.streamId;           
            $("#sucmsgForGameSchedule").html(msg);
            $("#sucmsgForGameSchedule").css("display", "block");
            $("#errmsgForGameSchedule").css("display", "none");
            //$("#schedulegame-form")[0].reset();
            $('#snippet_main').hide();  
            $('#groupIconPreviewId').attr('src', '');     
           $('#gamesName').prev().html('PleaseSelect');        
            $('#ScheduleGameForm_ShowThankYou').removeAttr('checked');
            $('#ScheduleGameForm_ShowThankYou').prev().css('background-position','0px 0px');
            $('#ScheduleGameForm_ShowDisclaimer').removeAttr('checked');
            $('#ScheduleGameForm_ShowDisclaimer').prev().css('background-position','0px 0px');
            $("#sucmsgForGameSchedule").fadeOut(3000,function(){
                $("#newModal").modal('hide');
            });
             $("#S_GameTitle").html('');
             $("#S_GameDescription").html('');
             $("#schedule_"+streamId).hide();
           // $('#gameprofilebox').empty();
            //page = 1;          
            //getCollectionData('/game/loadGameWall', 'StreamPostDisplayBean', 'gameprofilebox', 'No games found','No more games');
             pGameScheduleId='';
             //  $("#game_"+streamId).show();
              
             //   $("#game_"+streamId).html('');
              var queryString = {gameId:gameId,streamId:streamId};
       
        ajaxRequest("/game/loadSchduleGameWidget",queryString,function(data){loadGameScheduleHandler(data,streamId);},"html");
               // $("#game_"+streamId).load("/game/loadSchduleGameWidget",{gameId:gameId,streamId:streamId},loadScheduleHandler);  
                
                // $("#game_"+streamId).show();
                //  applyLayout();
                 
           //  $("#schedule_"+gameId).show();
    } else if(data.status=='Exists'){
        scrollPleaseWaitClose("gameScheduleSpinner");
          $("#errmsgForGameSchedule").html(data.data);
                    $("#errmsgForGameSchedule").css("display", "block");
                    $("#sucmsgForGameSchedule").css("display", "none");
                    $("#errmsgForGameSchedule").fadeOut(7000);
    }
        else{
            scrollPleaseWaitClose("gameScheduleSpinner");
            
            var lengthvalue=data.error.length;            
            var msg=data.data;
            var error=[];
            if(msg!=""){                
                    $("#errmsgForGameSchedule").html(msg);
                    $("#errmsgForGameSchedule").css("display", "block");
                    $("#sucmsgForGameSchedule").css("display", "none");
                    $("#errmsgForGameSchedule").fadeOut(5000);
       
            }else{
                
                if(typeof(data.error)=='string'){
                
                var error=eval("("+data.error.toString()+")");
                
            }else{
                
                var error=eval(data.error);
            }
            
            
            $.each(error, function(key, val) {
                if($("#"+key+"_em_")){  
                    $("#"+key+"_em_").text(val);                                                    
                    $("#"+key+"_em_").show();   
                    $("#"+key+"_em_").fadeOut(5000);
                   // $("#"+key).parent().addClass('error');
                }
                
            }); 
          }
        }
}
function loadGameScheduleHandler(data,streamId){
   scrollPleaseWaitClose("gameScheduleSpinner");   
    var data1 = $(data).html();    
         $("#postitem_"+streamId).html(data1);
         $("#postitem_"+streamId).show();
         applyLayout();
       //  $("#game_"+streamId).show();
}
 function closeGameScheduleDiv(gameId,streamId){
     $("#newModal").modal('hide');
     
//     $("#schedulegame-form")[0].reset();
//            $('#snippet_main').hide();  
//            $('#groupIconPreviewId').attr('src', '');             
//            $('#gamesName').prev().html('<?php echo Yii::t('translation','PleaseSelect'); ?>');            
//            $('#ScheduleGameForm_ShowThankYou').removeAttr('checked');
//            $('#ScheduleGameForm_ShowThankYou').prev().css('background-position','0px 0px');
//            $('#ScheduleGameForm_ShowDisclaimer').removeAttr('checked');
//            $('#ScheduleGameForm_ShowDisclaimer').prev().css('background-position','0px 0px');
//              $("#S_GameTitle").html('');
//             $("#S_GameDescription").html('');
//             $("#schedule_"+streamId).hide();
//               $("#game_"+streamId).show();
//               pGameScheduleId='';
             //applyLayout();
            // $('#updatePreferences').hide();
            
}

</script>
<?php include 'gameNode.php';?>
<script type="text/javascript">
     $(document).ready(function(){
       $(window).scrollEnd(function() {
            trackViews($("ul#gameprofilebox div.post.item>li.gamelist:not(.tracked)"), "GameWall");
       }, 1000);

            $("#more").click(function(){             
                 $('#gameShortDescription').hide();
                 $('#gameDetailDescription').show();
                 $("#more").hide();
                 $("#moreup").show();
                
            });
            $("#moreup").click(function(){ 
                 $('#gameShortDescription').show();
                 $('#gameDetailDescription').hide();
                 $("#more").show();
                 $("#moreup").hide();
                
            });
        });
  var handler = null;
    pF1 = 1;
    pF2 = 1;
//    if(typeof socket4Game !== "undefined")
//        socket4Game.emit('clearInterval',sessionStorage.old_key);    
    gPage = "Game";
   trackEngagementAction("Loaded","",9); 
   
   
  
    function applyLayout() {
        if(typeof optionsC !== "undefined"){
            optionsC.container.imagesLoaded(function() {
            // Create a new layout handler when images have loaded.
            handler = $('#gameprofilebox li.gamelist');
            
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
                
                trackViews($("ul#gameprofilebox div.post.item>li.gamelist:not(.tracked)"), "GameWall");

            });
        }
    }     
        
 $window.resize(function() {
     $("#gameprofilebox").hide()
     setTimeout(function(){
         applyLayout();    
         $("#gameprofilebox").show()
     },200);
  
   
        });
//    $("[rel=tooltip]").tooltip();

  
     $("ul.GameManagementActionsFilter li a").live("click", function() {
    var filterString = $(this).attr('class');
    scrollPleaseWait('postSpinLoader');
    $(window).unbind("scroll");
    $('ul.GameManagementActionsFilter li').removeClass('active');
    $(this).parent().addClass('active');
    page = 1;
    isDuringAjax=false;
    $('#gameprofilebox').empty();
    //$("#gameAnalytics").attr("data-original-title","Analytics");
     $("#gamesSelect,#gameCumAnalyticsBody,#gameDetailAnalyticsBody").hide();
     $("#gameprofilebox").show();
       $("#pagetitle").html("<?php echo Yii::t('translation','Game_Wall'); ?>");
    if(filterString=="Filter" || filterString=="FutureSchedule" || filterString=="SuspendedGames"){
      page = 1;
            getCollectionData('/game/loadGameWall', 'filterString='+filterString+'&StreamPostDisplayBean', 'gameprofilebox', '<?php echo Yii::t('translation','No_games_found'); ?>','<?php echo Yii::t('translation','No_more_games'); ?>');
     }else if(filterString=="NewGame"){
        // getCollectionData('/game/loadGameWallForNewGames', 'StreamPostDisplayBean', 'gameprofilebox', 'No games found','No more games');
    }
    else{
         getCollectionData('/game/loadGameWall', 'StreamPostDisplayBean', 'gameprofilebox', '<?php echo Yii::t('translation','No_games_found'); ?>','<?php echo Yii::t('translation','No_more_games'); ?>');
    }
     
    });
    var game_pageLength=5;
    var game_page=1;
  $("#gameAnalytics").live("click", function(){
      $('#gameprofilebox').empty();
       $('ul.GameManagementActionsFilter li').removeClass('active');
      if ($.trim( $("#gameAnalytics").attr("data-original-title")) == 'Analytics'){
            $("#gamesSelect,#gameCumAnalyticsBody,#gameDetailAnalyticsBody").show();
            
              $("#gameAnalytics").attr("data-original-title","<?php echo Yii::t('translation','Game_Wall'); ?>");
         var queryString = {type:"getGames"};
        
        $("#gameprofilebox").hide();
        ajaxRequest("/game/gameAnalytics",queryString,gameGamesHandler,"html");
         var queryString = {"type":"getCumilative","selectedGameId":"AllGames"};
        ajaxRequest("/game/gameAnalytics",queryString,gameAnalyticsHandler,"html");  
        var startLimit = 0;
        
         game_page=1;
       getDetailGameAnalytics("AllGames",startLimit);  
      }
        else{  
              $("#pagetitle").html("<?php echo Yii::t('translation','Game_Wall'); ?>");
              $("#gameAnalytics").attr("data-original-title","<?php echo Yii::t('translation','Analytics'); ?>");
            $("#gameprofilebox").show();
            $("#gamesSelect,#gameCumAnalyticsBody,#gameDetailAnalyticsBody").hide();
             page = 1;
             isDuringAjax=false;
            getCollectionData('/game/loadGameWall', 'StreamPostDisplayBean', 'gameprofilebox', '<?php echo Yii::t('translation','No_games_found'); ?>','<?php echo Yii::t('translation','No_more_games'); ?>');
        }
      
       });
  function gameGamesHandler(data){
     $("#pagetitle").html("<?php echo Yii::t('translation','Game'); ?> <?php echo Yii::t('translation','Analytics'); ?>");
     $("#gamesSelect").html(data);
     Custom.init();
  }
  function gameDetailAnalyticsHandler(data,selectedGameId){ 
      dataObj = data.split("**-numberOfRecords**");
      var noOfRecords = dataObj[1];
     // alert(noOfRecords);
       $("#gameDetailAnalyticsBody").html(dataObj[0]);
       if(noOfRecords>0){
     $("#pagination").pagination({
        currentPage: game_page,
        items: noOfRecords,
        itemsOnPage: game_pageLength,
        cssStyle: 'light-theme',
        onPageClick: function(pageNumber, event) { 
            game_page = pageNumber;
             var startLimit = ((parseInt(pageNumber) - 1) * parseInt(game_pageLength));
         getDetailGameAnalytics(selectedGameId,startLimit);
        }

    });
    }
  }
 function gameAnalyticsHandler(data){
     $("#gameCumAnalyticsBody").html(data);
   
 }
 function loadGameAnalytics(){ 
     var selectedGameId=$('#gameAnalyticId').find(":selected").val();   
     var queryString = {"type":"getCumilative","selectedGameId":selectedGameId};
     ajaxRequest("/game/gameAnalytics",queryString,gameAnalyticsHandler,"html");
      var startLimit = 0;
         var pageLength = 1;
         game_page=1;
     getDetailGameAnalytics(selectedGameId,startLimit);   
 }
 function getDetailGameAnalytics(selectedGameId,startLimit){
      var queryString = {"type":"getDetail","selectedGameId":selectedGameId,"startLimit":startLimit,"pageLength":game_pageLength};
        ajaxRequest("/game/gameAnalytics",queryString,function(data){gameDetailAnalyticsHandler(data,selectedGameId)},"html");  
 }
 function openGameAnalyticsXls(obj,gameId){
   
      var queryString ="gameId="+gameId;
      $("#"+obj.id).attr('href', "/analytics/gameAnalyticsGenerateXLS?"+queryString);
 }
 function openGameAnalyticsPDF(obj,gameId){
     
    $("#"+obj.id).attr("href", "/analytics/gamePdf?gameId="+gameId);
     var theHref = $("#"+obj.id).attr("href");
    

}function loadEvents(){    
     var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

 

    var checkin = $('#dpd1').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        if ((ev.date.valueOf() > checkout.date.valueOf()) || checkout.date.valueOf()!="") {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 0);
            checkout.setValue(newDate);
        }
        checkin.hide();
        $('#dpd2')[0].focus();
    }).data('datepicker');
    
    var checkout = $('#dpd2').datepicker({
        onRender: function(date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');

}
$(".inputor").live('paste', function (event) {    
     
    applyLayout();
});

    getCollectionData('/game/loadGameWall', 'StreamPostDisplayBean', 'gameprofilebox', '<?php echo Yii::t('translation','No_games_found'); ?>','<?php echo Yii::t('translation','No_more_games'); ?>');
     bindUserActionView();
     bindEventsForStream('gameprofilebox');
     bindEventsForStream('groupProfileDiv');
  </script>
