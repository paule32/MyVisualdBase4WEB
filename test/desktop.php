<?php
// ------------------------------------------------------
// File    : test/desktop.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

function EntryPoint()
{
	// init stuff
	InitializeFrameWork();

	// device for screen
	$my_device = new TDevice("screen");
/*
	// the screen object
	$my_screen = new TPaintDeviceScreen($my_device, "100vw","100vh");
	$my_screen->setMargin(20,20,20,20);
	$my_screen->Brush->setImage("/test/assests/image/bg.jpg");

	// the desktop
	$my_desktop = new TDesktopWindow($my_device);
	$my_desktop->setColor(200,20,100);

	$my_desktop->EmitCode("container");			// final stage
*/
	// last step: bring all together:
	WriteBodyContent();
}
?>
