
<?php include 'snippetDetails.php'?>
<h2 class="pagetitle">Quick Links</h2> 
<div class="alert alert-success" id="sucmsgAfterDND" style='display: none'></div> 
<div id='NAndDNDDiv' class="searchgroups searchgroupswl" >  
     
    <?php if(Yii::app()->session['IsAdmin']==1){?>
    <!--<input class="btn " id='DNDB' name="commit" type="submit" data-toggle="dropdown" value="Change Display" />--> 
<input class="btn " id='addWLink' name="commit" type="submit" data-toggle="dropdown" value="New Quick Link" /> 
    <?php }?>
<div id="addNewWebLink" class="dropdown dropdown-menu actionmorediv actionmoredivtop newgrouppopup newgrouppopupdivtop"  >
<div class="row-fluid">
        <div class="span12">
            <div class="headerpoptitle_white"><?php echo Yii::t('translation', 'New Quick Link'); ?></div>
            
            
             <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'weblink-form',
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
            <?php echo $form->hiddenField($webLinkForm, 'LinkGroup'); ?>
              <div id="WebLinkSpinner"></div>
                <div class="alert alert-error" id="errmsgForWL" style='display: none'></div>
                <div class="alert alert-success" id="sucmsgForWL" style='display: none'></div> 
                <div class="row-fluid  ">
                <div class="span12">

                    <label><?php echo Yii::t('translation', 'Web_Title');?></label>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($webLinkForm, 'Title', array('maxlength' => 100, 'class' => 'span12 textfield' )); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($webLinkForm, 'Title'); ?>
                    </div>                    
                </div>
            
               
            </div>
                 <div class="row-fluid  ">
                <div class="span12">

                    <?php echo $form->labelEx($webLinkForm, Yii::t('translation', 'Web_Link')); ?>
                    <div class="chat_profileareasearch" ><?php echo $form->textField($webLinkForm, 'WebLink', array('maxlength' => 300, 'class' => 'span12 textfield','onkeyup'=>"getWebLinksnippet(event,this);" )); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($webLinkForm, 'WebLink'); ?>
                    </div>
                    <div  id="snippet_main" style="display:none; padding-top: 10px;padding-bottom:10px;" >
           
      </div> 
                </div>
            
               
            </div>
                  <div class="row-fluid  ">
                      <div class="span12">
                          <?php echo $form->labelEx($webLinkForm, Yii::t('translation', 'WLDescription')); ?>
                          <div class="chat_profileareasearch" ><?php echo $form->textArea($webLinkForm, 'Description', array( 'maxlength' => 200,'class' => 'span12 textfield' )); ?> 
                    </div>
                    <div class="control-group controlerror">
                        <?php echo $form->error($webLinkForm, 'Description'); ?>
                    </div>
                      </div>
                      </div>
                <div class="row-fluid  ">
                      <div class="span12">
                                 <div class="span6">
                    <?php echo $form->labelEx($webLinkForm, Yii::t('translation', 'Link_Group')); ?>
                              <div class="positionrelative" >                                  
                              <select name="linkgroupname" id="linkgroupname" class="span12" >
                                  <option value="0">Please choose </option>
                                  <?php if(sizeof($linkGroups) > 0){
                                      foreach($linkGroups as $rw){?>
                                  <option value="<?php echo $rw->id; ?>"><?php echo $rw->LinkGroupName; ?></option>                                      
                                      <?php } }?>
                                  <option value="other">Other</option>
                              </select>
                    </div>
                    <div class="control-group controlerror">
               <?php echo $form->error($webLinkForm, 'LinkGroup'); ?>
                    </div>
                </div>
                          <div class="span6" id="othervalue" style="display:none;">
                              <?php echo $form->labelEx($webLinkForm, Yii::t('translation', 'Other_Link_Group')); ?>
                              <div class="chat_profileareasearch" >
                                        <?php echo $form->textField($webLinkForm, 'OtherValue', array('maxlength' => 50, 'class' => 'span12 textfield')); ?> 
                              </div>
                              <div class="control-group controlerror">
                                    <?php echo $form->error($webLinkForm, 'OtherValue'); ?>
                               </div>
                          </div>
                      </div>
                      </div>
                  
               
                 <div class="groupcreationbuttonstyle alignright">

                <?php
                echo CHtml::ajaxSubmitButton('Create', array('/Weblink/createWebLink'), array(
                    'type' => 'POST',
                    'dataType' => 'json',
                    'error' => 'function(error){
                                        }',
                    'beforeSend' => 'function(){
                                    
                                scrollPleaseWait("WebLinkSpinner","weblink-form");                }',
                    'complete' => 'function(){
                                                    }',
                    'success' => 'function(data,status,xhr) { webLinkHandler(data);}'), array('type' => 'submit', 'id' => 'newWebLink', 'class' => 'btn')
                );
                ?>
            <?php echo CHtml::resetButton(Yii::t('translation', 'Cancel'), array("id" => 'NewWebLinkReset', 'class' => 'btn btn_gray', 'onclick' => 'closeWebLink()')); ?>

            </div>
<?php $this->endWidget(); ?>
</div>    
</div>


