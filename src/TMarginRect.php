<?php
// ------------------------------------------------------
// File    : src/TMarginRect.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TMarginRect  extends TRect
{
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($a1) = func_get_args();
			parent::__construct($a1);
		}	else
		if ($cnt == 4) {
			list($a1,$a2,$a3,$a4) = func_get_args();
			parent::__construct($a1,$a2,$a3,$a4);
		}
		
		$this->setClassHandle($this->getClassHandle()+1);
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}
?>