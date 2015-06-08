

<div style="position: relative">

    <div  class="block">
        <div class="tablehead pull-left" >                  

        </div>
        <div class="tablehead tableheadright pull-right">
            <div class="tabletopcorner">
                <input type="text" placeholder="<?php echo Yii::t('translation','Search'); ?>" class="textfield textfieldsearch" id="searchAdId" onkeypress="return searchAD(event)" />
            </div>
            <div class="tabletopcorner" >
                <select id="filter" class="styled textfield textfielddatasearch">
                    <option <?php if($filterValue=='all'){ echo "selected";} ?> value="all">
                        <?php echo Yii::t('translation','All'); ?>
                    </option>
                    <option <?php if($filterValue=='currentactive'){ echo "selected";} ?> value="currentactive">
                        Current
                    </option>
                    <option  <?php if($filterValue=='expired'){ echo "selected";} ?> value="expired">
                        Expired
                    </option>
                    <option <?php if($filterValue=='future'){ echo "selected";} ?> value="future">
                        Future
                    </option>
                    <option <?php if($filterValue=='active'){ echo "selected";} ?> value="active">
                        <?php echo Yii::t('translation','Active'); ?>
                    </option>
                    <option <?php if($filterValue=='inactive'){ echo "selected";} ?> value="inactive">
                        <?php echo Yii::t('translation','Inactive'); ?>
                    </option> 

                    <option value="expired">
                        <?php echo Yii::t('translation','Expired'); ?>
                    </option> 
                </select>
            </div>
            <div class="btn-group pagesize tabletopcorner tabletopcornerpaddingtop" >
                <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle" data-placement="top"><?php echo Yii::t('translation','Page_size'); ?><span class="caret"></span></button>
                <ul class="dropdown-menu" style="min-width:70px">
                    <li><a  id="pagesize_5" onclick="setPageLength(5, 'advertisement')">5</a></li>
                    <li><a  id="pagesize_10" onclick="setPageLength(10, 'advertisement')">10</a></li>
                    <li><a  id="pagesize_15" onclick="setPageLength(15, 'advertisement')">15</a></li>                  
                </ul>
            </div>

            <div class="tabletopcorner tabletopcornerpaddingtop">
                <div class="label label-warning record_size " >+
                    <?php echo  $totlacount ?>
                </div>
            </div>
        </div>  
        <span id="spinner_admin"></span>
        <a class="block-heading" data-toggle="collapse">&nbsp;</a>
        <div id="tablewidget"  style="margin: auto;">
            <table class="table table-hover">                     
                <thead><tr><th><?php echo Yii::t('translation','Ad_Name'); ?></th><th class="data_t_hide">Advertisement Type</th><th><?php echo Yii::t('translation','Display_Page'); ?></th><th><?php echo Yii::t('translation','Display_Position'); ?></th><th class="data_t_hide">Start Date</th><th class="data_t_hide"><?php echo Yii::t('translation','Expiry_Date'); ?></th><th class="data_t_hide"><?php echo Yii::t('translation','Time_Interval'); ?></th><th>Current Status</th><th><?php echo Yii::t('translation','Status'); ?></th><th><?php echo Yii::t('translation','Actions'); ?></th></tr></thead>

                <tbody>
                    <tr id="noRecordsTR" style="display: none">
                        <td colspan="10">
                            <span class="text-error" style="text-align: center"> <b><?php echo Yii::t('translation','No_records_found'); ?></b></span>
                        </td>
                    </tr>
                    <?php if (is_array($advertisements)) { ?>
                        <?php foreach ($advertisements as $ad) { ?>
                            <tr class="odd">
                                <td>
                                    <?php echo $ad['Name'] ?>



                                </td> 
                                <td class="data_t_hide">
                                    <?php echo $adTypes[$ad['AdTypeId']] ?>



                                </td>
                                <td>
                                    <?php echo $ad['DisplayPage'] ?>
                                </td>
                                <td>                                                
                                    <?php echo $ad['DisplayPosition'] ?>
                                </td>
                                 <td class="data_t_hide">  
                                    
                                    <?php echo date("m/d/Y",strtotime($ad['StartDate'] )); ?>
                                </td>
                                <td class="data_t_hide">  
                                    
                                    <?php echo date("m/d/Y",strtotime($ad['ExpiryDate'] )); ?>
                                </td>

                                <td class="data_t_hide">                                                
                                    <?php if($ad['AdTypeId']==1 && $ad['IsAdRotate']==1){
                                        echo $ad['TimeInterval'] . " sec";                                        
                                    }else if($ad['AdTypeId']==2 && $ad['IsPremiumAd']==1){
                                        echo $ad['PTimeInterval'] . " sec";   
                                    } ?>

                                </td>
                                 <?php
                                    $date = date('Y-m-d');
                                    $sdate = new DateTime($ad['StartDate']);
                                    $exdate = new DateTime($ad['ExpiryDate']);
                                    $sdate = $sdate->format('Y-m-d');
                                    $exdate = $exdate->format('Y-m-d');               
                                    $currentStatus=($sdate<=$date && $date<=$exdate)?"Current":($exdate<$date?"Expired":"Future"); 
                                    $tatusclass=($sdate<=$date && $date<=$exdate)?"color:#497c3d":($exdate<$date?"color:#ac4d54":"color:#2672b2");
                                   
                                    ?>
                                <td style="<?php echo $tatusclass; ?>">
                                   <?php  echo $currentStatus; ?>
                                   
                                </td>
                                <td>
                                   <?php
                                   if ($ad['Status'] == 1) {
                                        echo Yii::t('translation','active');

                                        
                                    } else {
                                        echo Yii::t('translation','Inactive');
                                    }
                                    ?>

                                </td>
                                <td>
                                   
                                    <a rel="tooltip" style="cursor: pointer;" onclick="editAdvertisement(<?php echo $ad['id']?>)" role="button"  data-toggle="tooltip" title="Edit" > <i class="fa fa-pencil-square"></i></a> 

                                     <?php if($ad['AdTypeId']==1){?>
                                    <a rel="tooltip" style="cursor: pointer;" onclick='showPreview("<?php echo $ad['id']?>","<?php echo $ad['Url']?>","<?php echo $ad['Type']?>","<?php echo $ad['DisplayPosition']?>","<?php echo $ad['DisplayPage']?>")' role="button"  data-toggle="tooltip" title="Preview" > <i class="icon-place-view"></i></a> 
                                     <?php }else{?>
                                     <a rel="tooltip" style="cursor: pointer;" onclick='showStreamAdPreview("<?php echo $ad['id']?>")' role="button"  data-toggle="tooltip" title="Preview" > <i class="icon-place-view"></i></a> 
                                     <?php }?>
                                </td> 

                            </tr>

                        <?php } ?>
<?php } ?>
                </tbody>

            </table>

            <div class="pagination pagination-right">
                <div id="pagination"></div>  

            </div>
        </div>    
    </div>
</div>
<script type="text/javascript">
    Custom.init();
 </script>   