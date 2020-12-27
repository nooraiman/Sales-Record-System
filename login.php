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
            <form method="POST">
                <div class="input-group">
                    <span class="input-group-append">
                        <i class="fa fa-user"></i>
                    </span>
                    <input type="text" class="form-control" name="input_userid" placeholder="User ID">
                </div>
                <div class="input-group">
                    <span class="input-group-append">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" name="input_userpassword" placeholder="Password">
                </div>
                <input type="submit" class="btn btn-success submit-btn" name="btn_login" value="Login">
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
    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function messageBox(title,message) {
            Swal.fire(title,message,'error');
        }
        function redirectBox(title,message,location) {
            Swal.fire(title,message,'success').then((result) => {
                    window.location = location;
            });
        }
    </script>

    <!-- SESSION CHECK -->
    <?php
    session_start();

    function sessionCheck() {
        if(isset($_SESSION['id'])) {
            echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'You have already logged in!',
                text: 'You will be redirected in 2 seconds...',
                showConfirmButton: false,
                timer: 2000
                });
                let inputs = document.getElementsByTagName('input');
                for(let i = 0; i < inputs.length; i++) {
                inputs[i].disabled = true;
                }
                
            </script>";
            header("refresh: 3; index.php");
        }
    }

    if(isset($_GET['logout'])) {
        if($_GET['logout'] == "4236a440a662cc8253d7536e5aa17942") {
            session_destroy();
            session_start();
        } else {
            sessionCheck();
        }
    } else {
        sessionCheck();
    }
    ?>

    <!-- LOGIN SCRIPT -->
    <?php
        if(isset($_REQUEST['btn_login'])) {
            $userid = strip_tags($_REQUEST["input_userid"]);
            $userpass = md5(md5(md5(strip_tags($_REQUEST["input_userpassword"])))); //triple encyption using MD5

            if(empty($userid)) {
                echo "<script>messageBox('User ID is empty!','Please enter user ID in the input box.');</script>";
            } else if(empty($userpass)) {
                echo "<script>messageBox('Password is empty!','Please enter password in the input box.');</script>";
            } else {
                try {
                    $stmt = $conn->prepare("SELECT * FROM login a JOIN staff b, role c WHERE a.st_id = b.st_id AND a.ro_id = c.ro_id AND b.st_id =:userid"); //check if staff with the id exist
                    $stmt->execute(array(':userid'=>$userid));
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($stmt->rowCount() > 0) {  //first layer matches ID, if the staff exist then:
                        if($userid == $row["st_id"]) { //second layer matches ID, if the id matches (prevent 1=1 injection) then:
                            $inDBpass = $row["st_password"];
                            if($userpass == $inDBpass) { //password verification
                                $_SESSION["id"] = $row["st_id"];
                                $_SESSION["username"] = $row["st_username"];
                                $_SESSION["name"] = $row["st_name"];
                                $_SESSION["email"] = $row["st_email"];
                                $_SESSION["role"] = $row["ro_name"];
                                echo "<script>redirectBox('Successfully logged in!','You are authorized.','/');</script>";
                            } else {
                                echo "<script>messageBox('Login failed!','Please check your information again. <br>Error code: L02');</script>"; //L02 means wrong password.
                            }
                        } else {
                            echo "<script>messageBox('Login failed!','This message is rare to be displayed. What are you doing? You seems pretty sus...');</script>"; //PROBABLY an injection attempt!
                        }
                    } else {
                        echo "<script>messageBox('Login failed!','Please check your information again. <br>Error code: L01');</script>"; //L01 means User ID not found.
                    }
                } catch(PDOException $e) {
                    $e->getMessage();
                }
            }
        }
    ?>

</body>

</html>