<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mahaseel Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/AdminLTE.min.css">
  <!-- custom-->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/custom.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/backend/');?>dist/css/croppie.css">
<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />

        

  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
   
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
           <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>-->
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                      
                      <?php if(file_exists('attachments/users/thumb/'.$this->session->userdata('admin_data')['image']) && !empty($this->session->userdata('admin_data')['image'])){
                ?>
                
                <img src="<?php echo base_url('attachments/users/thumb/'.$this->session->userdata('admin_data')['image'])?>" class="user-image" alt="User Image">

                <?php
                      }else{
                        ?>
                          <img src="<?php echo base_url('assets/backend/');?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <?php
                      }
                ?>
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('assets/backend/');?>dist/img/user3-128x128.jpg" class="user-image" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('assets/backend/');?>dist/img/user4-128x128.jpg" class="user-image" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('assets/backend/');?>dist/img/user3-128x128.jpg" class="user-image" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?php echo base_url('assets/backend/');?>dist/img/user4-128x128.jpg" class="user-image" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>-->
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
           <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>-->
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php if(file_exists('attachments/users/thumb/'.$this->session->userdata('admin_data')['image']) && !empty($this->session->userdata('admin_data')['image'])){
                ?>
                
                <img src="<?php echo base_url('attachments/users/thumb/'.$this->session->userdata('admin_data')['image'])?>" class="user-image" alt="User Image">

                <?php
                      }else{
                        ?>
                          <img src="<?php echo base_url('assets/backend/');?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <?php
                      }
                ?>
              <span class="hidden-xs"><?php echo $this->session->userdata('admin_data')['first_name'];?> <?php echo $this->session->userdata('admin_data')['last_name'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
              <?php if(file_exists('attachments/users/thumb/'. $this->session->userdata('admin_data')['image']) && !empty($this->session->userdata('admin_data')['image'])){
                ?>
                
                <img src="<?php echo base_url('attachments/users/thumb/'.$this->session->userdata('admin_data')['image'])?>" class="img-circle" alt="User Image">

                <?php
                      }else{
                        ?>
                          <img src="<?php echo base_url('assets/backend/');?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        <?php
                      }
                ?>

                <p>
                <?php echo $this->session->userdata('admin_data')['first_name'];?> <?php echo $this->session->userdata('admin_data')['last_name'];;?>
                 </p>
              </li>
              <!-- Menu Body -->
             <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                 /.row 
              </li>-->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('admin-profile');?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('admin-logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    

    <a href="<?php echo base_url('admin-dashboard');?>" class="logo">
       <!--  mini logo for sidebar mini 50x50 pixels  -->
       <span class="logo-mini"><img src="<?php echo base_url('assets/frontend/images/logo.png');?>" style="max-height:25px;"></span>
      <!-- logo for regular state and mobile devices  -->
      <span class="logo-lg"><img src="<?php echo base_url('assets/frontend/images/logo.png');?>" style="max-height:40px;"></span>
    </a> 
    <!-- Sidebar user panel -->
      <div class="user-panel">
      
        <div class="pull-left image">
        <?php if(file_exists('attachments/users/thumb/'.$this->session->userdata('admin_data')['image']) && !empty($this->session->userdata('admin_data')['image'])){
                ?>
                <img src="<?php echo base_url('attachments/users/thumb/'.$this->session->userdata('admin_data')['image'])?>" class="img-circle" alt="User Image">

                <?php
                      }else{
                        ?>
                          <img src="<?php echo base_url('assets/backend/');?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        <?php
                      }
                ?>
        </div>
        <div class="pull-left info">
          <p><a href="<?php echo base_url('admin-profile');?>"><?php echo $this->session->userdata('admin_data')['first_name'];?> <?php echo $this->session->userdata('admin_data')['last_name'];?></a></p>
          <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
        </div>
      </div>
 
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <li class="active">
          <a href="<?php echo base_url('admin-dashboard');?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
         
        </li>
          <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Home</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="<?php echo base_url('admin-manage-sliders');?>">Manage Sliders</a></li>
          <li><a href="<?php echo base_url('admin-manage-pages');?>">Manage Pages</a></li>
          <li><a href="<?php echo base_url('admin-manage-faqs');?>">Manage Faq's</a></li>
           <li><a href="<?php echo base_url('admin-manage-email-templates');?>">Manage Email Templates</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Master</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="<?php echo base_url('admin-manage-unit');?>">Manage Units</a></li>
          <li><a href="<?php echo base_url('admin-manage-category');?>">Manage Product Categories</a></li>
          <!--<li><a href="<?php echo base_url('admin-manage-master-products');?>">Manage Master Products</a></li>-->
          <li><a href="<?php echo base_url('admin-manage-products');?>">Manage Products</a></li>
          <li><a href="<?php echo base_url('admin-manage-service-categories');?>">Manage Service Categories</a></li>
          <li><a href="<?php echo base_url('admin-manage-services');?>">Manage Service Provider Services</a></li>
          <li><a href="<?php echo base_url('admin-website-settings');?>">Manage Website Settings</a></li>
          <li><a href="<?php echo base_url('admin-manage-teams');?>">Manage Our Teams</a></li>
          <li><a href="<?php echo base_url('admin-manage-calculations');?>">Manage Calculations</a></li>
          <li><a href="<?php echo base_url('admin-manage-student');?>">Manage Students</a></li>
          <li><a href="<?php echo base_url('admin-manage-facilities');?>">Manage Facilities</a></li>
          <li><a href="<?php echo base_url('admin-manage-our-services');?>">Manage Our Services</a></li>
          <li><a href="<?php echo base_url('admin-manage-work-process');?>">Manage Work Process</a></li>
            </ul>
        </li>    
        
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Users</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="<?php echo base_url('admin-manage-users');?>">Manage Users</a></li>
          <li><a href="<?php echo base_url('admin-manage-subscribers');?>">Manage Subscribers</a></li>
          <li><a href="<?php echo base_url('admin-manage-contact-us');?>">Manage Contact Us</a></li>
          <li><a href="<?php echo base_url('admin-manage-reviews');?>">Manage Reviews</a></li>
          <li><a href="<?php echo base_url('admin-manage-orders');?>">Manage Orders</a></li>
         
            </ul>
        </li>
         <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Graphical User's Presentation</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="<?php echo base_url('admin-manage-graph');?>">Total Coustmer's Per Month</a></li>        <li><a href="<?php echo base_url('admin-invoice');?>">Invoice</a></li>

          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


         