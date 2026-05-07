    <?php
    include("config.php");
    include("check_session.php");
    ?>

    <!DOCTYPE html>

    <html>
    <?php include("header.php"); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <?php include("navbar.php"); ?>
            <!-- Main Sidebar -->
            <?php include("sidebar.php"); ?>
            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add Sales Return</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Sales Return Form</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Sales Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form method="POST" action="save_salesreturn.php" enctype="multipart/form-data">

                                            <input type="hidden" name="user_type" value="Customer">
                                            <input type="hidden" name="invoice_type" value="salesreturn">
                                            <input type="hidden" name="original_invoice_id" id="original_invoice_id">

                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="invoiceno">Invoice No</label>
                                                    <select id="invoiceno" name="invoice_no" class="form-select">
                                                        <option value="" disabled selected>Select Invoice</option>
                                                        <?php
                                                        $query = "SELECT id, invoice_no FROM invoice WHERE invoice_type='sales'";
                                                        $exec = mysqli_query($conn, $query);
                                                        while ($i = mysqli_fetch_assoc($exec)) { ?>
                                                            <option value="<?php echo $i['invoice_no']; ?>">
                                                                <?php echo $i['invoice_no']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Customer</label>
                                                    <div class="input-group">
                                                        <select class="form-select" name="user_id" required>
                                                            <option value="" disabled>Select Customer</option>
                                                        </select>
                                                        <a href="add_customers.php" class="btn btn-secondary me-2">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="date">Return Date</label>
                                                    <input type="date" id="invoice_date" name="invoice_date" class="form-control" required>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Product</label>
                                                    <div class="input-group">
                                                        <select class="form-select" id="product_id">
                                                            <option value="" disabled selected>Select Product</option>
                                                        </select>
                                                        <a href="add_product.php" class="btn btn-outline-secondary">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Quantity</label>
                                                    <input type="number" id="quantity" name="qty" class="form-control" placeholder="Qty">
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button id="addRow" type="button" class="btn btn-primary w-100">
                                                        <i class="bi bi-cart-plus"></i> Add Item to Return
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <table class="table table-striped table-bordered mt-3" id="itemsTable">
                                                    <thead class="table-light">
                                                        <tr class="text-center">
                                                            <th>Name</th>
                                                            <th>Qty</th>
                                                            <th>Unit Price</th>
                                                            <th>Subtotal</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <!-- <tbody class="text-center"></tbody> -->
                                                    <tbody class="text-center">


                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row mt-4 mb-4">

                                                <!-- LEFT SIDE Shipping address -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Shipping Address</label>
                                                    <textarea name="shipping_address" class="form-control" rows="5"></textarea>
                                                </div>

                                                <!-- RIGHT SIDE Subtotal Discount -->
                                                <div class="col-md-4 offset-md-2">

                                                    <label class="form-label">Subtotal</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">₹</span>
                                                        <label id="subtotal" name="subtotal"></label>
                                                        <input type="hidden" id="send_subtotal" name="sub_total">
                                                    </div>

                                                    <label class="form-label">Discount</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="number" step="0.01" class="form-control" name="discount" id="discount">
                                                    </div>

                                                    <label class="form-label">Grand total</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">₹</span>
                                                        <label id="grand_total"></label>
                                                        <input type="hidden" id="send_grand_total" name="grand_total">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">

                                                <div class="col-md-3 mb-3">
                                                    <label for="paid_amount" class="form-label">Paid Amount</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="number" step="0.01" class="form-control" name="paid_amount" id="paid_amount" placeholder="Enter Paid Amount" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                                                                echo $fetch1['paid_amount'];
                                                                                                                                                                                            } ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="payment_method" class="form-label">Payment Method</label>
                                                    <?php
                                                    $payment_method = '';
                                                    if (isset($_GET['id']) && isset($fetch1['id'])) {
                                                        $invoice_id = $fetch1['id'];
                                                        $payment = "select * from payment where invoice_id=$invoice_id";
                                                        $execpayment = mysqli_query($conn, $payment);
                                                        if ($payment_row = mysqli_fetch_assoc($execpayment)) {
                                                            $payment_method = $payment_row['payment_method'];
                                                            $bank_name = $payment_row['bank_name'];
                                                            $cheque_no = $payment_row['cheque_no'];
                                                        }
                                                    }
                                                    ?>

                                                    <select class="form-select" name="payment_method" id="payment_method" required>
                                                        <option value="" disabled selected <?php echo $payment_method == '' ? 'selected' : ''; ?>>Select Payment Method</option>
                                                        <option value="cash" <?php echo $payment_method == 'cash' ? 'selected' : ''; ?>>Cash</option>
                                                        <option value="bank" <?php echo $payment_method == 'bank' ? 'selected' : ''; ?>>Bank</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3" id="bank_name_field">
                                                    <label for="bank_name">Bank Name</label>
                                                    <input type="text" id="bank_name" name="bank_name" class="form-control" value="<?php if (isset($_GET['id'])) {
                                                                                                                                        echo $bank_name;
                                                                                                                                    } ?>">
                                                </div>

                                                <div class="col-md-3" id="bank_cheque_field">
                                                    <label for="cheque_no">Cheque No.</label>
                                                    <input type="text" id="cheque_no" name="cheque_no" class="form-control" value="<?php if (isset($_GET['id'])) {
                                                                                                                                        echo $cheque_no;
                                                                                                                                    } ?>">
                                                </div>
                                            </div>

                                            <div class="col-12 mt-3 mb-3 text-right">
                                                <button type="submit" name="add" class="btn btn-md btn-primary">Save Sales Return</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.card-header -->
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

        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- daterangepicker -->
        <script src="plugins/moment/moment.min.js"></script>

        <!-- Tempusdominus Bootstrap 4 -->
        <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- AdminLTE App -->
        <script src="dist/js/adminlte2167.js?v=3.2.0"></script>

        <script>
            $(document).ready(function() {
                function showbankfields() {
                    let paymentMethod = $('#payment_method').val();

                    if (paymentMethod == 'bank') {
                        $('#bank_name_field').show();
                        $('#bank_cheque_field').show();
                    } else {
                        $('#bank_name_field').hide();
                        $('#bank_cheque_field').hide();

                        $('#bank_name').val('');
                        $('#cheque_no').val('');
                    }
                }

                showbankfields();

                $('#payment_method').on('change', function() {
                    showbankfields();
                });

                $('#invoiceno').on("change", function() {

                    let invoice_no = $(this).val();

                    $.ajax({
                        url: "fetch_sales.php",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            invoice_no: invoice_no
                        },
                        success: function(res) {

                            $('#original_invoice_id').val(res.invoice_id);
                            $('select[name="user_id"]').html(
                                `<option value="${res.customer_id}" selected>${res.customer_name}</option>`
                            );

                            let rows = '';
                            let total = 0;

                            $.each(res.items, function(i, item) {

                                rows += `
                            <tr>
                            <td data-product-name="${item.name}"> ${item.name}
                            <input type="hidden" name="product_id[]" value="${item.product_id}">
                            <input type="hidden" name="unit_id[]" value="${item.unit_id}">
                            </td>

                             <td class='quantity'>${item.qty}
                                <input type="hidden" name="qty[]" value="${item.qty}">
                            </td>
                            <td>${item.rate}
                             <input type="hidden" name="rate[]" value="${item.rate}">
                            </td>
                            <td>${item.subtotal}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove deleteRow">delete</button>
                                <button type="button" class="btn btn-danger btn-sm editRow">edit</button>
                            </td>
                        </tr>`;
                            });

                            $('#itemsTable tbody').html(rows);
                            $('#discount').val(res.discount);

                            calSubtotal();
                        }
                    });
                });

                function calSubtotal() {
                    let total = 0;
                    $("#itemsTable tbody tr").each(function() {
                        let subtotal = Number($(this).find("td:eq(3)").text());
                        total += subtotal;
                    });
                    $("#subtotal").text(total);
                    grandtotal();
                }

                function grandtotal() {
                    var subtotal = Number($("#subtotal").text());
                    var discount = Number($("#discount").val());
                    var grandtotal = subtotal - discount;
                    // alert(grand_total);
                    $("#grand_total").text(grandtotal);
                }
                $("#discount").on("input", function() {
                    grandtotal();
                });

                $(document).on('click', '.deleteRow', function() {
                    $(this).closest('tr').remove();
                    calSubtotal();
                });

                let editingRow = null;

                $(document).on('click', '.editRow', function() {

                    editingRow = $(this).closest('tr');

                    let product_id = editingRow.find('input[name="product_id[]"]').val();
                    let product_name = editingRow.find('td:eq(0)').text();
                    let qty = editingRow.find('input[name="qty[]"]').val();
                    let unit_id = editingRow.find('input[name="unit_id[]"]').val();

                    maxqty = qty;
                    $('#product_id').html(`
                     <option value="${product_id}" selected>${product_name}</option>`);

                    $('#quantity').val(qty);


                    editingRow.remove();

                    calSubtotal();
                });


                $("#addRow").click(function() {

                    let qty = Number($("#quantity").val());

                    let price = Number(editingRow.find('td:eq(2)').text());
                    let subtotal = price * qty;

                    editingRow.find('td:eq(1)').html(`
                     ${qty}
                     <input type="hidden" name="qty[]" value="${qty}"> `);

                    editingRow.find('td:eq(3)').text(subtotal);

                    $("#itemsTable tbody").append(editingRow);

                    editingRow = null;

                    $("#product_id").html(`<option selected disabled>Select Product</option>`);
                    $("#quantity").val('');

                    calSubtotal();
                });
            });
        </script>


    </body>

    </html>