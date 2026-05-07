<?php
include("config.php");
include("check_session.php");
?>
<!DOCTYPE html>
<?php
if (isset($_POST['add'])) {

    $type = $_POST['type'];
    $name = $_POST['name'];
    $brand_id = $_POST['brand_id'];
    $cat_id = $_POST['cat_id'];
    $unit_id = $_POST['unit_id'];
    $quantity_alert = $_POST['quantity_alert'];
    $barcode = $_POST['barcode'];
    $purchase_price = $_POST['purchase_price'];
    $sales_price = $_POST['sales_price'];
    $mrp_price = $_POST['mrp_price'];
    $expiry_date = $_POST['expiry_date'];
    $description = $_POST['description'];


    $target_dir = "upload/product/";
    $file_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = array("jpg", "jpeg", "png");
    if (isset($_FILES["image"]["tmp_name"]) && in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $file_name = $file_name;
        } else {
            $file_name = "";
        }
    } else {
        if (isset($_GET['id'])) {
            $query = "select image from products where id=" . $_GET['id'];
            $exec = mysqli_query($conn, $query);
            $fetch = mysqli_fetch_assoc($exec);
            $file_name = $fetch['image'];
        } else {
            $file_name = "";
        }
    }

    if (isset($_GET['id'])) {

        $sql = "update products
                SET type='$type',name='$name',brand_id='$brand_id',cat_id='$cat_id',unit_id='$unit_id',image='$file_name',quantity_alert='$quantity_alert',barcode='$barcode',purchase_price='$purchase_price',sales_price='$sales_price',mrp_price='$mrp_price',expiry_date='$expiry_date',description='$description'
                WHERE id=" . $_GET['id'];
        $msg = 'Updated';
    } else {
        $sql = "INSERT INTO products(type,name,brand_id,cat_id,unit_id,image,quantity_alert,barcode,purchase_price,sales_price,mrp_price,expiry_date,description)
        values('$type','$name','$brand_id','$cat_id','$unit_id','$file_name','$quantity_alert','$barcode','$purchase_price','$sales_price','$mrp_price','$expiry_date','$description')";
        $msg = 'Created';
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: product.php?alert=success&msg=Product $msg Success");
        exit();
    }
}
//fetching existing user for edit form

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $query1 = "select * from products where id=$id";
    $exec1 = mysqli_query($conn, $query1);
    $fetch1 = mysqli_fetch_assoc($exec1);
}


$brand_q = mysqli_query($conn, "SELECT id,name FROM brands");
$cat_q = mysqli_query($conn, "SELECT id,name FROM category");
$unit_q = mysqli_query($conn, "SELECT id,name FROM units");

?>
<html lang="en">
<?php include("header.php"); ?>
<!-- Bootstrap Icons -->
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
                            <h1>Add Product</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Product Form</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Product Details</h3>
                                </div>
                                <div class="card-body">

                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo (isset($_GET['id']))  ? $_GET['id'] : 0; ?>">
                                        <input type="hidden" name="type" value="single">
                                        <div class="row">
                                            <!-- Name -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" class="form-control" name="name" required placeholder="Enter Product Name" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                            echo $fetch1['name'];
                                                                                                                                                        } ?>" required>
                                            </div>

                                            <!-- Image -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Product Image</label>
                                                <input type="file" class="form-control" name="image" <?php if (!isset($_GET['id'])) {
                                                                                                            echo "required";
                                                                                                        } ?>>
                                            </div>

                                            <!-- Quantity Alert -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Quantity Alert</label>
                                                <input type="number" class="form-control" name="quantity_alert" required placeholder="Enter Quantity Alert" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                                        echo $fetch1['quantity_alert'];
                                                                                                                                                                    } ?>" required>
                                            </div>

                                            <!-- Barcode -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Barcode</label>
                                                <input type="number" class="form-control" name="barcode" required placeholder="Enter Barcode Number" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                                echo $fetch1['barcode'];
                                                                                                                                                            } ?>" required>
                                            </div>

                                            <!-- Brand -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Brand</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="brand_id">
                                                        <option value="" disabled selected>Select Brand</option>
                                                        <?php
                                                        //fetch brand id with name
                                                        while ($b = mysqli_fetch_assoc($brand_q)) { ?>
                                                            <option value="<?php echo $b['id']; ?>"
                                                                <?php if (isset($_GET['id']) && $fetch1['brand_id'] == $b['id']) echo "selected"; ?>>
                                                                <?php echo $b['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <a href="add_brand.php" class="btn btn-secondary me-2">
                                                        <i class="bi bi-plus-circle"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Category -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Category</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="cat_id">
                                                        <option value="" disabled selected>Select Category</option>
                                                        <?php while ($c = mysqli_fetch_assoc($cat_q)) { ?>
                                                            <option value="<?php echo $c['id']; ?>"
                                                                <?php if (isset($_GET['id']) && $fetch1['cat_id'] == $c['id']) echo "selected"; ?>>
                                                                <?php echo $c['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>

                                                    <button class="btn btn-secondary" type="button">
                                                        <i class="bi bi-plus-circle"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Unit -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Unit</label>
                                                <div class="input-group">
                                                    <select class="form-select" name="unit_id">
                                                        <option value="" disabled selected>Select Unit</option>
                                                        <?php while ($u = mysqli_fetch_assoc($unit_q)) { ?>
                                                            <option value="<?php echo $u['id']; ?>"
                                                                <?php if (isset($_GET['id']) && $fetch1['unit_id'] == $u['id']) echo "selected"; ?>>
                                                                <?php echo $u['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>

                                                    <button class="btn btn-secondary" type="button">
                                                        <i class="bi bi-plus-circle"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Type -->
                                            <!-- <div class="mb-3">
                                                <label class="form-label">Type</label>
                                                <select class="form-select" name="type">
                                                    <option value="single">Single</option>
                                                    <option value="variatiants">Variants</option>
                                                </select>
                                            </div> -->

                                            <!-- Purchase Price -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Purchase Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="number" step="0.01" class="form-control" name="purchase_price" placeholder="Enter Purchase Price" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                                                echo $fetch1['purchase_price'];
                                                                                                                                                                            } ?>" required>
                                                </div>
                                            </div>

                                            <!-- Sales Price -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Sales Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="number" step="0.01" class="form-control" name="sales_price" placeholder="Enter Sales Price" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                                        echo $fetch1['sales_price'];
                                                                                                                                                                    } ?>" required>
                                                </div>
                                            </div>

                                            <!-- MRP Price -->
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">MRP Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="number" step="0.01" class="form-control" name="mrp_price" placeholder="Enter Mrp price" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                                    echo $fetch1['mrp_price'];
                                                                                                                                                                } ?>" required>
                                                </div>
                                            </div>

                                            <!-- Expiry Date -->
                                            <div class="col-md-3 mb-6">
                                                <label class="form-label">Expiry Date</label>
                                                <input type="date" class="form-control" name="expiry_date" min="<?php echo date('Y-m-d'); ?>" value="<?php if (isset($_GET['id'])) {
                                                                                                                                                            echo $fetch1['expiry_date'];
                                                                                                                                                        } ?>" required>
                                            </div>

                                            <!-- Description -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" name="description" rows="5" placeholder="Enter Decription" required><?php if (isset($_GET['id'])) {
                                                                                                                                                        echo $fetch1['description'];
                                                                                                                                                    } ?></textarea>
                                            </div>

                                            <div class="col-12 mt-3 mb-3 text-right">
                                                <button type="submit" name="add" class="btn btn-md btn-primary">Save Product</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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