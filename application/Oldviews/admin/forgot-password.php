<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
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
    <b>Admin</b>LTE
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Forgot Password</p> 
    <?php
   
            if ($this->session->flashdata('error')) {
                ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                <?php
            }
            if ($this->session->flashdata('success')) {
              ?>
              <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
              <?php
          }

             
            ?>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" id="username" class="form-control" placeholder="Email" value="<?= set_value('username') ? set_value('username'):$this->input->post('username');?>">
        <?php echo form_error('username'); ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
       
      <div class="row">
        <div class="col-xs-6">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button> 
        </div>
        <div class="col-xs-6">
        <a href="<?php echo base_url();?>admin" class="login-forgot-password">Login</a>
        </div>
        <!-- /.col -->
         
        <!-- /.col -->
      </div>
    </form>
 
 
    
 
  </div>
  <!-- /.login-box-body -->
</div>
 
</body>
</html>
