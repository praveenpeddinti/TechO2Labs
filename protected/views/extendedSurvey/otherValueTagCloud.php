   <?php
     try{
  $topictag = array();
   
    if (count($data) > 0) {
//        foreach ($data as $key => $topic) {
//            error_log("----".$topic['AbuseWord']."---".$topic['Weightage']);
//            $topicinarray = array();
//            $topicinarray['weight'] = $topic['Weightage'];
//            $topicinarray['id'] = 2;
//            $topicinarray['userid'] = 1;
//            $topictag[$topic['AbuseWord']] = $topicinarray;
//        }
        
           foreach ($data as $key => $topic) {
            $topicinarray = array();
            $topicinarray['weight'] = $topic;
            $topicinarray['url'] = "";
            $topicinarray['id'] = 2;
            $topicinarray['userid'] = 1;
            $topictag[$key] = $topicinarray;
        }
         $this->widget('application.extensions.YiiTagCloud.YiiTagCloud', array(
        'beginColor' => '00089A',
        'endColor' => 'A3AEFF',
        'minFontSize' => 10,
        'maxFontSize' => 20,
        //'htmlOptions' => array('style' => 'width: 700px;color:#177D9E; margin-left: auto; margin-right: auto;'),
        'arrTags' => $topictag,
            )
    ); 
    }else{
        echo "<center>". Yii::t('translation', 'Ex_NoData_Title')."</center>";
    }
   
     } catch (Exception $ex) {
         error_log("exceiotn-***----------------".$ex->getMessage());
     }
  
    ?>