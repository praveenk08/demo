<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin| Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/iCheck/square/blue.css">
  <!-- custom-->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/custom.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><img src="<?php echo base_url('assets/frontend/images/logo.png');?>" style="max-height:80px;"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <h4 class="login-box-msg"><strong>Admin</strong> Sign In</h4> 
    <?php
            if ($this->session->flashdata('err_login')) {
                ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('err_login') ?></div>
                <?php
            }
            ?>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="email" id="email" class="form-control" placeholder="Email"  value="<?= set_value('email');?>">
         <?php echo form_error('email'); ?> 
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
         <input type="password" class="form-control" id="password"  name="password" placeholder="Password"  value="<?= set_value('password');?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php echo form_error('password'); ?>
      </div>
     <!-- <div class="form-group">
        <div class="customCheck">
          <input type="checkbox" name="remind_me" id="rememberme" value="1">
          <label for="rememberme">Remember Me</label>
        </div>
      </div>-->
      <div><button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button></div>
      <div class="text-right"><a href="<?php echo base_url();?>admin-forgot-password" class="login-forgot-password">Forgot Password</a></div>
      
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
 
</body>
</html>
