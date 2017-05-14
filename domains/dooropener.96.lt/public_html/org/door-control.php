<?php

header("content-type:text/html charset=utf-8");
$command = filter_input(INPUT_POST, "command");

if ($command == "request") {
	$myfile = fopen("door-control.txt", "r") or die("unable to open file!");
	$cmd = fread($myfile, filesize("door-control.txt"));
	fclose($myfile);
	print $cmd;
} else {
	print "off";
}
exit();
