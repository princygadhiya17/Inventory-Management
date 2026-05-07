    <?php
    include("config.php");
    include("check_session.php");
    // $id = $_GET['id'];
    // $query = mysqli_query($conn, "select i.*,sum(paid_amount) as paid_amount from invoice where id=$id");

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
                                <h4>Payments</h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Payment In</li>
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
                                        <h3 class="card-title">Payment In</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form method="POST" action="save_payment_in.php" id="disable-fields" enctype="multipart/form-data">
                                            <!-- <input type="hidden" name="unused_amount"> -->
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">Customer</label>
                                                    <div class="input-group">
                                                        <select class="form-select" name="user_id" id="customer_id" required>
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
                                                    <label class="form-label fw-bold">Amount</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">₹</span>
                                                        <input type="number" step="0.01" name="rate" id="price" class="form-control" placeholder="Price">
                                                    </div>
                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="date">Payment Date</label>
                                                    <input type="date" id="salesdate" name="invoice_date" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
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
                                                    <input type="text" id="bank_name" name="bank_name" class="form-control">
                                                </div>

                                                <div class="col-md-3" id="bank_cheque_field">
                                                    <label for="cheque_no">Cheque No.</label>
                                                    <input type="text" id="cheque_no" name="cheque_no" class="form-control">
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <h5 class="m-0 mb-1">Invoice list</h5>
                                                <p style="font-size:0.9rem;">Settle below invoices using this payment</p>
                                                <table class="table table-striped table-bordered mt-1" id="itemsTable">
                                                    <thead class="table-light">
                                                        <tr class="text-center">
                                                            <th>Invoice No</th>
                                                            <th>Date</th>
                                                            <th>Total Amount</th>
                                                            <th>Due Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <!-- <tbody class="text-center"></tbody> -->
                                                    <tbody class="text-center">
                                                        <?php


                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-12 mt-3 mb-3 text-right">
                                                <button type="submit" name="add" class="btn btn-md btn-primary">Save Payment</button>
                                            </div>
                                        </form>
                                    </div>
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
            const payment_status = "<?php echo isset($fetch1['payment_status']) ? $fetch1['payment_status'] : 'pending'; ?>";
        </script>

        <script>
            $(document).ready(function() {

                $('#customer_id').on('change', function() {
                    let user_id = $(this).val();
                    $.ajax({
                        url: 'fetch_customer_payment.php',
                        type: 'POST',
                        data: {
                            user_id: user_id
                        },
                        dataType: 'json',
                        success: function(res) {
                            console.log(res);
                            let rows = '';
                            $.each(res.invoices, function(i, inv) {
                                rows += `
                        <tr>
                            <td>${inv.invoice_no}</td>
                            <td>${inv.invoice_date}</td>
                            <td>${inv.grand_total}</td>
                            <td>${inv.due_amount}</td>
                            <td><input type="number" class="form-control settle-amount" data-due="${inv.due_amount}"  name="settlements[${inv.id}]"></td>
                        </tr>
                        `;
                            });

                            $('#itemsTable tbody').html(rows);
                            $('#price').on('input', function() {

                                let amount = Number($(this).val());
                                $('.settle-amount').val(0);
                                // let unused_amount=amount;
                                // let settled=0;
                                $('.settle-amount').each(function() {
                                    let due = Number($(this).data('due'));
                                    // let renainamount=due;
                                    if (amount >= due) {
                                        $(this).val(due);
                                        amount = amount - due;
                                        console.log("amount:" + amount);
                                        console.log("due:" + due);
                                    } else {
                                        $(this).val(amount);
                                        // unused_amount = amount;
                                        amount = 0;
                                        console.log("amount:" + amount);
                                        console.log("due:" + due);
                                    }
                                })
                            });
                        }
                    })
                })

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
            })
        </script>
    </body>
    <!-- , Sat, 29 Nov 2025 06:35:23 GMT -->

    </html>