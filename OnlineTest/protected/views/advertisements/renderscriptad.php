<div data-adid="<?php echo $stream->id?>" onclick="trackAd(this)">
<?php  

 $num = rand(0, 100000000000000) + "";
 $streamBund = $stream->StreamBundle;
 $replaceStr = str_replace("<%RandomNumber%>", $num, $streamBund);
 echo $replaceStr;
?>

</div>
