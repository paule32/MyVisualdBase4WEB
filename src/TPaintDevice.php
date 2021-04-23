<?php
// ------------------------------------------------------
// File    : src/TPaintDevice.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

declare(strict_types = 1);
namespace kallup\awt;

require_once( "TDevice.php" );

class TPaintDevice extends TDevice
{
	public $Screen  = null; 	// visual screen
	public $Printer = null; 	// printer
	
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($sender) = func_get_args();
			parent::__construct($sender);

			if ($sender instanceof TScreen) {
				$this->Screen = $sender;
			}
			
			$this->setClassHandle ($sender->getClassHandle()+1);
		}
	}
	
	public function EmitCode($a1) {
		print_r($a1);
		$str = "";
		if (!empty($this->Screen)) {
			echo "\nTScreen";
			//$str = $this->Screen->EmitCode($this->getClassID() . $this->getClassHandle());
		}
		//return $str;
	}
	
	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}
?>