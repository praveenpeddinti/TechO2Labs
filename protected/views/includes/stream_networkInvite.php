<?php $networkName = str_replace(' ', '', Yii::app()->params['NetworkName']);
?> 
<div class="networkbanner">
    <?php if ($data->GroupImage != "") { ?>                        
        <img  src="<?php echo $data->GroupImage ?>">
    <?php } ?>
    <div  class="<?php if ($data->GroupImage != "") { ?>networkbottombanner<?php } ?>">
        <div class="<?php if ($data->GroupImage != "") { ?>networkinvitediscription<?php } ?>">
            <?php echo $data->PostCompleteText; ?>
        </div>
        <div class="networkbutton alignright clearboth">

            <button class="btn btn-2 btn-2a " onclick="loginOauthOnProvider('<?php echo $networkName ?>', '<?php echo Yii::app()->params['ServerURL'] ?>', '<?php echo $data->NetworkRedirectUrl ?>', '<?php echo $data->_id ?>')" name="Join Now" ></i> Join Now</button> 
        </div>
    </div>
</div>