<?php

header("Content-Type:text/html; charset=utf-8");
$command = filter_input(INPUT_POST, "command");
$command2 = filter_input(INPUT_GET, "command2");

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

switch ($command) {
   case "login":
      $user = filter_input(INPUT_POST, "username");
      $pass = filter_input(INPUT_POST, "password");
      $sql = "select * from user where user = '$user' and pass = '$pass'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
         print "login_ok";
      } else {
         print "login_fail";
      }
      break;
   case "managedevice":
      $user = filter_input(INPUT_POST, "username");
      $sql = "select * from adddevice where user = '$user' "; // รูปแบบคำสั่งการเรียกข้อมูลทั้งหมดจาก Table
      $result = $conn->query($sql); // ส่งคำสั่งไปหาฐานข้อมูล ข้อมูลที่มีจะส่งกลับมาที่ $result
      if ($result->num_rows > 0) { // ฐานมีข้อมูลที่ต้องการอยู่จริง จะทำงานในลูปนี้
         while ($row = $result->fetch_assoc()) { // วนเก็บข้อมูลใส่ตัวแปร json จนหมด
            echo $row["device"] . "<br>" . $row["ip"] . "<br><br>";
         }
      }
      break;
   case "adddevice":
      $user = filter_input(INPUT_POST, "username");
      $device = filter_input(INPUT_POST, "device_name");
      $ip = filter_input(INPUT_POST, "device_ip");
      $sql = "insert into adddevice (device, ip, user) values ('$device', '$ip', '$user')";
      if ($conn->query($sql) === TRUE) {
         echo "add_finished";
      } else {
         echo "add_failed";
      }
      break;
   case "adduser":
      $user = filter_input(INPUT_POST, "username");
      $pass = filter_input(INPUT_POST, "password");
      $conpass = filter_input(INPUT_POST, "confirm_password");
      $email = filter_input(INPUT_POST, "e_mail");
      $sql = "insert into user (user, pass, email,conpass) values ('$user', '$pass', '$email', '$conpass')";
      $sql2 = "insert into adddevice (device, ip, user, status,sensor) values ('-choose-', '0', '$user', '9','9')";

      if ($conn->query($sql) === TRUE) {
         echo "add_finished";
      } else {
         echo "add_failed";
      }
      if ($conn->query($sql2) === TRUE) {
         echo "add_finished";
      } else {
         echo "add_failed";
      }
      break;
   case "deletedevice":
      $user = filter_input(INPUT_POST, "username");
      $device = filter_input(INPUT_POST, "device_name");
      $sql = "delete from adddevice where device = '$device' and user = '$user' ";
      if ($conn->query($sql) === TRUE) {
         $sql = "select * from adddevice where user = '$user' "; // รูปแบบคำสั่งการเรียกข้อมูลทั้งหมดจาก Table
         $result = $conn->query($sql); // ส่งคำสั่งไปหาฐานข้อมูล ข้อมูลที่มีจะส่งกลับมาที่ $result
         if ($result->num_rows > 0) { // ฐานมีข้อมูลที่ต้องการอยู่จริง จะทำงานในลูปนี้
            while ($row = $result->fetch_assoc()) { // วนเก็บข้อมูลใส่ตัวแปร json จนหมด
               echo $row["device"] . "<br>" . $row["ip"] . "<br><br>";
            }
         }
      } else {
         echo "delete_failed";
      }
      break;
   case "update_status":
      //$user = filter_input(INPUT_POST, "username");
      $sql = "select * from adddevice  ";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) { // ฐานมีข้อมูลที่ต้องการอยู่จริง จะทำงานในลูปนี้
         while ($row = $result->fetch_assoc()) { // วนเก็บข้อมูลใส่ตัวแปร json จนหมด
            echo $row["device"] . "  " . $row["user"] . "<br><br>";
         }
      } else {
         echo "empty";
      }
      break;
//   case "setdoor_status":
//      $device = filter_input(INPUT_POST, "doorname");
//      $sql = "update adddevice set status = 1 where device = '$device' ";
//      $result = $conn->query($sql);
   case "update_status_door":
      print "hello";
      $device = filter_input(INPUT_POST, "doorname");
//      $sensor = filter_input(INPUT_POST, "sensor");
      $status = filter_input(INPUT_POST, "status");
      $sql = "update adddevice set status ='$status' where device = '$device'";
//      $sql2 = "update adddevice set sensor ='$sensor' where device = '$device'";
      $result = $conn->query($sql);
//      $result = $conn->query($sql2);
      break;

   default : break;
}

if ($command2 == "getdoor_status") {
   $device = filter_input(INPUT_GET, "doorname");
   $sql = "select * from adddevice where device = '$device' and status = 1";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         echo $row["device"] . "\r\n";
      }
//      $sql = "update adddevice set status = 0 where device = '$device' ";
      $result = $conn->query($sql);
   }
}
if ($command2 == "http_status") {
   echo "hello";
}
$conn->close();
