<?php
// ------------------------------------------------------
// File    : src/TPaddingRect.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TPaddingRect extends TRect {
	public function __construct() {
		$cnt = func_num_args();
		parent::__construct($this);
		
		$this->setClassName("TPaddingRect");
		$this->setClassID("qpaddingrect");
		$this->setClassHandle($this->getClassHandle()+1);
		
		if ($cnt == 1) {
			list($a1) = func_get_args();
			parent::__construct($a1);
		}	else
		if ($cnt == 4) {
			list($a1,$a2,$a3,$a4) = func_get_args();
			parent::__construct($a1,$a2,$a3,$a4);
		}
	}
	public function __destruct() {
		parent::__destruct();
	}
}
?>