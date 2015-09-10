
<!--
Designed By: Vamsi Nallana
copyrights@Techo2 India Pvt Limited
-->

<?php
$employee_id = 0;
$employee_name = NULL;
$employee_designation_id = NULL;
$employee_designation_name = NULL;
$session = Yii::app()->session['employee_data'];
if (isset($session) && count($session) > 0) {
    $employee_id = isset($session['employee_id']) ? $session['employee_id'] : $employee_id;
    $employee_name = isset($session['employee_name']) ? $session['employee_name'] : $employee_name;
    $employee_designation_id = isset($session['employee_designation_id']) ? $session['employee_designation_id'] : $employee_designation_id;
    $employee_designation_name = isset($session['employee_designation']) ? $session['employee_designation'] : $employee_designation_name;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap -->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/style.css" rel="stylesheet" type="text/css">
        <!--[if lt IE 9]>
              <link href="css/IE8.css" rel="stylesheet" type="text/css">
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        <!-- Link custom javascript file -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>

        
        
    </head>
    <body>
        <!-- ***************************FULL PAGE BACKGROUND******************************* --> 
        <div class="bgtransparent"></div> 
        <!-- ***************************HEADER******************************* -->
        <header>
            <div class="container" style="min-height:80px;">
                <div class="row">
                    <div class="col xs-12 col-sm-2 col-md-2">
                        <a class="navbar-brand" href="<?php  echo Yii::app()->request->baseUrl; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/techo2_images/logo.png" class="img-responsive" alt=""/></a>
                        
                        
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 mobilemenuheader" >

                    </div>
                    <?php
                      if(isset($session) && count($session) > 0){
                    ?>
                  
                    <div class="col-xs-12 col-sm-6 col-md-6 mobile">
                        <div class="pull-right normalpaddingtop">
                            <div class="row">
                                <div class="col-xs-4"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/techo2_images/pic.jpg" alt=""/></div>
                                <div class="col-xs-8">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <?php
                                            echo $employee_name;
                                            ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">               
                                           <?php //if(isset($employee_designation_id) && 1 == $employee_designation_id){ ?><!-- <li><a href="<?php  //echo $this->createUrl('Techo2Employee/RatingDashboard'); ?>">Rating Dashboard</a></li> --><?php  //} ?>
                                           <li><a href="<?php  echo $this->createUrl('Techo2Employee/EmployeeProfile',array('employee_id'=>$employee_id)); ?>">View profile</a></li>
                                           <li><a href="<?php  echo $this->createUrl('Techo2Employee/EditEmployeeProfile',array('employee_id'=>$employee_id)); ?>">Edit profile</a></li>

                                           <?php if(isset($employee_designation_id) && 1 == $employee_designation_id){ ?><li><a href="<?php  echo $this->createUrl('Techo2Employee/AllProfiles'); ?>">All Profiles</a></li><?php } ?>                                          
                                           <?php if(isset($employee_designation_id) && 1 == $employee_designation_id){ ?> <li><a href="<?php  echo $this->createUrl('Techo2Employee/EmployeeMultiupload'); ?>">Add New Files</a></li> <?php } ?>
                                                                                     

                                           <?php if(isset($employee_designation_id) && 1 == $employee_designation_id){ ?><li><a href="<?php  echo $this->createUrl('Techo2Employee/AllProfiles'); ?>">All Profiles</a>
                                           
                                           </li>
                                             
                                                   <?php } ?>
                                           
                                           
                                           <li><a href="<?php  echo Yii::app()->request->baseUrl.'/Techo2Employee/LoggedOut'; ?>">Log out</a></li>
                                           


                                        </ul>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                      }
                    ?>
                </div>
            </div>
        </header>
        
        
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php  echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
