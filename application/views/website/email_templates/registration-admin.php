<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Contact US</title>
   </head>
   <body style="background-color: #f1f1f1; font-family: roboto, sans-serif; font-size: 15px; margin: 0; padding: 0;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="background: #f1f1f1; font-family: 'roboto', sans-serif; font-size: 14px;">
         <tr>
            <td align="center">
               <table border="0" cellpadding="10" cellspacing="0" width="600" align="center">
                  <tr>
                     <td align="center">
                        <table border="0" cellpadding="10" cellspacing="0" width="600">
                           <tr>
                              <td align="center"><a href=""><img src="<?php echo base_url();?>assets/frontend/images/logo.png" style="width: 150px;"></a></td>
                           </tr>
                        </table>
                        <table border="0" cellpadding="10" cellspacing="10" width="600" style="background: #fff; border:1px solid #f5811e;">
                           <tr>
                              <td colspan="2">Dear  <b>Admin</b>, Some one has been Registered 
                              </td>
                           </tr>
                           <tr>
                              <td>Role:</td>
                              <td><?php echo $registration['role_name'];?></td>
                           </tr>
                           <tr>
                              <td>Name:</td>
                              <td><?php echo $registration['first_name'].' '.$registration['last_name'] ;?></td>
                           </tr>
                           <tr>
                              <td>Phone:</td>
                              <td><?php echo $registration['phone'];?></td>
                           </tr>
                           <tr>
                              <td>Email:</td>
                              <td><?php echo $registration['email'];?></td>
                           </tr>
                           <tr>
                              <td>Verification Link:</td>
                              <td><?php echo base_url('account-verification?token='.$registration['verification_code']);?></td>
                           </tr>
                           <tr>
                              <td align="right" colspan="2">Team, <br/> <?php echo base_url(); ?></td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>