

<?php if(isset($ispaswordreset) && $ispaswordreset=="true"){?>
    
   $(document).ready(function() {
 $('#resetPasswordModal').modal("show");});
 $('#ResetForm_email').val("<?php echo $resetForm->email;?>");
  $('#ResetForm_md5UserId').val("<?php echo $resetForm->md5UserId;?>");
<?php }

if(isset($resetpasswordexpirederror)){?>
      $(document).ready(function() {
   $('#resetPasswordModal').modal("show");});
 $('#resetPassword_body').html('<?php echo $resetpasswordexpirederror;?>');
<?php }

?>
    