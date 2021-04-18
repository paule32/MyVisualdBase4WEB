<?php
// ------------------------------------------------------
// File    : /tools/pub/head.php
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// ------------------------------------------------------
// web-pages must be always start by session !
// -----------------------------------------------
@session_start();

echo "<!doctype html>";
echo "<html lang='" . $toolclass->get_header_language() . "'>";

$dirsep = DIRECTORY_SEPARATOR;
$_SESSION['dir_sep']  = $dirsep;

// RewriteRule "^/pub/(.*)" "-" [E=HTTP_DOCDIR_HEADER:${APACHE_DSL}]
if (!isset($_SERVER['REDIRECT_HTTP_DOCDIR_HEADER']))
	$_SESSION['doc_root'] = $_SERVER['HTTP_DOCDIR_HEADER']; else
	$_SESSION['doc_root'] = $_SERVER['REDIRECT_HTTP_DOCDIR_HEADER'];
	$_SESSION['doc_root'] = str_replace(array('/'),$dirsep,$_SESSION['doc_root']);

require_once( $_SESSION['doc_root']
	. $dirsep . "tools"
	. $dirsep . "php"
	. $dirsep . "misc.php" );

if (session_status() == PHP_SESSION_ACTIVE) {
	$_dirroot    = "/../../intern/4430";
	$_docroot    = $_SERVER["DOCUMENT_ROOT"] . $_dirroot;
	if (!isset($_SESSION['dir_array'])) {
		$_SESSION['dir_array'] = [];
		$_SESSION['dir_root' ] = $_dirroot;
		$_SESSION['doc_root' ] = $_docroot;
		$_SESSION['req_time' ] = $_SERVER['REQUEST_TIME'];
	}
	// ---------------------------------
	// n - minutes till session out ...
	// ---------------------------------
	$n    = 1;
	$time = ($_SESSION['req_time'] + ($n * 60));
	if ($_SERVER['REQUEST_TIME'] >= $time) {
		unset($_SESSION['req_time' ]);  // delete time-out
		unset($_SESSION['dir_array']);  // delete scrabble
		//
		session_destroy();
		//header('Location: /pub/index.php');
		//die(); exit;
	}
	// -----------------------------------------------
	// "id" is given?
	// = NOTFOUND when no document string is given
	//   NOTFOUND comes from apache 2.4 config ...
	// -----------------------------------------------
	if (!isset($_GET['id'])) {
		//header('Location: /pub/logout.php');
		//die(); exit;
	}
	// -----------------------------------------------
	// data from previous session available ?
	// ------------------------------------------------
	// create map-hash-list.
	// to speed up the "session", only use get files.
	// ------------------------------------------------
	if (!isset($_SESSION['dir_array']))
		$_SESSION['dir_array'] = [];
	if (count($_SESSION['dir_array'])-1 < 0) {
		$directories = [];
		array_push($directories,$toolclass->expandDirectoriesMatrix($_docroot . "/pub"));
		array_push($directories,$toolclass->expandDirectoriesMatrix($_docroot . "/\\tools"));
	}
	// ------------------------------------------------
	// now, try to get the scrabbled file ...
	// ------------------------------------------------
	/*
	$parts = parse_url($_SERVER['REQUEST_URI']);
	if (isset($parts['query'])) {
		$hashq = htmlspecialchars($parts['query']) . '!';
		$hash  = ltrim($hashq, "p=%27");
		$hash  = rtrim($hash, "%27!");
		if (strlen($hash) > 2) {
			$link = $toolclass->get_link_value($_SESSION['dir_array'],"'". $hash ."'");
			if (strcmp($link,"notfound") == 0) {
				require $_docroot . "/pub/logout.php";
				dont_hack_me();
			}	else {
				echo "LINK: " . $link;
				require $_root . $link;
				die();
			}
		}
	}*/
}
?>
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
	
	<link rel="icon"       type="image/png" src="/pub/favicon.png">
	
    <link rel="stylesheet" type="text/css"  href="/tools/css/global.css">
	<link rel="stylesheet" type="text/css"  href="/tools/css/index.css">
	
	<link rel="stylesheet" type="text/css" href="/tools/js/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/tools/js/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/tools/js/easyui/themes/color.css">
	
	<title>Home - schooling</title>
	
	<script type="text/javascript" src="/tools/js/base/jquery-min.3.5.1.js"></script>
	<script type="text/javascript" src="/tools/js/easyui/jquery.easyui.min.js"></script>
	
	<script>
	function encode_utf8(s) {
	return unescape(encodeURIComponent(s));	}

	function decode_utf8(s) {
	return decodeURIComponent(escape(s));	}
	
	$.extend($.fn.window.methods, {
		hide: function(jq){
			return jq.each(function(){
				var w = $(this);
				var state = w.data('window');
				state.window.hide();
				if (state.shadow){state.shadow.hide();}
				if (state.mask){state.mask.hide();}
			})
		},
		show: function(jq){
			return jq.each(function(){
				var w = $(this);
				var state = w.data('window');
				state.window.show();
				if (state.shadow){state.shadow.show();}
				if (state.mask){state.mask.show();}
			})
		}
	});
	</script>
</head>
