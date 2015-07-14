
   <?php include 'header.php' ?>
   
   
<?php echo $content; ?>
          

                
<?php //include 'footer.php' ?>
    <!--- new end -->

<!-- animation script start -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="js/jquery-1.11.3.js"></script>
    <script src="js/bootstrap.min.js"></script>-->
    <script type="text/javascript">
   
	$( document ).ready(function() {
	$("#username").val("");
});
	
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
	
	bindFocusEventsforInputs("div.loginform");
		
	
		function bindFocusEventsforInputs(className){
                
                $(className).find(".customselectformdiv").live("click",function(){
                    var $this = $(this);
                    $(className).find(".idproof").attr("style","left:0px;color:#075067;font-size:13px;top:5px");
                });
        
                $(className).find("label").live("click",function(){
                    var $this = $(this);	
                    $this.siblings().attr("class");
                    $this.attr("style","left:0px;color:#075067;font-size:13px;top:5px");
                    
                 });
                
		$(className).find("input[type=text],input[type=password],").focusin(function(){
			var $this = $(this);			
			var value=$.trim($this.val());
			var rightu = "0px";			
			var labelclassName = $this.siblings().attr("class");
		
			if(value != "")
			{
				$("."+labelclassName).attr("style","left:0px;color:#075067;font-size:13px;top:5px");
			}else{
					
				$("."+labelclassName).hide().css("left","-80px").css("top","5px").show();
				$("."+labelclassName).animate({ "left":"0px","top":"5px" }, "speed" ).css('color', '#075067').css('font-size', '13px');

				
				
			}
	}).focusout(function(){
			var $this = $(this);			
			var value=$.trim($this.val());
			var rightu = "35px";				
			var labelclassName = $this.siblings().attr("class");
			if(value != "")
			{
				$("."+labelclassName).attr("style","left:0px;color:#075067;font-size:13px;top:5px");
			}else{
				$("."+labelclassName).attr("style","left:10px;color:#075067;font-size:13px;top:5px");				
				$("."+labelclassName).animate({ "left":"10px","top":rightu }, "slow" ).css('color', '#ccc').css('font-size', '13px');
				
			}
		});	
	}
    </script>
<!-- animation script end -->
</body>
</html>
