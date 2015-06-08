<?php
class SubGroupBean {
    public $GroupId;
    public $SubGroupId;
    public $ParentGroupId;
    public $SubGroupName;
    public $SubGroupMembers=array();
    public $SubGroupMembersProfilePictures=array();
    public $SubGroupMembersCount=0;
    public $SubGroupIcon;
    public $SubGroupBannerImage;
    public $SubGroupDescription;
    public $SubGroupShortDescription;
    public $SubGroupResource;
    public $SubGroupGames;
    public $SubGroupImagesAndVideos=array();
    public $SubGroupArtifacts=array();
    public $SubGroupImagesAndVideosCount=0;
    public $SubGroupArtifactsCount=0;
    public $IsSubGroupAdmin=0;
    public $SubGroupPostsCount=0;
    public $IsFollowing=0;
    public $IsGroupPrivate;
    public $GroupName;
    public $DisableWebPreview=0;
    public $GroupUniqueName = "";
    public $SubGroupUniqueName = "";
    public $DisableStreamConversation=0;
    public $Status;
}

