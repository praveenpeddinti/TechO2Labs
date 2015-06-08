<?php

class ProfileIntractionDisplayBean extends UserActivityCollection {
    public $SessionUserId;
    public $UserDisplayName;
    public $UserProfilePic;
    public $PostOn;
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
    public $GroupName;
    public $GroupDescription;
    public $FollowersCount;
    public $GroupImage;
    public $CanFeaturePost;
    public $CanMarkAsAbuse;
    public $DisableComments=0;
    public $CommentMessage=0;
    public $IsBlockedWordExist=0;//0 - Default/Release, 1 - Abused, 2 - Blocked
    public $Extension;
    public $MainGroupId;
    public $MainGroupName;
    public $isGroupAdminMember;
    public $IsCommented=0;
    public $ShowPrivateGroupPost;
    public $GroupBannerImage;
    public $GroupProfileImage;
    public $IsIFrameMode=0;
    public $IsGroupPostVisible=0;  
    
    public $ConversationVisibility;
    public $AddSocialActions=1;
    public $loveUsersArray;
    public $followUsersArray;
     public $CanSaveItForLater;//only  users with this option can saveit for later
}

?>
