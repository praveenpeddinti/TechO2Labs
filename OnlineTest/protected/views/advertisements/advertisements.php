<div id="main" role="main">

      <ul id="MoreGroupsDiv" class="profilebox">
       
        <!-- End of grid blocks -->
      </ul>

    </div>

<script type="text/javascript">
    getCollectionData('/admin/AdvertisementMgmt', 'AdvertisementsCollection', 'MoreGroupsDiv', <?php echo Yii::t('translation','No_advertisements_found'); ?>,<?php echo Yii::t('translation','No more advertisements'); ?>);
    </script>
<script type="text/javascript">
  var handler = null;
    // Prepare layout options.
        var options = {
          itemWidth: '48%', // Optional min width of a grid item
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#MoreGroupsDiv'), // Optional, used for some extra CSS styling
          offset: 8, // Optional, the distance between grid items
          outerOffset: 10, // Optional the distance from grid to parent
          flexibleWidth: '50%', // Optional, the maximum width of a grid item
          align: 'left'
        };


      /**
       * Refreshes the layout.
       */
       var $window = $(window);
      function applyLayout() {
         
            
        options.container.imagesLoaded(function() {
            // Create a new layout handler when images have loaded.
            handler = $('#MoreGroupsDiv li');
            
        if ($window.width() < 753) {
         
            options.itemWidth = '100%';
            options.flexibleWidth='100%';

        }
           else if ($window.width() > 753 && $window.width() < 1000) {
            
            options.itemWidth = '48%';
           //   options = { flexibleWidth: '100%' };
             
            
        }else{
           
            options.itemWidth = '32.5%'; 
        }
       
            handler.wookmark(options);
            
        });
    };


             
        
 $window.resize(function() {
     
  applyLayout();
   
        });
//    $("[rel=tooltip]").tooltip();

  
  </script>