   

<div style="position: relative" id="reporsttopdiv" data-total="<?php echo $total; ?>">
            <div  class="block">
                 <?php if($total>0){?>
                <table cellspacing="0" cellpadding="0" width="100%" border="0" class="dtb_header">
                    <thead><tr><th class="data_t_hide">Name</th>
                            <th class="data_t_hide">Date</th>
                            <th class="data_t_hide">Total Marks</th>
                            <!--<th class="data_t_hide">Total Questions</th>-->
                            <?php $j=1;foreach($reportData as $Details){ if($j==sizeof($reportData)){?> 
                            <?php foreach($Details->categoryScoreArray as $value){?>
                            <th><?php echo $value['categoryName'];?></th>
                            <?php }} $j++;}?>
                             <th class="data_t_hide">System Marks</th>
                              <th class="data_t_hide">Review Marks</th>
                            <th class="data_t_hide">Review Pending / Total</th>
                            <th class="data_t_hide">Action</th>
                        </tr></thead>
                    <tbody>
                        
                        <?php $i=1;foreach($reportData as $Details){?> 
                        <tr class="<?php if($i%2==0){echo "odd";}else{echo "even";} ?>" >
                            <td class="data_t_hide">
                                <?php echo $Details->userName;?>
                            </td>  
                            <td  class="data_t_hide">
                                <?php echo $Details->testDate;?>
                            </td>
                            <!--<td  class="data_t_hide">
                                <?php //echo $Details->totalQuestions;?>
                            </td>-->
                            <td  class="data_t_hide">
                                <?php echo $Details->totalMarks;?>
                            </td>
                            <?php foreach($Details->categoryScoreArray as $value){?>
                            <td class="data_t_hide"><?php echo $value['score'];?></td>
                            <?php }?>
                             <td  class="data_t_hide">
                                <?php echo $Details->systemMarks;?>
                            </td>
                             <td  class="data_t_hide">
                                <?php echo $Details->reviewMarks;?>
                            </td>
                            <td  class="data_t_hide">
                                <?php echo $Details->reviewPendingCount." / ".$Details->totalReviewQ;?>
                            </td>
                             
                          
                            <td  class="data_t_hide" id="reviewNow" data-userId="<?php echo $Details->userId;?>" data-testId="<?php echo $testPaperId; ?>" style="cursor: pointer">
                               
                            <?php if($Details->reviewPendingCount>0){?>
                                 
                                 <input  class="btn" type="button" value="Review Now" >
                                <?
                                
                            }else{ ?>
                                  <input  class="btn btn_gray" type="button" value="View Review" >
                                
                           <?php  }
                           ?>
                            </td>  
                          
                        </tr>
                         <?php $i++;}?>
                        
                    </tbody>
                </table>
                <div class="pagination pagination-right">
            <div id="pagination"></div> 
            </div> 
                <?php } else{ ?>
                <table cellspacing="0" cellpadding="0" width="100%" border="0" class="dtb_header">
                    <thead><tr><th class="data_t_hide">Name</th>
                            <th class="data_t_hide">Date</th>
                            <th class="data_t_hide">Total Marks</th>
                            <?php $j=1;foreach($reportData as $Details){ if($j==sizeof($reportData)){?> 
                            <?php foreach($Details->categoryScoreArray as $value){?>
                            <th><?php echo $value['categoryName'];?></th>
                            <?php }} $j++;}?>
                            <th class="data_t_hide">System Marks</th>
                              <th class="data_t_hide">Review Marks</th>
                            <th class="data_t_hide">Review</th>
                            <th class="data_t_hide">Action</th>
                        </tr></thead>
                    <tbody>
                        <tr id="noRecordsTR">
                            <td colspan="8">
                                <span class="text-error"> <b>No records found</b></span>
                            </td>
                        </tr></tbody>
                </table>
                            <?php }?>
        </div>
    </div>
