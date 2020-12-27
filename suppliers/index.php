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
                                            <th>Action</th>
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
                                            <td>
                                                <button class = "edit btn btn-sm btn-success" value="<?php echo $row['su_id'];?>">Edit</button>
                                                <button class="delete btn btn-sm btn-danger" value="<?php echo $row['su_id'];?>">Delete</button>
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
                <!-- / Main -->
            </div><!-- /.container-fluid -->
        </section>
    </div>

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
include '../includes/footer.php';
?>


    <script>
    $(document).ready(function() {
        // Edit Button
        $('.edit').click(function() {
            var idSupplier = $(this).val();

            $.ajax({
                url: "suppliers.php",
                method: "GET",
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
                        alert("Invalid Supplier ID!")
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
                    window.location.href = "suppliers.php?deleteSupplier&id=" + idSupplier;
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
                    async: false,
                    cache: false,
                    url: "suppliers.php",
                    data: form_data,
                    success: function(response) {
                        window.alert(['[Success] Supplier Has Been Added!']);
                        window.location.href =  window.location.href.split("?")[0]  //Remove All Parameter
                    }
                })
            }
            else
            {
                alert("Please Fill-In All The Empty Fields!");
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
                    async: false,
                    cache: false,
                    url: 'suppliers.php',
                    data: form_data,
                    success: function(response) {
                        window.alert(['[Success] Supplier Has Been Updated!']);
                        window.location.href =  window.location.href.split("?")[0]  //Remove All Parameter
                    }
                })
            }
            else
            {
                alert("Please Fill-In All The Empty Fields!");
                return false;
            }
        });

        // DataTables
        var table = $('#supplier_list').DataTable({
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