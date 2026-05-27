// $conn = mysqli_connect('127.0.0.1', 'root', '', 'inventory_management');
// if($conn)
// {
//     echo " Connection Successfull";
// }
// else{
//     echo " Connection fail";

// }
<?php
$conn = mysqli_connect(
    'zephyr.proxy.rlwy.net',
    'root',
    'ZLyoLnfsiwaLksmIgumWpgNXkIkLpLdd',
    'railway',
    59917
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>