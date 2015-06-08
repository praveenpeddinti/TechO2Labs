<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- follow feature -->
<div class="movetop">
<div class="moveright">
	<div class="movebottom">
		<div class="moveleft">
                     <input type="button" value="-" class="button minimizeJoyRide" style="float:right" onclick="minimizeJoyride('<?php echo $i;?>')"/>
			<div class="advancedtourguidepadding">
	<div class="advn_header">
    <div class="row-fluid">
     <div class="span12 position_r">
   
       <div class="advancedtourguidetable">
    <div class="advancedtourguidetablecol1"><div class="advancedtourguideTitle"><?php echo Yii::t('tourguide',"Follow Feature");?></div></div>
<!--    <div class="advancedtourguidetablecol2"  ><div class="advn_maxwidthheight"><img  class="advn_maxwidthauto" src="/pictocv/<?php //echo Yii::app()->session['UserStaticData']->UserId."_".$data['OpportunityType'].".png"?>"/></div></div>-->
    </div>
       </div>
    </div>
    </div>
    <div class="advn_body">
    <div class="row-fluid">
    <div class="span12">
    <div class="span7 advn_footerlinkstextcener"><img class="advn_maxwidthauto" src="/images/system/tourguide/advn_followfeature_users_img.gif" /></div>
    <div class="span5">
    <ul class="advn_ultourguide">
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyleone">1</span>
    <div class="advn_contentTitle">
  <?php echo Yii::t('tourguide',"Follow Members");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"Follow members within {NetworkName} by clicking on the grey feet associated with an individual member. This is a great way to connect with colleagues and stay informed of their important conversations and other contributions within the community",array('{NetworkName}'=>Yii::app()->params['NetworkName']));?>.
    </div>
    
    </div>
    </li>
   
    </ul>
        
        <?php if ($data['FocusDivId'] != '') { ?> <div class="advn_buttonarea" onclick="focusDiv('highlightNewUsers','<?php echo $data['DivId'] ?>','<?php echo $i; ?>','left','click');"><a class="advancedtourguidebutton" style="cursor: pointer" ><?php echo Yii::t('tourguide',"Try It Now");?></a></div> <?php } ?>
    </div>
    </div>
    </div>
    <div class="row-fluid advn_search_paddingtop20">
    <div class="span12">
   
    <div class="span6">
    <div >
    <ul class="advn_ultourguide ">
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyletwo">2</span>
    <div class="advn_contentTitle">
   <?php echo Yii::t('tourguide',"Follow Posts");?>
    </div>
    <div class="advn_contentText">
    <?php echo Yii::t('tourguide',"By following a post, you're keeping tabs onall of its interactions, including what other members are saying about it");?>.
    </div>
    
    </div>
    </li>
   
    </ul>
   <?php if ($data['FocusDivId'] != '') { ?> <div class="advn_buttonarea" onclick="focusDiv('highlightNewPosts','<?php echo $data['DivId'] ?>','<?php echo $i; ?>','bottom','click');"><a class="advancedtourguidebutton"  style="cursor: pointer"><?php echo Yii::t('tourguide',"Try It Now");?></a></div> <?php } ?>
    </div>
    </div>
     <div class="span6 advn_footerlinkstextcener"><img  class="advn_maxwidthauto" src="/images/system/tourguide/advn_followfeature_posts_img.gif" /></div>
    </div>
    </div>
       <div class="row-fluid advn_search_paddingtop20">
    <div class="span12">
    <div class="span7 advn_footerlinkstextcener"><img class="advn_maxwidthauto" src="/images/system/tourguide/advn_followfeature_groups_img.gif" /></div>
    <div class="span5">
    <ul class="advn_ultourguide">
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstylethree">3</span>
    <div class="advn_contentTitle">
   <?php echo Yii::t('tourguide',"Follow Groups");?>
    </div>
    <div class="advn_contentText">
  <?php echo Yii::t('tourguide',"Find groups you're interested in and follow them to receive their updates, resources and group conversations within your stream");?>. 
    </div>
    
    </div>
    </li>
   
    </ul>
         <?php if ($data['FocusDivId'] != '') { ?> <div class="advn_buttonarea" onclick="focusDiv('highlightNewGroups','<?php echo $data['DivId'] ?>','<?php echo $i; ?>','right','click');"><a class="advancedtourguidebutton" style="cursor: pointer" ><?php echo Yii::t('tourguide',"Try It Now");?></a></div> <?php } ?>
        
     
    </div>
    </div>
    </div> 
        
      
    </div>
    <div class="advn_footer">
    <div class="advn_otherfeatures">
    <div class="advn_otherfeatureTitle">
        <?php echo Yii::t('tourguide',"Other Features You Might be Interested In");?>:
    </div>
    <div>
    <ul class="advn_otherfeaturelist">
    <li >
     <div class="advn_otherfeaturelistTitle">
         <?php echo Yii::t('tourguide',"Follow Anything");?>
    </div>
    <div class="advn_otherfeaturecontentText">
        <?php echo Yii::t('tourguide',"{NetworkName} allows you to follow any object within the community to tailor your experience. Keep an eye out for grey feet, which signify an object that you haven’t yet followed. By clicking the grey feet that then turn green, you are automatically following that object",array('{NetworkName}'=>Yii::app()->params['NetworkName']));?>.
    </div>
    </li>
   
    </ul>
    </div>
    </div>
      
    </div>

</div>
		</div>
	</div>
</div>
</div>


<!-- followfeature end -->

