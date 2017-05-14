<?php

header("Content-Type:text/html; charset=utf-8");

$host = "localhost";
$db_username = "dooropen_door";
$db_password = "1234567";
$db_name = "dooropen_door";

$conn = new mysqli($host, $db_username, $db_password, $db_name);
//Check connection
if ($conn->connect_error) {
   die("Connection Failed: " . $conn->connect_error);
   exit();
}
$conn->query(("SET NAMES UTF8")); //set format of data
$doorname = $_GET["name"];
$sensor = $_GET["sensor"];
$sql2 = "update adddevice set sensor ='$sensor' where device = '$doorname'";
$result = $conn->query($sql2);

$sql = "select * from adddevice where device='$doorname'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
   while ($row = $result->fetch_assoc()) {
      echo $row["device"] . $row["status"] . $row["sensor"];
      break;
   }
   //  $result = $conn->query($sql);
}



$conn->close();
