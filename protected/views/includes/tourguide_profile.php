<?php //

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
    <div class="advancedtourguidetablecol1"><div class="advancedtourguideTitle"><?php echo Yii::t('tourguide',"Complete your profile");?></div></div>
<!--    <div class="advancedtourguidetablecol2"  ><div class="advn_maxwidthheight"><img  class="advn_maxwidthauto" src="/pictocv/<?php //echo Yii::app()->session['UserStaticData']->UserId."_".$data['OpportunityType'].".png"?>"/></div></div>-->
    </div>
       </div>
    </div>
    </div>
    <div class="advn_body">
    <div class="row-fluid">
    <div class="span12">
    <div class="span5"><img  class="advn_maxwidthauto" src="/images/system/tourguide/advn_profile_businesscard_img.png" /></div>
    <div class="span7">
    <ul class="advn_ultourguide">
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyleone">1</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Add Your Profile Picture");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"Put a face to your name so existing colleagues will know it's you, and new colleagues can get to you know better");?>.
    </div>
    
    </div>
    </li>
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstyletwo">2</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Provide Your Professional Credentials, NPI/State License Number");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"We're asking for your licensing information so you’re able to participate in future opportunities, like surveys and advisory board sessions.  This information will not be visible to other members viewing your profile");?>.
    </div>
    
    </div>
    </li>
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstylethree">3</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Identify Your Practice Information");?> 
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"Tell members more about your profession and practice.  Add your specialty, title and practice name");?>.
    </div>
    
    </div>
    </li>
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstylefour">4</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Share Your Location – City, State");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"Your location will allow us to bring you customized information based on where you live");?>.
    </div>
    
    </div>
    </li>
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstylefive">5</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Give Members a Brief Bio About Yourself");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"What’s your best elevator pitch?");?> 
    </div>
    
    </div>
    </li>
    <li>
    <div class="advn_content">
    <span class="numberstyle numberstylesix">6</span>
    <div class="advn_contentTitle">
        <?php echo Yii::t('tourguide',"Share Your Interests");?>
    </div>
    <div class="advn_contentText">
        <?php echo Yii::t('tourguide',"List some of your academic, personal or research interests and we’ll customize your experience based on them");?>. 
    </div>
    
    </div>
    </li>
    </ul>

     <?php if ($data['FocusDivId'] != '') { ?> <div class="advn_buttonarea" onclick="focusDiv('<?php echo $data['FocusDivId'] ?>','<?php echo $data['DivId'] ?>','<?php echo $i; ?>','right','click');"><a class="advancedtourguidebutton"  style="cursor: pointer"><?php echo Yii::t('tourguide',"Try It Now");?></a></div> <?php } ?>


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
         <?php echo Yii::t('tourguide',"Your Followers, Who's Following You");?>
    </div>
    <div class="advn_otherfeaturecontentText">
        <?php echo Yii::t('tourguide',"Check out which members are interested in what you have to say, and click through to view their profile");?>.  
    </div>
    </li>
<!--    <li >
     <div class="advn_otherfeaturelistTitle">
         <?php echo Yii::t('tourguide',"Discover Your CV Area");?>
    </div>
    <div class="advn_otherfeaturecontentText">
        <?php echo Yii::t('tourguide',"Add your education, experience, publications and achievements in an easy-to-use format");?>.  
    </div>
    </li>-->
<!--    <li >
     <div class="advn_otherfeaturelistTitle">
         <?php echo Yii::t('tourguide',"Recent Interactions");?>
    </div>
    <div class="advn_otherfeaturecontentText">
        <?php echo Yii::t('tourguide',"This keeps a summary of your community involvement, so you can go back here to re-read important news, or contribute to ongoing conversations at any time. Other members can also see what you’re doing within the community and learn more about you’re most interested in");?> 
    </div>
    </li>-->
    </ul>
    </div>
    </div>
       
    </div>

</div>
		</div>
	</div>
</div>
</div>


<!-- profile end -->