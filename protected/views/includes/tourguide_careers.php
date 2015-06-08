<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!-- career -->
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
    <div class="advancedtourguidetablecol1"><div class="advancedtourguideTitle"><?php echo Yii::t('tourguide',"Explore Career Opportunities");?></div></div>
<!--    <div class="advancedtourguidetablecol2"  ><div class="advn_maxwidthheight"><img  class="advn_maxwidthauto" src="/pictocv/<?php //echo Yii::app()->session['UserStaticData']->UserId."_".$data['OpportunityType'].".png"?>"/></div></div>-->
    </div>
       </div>
    </div>
    </div>
    <div class="advn_body">
    <div class="row-fluid">
    <div class="span12">
    <div class="span5"><img  class="advn_maxwidthauto" src="/images/system/tourguide/advn_career_img.gif" /></div>
    <div class="span7">
    <ul class="advn_ultourguide">
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyleone">1</span>
    <div class="advn_contentTitle">
     <?php echo Yii::t('tourguide',"View Jobs");?>
    </div>
    <div class="advn_contentText">
   <?php echo Yii::t('tourguide',"You will see job openingswithin your profession that are located within the U.S. and compiled based on your interests");?>. 
    </div>
    
    </div>
    </li>
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyletwo">2</span>
    <div class="advn_contentTitle">
    <?php echo Yii::t('tourguide',"Apply for Jobs");?> 
    </div>
    <div class="advn_contentText">
  <?php echo Yii::t('tourguide',"With one easy click, you’re able to read the full job description and instantly apply");?>. 
    </div>
    
    </div>
    </li>
    
    </ul>
     <?php if ($data['FocusDivId'] != '') { ?> <div class="advn_buttonarea" onclick="focusDiv('<?php echo $data['FocusDivId'] ?>','<?php echo $data['DivId'] ?>','<?php echo $i; ?>','right' ,'click');"><a style="cursor: pointer" class="advancedtourguidebutton" ><?php echo Yii::t('tourguide',"Try It Now");?></a></div> <?php } ?>
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
    <?php echo Yii::t('tourguide',"We've partnered with organizations to bring you the best jobs in your profession");?>. 
    </div>
    <div class="advn_otherfeaturecontentText">
   <?php echo Yii::t('tourguide',"Jobs that are highlighted are being brought to you by one of our reputable partnership organizations");?>.
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


<!-- career end -->


