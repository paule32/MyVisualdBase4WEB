<?php
// ------------------------------------------------------
// File    : src/TSize.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TObject.php" );

class TSize extends TObject
{
	private int $tzHeight = 0;
	private int $tzWidth  = 0;

	public function setHeight(int $h) { $this->tzHeight = $h; }
	public function setWidth (int $w) { $this->tzWidth  = $w; }
	
	public function height() { return $this->tzHeight; }
	public function width () { return $this->tzWidth;  }

	// -----------------------------------------------------------
	// returns true, if either width, and height <= 0; else false
	// -----------------------------------------------------------
	public function isNull() {
		if (($this->tzHeight <= 0) && ($this->tzWidth <= 0))
		return true; else
		return false;
	}
	public function isEmpty() {
		if (($this->tzHeight <= 0) && ($this->tzWidth <= 0))
		return true; else
		return false;
	}
	// ----------------------------------------------------------------------
	// returns true, if both (width+height) equal, or greater 0; else: false
	// ----------------------------------------------------------------------
	public function isValid() {
		if ((($this->tzHeight > 0) && ($this->tzWidth > 0))
		||  (($this->tzHeight      == $this->tzWidth)))
		return true; else
		return false;
	}
}
?>