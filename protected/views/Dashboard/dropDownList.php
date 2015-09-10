<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo CHtml::dropDownList('status'.$employee['employee_id'], $employee['status'],
    array(0=>'Inactive',1=>'Active'), 
    array('ajax' => 
        array('type'=>'POST',
            'data'=>array('status'=>'js:this.value','employee_id'=>$employee['employee_id']),
            'url'=> Yii::app()->createUrl('Techo2Employee/ajaxStatusChange'), 'dataType'=> 'json',
             'success' => 'function(data){var tempArray = this.data.split("&"); var finalArray = []; for (var i = 0; i < tempArray.length; i++) { final = tempArray[i].split("="); finalArray[final[0]] = final[1]; } $(".emp_"+finalArray["employee_id"]).find(".emp_status").html(data.status); }',
                    
                    'beforeSend' => 'function(){ }',
            
            )));
?>