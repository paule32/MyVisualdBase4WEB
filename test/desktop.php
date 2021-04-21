<?php
// ------------------------------------------------------
// File    : test/desktop.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

function EntryPoint()
{
	InitializeFrameWork();                      // init stuff

	// the screen object
	$my_screen = new TScreen("100vw","100vh");
	$my_screen->setMargin(0,0,0,0);
	$my_screen->setImage("/test/assests/image/bg.jpg");

	// device is screen
	$my_device = new TDevice($my_screen);		// screen

	// the desktop
	$my_desktop = new TDesktopWindow($my_device);
	$my_desktop->setColor(200,20,100);

	$my_desktop->EmitCode("container");			// final stage:
	WriteBodyContent();
return;

	// last step: bring all together:
	WriteBodyContent();
}
?>
