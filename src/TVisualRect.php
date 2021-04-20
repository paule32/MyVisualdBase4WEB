<?php
// ------------------------------------------------------
// File    : src/TVisualRect.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TVisualRect  extends TRect {
	public function __construct() {
		$cnt = func_num_args();
		
		$this->setClassName("TVisualRect");
		$this->setClassID("qvisualrect");
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