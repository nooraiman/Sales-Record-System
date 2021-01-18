<?php
$page_title = "SRS | Reports";
include '../includes/header.php';

function isAdmin()
{
    $role = $_SESSION['role'];
    if ($role == "Admin") {
        return true;
    } else {
        return false;
    }
}

?>
<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Reports</h1>
                </div><!-- /.col-sm-6 -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><a>Reports</a></li>
                    </ol>
                </div><!-- /.col-sm-6 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <!-- card header -->
                        <div class="card-header">
                            <h3 class="card-title">All Reports Details</h3>
                        </div>
                        <!-- /.card header -->

                        <!-- card-body -->
                        <div class="card-body">
                            <table id="transaction_list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Price Per Unit (RM)</th>
                                        <th>Quantity</th>
                                        <th>Total Sales (RM)</th>
                                        <th>Transaction Date</th>
                                        <th>Supplier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        if (isAdmin()) {
                                            $stmt = $conn->prepare("SELECT * FROM transaction t JOIN product p ON t.prod_id = p.prod_id JOIN staff s ON t.st_id = s.st_id JOIN supplier sp ON p.su_id = sp.su_id");
                                            $stmt->execute();
                                        } else {
                                            $stmt = $conn->prepare("SELECT * FROM transaction t JOIN product p ON t.prod_id = p.prod_id JOIN staff s ON t.st_id = s.st_id JOIN supplier sp ON p.su_id = sp.su_id WHERE t.st_id=:st_id");
                                            $stmt->execute(array(':st_id' => $_SESSION['id']));
                                        }

                                        $no = 0;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $cell_prod_price = number_format((float)$row['prod_price'], 2, '.', '');
                                            $cell_total_sales = number_format((float)($row['prod_price'] * $row['tr_qty']), 2, '.', '');
                                    ?>

                                            <tr>
                                                <td><?php echo ++$no; ?></td>
                                                <td><?php echo $row['prod_name']; ?></td>
                                                <td><span class="pull-right"><?php echo $cell_prod_price; ?></span></td>
                                                <td><?php echo $row['tr_qty']; ?> unit(s)</td>
                                                <td><span class="pull-right"><?php echo $cell_total_sales; ?></span></td>
                                                <td><?php echo $row['tr_date']; ?></td>
                                                <td><?php echo $row['su_name']; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    } catch (PDOException $e) {
                                        throw $e->getMessage();
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- / Main -->
        </div><!-- /.container-fluid -->
    </section>
</div>


<?php
include '../includes/footer.php';
?>

<script>
    $(document).ready(function() {

        // DataTables
        var table = $('#transaction_list').DataTable({
            dom: '<"row" <"col-sm-12 col-md-6" <"pull-left"B>> <"col-sm-12 col-md-6" <"pull-right"f>> >' + '<"row" <"col-12" t> >' + '<"row" <"col-sm-12 col-md-6" i> <"col-sm-12 col-md-6" <"pull-right"p>> >',
            buttons: [
                ["copy", "csv", "excel", "pdf", "print"]
            ],
            "pageLength": '10',
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        })

    })
</script>

</body>

</html>