<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.imagesloaded.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.wookmark.js"></script>
<div id="usergroupsfollowingdiv">
            <?php include 'userGroupsFollowing.php'; ?>
<?php include 'snippetDetails.php'?>
<div class="row-fluid" >
    <div class="span3" id="numero1"><h2 class="pagetitle"><?php echo Yii::t('translation','GroupsLabel'); ?> </h2></div><!-- This id numero1 is used for Joyride help -->
   
    <div class="span9 ">
        <!--replace class "fa fa-question" with  "fa fa-video-camera videohelpicon" if we have description and video remaining will be same-->
            
        
            <div class="searchgroups" >
                <?php if(isset($canCreateGroup) && $canCreateGroup==1) {?> 
            <input class="btn " id='addGroup' name="commit" type="submit" data-toggle="dropdown" value="<?php echo Yii::t('translation','Group_Creation'); ?>" /> 
             
<div id="addNewGroup" class="dropdown dropdown-menu actionmorediv actionmoredivtop newgrouppopup newgrouppopupdivtop" >
            
			<div class="headerpoptitle_white"><?php echo Yii::t('translation', 'Group_Creation');?></div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'groupcreation-form',
                    'enableClientValidation' => true,
                    'enableAjaxValidation' => false,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    //'action'=>Yii::app()->createUrl('//user/forgot'),
                    'htmlOptions' => array(
                        'style' => 'margin: 0px; accept-charset=UTF-8',
                    ),
                ));
                ?>
                        <?php echo $form->hiddenField($newGroupModel, 'IFrameMode'); ?>  
                        <?php echo $form->hiddenField($newGroupModel, 'GroupMenu'); ?>  
                        
                        <div id="groupCreationSpinner"></div>
                <div class="alert alert-error" id="errmsgForGroupCreation" style='display: none'></div>
                <div class="alert alert-success" id="sucmsgForGroupCreation" style='display: none'></div> 
                
                <div class="row-fluid  ">
                    <div class="span12 positionrelative">

                       <?php echo $form->labelEx($newGroupModel, Yii::t('translation', 'GroupName')); ?>
                        <span id="hiddengroupnamediv" style="display: none;"></span>                        
                        <span id="groupnamehtml" class="view_html" > <?php echo Yii::t('translation', 'Html_view'); ?></span>
                        <?php //echo $form->hiddenField($newGroupModel, 'GroupName'); ?>
                        <div class="chat_profileareasearch" ><?php echo $form->textField($newGroupModel, 'GroupName', array('maxlength' => 65, 'class' => 'span12 textfield groupnamerelatedfield')); ?> 
                            <ul class="typeahead dropdown-menu" style="top:64px; left:0px;display: none " id="typeheadstyle">
                                    
                            </ul>
                            </div>
                        
                        <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'GroupName'); ?>
                        </div>
                    </div>
                </div>
