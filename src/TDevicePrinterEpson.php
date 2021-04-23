<?php
// ------------------------------------------------------
// File    : src/TDevicePrinterEpson.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TObject.php" );

class TDevicePrinterEpson extends TObject
{
	public function __construct() {
		$cnt = func_num_args();
		list($a1) = func_get_args();
		parent::__construct($this);
	}

	public function __destruct() {
		parent::__destruct();
	}
}