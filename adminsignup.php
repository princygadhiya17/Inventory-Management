<?php
include "config.php";

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE user_type='Admin'");
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 0) {
    die("Admin already exists. Please <a href='login.php'>Login</a>.");
}

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $mobile   = $_POST['mobile'];

    $sql = "INSERT INTO users (user_name, user_type, user_mobile, email, status, password)
            VALUES ('$username','Admin','$mobile','$email',1,'$password')";

    if (mysqli_query($conn, $sql)) {
        echo "<p class='success'>Admin created successfully. <a href='login.php'>Login</a></p>";
        exit();
    } else {
        echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>First Admin Signup</title>
    <style>
        body {
            font-family: Arial;
            background-color: #e8f5e9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #4caf50;
            width: 350px;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #4caf50;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4caf50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #388e3c;
        }

        .success {
            color: #2e7d32;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .error {
            color: #c62828;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        a {
            color: #2e7d32;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <form method="POST">
        <h2>First Admin Signup</h2>
        <input type="text" name="user_name" placeholder="Admin Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="mobile" placeholder="Mobile">
        <input type="password" name="password" placeholder="Password" required>
        <button name="signup">Signup</button>
    </form>
</body>

</html>