<!--                <div class="row-fluid  ">
                    <div class="span12">

                        <?php //echo $form->labelEx($newGroupModel, Yii::t('translation', 'GroupShortDescription')); ?>
                        <?php //echo $form->textArea($newGroupModel, 'ShortDescription', array("placeholder" => Yii::t('translation', ''), 'maxlength' => 150, 'class' => 'span12 textfield')); ?> 
                    <div class="control-group controlerror">
                            <?php //echo $form->error($newGroupModel, 'ShortDescription'); ?>
                    </div>
                    </div>
                </div>-->
                <div class="row-fluid  ">
                    <div class="span12">

                    <?php echo $form->labelEx($newGroupModel, Yii::t('translation', 'GroupDescription')); ?>
                    <?php echo $form->textArea($newGroupModel, 'Description', array( 'class' => 'span12  inputor')); ?> 
                   
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'Description'); ?>
                        </div>
                    </div>
                </div>
                <div class="row-fluid padding8top">
                    <div class="span12">
                        <div class="span6">
                            <?php echo $form->labelEx($newGroupModel, Yii::t('translation', 'GroupMode')); ?>
                            <div class="positionrelative"  id="">                                
                            <?php echo CHtml::dropDownList('mode', '', 
              array('0' => Yii::t('translation', 'Native_Mode'), '1' => Yii::t('translation', 'IFrame_Mode'), '2' => Yii::t('translation', 'Custom_Mode')),array('empty' => Yii::t('translation', 'Select_mode_type'),'class'=>"styled span12 textfield")); ?>
                                </div>
                        <?php 
                            //echo $form->radioButton($newGroupModel,'IFrameMode',array('value'=>0,"id"=>"GroupCreationForm_IFrameMode",'uncheckValue'=>null,'class'=>'styled', 'onclick'=>'changeGroupMode("Native")','closeSnippetDiv()'));     
                        ?>
                            <!--Native Mode-->
                            <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'IFrameMode'); ?>
                        </div>
                        </div>
                        
                        <div class="span6" style="display: none;" id="custommenu">
                            <?php echo $form->labelEx($newGroupModel, Yii::t('translation', 'GroupMenu')); ?>
                            <div class="positionrelative" >
                            <?php echo CHtml::dropDownList('menutype', '', 
              array('1' => Yii::t('translation', 'Horizontal_Menu'), '2' => Yii::t('translation', 'Vertical_Menu'), '3' => Yii::t('translation', 'No_Menu')),array('empty' => Yii::t('translation', 'Select_menu_type'),'class'=>"styled span12 textfield")); ?>
                                </div>
                        <?php 
                            //echo $form->radioButton($newGroupModel,'IFrameMode',array('value'=>1,"id"=>"GroupCreationForm_IFrameMode",'uncheckValue'=>null,'class'=>'styled', 'onclick'=>'changeGroupMode("IFrame")'));     
                        ?>
                            <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'GroupMenu'); ?>
                        </div>
                        </div>
                      </div>
                  </div>
