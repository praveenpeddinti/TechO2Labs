
    <div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->
        
        

  <script>

   //alert('<?php echo Yii::app()->session['UserStaticData']->disableJoyRide ?>' +","+'<?php echo Yii::app()->session['UserStaticData']->UserClassification?>');
    var urlpageName=window.location.pathname;
       // alert(urlpageName); 
   
  setTimeout(function(){
      if('<?php echo Yii::app()->session['UserStaticData']->disableJoyRide ?>'!=1 &&  '<?php echo Yii::app()->session['UserStaticData']->userSessionsCount ?>'<=10)
    {
        if('<?php echo Yii::app()->session['UserStaticData']->UserClassification?>'==0)
          getJoyrideDetails();
          else  if('<?php echo Yii::app()->session['UserStaticData']->UserClassification?>'==1)
          {
             
          
                 urlpageName=urlpageName.substring(1,urlpageName.length);
            if(urlpageName.search("profile/")>=0)
               {
                   if(urlpageName=="profile/"+'<?php echo Yii::app()->session['TinyUserCollectionObj']['uniqueHandle']?>')
                     getNewUserJoyrideDetails();
                }
                else
                     getNewUserJoyrideDetails();
          }
        
           
     } 
   else if('<?php echo Yii::app()->session['UserStaticData']->disableJoyRide ?>'==0)
     {
          if('<?php echo Yii::app()->session['UserStaticData']->UserClassification?>'==0)
          {// alert('before');
              getJoyrideDetails();
          }
            else  if('<?php echo Yii::app()->session['UserStaticData']->UserClassification?>'==1)
            {
                
                urlpageName=urlpageName.substring(1,urlpageName.length);
            if(urlpageName.search("profile/")>=0)
               {
                   
                   if(urlpageName=="profile/"+'<?php echo Yii::app()->session['TinyUserCollectionObj']['uniqueHandle']?>')
                     getNewUserJoyrideDetails();
                }
                else
                     getNewUserJoyrideDetails();
                
            }
          
     }
//     else if('<?php echo  Yii::app()->session['OpportunityToLoadOnclick']?>'=='Yes')
//     {
//          getNewUserJoyrideDetails();
//         var unset=' <?php  unset(Yii::app()->session['OpportunityToLoadOnclick']) ?>';
//     }
     
     
  },300);
    
    
   
     
       //  getNewUserJoyrideDetails();
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', '<?php  echo Yii::app()->params['ga_transaction_id'];?>', '<?php  echo Yii::app()->params['ga_Analytics_ip'];?>');
  ga('send', 'pageview');

</script>
<script type="text/javascript">
    
        if(sessionStorage.minChatWidget=="true"){
        $("#minChatWidgetDiv").show();
        $("#minChatWidgetDiv").unbind().bind("click",function(){ 
       
     $(".closedchat").removeClass("m_c_header_active");
      if($("#minTourGuideDiv").css("display")=="block"){
     
    }else
    minimizeJoyride()
     divrenderget('chatDiv','/chat/index');
     
//     $("#chatDiv").show();
//       $("#contentDiv,#minChatWidgetDiv,#notificationHomediv").hide();
//       $('#chatBoxScrollPane,#usersListScrollPane').jScrollPane();
});
   }
var g_streamPostIds = 0;
$("#closeChatWidget").bind("click",function(){
    $("#minChatWidgetDiv").unbind();
     $("#minChatWidgetDiv").hide();
      $("#minChatWidgetDiv").unbind().bind("click",function(){ 
      if($("#minTourGuideDiv").css("display")=="block"){
     
    }else
    minimizeJoyride()
   
     
//     $("#chatDiv").show();
//       $("#contentDiv,#minChatWidgetDiv,#notificationHomediv").hide();
//       $('#chatBoxScrollPane,#usersListScrollPane').jScrollPane();
});
    
     if($("#minTourGuideDiv").css("display")=="block"){
      
    }
     sessionStorage.removeItem("minChatWidget");
    
});

$(document).ready(function(){
/**
 * this is used for mobiles/Ipads to handle the dropdown user experience issue...
 */
$('body').on('click touchstart',function(e){       
      $(".postmg_actions").each(function(key,value){
            if($(this).attr('class') == "postmg_actions postmg_actions_mobile open"){
               $(this).removeClass("open");
               $(this).find('dropdown-menu').addClass("open");
            }
        });
        
        $(".postmg_actions").each(function(key,value){
            if($(this).attr('class') == "postmg_actions postmg_actions_mobile open"){
               $(this).removeClass("open");
               $(this).find('dropdown-menu').addClass("open");
            }
        });
        $(".submenu").each(function(key,value){
           if($(this).parent('li').attr('class') != undefined && $(this).parent('li').attr('class') != null && $(this).parent('li').attr('class') == "open"){
             $(this).parent('li').removeClass('open');
           }
        });
      
});
$('.dropdown-menu').live("click touchstart",function(){
   $(this).parent('div').addClass("open"); 
   $(this).parent('li').addClass("open"); 
});    
});
</script>

</body>
</html>
