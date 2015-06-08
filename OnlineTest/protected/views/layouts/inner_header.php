<div id="sidebar"></div>
<header id="header">
     <!-- Modal -->
            <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content ">
                        <div class="modal-header" id="newModal_header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="newModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body" id="newModal_body">

                        </div>
                        <div class="modal-footer" id="newModal_footer">
                            <button type="button" class="btn btn-small" id="newModal_btn_primary"><?php echo Yii::t('translation','Save_changes'); ?></button>
                            <button type="button" class="btn btn-small" data-dismiss="modal" id="newModal_btn_close"><?php echo Yii::t('translation','Close'); ?></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
	<div class="container">
    	<div class="row-fluid">
        	<div class="span12">
            	<div class="span2 iphonelogo">
                    <a href="/"><img src="<?php echo Yii::app()->params['Logo']; ?>" alt="logo" class="logo"></a>                </div>
              <div class="span10 positionrelative" id='headerSection'>
                  
                <div class="pull-right mobileclear">
                   
                <ul class="nav headermenuarea ">
                    
                
<!--                <li> <input type="button" value="loadJoyRide" onclick="getNewUserJoyrideDetails();"></li>-->
                
<!--                <li class="gameiconlist">
                <img src="/images/system/removedimg.jpg"> 
                  <a  href="#" class="gameicon"  data-original-title="Game" rel="tooltip" data-placement="bottom" lass="tooltiplink">&nbsp;</a>
                </li>-->
                <?php if(Yii::app()->params['Chat'] == "ON"){?>
                 <li class="normal">
                     <div class="not_count " id="chatOffCount" style="display: none"></div>
                 <a  onclick="divrenderget('chatDiv','/chat/index')" id="chatIcon" class="chaticon"  data-original-title="<?php echo Yii::t('translation','Chat'); ?>" rel="tooltip" data-placement="bottom" lass="tooltiplink">&nbsp;</a>
                 
                </li>
                <?php } ?>
                 
                
                 <li class="normal" id='profileDropDown'>
                     <div  data-toggle="dropdown" id="drop3" class="headerprofileicon skiptaiconwidth43x43 skiptaiconmargintop6">
                  <a  href="#" rel="tooltip" data-placement="bottom"  class="skiptaiconinner submenu" data-original-title="<?php echo Yii::app()->session['TinyUserCollectionObj']['DisplayName']?>" >  <img id="profileImage_header" src=<?php echo Yii::app()->session['TinyUserCollectionObj']['profile250x250']?> > </a>
                     </div>
                  <div class="dropdown-menu profilewidth" >

               <form style="margin: 0px" accept-charset="UTF-8" action="/" method="post">
                <div id="UserDisplayName" class="headerpoptitle"><?php echo Yii::app()->session['TinyUserCollectionObj']['DisplayName']?></div>
                
                <ul>
                
               
                <li> <a href="/user/logout" id="logoutId" onclick="logout()"><i class="logOutIcon"><img src="/images/system/spacer.png" ></i><?php echo Yii::t('translation','Logout'); ?></a></li>
              
                </ul>
                
               </form>
             </div>
                 	 
                </li>
                </ul>
               
                </div>
            </div>
            </div>
       
        </div>
           
     </div>
</header>
<div id="norecordsFound" style="display: none" ></div>


<style>
    .table-cell{ display: table; width:100%}
    .table-col1, .table-col2, .table-col3, .table-col4 { display: table-cell; }
    .table-col3{width:160px}
    .table-col1{width:201px;vertical-align: top;}
    .table-col4{ vertical-align:top}
    .network_positionabsolutediv {left: 248px; width:540px}
  
    .drop_d_width .select{width:120px}
    .drop_d_width select{width:160px}
 @media (max-width: 480px) {
   .table-col1, .table-col2, .table-col3{ display: block; width:100%; text-align: center; margin: auto}
   .network_positionabsolutediv {left:0; right:0; width:100%}
   .drop_d_width{width:80%}
    .drop_d_width span{width:80%}
    }
  
    
</style>