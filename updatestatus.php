<?php
include("config.php");
include("check_session.php");

header('Content-Type: application/json');
$response = [];

if (isset($_POST['id']) && isset($_POST['status']) && isset($_POST['action'])) {

    $id = $_POST['id'];
    $status = $_POST['status'];
    $action = $_POST['action'];
    $msg = ($status == 1) ? 'On' : 'Off';

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
    $sql = "UPDATE $table SET status='$status' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => true, "message" => "Status $msg"]);
    } else {
        echo json_encode(["status" => false, "message" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["status" => false, "message" => "Missing parameters"]);
}
