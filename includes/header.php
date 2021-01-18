<?php
require 'database.php';
define('BASE', '/');
    
//SESSION CHECK
session_start();
if(!isset($_SESSION['id'])) {
    echo "<script>window.location = '/login.php';</script>";
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title;?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/plugins/summernote/summernote-bs4.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/plugins/sweetalert2/sweetalert2.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        .pull-left{float:left!important;}
        .pull-right{float:right!important;}
        .dt-center{text-align:center;}
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Nav Bar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left NavBar Links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                <a href="<?php echo BASE;?>" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Settings Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown"><i class="fas fa-user-cog"></i></a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">SR System</span>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo BASE;?>logout.php" class="dropdown-item">
                        Logout
                        <span class="float-right text-muted text-sm"><i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-blue elevation-4">
        <!-- Brand Logo -->
        <a href="<?php echo BASE; ?>" class="brand-link">
            <span class="brand-text font-weight-bold" style="text-align: center;margin-left: 55px;">SR System</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar User Panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php echo BASE; ?>assets/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a class="d-block"><?php echo strtoupper($_SESSION["username"]);?></a>
                    <a class="d-block"><small>(<?php echo strtoupper($_SESSION["role"]);?></small>)</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <i class="nav-icon fa fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo BASE;?>products/" class="nav-link">
                            <i class="nav-icon fab fa-wpforms"></i>
                            <p>Products</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo BASE;?>suppliers/" class="nav-link">
                            <i class="nav-icon fas fa-store"></i>
                            <p>Suppliers</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo BASE;?>transactions/" class="nav-link">
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>Transactions</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo BASE;?>reports/" class="nav-link">
                            <i class="nav-icon far fa-fw fa-file"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                    
                    <?php if($_SESSION['role'] == 'Admin') {?>
                    <li class="nav-header">Admins</li>
                    <li class="nav-item">
                        <a href="<?php echo BASE;?>staffs/" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Staff</p>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>

    </aside>
