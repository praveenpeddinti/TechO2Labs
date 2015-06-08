
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
      <div id="CopyUrl_sucmsg" class="alert alert-success margintop5 " style="display: none"></div>
          <div id="postwidgetContent" >
<?php
foreach($job as $rw){
    if($rw['Source'] != 'hec'){ 
    ?>        
<table border="0" cellpadding="0" cellspacing="0"style="margin:auto">
<tr>
    <td>
        <a href="<?php echo $url;?>" target="_blank" style="text-decoration:none;color:#333;font-family:arial;font-size:12px;display:block"> 
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;border:1px solid #ccc;">
        <tr>
            <td style="padding:10px;font-size:16px;font-family:arial;color:#333;border-bottom:1px solid #ccc;">
                
               
                 <b id="groupName" data-id="<?php echo $rw['id'] ?>"   class="group"><?php echo $rw['JobTitle'] ?> - </b> <i> <?php echo $rw['JobPosition'] ?></i> 
            </td>
        </tr>
	<tr>
            <td style="padding:5px 10px;font-size:14px;font-weight:bold;font-family:arial;color:#333;border-bottom:1px solid #ccc;">
                
               <?php echo $rw['Category'];?> - <span style="font-size:12px;font-weight:normal;font-family:arial;color:#7C7B79"><?php echo $rw['Industry']?></span>

            </td>
        </tr>

	<tr>
            <td style="padding:5px 10px;border-bottom:1px solid #ccc;">
                
                <?php if(isset($rw['IframeUrl'])) {?>
                    <?php if(isset($rw['SnippetDescription']) && !empty($rw['SnippetDescription'])){?>
                        <a href="<?php echo $rw['IframeUrl']?>" target="_blank"> <?php echo $rw['SnippetDescription']?></a>
                   <?php }else{?>
                        <a href="<?php echo $rw['IframeUrl']?>" target="_blank"> <?php echo $rw['IframeUrl']?></a>
                   <?php }?>
                        <?php } else{
                          echo $rw['JobDescription']; 
                        }?>

            </td>
        </tr>
        </table>
              </a>
    </td>
</tr>
</table>
    <?php }else{ ?>      
                  <?php 
$location = "";
if(!empty($rw['City'])){
    $location = $rw['City'];
}
if(!empty($rw['State'])){
    if(!empty($location))
        $location = "$location, ".$rw['State'];
    else
        $location = $rw['State'];
}
if(!empty($rw['Zip'])){
    if(!empty($location))
        $location = "$location, ".$rw['Zip'];
    else
        $location = $rw['Zip'];
}
?>
                   <?php $strtime=strtotime($rw['PostedDate'])?>
<table border="0" cellpadding="0" cellspacing="0"style="width:100%;margin:auto">
<tr>
    <td>
        
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;border:1px solid #ccc;">
        <tr>
            
            <td style="padding:10px;font-size:16px;font-weight:bold;font-family:arial;color:#333;border-bottom:1px solid #ccc;">
               <a href="<?php echo $url;?>" target="_blank" style="text-decoration:none;color:#333;font-family:arial;font-size:12px;display:block"> 
                 <b id="groupName" data-id="<?php echo $rw['id'] ?>"   class="group"><?php echo $rw['JobTitle'] ?> - </b> <i style="font-size:12px;font-weight: normal;color:#888888;font-style:normal;"> <?php echo $rw['JobPosition'] ?></i> 
               </a>
                 
            </td>
           
        </tr>
        <tr>
            <td style="padding:10px;font-size:12px;font-family:arial;color:#333;border-bottom:1px solid #ccc;"> 
                <table border="0" cellpadding="0" cellspacing="0"style="width:100%;margin:auto">
                    <tr>
                        <td style="text-align:left;">
                            <b style="font-size:14px"> <?php echo $rw['JobId']; ?></b>
                        </td>
                         <td style="text-align: right;color:#7E7E7E;font-size:12px;font-style: italic">
                <?php echo CommonUtility::styleDateTime($strtime); ?>
            </td>
                    </tr>
                </table>
               
                
            </td>
           
        </tr>
        <?php if(!empty($rw['EmployerName'])){ ?>   
        <tr>
            <td style="padding:5px 10px 5px 10px;">    
                <table border="0" cellpadding="0" cellspacing="0"style="width:100%;margin:auto">
                    <tr>
                        <td style="text-align:left;font-size:14px"><img style="vertical-align: bottom" src="<?php echo $iurl;?>/employer.png"> </img> <?php echo $rw['EmployerName']; ?></td>
                        
                    </tr>
                </table>
                 
            </td>            
        </tr>
        <?php } ?>
            <?php if(!empty($location) || !empty($rw['Industry'])){ ?>
            <tr  >
                <td style="padding:5px 10px 5px 10px;font-size:12px;font-family:arial;color:#333;border-bottom:1px solid #ccc;">
                    <table border="0" cellpadding="0" cellspacing="0"style="width:100%;margin:auto">
                    <tr>
                        <td style="font-size:14px;text-align: left">
                            <img style="vertical-align: middle"  src="<?php echo $iurl;?>/location.png"/> <?php echo $location; ?>
                        </td>
                        
                    </tr>
                </table>
                    
                    
                    
                </td>
                
                
            </tr>
            <?php } ?>
            
	

	<tr>
            
            <td style="padding:5px 10px;font-size:14px;line-height: 18px;border-bottom:1px solid #ccc;">
                <a href="<?php echo $url;?>" target="_blank" style="text-decoration:none;color:#333;font-family:arial;font-size:12px;display:block"> 
               <?php echo $rw['JobDescription'];  ?>
                    </a>
            </td>
            
        </tr>
        
            
          <?php if(!empty($rw['InternalApplyUrl'])){ ?>
        <tr>
            <td style="padding:10px;text-align: right">                
               
                <input data-uri="<?php echo $rw['InternalApplyUrl']; ?>" type="button" value="<?php echo Yii::t('translation','Learn_More_Apply'); ?>" name="commit" class="btn btn-mini jobsapplybutton"  />
            </td>            
        </tr>
        <?php } ?>
        </table>
              
    </td>
</tr>
</table>              
    <?php } } ?>
     </div>
    
    <div style="text-align:right;vertical-align:top;padding-top: 10px;">
         <button data-mode="play"   class="btn btnplay btnplaymini gameStatusView " type="button"  onclick="copypostwidget('<?php echo $siteurl; ?>');"  id="copyurl"><?php echo Yii::t('translation','Copy_Content'); ?> <i class="fa fa-chevron-circle-right"></i></button>
        </div>
</body>
</html>