</div>
</div>

<div id="webLinkWall">
     <ul id="WebLinkWD" class="profilebox profileboxWL">
       
        <!-- End of grid blocks -->
      </ul>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        $("a.quickLinkTrack").live("click",function(){
            var dataId = $(this).closest("div.Snippet_div").attr("data-weblinkid");
            trackEngagementAction("QuickLinkClick",dataId);
        });
       $(window).scrollEnd(function() {
            trackViews($("#webLinkWall ul#WebLinkWD div>li.ImpressionLI:not(.tracked)"), "Weblink");
       }, 1000);
   });
//    Custom.init();    
    $("#linkgroupname").change(function(){       
       var val = $(this).val();
       $("#WebLinkForm_LinkGroup").val(val);
       
       if( val === "other"){
           $("#othervalue").show();
       }else{
           $("#othervalue").hide();
       }       
    });
    $("#addWLink").bind( "click touchstart", 
        function(){
          $("#linkgroupname,#WebLinkForm_LinkGroup").val("");          
          getLinkGroups('linkgroupname');
          $("#othervalue").hide();
           $('#addNewWebLink').show();
           
        }
    );
    function getLinkGroups(id){     
            ajaxRequest("/weblink/getLinkGroups", '', function(data){getLinkGroupsHandler(data,id);});
    }
    function getLinkGroupsHandler(data,id){        
        $('#linkgroupname option').remove();        
        var dataArr = data.data;
        $('#'+id).append("<option value='0'><?php echo Yii::t('translation','Please_Choose_Link_Group'); ?></option>");
        $.each(dataArr, function(i){           
            $('#'+id).append($("<option></option>")
            .attr("value",dataArr[i]['id'])
            .text(dataArr[i]['LinkGroupName']));
        });
        $('#'+id).append("<option value='other'><?php echo Yii::t('translation','Other'); ?></option>");
    }
    
//      $("#DNDB").bind( "click touchstart", 
//        function(){
//            $('#WebLinkWD').html('');
//            $('#NAndDNDDiv').hide();
//        page=1;
//          getCollectionData('/weblink/loadWebLinks', 'WLPage=DND'+'&WebLinks', 'WebLinkWD', 'No weblinks found','No more weblinks');
//           $('#addNewWebLink').hide();
//        }
//    );
    
      
  getCollectionData('/weblink/loadWebLinks', 'WLPage=WLWall'+'&WebLinks', 'WebLinkWD', '<?php echo Yii::t('translation','No_quick_links'); ?>','<?php echo Yii::t('translation','No_more_quick'); ?>');
   function webLinkHandler(data,txtstatus,xhr) {
       scrollPleaseWaitClose("WebLinkSpinner");
          var data=eval(data);             
          if(data.status =='success'){
               var msg=data.data;
               
            $("#sucmsgForWL").html(msg);
            $("#sucmsgForWL").css("display", "block");
            $("#errmsgForWL").css("display", "none");
            
            if(data.page=='edit'){                  
            $("#editweblink-form")[0].reset();
            $("#sucmsgForWL").fadeOut(3000).promise().done(function(){
            $("#myModal_body").html('');
            $("#myModal").modal('hide');
             });
              }else{               
            $("#weblink-form")[0].reset();
            $('#snippet_main').html('');
        $("#sucmsgForWL").fadeOut(3000).promise().done(function(){
          $('#addNewWebLink').hide();
             });  
              }
              $('#WebLinkWD').html('');
             page=1;
        getCollectionData('/weblink/loadWebLinks', 'WLPage=WLWall'+'&WebLinks', 'WebLinkWD', '<?php echo Yii::t('translation','No_weblinks'); ?>','<?php echo Yii::t('translation','No_more_weblinks'); ?>');
           //  applyLayout();
          }else{
               var lengthvalue=data.error.length;            
            var msg=data.data;
            var error=[];
            if(msg!=""){                
                    $("#errmsgForWL").html(msg);
                    $("#errmsgForWL").css("display", "block");
                    $("#sucmsgForWL").css("display", "none");
                    $("#errmsgForWL").fadeOut(5000);
       
            }else{
                
                if(typeof(data.error)=='string'){
                
                var error=eval("("+data.error.toString()+")");
                
            }else{
                
                var error=eval(data.error);
            }
            
            if(typeof(data.oerror)=='string'){
                var errorStr=eval("("+data.oerror.toString()+")");
            }else{
                var errorStr=eval(data.oerror);
            }
            $.each(error, function(key, val) {
                if($("#"+key+"_em_")){  
                    $("#"+key+"_em_").text(val);                                                    
                    $("#"+key+"_em_").show();   
                    $("#"+key+"_em_").fadeOut(5000);
                   // $("#"+key).parent().addClass('error');
                }
                
            });            
            $.each(errorStr, function(key, val) {
                
                if($("#"+key+"_em_") && val != ""){  
                    $("#"+key+"_em_").text(val);                                                    
                    $("#"+key+"_em_").show();   
                    $("#"+key+"_em_").fadeOut(5000);
                   // $("#"+key).parent().addClass('error');
                }
                
            }); 
            
//            if($("#linkgroupname").val() === "other" && $("#WebLinkForm_OtherValue").val() === "")
//                $("#WebLinkForm_OtherValue_em_").html("Link Group Name cannot be blank").show().fadeOut(5000);
          }
          }
   }
  function closeWebLink(){
      $("#weblink-form")[0].reset();
      $('#addNewWebLink').hide();
      $('#snippet_main').html('');
      
  }  
      
    function getWebLinksnippet(event, obj) {
    $(".atmention_popup").hide();
    if ($(obj).val().length > 0) {
        //removeErrorMessage("NormalPostForm_Description");
    }
    var urlPattern = "(((https?)\:\/\/)|(www\.))[A-Za-z0-9][A-Za-z0-9.-]+(:\d+)?(\/[^ ]*)?";
    var text = $(obj).val();
    var results = text.match(new RegExp(urlPattern));
    if (results && event.keyCode == '32') {
       var Weburl = results[0].split("&nbsp");
        var weburl=$.trim( Weburl[0] );
           var queryString = {data:weburl,Type:"post"}; 
          // var queryString = {data:Weburl[0],Type:"post"}; 
        ajaxRequest("/post/SnippetpriviewPage", queryString, getsnipetHandler);
    }

}

