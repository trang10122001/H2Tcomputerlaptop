<?php
	$SERVER = 'localhost';
	$USERNAME = 'root';
	$PASSWORD = '';
	$DBNAME = 'nhncomputer';

	$connect = new mysqli($SERVER, $USERNAME, $PASSWORD, $DBNAME);

	if ($connect->connect_error) {
		die("Error".$connect->connect_error);
	}
	$connect->set_charset('utf8');
?>