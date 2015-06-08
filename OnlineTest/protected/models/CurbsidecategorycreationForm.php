<?php

/* 
 * CurbsideCategoryCreation class.
 * CurbsideCategoryCreation is the data structure for creating a category
 * It is used by the 'forgot' action of 'AdminController'.
 */
class CurbsidecategorycreationForm extends CFormModel
{
    public $category;
    public $id;
    public $TopicprofileImage;
    public $SegmentId;


    public function rules() {
        return array(
            // category required
            array('category', 'required'),
            array('id,category,TopicprofileImage, SegmentId', 'safe'),
            array('category', 'CRegularExpressionValidator', 'pattern'=>'/^([0-9a-zA-Z  ]+)$/'),
            );
    }
    
}