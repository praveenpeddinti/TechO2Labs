<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.wookmark.js"></script>

    <ul  class="listnone newsbox" id="diseaseTopicsbox"  >
        
    </ul>
    

    
<script type="text/javascript">
    pF1 = 1;
    pF2 = 1;
    $(window).unbind("scroll");
//    if(typeof socketCurbside !== "undefined")
//        socketCurbside.emit('clearInterval',sessionStorage.old_key);
    gPage = "TopicStream";
    getCollectionData('/disease/getTopics', 'StreamPostDisplayBean', 'diseaseTopicsbox', '<?php echo Yii::t('translation','No_Data_Found'); ?>',"<?php echo Yii::t('translation','Thas_all_folks'); ?>");
    
        //ClearPostNodeIntervals();
 
     

 </script>    
 <script >
    
     var optionsC = {
          itemWidth: '100%', // Optional min width of a grid item
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#diseaseTopicsbox'), // Optional, used for some extra CSS styling
          offset: 20, // Optional, the distance between grid items
          outerOffset: 20, // Optional the distance from grid to parent
          flexibleWidth: '50%', // Optional, the maximum width of a grid item
          align: 'left'
        };
    var $window = $(window);
   applyLayout();
    function applyLayout() {
       
        optionsC.container.imagesLoaded(function() {
            optionsC.container.imagesLoaded(function() {
            // Create a new layout handler when images have loaded.
            handler = $('#diseaseTopicsbox li.woomarkLi1');
            
        if ($window.width() < 753) {
            optionsC.itemWidth = '100%';
            optionsC.flexibleWidth='100%';

        }
           else if ($window.width() > 753 && $window.width() < 1000) {
            optionsC.itemWidth = '80%';
        }else{
           
            optionsC.itemWidth = '40%'; 
        }
       
            handler.wookmark(optionsC);
            
        });
        });
    }  
   
    
 $window.resize(function() {
     
  applyLayout();
   
        });
     Custom.init(); 
//    
    </script>