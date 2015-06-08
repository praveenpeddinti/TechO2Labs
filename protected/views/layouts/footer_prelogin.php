<footer id="footer" >
	<div class="footer">
	<div class="container">
		<div class="row-fluid">
    <div class="span12">
        <div class="span5 footerlinks mobilecenter">
           <a  onclick="openFooterTabs('termsOfServices');" class="cursor"><?php echo Yii::t('translation','Terms_of_Use'); ?></a> | <a  onclick="openFooterTabs('privacyPolicy');" class="cursor"><?php echo Yii::t('translation','Privacy_Policy'); ?></a>
        <br/>
         <div class="copyright"><?php echo Yii::app()->params['COPYRIGHTS']; ?></div>
        </div> <div class="span7 mobilecenter"><div class="pull-right"><a href="http://skipta.com" target="_blank"><img src="/images/system/poweredbyskipta.png"></a></div> </div>     </div>
    </div>
	</div>	
</div>	
<!--        <div id="f_body"></div>-->
    
</footer>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php  echo Yii::app()->params['ga_transaction_id'];?>', '<?php  echo Yii::app()->params['ga_Analytics_ip'];?>');
  ga('send', 'pageview');

</script>
<script type="text/javascript">
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


      <script> 
    $('.sf-menu li').click(function(){
    
    $('.sf-menu li').removeClass('active selected')
    $(this).addClass('selected');
});
        </script>  