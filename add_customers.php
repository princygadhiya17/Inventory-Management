<?php
include("config.php");
include("check_session.php");
?>
<!DOCTYPE html>
<?php
if (isset($_POST['add'])) {

    $user_name = $_POST['user_name'];
    $user_type = $_POST['user_type'];
    $user_mobile = $_POST['user_mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $billing_address = $_POST['billing_address'];
    $shipping_address = $_POST['shipping_address'];

    $target_dir = "upload/customer/";
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
            $query = "select image from users where id=" . $_GET['id'];
            $exec = mysqli_query($conn, $query);
            $fetch = mysqli_fetch_assoc($exec);
            $file_name = $fetch['image'];
        } else {
            $file_name = "";
        }
    }

    if (isset($_GET['id'])) {

        // duplicate users for mobile and email check
        $check = mysqli_query(
            $conn,
            "SELECT * FROM users 
        WHERE (user_mobile='$user_mobile' OR email='$email')
        AND id != " . $_GET['id']
        );

        if (mysqli_num_rows($check) > 0) {
            header("Location: customers.php?alert=danger&msg=User Already Exist!");
            exit();
        }

        $sql = "UPDATE users
               SET  image='$file_name',user_name='$user_name',user_type='$user_type',user_mobile='$user_mobile',email='$email',password='$password',billing_address='$billing_address',shipping_address='$shipping_address'
               WHERE id=" . $_GET['id'];
        $msg = 'Updated';
    } else {

        // duplicate users for mobile and email check
        $check = mysqli_query(
            $conn,
            "SELECT * FROM users 
        WHERE (user_mobile='$user_mobile' OR email='$email')"
        );

        if (mysqli_num_rows($check) > 0) {
            header("Location: customers.php?alert=danger&msg=User Already Exist!");
            exit();
        }

        $sql = "INSERT INTO users(image,user_name,user_type,user_mobile,email,password,billing_address,shipping_address)
                   values('$file_name','$user_name','$user_type','$user_mobile','$email','$password','$billing_address','$shipping_address')";
        $msg = 'Created';
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: customers.php?alert=success&msg=User $msg Success");
        exit();
    }
}
//fetching existing user for edit form

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $query1 = "select * from users where id=$id";
    $exec1 = mysqli_query($conn, $query1);
    $fetch1 = mysqli_fetch_assoc($exec1);
}

?>
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
                            <h1>Add Customer</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">customers Form</li>
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
                                    <h3 class="card-title">Customer Details</h3>
                                </div>
                                <div class="card-body">
                                    <!-- form start -->
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo (isset($_GET['id']))  ? $_GET['id'] : 0; ?>">
                                        <input type="hidden" name="user_type" value="Customer">
                                        <div class="row">
                                            <div class="col-md-2 mb-3">
                                                <label for="fullname">Image</label>
                                                <input type="file" id="file" name="image" class="form-control" <?php if (!isset($_GET['id'])) {
                                                                                                                    echo "required";
                                                                                                                } ?>>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="username">User Name</label>
                                                <input type="text" id="username" name="user_name" class="form-control" value="<?php if (isset($_GET['id'])) {
                                                                                                                                    echo $fetch1['user_name'];
                                                                                                                                } ?>" required>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="phone">Mobile</label>
                                                <input type="number" id="phone" name="user_mobile" class="form-control" value="<?php if (isset($_GET['id'])) {
                                                                                                                                    echo $fetch1['user_mobile'];
                                                                                                                                } ?>" required pattern="^(\d{10}|\d{12})$"
                                                    maxlength="12">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="email">Email</label>
                                                <input type="email" id="email" name="email" class="form-control" required value="<?php if (isset($_GET['id'])) {
                                                                                                                                        echo $fetch1['email'];
                                                                                                                                    } ?>">
                                            </div>
                                            <div class="col-md-3 mb-6">
                                                <label for="password">Password</label>
                                                <input type="password" id="password" name="password" class="form-control" value="<?php if (isset($_GET['id'])) {
                                                                                                                                        echo $fetch1['password'];
                                                                                                                                    } ?>" required minlength="6">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="billingaddress">Billing Address</label>
                                                <textarea class="form-control" name="billing_address" id="billing_address" rows="5" required><?php if (isset($_GET['id'])) {
                                                                                                                                                    echo $fetch1['billing_address'];
                                                                                                                                                } ?></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="shippingaddress">Shipping Address</label>
                                                <textarea class="form-control" name="shipping_address" id="shipping_address" rows="5" required><?php if (isset($_GET['id'])) {
                                                                                                                                                    echo $fetch1['shipping_address'];
                                                                                                                                                } ?></textarea>
                                            </div>
                                            <div class="col-12 mt-3 mb-3 text-right">
                                                <button type="submit" name="add" class="btn btn-md btn-primary">Save Customer</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-header -->
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