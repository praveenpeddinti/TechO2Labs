
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<!-- stream -->
<div id="CopyUrl_sucmsg" class="alert alert-success margintop5 " style="display: none"></div>
 <div id="postwidgetContent" >
<table border="0" cellpadding="0" cellspacing="0" style="width:100%;margin:auto">
<tr>
<td>
<!-- Normal Posts -->
<?php 
 if(is_object($stream))
      { 

     $style="display:block";

    foreach($stream as $data){

?>
<table cellpadding="0" cellspacing="0" style="width:100%">
<tr>
<td style="background-image:url(<?php echo $siteurl; ?>/snipetshtmls/rightdotline.png);background-repeat:repeat-y;background-position:left top">
<table cellpadding="0" cellspacing="0" style="width:100%">
<tr>
 <td style="vertical-align: top">
        <table cellpadding="0" cellspacing="0" style="width:100%">
        <tr>
         <td style="vertical-align: top">
        	 <table cellpadding="0" cellspacing="0" style="width:100%">
             <tr>
             <td style="width:87px;vertical-align:top;">
            <table cellpadding="0" cellspacing="0" style="width:100%">
             <tr>
              <td style="width:87px;height:87px;vertical-align:top;text-align:center;border-top:10px solid #fff">
              <div style="width:87px;height:87px;vertical-align:top;text-align:center;position:relative;">
               <a href="<?php echo $url;?>" target="_blank" > <img src="<?php echo  $data->FirstUserProfilePic; ?>" style="max-width:100%;width:90%;border:3px solid #d9d9d9" /></a>
             </div>
             </td>
             </tr>
             </table>
             </td>
            
             <td style="vertical-align:top">
            		 <table cellpadding="0" cellspacing="0" style="width:100%">
                    <tr>
                     <td style="background-image:url(<?php echo $siteurl; ?>/snipetshtmls/boxleftbg.png);background-repeat:repeat-y;background-position:right top;width:20px;vertical-align:top;padding-top:30px">
           
             </td>
                    <td style="border-top:1px solid #d9d9d9;border-right:1px solid #d9d9d9;padding:3px 10px;height:24px">
                        
            
                    
               
                
               <?php if(($data->CategoryType!=3 || $data->IsIFrameMode==1) && $data->CategoryType!=5  && $data->CategoryType!=6 ){ ?>
               
                      <a href="<?php echo $url;?>" target="_blank" style="text-decoration:none;color:#333;font-family:arial;font-size:12px;display:block">
                          <b style="font-weight:bold;font-family:arial;font-size:15px;color:#5f6468;">
                             <?php if($data->isGroupAdminPost == 'true' && $data->ActionType=='Post') {
                           echo html_entity_decode($data->GroupName); 
                        }else{
                            echo $data->FirstUserDisplayName;
                        } ?>
                          
                          </b>
                          <?php  echo $data->SecondUserData?> <?php  echo $data->StreamNote." ".$data->PostTypeString ?>
                          <?php if($data->PostType==2 || $data->PostType==3){ if(isset($data->Title) && $data->Title!=""){ echo $data->Title; };} ?>
                           <?php if ($data->PostType==11){ echo '"'.$data->Title.'"' ?> <?php } else if ($data->PostType==5){echo $data->CurbsideConsultTitle ?><?php } }?>
                          
                      
                      </a>  
                    
                    </td>
                    </tr>
                    </table>
 <!--------------------------------------------------------Content Start------------------------------------------------------------------------------------------------------------->                
                <table cellspacing="0" cellpadding="0" style="width:100%">
                    <tbody><tr>
                     <td style="background-image:url(<?php echo $siteurl; ?>/snipetshtmls/boxleftbg.png);background-repeat:repeat-y;background-position:right top;width:20px;vertical-align:top;padding-top:1px">
             <img src="<?php echo $siteurl; ?>/snipetshtmls/leftarrow.png" style="border:0">
             </td>
                    <td style="border-top:1px solid #d9d9d9;border-right:1px solid #d9d9d9;padding:3px 10px;vertical-align:top">
                          <div style="min-height:60px">               
                        <table cellspacing="0" cellpadding="0" style="width:100%">
                    <tbody><tr>
                            
                        <?php 
                        if($data->PostType ==12 ){
                        if ($data->GameBannerImage  != "") {
                                        ?>
                                        <td style="width:200px;padding-top:7px;padding-bottom:7px;vertical-align:top">
                                                
                                                    <div style="border:2px solid #d0d0d0;padding:2px;">
                                                        <a href="<?php echo $url;?>" target="_blank"><img src="<?php echo $siteurl; ?>/<?php echo$data->GameBannerImage  ?>" style="width:100%;border:0"/></a>
                                                    </div> 
                                        </td>
                        <?php }
                        
                        } ?>     
                            
                          <?php 
                        if($data->PostType ==11 ){ ?>
                            <?php if ($data->HtmlFragment != '') { ?>
                            <td style="width:200px;padding-top:7px;padding-bottom:7px;vertical-align:top">
                                <a  class="pull-left img_single NOBJ postdetail">
                                    <?php $object = stristr($data->HtmlFragment, '<object');
                                    if ($object != '') {
                                        ?>
                                        <div class="galleria-info" style="bottom:0px"><div class="galleria-info-text" style="border-radius:0px"><div class="galleria-info-description" style="height:132px"></div></div></div>
                                    <?php } ?>
                                    <?php
                                    $pattern = '/(width)="[0-9]*"/';
                                    $string = $data->HtmlFragment;
                                    $string = preg_replace($pattern, "width='180'", $string);
                                    $pattern = '/(height)="[0-9]*"/';
                                    $string = preg_replace($pattern, "height='150'", $string);

                                    echo $string;
                                    ?>
                                </a>
                        </td>

                        <?php }?>
                            
                            
                            
                     <?php    } ?>
                    <td style="padding-left:10px;vertical-align:top;padding-top:7px;padding-bottom:7px"> 
                     <table cellspacing="0" cellpadding="0">
                    <tbody>
                       <?php 
                        if($data->PostType ==12 ){?>
                        <tr>
                            <?php echo $data->GameName ?>
                        </tr>
                       <?php } ?>
                     <tr>
                    <td style="vertical-align:top"> <a style="text-decoration:none;color:#333;font-family:arial;font-size:12px;display:block" href="<?php echo $url;?>" target="_blank">
                      <?php echo $data->PostText;?>
                      </a></td>
                    </tr>
                    </tbody></table>
                                      <?php
            
            
            if($data->GameStatus=="play"){
                $class = "btn btnplay btnplaymini";
                $label = Yii::t('translation','Play_Now')." <i class='fa fa-chevron-circle-right'></i>";
            }
            else if($data->GameStatus=="resume"){
                 $class = "btn btnresume btnplaymini";
                  $label = Yii::t('translation','Resume')." <i class='fa fa-chevron-circle-right'></i>";
            }
            else if($data->GameStatus=="view"){
               $class = "btn btnviewanswers btnplaymini";
                $label = Yii::t('translation','View')." <i class='fa fa-chevron-circle-right'></i>";
            }?>
                        <?php 
                        if($data->PostType ==12 ){?>
                    <div style="text-align:right;vertical-align:top">
                      <a href="<?php echo $url;?>" target="_blank"><img style="border:0" src="<?php echo $siteurl; ?>/snipetshtmls/playnow.png"></a>
                    </div>
                        <?php } ?>
                    </td>
                    </tr>
                   </tbody></table>
                          </div>
                      
                                      </td>
                    </tr>
                    </tbody></table>
 
 </td>
             </tr>
             </table>
            <table cellpadding="0" cellspacing="0" style="width:100%">
                <tr>
                    <td style="vertical-align: bottom;width:87px;line-height: 0">
                        <img src="<?php echo $siteurl; ?>/snipetshtmls/rightdot.png" style="border:0" />
                        
                    </td>
                    <td style="vertical-align: top">
                        <!----------------------------------------------------Content End---------------------------------------------------------------------------->
<!--------------------------------------------------Social-Bar Start------------------------------------------------------------------------------------------------------>                 
                 <table cellpadding="0" cellspacing="0" style="width:100%">
                     <tr>
                         <td style="background-image:url(<?php echo $siteurl; ?>/snipetshtmls/boxleftbg.png);background-repeat:repeat-y;background-position:right top;width:20px;vertical-align:top;padding-top:30px">

                         </td>
                         <td style="border-top:1px solid #d9d9d9;border-bottom:1px solid #d9d9d9;border-right:1px solid #d9d9d9;padding:3px 10px">
                             <a href="<?php echo $url;?>" target="_blank" style="text-decoration:none;color:#333;font-family:arial;font-size:12px;display:block">
                                 <table cellpadding="0" cellspacing="0" >
                                     <tr>
                                         <td>

                                             <?php if ($data->IsFollowingPost == '1') { ?>
                                                 <img src="<?php echo $siteurl; ?>/snipetshtmls/folllowactive.png" style="border:0"/>
                                             <?php } else { ?>
                                                 <img src="<?php echo $siteurl; ?>/snipetshtmls/folllowinactive.png" style="border:0"/>
                                             <?php } ?> 

                                         </td>
                                         <td style="padding:3px 15px 3px 5px;font-weight:bold;font-family:arial;font-size:12px;color:#5f6468;"><?php echo $data->FollowCount ?></td>
                                       
                                         <?php if (!$data->DisableComments) { ?>
                                             <td>
                                                 <?php 
                                                     if($data->IsCommented!=1){ ?>
                                                   
                                                 
                                                 <img src="<?php echo $siteurl; ?>/snipetshtmls/commentsinactive.png" style="border:0"/>
                                                     <?php }else{ ?>
                                                         
                                                 <img src="<?php echo $siteurl; ?>/snipetshtmls/commentsactive.png" style="border:0"/>
                                                  <?php    } ?>

                                                     
                                                  
                                             </td>
                                             <td style="padding:3px 15px 3px 5px;font-weight:bold;font-family:arial;font-size:12px;color:#5f6468;"><?php   echo count($data->Comments);?></td>
                                         <?php } ?>
                                     </tr>
                                 </table>
                             </a>
                         </td>
                     </tr>
                 </table>
<!----------------------------------------------------Social-Bar END------------------------------------------------------------------------------------------>
             
                         </td>
        </tr>
        </table>
       
        </td>
        </tr>
        </table>
</td>
</tr>
</table>
</td>
</tr>
</table>

      <?php }
          }
          ?>
</td>
</tr>
</table>
</div>

<div style="text-align:right;vertical-align:top;padding-top: 10px;">
         <button data-mode="play"   class="btn btnplay btnplaymini gameStatusView " type="button"  onclick="copypostwidget('<?php echo $siteurl; ?>');"  id="copyurl"><?php echo Yii::t('translation','Copy_Content'); ?> <i class="fa fa-chevron-circle-right"></i></button>
        </div>
</body>
</html>

 

