<?php 
 if(is_object($stream))
      { 
     $style="display:block";
    foreach($stream as $key=>$data){
        $stream=(array)$stream;
       
        $singleStream=array();
        $singleStream[0]=$stream[$key];
        $singleStream = (object)$singleStream;
  
        $this->renderPartial('/curbsidePost/curbside_view', array('stream' => $singleStream, 'streamIdArray'=>$streamIdArray,'totalStreamIdArray'=>$totalStreamIdArray));
    
  
      }
      }
      else{
          echo $stream;
      }
?>