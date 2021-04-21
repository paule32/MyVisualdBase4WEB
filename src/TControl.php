<?php
// ------------------------------------------------------
// File    : src/TControl.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TControl extends TObject
{
	public $ParentDiv  = "";		 // name of the parent <DIV>
	public static $Controls = [];	 // visual controls list
	
	public function __construct() {
		parent::__construct(this);
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}
?>