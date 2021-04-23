<?php
// ------------------------------------------------------
// File    : src/TPaintDevicePrinter.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TPaintDevice.php" );

class TPaintDevicePrinter extends TPaintDevice
{
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 0) {
			parent::__construct($this);
		}
	}

	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}
?>