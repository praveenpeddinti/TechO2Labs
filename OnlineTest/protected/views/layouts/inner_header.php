<header>
    <div class="container paddingtoplogo">
    <div class="row-fluid">
            <div class="span12">
                <div class="span3 iphonelogo ">
                 <a class="navbar-brand" href="#"><img src="/images/inner_techo2logo.png" ></a>    
                </div>
                <?php if(Yii::app()->session['IsAdmin'] ==1){?>
                <div class="span9 positionrelative" id="headerSection">
                    <div class="headernavigation">
                        <?php include 'leftmenu.php'; ?>
                    </div>
                    <div class="pull-right mobileclear">
                        <ul class="nav headermenuarea ">
                            <li class="normal" id="profileDropDown">
                                 <li class=" profilelist dropdown">
                                    <div class="generalprofileicon skiptaiconwidth60x60" >
                                        <a aria-expanded="false" role="button" data-toggle="dropdown" data-placement="right" class="dropdown-toggle skiptaiconinner " href="#"><img src="/images/sreeni.png"> <span class="caret"></span></a> </a>
                                        <ul role="menu" class="dropdown-menu">
                                            <li> <a href="/user/logout" id="logoutId" onclick="logout()"><i class="logOutIcon"><img src="/images/system/spacer.png" ></i><?php echo Yii::t('translation', 'Logout'); ?></a></li>
                                        </ul>
                                    </div>
                                 </li>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php }?>
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