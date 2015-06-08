<div id="groupslogoarea" class="groupslogoarea">
    <?php include 'userSubGroupsFollowing.php'; ?>
    <div id="groupsSpinLoader"></div>
    <div id="SubgroupsFollowingId">
        
        <div id="noRecordsForFollowedGroups" style="display: none">
    <table>
        <tr>
            <td colspan="8">
                <span class="text-error"> <b><?php echo Yii::t('translation','No_records_found'); ?></b></span>
            </td>
        </tr>
     </table>
   </div>
    </div>
</div>

<h2 class="pagetitle"><?php echo Yii::t('translation','More_Sub_Groups'); ?> </h2>



<div id="main" role="main">

      <ul id="MoreGroupsDiv" class="profilebox">
       
        <!-- End of grid blocks -->
      </ul>

    </div>

<div id="groupPostDetailedDiv" style="display: none;"></div>

<script type="text/javascript" >

     $(document).ready(function(){       
        $("b[class=group]").live( "click", function(){ 
           var subgroupName=$(this).attr('data-name');
            var groupName='<?php echo addslashes($groupName)?>'; 
            window.location="/"+groupName+'/sg/'+subgroupName;
          // loadGroupDetailPage($(this).attr('data-id'));
        } );
        $("#streamMainDiv div[name=groupimage]").live( "click", function(){
           // var groupId=$(this).attr('data-id');
            //window.location='/group/groupdetail?data-id='+groupId            
           var subgroupName=$(this).attr('data-name');
            var groupName='<?php echo addslashes($groupName)?>'; 
            window.location="/"+groupName;
          // loadGroupDetailPage($(this).attr('data-id'));
         } );
        $("li[name=GroupDetail]").live( "click", function(){ 
            var subgroupName=$(this).attr('data-name');
            var groupName='<?php echo addslashes($groupName)?>';  
            window.location="/"+groupName+'/sg/'+subgroupName;
          // loadGroupDetailPage($(this).attr('data-id'));
        } );
   var groupId='<?php echo $groupId?>'; 
      
        getCollectionData('/group/GetJoinMoreSubGroups', 'groupId='+groupId+'&SubGroupCollection', 'MoreGroupsDiv', 'No sub groups found','No more sub groups');
    });
