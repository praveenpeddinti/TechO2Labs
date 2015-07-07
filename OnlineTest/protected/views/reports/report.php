   

<div style="position: relative">
            <div  class="block">
                
                <table cellspacing="0" cellpadding="0" width="100%" border="0" class="dtb_header">
                    <thead><tr><th class="data_t_hide">Name</th>
                            <th class="data_t_hide">Date</th>
                            <th class="data_t_hide">Total Questions</th>
                            <?php $j=1;foreach($reportData as $Details){ if($j==sizeof($reportData)){?> 
                            <?php foreach($Details->categoryScoreArray as $value){?>
                            <th><?php echo $value['categoryName'];?></th>
                            <?php }} $j++;}?>
                            <th class="data_t_hide">Total Marks</th>
                            <th class="data_t_hide">Review</th>
                            <th class="data_t_hide">Action</th>
                        </tr></thead>
                    <tbody>
                        <tr id="noRecordsTR" style="display: none">
                            <td colspan="8">
                                <span class="text-error"> <b>No records found</b></span>
                            </td>
                        </tr>
                        <?php $i=1;foreach($reportData as $Details){?> 
                        <tr class="<?php if($i%2==0){echo "odd";}else{echo "even";} ?>" >
                            <td class="data_t_hide">
                                <?php echo $Details->userName;?>
                            </td>  
                            <td  class="data_t_hide">
                                <?php echo $Details->testDate;?>
                            </td>
                            <td  class="data_t_hide">
                                <?php echo $Details->totalQuestions;?>
                            </td>
                            <?php foreach($Details->categoryScoreArray as $value){?>
                            <td class="data_t_hide"><?php echo $value['score'];?></td>
                            <?}?>
                            <td  class="data_t_hide">
                                <?php echo $Details->totalMarks;?>
                            </td>
                            <td  class="data_t_hide">
                                <?php echo $Details->totalReviewQ;?>
                            </td>
                            <?php if($Details->totalReviewQ>0){?>
                            <td  class="data_t_hide" id="reviewNow">Review Now</td>  
                           <?php }?>
                        </tr>
                         <?php $i++;}?>
                    </tbody>
                </table>
            </div>        
        </div>