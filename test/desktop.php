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

	$my_screen = new TScreen("100vw","100vh");
	$my_screen->setColor(new TColor(100,200,100));
	//
	$my_device = new TDevice($my_screen);	// screen
	$my_device->EmitCode("container");			// final stage:

	// last step: bring all together:
	WriteBodyContent();
}
?>
