
<script type="text/javascript">
$(document).ready(function(){
   //$('#main-menu').hide();
    $("div.logo a.brand").attr("href","/");
    $(".logo a,#logo a,div.logo a.brand ").live("click",function(){      
       window.location.href = "/";
    });

});
$("ul.navbar-nav>li>a").live("click",function(){
    var $this = $(this);
    var menuhref = $this.attr("href");
    window.location.href = "/site"+menuhref;
});
</script>  



