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
                            <h1>Payments</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Payment In</li>
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
                                            <h3 class="card-title">Payment List</h3>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="addpayment_out.php" class="btn btn-primary me-2">
                                                <i class="fas fa-plus"></i> Add New Payment
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-striped table-hover" style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>Payment Date</th>
                                                <th>User Name</th>
                                                <th>Amount</th>
                                                <th>Payment Method</th>
                                                <th>Bank Name</th>
                                                <th>Cheque No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "select u.user_name,u.user_type,p.* from payment p left join users u on u.id=p.user_id where u.user_type='supplier'");
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                echo "<tr>
                                                    <td>{$row['date']}</td>
                                                    <td>{$row['user_name']}</td>
                                                    <td>{$row['amount']}</td>
                                                    <td>{$row['payment_method']}</td>
                                                    <td>{$row['bank_name']}</td>
                                                    <td>{$row['cheque_no']}</td>
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
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins\moment\moment.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte2167.js?v=3.2.0"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"2437d112162f4ec4b63c3ca0eb38fb20","server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script src="./plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./plugins/toastr/toastr.min.js"></script>
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
                        action: 'users'
                    },
                    success: function(response) {
                        if (response.status == true) {
                            if (status_val == 1) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                            } else {
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
                            action: 'users'
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
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>


</body>

<!-- , Sat, 29 Nov 2025 06:35:23 GMT -->

</html>