<?php
// ------------------------------------------------------
// File    : /pub/desk/index.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------
?>
<!doctype html>
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
<body>
<?php




// -------------------------------------------------------
// class TPanWindow: represents a application window/panel
// -------------------------------------------------------


// -------------------------------------
// construct a simple application ...
// -------------------------------------
//$my_device = new TDevice(new TAndroid());
//$my_screen  = new TScreen(new TColor(0,64,190));	// screen: 0

/*
$my_desktop = new TDesktopWindow($my_screen);		// the desktop (icons...)
$my_desktop->setHeight("calc(100vh - 36px)");
$my_desktop->setWidth ("100vw");
$my_desktop->setBackground(new TImage("/pub/bg.jpg"));

$my_taskbar = new TTaskBar($my_screen); 			// the taskbar: window
$my_taskbar->setHeight("36px");
$my_taskbar->setWidth("100vw");
$my_taskbar->setColor(110,64,160);	// window: color
$my_taskbar->setOpacity(1.0);

// start button
$my_startbtn = new TButton($my_taskbar);
$my_startbtn->setHeight("36px");
$my_startbtn->setBackgroundNormal ("/pub/desk/img/StartButtonNormal.png" );
$my_startbtn->setBackgroundClicked("/pub/desk/img/StartButtonClicked.png");
$my_startbtn->setBackgroundHover  ("/pub/desk/img/StartButtonHover.png"  ,"/pub/desk/img/StartButtonNormal.png");
//$my_startbtn->onClick(function() {
	//$my_startbar = new TPanel($my_desktop);
	//$my_startbar->setHeight("100px");
	//$my_startbar->setWidth("120px");
//});

/*
// dBase 4 web 1.0 ...
$my_app = new TWindow($my_desktop);
$my_app->setMoveable(true);
$my_app->setHeight("100px");
$my_app->setWidth("100px");
$my_app->setColor(0,100,200);
$my_app->setImage("/pub/desk/img/monster.png","94px","74px");
/*
$my_app->onDblClick(function() {
		$func_str = "";
		$func = array(
			function() { return $my_app->setTitle('dBase-4-Web'); },
			function() { return $my_app->setLayout('east',100);   },
			function() { return $my_app->show();                  }
		);
		for ($idx = 0; $idx < count($func); $idx++)
			 $func_str .= $func()[$idx];    return
		     $func_str ;
	}
);*/

// start test application
//MainEntryPoint();
?>
