<?php
// ------------------------------------------------------
// File    : src/TApplication.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TWindow.php" );

// -------------------------------------
// construct a simple application ...
// -------------------------------------
class TApplication extends TWindow
{
	public $app_device = null;		// default: TScreen
	
	// ctor: constructor
	public function __construct() {
		$this->app_device = new TDevice(new TScreen());
	}
	
	// start the application ...
	public function exec() {
		WriteBodyContent();
	}

	// dtor: free memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

function MainEntryPoint()
{
	$my_app = new TApplication();
	$my_app->exec();
}
?>