<?php
include("config.php");

$id = $_POST['id'];

// invoice ane users
$invoice = mysqli_query($conn, "
    select i.*, u.user_name 
    from invoice i
    left join users u ON i.user_id = u.id
    where i.id='$id'
");
$inv = mysqli_fetch_assoc($invoice);

//invoice_details ane product , unit , tax
$items = mysqli_query($conn, "
    select d.*,  p.name as product_name, u.name as unit_name , i.discount
    from invoice_details d
    left join invoice i on d.invoice_id = i.id
    left join products p on d.product_id = p.id
    left join units u on d.unit_id = u.id
    WHERE d.invoice_id='$id'
");

//invoice_details ane unit
// $u = mysqli_query($conn, "select i.*,u.name
// from invoice_details i
// left join units u on i.unit_id=u.id
// where i.invoice_id='$id'
// ");
// $unit = mysqli_fetch_assoc($u);

//invoice ane invoice_details

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container-fluid p-3">
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="font-weight-bold">Invoice Number :</label>
                <p><?= $inv['invoice_no'] ?></p>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Invoice Date :</label>
                <p><?php echo $inv['invoice_date']; ?></p>

            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Supplier Name :</label>
                <p><?php echo $inv['user_name']; ?></p>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Order Status :</label>
                <p>Not Delivered</p>
            </div>
        </div>
        <div class="row mb-3">

            <div class="col-md-3">
                <label class="font-weight-bold">Payment Status :</label>
                <p><?php echo $inv['payment_status']; ?></p>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Shipping address :</label>
                <p><?php echo $inv['shipping_address']; ?></p>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Total amount :</label>
                <p><?php echo $inv['grand_total']; ?></p>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Paid amount :</label>
                <p><?php echo $inv['paid_amount']; ?></p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="font-weight-bold">Due amount :</label>
                <p><?php echo $inv['due_amount']; ?></p>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Discount :</label>
                <p><?php echo $inv['discount']; ?></p>
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">Order Tax :</label>
                <p>0</p>
            </div>
        </div>
    </div>
    <!-- =======================
        ORDER ITEMS TABLE
    ======================== -->
    <h5 class="mb-3">Order Items</h5>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th style="width: 25%;">Product</th>
                    <th style="width: 10%;">Quantity</th>
                    <th style="width: 12%;">Unit</th>
                    <th style="width: 12%;">Rate</th>
                    <th style="width: 10%;">Discount</th>
                    <th style="width: 15%;">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $total_qty = 0;
                $grand_total = 0;

                while ($row = mysqli_fetch_assoc($items)) {
                    $total_qty = $total_qty + $row['qty'];
                    $grand_total = $grand_total + $row['total_price'];
                    $discount = $row['discount'];
                ?>
                    <tr>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['qty']; ?></td>
                        <td><?php echo $row['unit_name']; ?></td>
                        <td><?php echo $row['rate']; ?></td>
                        <td>0</td>
                        <td><?php echo $row['total_price']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>

            <tfoot>
                <tr class="font-weight-bold">
                    <td>Total</td>
                    <td><?php echo $total_qty; ?></td>
                    <td>-</td>
                    <td>-</td>
                    <td><?php echo $discount; ?></td>
                    <td><?php echo $grand_total; ?></td>
                </tr>
            </tfoot>

        </table>
    </div>

</body>

</html>