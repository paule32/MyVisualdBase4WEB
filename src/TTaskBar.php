<?php
// ------------------------------------------------------
// File    : src/TTaskBar.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TTaskBar extends TPanel {
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);

		parent::EmitCode($this);
	}
	public function __destruct() {
		parent::__destruct();
	}
}
?>