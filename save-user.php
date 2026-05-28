<?php

session_start();

$conn = mysqli_connect(
"localhost",
"root",
"",
"inventory_management"
);

$data=json_decode(
file_get_contents("php://input"),
true
);

$name=$data['name'];
$email=$data['email'];


$check=mysqli_query(
$conn,
"SELECT * FROM users
WHERE email='$email'"
);

if(mysqli_num_rows($check)==0){

mysqli_query(
$conn,

"INSERT INTO users
(name,email)

VALUES(
'$name',
'$email',
)"
);

}

$_SESSION['email']=$email;

echo "success";
?>