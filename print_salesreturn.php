<?php
include("config.php");
include("check_session.php");

$id = $_GET['id'] ?? 0;

$invoice = mysqli_query($conn, "
    select i.*, u.user_name,u.user_mobile,u.email
    from invoice i
    left join users u on i.user_id = u.id
    where i.id='$id'");
$inv = mysqli_fetch_assoc($invoice);

//invoice_details ane product , unit , tax
$items = mysqli_query($conn, "
    select d.*,  p.name as product_name, p.description , u.name as unit_name , i.discount
    from invoice_details d
    left join invoice i on d.invoice_id = i.id
    left join products p on d.product_id = p.id
    left join units u on d.unit_id = u.id
    WHERE d.invoice_id='$id'
");
?>
<!DOCTYPE html>
<html lang="en">
<?php include("header.php"); ?>

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
                            <h1>Invoice</h1>
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
                        <div class="col-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Note:</h5>
                                This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                            </div>


                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <i class="fas fa-globe"></i> AdminLTE, Inc.
                                            <small class="float-right">Date: 2/10/2014</small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        From
                                        <address>
                                            <strong>Admin, Inc.</strong><br>
                                            795 Folsom Ave, Suite 600<br>
                                            San Francisco, CA 94107<br>
                                            Phone: (804) 123-5432<br>
                                            Email: <a href="https://adminlte.io/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="3f565159507f5e53525e4c5e5a5a5b4c4b4a5b5650115c5052">[email&#160;protected]</a>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        To
                                        <address>
                                            <strong><?php echo $inv['user_name']; ?></strong><br>
                                            <?php echo $inv['shipping_address']; ?><br>
                                            Phone : <?php echo $inv['user_mobile']; ?><br>
                                            Email: <a href=""><?php echo $inv['email']; ?></a>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Invoice No : <?php echo $inv['invoice_no']; ?></b><br>
                                        <br>
                                        <b>Order ID:</b> - <br>
                                        <b>Payment Due Date : </b><?php echo $inv['invoice_date'] ?><br>
                                        <b>Account:</b> -
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Qty</th>
                                                    <th>Product</th>
                                                    <th>Unit</th>
                                                    <th>price</th>
                                                    <th>Description</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row = mysqli_fetch_assoc($items)) { ?>
                                                    <tr>
                                                        <td><?php echo $row['qty']; ?></td>
                                                        <td><?php echo $row['product_name']; ?></td>
                                                        <td><?php echo $row['unit_name']; ?></td>
                                                        <td><?php echo $row['rate']; ?></td>
                                                        <td><?php echo $row['description']; ?></td>
                                                        <td><?php echo $row['total_price']; ?></td>
                                                    </tr>
                                                <?php } ?>


                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-6">
                                        <p class="lead">Payment Methods:</p>
                                        <img src="././dist/img/credit/visa.png" alt="Visa">
                                        <img src="././dist/img/credit/mastercard.png" alt="Mastercard">
                                        <img src="././dist/img/credit/american-express.png" alt="American Express">
                                        <img src="././dist/img/credit/paypal2.png" alt="Paypal">

                                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                                            plugg
                                            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                        </p>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-6">
                                        <p class="lead"> Amount Due Date : <?php echo $inv['invoice_date']; ?></p>

                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">Subtotal : </th>
                                                    <td><?php echo $inv['sub_total']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tax</th>
                                                    <td>0.00</td>
                                                </tr>
                                                <tr>
                                                    <th>Discount : </th>
                                                    <td><?php echo $inv['discount']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Grand Total:</th>
                                                    <td><?php echo $inv['grand_total']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div class="col-12">
                                        <a href="salesreturn_pdf.php?id=<?php echo $inv['id']; ?>" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                        <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                            Payment
                                        </button>
                                         <a href="viewsalesreturn_pdf.php?id=<?php echo $inv['id']; ?>"
                                            target="_blank"
                                            class="btn btn-primary float-right"
                                            style="margin-right:5px;">
                                            <i class="fas fa-download"></i> Generate PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.invoice -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>

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

    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- AdminLTE App -->
    <script src="dist/js/adminlte2167.js?v=3.2.0"></script>
</body>
<!-- , Sat, 29 Nov 2025 06:35:23 GMT -->

</html>