<?php

header("Content-Type: text/html charset=utf-8");


$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");
$email = filter_input(INPUT_POST, "email");


$timezone = +7;
$datetime = gmdate("Y-m-d H:i:s", time() + 3600 * ($timezone + date("I")));

$con = @mysql_connect('mysql.hostinger.in.th', 'u342246937_door', '1234567') or die(mysql_error());

mysql_select_db('u342246937_door') or die(mysql_error());
mysql_query("SET NAMES UTF8");

if ($username != null || $username != "" && $password != null || $password != "" && $email != null || $email != "") {

	$sql = "INSERT INTO signup(username, password, email)";
	$sql .= "VALUE('$username', '$password', '$email')";
} else {

	mysql_close();
	print "have not value to update";
	exit();
}

$res = mysql_query($sql);

mysql_close();

if ($res == TRUE) {

	print "insert to table ok";
} else {

	print "insert to table fail";
}