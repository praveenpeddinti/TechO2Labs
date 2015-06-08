<?php if (isset($data->WebUrls) && isset($data->WebUrls->Weburl)) {
    ?>
    <?php if (isset($data->IsWebSnippetExist) && $data->IsWebSnippetExist == '1') { ?>            
        <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;clear:both;">
            <div class="Snippet_div" style="position: relative">

                <a href="<?php echo $data->WebUrls->Weburl; ?>" target="_blank">


                    <?php if ($data->WebUrls->WebImage != "") { ?>
                        <span  class=" pull-left img_single e_img" style="width:100px;" ><img src="<?php echo $data->WebUrls->WebImage; ?>"></span>
                    <?php } ?>  </a>   
                <div class="media-body">                                   

                    <label class="websnipheading"><?php echo $data->WebUrls->WebTitle ?></label>

                    <a class="websniplink" href="<?php echo $data->WebUrls->Weburl; ?>" target="_blank"> <?php echo $data->WebUrls->WebLink ?></a>
                    <p><?php echo $data->WebUrls->Webdescription ?></p>

                </div>

            </div>
        </div>

    <?php
    }
}?>
