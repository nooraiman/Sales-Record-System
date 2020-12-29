<?php
require 'includes/database.php';
define('BASE', '/');
session_start();
$page_title = "Logging out...";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title;?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/css/adminlte.min.css">
    <!-- Sweet alert -->
    <link rel="stylesheet" href="<?php echo BASE;?>assets/plugins/sweetalert2/sweetalert2.min.css">
    <!-- Sweet alert -->
    <script src="<?php echo BASE;?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
    <?php
        if(isset($_SESSION['id'])) {
    ?>
        <script>
            Swal.fire({
            title: 'Are you sure?',
            text: "You are about to log out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, I am!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel || result.dismiss === Swal.DismissReason.esc || result.dismiss === Swal.DismissReason.backdrop) {
                    window.location = "index.php";
                } else {
                    window.location = "login.php?logout=4236a440a662cc8253d7536e5aa17942"; //logout in md5 (not encryption but just unique so ppl wont type this by chance)
                }
            });
        </script>
    <?php
        } else {
            header("Location: login.php");
        }
    ?>
</body>
</html>