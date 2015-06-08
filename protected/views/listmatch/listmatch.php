

 <div id="uploadfile" data-placement="bottom" rel="tooltip"  data-original-title="Upload"></div>





<script type="text/javascript">   
    
    
    $(function(){
    
      var extensions='csv';
        initializeFileUploader('uploadfile', '/listmatch/upload', '10*1024*1024', extensions,'4', 'ListMatchForm' ,'',callbackofcsv,appendErrorMessages,"uploadlist");
      
    
    });
    
    
    function callbackofcsv(data){
        
        alert(data.toSource())
    }
    </script>