var handler = null;
    // Prepare layout options.
        var options = {
          itemWidth: '100%', // Optional min width of a grid item
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#WebLinkWD'), // Optional, used for some extra CSS styling
          offset: 20, // Optional, the distance between grid items
          outerOffset: 20, // Optional the distance from grid to parent
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
            handler = $('#WebLinkWD li');
            
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
          setTimeout(function(){
            trackViews($("#webLinkWall ul#WebLinkWD div>li.ImpressionLI:not(.tracked)"), "Weblink");
             }, 2000);
            
        });
    };
    
     $("#EWL").live( "click touchstart", 
        function(){
            var WLID=$(this).data('id');            
            var queryString = 'WLID='+WLID;
        scrollPleaseWait('spinner_weblink_'+WLID);
        
         ajaxRequest("/weblink/editWebLink",queryString,function(data){openeditWebLinkPopupHandler(data,WLID);});
        }
    );
    function openeditWebLinkPopupHandler(data,id){        
        scrollPleaseWaitClose('spinner_weblink_'+id);
        $("#myModal_body").html("");
        $("#myModal_body").html(data.htmlData);        
        $("#myModalLabel").html("Edit Quick Link");
        $("#editlinkgroupname").val($("#WebLinkForm_LinkGroup").val());
        $('#myModelDialog').css("width","603px");        
        $("#myModal").modal('show');
        $("#myModal_footer").hide();
    
    }
    
  function editWebLinkHandler(data){
       var data=eval(data); 
         if(data.status =='success'){   
              var msg=data.data;
            $("#sucmsgForWL").html(msg);
            $("#sucmsgForWL").css("display", "block");
            $("#errmsgForWL").css("display", "none");
            $("#editweblink-form")[0].reset();
            $("#sucmsgForWL").fadeOut(3000).promise().done(function(){
            $("#myModal_body").html('');
            $("#myModal").modal('hide');
             });
           
         }else{
              $("#errmsgForWL").html(msg);
              $("#errmsgForWL").css("display", "block");
              $("#sucmsgForWL").css("display", "none");
              $("#errmsgForWL").fadeOut(4000);
         }
  }  
  
  function clearWebSnippet(){
      $('#EWS').html('');   
  }
  function cancelEdit(){
     $("#editweblink-form")[0].reset();
    $('#snippet_main').html('');
    $("#myModal_body").html('');
    $("#myModal").modal('hide');  
  }
  
    var dragcomplete="";    
  
 
    
    function saveDrragAndDrop(){
        
         var queryString = 'dragdata='+dragcomplete;        
         ajaxRequest("/weblink/updateDrag",queryString,updateDragHandler);
        
    }
    function updateDragHandler(){        
        
         $("#sucmsgAfterDND").html('saved the changed successfully');
         $("#sucmsgAfterDND").css("display", "block");
         $("#sucmsgAfterDND").fadeOut(3000);
         $('#WebLinkWD').html('');
        page=1;
        getCollectionData('/weblink/loadWebLinks', 'WLPage=WLWall'+'&WebLinks', 'WebLinkWD', '<?php echo Yii::t('translation','No_weblinks'); ?>','<?php echo Yii::t('translation','No_more_weblinks'); ?>');
         $('#NAndDNDDiv').show();
         $('#SaveAndCancelDND').hide();
         
    }
 
function cancelDND(){
    page=1;
      $('#WebLinkWD').html('');
      $('#NAndDNDDiv').show();
      $('#SaveAndCancelDND').hide();      
    getCollectionData('/weblink/loadWebLinks', 'WLPage=WLWall'+'&WebLinks', 'WebLinkWD', '<?php echo Yii::t('translation','No_weblinks'); ?>','<?php echo Yii::t('translation','No_more_weblinks'); ?>');
}
 gPage = "QuickLinks";
trackEngagementAction("Loaded"); 
</script>

