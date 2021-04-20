<?php
// ------------------------------------------------------
// File    : src/TPainterScreen.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TPainterScreen extends TObject
{
	private $Color  = null;
	private $Screen = null;
	
	// --------------------------------------------
	// ctor: constructor
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($sender) = func_get_args();
			parent::__construct($sender);
			
			// reference to TScreen ...
			$this->Screen = $sender;

			$this->setClassName   ("TPainterScreen");
			$this->setClassID     ("qpainterscreen");
			$this->setClassHandle ($sender->getClassHandle()+1);

			// default color:
			$this->Color = new TColor(10,100,200);
		}
	}

	// --------------------------------------------
	// set color of the board
	// --------------------------------------------
	public function setColor() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list ($a1) = func_get_args();
			if ($a1 instanceof TColor) {
				$this->Color = new TColor(
				$a1->getRed  (),
				$a1->getGreen(),
				$a1->getBlue ());
			}	else
			if (is_string($a1)) {
			}
		}	else
		if ($cnt == 3) {
			list($a1,$a2,$a3) = func_get_args();
			$this->Color = new TColor($a1,$a2,$a3);
		}
		// jquery
		$_SESSION['document_stream'] .= "$('#"
		. $this->getClassID()
		. $this->getClassHandle()  . "').css("
		. "'background-color','"
		. $this->Color->getHtmlColor()
		. "');";
	}

	// --------------------------------------------
	// perform code emit to parent DIV: $a1
	// --------------------------------------------
	public function EmitCode($a1) {
		// jquery
		$_SESSION['document_stream'] .= "$('#"
		. $this->getClassID()
		. $this->getClassHandle()    . "')"
		. ".css('width','"   . $this->Screen->VisualRect->getWidth () . "')"
		. ".css('height','"  . $this->Screen->VisualRect->getHeight() . "')"
		. ".appendTo($('#"   . $a1 . "'));";

		// html
		$str  = "<div id='"
		. $this->getClassID()
		. $this->getClassHandle()
		. "'></div>";
		
		return $str;
	}
	
	// --------------------------------------------
	// dtor: free used memory ...
	// --------------------------------------------
	public function __destruct() {
		parent::__destruct();
	}
}
?>