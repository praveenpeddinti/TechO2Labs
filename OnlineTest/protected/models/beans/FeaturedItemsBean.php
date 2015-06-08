<?php

class FeaturedItemsBean extends NewsCollection {
    public $SessionUserId;
    public $PostOn;
    public $FirstUserDisplayName;
    public $FirstUserId;
    public $FirstUserProfilePic;
    public $SecondUserData;
    public $PostBy;
    public $Type;
    public $PostTypeString;
    public $OriginalUserDisplayName;
    public $OriginalPostPostedOn;
    public $OriginalUserProfilePic;
    public $IsFollowingPost;
    public $OriginalUserId;
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
    public $IsMultiPleResources;
    public $StartDate;
    public $EndDate;
    public $OptionOne;
    public $OptionTwo;
    public $OptionThree;
    public $OptionFour;
    public $StartTime;
    public $EndTime;
    public $Location;
    public $Extension;
    public $Title;
    
     public $CanSaveItForLater;//only  users with this option can saveit for later
   


    /**
     * @author suresh following entity attributes
     */
    public $IsFollowingEntity=0;
}

