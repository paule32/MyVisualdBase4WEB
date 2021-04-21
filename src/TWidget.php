<?php
// ------------------------------------------------------
// File    : src/TWidget.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TWidget extends TObject
{
	public $MarginRect  = null;
	public $VisualRect  = null;
	public $PaddingRect = null;
	
	public $internalParent = null;

	public $Brush  = null;
	
	// --------------------------------------------
	// this is the real ctor, it call the fake ctor
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		parent::__construct($this);
		
		$this->setClassName("TWidget");
		$this->setClassID("qwidget");
		$this->setClassHandle($this->getClassHandle()+1);

		$this->MarginRect  = new TMarginRect(0,0,0,0);
		$this->PaddingRect = new TPaddingRect(0,0,0,0);

		$this->MarginRect->setParent($this);
		
		$this->Brush = new TPainterScreen($this);

		// default values:
		if ($cnt == 0) {
			$this->VisualRect = new TVisualRect(2,1,"100vw","100vh");
		}	else
		if ($cnt == 2) {
			list($w,$h) = func_get_args();
			$this->VisualRect = new TVisualRect(0,0,$w,$h);
		}	else
		if ($cnt == 1) {
			list($a1) = func_get_args();
			$this->setParent($a1);
			if ($a1 instanceof TRect) {
				$this->VisualRect = new TRect(
				$a1->getLeft  (),
				$a1->getTop   (),
				$a1->getRight (),
				$a1->getBottom());
			}	else
			if ($a1 instanceof TScreen) {
				$this->VisualRect = new TVisualRect(0,0,"100vw","100vh");
			}
		}
	}

	public function getMarginBottom () { return $this->MarginRect->getBottom(); }
	public function getMarginLeft   () { return $this->MarginRect->getLeft  (); }
	public function getMarginRight  () { return $this->MarginRect->getRight (); }
	public function getMarginTop    () { return $this->MarginRect->getTop   (); }

    public function getPaddingBottom () { return $this->PaddingRect->getBottom(); }
	public function getPaddingLeft   () { return $this->PaddingRect->getLeft  (); }
	public function getPaddingRight  () { return $this->PaddingRect->getRight (); }
	public function getPaddingTop    () { return $this->PaddingRect->getTop   (); }
	
	public function getVisualBottom () { return $this->VisualRect->getBottom(); }
	public function getVisualLeft   () { return $this->VisualRect->getLeft  (); }
	public function getVisualRight  () { return $this->VisualRect->getRight (); }
	public function getVisualTop    () { return $this->VisualRect->getTop   (); }
	
	public function setMarginBottom ($a1) { $this->MarginRect->setBottom($a1); }
	public function setMarginLeft   ($a1) { $this->MarginRect->setLeft  ($a1); }
	public function setMarginRight  ($a1) { $this->MarginRect->setRight ($a1); }
	public function setMarginTop    ($a1) { $this->MarginRect->setTop   ($a1); }
	
	public function setPaddingBottom ($a1) { $this->PaddingRect->setBottom($a1); }
	public function setPaddingLeft   ($a1) { $this->PaddingRect->setLeft  ($a1); }
	public function setPaddingRight  ($a1) { $this->PaddingRect->setRight ($a1); }
	public function setPaddingTop    ($a1) { $this->PaddingRect->setTop   ($a1); }
	
	public function setVisualBottom ($a1) { $this->VisualRect->setBottom($a1); }
	public function setVisualLeft   ($a1) { $this->VisualRect->setLeft  ($a1); }
	public function setVisualRight  ($a1) { $this->VisualRect->setRight ($a1); }
	public function setVisualTop    ($a1) { $this->VisualRect->setTop   ($a1); }

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
	
	public function getMargin() { return $this->Brush->MarginRect; }
	public function setMargin() {
		$cnt = func_num_args();
		if ($cnt == 4) {
			list($a1,$a2,$a3,$a4) = func_get_args();
			if (is_int($a1) && is_int($a2)
			&&  is_int($a3) && is_int($a4)) {
				$_SESSION['document_stream'] .= "$('#"
				. $this->getClassID()
				. $this->getClassHandle()  . "')"
				. ".css('margin-left','"   . $a1 . "px')"
				. ".css('margin-top','"    . $a2 . "px')"
				. ".css('margin-right','"  . $a3 . "px')"
				. ".css('margin-bottom','" . $a4 . "px');";
				$this->setMarginLeft  ($a1);
				$this->setMarginTop   ($a2);
				$this->setMarginRight ($a3);
				$this->setMarginBottom($a4);
			}	else
			if (is_string($a1) && is_string($a2)
			&&  is_string($a3) && is_string($a4)) {
				$_SESSION['document_stream'] .= "$('#"
				. $this->getClassID()
				. $this->getClassHandle()  . "')"
				. ".css('margin-left','"   . $a1 . "')"
				. ".css('margin-top','"    . $a2 . "')"
				. ".css('margin-right','"  . $a3 . "')"
				. ".css('margin-bottom','" . $a4 . "');";
				$this->setMarginLeft  ($a1);
				$this->setMarginTop   ($a2);
				$this->setMarginRight ($a3);
				$this->setMarginBottom($a4);
			}
		}
	}
	
	public function getPadding() { return $this->Foreground->PaddingRect; }
	public function setPadding() {
		$cnt = func_num_args();
		if ($cnt == 4) {
			list($a1,$a2,$a3,$a4) = func_get_args();
			if (is_int($a1) && is_int($a2)
			&&  is_int($a3) && is_int($a4)) {
				$_SESSION['document_stream'] .= "$('#"
				. $this->getClassID()
				. $this->getClassHandle()  . "')"
				. ".css('padding-left','"   . $a1 . "px')"
				. ".css('padding-top','"    . $a2 . "px')"
				. ".css('padding-right','"  . $a3 . "px')"
				. ".css('padding-bottom','" . $a4 . "px');";
				$this->setPaddingLeft  ($a1);
				$this->setPaddingTop   ($a2);
				$this->setPaddingRight ($a3);
				$this->setPaddingBottom($a4);
			}	else
			if (is_string($a1) && is_string($a2)
			&&  is_string($a3) && is_string($a4)) {
				$_SESSION['document_stream'] .= "$('#"
				. $this->getClassID()
				. $this->getClassHandle()  . "')"
				. ".css('padding-left','"   . $a1 . "')"
				. ".css('padding-top','"    . $a2 . "')"
				. ".css('padding-right','"  . $a3 . "')"
				. ".css('padding-bottom','" . $a4 . "');";
				$this->setPaddingLeft  ($a1);
				$this->setPaddingTop   ($a2);
				$this->setPaddingRight ($a3);
				$this->setPaddingBottom($a4);
			}
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
			$_SESSION['document_stream'] .= "$('#"
			. $this->getClassID()
			. $this->getClassHandle()
			. "').css('position','" . $tmp . "');";
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
				. $this->getClassID()
				. $this->getClassHandle()
				. "').css('background-image','url(\""
				. $a1 . "\")');";
			}
		}
	}

	public function EmitCode($a1)
	{
		// jquery
		$_SESSION['document_stream'] .= "$('#"
		. $this->getClassID()
		. $this->getClassHandle()
		. "').appendTo($('#" . $a1 . "'));";

		// html
		$str  = "<div class='easyui-panel' id='"   // ööö
		. $this->getClassID()
		. $this->getClassHandle()
		. "' style='position:relative;overflow:auto;'"
		. "></div>"
		. $this->Brush->EmitCode($this->getClassID() . $this->getClassHandle());

		return $str;
	}
	
	// ------------------------------------------
	// set Click event ...
	// ------------------------------------------
	public function onClick($a1) {
		if (is_callable($a1)) {
			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $this->ClassLHS
			. $this->Number . "').click(function() {"
			. $a1
			. "});";
		}
	}
	// ------------------------------------------
	// set dblClick event ...
	// ------------------------------------------
	public function onDblClick($a1) {
		if (is_string($a1)) {
			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $this->ClassLHS
			. $this->Number . "').dblclick(function() {"
			. $a1
			. "});";
		}
	}

	public function setTitle($a1) {
		return "$('#wipa0').window({title:'" . $a1 . "'});";
	}
	public function show() { return "$('#wipa0').window('show');"; }
	public function hide() { return "$('#wipa0').window('hide');"; }
	
	public function setLayout($a1,$a2) {
		if (is_string($a1) && is_int($a2)) {
			if ($this->init_layout)
			return "";
			$this->init_layout = 1;
			$str = ""
			. "$('#wipa0').panel('refresh','/pub/desk/t1.php');";
			return $str;
		}
	}
	
	public function setBackgroundNormal($a1) {
		if (is_string($a1)) {
			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $this->ClassLHS
			. $this->Number
			. "').css('background-image','url(" . $a1 . ")');";
		}
	}
	public function setBackgroundClicked($a1) {
		if (is_string($a1)) {
			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $this->ClassLHS
			. $this->Number
			. "').mousedown("
			. "function(){\$('#"
			. $this->ClassLHS . $this->Number
			. "').css('background-image','url(" . $a1 . ")');});";
		}
	}
	public function setBackgroundHover($a1,$a2) {
		if (is_string($a1)) {
			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $this->ClassLHS
			. $this->Number
			. "').hover("
			. "function(){\$('#" . $this->ClassLHS . $this->Number . "').css('background-image','url(" . $a1 . ")'); },"
			. "function(){\$('#" . $this->ClassLHS . $this->Number . "').css('background-image','url(" . $a2 . ")'); }"
			. ");";
		}
	}
	
	// ----------------------------
	// set the height of TWindow
	// ----------------------------
	public function setHeight($a1) {
		$_SESSION['document_stream'] .= ""
		. "$('#"
		. $this->ClassLHS
		. $this->Number
		. "').css({'height':'" . $a1 . "'});";
	}
	
	// ----------------------------
	// set the width of TWindow
	// ----------------------------
	public function setWidth($a1) {
		$_SESSION['document_stream'] .= ""
		. "$('#"
		. $this->ClassLHS
		. $this->Number
		. "').css({'width':'" . $a1 . "'});";
	}
	
	// ---------------------------------------------
	// set transparency (opacity) of the TWindow ...
	// ---------------------------------------------
	public function setOpacity($alpha) {
		if (is_float($alpha)) {
			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $this->ClassLHS
			. $this->Number
			. "').css({'opacity':'"
			. $alpha
			. "'});";
		}
	}
	
	public function setMoveable($flag) {
		$str = "true";
		if ($flag == true)
			$str   = "enable"; else
			$str   = "disable";
		
		$_SESSION['document_stream'] .= ""
			. "$('#"
			. $this->ClassLHS
			. $this->Number
			. "').draggable('" . $str . "');";
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}
?>