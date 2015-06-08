<?php if(is_array($userAnswers)){ ?>

<div class="row-fluid " id="postDetailedTitle">
    <div class="span11 ">        
            <div class="questionview">
                <?php echo $question;?>
            </div>        
     </div>
          <div class="span1 ">
          <div class="grouphomemenuhelp alignright tooltiplink"> <a data-postType="" data-categoryId="" class="detailed_close_page" rel="tooltip"  data-original-title="close" data-placement="bottom" data-toggle="tooltip"> <i class="fa fa-times"></i></a> </div>
          </div>
     </div>
<hr>

<?php foreach($userAnswers as $row){ ?>
<div class="stream_widget marginT10" id="postDetailedwidget">
   	 <div class="profile_icon"><img src="<?php echo $row->ProfilePic;  ?>" >
         </div>
    <div class="post_widget" data-postid="<?php  echo $data->_id ?>" data-postType="<?php  echo $data->Type;?>">
        <div class="stream_msg_box">           
            <div class="stream_title paddingt5lr10" style="position: relative">
                <a style="cursor:pointer;text-decoration: none;"  class="userprofilename ">
                    <b><?php echo $row->Title; ?> </b> entered any other values
                </a>
                
            </div>
             <div class=" stream_content positionrelative">
                <ul>
                    <li class="media">
                        <div  class="media-body">
                             <ol><?php $i=1; foreach($row->Answers as $key=>$value){ ?>
                           
                                 <li class="survey_anyothercomments"><p><?php echo " $value"; $i++;?></p> </li>
                                
                            
                            <?php } ?></ol>
                            
                        </div>
                    </li>
                </ul>            
             
          </div>
          
        </div>          
        </div>
</div>

    

<?php } ?>
<script type="text/javascript">
$(".detailed_close_page").live("click",function(){
    $("#anyothervaluespage").hide();
    $("#streamsectionarea,#contentDiv").show();
});
</script>

<?php } ?>
