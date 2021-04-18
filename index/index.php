<?php
session_start();

	setLocale(LC_ALL, 'de_DE');
	$office = iconv('utf-8', 'ascii//TRANSLIT', $_SERVER['HTTP_OFFICE_HEADER']);
	$status = 0;	// office close (0 - default: closed)
	if (strcmp($office,"office_open") == 0)
	$status = 1; else
	$status = 0;

	$user = trim($_SERVER['REMOTE_USER']);
	
	// sanity check's ...
	if ($status == 0) {
		header('Location: /index.php');
		die();
		exit;
	}

	if (strcmp($user,'log') == 0) {
		header('Location: /logout/index.php');
		die();
		exit;
	}

	// switch to Windows-XP
	header('Location: /applications/web_mswin/index/index.php');
?>
