<?php
// ------------------------------------------------------
// File    : src/TDesktopWindow.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TDesktopWindow extends TWidget
{
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($sender);
		
		$this->setClassHandle($this->getClassHandle()+1);
	}
	
	// --------------------------------------------
	// perform code emit to parent DIV: $a1
	// --------------------------------------------
	public function EmitCode($a1) {
		echo "<pre>uuuuuuu \n\n";
		echo get_called_class() . "\n---\n";
		//print_r($this);
		echo "\n---\n\n";
		print_r($this);
		echo " ttttttt";
		/*
		// jquery
		$_SESSION['document_stream'] .= "$('#"
		. $this->getClassID()
		. $this->getClassHandle()    . "')"
		//. ".css('width','"   . $this->VisualRect->getWidth () . "')"
		//. ".css('height','"  . $this->VisualRect->getHeight() . "')"
		. ".appendTo($('#"   . $a1 . "'));";

		// html
		/*$str  = "<div gugu='ooooooooooo' id='"
		. $this->getClassID()
		. $this->getClassHandle()
		. "'></div>"*/
		
		//if ($this->internalParent instanceof TDevice) {
		//	echo "-------- " . $this->getClassID() . " ------";
		//}
		//$str = "------------------" .
		
		//parent::EmitCode($this->getClassID() . $this->getClassHandle());
		
		//if (!strcmp($a1,"container"))
		//echo   $str; else
		//return $str;
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}

?>