<?php
include("config.php");
include("check_session.php");

header('Content-Type: application/json');
$response = [];

if (isset($_POST['id']) && isset($_POST['action'])) {

    $id = $_POST['id'];
    $action = $_POST['action'];

    // Choose table and ID column
    if ($action === "users") {
        $table = "users";
    } elseif ($action === "brands") {
        $table = "brands";
    } elseif ($action === "category") {
        $table = "category";
    } elseif ($action === "units") {
        $table = "units";
    } elseif ($action === "products") {
        $table = "products";
    } elseif ($action === "invoice") {
        $table = "invoice";
    } else {
        echo json_encode(["status" => false, "message" => "Invalid action"]);
        exit;
    }

    // Update query
    $query = "DELETE FROM $table WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        $json['status'] = true;
        $json['message'] = "Deleted Successfully";
    } else {
        $json['status'] = false;
        $json['message'] = "Deleted Fail..";
    }
} else {
    echo json_encode(["status" => false, "message" => "Missing parameters"]);
}
echo json_encode($json);
