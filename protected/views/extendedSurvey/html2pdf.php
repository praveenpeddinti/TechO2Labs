<?php
    ob_start();
    
    echo $this->renderPartial('htmlpage',array('date'=>$date,"name"=>$name,'configParams'=>$configParams,"question"=>$question,"questionText"=>$questionText,"ii"=>$ii));
    $content = ob_get_clean();
    try
    {
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('eotbold');         
        $html2pdf->writeHTML($content,false);
        $html2pdf->Output("literacyReports.pdf");
        
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>