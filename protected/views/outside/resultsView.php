
    <div >
            <div class="ext_surveybox NPF lineheightsurvey">
                <center class="ndm" id="errorTitle" > 
                    
                <?php if($type=="spots"){
                   echo Yii::t("translation","MarketSurvey_NoMoreSpots");
                }else{?>
                    No Results Found
                <?php }?>
                </center>
            </div>
        </div>
<script type="text/javascript">
    $("#surveysubmitbuttons").hide();
</script>	