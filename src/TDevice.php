<?php
// ------------------------------------------------------
// File    : src/TDevice.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TDevice extends TPaintDevice
{
	// ctor: constructor
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($sender) = func_get_args();
			parent::__construct($sender);

			$this->setClassName   ("TDevice");
			$this->setClassID     ("qdevice");
			$this->setClassHandle ($sender->getClassHandle()+1);
		}
	}

	// --------------------------------------------
	// perform code emit to parent DIV: $a1
	// --------------------------------------------
	public function EmitCode($a1) {
		// jquery
		$_SESSION['document_stream'] .= "$('#"
		. $this->getClassID()
		. $this->getClassHandle()
		. "').appendTo($('#" . $a1 . "'));";

		// html
		$str  = "<div id='"
		. $this->getClassID()
		. $this->getClassHandle()
		. "'></div>"
		. parent::EmitCode($this->getClassID() . $this->getClassHandle());
		
		echo $str;
	}

	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}
?>