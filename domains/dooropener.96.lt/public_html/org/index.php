<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


header('Content-Type: text/html; charset=utf-8');
$user = filter_input(INPUT_POST, "user");
$pass = filter_input(INPUT_POST, "pass");

$servername = "mysql.hostinger.in.th";
$username = "u342246937_door";
$password = "1234567";
$databasename = "u342246937_door";
$tablename = "user";

$conn = new mysqli($servername, $username, $password, $databasename);
//Check connection
if ($conn->connect_error) {
	die("Connection Failed: " . $conn->connect_error);
	exit();
}

$conn->query(("SET NAMES UTF8")); //set format of data

$sql = "
   SELECT *
   FROM `$tablename`
   WHERE `user` = '$user'
   AND `pass` = '$pass'
      ";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
	print "login_ok";
} else {
	print "login_fail";
}


$conn->close();
