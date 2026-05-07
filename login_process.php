<?php
session_start();
include "config.php";

if (isset($_POST['login'])) {

    $email    = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);
        if ($row['password'] == $password) {

            // Set session
            $_SESSION['user_id']   = $row['id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['email'] = $row['email'];

            header("Location: index.php");
            exit();
        }
    } else {
        echo "<script>
                alert('email Not Found');
                window.location.href='login.php';
              </script>";
        exit();
    }
}