<?php if(count($subSpe)>0){ ?>
<div class="row-fluid customrowfluidad  "  >
                  <div class="span12" id="SubSpecialityList">

                        <?php echo $form->labelEx($newGroupModel, Yii::t('translation', 'User_Register_Urology_What_is_Primary')); ?>
                    <div class="chat_profileareasearch"  style="margin:0px">
                        <?php
                        echo $form->dropDownlist($newGroupModel, 'SubSpeciality',$subSpe , array(
                            'class' => "span12",
                            'multiple' => 'multiple'
                        ));
                        ?>   
                    </div>
                    <div class="control-group controlerror">
<?php echo $form->error($newGroupModel, 'SubSpeciality'); ?>
                    </div>
                </div>
            </div>
<?php }?>
                <div class="row-fluid  " id="IFrameURLDiv" style="display: none">
                    <div class="span12">

                       <?php echo $form->labelEx($newGroupModel, Yii::t('translation', 'IFrameURL')); ?>
                        <?php echo $form->textField($newGroupModel, 'IFrameURL', array( 'maxlength' => 100, 'class' => 'span12 textfield', 'onkeyup'=>'getsnipetIframe(this.id)','value'=>'')); ?> 
                        <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'IFrameURL'); ?>
                        </div>
                    </div>
                </div>
             <div  id="snippet_main" style="display:none; padding-top: 10px;padding-bottom:0px;" ></div>
             <div class="row-fluid lineheight25"  id="GroupCreationAutoPrivateMode" style=" padding-top: 10px;padding-bottom:0px;">
                 <div class="span12">
                    <div class="span6" id="isPrivate">

                    
                   <?php echo $form->checkBox($newGroupModel,'IsPrivate',array('class' => 'styled'))?>
                    <?php echo Yii::t('translation', 'Mark_as_Private'); ?>     
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'IsPrivate'); ?>
                        </div>
                    </div>
                 <div class="span6" id="autofollowdiv">

                    
                   <?php echo $form->checkBox($newGroupModel,'AutoFollow',array('class' => 'styled'))?>
                         <?php  echo  Yii::t('translation','Show_AutoFollowGroup_Label');?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'AutoFollow'); ?>
                        </div>
                    </div>
                 
                 </div>
                </div>
                   <div class="row-fluid lineheight25" >
                  <div class="span6">
                   <?php echo $form->checkBox($newGroupModel,'AddSocialActions',array('class' => 'styled'))?>
                       <?php  echo  Yii::t('translation','Show_SocialAction_Label');?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'AddSocialActions'); ?>
                        </div>
                  </div>
                 <div class="span6" > 
                   <?php echo $form->checkBox($newGroupModel,'DisableWebPreview',array('class' => 'styled'))?>
                         <?php  echo  Yii::t('translation','Disable_WebPreview_Label');?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'DisableWebPreview'); ?>
                        </div>
                 
                 </div>
                </div>
                <div class="row-fluid lineheight25" >

                 <div class="span6" id="groupVisibility"> 
                   <?php echo $form->checkBox($newGroupModel,'ConversationVisibility',array('class' => 'styled',"checked"=>"checked"))?>
                        <?php  echo  Yii::t('translation','Show_ConversationsGroup_Label');?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'ConversationVisibility'); ?>
                        </div>
                 
                 </div>
                  <div class="span6" id="DisableStreamConversation"> 
                   <?php echo $form->checkBox($newGroupModel,'DisableStreamConversation',array('class' => 'styled'))?>
                    <?php  echo  Yii::t('translation','Disable_StreamConversation_Label');?> 
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'DisableStreamConversation'); ?>
                        </div>
                 
                 </div>
                </div>             
                <div class="row-fluid lineheight25" id="restrictrow">
                 <div class="span6"  id="restrictedGroupdiv"> 
                   <?php echo $form->checkBox($newGroupModel,'RestrictedAccess',array('class' => 'styled'))?>
                         <?php echo Yii::t('translation','RestrictedAccess'); ?>
                    <div class="control-group controlerror">
                            <?php echo $form->error($newGroupModel, 'RestrictedAccess'); ?>
                </div>             
                 
                 </div>
                </div>
                
                <div class="groupcreationbuttonstyle alignright">
                    
                        <?php
                        echo CHtml::ajaxSubmitButton(Yii::t('translation', 'Create'), array('/group/createnewgroup'), array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'error' => 'function(error){
                                        }',
                            'beforeSend' => 'function(){
                                scrollPleaseWait("groupCreationSpinner","groupcreation-form"); 
//                                $("#GroupCreationForm_GroupName").val(sessionStorage.GroupName);

                                }',
                            'complete' => 'function(){
                                                    }',
                            'success' => 'function(data,status,xhr) { groupCreationHandler(data,status,xhr);}'), array('type' => 'submit', 'id' => 'newGroupId', 'class' => 'btn')
                        );
                        ?>
                        <?php echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'NewGroupReset', 'class' => 'btn btn_gray','onclick'=>'closeSnippetDiv()')); ?>

                </div>
            <?php $this->endWidget(); ?>
            </div>
             <?php }?>
            <i data-id="Groups_DivId" class="fa fa-question helpicon helpmanagement helprelative pull-right pull-bottom tooltiplink" data-placement="bottom" rel="tooltip"  data-original-title="<?php echo Yii::t('translation','GroupsLabel'); ?>" ></i> 
        </div>
           

    </div>
    
    
</div>
<div id="groupslogoarea" class="groupslogoarea">
    <div id="groupsSpinLoader"></div>
    <div id="groupsFollowingId">
        
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

    <div id="numero2"><h2 class="pagetitle"><?php echo Yii::t('translation','Join_more_Groups'); ?> </h2></div><!-- This id numero2 is used for Joyride help -->



<div id="main" role="main">

      <ul id="MoreGroupsDiv" class="profilebox">
       
        <!-- End of grid blocks -->
      </ul>

    </div>
