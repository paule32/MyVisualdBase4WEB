<?php
// ------------------------------------------------------
// File    : src/TDevice.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TObject.php" );
require_once( "TDeviceScreen.php" );
require_once( "TDevicePrinter.php" );

class TDevice extends TObject
{	
	public $Screen  = null;
	public $Printer = null;

	// ctor: constructor
	public function __construct() {
		$cnt = func_num_args();
		parent::__construct($this);
		
		if ($cnt == 1) {
			list($a1) = func_get_args();
			if ($a1 instanceof TScreen) {
				$this->Screen = $a1;
				$this->setClassHandle ($a1->getClassHandle()+1);
			}	else
			if ($a1 instanceof TPrinter) {
				$this->Printer = $a1;
				$this->setClassHandle ($a1->getClassHandle()+1);
			}	else
			if (is_string($a1)) {
				if (!strcmp($a1,"screen")) {
					$this->Screen = new TDeviceScreen($this);
				}	else
				if (!strcmp($a1,"printer")) {
					$this->Printer = new TDevicePrinter($this);
				}
			}
		}
	}

	// --------------------------------------------
	// perform code emit to parent DIV: $a1
	// --------------------------------------------
	public function EmitCode($a1) {
		if ($a1 instanceof TDesktopWindow) {
			echo "\nTDevice";
			if (!empty($this->Screen)) {
				echo "\nTScreen";
				$this->Screen->EmitCode($this);
			}	else
			if (!empty($this->Printer)) {
				echo "\nTPrinter";
				$this->Printer->EmitCode($this);
			}	else
			if (is_string($a1)) {
				if (!strcmp($a1,"screen")) {
					echo "\nTScreen device";
				}	else
				if (!strcmp($a1,"printer")) {
					echo "\nTPrinter device";
				}
			}
		}
		/*
		echo "ooooo  " . $a1 . " ooooo";
		/*
		// jquery
		$_SESSION['document_stream'] .= "$('#"
		. $this->getClassID()
		. $this->getClassHandle()
		. "').appendTo($('#" . $a1 . "'));";

		// html
		$str  = "<div id='"
		. $this->getClassID()
		. $this->getClassHandle()
		. "'></div>"
		. parent::EmitCode($this->getClassID() . $this->getClassHandle());*/
		/*
		echo $str; */
	}

	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}
?>