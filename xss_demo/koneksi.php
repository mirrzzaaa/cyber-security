<?php

$host = "localhost";
$user = "blog";
$pass = "blog";
$db   = "blog";

$conn = mysqli_connect($host, $user, $pass);
mysqli_select_db($conn, $db);
