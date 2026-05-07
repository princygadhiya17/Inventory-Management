<?php
include("config.php");
include("check_session.php");

?>
<!DOCTYPE html>
<html lang="en">
<?php include("header.php"); ?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="./plugins/toastr/toastr.min.css">

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include("navbar.php"); ?>

        <!-- Main Sidebar -->
        <?php include("sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Categories</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Categories</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php if (isset($_GET['alert'])) { ?>
                            <div class="col-md-12">
                                <div class="alert alert-<?php echo $_GET['alert']; ?>" role="alert">
                                    <?php echo $_GET['msg']; ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <!-- <h3 class="card-title">DataTable with default features</h3> -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="card-title">Category List</h3>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="button" id="addnew" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
                                                <i class="fas fa-plus"></i> ADD Category
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-striped table-hover" style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Category Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $result = mysqli_query($conn, "select * from category");
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $statusText = $row['status'] == 1 ? "checked" : "";
                                                echo "<tr>
                                            <td><img src='upload/category/{$row['image']}' width='50' height='50'></td>
                                            <td>{$row['name']}</td>
                                            <td>
                                            <input type='checkbox'  id='status_" . $row['id'] . "'  data-toggle='toggle' statusid='" . $row['id'] . "' class='statuschange' $statusText>
                                         </td>
                                            <td>
                                                <div class='btn-group' role='group'>
                                                    " . '<button class="btn btn-sm btn-outline-primary m-2 editBtn" data-id="' . $row['id'] . '" >Edit</button>' . "
                                                    " . '<button class="btn btn-sm btn-outline-danger m-2 deleteBtn" data-id="' . $row['id'] . '" >Delete</button>' . "
                                                </div>
                                            </td>

                                            </tr>";
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <div class="modal fade" id="modal-lg">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">ADD Category</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="categoryForm" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="0">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="file">Logo</label>
                                            <input type="file" id="file" name="image" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="categoryname">Category Name</label>
                                            <input type="text" id="categoryname" name="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" id="saveCategory" class="btn btn-primary">Save Category</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
                <!-- /.modal -->
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    </div>
    <?php
    include("footer.php");
    ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="./plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins\moment\moment.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="./plugins/toastr/toastr.min.js"></script>
    <script src="./plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte2167.js?v=3.2.0"></script>
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.statuschange').change(function() {
                var statusid = $(this).attr('statusid');
                if (this.checked != true) {
                    updateStatus(0, statusid);
                } else {
                    updateStatus(1, statusid);
                }
            });

            function updateStatus(status_val, id) {
                $.ajax({
                    type: "POST",
                    url: "updatestatus.php",
                    data: {
                        id: id,
                        status: status_val,
                        action: 'category'
                    },
                    success: function(response) {
                        if (response.status == true) {
                            if (status_val == 1) {
                                // toastr.success(response.message);
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                            } else {
                                // toastr.error(response.message);
                                Toast.fire({
                                    icon: 'error',
                                    title: response.message
                                });
                            }
                        }
                    }
                });
            }
        });

        $(document).on("click", ".deleteBtn", function() {
            let id = $(this).data("id");

            Swal.fire({
                title: "Are you sure?",
                text: "are you sure you want to delete this record !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "POST",
                        url: "delete.php",
                        data: {
                            id: id,
                            action: 'category'
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success",
                                }).then(() => {
                                    location.reload();
                                });

                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to delete record!",
                                    icon: "error",
                                });
                            }
                        }
                    });

                }
            });
        });


        $(function() {
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });

        $("#addnew").click(function() {
            document.getElementById("categoryForm").reset();
        });
        $("#categoryForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            let formData = new FormData($("#categoryForm")[0]);

            $.ajax({
                url: "add_category.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    if (response.status == true) {
                        alert(response.message);
                        $("#modal-lg").modal("hide");
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
        $(document).on("click", ".editBtn", function() {
            let id = $(this).data("id");
            $.ajax({
                url: "add_category.php",
                type: "POST",
                data: {
                    edit_id: id
                },
                dataType: "json",
                success: function(res) {
                    var res = res.detail;
                    $("input[name=id]").val(res.id);
                    $("#categoryname").val(res.name);
                    $("#modal-lg").modal("show");
                }
            });

        });
    </script>


</body>

<!-- , Sat, 29 Nov 2025 06:35:23 GMT -->

</html>