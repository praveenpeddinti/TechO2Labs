<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
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
    <div class="advancedtourguidetablecol1"><div class="advancedtourguideTitle"><?php echo Yii::t('tourguide',"Search Opportunities");?></div></div>
<!--    <div class="advancedtourguidetablecol2"><div class="advn_maxwidthheight"><img  class="advn_maxwidthauto" src="/pictocv/<?php //echo Yii::app()->session['UserStaticData']->UserId."_".$data['OpportunityType'].".png"?>"/></div></div>-->
    </div>
       </div>
    </div>
    </div>
    <div class="advn_body">
    <div class="row-fluid">
    <div class="span12">
    <div class="span6 advn_footerlinkstextcener"><img  class="advn_maxwidthauto" src="/images/system/tourguide/advn_searchbar_img.png" /></div>
    <div class="span6">
    <ul class="advn_ultourguide">
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyleone">1</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Search Anything");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"Our search is quick, easy and comprehensive. Search topics of interest, specific drugs, best practices or individual members. Search results are neatly organized by community feature and category");?>. 
    </div>
    
    </div>
    </li>
   
    </ul>
    </div>
    </div>
    </div>
    <div class="row-fluid">
    <div class="span12">
   
    <div class="span6">
    <div class=" advn_search_paddingleft advn_search_paddingtop10">
    <ul class="advn_ultourguide ">
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyletwo">2</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Explore Various Resources");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"If you're searching for a particular member, you can view a brief summary of their activity and click to view their full profile. Results with Curbside Consult posts and Group categoriesprovide an idea of how many conversations are occurring and offer the opportunity to contribute");?>.
    </div>
    
    </div>
    </li>
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstylethree">3</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Discover More");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"If your search results include posts, Curbside Consults, Games or News objects, you're able to segment out each type and view all corresponding items");?>.
    </div>
    
    </div>
    </li>
    
    </ul>
      <?php if ($data['FocusDivId'] != '') { ?> <div class="advn_buttonarea" onclick="focusDiv('<?php echo $data['FocusDivId'] ?>','<?php echo $data['DivId'] ?>','<?php echo $i; ?>','bottom','click');"><a style="cursor: pointer" class="advancedtourguidebutton" ><?php echo Yii::t('tourguide',"Try It Now");?></a></div> <?php } ?>
    </div>
    </div>
     <div class="span6 advn_footerlinkstextcener"><img  class="advn_maxwidthauto" src="/images/system/tourguide/advn_searchresults_img.gif" /></div>
    </div>
    </div>
    </div>
    

</div>
		</div>
	</div>
</div>
</div>


<!-- followfeature end -->

