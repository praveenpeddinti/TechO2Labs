<?php include 'groupFloatingMenu.php'; ?>
<div id="GroupTotalPage" class="paddingtop6">
<iframe width="100%" id="myIframeContent" style="overflow-y:auto"frameborder="0" src="<?php echo $iframeURL; ?>"  > </iframe>
</div>
<script type="text/javascript">
     bindGroupsFollowUnFollow();    
window.onload = function () {
    document.getElementById('myIframeContent').height = $('#streamsection').height();
    trackBrowseDetails("http://localhost/","<?php   echo $groupId ?>"); 
};

    
    $('#IFramePost').click(function(){ 
         var groupId='<?php echo $groupId?>';
         
                loadPostWidget(groupId);
 
            });
            
</script>   
