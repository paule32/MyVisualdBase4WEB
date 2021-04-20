<?php
// ------------------------------------------------------
// File    : src/TObject.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

// -------------------------------
// basse class of all classes ...
// -------------------------------
class TObject
{
	public $ClassName   = "TObject";  // class name
	public $ClassID     = "";         // class ID name
	public $ClassHandle =  0;         // class ID number
	public $ClassParent = null;       // parent object
	
	public static $Objects =   [];    // counter

	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		$this->ClassHandle++;

		if ($cnt == 0) {
			//$this->setParent(null);
			$this->setClassName("TObject");
			$this->setClassID($this->addObject("qobject"));
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			if  ($sender != $this) {
				//$this->setParent($sender);
				$this->setClassName($sender->ClassName);
				$this->setClassID($sender->ClassID);
			}	else {
				// todo: error msg.
			}
		}
	}

	// --------------------------------------------
	// add next object in list ...
	// --------------------------------------------
	public function addObject($a1) {
		$found = false;
		$num   = 1;
		$str   = $a1 . $num;
		foreach ($this->Objects as $key => $value) {
			$str = $a1 . $num++;
			if (!strcmp($key,$str)) {
				$found = true;
				break;
			}
		}
		if ($found == false) {
			$this->Objects[$str]['classname'  ] = $this->ClassName;
			$this->Objects[$str]['classparent'] = $this->ClassParent;
			$this->Objects[$str]['classhandle'] = $this->ClassHandle;
		}

		while (1) {
			$str = $a1 . $num++;
			if (!in_array($str, $this::$Objects)) {
				array_push($this::$Objects,$str);
				$this->setClassHandle($num);
				$found = true;
				break;
			}
		}
		if ($found == false) {
			return $a1 . $this->getClassHandle();
		}	return $str;
	}

	// --------------------------------------------
	// seter's: class name
	// --------------------------------------------
	public function setClassName($a1) {
		if (is_string($a1)) {
			$this->ClassName = $a1;
		}
	}
	public function setClassHandle ($a1) { $this->ClassHandle = $a1; }
	public function setClassID     ($a1) { $this->ClassID     = $a1; }
	public function setParent      ($a1) { $this->ClassParent = $a1; }
	
	// --------------------------------------------
	// getter's: class name
	// --------------------------------------------
	public function getClassName   () { return $this->ClassName;   }
	public function getClassHandle () { return $this->ClassHandle; }
	public function getClassID     () { return $this->ClassID;     }
	public function getParent      () { return $this->ClassParent; }
	
	// dtor: free used memory ...
	public function __destruct() {
	}
}
?>