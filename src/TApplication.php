<?php
// ------------------------------------------------------
// File    : /pub/desk/index.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

// -------------------------------------
// construct a simple application ...
// -------------------------------------
class TApplication extends TWindow
{
	public $ClassName  = "TApplication";
	public $app_device = null;		// default: TScreen
	
	// ctor: constructor
	public function __construct() {
		$this->app_device = new TDevice(new TScreen());
		$this->ClassName  = "TApplication";
		//parent::__construct($this);
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