   

<div style="position: relative" id="reporsttopdiv" data-total="<?php echo $total; ?>">
            <div  class="block table-responsive" >
                 <?php //if($total>0){?> <?php if(sizeof($reportData)>0){?>
                
                <table cellspacing="0" cellpadding="0" width="100%" border="0" class="dtb_header table">
  	<tr >
                    <td style=" text-align:left"> </td>
    	<td style="width:130px; text-align:left"> </td>
        <td style="width:80px; text-align:left"></td>
        <td style="width:80px; text-align:left"></td>
        
        <td style=" text-align:left;width:50px;" ><a id="exportExcel" class="tooltiplink cursor" rel="tooltip"  data-testId="<?php echo $testPaperId;?>" style="cursor: pointer;"  role="button"  data-placement="bottom"  data-original-title="Export Users" > <i class="icon-place-exportXls"></i></a> </td>
            
    </tr>
  </table>
                
                
                
                <table cellspacing="0" cellpadding="0" width="100%" border="0" class="dtb_header">
                    <thead><tr><th class="data_t_hide" >Name</th>
                            <th class="data_t_hide">Email</th>
                            <th class="data_t_hide">Phone</th>
                            <th class="data_t_hide">Date</th>
                            <th class="data_t_hide">Total Marks</th>
                            <!--<th class="data_t_hide">Total Questions</th>-->
                            <?php $j=1;foreach($reportData as $Details){ if($j==sizeof($reportData)){?> 
                            <?php $k=0;
                            foreach($Details->categoryScoreArray as $value){
                               
                                        
                                
                                ?>
                            <th><div class="truncatetable" rel="tooltip" data-original-title="<?php echo $value['categoryName']."(".$Details->categoryScoreArray1[$k].")";?>"><?php echo $value['categoryName']." (".$Details->categoryScoreArray1[$k].")";?></div></th>
                            <?php $k++;}} $j++;}?>
                             <th class="data_t_hide">System Marks</th>
                              <th class="data_t_hide">Review Marks</th>
                            <th class="data_t_hide">Review Pending / Total</th>
                            <th class="data_t_hide">Action
                                <!--<div rel="tooltip" title="TotalQuestion(s)" class="tabletopcorner tabletopcornerpaddingtop" style="float: right;cursor: pointer;">
                                    <div class="label label-warning record_size">
                                        <?php //echo $totalQuestions;?> 
                                    </div>
                                </div>-->
                            </th>
                        </tr></thead>
                    <tbody>
                        
                        <?php $i=1;foreach($reportData as $Details){?> 
                        <tr class="<?php if($i%2==0){echo "odd";}else{echo "even";} ?>" >
                            <td class="data_t_hide">
                                <div class="emaildiv">
                                <?php echo $Details->userName;?>
                                </div>
                            </td> 
                            <td class="data_t_hide"><div class="emaildiv">
                                <?php echo $Details->EmailId;?>
                                </div>
                            </td>
                            <td class="data_t_hide center">
                                <?php echo $Details->PhoneNumber;?>
                            </td>
                            <td  class="data_t_hide">
                                <?php echo $Details->testDate;?>
                            </td>
                            <!--<td  class="data_t_hide">
                                <?php //echo $Details->totalQuestions;?>
                            </td>-->
                            <td  class="data_t_hide center" style="text-align:center">
                                <?php echo $Details->totalMarks;?>
                            </td>
                            <?php foreach($Details->categoryScoreArray as $value){?>
                            <td class="data_t_hide" style="text-align:center"><?php echo $value['score'];?></td>
                            <?php }?>
                             <td  class="data_t_hide" style="text-align:center">
                                <?php echo $Details->systemMarks;?>
                            </td>
                             <td  class="data_t_hide" style="text-align:center">
                                <?php echo $Details->reviewMarks;?>
                            </td>
                            <td  class="data_t_hide" style="text-align:center">
                                <?php echo $Details->reviewPendingCount." / ".$Details->totalReviewQ;?>
                            </td>
                             
                          
                            <td  class="data_t_hide" id="reviewNow" data-userId="<?php echo $Details->userId;?>" data-testId="<?php echo $testPaperId; ?>" style="cursor: pointer">
                               
                            <?php if($Details->reviewPendingCount>0){?>
                                 
                                 <input  class="btn" type="button" value="Review Now" >
                            <?php }else{ ?>
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
                        <?php  } else{ ?>
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
<script type="text/javascript">
$("[rel=tooltip]").tooltip();
</script>