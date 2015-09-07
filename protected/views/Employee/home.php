<title>
    <?php
    $commonTitle = Yii::app()->params['pageTitles']['commonTitle'];
    echo isset($pageTitle) ? $pageTitle : $commonTitle;
    ?>

</title>
<div class="container container_top">
    <div class="row">
          <?php require_once 'registration.php'; ?>
        <?php require_once 'login.php'; ?>
    </div>
</div>