<?php 

 if(is_object($stream))
      {  
?>
<ul  class="listnone newsbox impressionUL" >
<?php foreach($stream as $data){ 
        $translate_fromLanguage = $data->Language;
        $translate_class = "translatebutton";
        $translate_id = $data->_id;
        $translate_postId = $data->PostId;
        $translate_postType = $data->PostType;
        $translate_categoryType = $data->CategoryType;
    ?>

<?php if($data->CategoryType==8){ ?>
      <li class="woomarkLi newsLis <?php echo (isset($data->IsPromoted) && $data->IsPromoted==1)?'promoted':'';echo (isset($data->IsSaveItForLater) && $data->IsSaveItForLater==1) ?' saveitforlater' :'' ?>"  id="<?php echo $data->_id?>" data-postid="<?php echo $data->PostId; ?>" data-posttype="<?php  echo $data->PostType;?>" data-categorytype="<?php  echo $data->CategoryType;?>">  
      <?php  include Yii::app()->basePath.'/views/includes/news_view.php';?></li>
      <?php } else{ $displayStream="news"; 
            if($data->IsNotifiable){ ?>
           <li class="woomarkLi test" id="<?php echo $data->_id?>" data-postid="<?php echo $data->PostId; ?>" data-posttype="<?php  echo $data->PostType;?>" data-categorytype="<?php  echo $data->CategoryType;?>">  
            <?php include Yii::app()->basePath.'/views/post/advertisement_view.php';
            ?></li>
            <?php } } 
?>


<?php }?>
</ul>
<?php
      }else{
          echo $stream;
      }
?>