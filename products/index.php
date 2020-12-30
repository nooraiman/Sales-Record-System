<?php
$page_title = "SRS | Products";
include '../includes/header.php';
?>
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Products</h1>
                    </div><!-- /.col-sm-6 -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a>Products</a></li>
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
                                <h3 class="card-title">Product Details</h3>
                            </div>
                            <!-- /.card header -->

                            <!-- card-body -->
                            <div class="card-body">
                                <table id="product_list" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Product Price (RM)</th>
                                            <th>Supplier Name</th>

                                            <?php if($_SESSION['role'] == 'Admin') {?>
                                            <th>Action</th>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    try
                                    {
                                        $stmt = $conn->prepare("SELECT * FROM product p JOIN supplier s ON p.su_id = s.su_id");
                                        $stmt->execute();

                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                            $formatted_prod_price = number_format((double)$row['prod_price'], 2, '.', '');
                                        ?>

                                        <tr>
                                            <td><?php echo $row['prod_id'];?></td>
                                            <td><?php echo $row['prod_name'];?></td>
                                            <td class="text-right"><?php echo $formatted_prod_price;?></td>
                                            <td><?php echo $row['su_name'];?></td>

                                            <?php if($_SESSION['role'] == 'Admin'){?>
                                            <td>
                                                <button class = "edit btn btn-sm btn-success" value="<?php echo $row['prod_id'];?>">Edit</button>
                                                <button class="delete btn btn-sm btn-danger" value="<?php echo $row['prod_id'];?>">Delete</button>
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

    <?php
    if($_SESSION['role'] == 'Admin')
    {
    ?>

    <div class="modal fade" id="addProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Product</h4>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">
                        <form id="addProduct_form" method="post" role="form" autocomplete="off">
                        <div class="form-group">
                            <label for="productName">Product Name:</label>
                            <input type="text" id="productName" name="productName" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Product Price (RM):</label>
                            <input type="number" id="productPrice" name="productPrice" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="supplier">Supplier:</label>
                            <select name="supplier" id="supplier" class="form-control">
                                <option value="" selected disabled>-- Chose Supplier --</option>
                                <?php
                                $querySUP = $conn->prepare("SELECT * FROM supplier");
                                $querySUP->execute();
                                while($dataSUP = $querySUP->fetch(PDO::FETCH_ASSOC))
                                {
                                ?>
                                <option value="<?php echo $dataSUP['su_id'];?>"><?php echo $dataSUP['su_name'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="insertProduct" value="1">
                        </form>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="addProduct_btn" name="addProduct_btn">Add</button>
                    </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="editProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Product</h4>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">
                        <form id="editProduct_form" method="post" role="form" autocomplete="off">
                        <div class="form-group">
                            <label for="EproductName">Product Name:</label>
                            <input type="hidden" id="EproductID" name="EproductID" class="form-control">
                            <input type="text" id="EproductName" name="EproductName" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="EproductPrice">Product Price (RM):</label>
                            <input type="number" id="EproductPrice" name="EproductPrice" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="Esupplier">Supplier:</label>
                            <select name="Esupplier" id="Esupplier" class="form-control">
                                <option id="default" value="" selected readonly></option>
                                <?php
                                $querySUP = $conn->prepare("SELECT * FROM supplier");
                                $querySUP->execute();
                                while($dataSUP = $querySUP->fetch(PDO::FETCH_ASSOC))
                                {
                                ?>
                                <option value="<?php echo $dataSUP['su_id'];?>"><?php echo $dataSUP['su_name'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="editProduct" value="1">
                        </form>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="editProduct_btn" name="editProduct_btn">Edit</button>
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
    $(document).ready(function () {
        <?php
        if($_SESSION['role'] == 'Admin')
        {
        ?>
        // Edit Button
        $('.edit').click(function() {
            var idProduct = $(this).val();

            $.ajax({
                url: "products.php",
                method: "GET",
                data: "getProduct&id=" + idProduct,
                success: function(data) {
                    data = $.parseJSON(data);

                    if(data.message == "found")
                    {
                        $('#EproductID').val(data.prod_id);
                        $('#EproductName').val(data.prod_name);
                        $('#EproductPrice').val((data.prod_price * 1).toFixed(2));
                        $('#default').val(data.su_id);
                        $('#default').html(data.su_name);
                    }
                }
            });
            $('#editProduct').modal('show');
        });

        // Delete Button
        $('.delete').click(function() {
            var idProduct = $(this).val();

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
                    Toast.fire({
                        icon: 'success',
                        title: 'Product Has Been Deleted!'
                    }).then((result) => {
                        window.location.href = "products.php?deleteProduct&id=" + idProduct;
                    });
                    
                }
            });
        })

        // Submit Form - Add Supplier
        $('#addProduct_btn').click(function(e) {
            e.preventDefault;

            $('#productPrice').val(($('#productPrice').val()*1).toFixed(2));

            // Empty Field Validation
            if($('#productName').val() && $('#productPrice').val() && $('#supplier').val())
            {
                var form_data = $('form#addProduct_form').serialize();

                $.ajax({
                    type: "POST",
                    async: false,
                    cache: false,
                    url: "products.php",
                    data: form_data,
                    success: function(response) {
                        console.log(response);
                        if(response.trim() == "success")
                        {
                            $('#addProduct').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: 'Product Has Been Added!'
                            }).then((result) => {
                                window.location.href =  window.location.href.split("?")[0]  //Remove All Parameter
                            });
                        }
                        else
                        {
                            Toast.fire({
                                icon: 'error',
                                title: 'Product Has Not Been Added!'
                            });
                        }
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

        // Submit Form - Edit Product
        $('#editProduct_btn').click(function(e) {
            e.preventDefault;
            $('#EproductPrice').val(($('#EproductPrice').val()*1).toFixed(2));

            // Empty Field Validation
            if($('#EproductName').val() && $('#EproductPrice').val() && $('#Esupplier').val())
            {
                var form_data = $('form#editProduct_form').serialize();

                $.ajax({
                    type: "POST",
                    async: false,
                    cache: false,
                    url: "products.php",
                    data: form_data,
                    success: function(response) {
                        console.log(response);
                        if(response.trim() == "success")
                        {
                            $('#editProduct').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: 'Product Has Been Updated!'
                            }).then((result) => {
                                window.location.href =  window.location.href.split("?")[0]  //Remove All Parameter
                            });
                        }
                        else
                        {
                            Toast.fire({
                                icon: 'error',
                                title: 'Product Has Not Been Updated!'
                            });
                        }
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
        var table = $('#product_list').DataTable({
            <?php if($_SESSION['role'] == 'Admin') {?>
            dom: '<"row" <"col-sm-12 col-md-6" <"pull-left"B>> <"col-sm-12 col-md-6" <"pull-right"f>> >' + '<"row" <"col-12" t> >' + '<"row" <"col-sm-12 col-md-6" i> <"col-sm-12 col-md-6" <"pull-right"p>> >',
            buttons: [
                {
                    text:'Add Product',
                    className: 'btn-primary',
                    action: function(e, node, config) {
                        $('#addProduct').modal('show');
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
    })
    </script>
</body>
</html>