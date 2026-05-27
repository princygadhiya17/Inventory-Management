<?php
include("config.php");
include("check_session.php");

$invoice_items = [];
    $fetch1 = [];
    $q2 = mysqli_query($conn, "SELECT * FROM invoice_details WHERE 1=0");

    //to fetch old record 
    if (isset($_GET['id'])) {

        $invoice_id = $_GET['id'];

        $invoice = mysqli_query($conn, "SELECT * FROM invoice WHERE id='$invoice_id'");
        $fetch1 = mysqli_fetch_assoc($invoice);

        // fetch invoice items
        $invoice_items = [];
        $q2 = mysqli_query($conn, "SELECT * FROM invoice_details WHERE invoice_id='$invoice_id'");
    }

    $payment_status = $fetch1['payment_status'] ?? '';
    // $payment_status = "";
    // if (isset($_GET['id'])) {
    //     $payment_status = $_GET['payment_status'];
    // }
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
                        <div class="row mb-0">
                            <div class="col-sm-6">
                                <h4>Invoice</h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Invoice</li>
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
                                        <h3 class="card-title">Create Invoice</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form method="POST" action="save_sales.php" id="disable-fields" enctype="multipart/form-data">
                                            <input type="hidden" name="invoice_id" value="<?php echo (isset($_GET['id']))  ? $_GET['id'] : 0; ?>">
                                            <input type="hidden" name="user_type" value="Customer">
                                            <input type="hidden" name="invoice_type" value="Sales">
                                            <div class="row">
                                                <h5 class="m-0 mb-1">Basic Details of Invoice</h5>
                                                <p style="font-size:0.9rem;">By Adding invoice basic details invoice will made</p>
                                                <div class="col-md-3 mb-3">
                                                    <label for="invoiceno">Invoice No</label>
                                                    <input type="number" id="invoiceno" name="invoice_no" class="form-control" placeholder="Enter Invoice No" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                                            echo $fetch1['invoice_no'];
                                                                                                                                                                        } ?>" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Customer</label>
                                                    <div class="input-group">
                                                        <select class="form-select" name="user_id" required>
                                                            <option value="" disabled <?php if (!isset($_GET['id'])) echo 'selected'; ?>>Select Customer</option>
                                                            <?php
                                                            $user_q = mysqli_query($conn, "SELECT id,user_name FROM users where user_type='Customer'");
                                                            while ($b = mysqli_fetch_assoc($user_q)) {
                                                                $selected = (isset($_GET['id']) && $fetch1['user_id'] == $b['id']) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $b['id']; ?>" <?php echo $selected; ?>>
                                                                    <?php echo $b['user_name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <a href="add_customers.php" class="btn btn-secondary me-2">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="date">Sales Date</label>
                                                    <input type="date" id="salesdate" name="invoice_date" class="form-control" required value="<?php if (isset($_GET['id'])) {
                                                                                                                                                    echo $fetch1['invoice_date'];
                                                                                                                                                } ?>">
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="row">
                                                <h5 class="m-0 mb-1">Add Item In Sales Invoice</h5>
                                                <p style="font-size:0.9rem;">By Adding Item in List its consider in invoice of customer</p>
                                                <div class="col-md-2 mb-3 mt-1">
                                                    <label class="form-label">Brand</label>
                                                    <div class="input-group">
                                                        <select class="form-select" name="brand_id">
                                                            <option value="" disabled selected>Brand</option>
                                                            <?php
                                                            $brand_q = mysqli_query($conn, "SELECT id,name FROM brands");
                                                            while ($b = mysqli_fetch_assoc($brand_q)) { ?>
                                                                <option value="<?php echo $b['id']; ?>">
                                                                    <?php echo $b['name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <a href="add_brand.php" class="btn btn-secondary me-2">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Category</label>
                                                    <div class="input-group">
                                                        <select class="form-select cat" name="category_id" id="category_list">
                                                            <option value="" disabled selected>Category</option>
                                                            <?php
                                                            $category_q = mysqli_query($conn, "SELECT id,name FROM category");
                                                            while ($c = mysqli_fetch_assoc($category_q)) { ?>
                                                                <option value="<?php echo $c['id']; ?>">
                                                                    <?php echo $c['name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <a href="add_brand.php" class="btn btn-secondary me-2">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label fw-bold">Product</label>
                                                    <div class="input-group">
                                                        <select class="form-select" id="product_id">
                                                            <option value="" disabled selected>Product</option>
                                                        </select>
                                                        <a href="add_product.php" class="btn btn-outline-secondary">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Unit</label>
                                                    <div class="input-group">
                                                        <select class="form-select" name="unit_id" id="unit_id">
                                                            <option value="" disabled selected>Unit</option>
                                                            <?php
                                                            $unit_q = mysqli_query($conn, "SELECT id,name FROM units");
                                                            while ($u = mysqli_fetch_assoc($unit_q)) { ?>
                                                                <option value="<?php echo $u['id']; ?>">
                                                                    <?php echo $u['name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <a href="add_brand.php" class="btn btn-secondary me-2">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="form-label fw-bold">Quantity</label>
                                                    <input type="number" id="quantity" name="qty" class="form-control" placeholder="Qty">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label fw-bold">Price</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="number" step="0.01" name="rate" id="price" class="form-control" placeholder="Price">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button id="addRow" type="button" class="btn btn-primary w-100">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <h5 class="m-0 mb-1">Items list</h5>
                                                <p style="font-size:0.9rem;">listed invoice items</p>
                                                <table class="table table-striped table-bordered mt-1" id="itemsTable">
                                                    <thead class="table-light">
                                                        <tr class="text-center">
                                                            <th>Name</th>
                                                            <th>Qty</th>
                                                            <th>Unit</th>
                                                            <th>Price</th>
                                                            <th>Subtotal</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <!-- <tbody class="text-center"></tbody> -->
                                                    <tbody class="text-center">
                                                        <?php
                                                        while ($it = mysqli_fetch_assoc($q2)) { ?>
                                                            <tr>
                                                                <td><?php
                                                                    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM products WHERE id=" . $it['product_id']));
                                                                    echo $p['name'];
                                                                    ?></td>

                                                                <td><?php echo $it['qty']; ?></td>
                                                                <td>
                                                                    <?php
                                                                    $u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM units WHERE id=" . $it['unit_id']));
                                                                    echo $u['name'];
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $it['rate']; ?></td>
                                                                <td><?php echo $it['total_price']; ?></td>

                                                                <td>
                                                                    <button type="button" class="btn btn-danger deleteRow">
                                                                        Delete
                                                                    </button>
                                                                </td>

                                                                <input type="hidden" name="product_id[]" value="<?php echo $it['product_id']; ?>">
                                                                <input type="hidden" name="quantity[]" value="<?php echo $it['qty']; ?>">
                                                                <input type="hidden" name="unit_id[]" value="<?php echo $it['unit_id']; ?>">
                                                                <input type="hidden" name="rate[]" value="<?php echo $it['rate']; ?>">
                                                            </tr>
                                                        <?php }
                                                        ?>
                                                    </tbody>


                                                </table>
                                            </div>

                                            <div class="row mt-4 mb-4">

                                                <div class="col-md-6">
                                                    <label class="form-label">Shipping Address</label>
                                                    <textarea name="shipping_address" class="form-control" rows="2"><?php if (isset($_GET['id'])) {
                                                                                                                        echo $fetch1['shipping_address'];
                                                                                                                    } ?></textarea>
                                                </div>

                                                <div class="col-md-6">
                                                    <table class="table table-striped table-bordered">
                                                        <tr>
                                                            <td class="text-left p-1">SubTotal</td>
                                                            <td><span class="input-group-text" id="subtotal"><?php if (isset($_GET['id'])) echo $fetch1['sub_total']; ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left p-1">Discount</td>
                                                            <td>
                                                                <input type="number" step="0.01" class="form-control" name="discount" id="discount" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                                echo $fetch1['discount'];
                                                                                                                                                            } ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left p-1">Grand Total</td>
                                                            <td><span class="input-group-text" id="grand_total"><?php if (isset($_GET['id'])) echo $fetch1['grand_total']; ?></span></td>
                                                        </tr>
                                                    </table>
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
                                                <button type="submit" name="add" class="btn btn-md btn-primary">Save Invoice</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
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
            const payment_status = "<?php echo isset($fetch1['payment_status']) ? $fetch1['payment_status'] : 'pending'; ?>";
        </script>

        <script>
            // $(document).ready(function() {
            //     // var inputfields=$()
            //     // input fields disabled krva mate id input field ne id apine 
            //     if (payment_status != 'pending') {
            //         $('input,select,textarea,button').prop('disabled', true);
            //         // $('#disable-fields')
            //         //     .find('input, select, textarea, button')
            //     }

            // })

            $(document).ready(function() {

                $('#category_list').change(function() {
                    var sel_val = $(this).val();

                    $.ajax({
                        url: "get_products.php",
                        type: "POST",
                        data: {
                            cat_id: sel_val
                        },
                        dataType: "json", // Expecting JSON response from the server
                        success: function(res) {
                            // Clear existing options in the dropdown
                            $('#product_id').empty();
                            // Loop through the returned data and add options to the select list
                            $.each(res.data, function(i, item) {
                                $('#product_id').append($('<option>', {
                                    value: item.id, // Assuming item has an id field for value
                                    text: item.name // Assuming item has a name field for display text
                                }));
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + error);
                        }
                    });
                });

                $('#product_id').change(function() {
                    var sel_val = $(this).val();

                    $.ajax({
                        url: "get_price.php",
                        type: "POST",
                        data: {
                            product_id: sel_val
                        },
                        dataType: "json",
                        success: function(res) {
                            $('#price').val(res.sales_price);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + error);
                        }
                    });
                });

                $("#addRow").click(function() {
                    var product_id = $("#product_id").val();
                    var productText = $("#product_id option:selected").text();
                    var qty = $("#quantity").val();
                    var price = $("#price").val();
                    var unit_id = $("#unit_id").val();

                    if (!productText || !qty || !price) {
                        alert("Please select product & enter quantity & price");
                    }
                    var unitText = $("#unit_id option:selected").text();
                    var subtotal = qty * price;
                    var row = `<tr>
                    <td>${productText}</td>
                    <td>${qty}</td>
                    <td>${unitText}</td>
                    <td>${price}</td>
                    <td>${subtotal}</td>
                    <td><button type="button" class="btn btn-danger deleteRow">delete</button></td>
                    
                    </tr>
                    <input type="hidden" name="unit_id[]" value="${unit_id}">
                    <input type="hidden" name="product_id[]" value="${product_id}">
                    <input type="hidden" name="quantity[]" value="${qty}">
                    <input type="hidden" name="rate[]" value="${price}">
                    `;


                    $("#itemsTable tbody").append(row);
                    calSubtotal();
                    grandtotal();
                });

                function calSubtotal() {
                    let total = 0;
                    $("#itemsTable tbody tr").each(function() {
                        let subtotal = Number($(this).find("td:eq(4)").text());
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

                $("#discount").on('input', function() {
                    grandtotal();
                });

                $(document).on('click', '.deleteRow', function() {
                    $(this).closest('tr').remove();
                    calSubtotal();
                });

                // $('#payment_method').change(function() {
                //     let paymentMethod = $('#payment_method').val();
                //     if (paymentMethod === 'bank') {
                //         $('#bank_name_field').show();
                //         $('#bank_cheque_field').show();
                //     } else {
                //         $('#bank_name_field').hide();
                //         $('#bank_cheque_field').hide();

                //         $('#bank_name').val('');
                //         $('#cheque_no').val('');
                //     }
                // })
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

            });
        </script>
    </body>
    <!-- , Sat, 29 Nov 2025 06:35:23 GMT -->

    </html>