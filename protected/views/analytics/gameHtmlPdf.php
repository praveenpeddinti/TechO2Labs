<!--<style type="text/css">
h1{
    color:#718E2D;
    text-align: center;
}
table{
    margin: auto;
    border: 1px solid gray;
}
table td,table th{
    border: 1px solid gray;
    border-collapse: collapse;
    padding: 5px;
}
</style>-->

<link href="<?php echo $configParams['ServerURL']; ?>/css/<?php echo $configParams['ThemeName']; ?>" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $configParams['ServerURL']; ?>/css/pdf.css" rel="stylesheet" type="text/css" media="screen" />

<page>
    <page_header> 
        <div class="pdf_header">
                     
           <table style="width:96%;border:0px solid #017bc4;border-spacing: 0;" cellpadding="0" cellspacing="0">
               <tr>
                   <td style="width:50%;border:0px solid #017bc4"> <img src="<?php echo $configParams['ServerURL']; ?>/images/system/logo.png" alt="logo" class="logo">   </td>
                   <td class="headerrighttext" style="border:0px solid #017bc4">
      <?php echo $analyticType; ?> 
    </td>
               </tr>
           </table>
            
        </div>
    </page_header>
      <br><br><br><br><br><br>
    <h4  class="pdftitle">
      <?php echo $analyticType; ?> Report : <span><?php echo $date; ?></span>
    </h4>
<div>
    <div style="margin-left: 35px;padding-bottom: 5px"><?php echo $gameName; ?></div>
      <table class="table table-hover">
          <thead ><tr style="background-color: #ccc"><th >Game Name</th><th class="data_t_hide">Schedules</th><th>Players</th><th>Completed Players</th><th>Paused Players</th><th class="data_t_hide">Average Time</th><th>Avg Points/<br/>Total Points</th></tr></thead>
                    <tbody>
                        <?php if(count($gamesAnalyticsData)==0){?>
                        <tr id="noRecordsTR" >
                            <td colspan="8">
                                <span class="text-error"> <b>No records found</b></span>
                            </td>
                        </tr>
                        <?php }else{
                            $c=1;
                     foreach ($gamesAnalyticsData as $value) {
                            $scheduleGame = $value[0];
                            $gameBean = $value[1];
                        ?>   
                        <tr class="<?php if($c%2==0) echo "even";else echo "odd";?>">
                            <td>
                           <?php echo $scheduleGame->GameName;?>
                            </td>  
                            <td>
                                <?php echo date(Yii::app()->params['PHPDateFormat'],CommonUtility::convert_date_zone($scheduleGame->StartDate->sec,Yii::app()->session['timezone'],  date_default_timezone_get()));?> to<br/>  <?php echo date(Yii::app()->params['PHPDateFormat'],CommonUtility::convert_date_zone($scheduleGame->EndDate->sec,Yii::app()->session['timezone'],  date_default_timezone_get()));?>
                            </td>
                            <td class="aligncenter">
                             <?php echo count($scheduleGame->Players)+count($scheduleGame->ResumePlayers);?>
                            </td>
                            <td class="aligncenter">
                             <?php echo count($scheduleGame->Players);?>
                            </td>
                            <td class="aligncenter"> 
                                                
                               
                                
                                  <?php echo count($scheduleGame->ResumePlayers);?>

                               
                        
                            </td>
                           
                            <td class="aligncenter">                          
                                <?php echo $gameBean->averageTime;?>
                            </td>
                    <td >     
                          <?php echo number_format($gameBean->avgPoints);?>/<?php echo number_format($gameBean->gameTotalPoints);?>
                    </td>
                </tr>
                        <?php $c++;}}?>
            </tbody>
        </table>
  


</div>
    <page_footer> 
        
      <div class="pdf_footer">
          <?php echo $configParams['COPYRIGHTS']; ?>
	</div>
    </page_footer> 
</page>   
