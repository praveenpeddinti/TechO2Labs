<?php

/* 
 * NormalPostForm class.
 * NormalPostForm is the data structure for saving the stream
 * It is used by the 'index' action of 'CurbsidePostController'.
 * @author Haribabu
 */
class CurbsidePostForm extends CFormModel
{
    public $UserId;
    public $Description;
    public $Artifacts;
    public $HashTags;
    public $Mentions;
    public $Subject;
    public $Category;
    public $Type;

    public $WebUrls;
    public $IsFeatured=0;
    public $IsBlockedWordExist=0;
    public $IsWebSnippetExist=0;
    public $CreatedOn;
    public $CategoryId;
    public $MigratedPostId='';
    //$postedBy is added by Sagar for PostAsNetwork
    public $PostedBy=0;
    public $FeaturedTitle;
    public $NetworkId=1;
    public $SegmentId=0;
    public $Language='en';


    public function rules() {
        return array(

             array('Description,Artifacts,HashTags,Mentions,Category,Subject,Type,NetworkId,IsBlockedWordExist,IsFeatured,IsWebSnippetExist,WebUrls,$MigratedPostId,PostedBy,FeaturedTitle', 'safe'),

            array('Description,Subject,Category', 'required'),
            );
    }
    
}