$("#grouppost").addClass('active');
    var startLimit=0;
    var pageLength=8;
    var userFollowingGroupsCount=0;
      bindGroupsForStreamFromIndex();  
       groupsFollowing();
    
   function groupsFollowing(){                 
        var groupId='<?php echo $groupId?>';        
        var query="groupId="+ groupId;
        ajaxRequest('/group/getUserFollowingSubGroups', query, groupsFollowingHandler);
    }
      function groupsFollowingHandler(data){         
       userFollowingGroupsCount= Number(data.count);
       
        var item = {
            'data':data.data
        };    
      
         if (data != "") 
         {
             $("#SubgroupsFollowingId").html(
             $("#subGroupFollowingTmpl_render").render(item)      
                );
        //specific for rendering group names in HTML view...
                $(".userfollowinggroups").each(function(){
                    var $this = $(this);
                    var groupName = $this.attr("data-original-title");
                    var gId = $this.attr("data-id");
                    $("#temp_"+gId).html(groupName);
                    $("#temp_"+gId).html($("#temp_"+gId).text());
                    groupName = $("#temp_"+gId).text();
                    $("#temp_"+gId).html("").hide();
                    //groupName = $.parseHTML(groupName);
                    $this.attr("data-original-title",groupName);
                })
         }
         startLimit = Number((data.data).length);
        
        if (data.data == 'failure') {        
            $("#noRecordsTRgroupFollowing").show();
        }
        
        if((data.data).length< userFollowingGroupsCount)
        {
            var moreCount = Number(userFollowingGroupsCount)- Number((data.data).length);           
            $("#moreFollowingGroupsId").show();
            
             $("#totalcount").html(moreCount)      
             
        }
        if(!detectDevices())
            $("[rel=tooltip]").tooltip();
    }
    
     $("#NewSubGroupReset").bind("click touchstart", 
        function(){
           $('#addNewSubGroup').hide();
        }
    );
    $("#addSubGroup").bind( "click touchstart", 
        function(){
           $('#addNewSubGroup').show();
        }
    );
    
    function showmoreSubGroups(groupId){
       var groupId='<?php echo $groupId?>';    
	 scrollPleaseWait('groupsSpinLoader','groupslogoarea');         
        var query="startLimit=" +startLimit+ "&pageLength=" +pageLength+ "&groupId=" +groupId;
        ajaxRequest('/group/getMoreFollowingSubGroups', query, moreGroupsFollowingHandler);
	}
        
        
        
      function moreGroupsFollowingHandler(data){
         scrollPleaseWaitClose('groupsSpinLoader');
        
        var item = {
            'data':data.data
        };
         if (data.data != "") 
         {
         
             $("#SubgroupsFollowingId").append(
             $("#subGroupFollowingTmpl_render").render(item)      
                );
        //specific for rendering group names in HTML view...
            $(".userfollowinggroups").each(function(){
                    var $this = $(this);
                    var groupName = $this.attr("data-original-title");
                    var gId = $this.attr("data-id");
                    $("#temp_"+gId).html(groupName);
                    $("#temp_"+gId).html($("#temp_"+gId).text());
                    groupName = $("#temp_"+gId).text();
                    $("#temp_"+gId).html("").hide();
                    //groupName = $.parseHTML(groupName);
                    $this.attr("data-original-title",groupName);
                })
              
         }
         startLimit = Number(data.data.length) + Number(startLimit);
        if (data.length == 0) {
        $("#noRecordsTR").show();
        }
        if(data.data.length < userFollowingGroupsCount)
        {
            $("#moreFollowingGroupsId").show();
            var moreCount = Number(userFollowingGroupsCount)- Number(startLimit);
             $("#totalcount").html(moreCount)      
             
        }
        if(!detectDevices())
            $("[rel=tooltip]").tooltip();
    }
    /*
     * Handler for requesting new category
     */
    function groupCreationHandler(data,txtstatus,xhr){
     scrollPleaseWaitClose("groupCreationSpinner");
          var data=eval(data); 
        if(data.status =='success'){
            var msg=data.data;
            $("#sucmsgForGroupCreation").html(msg);
            $("#sucmsgForGroupCreation").css("display", "block");
            $("#errmsgForGroupCreation").css("display", "none");
            $("#groupcreation-form")[0].reset();
             $("#sucmsgForGroupCreation").fadeOut(3000,function(){
            $("#addNewGroup").hide();
        }); 
        groupsFollowing();
        }else{
            var lengthvalue=data.error.length;            
            var msg=data.data;
            var error=[];
            if(msg!=""){                
                    $("#errmsgForGroupCreation").html(msg);
                    $("#errmsgForGroupCreation").css("display", "block");
                    $("#sucmsgForGroupCreation").css("display", "none");
                    $("#errmsgForGroupCreation").fadeOut(5000);
       
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
   function bindGroupsForStreamFromIndex(){  
    
        $(".stream_content img.follow").live( "click", 
        function(){
            var groupId = $(this).closest('div.social_bar').attr('data-groupid');
            followOrUnfollowGroup(groupId,"UnFollow");
            
             $("#groupId_"+groupId).remove();
           applyLayout();
             groupsFollowing();
          
           $(this).attr({
               "class":"unfollow" 
            });
        }
    );
    $(".stream_content img.unfollow").live( "click", 
        function(){
            var groupId = $(this).closest('div.social_bar').attr('data-groupid');
            followOrUnfollowGroup(groupId,"Follow");
             groupsFollowing();            
            $("#groupId_"+groupId).remove();
           applyLayout();
            
            $(this).attr({
               "class":"follow" 
            });
        }
    );   
     $(".streamMainDiv img.follow").live( "click", 
        function(){
            var groupId = $(this).closest('div.social_bar').attr('data-groupid');
            followOrUnfollowGroup(groupId,"UnFollow");
           $(this).attr({
               "class":"unfollow" 
            });
        }
    );
    $("#streamMainDiv img.unfollow").live( "click", 
        function(){
            var groupId = $(this).closest('div.social_bar').attr('data-groupid');
            followOrUnfollowGroup(groupId,"Follow");
            $(this).attr({
               "class":"follow" 
            });
        }
    );
   }
</script>
  

<script type="text/javascript">
  var handler = null;
    // Prepare layout options.
        var options = {
          itemWidth: '48%', // Optional min width of a grid item
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#MoreGroupsDiv'), // Optional, used for some extra CSS styling
          offset: 8, // Optional, the distance between grid items
          outerOffset: 10, // Optional the distance from grid to parent
           flexibleWidth: '50%', // Optional, the maximum width of a grid item
          align: 'left'
        };


      /**
       * Refreshes the layout.
       */
       var $window = $(window);
      function applyLayout() {         
            
        options.container.imagesLoaded(function() {
            // Create a new layout handler when images have loaded.
            handler = $('#MoreGroupsDiv li');
            
        if ($window.width() < 753) {
         
            options.itemWidth = '100%';
            options.flexibleWidth='100%';

        }
           else if ($window.width() > 753 && $window.width() < 1000) {
            
            options.itemWidth = '48%';
           //   options = { flexibleWidth: '100%' };
             
            
        }else{
           
            options.itemWidth = '32.5%'; 
        }
       
            handler.wookmark(options);
            
        });
    };


     
        
 $window.resize(function() {
     
  applyLayout();
   
        });
//    $("[rel=tooltip]").tooltip();

  
  </script>
  <script type="text/javascript">
$(document).ready(function(){
                if(!detectDevices()){                   
                    $("[rel=tooltip]").tooltip();
                }
              });
        </script>