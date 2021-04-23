<?php
// ------------------------------------------------------
// File    : src/TWindow.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TWidget.php" );

class TWindow extends TWidget
{
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);
		
		$this->setClassHandle($this->getClassHandle()+1);
	}
	public function __destruct() {
		parent::__destruct();
	}
}
?>