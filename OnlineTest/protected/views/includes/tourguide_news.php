<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!-- news -->
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
    <div class="advancedtourguidetablecol1"><div class="advancedtourguideTitle"><?php echo Yii::t('tourguide',"Stay Current On Specialty-Specific News");?></div></div>
<!--    <div class="advancedtourguidetablecol2"  ><div class="advn_maxwidthheight"><img  class="advn_maxwidthauto" src="/pictocv/<?php //echo Yii::app()->session['UserStaticData']->UserId."_".$data['OpportunityType'].".png"?>"/></div></div>-->
    </div>
       </div>
    </div>
    </div>
    <div class="advn_body">
    <div class="row-fluid">
    <div class="span12">
    <div class="span5"><img  class="advn_maxwidthauto" src="/images/system/tourguide/advn_news_img.png" /></div>
    <div class="span7">
    <ul class="advn_ultourguide">
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyleone">1</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Read News");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"We bring you the latest news and information relevant to your professionfrom only the most reputable sources in one convenient location");?>.
    </div>
    
    </div>
    </li>
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyletwo">2</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Contribute to the Conversation");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"Share your opinions on news stories and invite members to join the conversation");?>.
    </div>
    
    </div>
    </li>
    
    </ul>
    <?php if ($data['FocusDivId'] != '') { ?> <div id="newsTryItNow" class="advn_buttonarea" onclick="focusDiv('<?php echo $data['FocusDivId'] ?>','<?php echo $data['DivId'] ?>','<?php echo $i; ?>','right' ,'click');"><a class="advancedtourguidebutton" style="cursor: pointer" ><?php echo Yii::t('tourguide',"Try It Now");?></a></div> <?php } ?>
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
         <?php echo Yii::t('tourguide',"Do More with News");?>
    </div>
    <div class="advn_otherfeaturecontentText">
        <?php echo Yii::t('tourguide',"We provide a variety of ways for you to interact with News stories in a social environment including starting a conversation about the story and inviting other members to read and contribute");?>.
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



<!-- news end -->

