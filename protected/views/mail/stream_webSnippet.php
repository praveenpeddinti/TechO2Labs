<?php if (isset($streamObject->WebUrls) && isset($streamObject->WebUrls->Weburl)) {
    ?>
    <?php if (isset($streamObject->IsWebSnippetExist) && $streamObject->IsWebSnippetExist == '1') { ?>            
        <div id="snippet_main" style="padding-top: 10px; padding-bottom: 10px;clear:both;">
            <table>
                <tr>
                    <td style="width:105px;vertical-align: top">
                        <a href="<?php echo $streamObject->WebUrls->Weburl; ?>" target="_blank">
                        <?php if ($streamObject->WebUrls->WebImage != "") { ?>
                        <span  style="background:#fff;display:block"><img style="max-width:95px;padding:3px;border: 2px solid #c7c5c5;" src="<?php  echo $streamObject->WebUrls->WebImage; ?>"></span>
                    <?php } ?>  </a>
                        
                        
                    </td>
                    <td style="vertical-align: top">
                         <label style="font-size:18px;font-family:exo_2.0bold;color:#1E1D1B;font-weight: normal"><?php echo $streamObject->WebUrls->WebTitle ?></label>

                    <a style="font-weight:bold;color:#797979" href="<?php echo $streamObject->WebUrls->Weburl; ?>" target="_blank"> <?php echo $streamObject->WebUrls->WebLink ?></a>
                    <p><?php echo $streamObject->WebUrls->Webdescription ?></p>
                        
                    </td>
                </tr>
            </table>
           
        </div>

    <?php
    }
}?>
