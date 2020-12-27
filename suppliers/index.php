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
                                                <a href = "suppliers.php?deleteSupplier&id=<?php echo $row['su_id'];?>"><button class="btn btn-sm btn-danger">Delete</button></a>
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

                <form id="addSupplier_form" name="addSupplier_form" role="form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="supplierName">Supplier Name:</label>
                            <input type="text" name="supplierName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="supplierPhone">Supplier Phone:</label>
                            <input type="text" name="supplierPhone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="supplierEmail">Supplier Email:</label>
                            <input type="text" name="supplierEmail" class="form-control">
                        </div>
                        <input type="hidden" name="insertSupplier" value="1">
                    </div>

                    <div class="modal-footer justify-content-between">
                        <!-- <button class="btn btn-default" data-dismiss="modal">Close</button> -->
                        <button class="btn btn-primary" name="addSupplier_btn">Add</button>
                    </div>
                </form>
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
                <form id="editSupplier_form" name="editSupplier_form" role="form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="EsupplierName">Supplier Name:</label>
                            <input type="hidden" id="EsupplierID" name="EsupplierID" class="form-control">
                            <input type="text" id="EsupplierName" name="EsupplierName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="EsupplierPhone">Supplier Phone:</label>
                            <input type="text" id="EsupplierPhone" name="EsupplierPhone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="EsupplierEmail">Supplier Email:</label>
                            <input type="text" id="EsupplierEmail" name="EsupplierEmail" class="form-control">
                        </div>
                        <input type="hidden" name="editSupplier" value="1">
                    </div>

                    <div class="modal-footer justify-content-between">
                        <!-- <button class="btn btn-default" data-dismiss="modal">Close</button> -->
                        <button class="btn btn-primary" name="editSupplier_btn">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
include '../includes/footer.php';
?>
    <script>
    //Add Supplier
    function addSupplier() {
        $.ajax({
            type: "POST",
            url: "suppliers.php",
            cache: false,
            data: $('form#addSupplier_form').serialize(),
            success: function(response) {
                if(response == 'success')
                {
                    alert('[Success] Supplier Has Been Added');
                    window.location.href =  window.location.href.split("?")[0]  //Remove All Parameter
                }
                
            },
            error: function(response) {
                console.log(response);
            }
        })
    }

    //Edit Supplier
    function editSupplier() {
        $.ajax({
            type: "POST",
            url: "suppliers.php",
            cache: false,
            data: $('form#editSupplier_form').serialize(),
            success: function(response) {
                if(response == 'success')
                {
                    alert(['[Success] Supplier Has Been Updated!']);
                    window.location.href =  window.location.href.split("?")[0]  //Remove All Parameter
                }
            }
        })
    }
    </script>

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

        // Form Submit - Add Supplier
        $('#addSupplier_form').submit(function(event) {
            if($("[name='supplierName']").val() != '' && $("[name='supplierPhone']").val() != '' && $("[name='supplierEmail']").val() != '')
            {
                addSupplier();
            }
            else
            {
                alert('Please Fill-In All The Fields!');
                return false;
            }
        });

        //Form Submit - Edit Supplier
        $('#editSupplier_form').submit(function(event) {
            if($("[name='EsupplierName']").val() != '' && $("[name='EsupplierPhone']").val() != '' && $("[name='EsupplierEmail']").val() != '')
            {
                editSupplier();
            }
            else
            {
                alert('Please Fill-In All The Fields!');
                return false;
            }
        });

        // DataTables
        var table = $('#supplier_list').DataTable({
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
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false
        });
        table.buttons().container().appendTo('#supplier_list_wrapper .col-md-6:eq(0)');
    })
    </script>
</body>
</html>