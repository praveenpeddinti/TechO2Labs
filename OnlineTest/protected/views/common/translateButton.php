<?php 
    if(isset($userLanguage) && $translate_fromLanguage!="" && $userLanguage!="" && $translate_fromLanguage!=$userLanguage){
        $translate_location = isset($translate_location)?$translate_location:"";
        $translate_fromLanguage = isset($translate_fromLanguage) && !empty($translate_fromLanguage)?$translate_fromLanguage:'en';
    ?>
    <div class="translationbuttondiarea">
        <input type="button" value="Translate to <?php echo $userLanguage;?>" class="<?php echo $translate_class ?>" data-id="<?php  echo $translate_id ?>" data-postid="<?php  echo $translate_postId ?>" data-postType="<?php  echo $translate_postType;?>" data-categoryType="<?php  echo $translate_categoryType;?>" data-fromLanguage="<?php  echo $translate_fromLanguage;?>" data-toLanguage="<?php echo $userLanguage;?>" data-location="<?php echo $translate_location; ?>" />
    </div>
<?php } ?>
<?php //this is for game play
    if(isset($isTop) && $isTop){
        $isTop = false; 
        if(isset($translateNeed["userLanguage"]) && $translateNeed["userLanguage"]!="" && $translateNeed['gameLanguage']!="" && $translateNeed["userLanguage"]!=$translateNeed['gameLanguage']){?>
            <div id="gameQuestions" class="translationbuttondiarea">
                <input type="button" value="Translate to <?php echo $translateNeed["userLanguage"];?>" class="translatebutton" />
            </div>
<?php }} ?>
<?php //include Yii::app()->basePath . '/views/common/translateButton.php'; ?>