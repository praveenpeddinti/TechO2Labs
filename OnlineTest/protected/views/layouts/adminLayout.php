<?php include 'header.php';
$user_present = Yii::app()->session->get('TinyUserCollectionObj');
if(isset($user_present) || Yii::app()->params['Project']!='SkiptaNeo') {?>
<section >
<div class="container">
        <div class="marginT80">
       <?php echo $content; ?>
            </div>
   </div>
</section>
<?php } ?>
    
<?php include 'footer.php' ?>
