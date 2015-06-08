<div id="containerId" class="container">
    <div id="padding10Id" class="padding10">
<h2 class="pagetitle">Contact Us</h2> 
    <div class="row-fluid">
<div class="span12">
<div class="row-fluid">
         <div class="span7 span10textcenter">
            <div class="padding20">
            <div style="padding-top:15px;text-align:center">
            <img style="width:100%" src="/images/system/contactmap.png">
            </div>
            <div class="">
            <div class="row-fluid">
            <div class="span12 paddingt12">
            <div class="span6 profilebox">
            <div class="p_name"> Skipta, Ltd.</div>
            <div class="p_add">416 ½ North Queen Street</div>
            <div class="p_add">Lancaster, PA 17603</div>
            <div class="p_info">717.517.8720</div>
            <div class="p_mail"><a 
href="mailto:info@skipta.com">info@skipta.com</a></div>
           </div>
            <div style="padding-top:20px" class="span6">
             <div class="p_faq">Interested in joining the steering 
committee?</div>
              <div class="p_faq">Sales and Advertising?</div>
               <div class="p_faq">Technical Support?</div>
            </div>
            </div>

            </div></div>

         </div>
         </div>
     </div>
   </div>
</div>
       
</div></div>
<script type="text/javascript">
  
    <?php if(isset($this->tinyObject->UserId)) { ?>
   loginUserId = '<?php echo $this->tinyObject->UserId; ?>';
    <?php } ?>
    $(document).ready(function(){
        if(loginUserId!=undefined && loginUserId!=null && loginUserId != ""){
        $('#containerId').removeClass();
        $('#padding10Id').removeClass('padding10'); 
    }
});

</script>