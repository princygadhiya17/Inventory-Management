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
