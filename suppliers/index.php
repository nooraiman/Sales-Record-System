<?php
$page_title = "SRS | Suppliers";
include '../includes/header.php';
?>
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Suppliers</h1>
                    </div><!-- /.col-sm-6 -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a>Suppliers</a></li>
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
                                <h3 class="card-title">Supplier Details</h3>
                            </div>
                            <!-- /.card header -->

                            <!-- card-body -->
                            <div class="card-body">
                                <table id="supplier_list" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Supplier ID</th>
                                            <th>Supplier Name</th>
                                            <th>Supplier Phone</th>
                                            <th>Supplier Email</th>

                                            <?php if($_SESSION['role'] == 'Admin') {?>
                                            <th>Action</th>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    try
                                    {
                                        $stmt = $conn->prepare("SELECT * FROM supplier");
                                        $stmt->execute();

                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                        ?>

                                        <tr>
                                            <td><?php echo $row['su_id'];?></td>
                                            <td><?php echo $row['su_name'];?></td>
                                            <td><?php echo $row['su_phone'];?></td>
                                            <td><?php echo $row['su_email'];?></td>

                                            <?php if($_SESSION['role'] == 'Admin') {?>
                                            <td>
                                                <button class = "edit btn btn-sm btn-success" value="<?php echo $row['su_id'];?>">Edit</button>
                                                <button class="delete btn btn-sm btn-danger" value="<?php echo $row['su_id'];?>">Delete</button>
                                            </td>
                                            <?php } ?>

                                        </tr>
                                        <?php
                                        }
                                    }
                                    catch(PDOException $e)
                                    {
                                        throw $e;
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

    <?php if($_SESSION['role'] == 'Admin') 
    {
    ?>

    <div class="modal fade" id="addSupplier">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Supplier</h4>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">
                        <form id="addSupplier_form" method="post" role="form" autocomplete="off">
                        <div class="form-group">
                            <label for="supplierName">Supplier Name:</label>
                            <input type="text" id="supplierName" name="supplierName" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="supplierPhone">Supplier Phone:</label>
                            <input type="text" id="supplierPhone" name="supplierPhone" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="supplierEmail">Supplier Email:</label>
                            <input type="text" id="supplierEmail" name="supplierEmail" class="form-control" autocomplete="off" required>
                        </div>
                        <input type="hidden" name="insertSupplier" value="1">
                        </form>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="addSupplier_btn" name="addSupplier_btn">Add</button>
                    </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSupplier">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Supplier</h4>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">
                        <form id="editSupplier_form" method="post" role="form" autocomplete="off">
                        <div class="form-group">
                            <label for="EsupplierName">Supplier Name:</label>
                            <input type="hidden" id="EsupplierID" name="EsupplierID" class="form-control">
                            <input type="text" id="EsupplierName" name="EsupplierName" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="EsupplierPhone">Supplier Phone:</label>
                            <input type="text" id="EsupplierPhone" name="EsupplierPhone" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="EsupplierEmail">Supplier Email:</label>
                            <input type="text" id="EsupplierEmail" name="EsupplierEmail" class="form-control" autocomplete="off">
                        </div>
                        <input type="hidden" name="editSupplier" value="1">
                        </form>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="editSupplier_btn" name="editSupplier_btn">Edit</button>
                    </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>

<?php
include '../includes/footer.php';
?>


    <script>
    $(document).ready(function() {

        <?php if($_SESSION['role'] == 'Admin') {?>
        // Edit Button
        $('.edit').click(function() {
            var idSupplier = $(this).val();

            $.ajax({
                url: "suppliers.php",
                method: "GET",
                async: true,
                cache: false,
                data: "getSupplier&id=" + idSupplier,
                success: function(data) {
                    data = $.parseJSON(data);

                    if(data.message == 'found')
                    {
                        $('#EsupplierID').val(data.su_id);
                        $('#EsupplierName').val(data.su_name);
                        $('#EsupplierPhone').val(data.su_phone);
                        $('#EsupplierEmail').val(data.su_email);
                    }
                    else
                    {
                        Toast.fire({
                            icon: 'error',
                            title: 'Invalid Supplier ID!'
                        });
                    }
                }
            })
            $('#editSupplier').modal('show');
        });

        // Delete Button
        $('.delete').click(function() {
            var idSupplier = $(this).val();
            
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
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        url: "suppliers.php",
                        data: "deleteSupplier&id=" + idSupplier,
                        success: function(response) {
                            if(response.trim() == "success")
                            {
                                Toast.fire({
                                        icon: 'success',
                                        title: 'Supplier Has Been Deleted!'
                                })
                                .then((result) => {
                                    window.location.href = window.location.toString();
                                });
                            }
                        }
                    })
                }
            });
        });

        // Submit Form - Add Supplier
        $('#addSupplier_btn').click(function(e) {
            e.preventDefault;

            if($('#supplierName').val() && $('#supplierPhone').val() && $('#supplierEmail').val())
            {
                var form_data = $('form#addSupplier_form').serialize();
                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    url: "suppliers.php",
                    data: form_data,
                    success: function(response) {
                        $('#addSupplier').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Supplier Has Been Added!'
                        }).then((result) => {
                            window.location.href = window.location.toString();
                        });
                    }
                })
            }
            else
            {
                Toast.fire({
                    icon: 'error',
                    title: 'Please Fill-In All The Empty Fields!'
                });
                return false;
            }
        });

        // Submit Form - Edit Supplier
        $('#editSupplier_btn').click(function(e){
            e.preventDefault;

            if($('#EsupplierName').val() && $('#EsupplierPhone').val() && $('#EsupplierEmail').val())
            {
                var form_data = $('form#editSupplier_form').serialize();
                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    url: 'suppliers.php',
                    data: form_data,
                    success: function(response) {
                        $('#editSupplier').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Supplier Has Been Updated!'
                        }).then((result) => {
                            window.location.href = window.location.toString();
                        });
                    }
                })
            }
            else
            {
                Toast.fire({
                    icon: 'error',
                    title: 'Please Fill-In All The Empty Fields!'
                });
                return false;
            }
        });

        <?php
        }
        ?>

        // DataTables
        var table = $('#supplier_list').DataTable({
            <?php if($_SESSION['role'] == 'Admin') {?>
            dom: '<"row" <"col-sm-12 col-md-6" <"pull-left"B>> <"col-sm-12 col-md-6" <"pull-right"f>> >' + '<"row" <"col-12" t> >' + '<"row" <"col-sm-12 col-md-6" i> <"col-sm-12 col-md-6" <"pull-right"p>> >',
            buttons: [
                {
                    text:'Add Supplier',
                    className: 'btn-primary',
                    action: function(e, node, config) {
                        $('#addSupplier').modal('show');
                    },
                    init: function(api,node,config) {
                        $(node).removeClass('btn-secondary')
                    }
                },
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [4]}
            ],
            <?php 
            }
            else { ?>
            dom: '<"row" <"col-sm-12 col-md-12" <"pull-right"f>> >' + '<"row" <"col-12" t> >' + '<"row" <"col-sm-12 col-md-6" i> <"col-sm-12 col-md-6" <"pull-right"p>> >',
            <?php } ?>
            "pageLength": '10',
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        });
        //table.buttons().container().appendTo('#supplier_list_wrapper .col-md-6:eq(0)');
    })
    </script>
</body>
</html>