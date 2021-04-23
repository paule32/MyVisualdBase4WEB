<?php
// ------------------------------------------------------
// File    : src/TDesktopWindow.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TWidget.php" );

class TDesktopWindow extends TWidget
{
	private $Device = null;
	
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		$this->Device = $sender;
		parent::__construct($this);
		
		$this->setClassHandle($this->getClassHandle()+1);
	}
	
	// --------------------------------------------
	// perform code emit to parent DIV: $a1
	// --------------------------------------------
	public function EmitCode($a1) {
		echo "<pre>";
		if (is_string($a1) && !strcmp($a1,"container")) {
			if (!(empty($this->Device))) {
				$this->Device->EmitCode($this);
			}
		}
		echo "\nTDesktopWindow";
		// jquery
		//if (is_string($a1) && !strcmp($a1,"container")) {
		//	$_SESSION['document_stream'] .= "$('#"
		//	. $this->getClassID()
		////. $this->getClassHandle()    . "')"
		//. ".css('width','"   . $this->VisualRect->getWidth () . "')"
		//. ".css('height','"  . $this->VisualRect->getHeight() . "')"
		////. ".appendTo($('#"   . $a1 . "'));";

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