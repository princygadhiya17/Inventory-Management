<?php
include("config.php");
include("check_session.php");

// $query = mysqli_query($conn, "select i.* , u.user_name from invoice i 
//                             left join users u
//                             on i.user_id=u.id
//                             where i.invoice_type='sales'");

// $invoice_date = "";
// if (isset($_GET['invoice_date'])) {
//     $invoice_date = $_GET['invoice_date'];
// }
$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';

if ($from_date != "" and $to_date != "") {
    $query = " select i.*, u.user_name from invoice i
        left join users u on i.user_id = u.id
        where i.invoice_type='sales'
        and  DATE(i.invoice_date) between '$from_date' and '$to_date'";
} elseif ($from_date != "") {

    $query = "select i.*, u.user_name from invoice i
        left join users u on i.user_id = u.id
        where i.invoice_type = 'sales'
        and DATE(i.invoice_date) = '$from_date'";
} else {
    $query = "select i.*, u.user_name from invoice i
        left join users u on i.user_id = u.id
        where i.invoice_type = 'sales'";
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
<!-- use version 0.20.3 -->
<script type="text/javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
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
                            <h1>Sales</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Sales</li>
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
                                                <label for="supplier_id" class="mr-2">From Date</label>
                                                <input type="date" name="from_date" id="invoice_date"
                                                    value="<?php echo $_GET['from_date'] ?? ''; ?>"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="supplier_id" class="mr-2">To Date</label>
                                                <input type="date" name="to_date" id="invoice_date"
                                                    value="<?php echo $_GET['to_date'] ?? ''; ?>"
                                                    class="form-control">
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
                                            <h3 class="card-title">Sales List</h3>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="exportsales.php" class="btn btn-primary">Export in Excel</a>
                                            <a href="salesreport_pdf.php" class="btn btn-primary">Generate pdf</a>
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

    <!-- ===== INVOICE VIEW MODAL ===== -->
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">#Sales Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="invoiceModalBody">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="saveCategory" class="btn btn-primary">Save Category</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
        $(document).on("click", "#filter", function() {
            $(this).closest("form").submit();
        });
        // function submitDetailsForm() {
        //     $("#customer_id").submit();
        // }

        $(function() {
            $("#example2").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        });

        function export_data() {
            var data = document.getElementById('example2');
            let fp = XLSX.utils.table_to_book(data, {
                sheet: 'salesreport'
            });
            //    XLSX.write(fp,{
            //     bookType:'xlsx',
            //     type:'base64'
            //    });
            XLSX.writeFile(fp, "ExportSales.xlsx");
        }
    </script>


</body>

<!-- , Sat, 29 Nov 2025 06:35:23 GMT -->

</html>