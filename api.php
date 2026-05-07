<?php
include("config.php");
header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {

    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $data = mysqli_fetch_assoc($result);
    echo json_encode($data);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_name = $input['user_name'];
    $user_type = $input['user_type'];
    $user_mobile = $input['user_mobile'];
    $email = $input['email'];
    $password = $input['password'];
    $billing_address = $input['billing_address'];
    $shipping_address = $input['shipping_address'];

    $sql = "INSERT INTO users 
        (user_name, user_type, user_mobile, email, password, billing_address, shipping_address)
        VALUES 
        ('$user_name','$user_type','$user_mobile','$email','$password','$billing_address','$shipping_address')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(["message" => "user added successfully"]);
    } else {
        echo json_encode(["message" => "user not added"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $id = $_GET['id'];

    $user_name = $input['user_name'];
    $user_type = $input['user_type'];
    $user_mobile = $input['user_mobile'];
    $email = $input['email'];
    $password = $input['password'];
    $billing_address = $input['billing_address'];
    $shipping_address = $input['shipping_address'];

    $sql = "UPDATE users
               SET user_name='$user_name',user_type='$user_type',user_mobile='$user_mobile',email='$email',password='$password',billing_address='$billing_address',shipping_address='$shipping_address'
               WHERE id=$id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(["message" => "user updated successfully"]);
    } else {
        echo json_encode(["message" => "user not updated"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];

    $sql = "delete from users where id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode(["message" => "user deleted successfully"]);
    } else {
        echo json_encode(["message" => "user not deleted"]);
    }
} else {

    $result = mysqli_query($conn, "SELECT * FROM users");
    $users = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    echo json_encode($users);
}
