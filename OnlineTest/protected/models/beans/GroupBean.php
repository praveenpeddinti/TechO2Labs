<?php

class GroupBean {
    public $GroupId;
    public $GroupName;
    public $GroupMembers=array();
    public $GroupMembersProfilePictures=array();
    public $GroupMembersCount=0;
    public $GroupIcon;
    public $GroupBannerImage;
    public $GroupDescription;
    public $GroupShortDescription;
    public $GroupResource;
    public $GroupGames;
    public $GroupImagesAndVideos=array();
    public $GroupArtifacts=array();
    public $GroupImagesAndVideosCount=0;
    public $GroupArtifactsCount=0;
    public $IsGroupAdmin=0;
    public $GroupPostsCount=0;
    public $IsFollowing=0;
    public $SubgroupsCount=0;
    public $SubGroupLogo=array();
    public $IsPrivate=0;

    public $DisableWebPreview=0;
    public $GroupUniqueName = "";
    public $DisableStreamConversation=0;
    public $AutoFollow=0;
    public $Speciality;
    public $UserId;
    public $Status;
    public $RestrictedAccess = 0;
    public $IsAccessGroup=0;

    
    
}
