<?php
// ------------------------------------------------------
// File    : src/TUrl.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TUrl extends TObject {
	public $Text   = "";

	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 0) {
			$this->Text = "https://www.google.com";
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			$this->Parent = new TObject();
			if (is_string($sender)) {
				$this->Text = $sender;
			}
		}
	}

	// dtor: free memory ...
	public function __destruct() {
	}
}
?>