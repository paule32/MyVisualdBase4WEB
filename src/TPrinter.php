<?php
// ------------------------------------------------------
// File    : src/TPrinter.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TPrinter extends TDevice
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