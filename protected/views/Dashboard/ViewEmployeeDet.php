<?php 
if(isset($employee_data) && count($employee_data) > 0){ ?>
<div id="dlg-employee-view">
    <table border="1" cellpadding ="2" cellspacing="2">
        <thead>
            <tr> 
            <?php
             echo isset($employee_data['employee_firstname']) ? $employee_data['employee_firstname'] :'NA';
             echo "&nbsp;&nbsp;"."Details";
            ?>
           <tr/>
        </thead>
        <tr>
            <th>Firstname</th>
            <td>
                <?php  echo isset($employee_data['employee_firstname']) ? $employee_data['employee_firstname'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>Middlename</th>
            <td>
                <?php  echo isset($employee_data['employee_middlename']) ? $employee_data['employee_middlename'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>Lastname</th>
            <td>
                <?php  echo isset($employee_data['employee_lastname']) ? $employee_data['employee_lastname'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>
                <?php  
                    if(isset($employee_data['gender_type']) && "M" == $employee_data['gender_type']){
                        echo "Male";
                    }
                    
                    if(isset($employee_data['gender_type']) && "F" == $employee_data['gender_type']){
                        echo "Female";
                    }
                    
                    if(isset($employee_data['gender_type']) && "O" == $employee_data['gender_type']){
                        echo "Other";
                    }
                  ?>
            </td>
        </tr>
        <tr>
            <th>Designation</th>
            <td>
                <?php  echo isset($employee_data['designation_name']) ? $employee_data['designation_name'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>Code</th>
            <td>
                <?php  echo isset($employee_data['employee_code']) ? $employee_data['employee_code'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>Email Address</th>
            <td>
                <?php  echo isset($employee_data['employee_email']) ? $employee_data['employee_email'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>Mobile Number</th>
            <td>
                <?php  echo isset($employee_data['employee_phone']) ? $employee_data['employee_phone'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>Date Of Birth</th>
            <td>
                <?php  echo isset($employee_data['employee_dob']) ? $employee_data['employee_dob'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>State</th>
            <td>
                <?php  echo isset($employee_data['state_name']) ? $employee_data['state_name'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>Country</th>
            <td>
                <?php  echo isset($employee_data['country_name']) ? $employee_data['country_name'] :'NA';  ?>
            </td>
        </tr>
        <tr>
            <th>Address</th>
            <td>
                <?php  echo isset($employee_data['employee_address']) ? $employee_data['employee_address'] :'NA';  ?>
            </td>
        </tr>
    </table>
    
</div>
<?php }else{ 
      echo "Please activate the user to show the details.";
    ?>
    
<?php } ?>
