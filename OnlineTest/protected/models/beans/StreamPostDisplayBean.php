<?php

class StreamPostDisplayBean extends UserStreamCollection {
    public $SessionUserId;
    public $PostOn;
    public $FirstUserDisplayName;
    public $FirstUserId;
    public $FirstUserProfilePic;
    public $SecondUserData;
    public $PostBy;
    public $PostTypeString;
    public $OriginalUserDisplayName;
    public $OriginalPostPostedOn;
    public $OriginalUserProfilePic;
    public $IsFollowingPost;
    public $IsLoved;
    //****For Actifacts
    public $ArtifactIcon;
    //****For Survey Post
    public $IsSurveyTaken;
    public $TotalSurveyCount;
    //****For Event Post
    public $EventStartDay;
    public $EventStartDayString;
    public $EventStartMonth;
    public $EventStartYear;
    public $EventEndDay;
    public $EventEndDayString;
    public $EventEndMonth;
    public $EventEndYear;
    public $IsEventAttend;
    public $IsAdmin;
    public $CanPromotePost;//only promoted users can promote a post
    public $CanDeletePost;//admin as well as owner of the post can delete a post
    public $CanSaveItForLater;//only  users with this option can saveit for later
    public $GroupName;
    public $GroupDescription;
    public $GroupFollowersCount;
    public $GroupImage;
    public $CanFeaturePost=0;
    public $CanMarkAsAbuse=0;
    public $DisableComments=0;
    public $canManageFlaggedPost=0;
    public $CanFeaturedPost=0;
    public $PromotedDate;
    public $IsFeatured=0;
    public $PostCompleteText;
    /**
     * @author suresh following entity attributes
     */
    public $IsFollowingEntity=0;
    
    /**
     * @added karteek V
     */
    public $IsOptionDExist=-1;
    /**
     * @added Sagar
     */
    public $FbShare = 0;
    public $TwitterShare = 0;
    public $SubGroupName;
    public $SubGroupDescription;
    public $SubGroupFollowersCount;
    public $SubGroupImage;
    public $Type;
    public $IsIFrameMode=0;



    /**
     * @added Praneeth
     */
    public $isGroupAdminPost;
    public $MainGroupId;
    public $IsCommented=0;
    
    public $isDerivative=0;
    public $IsPrivate;
    public $GameName;
    public $GameDescription;     
    public $GameAdminUser;
    public $QuestionsCount;
    public $IsCurrentSchedule=0;
    public $PlayersCount;
    public $Players=array();
    public $GameBannerImage;
    public $GameFollowers;
    public $Love;
    public $GameStatus;
    public $SchedulesArray=array();
    public $PreviousGameStatus=0;
    public $CanCopyURL=0;
    public $IsHomeStream=0;

    
      public $IsVideo=0;

    public $NetworkAdminUserId="";
    public $IsNativeGroup=0;
    public $Width;
    public $Height;
    public $AddSocialActions=1;
    public $ConversationVisibility;
    public $DisableWebPreview=0;
    public $DisableStreamConversation=0;
    public $IsMultipleArtifact;
    public $GroupUniqueName = "";
    public $SubGroupUniqueName = "";
    public $loveUsersArray;
    public $followUsersArray;
    public $SpotsCount = 0;
    public $SpotsMessage = "";
    public $RestrictedAccessGroup = 0;
    public $CanScheduleGame=1;
    public $IsUseForDigest=0;
    public $Digest_Use=0;
    public $IsPremiumAd = 0;
    public $PTimeInterval;
}

?>
