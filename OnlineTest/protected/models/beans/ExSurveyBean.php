<?php

class ExSurveyBean{
    public $QuestionId;
    public $Question;
    public $Options = array();
    public $QuestionPosition;
    public $QuestionImage;
    public $QuestionType = 0;
    public $Resources = array();
    public $NoofOptions=0;
    public $NoofRatings=0;
    public $LabelName = array();
    public $OptionName = array();
    public $Other=0;
    public $OtherValue="";
    public $TotalValue=0;
    public $NoofChars = 0;
    public $MatrixType=0;
    public $TextOptions=0;
    public $TextMaxlength=1;
    public $IsMadatory=0;
    public $IsAnalyticsShown = 1;
    public $AnyOther = 0;
    public $Justification = array();
    public $JustificationPlaceholders = array();
    public $LabelDescription = array();
    public $SelectionType = 0;
    public $IsAcceptUserInfo=0;  
    public $JustificationAppliedToAll = 0;
    public $DisplayType = "";
    public $StylingOption = 1;
            
}
