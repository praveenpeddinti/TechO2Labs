<table>
    
    <th>UserName</th><th>Email</th>
    
     <?php  for($i=0;$i<sizeof($Emails);$i++){
     ?>   <tr>
          <td>  <?php  echo $UserNames[$i];
      ?> </td>
      <td>  <?php  echo $Emails[$i];
      ?> </td>  </tr>
  <?php   }
    ?>
    
    
</table>