<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="/images/inner_techo2logo.png" ></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="headernavigation">
                <?php if (Yii::app()->params['Project'] == 'SkiptaNeo') {
                    include 'leftmenu.php';
                } ?>


                <div style="float:right" class="profilearea position_R"><ul class="nav navbar-nav profileul">

                        <li class=" profilelist dropdown">
                            <div class="generalprofileicon skiptaiconwidth60x60" >
                                <a aria-expanded="false" role="button" data-toggle="dropdown" data-placement="right" class="dropdown-toggle skiptaiconinner " href="#"><img src="/images/sreeni.png"> <span class="caret"></span></a> </a>
                                <ul role="menu" class="dropdown-menu">
                                    <li> <a href="/user/logout" id="logoutId" onclick="logout()"><i class="logOutIcon"><img src="/images/system/spacer.png" ></i><?php echo Yii::t('translation', 'Logout'); ?></a></li>
                                </ul>

                            </div>



                        </li>
                    </ul></div>
            </div>
        </div><!--/.navbar-collapse -->
    </div>

</nav>











<!-- -->






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