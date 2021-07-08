<!DOCTYPE html>
<html>
   <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Notification</title>
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
                              <td align="center"><a href=""><img src="http://localhost/mahaseel/assets/frontend/images/logo.png" style="width: 150px;"></a></td>
                           </tr>
                        </table>
                        
                        <table border="0" cellpadding="10" cellspacing="10" width="600" style="background: #fff; border:1px solid #f5811e;">
                           <tr>
                              <td colspan="2">Dear <b><?php echo $template['name'];?></b>
                              </td>
                           </tr>
                           <tr>
                              <td>Type:</td>
                              <td><?php echo $template['type'];?></td>
                           </tr>
                           <tr>
                              <td>Message:</td>
                              <td><?php echo $template['message'];?></td>
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