<?php
include("config.php");
include("check_session.php");
$json = [];

if (isset($_POST['edit_id'])) {

    $id = $_POST['edit_id'];

    $q = mysqli_query($conn, "SELECT * FROM units WHERE id = '$id'");
    $json['status'] = true;
    $json['message'] = "Recored Fetched!";
    $json['detail'] = mysqli_fetch_assoc($q);
}

if (isset($_POST['id'])) {
    $id   = $_POST['id'];       // IMPORTANT: define ID
    $name = $_POST['name'];
    if ($id == 0) {

        $check = mysqli_query($conn, "SELECT * FROM units WHERE name='$name'");

        if (mysqli_num_rows($check) > 0) {
            $json['status'] = false;
            $json['message'] = "Unit Already Exist!";
        } else {
            $sql = "INSERT INTO units (name) VALUES ('$name')";
            if (mysqli_query($conn, $sql)) {
                $json['status'] = true;
                $json['message'] = "Inserted Successfully";
            } else {
                $json['status'] = false;
                $json['message'] = "Inserted Fail!";
            }
        }
    } else {

        $check = mysqli_query($conn, "SELECT * FROM units WHERE name='$name' and id!=$id");

        if (mysqli_num_rows($check) > 0) {
            $json['status'] = false;
            $json['message'] = "Unit Already Exist!";
        } else {
            $sql = "UPDATE Units SET name='$name' WHERE id=$id";
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
