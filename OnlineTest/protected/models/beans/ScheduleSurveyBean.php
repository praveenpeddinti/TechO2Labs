<?php

class ScheduleSurveyBean{
    public $_id;
    public $UserId;
    public $QuestionId;
    public $SurveyTitle;
    public $SurveyDescription;    
    public $WidgetType;
    public $CreatedBy;
    public $QuestionsCount;
    public $CurrentScheduleId;
    public $Status;
    public $Question;
    public $Options = array();
    public $QuestionPosition;
    public $QuestionImage;
    public $QuestionType = 0;
    public $Resources = array();
    public $NoofOptions;
    public $NoofRatings;
    public $LabelName = array();
    public $OptionName = array();
    public $Other;
    public $OtherValue;
    public $TotalValue=0;
    public $NoofChars;
    public $MatrixType;
    public $SureyLogo; 
    public $SurveyRelatedGroupName;
    public $SurveyTakenCount;
    public $IsDeleted;
    public $IsCurrentSchedule;
    public $SchedulesArray=array();
    public $NetworkId;
    public $SurveyedUsersCount = 0;
    public $MaxSpots=0;
    public $CategoryCounts = array();
    public $SuspendedCount = 0;
            
}
