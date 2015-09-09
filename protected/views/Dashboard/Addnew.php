<div id="rows" >    
    <div id="image_wrap" class="MultiFile-wrap">
        
        <?php 
            echo "<br/>";
            $id =  $_GET['id'];       
        ?>  
    <?php 
        $this->widget('CMultiFileUpload', array(
                'model'=>$validations,
                'name' => 'image',
                'attribute'=>'image',
                'accept'=>'jpeg|jpg|gif|png', 
                'remove'=>'[X]',
                'max'=>4,
                'duplicate'=>'Already Selected',
                'denied' => 'Invalid file type', 
                'htmlOptions' => array('enctype' => 'multipart/form-data','multiple' => 'multiple'),
            ));
        ?>
 
    <div id="image_wrap_list<?php echo $_GET['id']; ?>" class="MultiFile-list"></div>
    
     
    </div>
</div>
</div>