</div>
<div id="groupPostDetailedDiv" style="display: none;"></div>

<script type="text/javascript" >
     gPage = "Group";     
Custom.init();
     $(document).ready(function(){   checkPrivateAndAutoFollow();   
        $("b[class=group]").live( "click", function(){ 
            var groupName=$(this).attr('data-name');
            window.location="/"+groupName;            
          // loadGroupDetailPage($(this).attr('data-id'));
        } );
        $("#streamMainDiv div[name=groupimage]").live( "click", function(){
           // var groupId=$(this).attr('data-id');
            //window.location='/group/groupdetail?data-id='+groupId
              var groupName=$(this).attr('data-name');
            window.location="/"+groupName;
          // loadGroupDetailPage($(this).attr('data-id'));          
         } );
        $("li[name=GroupDetail]").live( "click", function(){ 
            var groupName=$(this).attr('data-name');
            var customGroup = $(this).data("customgroup");   
            
                window.location="/"+groupName;            
            
          // loadGroupDetailPage($(this).attr('data-id'));
        } );
        getCollectionData('/group/getJoinMoreGroups', 'GroupCollection', 'MoreGroupsDiv', '<?php echo Yii::t('translation','No_groups_found'); ?>','<?php echo Yii::t('translation','No_more_groups'); ?>');
   
        trackEngagementAction("Loaded","",3);  
    });
