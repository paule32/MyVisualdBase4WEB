<?php
// ------------------------------------------------------
// File    : src/TException.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TObject.php" );

class TException extends TObject {

	public function __construct($a1) {
		parent::__construct();
	}
}
?>