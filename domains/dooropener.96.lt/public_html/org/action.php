<?php

header("content-type:text/html charset=utf-8");

$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");

$conn = @mysql_connect('localhost', 'dooropen_door', '1234567') or die(mysql_error());
mysql_select_db('dooropen_door') or die(mysql_error());
mysql_query("SET NAME UTF8");
$sql = "SELECT*FROM user WHERE user = '$username' AND pass = '$password'";
$res = mysql_query($sql);
$row = mysql_fetch_assoc($res);
mysql_close();
if (sizeof($row) == 3) {
   print "login_ok";
} else {
   print "login_fail";
}