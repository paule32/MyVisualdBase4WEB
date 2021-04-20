<?php
// ------------------------------------------------------
// File    : src/TWindow.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TWindow extends TWidget
{
	public $ClassName = "TWindow";
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);
		$this->uiText = $sender->uiText;
		parent::EmitCode($this);
	}
	public function __destruct() {
		parent::__destruct();
	}
}
?>