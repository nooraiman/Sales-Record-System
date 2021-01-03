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
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Transactions</h1>
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
                                <h3 class="card-title">All Transaction Details</h3>
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
                                        <th>Submitted Date</th>
                                        <?php if(isAdmin()) { ?>
                                        <th style="width: 150px;">Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try
                                    {
                                        if(isAdmin()) {
                                            $stmt = $conn->prepare("SELECT * FROM transaction t JOIN product p ON t.prod_id = p.prod_id JOIN staff s ON t.st_id = s.st_id");
                                            $stmt->execute();
                                        } else {
                                            $stmt = $conn->prepare("SELECT * FROM transaction t JOIN product p ON t.prod_id = p.prod_id JOIN staff s ON t.st_id = s.st_id WHERE t.st_id=:st_id");
                                            $stmt->execute(array(':st_id'=>$_SESSION['id']));
                                        }
                                        
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
                                        <td><?php echo $row['tr_qty'];?> unit(s)</td>
                                        <td><span class="pull-right"><?php echo $cell_total_sales;?></span></td>
                                        <td><?php echo $row['tr_date'];?></td>
                                        <td><?php echo $row['tr_key_in'];?> 
                                            <?php if(isAdmin()) { ?>
                                            <br>by <a href="#" title="<?php echo $row['st_name'];?>"><?php echo $row['st_username'];?></a>
                                            <?php } ?>
                                        </td>
                                        <?php if(isAdmin()) { ?>
                                        <td class="dt-center">
                                            <button class="edit btn btn-sm btn-success"
                                                value="<?php echo $row['tr_id'];?>">Edit</button>
                                            <button class="delete btn btn-sm btn-danger"
                                                value="<?php echo $row['tr_id'];?>">Delete</button>
                                        </td>
                                        <?php } ?>
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

    <!-- Form Add Transactions -->
    <div class="modal fade" id="addTransaction">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Transaction</h4>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                    <input type="datetime-local" class="form-control" id="add_tr_date" name="add_tr_date" required>
                                    <input hidden type="datetime-local" id="add_tr_key_in" name="add_tr_key_in" required>
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

    <?php if(isAdmin()) {?>

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
                    <button class="btn btn-primary" id="editTransaction_btn" name="editTransaction_btn">Edit</button>
                </div>
            </div>
        </div>
    </div>
    
    <?php } ?>

<?php
include '../includes/footer.php';
?>

    <script>
    $(document).ready(function() {

        function getCurrentDateTime() {
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var hour = ("0" + now.getHours()).slice(-2);
        var minute = ("0" + now.getMinutes()).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day) + "T" + (hour) + ":" + (minute);
        return today;
        }
        
        <?php if(isAdmin()) {?>

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
                        $('#disabled_edit_product').val(data.prod_name);
                        $('#edit_prod_id').val(data.prod_id);
                        $('#disabled_edit_prod_price').val((data.prod_price * 1).toFixed(2));
                        $('#edit_tr_qty').val(data.tr_qty);
                        $('#disabled_edit_total_sales').val((data.tr_qty * data.prod_price).toFixed(2));
                        $('#edit_tr_date').val((data.tr_date).replace(' ', 'T'));
                        $('#disabled_edit_st_id').val(data.st_username);
                        $('#edit_st_id').val(data.st_id);
                        $('#edit_tr_key_in').val((data.tr_key_in).replace(' ','T'));
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Invalid Transaction ID!'
                        });
                    }
                }
            });

            $('#editTransaction').modal('show');
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
                })
                .then((result) => {
                   if(result.value) {
                       $.ajax({
                           type: "POST",
                           async: false,
                           cache: false,
                           url: "transactions.php",
                           data: "deleteTransaction&id="+idTransaction,
                           success: function(response) {
                                if(response.trim() == "success")
                                {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Transaction Has Been Deleted!'
                                    })
                                    .then((result) => {
                                        window.location.href = window.location.href.split('?')[0];
                                    });
                                }
                           }
                       })
                   }
            });
        })

        <?php } ?>

        // Submit Form - Add Transaction
        $('#addTransaction_btn').click(function(e) {
            e.preventDefault;
            $('#add_tr_key_in').val(getCurrentDateTime());

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
            }
            else {
                Toast.fire({
                    icon: 'error',
                    title: 'Please Fill-In All The Empty Fields!'
                });
                return false;
            }
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

        <?php if(isAdmin()) {?>

        // Submit Form - Edit Transaction
        $('#editTransaction_btn').click(function(e) {
            e.preventDefault;

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
                            window.location.href = window.location.href.split("?")[0]; //Remove All Parameter
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

        <?php } ?>
        
        // DataTables
        var table = $('#transaction_list').DataTable({
            dom: '<"row" <"col-sm-12 col-md-6" <"pull-left"B>> <"col-sm-12 col-md-6" <"pull-right"f>> >' + '<"row" <"col-12" t> >' + '<"row" <"col-sm-12 col-md-6" i> <"col-sm-12 col-md-6" <"pull-right"p>> >',
            buttons: [
                    {
                        text:'Add Transaction',
                        className: 'btn-primary',
                        action: function(e, node, config) {
                            $('#addTransaction').modal('show');
                        },
                        init: function(api,node,config) {
                            $(node).removeClass('btn-secondary')
                        }
                    },
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