<?php

/*
 * ForgotForm class.
 * ForgotForm is the data structure for requesting a new password
 * It is used by the 'forgot' action of 'UserController'.
 */

class GameCreationForm extends CFormModel {
    
    public $GameBannerImage;
    public $GameName;
    public $GameDescription;
    public $Qusetion;
    public $QusetionDisclaimer;
    public $OptionA;
    public $OptionADisclaimer;
    public $OptionB;
    public $OptionBDisclaimer;
    public $OptionC;
    public $OptionCDisclaimer;
    public $OptionD;
    public $OptionDDisclaimer;
    public $QuestionImage;
    public $CreatedOn;
    public $Questions;
    public $QuestionArtifacts;
    public $GameId;
    public $Iscreated;
    public $CreatedBy=0;
    public $MigratedGameId;
    public $IsSponsors;
    public $BrandName;
    public $BrandLogo;
    public $IsEnableSocialActions;
    public $OtherValue;
    public function rules() {
        return array(            
            array('OtherValue,IsEnableSocialActions,BrandLogo,BrandName,IsSponsors,Questions,GameBannerImage,GameName,GameDescription,Qusetion,QusetionDisclaimer,OptionA,OptionADisclaimer,OptionB,OptionBDisclaimer,OptionC,OptionCDisclaimer,OptionD,OptionDDisclaimer,QuestionImage,CreatedOn,QuestionArtifacts,GameId,Iscreated,CreatedBy,MigratedGameId', 'safe'),
        );
    }
    
}
