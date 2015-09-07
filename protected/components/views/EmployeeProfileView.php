<?php
if (isset($profile) && count($profile) > 0) {
    ?>
    <table border = "3" cellpadding ="3" cellspacing = "3">
        
        <tr>
            <th>
                <?php
                echo Yii::app()->params['widgetLables']['fullname'];
                ?>
            </th>       
            <th>
                <?php
                echo Yii::app()->params['widgetLables']['designation'];
                ?>
            </th>
            <th>
                <?php
                echo Yii::app()->params['widgetLables']['code'];
                ?>
            </th>
            <th>
                <?php
                echo Yii::app()->params['widgetLables']['email'];
                ?>
            </th>
            <th>
                <?php
                echo Yii::app()->params['widgetLables']['mobile'];
                ?>
            </th>
            <th>
                <?php
                echo Yii::app()->params['widgetLables']['status'];
                ?>
            </th>
        </tr>


        <tbody>        





            <tr>
                <td>
                    <?php
                    echo isset($profile['fullname']) ? $profile['fullname'] : 'NA';
                    ?>
                </td>
                <td>
                    <?php
                    echo isset($profile['designation_name']) ? $profile['designation_name'] : 'NA';
                    ?>
                </td>
                <td>
                    <?php
                    echo isset($profile['employee_code']) ? $profile['employee_code'] : 'NA';
                    ?>
                </td>
                <td>
                    <?php
                    echo isset($profile['employee_email']) ? $profile['employee_email'] : 'NA';
                    ?>
                </td>
                <td>
                    <?php
                    echo isset($profile['employee_phone']) ? $profile['employee_phone'] : 'NA';
                    ?>
                </td>
                <td>
                    <?php
                    if (isset($profile['employee_status']) && 1 == $profile['employee_status']) {
                        echo Yii::app()->params['widgetLables']['active'];
                    }

                    if (isset($profile['employee_status']) && 0 == $profile['employee_status']) {
                        echo Yii::app()->params['widgetLables']['inactive'];
                    }
                    ?>
                </td>
            </tr>





        </tbody>
    </table>
    <?php
}
?>

