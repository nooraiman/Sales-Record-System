<?php
$page_title = "SRS | Transactions";
include '../includes/header.php';

function isAdmin() {
    $role = $_SESSION['role'];
    if($role == "Admin") {
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
            <?php if(isAdmin()) { ?>
            <!-- ADMIN CARD -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <!-- card header -->
                        <div class="card-header">
                            <h3 class="card-title">All Transaction Details</h3>
                        </div>
                        <!-- /.card header -->

                        <!-- card-body -->
                        <div class="card-body">
                            <table id="admin_transaction_list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Price Per Unit (RM)</th>
                                        <th>Quantity</th>
                                        <th>Total Sales (RM)</th>
                                        <th>Transaction Date</th>
                                        <th>Submitted Date</th>
                                        <th style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try
                                    {
                                        $stmt = $conn->prepare("SELECT * FROM transaction t JOIN product p ON t.prod_id = p.prod_id JOIN staff s ON t.st_id = s.st_id");
                                        $stmt->execute();
                                        $no = 0;
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                            $cell_prod_price = number_format((double)$row['prod_price'], 2, '.', '');
                                            $cell_total_sales = number_format((double)($row['prod_price']*$row['tr_qty']), 2, '.', '');
                                        ?>

                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td><?php echo $row['prod_name'];?></td>
                                        <td><span class="pull-right"><?php echo $cell_prod_price;?></span></td>
                                        <td><?php echo $row['tr_qty'];?> units</td>
                                        <td><span class="pull-right"><?php echo $cell_total_sales;?></span></td>
                                        <td><?php echo $row['tr_date'];?></td>
                                        <td><?php echo $row['tr_key_in'];?> <br>by <a href="#"
                                                title="<?php echo $row['st_name'];?>"><?php echo $row['st_username'];?></a>
                                        </td>
                                        <td class="dt-center">
                                            <button class="edit btn btn-sm btn-success"
                                                value="<?php echo $row['tr_id'];?>">Edit</button>
                                            <button class="delete btn btn-sm btn-danger"
                                                value="<?php echo $row['tr_id'];?>">Delete</button>
                                        </td>
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
            <!-- / ADMIN CARD -->
            <?php } else { ?>
            <!-- STAFF CARD -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <!-- card header -->
                        <div class="card-header">
                            <h3 class="card-title">My Transaction Details</h3>
                            <div class="card-tools">
                                <button class="add btn btn-tool bg-success"><i class="fa fa-plus"></i> New
                                    Transaction</button>
                            </div>
                        </div>
                        <!-- /.card header -->

                        <!-- card-body -->
                        <div class="card-body">
                            <table id="staff_transaction_list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Price Per Unit (RM)</th>
                                        <th>Quantity</th>
                                        <th>Total Sales (RM)</th>
                                        <th>Transaction Date</th>
                                        <th>Submitted Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try
                                    {
                                        $stmt = $conn->prepare("SELECT * FROM transaction t JOIN product p ON t.prod_id = p.prod_id JOIN staff s ON t.st_id = s.st_id WHERE t.st_id=:st_id");
                                        $stmt->execute(array(':st_id'=>$_SESSION['id']));
                                        $no = 0;
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                            $cell_prod_price = number_format((double)$row['prod_price'], 2, '.', '');
                                            $cell_total_sales = number_format((double)($row['prod_price']*$row['tr_qty']), 2, '.', '');
                                        ?>

                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td><?php echo $row['prod_name'];?></td>
                                        <td><span class="pull-right"><?php echo $cell_prod_price;?></span></td>
                                        <td><?php echo $row['tr_qty'];?> units</td>
                                        <td><span class="pull-right"><?php echo $cell_total_sales;?></span></td>
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
            <!-- / STAFF -->
            <?php } ?>
        </div><!-- /.container-fluid -->
    </section>
</div>

<?php
include '../includes/footer.php';
?>
<!-- Form Add Transactions -->
<div class="modal fade" id="addTransaction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Transaction</h4>
                <button class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="addTransaction_form" method="post" role="form" autocomplete="off">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="select_add_product">Product</label>
                                <select id="select_add_product" class="form-control" name="select_add_product">
                                    <?php echo fetchSelectProduct(); ?>
                                </select>
                                <input hidden type="text" id="add_prod_id" name="add_prod_id" class="form-control"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="disabled_prod_price">Price Per Unit (RM)</label>
                                <input disabled id="disabled_prod_price" class="form-control" value="" required>
                            </div>
                            <div class="col">
                                <label for="disabled_total_sales">Total Sales (RM)</label>
                                <input disabled class="form-control" id="disabled_total_sales" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="add_tr_qty">Quantity</label>
                                <input type="number" class="form-control" id="add_tr_qty" name="add_tr_qty" value=0
                                    min=0 required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="add_tr_date">Transaction Date</label>
                                <input type="datetime-local" class="form-control" id="add_tr_date" name="add_tr_date"
                                    required>
                                <input hidden id="add_tr_key_in" type="datetime-local" name="add_tr_key_in">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="disabled_st_id">Submitted by</label>
                                <input disabled id="disabled_st_id" class="form-control"
                                    value="<?php echo $_SESSION['username']; ?>">
                                <input hidden id="add_st_id" name="add_st_id" value="<?php echo $_SESSION['id']; ?>">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="insertTransaction" value="1">
                </form>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="addTransaction_btn" name="addTransaction_btn">Add</button>
            </div>
        </div>
    </div>
</div>

<!-- Form Edit Transactions -->
<div class="modal fade" id="editTransaction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Transaction</h4>
                <button class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="editTransaction_form" method="post" role="form" autocomplete="off">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <input hidden type="text" id="edit_tr_id" name="edit_tr_id" value="" required>
                                <label for="disabled_edit_product">Product</label>
                                <input disabled id="disabled_edit_product" class="form-control" value="">
                                <input hidden type="text" id="edit_prod_id" name="edit_prod_id" class="form-control"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="disabled_edit_prod_price">Price Per Unit (RM)</label>
                                <input disabled id="disabled_edit_prod_price" class="form-control" value="" required>
                            </div>
                            <div class="col">
                                <label for="disabled_edit_total_sales">Total Sales (RM)</label>
                                <input disabled class="form-control" id="disabled_edit_total_sales" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="edit_tr_qty">Quantity</label>
                                <input type="number" class="form-control" id="edit_tr_qty" name="edit_tr_qty" value=0
                                    min=0 required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="edit_tr_date">Transaction Date</label>
                                <input type="datetime-local" class="form-control" id="edit_tr_date" name="edit_tr_date"
                                    required>
                                <input hidden id="edit_tr_key_in" type="datetime-local" name="edit_tr_key_in">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="disabled_edit_st_id">Submitted by</label>
                                <input disabled id="disabled_edit_st_id" class="form-control"
                                    value="<?php echo $_SESSION['username']; ?>">
                                <input hidden id="edit_st_id" name="edit_st_id" value="<?php echo $_SESSION['id']; ?>">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="editTransaction" value="1">
                </form>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-warning" id="editTransaction_btn" name="editTransaction_btn">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {

    function getCurrentDateTime() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var hour = now.getHours();
        var minute = now.getMinutes();
        var today = now.getFullYear() + "-" + (month) + "-" + (day) + "T" + (hour) + ":" + (minute);
        return today;
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 1400,
    });
    // DataTables Admin
    var tableAdmin_id = "admin_transaction_list";
    $('#' + tableAdmin_id).find('*').click(function() {
        $('#' + tableAdmin_id + '_wrapper .row .dataTables_paginate .pagination').addClass(
        'pull-right');
    });
    var tableAdmin = $('#' + tableAdmin_id).DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false
    });

    // Custom script to fix searchbox styling 
    $('#' + tableAdmin_id + '_wrapper .row:first-child .col-sm-12:first-child').remove();
    var searchBoxAdminRow = $('#' + tableAdmin_id + '_wrapper .row:first-child .col-sm-12');
    searchBoxAdminRow.removeClass('col-md-6');
    searchBoxAdminRow.addClass('col-md-12');
    var searchBoxAdmin = $('#' + tableAdmin_id + '_wrapper .row:first-child .col-sm-12 #' + tableAdmin_id +
        '_filter label');
    searchBoxAdmin.children().unwrap();
    $('#' + tableAdmin_id).addClass('mt-1');
    $('#' + tableAdmin_id + '_wrapper .row .dataTables_paginate .pagination').addClass('pull-right');

    // DataTables Staff
    var tableStaff_id = "staff_transaction_list";
    $('#' + tableStaff_id).find('*').click(function() {
        $('#' + tableStaff_id + '_wrapper .row .dataTables_paginate .pagination').addClass(
        'pull-right');
    });
    var tableStaff = $('#' + tableStaff_id).DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false
    });
    $('#' + tableStaff_id + '_wrapper .row:first-child .col-sm-12:first-child').remove();

    // Custom script to fix searchbox styling
    var searchBoxStaffRow = $('#' + tableStaff_id + '_wrapper .row:first-child .col-sm-12');
    searchBoxStaffRow.removeClass('col-md-6');
    searchBoxStaffRow.addClass('col-md-12');
    var searchBoxStaff = $('#' + tableStaff_id + '_wrapper .row:first-child .col-sm-12 #' + tableStaff_id +
        '_filter label');
    searchBoxStaff.children().unwrap();
    $('#' + tableStaff_id).addClass('mt-1');
    $('#' + tableStaff_id + '_wrapper .row .dataTables_paginate .pagination').addClass('pull-right');

    // Add Transaction
    $('#addTransaction_btn').click(function(e) {
        e.preventDefault;
        $('#add_tr_key_in').val(getCurrentDateTime());

        /*
        alert("Product ID: " + $('#add_prod_id').val());
        alert("Staff ID: " + $('#add_st_id').val());
        alert("Quantity: " + $('#add_tr_qty').val());
        alert("Transaction Date: " + $('#add_tr_date').val());
        */

        if ($('#add_prod_id').val() && ($('#add_prod_id').val() != 'none') && $('#add_st_id').val() && $('#add_tr_qty').val() && $('#add_tr_date').val()) {
            var form_data = $('form#addTransaction_form').serialize();
            $.ajax({
                type: "POST",
                async: false,
                cache: false,
                url: "transactions.php",
                data: form_data,
                success: function(response) {
                    $('#addTransaction').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'New Transaction Added!'
                    }).then((result) => {
                        window.location.href = window.location.href.split("?")[0] //Remove All Parameter
                    });
                }
            })
        } else {
            Toast.fire({
                icon: 'error',
                title: 'Please Fill-In All The Empty Fields!'
            });
            return false;
        }
    });

    $('.add').click(function() {
        $('#addTransaction').modal('show');
    });
    $('#select_add_product').on("change", function() {
        var prod_id = $(this).find(':selected').val();
        var prod_price = $(this).find(':selected').data('price');
        $('#add_prod_id').val(prod_id);
        $('#disabled_prod_price').val(prod_price);
        $('#disabled_total_sales').val((prod_price * $("#add_tr_qty").val()).toFixed(2));
    });
    $('#add_tr_qty').on("change", function() {
        var prod_price = $('#disabled_prod_price').val();
        $('#disabled_total_sales').val((prod_price * $(this).val()).toFixed(2));
    });

    // Edit Button
    $('.edit').click(function() {
        var idTransaction = $(this).val();

        $.ajax({
            url: "transactions.php",
            method: "GET",
            data: "getTransaction&id=" + idTransaction,
            success: function(data) {
                data = $.parseJSON(data);

                if (data.message == 'found') {
                    $('#edit_tr_id').val(data.tr_id);
                    $('#disabled_edit_product').val(data.prod_name + " " + data.tr_id);
                    $('#edit_prod_id').val(data.prod_id);
                    $('#disabled_edit_prod_price').val((data.prod_price * 1).toFixed(2));
                    $('#edit_tr_qty').val(data.tr_qty);
                    $('#disabled_edit_total_sales').val((data.tr_qty * data.prod_price).toFixed(2));
                    $('#edit_tr_date').val((data.tr_date).replace(' ', 'T'));
                    $('#disabled_edit_st_id').val(data.st_username);
                    $('#edit_st_id').val(data.st_id);
                    $('#edit_tr_key_in').val(getCurrentDateTime());
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Invalid Transaction ID!'
                    });
                }
            }
        })
        $('#editTransaction').modal('show');
    });

    // Edit Transaction
    $('#editTransaction_btn').click(function(e) {
        e.preventDefault;
        $('#edit_tr_key_in').val(getCurrentDateTime());

        if ($('#edit_prod_id').val() && $('#edit_st_id').val() && $('#edit_tr_qty').val() && $('#edit_tr_date').val()) {
            var form_data = $('form#editTransaction_form').serialize();
            $.ajax({
                type: "POST",
                async: false,
                cache: false,
                url: 'transactions.php',
                data: form_data,
                success: function(response) {
                    $('#editTransaction').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Transaction Edited Successfully!'
                    }).then((result) => {
                        window.location.href = window.location.href.split("?")[0] //Remove All Parameter
                    });
                }
            })
        } else {
            Toast.fire({
                icon: 'error',
                title: 'Please Fill-In All The Empty Fields!'
            });
            return false;
        }
    });

    $('#edit_tr_qty').on("change", function() {
        var prod_price = $('#disabled_edit_prod_price').val();
        $('#disabled_edit_total_sales').val((prod_price * $(this).val()).toFixed(2));
    });

    // Delete Button
    $('.delete').click(function() {
        var idTransaction = $(this).val();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Deleted!',
                    icon: 'success',
                    showCancelButton: false
                }).then((result) => {
                    window.location.href = "transactions.php?deleteTransaction&id=" +
                        idTransaction;
                });
            }
        });
    });
});
</script>

<?php
    function fetchSelectProduct() {
        global $conn;
        $options = '<option selected val="none" disabled="disabled">No product available</option>';
        try
        {
            $stmt = $conn->prepare("SELECT * FROM product");
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $options = '<option selected val="none" disabled="disabled">Please select</option>';
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $formatted_prod_price = number_format((double)$row['prod_price'], 2, '.', '');
                    $options .= '<option value="'.$row['prod_id'].'" data-price="'.$formatted_prod_price.'">'.$row['prod_name'].' (RM'.$formatted_prod_price.')</option>';
                }
            }
        }
        catch(PDOException $e)
        {
            throw $e->getMessage();
        }
        return $options;
    }

?>

</body>

</html>