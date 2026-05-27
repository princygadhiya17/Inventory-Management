<?php
include("config.php");
include("check_session.php");
?>
<!DOCTYPE html>
<?php
if (isset($_POST['add'])) {
    $now = date('Y-m-d H:i:s');

    $name = $_POST['name'];
    $target_dir = "upload/brand/";
    $file_name = basename($_FILES["logo"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = array("jpg", "jpeg", "png");
    if (isset($_FILES["logo"]["tmp_name"]) && in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            $file_name = $file_name;
        } else {
            $file_name = "";
        }
    } else {
        if (isset($_GET['id'])) {
            $query = "select logo from brands where id=" . $_GET['id'];
            $exec = mysqli_query($conn, $query);
            $fetch = mysqli_fetch_assoc($exec);
            $file_name = $fetch['logo'];
        } else {
            $file_name = "";
        }
    }

    if (isset($_GET['id'])) {

        $check = mysqli_query(
            $conn,
            "SELECT * FROM brands
        WHERE (name='$name')
        AND id != " . $_GET['id']
        );

        if (mysqli_num_rows($check) > 0) {
            header("Location: brand.php?alert=danger&msg=brand Already Exist!");
            exit();
        }

        $sql = "UPDATE brands
               SET  logo='$file_name',name='$name'
               WHERE id=" . $_GET['id'];
        $msg = 'Updated';
    } else {

        $check = mysqli_query(
            $conn,
            "SELECT * FROM brands
        WHERE (name='$name')"
        );

        if (mysqli_num_rows($check) > 0) {
            header("Location: brand.php?alert=danger&msg=brand Already Exist!");
            exit();
        }

        $sql = "INSERT INTO brands (logo, name, created_at, updated_at)
        VALUES ('$file_name', '$name', '$now', '$now')";
        $msg = 'Created';
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: brand.php?alert=success&msg=Brand $msg Success");
        exit();
    }
}
//fetching existing user for edit form

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $query1 = "select * from brands where id=$id";
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
                            <h1>Add Brand</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Brands</li>
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
                                    <h3 class="card-title">Brand Details</h3>
                                </div>
                                <div class="card-body">
                                    <!-- form start -->
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo (isset($_GET['id']))  ? $_GET['id'] : 0; ?>">

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="fullname">Logo</label>
                                                <input type="file" id="file" name="logo" class="form-control" <?php if (!isset($_GET['id'])) {
                                                                                                                    echo "required";
                                                                                                                } ?>>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="brandname">Brand Name</label>
                                                <input type="text" id="brandname" name="name" class="form-control" value="<?php if (isset($_GET['id'])) {
                                                                                                                                echo $fetch1['name'] ?? '';
                                                                                                                            } ?>" required>
                                            </div>

                                            <div class="col-12 mt-3 mb-3 text-left">
                                                <button type="submit" name="add" class="btn btn-md btn-primary">Save Brand</button>
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

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- AdminLTE App -->
    <script src="dist/js/adminlte2167.js?v=3.2.0"></script>

</body>
<!-- , Sat, 29 Nov 2025 06:35:23 GMT -->

</html>