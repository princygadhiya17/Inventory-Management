<?php
include("config.php");
include("check_session.php");
$json = [];

if (isset($_POST['edit_id'])) {

    $id = $_POST['edit_id'];

    $q = mysqli_query($conn, "SELECT * FROM category WHERE id = '$id'");
    $json['status'] = true;
    $json['message'] = "Recored Fetched!";
    $json['detail'] = mysqli_fetch_assoc($q);
}

if (isset($_POST['id'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $target_dir = "upload/category/";
    $file_name = "";

    if (!empty($_FILES["image"]["name"])) {

        $file_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = array("jpg", "jpeg", "png");

        if (in_array($file_type, $allowed_types)) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }
    } else {

        if ($id != 0) {
            $query = "SELECT image FROM category WHERE id = $id";
            $exec = mysqli_query($conn, $query);
            $fetch = mysqli_fetch_assoc($exec);
            $file_name = $fetch['image'];
        } else {
            $file_name = "";
        }
    }

    if ($id == 0) {

        $check = mysqli_query($conn, "SELECT * FROM category  WHERE name='$name'");
        if (mysqli_num_rows($check) > 0) {
            $json['status'] = false;
            $json['message'] = "Category Already Exist!";
        } else {
            $sql = "INSERT INTO category (name, image) VALUES ('$name', '$file_name')";
            if (mysqli_query($conn, $sql)) {
                $json['status'] = true;
                $json['message'] = "Inserted Successfully";
            } else {
                $json['status'] = false;
                $json['message'] = "Inserted Fail!";
            }
        }
    } else {

        $check = mysqli_query($conn, "SELECT * FROM category  WHERE name='$name' and id!=$id");

        if (mysqli_num_rows($check) > 0) {
            $json['status'] = false;
            $json['message'] = "Category Already Exist!";
        } else {
            $sql = "UPDATE category SET name='$name', image='$file_name' WHERE id=$id";
            if (mysqli_query($conn, $sql)) {
                $json['status'] = true;
                $json['message'] = "Updated Successfully";
            } else {
                $json['status'] = false;
                $json['message'] = "Updated Fail!";
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($json);
