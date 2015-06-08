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

<?php
$qNum = "";
if(!empty($questionText)){
    //$QuestionIdValue = explode("_", $QuestionId);
    $QuestionTextValue = explode("_", $questionText);    
    $cnt=count($QuestionTextValue)-1;
    $question = $question;
}else{  
    $cnt=1;
    $QNumber = $ii;
    if($QNumber>0)
    $qNum = $QNumber.") ";
}

for($k=0;$k<$cnt;$k++){

    if(!empty($questionText)){
        $QNumber = $k+1;        
        $question = $QuestionTextValue[$k];
        
        if($QNumber > 2){ $qNum = ($QNumber-2).") ";}
    }
?>

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
      <?php echo $qNum.$question; ?>
    </h4>
<div>
    <img src="<?php echo $this->findUploadedPath(); ?>/images/<?php echo $this->tinyObject->UserId."_".$QNumber;?>_analyticsPDF.png" title="pie logo" width="800"/>


</div>
    <page_footer> 
        
      <div class="pdf_footer">
          <?php echo $configParams['COPYRIGHTS']; ?>
	</div>
    </page_footer> 
</page>

    <?php
    }

?>


