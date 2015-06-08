<div class="rightwidget  paddingt12 ">

    <div class="rightwidgettitle ">
        <i class="spriteicon"><img src="/images/system/spacer.png" class="r_featurednews"></i><span class="widgettitle"><?php echo Yii::t('translation','Featured_Items'); ?></span><i data-id="FeaturedItems_DivId" class="fa fa-question helpmanagement helpicon helprelative pull-right marginTR6 tooltiplink" data-placement="bottom" rel="tooltip"  data-original-title="Featured Items" ></i> 
    </div>
    <div class="border3">
        <?php if (isset($featuredItems) && $featuredItems != 'failure') { ?>
            <div class="featurednewsOtherview">
                <ul class="featuredlinks"> 
                    <?php foreach ($featuredItems as $featured) { ?>

                        <li class="featuredlinksli">
                            <div id="F_D_<?php echo $featured['PostId'] ?>" class="featuredsection">
                                <div data-postType="<?php echo $featured['PostType'] ?>"  data-categoryType="<?php echo $featured['CategoryType'] ?>" data-postid="<?php echo $featured['PostId'] ?>" data-id="<?php echo $featured['PostId'] ?>" class="postdetail stream_msg_box">
                                    <div style="position: relative" class="stream_title paddingt5lr10">

                                        <a  style="cursor:pointer"  class="userprofilename ">
                                            <b><?php echo $featured['FirstUserDisplayName'] ?></b>
                                        </a>

                                    </div>

                                    <div class=" stream_content positionrelative">
                                        <span id="followUnfollowSpinLoader_542bc45ecec9fe1d2f8b4658"></span>
                                        <ul>
                                            <li class="media">

                                                <?php if ($featured['Type'] >= 0) { ?>
                                                    <div class="pull-left <?php echo $featured['Type'] > 1 ? 'multiple' : 'img_single' ?>" style="<?php echo $featured['Type'] > 1 ? 'margin-right:15px' : '' ?>">

                                                        <?php if ($featured['Type'] > 1) { ?>
                                                            <div class="img_more1"></div>
                                                            <div class="img_more2"></div>
                                                        <?php } ?>
                                                                                                                        
                                                        <a   style="margin-right:0" class="  <?php if ($featured['Type'] > 1) { ?> pull-left img_more <?php } ?>">
                                                            <img src="<?php echo $featured['ArtifactIcon'] ?>"></a>
                                                    </div><?php } ?>


                                                <div id="media_main_<?php echo $featured['PostId'] ?>" class="media-body">


                                                    <div style="display:block">

                                                        <div id="post_content_<?php echo $featured['PostId'] ?>" data-categorytype="<?php echo $featured['CategoryType'] ?>" data-id="<?php echo $featured['PostId'] ?>" data-postid="<?php echo $featured['PostId'] ?>" class="bulletsShow">

                                                            <?php echo strip_tags($featured['PostText']) > 100 ? strip_tags(substr($featured['PostText'], 0, 90)) : strip_tags($featured['PostText']); ?>
                                                            <a>
                                                                <span data-posttype="<?php echo $featured['Type'] ?>"  data-categorytype="<?php echo $featured['CategoryType'] ?>" data-postid="<?php echo $featured['PostId'] ?>"  data-id="<?php echo $featured['PostId'] ?>" class="  tooltiplink"><?php if (strlen(strip_tags($featured['PostText'])) > 100) { ?> <i class="fa  moreicon moreiconcolor"><?php echo Yii::t('translation','Readmore')?></i><?php } ?></span></a> </div>

                                                    </div>
                                                </div>
                                                                         
                                                <div class="social_bar social_bar_detailed" >	
                                                            <a class="follow_a"><i><img src="/images/system/spacer.png" data-placement="bottom" rel="tooltip"  ></i><b ><?php echo $featured['FollowCount'] ?></b></a>
                                                            <?php if ($featured['CategoryType'] != 10) { ?>
                                                                <a ><i><img  src="/images/system/spacer.png"   data-placement="bottom"  class="tooltiplink cursor invite_frds"  ></i></a>
                                                            <?php } ?>
                                                            <span class="cursor"><i><img  class=" likes" data-placement="bottom"   src="/images/system/spacer.png"  ></i><b><?php echo $featured['LoveCount'] ?></b></span>
                                                            <span class="sharesection"><i class="tooltiplink" data-toggle="bottom"  data-placement="bottom"><img src="/images/system/spacer.png"  class="sharedisable"  ></i><b ><?php echo $featured['ShareCount'] ?></b></span>
                                                            <span><i><img src="/images/system/spacer.png" data-placement="bottom"  class="detailedComment tooltiplink cursor  commented"  ></i><b ><?php echo $featured['CommentCount'] ?> </b></span>
                                                </div> 
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                            </div>
                            <div id="F_D_L_<?php echo $featured['PostId'] ?>" >
                            <div  data-postType="<?php echo $featured['PostType'] ?>"  data-categoryType="<?php echo $featured['CategoryType'] ?>" data-postid="<?php echo $featured['PostId'] ?>" data-id="<?php echo $featured['PostId'] ?>" class="postdetail">
                            <a href="#" class="featuredanchor " >
                                <?php echo strip_tags($featured['FirstUserDisplayName']); ?>
                            </a></div></div></li>


                 <script type="text/javascript">
    featuredItemDetailPage('F_D_<?php echo $featured['PostId'] ?>');
    featuredItemDetailPage('F_D_L_<?php echo $featured['PostId'] ?>');
    
    </script>           
                            


                       <?php
                    } ?>
                </ul>
            </div>   
        <?php } ?>

        <div id="featureitemspinner" style="position: relative;"></div>
        <div id="FeaturedItemsGallery">

        </div>
    </div> 
</div>