$("#grouppost").addClass('active');
    var startLimit=0;
    var pageLength=8;
    var userFollowingGroupsCount=0;
      bindGroupsForStreamFromIndex();
  //  groupsFollowingHandler(<?php echo $userGroupsFollowing; ?>,<?php echo $userGroupsFollowingCount; ?>);
       groupsFollowing();
    
   function groupsFollowing(){
   
        var query="test";
        ajaxRequest('/group/getUserFollowingGroups', query, groupsFollowingHandler);
    }
    function groupsFollowingHandler(data){            
       userFollowingGroupsCount= Number(data.count);
       
        var item = {
            'data':data.data
        };
    
      
         if (data != "") 
         {
             $("#groupsFollowingId").html(
             $("#groupFollowingTmpl_render").render(item)      
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
        
        if ((data.data).length == 0) {
            $("#noRecordsTRgroupFollowing").show();
        }
        
        if((data.data).length< userFollowingGroupsCount)
        {
            var moreCount = Number(userFollowingGroupsCount)- Number((data.data).length);
           // alert("count-------"+moreCount);
            $("#moreFollowingGroupsId").show();
            
             $("#totalcount").html(moreCount)      
             
        }
        if(!detectDevices())
            $("[rel=tooltip]").tooltip();
        
        trackViews($("#groupsFollowingId ul li.userfollowinggroups:not(.tracked)"), "FollowGroups");
    }
    
     $("#NewGroupReset").bind( "click touchend", 
        function(e){
           $('#addNewGroup').hide();           
           e.stopPropogation();
        }
    );
    $("#addGroup").bind( "click touchstart", 
        function(){
           $('#addNewGroup').show();
           $('#IFrameURLDiv').hide();
           $("#selectmode").html("<?php echo Yii::t('translation','Select_mode_type'); ?>");
           $("#selectmenutype").html("<?php echo Yii::t('translation','Select_menu_type'); ?>");
           $("#mode").val("");
           $("#custommenu").hide();
           $("#menutype").val("");
           $("#GroupCreationForm_GroupName,#GroupCreationForm_Description,GroupCreationForm_IFrameMode,GroupCreationForm_GroupMenu").val("")
           Custom.init();
        }
    );
    
    function showmoreGroups(){
       
	 scrollPleaseWait('groupsSpinLoader','groupslogoarea');         
        var query="startLimit=" +startLimit+ "&pageLength=" +pageLength;
        ajaxRequest('/group/getMoreFollowingGroups', query, moreGroupsFollowingHandler);
	}
        
        
        
      function moreGroupsFollowingHandler(data){
         scrollPleaseWaitClose('groupsSpinLoader');
        
        var item = {
            'data':data.data
        };
         if (data.data != "") 
         {
         
             $("#groupsFollowingId").append(
             $("#groupFollowingTmpl_render").render(item)      
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
        
        
        trackViews($("#groupsFollowingId ul li.userfollowinggroups:not(.tracked)"), "FollowGroups");
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
            $('#snippet_main').hide();
            $("#snippet_main").html("");
             $('#SubSpecialityList').show();
            globalspace['IsWebSnippetExistForPost']=0;
            globalspace['weburls']="";
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
    $('span.radio').live("click",
        function(){
            if($(this).next().val()==0){
                $('#IFrameURLDiv').hide();
                closeSnippetDiv();
            }else{
                $('#IFrameURLDiv').show();
                getsnipetIframe(event,id);
                 $('#snippet_main').show();
                  $('#Snippet_div').show();
            }
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
          setInterval(function() {
            trackViews($("#main ul#MoreGroupsDiv li:not(.tracked)"), "MoreGroups");
          }, 2000);
            
        });
    };


    $("#mode").on('change',function(){
        var val = $(this).val();
        $("#GroupCreationForm_IFrameMode").val(val);  
        if(val == 2){
            $("#custommenu").show(); 
            $('#IFrameURLDiv,#groupVisibility').hide();
        }else{
            if(val == 1){
                $('#IFrameURLDiv').show();
                $("#groupVisibility").hide();
            }else{
                $('#IFrameURLDiv').hide();
                $("#groupVisibility").show();
            }
            $("#custommenu").hide();
        }
    });   
    
    $("#menutype").on('change',function(){
        var val = $(this).val();
        $("#GroupCreationForm_GroupMenu").val(val);
        
        
    });
        
 $window.resize(function() {
     
  applyLayout();
   
        });
//    $("[rel=tooltip]").tooltip();

    $("#GroupCreationForm_GroupName").bind('keypress',function(){
        var value = $(this).val();
        $("#hiddengroupnamediv").html(value);
        sessionStorage.GroupName = $("#hiddengroupnamediv").text();
    }).bind('blur',function(){
        var value = $(this).val();
        $("#hiddengroupnamediv").html(value);
        sessionStorage.GroupName = $("#hiddengroupnamediv").text();
    });
  $("#groupnamehtml").live('click',function(){
        var text = $("#GroupCreationForm_GroupName").val();
        sessionStorage.GroupName = text;
//        var html = $.parseHTML( text );   
        $("#hiddengroupnamediv").text(text);
        $("#hiddengroupnamediv").html($("#hiddengroupnamediv").text());        
        var html = $("#hiddengroupnamediv").text();
//        $("#GroupCreationForm_GroupName").val(html);
        if(text != "")
            $("#typeheadstyle").html('<li class="" data-value="Florida" style="cursor:pointer">'+html+'</li>').show();

  });
  $("#typeheadstyle").bind('click',function(){
    var hValue = $(this).html();
    var html = $("#hiddengroupnamediv").html($("#hiddengroupnamediv").text()).text();
    $("#GroupCreationForm_GroupName").val(html);
    $(this).hide();
});
$("#addNewGroup").bind("click",function(){
     $("#typeheadstyle").hide();
});
  </script>
  <script type="text/javascript">
      function checkautofollow(){
          alert("-");
      }
$(document).ready(function(){
    
       $(window).scrollEnd(function() {
            trackViews($("#main ul#MoreGroupsDiv li:not(.tracked)"), "MoreGroups");
       }, 1000);
       
    
    if(!detectDevices()){                   
        $("[rel=tooltip]").tooltip();
    }
    $(".groupsview_content").live("click",function(){
       var $this = $(this);
       var groupName = $this.attr("data-groupname");
       window.location="/"+groupName;
    });
});
        </script>