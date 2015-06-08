<?php
     $user_present = Yii::app()->session->get('TinyUserCollectionObj');
     if(isset($user_present))
     {
     include 'footer_postlogin.php';
     }
     else 
     {
     include 'footer_prelogin.php';
     }
     ?>	
   <div class="modal fade" id="footerlinksModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialogfooterlinks  ">
                    <div class="modal-content ">
                        <div class="modal-header" id="footerlinksModal_header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="footerlinksModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body" id="footerlinksModal_body">
    
                        </div>
                        
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
</body>
</html>
