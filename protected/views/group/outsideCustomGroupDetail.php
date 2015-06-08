<?php include 'groupFloatingMenu.php';  ?>

<?php $location = isset($_GET['location'])?$_GET['location']:""; 
    
?>
<div id="GroupTotalPage" class="paddingtop6">
    <?php if(empty($location) || is_numeric($location)){ 
        
        ?>
    <iframe scrolling="no" width="100%" id="myIframeContent" data-value="home" frameborder="0" src="/customgroups/<?php echo $customGroupName;?>/<?php echo $customGroupName;?>Home.php" > </iframe>
    <?php }else { 
        
        $location = str_replace(",$","",rtrim(strip_tags($location))); 
        
        if(strpos($location,'.')){
            $locArr = explode(".",$location);
            $location = $locArr[0];
        }else if(strpos($location,' ')){            
            $locArr = explode(" ",$location);
            $location = $locArr[0];
        }
        ?>
    <iframe style="overflow:hidden" width="100%" id="myIframeContent" data-value="home" frameborder="0" src="/customgroups/<?php echo $customGroupName;?>/<?php echo $location;?>.php" > </iframe>
    <?php } ?>
</div>
<script type="text/javascript">    
     bindGroupsFollowUnFollow();
            $("ul.topmenu li a").live('click',function(){ 
//                
                var menuValue = $.trim($(this).text());
                var dataValue = $(this).data("avalue");
                $('.active').each(function(){
                    $(this).removeClass('active');
                });
               // alert(dataValue)
                if(dataValue !== "home" && dataValue !== "tarea" && dataValue !== "op"){
                    $("#op,#tArea").hide();                    
                }else if(dataValue === "home"){
                    $("#op,#tArea").show();
                }else if(dataValue === "tarea"){
                    $("#op").hide();
                    $("#tArea").show();
                }else if(dataValue === "op"){
                    $("#op").show();
                    $("#tArea").hide();
                }
                //               
                $(this).addClass("active");
                var linkURL = $(this).data("linkurl");                
                $("#myIframeContent").attr("src",linkURL);
                loadIframeHeight('myIframeContent');
            });
            $("ul.topmenu li").click(function(){
                if($(this).attr("id") !== "menu-button"){
                    $(this).parent().removeClass("open");
                }
                
            });
            $("li.o_noteworthy a").live("click",function(){
               
            });  
            $(document).ready(function(){
               loadIframeHeight('myIframeContent'); 
            });
            
            
    function loadIframeHeight(frameId){        
//        $('.vertical').removeClass("open");
        
        $('#'+frameId).load(function() {
                    this.style.height =
                    this.contentWindow.document.body.offsetHeight+Number(100) +'px';
            
                });
                
    }
    function setMenuStyles(flag){ 
            if(flag === "H"){
                //alert("========")
                <?php Yii::app()->session['switch'] = "horizontal";?>
                            window.location = "/Otsuka";
                //sessionStorage.switch = "horizontal";
            }else if(flag === "V"){
                <?php Yii::app()->session['switch'] = "vertical";?>
                    window.location = "/Otsuka";
               // sessionStorage.switch = "vertical";
            }
        }  
     
          $('#IFramePost').click(function(){ 
         var groupId='<?php   echo $groupId ?>';
         
                loadPostWidget(groupId);
 
            });   
        var RequestParameter='<?php echo $_REQUEST['G']?>';
        if(RequestParameter!=''){
             iframeLoaded(RequestParameter);
        }

         function iframeLoaded(rp){      
             var src="";
            if(rp=='SGLT2'){
                src="/customgroups/Janssen/SGLT2Inhibition.php";
            }else if(rp=='CLI'){
                src="/customgroups/Janssen/Clinical.php";
            }else if(rp=='PI'){
                src="/customgroups/Janssen/Prescribing.php";
            }
            else{
                src="/customgroups/Janssen/JanssenHome.php";
            }
              $('#myIframeContent').attr("src",src);  
             loadIframeHeight("myIframeContent");
          
           }
        
</script>   
