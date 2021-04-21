<?php
// ------------------------------------------------------
// File    : src/TImage.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

class TImage extends TObject
{
	public $FileName = "";

	// --------------------------------------------
	// this is the real ctor, it call the fake ctor
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 0) {
			parent::__construct();
			$this->Parent = new TObject();
			$this->FileName = "";
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			parent::__construct();
			if ($sender instanceof TString) {
				$this->Parent = new TObject();
				$this->FileName = $sender->Text;
			}	else
			if ($sender instanceof TUrl) {
				$this->Parent = new TObject();
				$this->FileName = $sender->Text;
			}	else
			if (is_string($sender)) {
				$this->Parent = new TObject();
				$this->FileName = $sender;
			}
		}
	}
	
	// dtor: free used memory ...
	public function __destruct() {
	}
}
?>