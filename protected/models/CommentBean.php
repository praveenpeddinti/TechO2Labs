<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class CommentBean{
    public $CommentId;
    public $CommentText;
    public $CommentFullText;
    public $UserId;
    public $CreatedOn;
    public $PostType;
    public $Artifacts;
    public $PostId;
    public $NoOfArtifacts;
    public $Type; 
    public $Comments=array();
    public $CommentMoreUsersCount;
    public $CommentActivitiesCount;
    public $CommentMoreText;
    public $AbusedUserId;
    public $IsAbused=0;
    public $SegmentId;
    public $NetworkId;
    public $Language="en";

}
