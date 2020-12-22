<?php
require 'includes/database.php';
define('BASE', '');
$page_title = "SRS | Login";
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
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/css/adminlte.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/css/login.css">
</head>

<body>
    <!-- Login Box Start -->
    <div class="login-box text-center">
        <h3 class="login-title "><strong>SR System Login</strong></h3>
        <div class="login-form">
            <form method="POST" action="<?php echo BASE;?>index.php"> <!-- TO BE CHANGED TO PROCESS LOGIN CREDENTIALS -->
                <div class="input-group">
                    <span class="input-group-append">
                        <i class="fa fa-user"></i>
                    </span>
                    <input type="text" class="form-control" name="userid" placeholder="User ID">
                </div>
                <div class="input-group">
                    <span class="input-group-append">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" name="userpassword" placeholder="Password">
                </div>
                <input type="submit" class="btn btn-success submit-btn" value="Login">
            </form>
        </div>
        <footer>
            <hr>
            <small><strong>Copyright &copy; 2020 <a href="#">SRS Teams</a>.</strong>
            All rights reserved. Version 1.0</small>
        </footer>
    </div>
    <!-- Login Box Ends -->

    <!-- jQuery -->
    <script src="<?php echo BASE; ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo BASE; ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo BASE; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo BASE; ?>assets/js/adminlte.js"></script>

</body>

</html>