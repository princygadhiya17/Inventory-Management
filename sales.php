<?php
include("config.php");
include("check_session.php");

$customers = mysqli_query($conn, "select id, user_name from users where user_type='customer'");

$selected_customer = "";
$invoice_no = "";

if (isset($_GET['customer_id'])) {
    $selected_customer = $_GET['customer_id'];
}

if (isset($_GET['invoice_no'])) {
    $invoice_no = $_GET['invoice_no'];
}

if ($selected_customer != "" && $invoice_no != "") {

    $invoices = mysqli_query($conn, "
        select i.*, u.user_name from invoice i
        left join users u on i.user_id = u.id
        where i.invoice_type='sales'
        and i.user_id='$selected_customer'
        and i.invoice_no='$invoice_no' ");
} else if ($selected_customer != "") {

    $invoices = mysqli_query($conn, "
        select i.*, u.user_name from invoice i
        left join users u on i.user_id = u.id
        where i.invoice_type='sales'
        and i.user_id='$selected_customer'
        ");
} else if ($invoice_no != "") {

    $invoices = mysqli_query($conn, "
        select i.*, u.user_name
        from invoice i
        left join users u on i.user_id = u.id
        where i.invoice_type='sales'
        and i.invoice_no='$invoice_no'");
} else {
    $invoices = mysqli_query($conn, "
        select i.*, u.user_name from invoice i
        left join users u on i.user_id = u.id
        where i.invoice_type='sales' ");
}

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
                                                <label for="customer_id" class="mr-2">Select Customer:</label>
                                                <select name="customer_id" id="customer_id" class="form-control mr-2">
                                                    <option value="">All Customers</option>
                                                    <?php while ($customer = mysqli_fetch_assoc($customers)) { ?>
                                                        <option value="<?php echo $customer['id']; ?>"
                                                            <?php echo ($customer['id'] == $selected_customer) ? 'selected' : ''; ?>>
                                                            <?php echo $customer['user_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <label>Invoice No:</label>
                                                <input type="text" name="invoice_no" id="invoice_no"
                                                    value="<?php echo isset($_GET['invoice_no']) ? $_GET['invoice_no'] : ''; ?>"
                                                    class="form-control" placeholder="Enter Invoice No">
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
                                            <a href="add_sales.php" class="btn btn-primary me-2">
                                                <i class="fas fa-plus"></i> Add New Sales
                                            </a>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($invoices)) {

                                                $date = new DateTime($row['invoice_date']);
                                                $status = $row['payment_status'];

                                                if ($status == 'paid') {
                                                    $paymentBadge = "<span class='badge badge-success'>Paid</span>";
                                                } elseif ($status == 'partialpaid') {
                                                    $paymentBadge = "<span class='badge badge-warning'>Partial Paid</span>";
                                                } else {
                                                    $paymentBadge = "<span class='badge badge-danger'>pending</span>";
                                                }

                                                echo "<tr id='invoiceRow{$row['id']}'>

                                                 <td>
                                                 <a href='#' class='invoiceView' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#modal-lg'>
                                                     {$row['invoice_no']}
                                                  </a>
                                                </td>

                                        <td>" . $date->format('d/m/Y') . "</td>
                                        <td>{$row['user_name']}</td>
                                        <td>{$row['grand_total']}</td>
                                        <td class='paid_amount'>{$row['paid_amount']}</td>
                                        <td class='due_amount'>{$row['due_amount']}</td>
                                        <td class='paymentstatus'>{$paymentBadge}</td>
                                         <td>
                                            <div class='btn-group' role='group'>
                                             <a href='print_sales.php?id={$row['id']}' class='btn btn-outline-primary m-1'>View</a>
                                                <a href='add_sales.php?id={$row['id']}' class='btn btn-outline-primary m-1 editbtn'>Edit</a>
                                                " . '<button class="btn btn-outline-danger m-1 deleteBtn" data-id="' . $row['id'] . '">Delete</button>' . "
                                             " . '<button class="btn btn-outline-info m-1 paymentbtn" data-toggle="modal" data-target="#modal-lg2" data-id="' . $row['id'] . '" data-due="' . $row['due_amount'] . '">Payment</button>' . "
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
                    <!-- <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="saveCategory" class="btn btn-primary">Save Category</button>
                    </div> -->

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <div class="modal fade" id="modal-lg2">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Payment Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="paymentmodalbody">
                    <div id="paymentDetails" class="mb-3"></div>
                    <div id="addPaymentSection">
                        <h4 class="modal-title">AddPayment</h4>
                        <hr>
                        <form method="POST" id="paymentform" action="" enctype="multipart/form-data">
                            <input type="hidden" name="invoice_id" id="invoice_id">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="paymentdate">Payment Date</label>
                                    <?php
                                    $date = date("Y-m-d");
                                    ?>
                                    <input type="date" id="paymentdate" name="paymentdate" value="<?php echo $date; ?>" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Payment Method</label>
                                        <select name="payment_method" class="form-control" required>
                                            <option value="">Select Payment Method</option>
                                            <option value="Cash" id="cash" name="cash" default selected>Cash</option>
                                            <option value="Bank" id="bank" name="bank">Bank</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="bankfield">
                                <div class="col-md-6">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" id="bank_name" name="bank_name" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="cheque_no">Cheque No.</label>
                                    <input type="text" id="cheque_no" name="cheque_no" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="paymentamount">Payment Amount</label>
                                    <input type="number" id="paymentamount" name="paymentamount" class="form-control" required min=1>
                                    <small class="text-danger">
                                        Due Amount: <strong id="dueAmountText">0</strong>
                                    </small>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="savepayment" class="btn btn-primary">Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        $(document).ready(function() {
            // let payment = $('#paymentstatus').text();
            // if (payment == "partialpaid" || payment == "paid") {
            //     $('.editbtn').hide();
            // }
            $('#example2 tbody tr').each(function() {

                let payment = $(this).find('.paymentstatus span').text()
                if (payment == 'Paid' || payment == 'Partial Paid') {
                    $(this).find('.editbtn').hide();
                }
            });
        })

        $(document).on("click", ".invoiceView", function(e) {
            e.preventDefault();
            let id = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "invoice_view.php",
                data: {
                    id: id
                },
                success: function(res) {
                    $("#invoiceModal").modal("show");
                    $("#invoiceModalBody").html(res);
                }
            });
        });

        $(document).on("click", ".paymentbtn", function(e) {
            e.preventDefault();

            let id = $(this).data("id");

            $("#bankfield").hide();

            let invoiceId = $(this).data("id");
            let dueAmount = $(this).data("due");
            // console.log("INVoice ID:", invoiceId);
            // console.log("Due Amount:", dueAmount);

            $("#invoice_id").val(invoiceId);
            $("#dueAmountText").text(dueAmount);

            $("#paymentform")[0].reset();

            if (dueAmount <= 0) {
                $("#addPaymentSection").hide();
            } else {
                $("#addPaymentSection").show();
            }

            $("select[name='payment_method']").change(function() {
                //   $("#bank_name_field").hide();
                //     $("#bank_cheque_field").hide();
                if ($(this).val() == 'Bank') {
                    $("#bankfield").show();
                } else {
                    $("#bankfield").hide();
                }
            })
            $.ajax({
                type: "POST",
                url: "fetchpayment_details.php",
                data: {
                    id: id
                },
                success: function(res) {
                    // alert("test");
                    // console.log(res);
                    $("#paymentDetails").html(res);
                    // // let status = $(".paymentstatus").text();
                }
            });
            $("#modal-lg2").modal("show");
        });
        // $(document).ready(function() {
        //     $("#bank_name_field").hide();
        //     $("#cheque_no_field").hide();
        //     $("select[name='payment_method']").change(function() {
        //         if ($(this).val() === 'Bank') {
        //             $("#bank_name_field").show();
        //             $("#bank_cheque_field").show();

        //         } else {
        //             $("#bank_name_field").hide();
        //             $("#bank_cheque_field").hide();
        //         }
        //     })
        // // })
        $("#paymentform").submit(function(e) {


            e.preventDefault();
            let formData = new FormData($("#paymentform")[0]);
            $.ajax({
                url: "add_paymentsales.php",
                type: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == true) {
                        let id = $('#invoice_id').val();
                        let row = $("#invoiceRow" + id);

                        row.find(".paid_amount").text(response.paid_amount);
                        row.find(".due_amount").text(response.due_amount);
                        row.find(".paid_amount").text(response.paid_amount);
                        row.find(".paymentbtn").data("due", response.due_amount);

                        let paymentBadge = '';
                        if (response.due_amount <= 0) {
                            paymentBadge = "<span class='badge badge-success'>Paid</span>";
                        } else if (response.paid_amount > 0) {
                            paymentBadge = "<span class='badge badge-warning'>Partial Paid</span>";
                        } else {
                            paymentBadge = "<span class='badge badge-danger'>pending</span>";
                        }
                        row.find(".paymentstatus").html(paymentBadge);

                        $("#dueAmountText").text(response.due_amount);

                        alert(response.message);
                        $("#modal-lg2").modal("hide");
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    </script>

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
                                action: 'invoice'
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