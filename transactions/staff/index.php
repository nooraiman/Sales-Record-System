<?php
$page_title = "SRS | Transactions";
include '../../includes/header.php';
?>
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Sales Records</h1>
                    </div><!-- /.col-sm-6 -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a>Transactions</a></li>
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
                                <h3 class="card-title">My Transaction Details</h3>
                                <div class="card-tools">
                                    <button class="add btn btn-tool bg-success"><i class="fa fa-plus"></i> New Transaction</button>
                                </div>
                            </div>
                            <!-- /.card header -->

                            <!-- card-body -->
                            <div class="card-body">
                                <table id="transaction_list" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total Sales</th>
                                            <th>Transaction Date</th>
                                            <th>Submitted Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <!-- TEST DATA STARTS HERE (TO BE REMOVED WHEN BACK-END PART FINISHED) -->
                                    <tr>
                                        <td>1</td>
                                        <td>test</td>
                                        <td>213123</td>
                                        <td>3</td>
                                        <td>452523</td>
                                        <td>23/5/2000</td>
                                        <td>24/5/2000</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>ztest</td>
                                        <td>213123</td>
                                        <td>3</td>
                                        <td>452523</td>
                                        <td>23/5/2000</td>
                                        <td>24/5/2000</td>
                                    </tr>
                                    <!-- TEST DATA ENDS HERE -->
                                    <?php
                                    try
                                    {
                                        $stmt = $conn->prepare("SELECT * FROM transaction t JOIN product p ON t.prod_id = p.prod_id JOIN staff s ON t.st_id = s.st_id WHERE t.st_id=:st_id");
                                        $stmt->execute(array(':st_id'=>$_SESSION['id']));
                                        $no = 0;
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                        ?>

                                        <tr>
                                            <td><?php echo ++$no; ?></td>
                                            <td><?php echo $row['prod_name'];?></td>
                                            <td><?php echo $row['prod_price'];?></td>
                                            <td><?php echo $row['tr_qty'];?></td>
                                            <td><?php echo ($row['prod_price']*$row['tr_qty']);?></td>
                                            <td><?php echo $row['tr_date'];?></td>
                                            <td><?php echo $row['tr_key_in'];?></td>
                                        </tr>
                                        <?php
                                        }
                                    }
                                    catch(PDOException $e)
                                    {
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
include '../../includes/footer.php';
?>

<script>

    // DataTables
    var table_id = "transaction_list";
    var table = $('#'+table_id).DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
            });
    $('#'+table_id+'_wrapper .row:first-child .col-sm-12:first-child').remove();

    // Custom script to fix searchbox styling
    var searchBoxRow = $('#'+table_id+'_wrapper .row:first-child .col-sm-12');
    searchBoxRow.removeClass('col-md-6');
    searchBoxRow.addClass('col-md-12');
    var searchBox = $('#'+table_id+'_wrapper .row:first-child .col-sm-12 #'+table_id+'_filter label');
    searchBox.children().unwrap();
    $('#'+table_id).addClass('mt-1');
    $('#'+table_id+'_wrapper .row .dataTables_paginate .pagination').addClass('pull-right');

// #UNFINISHED YET
//OTHER FUNCTIONS TO BE DONE...
</script>

</body>
</html>