<!--<div id="surveyChart1" style="height: 500px;display: none;">
  
</div>
<div id="surveyChart2" style="height: 500px;display: none;">
  
</div>
<div id="surveyChart3" style="height: 500px;display: none;">
  
</div>-->
<div id="allchartsmaindiv">
    
</div>
<script type="text/javascript">

function surveyAnalticsHandler(data){
        //alert(data.toSource());
   
     var colorArray = ['#b87333','silver','gold','#e5e4e2']

             $.each(data.Questions, function(key, value) {
                  var userAnnotationArray = value.UserAnnotationArray;
                 $("#allchartsmaindiv").append("<div id='surveyChart" + key + "' style='height: 500px;'></div>");
                 if (value.QuestionType == 1 || value.QuestionType == 2 || value.QuestionType == 5) {
                     var dataArray = new Array();
                     dataArray.push(['Element', 'Percentage', {role: 'style'}, {role: 'tooltip'},{role: 'annotation'}]);
                     //alert(value.OptionsNewArray);
                     var colorArrayIndex = 0;
                     $.each(value.OptionsPercentageArray, function(key1, value1) {

                         key1 = "" + key1 + "";
                        
                         //if(key1 != "Other value "){
                         var annotation = '';
                         if(userAnnotationArray.indexOf(key1)>=0){
                             annotation = '*';
                         }
                         var newarray = [key1, value1, colorArray[colorArrayIndex], "Value:" + value.OptionsNewArray[key1],annotation];
                         dataArray.push(newarray);
                         //  }

                         colorArrayIndex++;
                     });

                     var data = google.visualization.arrayToDataTable(dataArray);
                     var options = {
                         title: value.Question,
                         legend: 'none',
                         hAxis: {format: '#\'%\''},
                           annotations:{
                              alwaysOutside:true,
                             textStyle: {
                                  fontName: 'Times-Roman',
                                  fontSize: 18,
                                  bold: true,
                                  italic: true,
                                  color: 'red',     // The color of the text.
                                  auraColor: 'red', // The color of the text outline.
                                  opacity: 0.8          // The transparency of the text.
                            }
                          }

                     };
                 }else if(value.QuestionType == 3 || value.QuestionType == 4){ 
      var userSelectedOptionsArray = value.userSelectedOptionsArray;
      //userSelectedOptionsArray[userId]
      var dataArray = new Array();
      //var labelArray = new Array();
      var labelArray =  new Array();
      labelArray.push('Genre');
       $.each(value.LabelName, function( key, value ) {
           labelArray.push(value);
            labelArray.push({ role: 'tooltip' });
             labelArray.push({ role: 'annotation' });
       });
       dataArray.push(labelArray);
     
      //alert(dataArray);
      var i=0;
        $.each(value.OptionsPercentageArray, function( key1, value1 ) {
             
              key1 = ""+key1+"";
             var selectedOption =  userSelectedOptionsArray[i];
            var newarray = new Array();
              newarray.push(key1); 
              var j=1;
             $.each(value1, function( k, v ) {
                 var annotation;
                 if(j == selectedOption){
                     annotation = "*";
                 }else{
                    annotation = ""; 
                 }
               newarray.push(v);
               newarray.push("Value:"+value.OptionsNewArray[key1][k]);
                newarray.push(annotation);
                j++;
            });
               
               dataArray.push(newarray); 
           
            i++;  
         });


var data = google.visualization.arrayToDataTable(dataArray);
      var options = {
        title: value.Question,
        width: 600,
        height: 400,
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: true,
         hAxis: {format:'#\'%\''},
          annotations:{
                              alwaysOutside:true,
                             textStyle: {
                                  fontName: 'Times-Roman',
                                  fontSize: 18,
                                  bold: true,
                                  italic: true,
                                  color: 'red',     // The color of the text.
                                  auraColor: 'red', // The color of the text outline.
                                  opacity: 0.8          // The transparency of the text.
                            }
                          }
      };
 }
 else if(value.QuestionType == 6 || value.QuestionType == 7){ 
     
     
     
     var dataArray = new Array();
       dataArray.push(['Task', 'Hours per Day']);
         //alert(value.OptionsNewArray);
       
         $.each(value.OptionsNewArray, function( key1, value1 ) {
                     key1 = "" + key1 + "";
                     var newarray = [key1, value1];
                     dataArray.push(newarray);
                 });

                 var data = google.visualization.arrayToDataTable(dataArray);


                 var options = {
                     title: 'My Daily Activities',
                     is3D: true,
                     sliceVisibilityThreshold: 0
                 };


    }
             if (value.QuestionType == 6 || value.QuestionType == 7) {
                 var chart = new google.visualization.PieChart(document.getElementById('surveyChart' + key));
             } else {
                 var chart = new google.visualization.BarChart(document.getElementById('surveyChart' + key));

             }
             chart.draw(data, options);

         });



     }
</script>