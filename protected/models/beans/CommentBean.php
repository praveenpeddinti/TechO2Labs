<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class CommentBean{
    public $CommentId;
    public $CommentText;
    public $UserId;
    public $CreatedOn;
    public $PostType;
    public $Artifacts;
    public $PostId;
    public $Type; 
    public $NoOfArtifacts;
    public $HashTags=array();
    public $Mentions=array(); 
    public $CommentTextLength;
    public $CategoryType;
    public $IsBlockedWordExist=0;
    public $WebUrls;
    public $IsWebSnippetExist=0;
    public $NetworkId;
       public $CommentMoreUsersCount;
    public $CommentActivitiesCount;
       public $CommentMoreText;
           public $Comments;
}
