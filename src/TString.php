<?php
// ------------------------------------------------------
// File    : src/TString.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TObject.php" );

class TString extends TObject
{
	public $Text = "";

	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 0) {
			parent::__construct($this);
			$Text = "";
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			if (is_string($sender)) {
				$this->Text = $sender;
			}
		}
	}
	
	// dtor: free memory ...
	public function __destruct() {
		parent::__destruct();
	}
}
?>