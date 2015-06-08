<?php

class UserStreamBean {

    public $StreamUserId;
    
    public $PostId;
    public $GroupId;
    public $UserId;
    public $CreatedOn;

    public $StreamNote="";
    public $StreamNote1;
    public $HashTagPostUserId;
    
        //1- comment , 2-followers, 3-mentions
    public $RecentActivity;
    
    public $ActionType;
    public $CategoryType;
    public $FollowEntity;
    public $PostType;
    public $NetworkId;
    
    public $CommentUserId;
    public $Comments=array();
    public $FollowUserId;
    public $MentionUserId="";
    public $HashTagsFollowers;
    public $UserFollowers;
    public $LoveUserId=0;
    
    public $PostText;
    public $Resource;
    public $IsMultiPleResources;
    public $OriginalUserId;
    public $OriginalPostTime;
    public $PostTextLength;
    
    public $LoveCount;
    public $CommentCount;
    public $FollowCount;
    public $ShareCount;
    public $InviteCount;
    
    public $MentionArray;
    public $HashTags;
    
    
    //event post
    public $StartDate;
    public $EndDate;
    public $Location;
    public $EventAttendes = array();
    public $PostFollowers=array();
    public $InviteUsers=array();
    public $InviteMessage;
    
    public $OptionOne;
    public $OptionTwo;
    public $OptionThree;
    public $OptionFour;
    
    public $OptionOneCount;
    public $OptionTwoCount;
    public $OptionThreeCount;
    public $OptionFourCount;
    public $ExpiryDate;
    public $SurveyTaken=array();
    public $StartTime;
    public $EndTime;
    public $CurbsideConsultTitle;
    public $CurbsideConsultCategory;
    public $Priority=0;
    public $HashTagName;
    public $HashTagPostCount;
    public $HashTagFollowers;
    
    public $CurbsideCategoryFollowers=array();
    public $CurbsidePostCount=0;
    public $HashTagId;
    public $DisableComments=0;
    public $CurbsideCategoryId;
    public $GroupFollowers=array();
    public $IsBlockedWordExist=0;
    public $IsFeatured=0;
    public $FeaturedUserId;
    public $FeaturedOn;
    public $IsBlockedWordExistInComment=0;
    public $IsWebSnippetExist = 0;
    public $WebUrls;
    /* this is RiteAid Specific */
    public $Division=0;
    public $District=0;
    public $Region=0;
    public $Store=0;
    public $Title;
    public $SubGroupId;
    public $SubGroupFollowers=array();
    public $ShowPostInMainStream=1;
    /**
     * for news stream bean
     */
    public $HtmlFragment;
    public $PublisherSource = '';
    public $PublisherSourceUrl = '';
    public $Editorial = '';
    public $Released = 0;
    public $TopicId = 0;
    public $TopicName = '';
    public $Alignment = '';
    public $PublicationTime;
   public $PublicationDate = '';
   public $TopicImage = '';
    public $IsPrivate;

   public $FollowOn = '';
   public $LoveOn = '';
    public $PlayedUsers=array();
   public $ResumeUsers=array();
   public $PlayersCount=array();
   public $GameName;
   public $GameDescription;
   public $GameFollowers;
   public $GameBannerImage;
   public $QuestionsCount;
   public $GameScheduleId;
   public $CurrentGameScheduleId=0;
   public $PreviousGameScheduleId=0;
   public $CurrentScheduledPlayers=array();
   public $CurrentScheduleResumePlayers=array();
   public $PreviousSchedulePlayers=array();
   public $PreviousScheduleResumePlayers=array();
   public $IsNotifiable=1;
   
   //For badging
   
   public $BadgeHoverText;
   public $BadgeDescription;
   public $BadgeName;
   public $BadgeLevelValue;
   public $BadgeHasLevel;
   public $NetworkAdminUserId="";
   public $Language="en";
   public $SegmentId=0;
   
   //For Advertisement
   
   public $RedirectUrl;
   public $DisplayPage;
   public $Groups;
   public $RequestedFields;
   public $AdType;
   public $AdvertisementId;
   public $RequestedParams;
   public $BannerTemplate;
   public $BannerContent;
   public $BannerTitle;
   public $ImpressionTag;
   public $ClickTag;
   public $BannerOptions;
   public $StreamBundle;
   public $Banners;
   public $Uploads;
   
   public $GroupSpecialities=array();
     public $IsAnonymous=0;
  public $IsUseForDigest=0;
  public $QueueType="activities";
  public $NetworkLogo;
  public $Miscellaneous = 0;
  public $IsPremiumAd = 0;
  public $PTimeInterval;
}

?>
