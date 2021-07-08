 
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Mahaseel Registration</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800&display=swap" rel="stylesheet">
	</head>
	<body style="background-color: #fff; margin: 0; padding: 0;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="background: #f9f9f9; font-family: 'Montserrat', sans-serif;	font-size: 14px;">
			
			<tr>
				<td align="center">
					<table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
						<tr>
							<td></td>
						</tr>
						<tr>
							<td align="center" style="background-color: #fff;">
								<p style="margin: 0;">
								<?php
 								if(is_file('attachments/email-templates/main/'.$email_data['banner_image'])){
								?>
 								 <img src="<?php echo base_url('attachments/email-templates/main/'.$email_data['banner_image'])?>">
									<?php
									}else{
									?>
								<img src="<?php echo base_url();?>assets/frontend/images/banner01.jpg" style="width:100%;">
										<?php
									}
									?>
								</p>
								<p style="margin-top:-40px;">
								<a href="" style="background-color: #fff; border: 3px solid #205533; padding: 5px; display: inline-block;">
								<?php
								$settings=getSettings();
								if(is_file('attachments/pages/thumb/'.$settings['logo'])){
								?>
 								 <img src="<?php echo base_url('attachments/pages/thumb/'.$settings['logo'])?>">
									<?php
									}else{
									?>
										<img src="<?php echo base_url();?>/assets/frontend/images/logo.png">
										<?php
									}
									?>
								</p>
							</td>
						</tr>
						<tr>
							<td>
								<table border="0" cellpadding="15" cellspacing="0" width="100%" style="background: #f9fdff;">
									<tr>
										<td></td>
									</tr>
									<tr>
										<td align="center" style="font-size: 24px; font-weight: bold; color: #10a1da; letter-spacing: 1px;">
										<?php echo $email_data['welcome_heading'];?>
										</td>
									</tr>
									<tr>
										<td align="center" style="font-size: 18px; font-weight: bold; color: #205533; letter-spacing: 1px;">Hi <?php echo $registration['first_name'].' '.$registration['last_name'] ;?>,<?php echo $email_data['welcome_message'];?></td>
									</tr>
									<tr>
										<td align="center" style="">
										<?php echo $email_data['message_description'];?>
										</td>
									</tr>
									<tr>
										<td align="center" style=""><a href="<?php echo base_url('account-verification?token='.$registration['verification_code']);?>" style="display: inline-block; padding: 15px; background-color: #eeaf1f; color: #fff; text-transform: uppercase; text-decoration: none; font-size: 15px; font-weight: 600;">Confirm Registration</a></td>
									</tr>
									<tr>
										<td></td>
									</tr>
									<tr>
										<td align="center" style="background-color: #fff;">
											<p style="margin-top: 0; margin-bottom: 0;">Thank You,</p>
											<p style="font-style: italic; margin-bottom: 0; margin-top: 5px;">Team, <span style="font-style: normal; font-weight: bold;">Mahaseel</span></p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr><td><img src="<?php echo base_url();?>assets/frontend/images/banner02.jpg" style="width:100%;"></td></tr>
					</table>
				</td>
			</tr>
			
		</table>
	</body>
</html>