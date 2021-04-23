<?php
// ------------------------------------------------------
// File    : src/TScreen.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TObject.php" );

class TScreen extends TObject
{
	public $Position    = "absolute";  // default: css

	public $MarginRect  = null;
	public $PaddingRect = null;
	
	public $Brush       = null;   // paint the rect :D
	
	// ctor: constructor
	public function __construct() {
		$cnt = func_num_args();
		parent::__construct($this);
		
		// default values:
		if ($cnt == 2) {
			list($w,$h) = func_get_args();
			$this->MarginRect = new TMarginRect(0,0,$w,$h);
		}	else
		if ($cnt == 1) {
			list($a1) = func_get_args();
			if ($a1 instanceof TRect) {
				$this->MarginRect = $a1;
			}
		}
		
		$this->MarginRect  = new TMarginRect (0,0,0,0);
		$this->PaddingRect = new TPaddingRect(0,0,0,0);
		
		$this->Brush = new TScreenBrush($this);
	}

	public function setColor() {
		$cnt = func_num_args();
		if ($cnt == 0) {
			$this->Brush->setColor(10,100,200);
		}	else
		if ($cnt == 1) {
			list($a1) = func_get_args();
			$this->Brush->setColor($a1);
		}	else
		if ($cnt == 3) {
			list($a1,$a2,$a3) = func_get_args();
			$this->Brush->setColor($a1,$a2,$a3);
		}
	}
	
	public function getMargin() { return $this->MarginRect; }
	public function setMargin() {
		$cnt = func_num_args();
		if ($cnt == 4) {
			list($a1,$a2,$a3,$a4) = func_get_args();
			$this->MarginRect->setLeft  ($a1);
			$this->MarginRect->setTop   ($a2);
			$this->MarginRect->setRight ($a3);
			$this->MarginRect->setBottom($a4);
		}
	}
	
	public function getPadding() { return $this->PaddingRect; }
	public function setPadding() {
		$cnt = func_num_args();
		if ($cnt == 4) {
			list($a1,$a2,$a3,$a4) = func_get_args();
			$this->PaddingRect->setLeft  ($a1);
			$this->PaddingRect->setTop   ($a2);
			$this->PaddingRect->setRight ($a3);
			$this->PaddingRect->setBottom($a4);
		}
	}

	public function getPosition() { return $this->Position; }
	public function setPosition($a1) {
		if (!is_string($a1)) {
			// todo: error msg.
			return;
		}
		$tmp = strtolower($a1);
		if ((!strcmp($tmp,"absolute"))
		||  (!strcmp($tmp,"relative"))
		||  (!strcmp($tmp,"fixed"   ))) {
			$this->Position = $tmp;
		}	else {
			// todo: error msg.
		}
	}
	
	public function setAbsolute() { $this->setPosition("absolute"); }
	public function setRelative() { $this->setPosition("relative"); }
	public function setFixed   () { $this->setPosition("fixed"   ); }

	public function setImage() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($a1) = func_get_args();
			if ($a1 instanceof TUrl) {
				// todo
			}	else
			if (is_string($a1)) {
				$_SESSION['document_stream'] .= "$('#"
				//. $this->getClassID()
				. $this->getClassHandle()
				. "').css('background-image','url("
				. $a1 . ")');";
			}
		}
	}
	
	// --------------------------------------------
	// perform code emit to parent DIV: $a1
	// --------------------------------------------
	public function EmitCode($a1) {
		print_r($a1);
		/*
		// jquery
		$_SESSION['document_stream'] .= "$('#"
		//. $this->getClassID()
		. $this->getClassHandle()
		. "').appendTo($('#" . $a1 . "'))"
		. ".css('width','"   . $this->getVisualRight () . "')"
		. ".css('height','"  . $this->getVisualBottom() . "')"
		. ";";

		// html
		/*
		$str  = "<div id='"
		//. $this->getClassID()
		. $this->getClassHandle()
		. "'></div>"
		. $this->Brush->EmitCode($this->getClassID() . $this->getClassHandle());

		if (!strcmp($a1,"container"))
		echo   $str; else
		return $str;*/
	}

	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}
?>