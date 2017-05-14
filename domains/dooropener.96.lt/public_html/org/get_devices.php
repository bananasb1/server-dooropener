<?php

header("Content-Type:text/html; charset=utf-8");
$user = filter_input(INPUT_POST, "user");

$host = "mysql.hostinger.in.th";
$db_username = "u342246937_door";
$db_password = "1234567";
$db_name = "u342246937_door";
$tb_name = "adddevice";

$conn = new mysqli($host, $db_username, $db_password, $db_name);
if (!$db_name) {
	echo "error";
	exit();
}
$conn->query("SET NAMES UTF8");
$sql = "select * from $tb_name where user = '$user' "; // รูปแบบคำสั่งการเรียกข้อมูลทั้งหมดจาก Table
$result = $conn->query($sql); // ส่งคำสั่งไปหาฐานข้อมูล ข้อมูลที่มีจะส่งกลับมาที่ $result
if ($result->num_rows > 0) { // ฐานมีข้อมูลที่ต้องการอยู่จริง จะทำงานในลูปนี้
	while ($row = $result->fetch_assoc()) { // วนเก็บข้อมูลใส่ตัวแปร json จนหมด
		echo $row["device"] . "<br>" . $row["ip"] . "<br><br>";
	}
}
$conn->close();



