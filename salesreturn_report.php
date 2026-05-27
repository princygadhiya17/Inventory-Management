<?php
include("config.php");
include("check_session.php");

$from_date = "";
$to_date = "";

$datetimes  = $_GET['datetimes'] ?? '';

if (!empty($_GET['datetimes'])) {
    $daterange = explode(" - ", $_GET['datetimes']);
    // echo "<pre>";print_r($daterange);exit;
    $from_date = $daterange[0];
    $to_date = $daterange[1];
    // echo $from_date;exit;
}

if ($from_date && $to_date) {
    $query = "select i.*, u.user_name 
              from invoice i
              left join users u on i.user_id = u.id
              where i.invoice_type='salesreturn' 
              and DATE(i.invoice_date) between '$from_date' and '$to_date'";
} else {
    $query = "select i.*, u.user_name 
              from invoice i
              left join users u on i.user_id = u.id
              where i.invoice_type='salesreturn'";
}

$invoices = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include("header.php"); ?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                            <h1>Sales Return</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Sales Return</li>
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
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <form method="GET" class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="supplier_id" class="mr-2">Date</label>
                                                <input type="text" name="datetimes" class="form-control"
                                                    value="<?php echo $_GET['datetimes'] ?? ''; ?>">
                                            </div>
                                            <div class="col-md-1" style="margin-top:32px;">
                                                <button type="submit" class="btn btn-primary btn-block" id="filter">
                                                    <i class="fas fa-filter"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <!-- <h3 class="card-title">DataTable with default features</h3> -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="card-title">Sales ReturnList</h3>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="exportsalesreturn.php" class="btn btn-primary">Export in Excel</a>
                                            <a href="salesreturnreports_pdf.php" class="btn btn-primary">Generate pdf</a>

                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-striped table-hover" style="text-align: center;">
                                        <thead>
                                            <tr>
                                                <th>Invoice No</th>
                                                <th>Invoice Date</th>
                                                <th>Customer</th>
                                                <th>Total Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Due Amount</th>
                                                <th>Payment Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($invoices)) {
                                                $date = new DateTime($row['invoice_date']);
                                                echo "<tr>
                                                    <td>{$row['invoice_no']}</td>
                                                    <td>" . $date->format("d/m/Y") . "</td>
                                                    <td>{$row['user_name']}</td>
                                                    <td>{$row['grand_total']}</td>
                                                    <td>{$row['paid_amount']}</td>
                                                    <td>{$row['due_amount']}</td>
                                                    <td>{$row['payment_status']}</td>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>

    <script>
        $(document).on("click", "#filter", function() {
            $(this).closest("form").submit();
        });

        $(function() {
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            });
        });
    </script>
    <script>
        $(function() {
            $('input[name="datetimes"]').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                opens: 'left',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, function(start, end, label) {
                // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });

        function export_data() {
            var data = document.getElementById('example2');
            let fp = XLSX.utils.table_to_book(data, {
                sheet: 'salesreturn'
            });
            XLSX.writeFile(fp, "ExportSalesreturn.xlsx");
        }
    </script>



</body>

<!-- , Sat, 29 Nov 2025 06:35:23 GMT -->

</html>