<?php
$dateFormat =  CommonUtility::getDateFormat();
    ?> 
<div class="row-fluid marginT10">
        <div class="span12">
            <div class="analytics_topleaders_box">
                <div class="analytics_widgetheader">
                <div class="row-fluid">
                    <div class="span12">
                          <div class="span4">
                            <div class="analytics_widgettitle">
                     <span class=""><?php echo Yii::t('translation','Group_Traffic'); ?> <i class="cursor helpmanagement" data-id="GroupTrafficHelpDescription_DivId"><img src="/images/system/spacer.png" /></i></span>
                    
                </div>
                        </div>
                         <div class="span8">
                        <div class="analytics_datepicker pull-right">
                            <ul class="anlt_datepic">
                                <li>
                                    <div class="row-fluid">
                                        <div class=" pull-right">

                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left  " id="Group_Traffic_dpd1">

                                                <label><?php echo Yii::t('translation','Start_Date'); ?></label>
                                                <input type="text"  id="GroupTraffic_StartDate" readonly="readonly" class="textfield " maxlength="20" value="">
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>

                                            <div data-date="" data-date-format="<?php echo Yii::app()->params['DateFormat']; ?>" class="input-append date pull-left " id="Group_Traffic_dpd2">

                                                <label><?php echo Yii::t('translation','End_Date'); ?></label>
                                                <input type="text"  id="GroupTraffic_EndDate"  readonly="readonly" class="textfield  " maxlength="20" value="">      
                                                <span class="add-on">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                               
                                            </div>

                                        </div>
                                    </div>
                                </li>
                                <!-- -->
                                <li style="cursor:pointer; position: relative" class="dropdown pull-left">
                                    <a data-original-title="<?php echo Yii::t('translation','Advanced_Options'); ?>" rel="tooltip" data-placement="bottom" class="tooltiplink analytics_export " data-toggle="dropdown" id="drop2"><i><img src="/images/system/spacer.png" ><span class="fa fa-caret-down"></span></i></a>

                                    <div class="dropdown-menu analytics_export_div">

                                        <ul>
                                            
                                            <li class="" ><a  href="/analytics/Pdf?date=1234" target="_blank" onclick="openActivitypdf(this,'GroupTraffic')" id="GroupTrafficPdf" name="GroupTrafficPdf"><i><img src="/images/system/spacer.png"  class="pdf_doc"></i> <?php echo Yii::t('translation','Export_as_PDF'); ?></a></li>
                                            <li class="" ><a href="/analytics/GenerateXLS?startdate=1234&enddate=456"  onclick="openActivityXls(this,'GroupTraffic')" id="GroupTrafficXls"  target="_blank"s><i><img src="/images/system/spacer.png" class="excel_doc"></i> <?php echo Yii::t('translation','Export_as_Excel'); ?></a></li>
                                        </ul>

                                    </div>
                                  </li>
                            </ul>
                        </div>
                       
                          </div>
                        
                        
                        
                    </div>
                </div>
                </div>
                <div id="GroupTraffic_daterange_error" class="alert alert-error" style="display: none;padding-left: 100px;"></div> 
                  <div id="Group_Trafficimg_div" style="display: none;"></div>
                <div id="Group_Traffic_Reports" style="position: relative;"></div>
                <div class="row-fluid">
                    <div class="span12 positionrelative">
                        
                         
                        <div id="Group_Traffic_chart_div"></div>
                        <div class="aligncenter poweredgoogle"><img src="/images/system/icon-powered-by-googleanalytics.png" /></div>
                        
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>

