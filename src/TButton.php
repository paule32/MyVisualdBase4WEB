<?php
// ------------------------------------------------------
// File    : src/TButton.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TObject.php" );

class TButton extends TPanel {
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);
	}
	public function __destruct() {
		parent::__destruct();
	}
}

?>