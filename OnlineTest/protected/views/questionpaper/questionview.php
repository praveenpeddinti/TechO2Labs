            <?php if($data['QuestionType'] == 1) {?>
        <div class="question_options_div">
        	<div class="question position_R"> <label class="question_no">1) </label><?php echo $data['Question']; ?></div>
            <div class="q_options">
            	<ol>
                    <?php $i=0;foreach($data['Options'] as $rw) { ?>
                	<li><input name="answerinput" type="radio" value="<?php echo ($i+1); ?>"> <?php echo $rw; ?></li>
                <?php } ?>
                    
                </ol>
            </div>
        </div>
            <?php }else  { ?>
<p>hi sri</p>
                
                <?php } ?>
        


 