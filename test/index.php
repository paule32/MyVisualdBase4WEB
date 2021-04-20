<?php
// ------------------------------------------------------
// File    : test/index.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------
?>
<html lang='en'>
<head>
	<meta charset="utf-8">
 
	<meta name="author"      content="Jens Kallup [paule32]">
	<meta name="copyright"   content="Jens Kallup">
	<meta name="keywords"    content="kallup, css, html, theme, desktop, windows, xp">
	<meta name="description" content="A Windows XP desktop in HTML, CSS and JavaScript">
	<meta name="robots" 	 content="index, nofollow">

	<meta http-equiv="content-type"    content="text/html; charset=utf-8">
	<meta http-equiv="expires"         content="0">
	<meta http-equiv="cache-control"   content="max-age=0">
	<meta http-equiv="cache-control"   content="no-cache">
	<meta http-equiv="pragma"          content="no-cache">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<link rel="stylesheet" type="text/css" href="/src/tools/js/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/src/tools/js/easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="/src/tools/js/easyui/themes/color.css">
	
	<title>DEMO - desktop</title>
	
	<script type="text/javascript" src="/src/tools/js/base/jquery-min.3.5.1.js"></script>
	<script type="text/javascript" src="/src/tools/js/easyui/jquery.easyui.min.js"></script>
	
	<script type="text/javascript" src="/src/utils.js"></script>
</head>
<body>
<?php
function file_build_path(...$segments) {
	return join(DIRECTORY_SEPARATOR, func_get_args($segments));
}

require_once ( file_build_path( __DIR__ , "..", "src" , "TInitialize.php") );
require_once ( file_build_path( __DIR__ , "..", "test", "desktop.php"    ) );

EntryPoint();
?>
</body>
</html>