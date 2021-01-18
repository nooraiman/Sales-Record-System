<?php
$page_title = "SRS | Manage Staffs";
include '../includes/header.php';

if($_SESSION['role'] != 'Admin')
{
    echo "<script>alert('You Have No Access To This Module!');window.location = '../';</script>";
    die();
}
?>
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Staffs</h1>
                    </div><!-- /.col-sm-6 -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a>Staffs</a></li>
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
                                <h3 class="card-title">Staff Details</h3>
                            </div>
                            <!-- /.card header -->

                            <!-- card-body -->
                            <div class="card-body">
                                <table id="staff_list" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Staff ID</th>
                                            <th>Staff Username</th>
                                            <th>Staff Name</th>
                                            <th>Staff Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    try
                                    {
                                        $stmt = $conn->prepare("SELECT s.st_id, s.st_username, s.st_name, s.st_email, l.ro_id, r.ro_name FROM staff s JOIN login l ON s.st_id = l.st_id JOIN role r ON l.ro_id = r.ro_id ORDER BY l.ro_id ASC");
                                        $stmt->execute();

                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                        ?>

                                        <tr>
                                            <td><?php echo $row['st_id'];?></td>
                                            <td><?php echo $row['st_username'];?></td>
                                            <td><?php echo $row['st_name'];?></td>
                                            <td><?php echo $row['st_email'];?></td>
                                            <td><?php echo $row['ro_name'];?></td>

                                            <td>
                                                <button class="edit btn btn-sm btn-success" value="<?php echo $row['st_id'];?>">Edit</button>
                                                <button class="delete btn btn-sm btn-danger" value="<?php echo $row['st_id'];?>">Delete</button>
                                            </td>

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
    
    <div class="modal fade" id="addStaff">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Staff</h4>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">
                        <form id="addStaff_form" method="post" role="form" autocomplete="off">
                        <div class="form-group">
                            <label for="staffID">Staff ID:</label>
                            <input type="text" id="staffID" name="staffID" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="staffUsername">Staff Username:</label>
                            <input type="text" id="staffUsername" name="staffUsername" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="staffName">Staff Name:</label>
                            <input type="text" id="staffName" name="staffName" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="staffPassword">Staff Password:</label>
                            <div class="input-group">
                            <input type="password" id="staffPassword" name="staffPassword" class="form-control" autocomplete="off" required>
                                <span class="input-group-append">
                                    <button type="button" class="togglePass btn btn-info btn-sm">Show</button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="staffEmail">Staff Email:</label>
                            <input type="text" id="staffEmail" name="staffEmail" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Staff Role:</label>
                            <select name="role" id="role" class="form-control">
                                <option value="" selected disabled>-- Choose Role --</option>
                                <?php
                                $qryRole = $conn->prepare("SELECT * FROM role");
                                $qryRole->execute();
                                while($dataRole = $qryRole->fetch(PDO::FETCH_ASSOC))
                                {
                                ?>
                                <option value="<?php echo $dataRole['ro_id'];?>"><?php echo $dataRole['ro_name'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="insertStaff" value="1">
                        </form>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="addStaff_btn" name="addStaff_btn">Add</button>
                    </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editStaff">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Staff</h4>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">
                        <form id="editStaff_form" method="post" role="form" autocomplete="off">
                        <div class="form-group">
                            <label for="EstaffID">Staff ID:</label>
                            <input type="text" id="EstaffID" name="EstaffID" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="EstaffUsername">Staff Username:</label>
                            <input type="text" id="EstaffUsername" name="EstaffUsername" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="EstaffName">Staff Name:</label>
                            <input type="text" id="EstaffName" name="EstaffName" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="EstaffPassword">Staff Password:</label>
                            <div class="input-group">
                            <input type="password" id="EstaffPassword" name="EstaffPassword" class="form-control" autocomplete="off">
                                <span class="input-group-append">
                                    <button type="button" class="togglePass btn btn-info btn-sm">Show</button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="EstaffEmail">Staff Email:</label>
                            <input type="text" id="EstaffEmail" name="EstaffEmail" class="form-control" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="Erole">Staff Role:</label>
                            <select name="Erole" id="Erole" class="form-control">
                                <option id="defaultRole" value="" selected>-- Choose Role --</option>
                                <?php
                                $qryRole = $conn->prepare("SELECT * FROM role");
                                $qryRole->execute();
                                while($dataRole = $qryRole->fetch(PDO::FETCH_ASSOC))
                                {
                                ?>
                                <option value="<?php echo $dataRole['ro_id'];?>"><?php echo $dataRole['ro_name'];?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="editStaff" value="1">
                        </form>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="editStaff_btn" name="editStaff_btn">Edit</button>
                    </div>
            </div>
        </div>
    </div>
<?php
include '../includes/footer.php';
?>
    <script>
    $(document).ready(function() {
        // Toggle Password
        $('.togglePass').click(function() {
            var x = $('#staffPassword');

            if(x.attr('type') == 'password') {
                x.attr('type','text');
            }
            else {
                x.attr('type','password');
            }
        })

        // Edit Button
        $('.edit').click(function() {
            var idStaff = $(this).val();

            $.ajax({
                url: "staffs.php",
                method: "GET",
                async: true,
                cache: false,
                data: "getStaff&id=" + idStaff,
                success: function(data) {
                    data = $.parseJSON(data);

                    if(data.message == 'found') {

                        $('#EstaffID').val(data.st_id);
                        $('#EstaffUsername').val(data.st_username);
                        $('#EstaffName').val(data.st_name);
                        $('#EstaffEmail').val(data.st_email);

                        $('#defaultRole').val(data.ro_id);
                        $('#defaultRole').html(data.ro_name);

                        $('#editStaff').modal('show');
                    }
                    else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Invalid Staff ID!'
                        });
                    }
                }
            })
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
                        url: "staffs.php",
                        data: "deleteStaff&id=" + idSupplier,
                        success: function(response) {
                            if(response.trim() == "success")
                            {
                                Toast.fire({
                                        icon: 'success',
                                        title: 'Staff Has Been Deleted!'
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

        // Submit Form - Add Staff
        $('#addStaff_btn').click(function(e) {
            e.preventDefault;

            if($('#staffID').val() && $('#staffUsername').val() && $('#staffName').val() && $('#staffPassword').val() && $('#staffEmail').val() && $('#role').val())
            {
                var form_data = $('form#addStaff_form').serialize();
                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    url: "staffs.php",
                    data: form_data,
                    success: function(response) {
                        if(response == 'success')
                        {
                            $('#addStaff').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: 'Staff Has Been Added!'
                            }).then((result) => {
                                window.location.href = window.location.toString();
                            });
                        }
                        else if(response == "exist")
                        {
                            Toast.fire({
                                icon: 'error',
                                title: 'Staff Already Existed!'
                            })
                        }
                        else
                        {
                            Toast.fire({
                                icon: 'error',
                                title: 'Staff Has Not Been Added!'
                            })
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

        // Submit Form - Edit Supplier
        $('#editStaff_btn').click(function(e){
            e.preventDefault;

            if($('#EstaffID').val() && $('#EstaffUsername').val() && $('#EstaffName').val() && $('#EstaffEmail').val() && $('#Erole').val())
            {
                var form_data = $('form#editStaff_form').serialize();

                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    url: 'staffs.php',
                    data: form_data,
                    success: function(response) {
                        if(response == 'success')
                        {
                            $('#editStaff').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: 'Staff Has Been Updated!'
                            }).then((result) => {
                                window.location.href = window.location.toString();
                            });
                        }
                        else
                        {
                            Toast.fire({
                            icon: 'error',
                            title: 'Staff Has Not Been Updated!'
                            })
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

        //DataTables
        var table = $('#staff_list').DataTable({
            dom: '<"row" <"col-sm-12 col-md-6" <"pull-left"B>> <"col-sm-12 col-md-6" <"pull-right"f>> >' + '<"row" <"col-12" t> >' + '<"row" <"col-sm-12 col-md-6" i> <"col-sm-12 col-md-6" <"pull-right"p>> >',
            buttons: [
                {
                    text:'Add Staff',
                    className: 'btn-primary',
                    action: function(e, node, config) {
                        $('#addStaff').modal('show');
                    },
                    init: function(api,node,config) {
                        $(node).removeClass('btn-secondary')
                    }
                },
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [5]}
            ],
            "order": [
                [4, "asc"]
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