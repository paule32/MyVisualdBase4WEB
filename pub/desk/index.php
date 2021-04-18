<?php
// ------------------------------------------------------
// File    : /pub/desk/index.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// ------------------------------------------------------
// web-pages must be always start by session !
// -----------------------------------------------
session_start();
$_SESSION['doc_root'] = //"c:/www/html/443";
"e:/srv/www/kallup.net/new/html/extern/4430";
?>
<!doctype html>
<html lang='en'>
<head>
	<meta charset="utf-8">
 
	<meta name="author"      content="Jens Kallup [paule32]">
	<meta name="copyright"   content="Jens Kallup">
	<meta name="keywords"    content="kallup, css, html, theme, desktop, windows, xp">
	<meta name="description" content="A Windows XP desktop in HTML, CSS and JavaScript">
	<meta name="robots" 	 content="index, nofollow">

    <meta http-equiv="content-type"    content="text/html; charset=utf-8">
    <meta http-equiv="expires"         content="0">
    <meta http-equiv="cache-control"   content="max-age=0">
    <meta http-equiv="cache-control"   content="no-cache">
    <meta http-equiv="pragma"          content="no-cache">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<link rel="icon"       type="image/png" src="/pub/favicon.png">
	
    <link rel="stylesheet" type="text/css"  href="/tools/css/global.css">
	<link rel="stylesheet" type="text/css"  href="/tools/css/index.css">
	
	<link rel="stylesheet" type="text/css" href="/tools/js/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/tools/js/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/tools/js/easyui/themes/color.css">
	
	<title>Home - schooling</title>
	
	<script type="text/javascript" src="/tools/js/base/jquery-min.3.5.1.js"></script>
	<script type="text/javascript" src="/tools/js/easyui/jquery.easyui.min.js"></script>
	
	<script>
	function encode_utf8(s) {
	return unescape(encodeURIComponent(s));	}

	function decode_utf8(s) {
	return decodeURIComponent(escape(s));	}
	
	$.extend($.fn.window.methods, {
		hide: function(jq){
			return jq.each(function(){
				var w = $(this);
				var state = w.data('window');
				state.window.hide();
				if (state.shadow){state.shadow.hide();}
				if (state.mask){state.mask.hide();}
			})
		},
		show: function(jq){
			return jq.each(function(){
				var w = $(this);
				var state = w.data('window');
				state.window.show();
				if (state.shadow){state.shadow.show();}
				if (state.mask){state.mask.show();}
			})
		}
	});
	</script>
</head>
<?php
function mySha512($str, $salt, $iterations) {
	for ($x=0; $x<$iterations; $x++) {
		$str = hash('sha512', $str . $salt);
	}
	return $str;
}
if (!isset($_REQUEST['bw_username'])
||  !isset($_REQUEST['bw_password']))
{
	echo '<body><script type="text/javascript">window.location = "/pub";</script></body></html>';
	die();
}	else {
	$rqusr = $_REQUEST['bw_username'];
	$rqpwd = $_REQUEST['bw_password'];

	$str   = $_REQUEST['bw_password'];
    $salt  = 'bQ423hbHM8Sbdb9pjquUQU1IWxcxnybBSjqnyBJ23HjqnI3WbkxUQsxnPw813jkq';
    $phash = mySha512($str, $salt, 10000);

	$str   = $_REQUEST['bw_username'];
    $salt  = 'bQ423hbHM8Sbdb9pjquUQU1IWxcxnybBSjqnyBJ23HjqnI3WbkxUQsxnPw813jkq';
    $uhash = mySha512($str, $salt, 10000);

	// ----------------------------------
	// double check: user + pass ...
	// ----------------------------------
	$file = $_SESSION['doc_root'] . "/pub/desk/xml/extern_deskusers.xml";
	if (!file_exists($file)) {
		echo '<script type="text/javascript">' .
		'alert("extern_deskusers.xml dont exists!");'.
		'window.location = "/pub";</script>';
		die(); exit;
	}
	$xml  = simplexml_load_file($file);
	
	$found = false;
	foreach ($xml->user as $user) {
		if (strcmp($user->user_name_plain,$rqusr) == 1) {
			if ($user->user_name_crypt == $uhash) {
			if ($user->user_pass_crypt == $phash) {
				$found = true;
				break;
			}	}
			$found = false;
			break;
		}
	}
	// user + pass = not ok -> redirect
	if ($found == false) {
		echo '<script type="text/javascript">window.location = "/pub";</script>';
		die(); exit;
	}
	
	// now, we use crypted user + pass ...
	$_SESSION['user_name_crypt'] = $uhash;
	$_SESSION['user_pass_crypt'] = $phash;
}

// ----------------------------------------
// The perfect way to check HEX string ...
// ----------------------------------------
function is_hex($hex_code) {
	return @preg_match("/^[a-f0-9]{2,}$/i",
	$hex_code) && !(strlen($hex_code) & 1);
}


// -----------------------------------------------
// initial variables ...
// -----------------------------------------------
$_SESSION['document_stream'] = "";
$_SESSION['ClassRegister'  ] = array(); 	// default suported classes
$_SESSION['Sender'         ] = null;		// global: object sender

// -----------------------------------------------
// RegisterClass: register classes to be in use
// in the class system.
// -----------------------------------------------
function RegisterClass($class) {
	if (is_array($class)) {
		$_SESSION['ClassRegister'] += $class;
	}	else
	if (is_string($class)) {
		if (!in_array($class,
				   $_SESSION['ClassRegister']));
		array_push($_SESSION['ClassRegister'],$str);
	}
}

// -------------------------------------
// initialize framework ...
// -------------------------------------
function InitializeFrameWork()
{
	// -------------------------------------
	// invoke default classes:
	// -------------------------------------
	RegisterClass([
		"TObject",			// base of all classes
		"TLocales", 		// international locales
		"TException",		// exception handling
		"TDevice",			// device: TScreen, TPrinter, ...
		"TKeyboard",		// input device: keyboard
		"TScreen",			// output device: screen
		"TPrinter", 		// output device: printer
		"TControl", 		// gui controls
		"TPanel",			// panel
		"TWindow",			// window
		"TButton",			// window: button
	]);
}

// -------------------------------------
// construct a simple application ...
// -------------------------------------
class TApplication extends TWindow
{
	public $ClassName  = "TApplication";
	public $app_device = null;		// default: TScreen
	
	// ctor: constructor
	public function __construct() {
		$this->app_device = new TDevice(new TScreen());
		$this->ClassName  = "TApplication";
		parent::__construct($this);
	}
	
	// start the application ...
	public function exec() {
		echo "<body>"
		. "<div id='container'></div>"
		. "<script>"
		. "$(document).ready(function(){" . $_SESSION['document_stream']
		. "});"
		. "</script>"
		. "</body></html>";
	}

	// dtor: free memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

function MainEntryPoint()
{
	$my_app = new TApplication();
	$my_app->exec();
}

// -----------------------------------------------
// the global class for locales information's ...
// -----------------------------------------------
class TLocales extends TObject
{
	public $ClassName       = "TLocales";
	
	public $DefaultLang     = "English";
	public $DefaultCurrency = "USD";
	//
	public $Language        = array();
	
	// ctor: constructor
	public function __construct() {
		parent::__construct($this);
		$defLang = "English";
		
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($a1) = func_get_args();
			if (is_string($a1)) {
				$defLang = $a1;
			}
		}
		
		$Language['English']['info'] = function($a1) { return TLocales::info_en_us($a1); };
		$Language['German' ]['info'] = function($a1) { return TLocales::info_de_de($a1); };
		
		$Language['English']['warn'] = function($a1) { return TLocales::warn_en_us($a1); };
		$Language['German' ]['warn'] = function($a1) { return TLocales::warn_de_de($a1); };
		
		$Language['English']['error'] = function($a1) { return TLocales::error_en_us($a1); };
		$Language['German' ]['error'] = function($a1) { return TLocales::error_de_de($a1); };
	
		$Language['English']['currency'] = "USD";	// us: dollar
		$Language['German' ]['currency'] = "EUR";	// european: euro

		$this->setDefaultLang($defLang);	// us, england
		$this->setDefaultCurrency("USD");	// us dollar
	}

	// -------------------------------
	// seter's of TLocales
	// -------------------------------
	public function setDefaultLang($a1) {
		if (is_string($a1)) {
			$tmp = strtolower($a1);
			if (!strcmp($tmp,"english")) { $DefaultLang = "English"; } else
			if (!strcmp($tmp,"german" )) { $DefaultLang = "German" ; } else {
				$DefaultLang = "English";
			}
		}
	}
	public function setDefaultCurrency($a) {
		if (is_string($a1)) {
			$Language[$this->getDefaultLang()]['currency'] = $a1;
		}
	}
	// -------------------------------
	// geter's of TLocales
	// -------------------------------
	public function getDefaultCurrency () { return $this->DefaultCurrency; }
	public function getDefaultLang     () { return $this->DefaultLang;     }
	
	// -------------------------------
	// message dialogs ...
	// -------------------------------
	public function info  ($a1) { $Language[$this->getDefaultLang()]['info' ]($a1); }
	public function warn  ($a1) { $Language[$this->getDefaultLang()]['warn' ]($a1); }
	public function error ($a1) { $Language[$this->getDefaultLang()]['error']($a1); }
	
	// information dialog:
	private static function info_en_us($a1) {
		if (is_string($a1)) {
			"<script>document.write(\"console.info('" . $a1 . "');\");</script>";
			// todo: error msg.
		}	else
		if (is_int($a1)) {
			"<script>document.write(\"console.info('Code: " . $a1 . "');\");</script>";
			// todo: error code
		}
	}
	private static function info_de_de($a1) {
		if (is_string($a1)) {
			"<script>document.write(\"console.info('" . $a1 . "');\");</script>";
			// todo: error msg.
		}	else
		if (is_int($a1)) {
			"<script>document.write(\"console.info('Code: " . $a1 . "');\");</script>";
			// todo: error code
		}
	}
	
	// warning dialog:
	private static function warn_en_us($a1) {
		if (is_string($a1)) {
			"<script>document.write(\"console.warn('" . $a1 . "');\");</script>";
			// todo: error msg.
		}	else
		if (is_int($a1)) {
			"<script>document.write(\"console.warn('Code: " . $a1 . "');\");</script>";
			// todo: error code
		}
	}
	private static function warn_de_de($a1) {
		if (is_string($a1)) {
			"<script>document.write(\"console.warn('" . $a1 . "');\");</script>";
			// todo: error msg.
		}	else
		if (is_int($a1)) {
			"<script>document.write(\"console.warn('Code: " . $a1 . "');\");</script>";
			// todo: error code
		}
	}
	
	// error dialog:
	private static function error_en_us($a1) {
		if (is_string($a1)) {
			"<script>document.write(\"console.error('" . $a1 . "');\");</script>";
			// todo: error msg.
		}	else
		if (is_int($a1)) {
			"<script>document.write(\"console.error('Code: " . $a1 . "');\");</script>";
			// todo: error code
		}
	}
	private static function error_de_de($a1) {
		if (is_string($a1)) {
			"<script>document.write(\"console.error('" . $a1 . "');\");</script>";
			// todo: error msg.
		}	else
		if (is_int($a1)) {
			"<script>document.write(\"console.error('Code: " . $a1 . "');\");</script>";
			// todo: error code
		}
	}
	
	// dtor: free memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

class TException extends TObject {
	public $ClassName = "TException";
	public function __construct($a1) {
		parent::__construct();
	}
}

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
		echo "class: TObject\n";
		if ($cnt == 0) {
			$this->setParent(null);
			$this->setClassName("TObject");
			$this->setClassID(addObject("qobject"));
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			if  ($sender != $this) {
				$this->setParent($sender);
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

// -----------------------------------------------------------
// class TRect: represents an area/size for a device/window.
// -----------------------------------------------------------
class TRect extends TObject
{	
	public $Left   = 0;
	public $Top    = 0;
	public $Right  = 0;
	public $Bottom = 0;
	//
	public $Width  = 0;
	public $Height = 0;
	
	public function __construct() {
		$cnt = func_num_args();
		echo "TRect\n";
//		parent::__construct($this);
		$this->setClassName("TRect");
		if ($cnt == 0) {
			echo "------>  "
			. get_parent_class($this) . "\n";
			$this->setTop   (1);
			$this->setLeft  (2);
			$this->setRight (3); $this->setWidth (5);
			$this->setBottom(4); $this->setHeight(6);
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			if ($sender instanceof TRect) {
				$this->Parent = $sender;
				$this->setHeight($sender->getHeight());
				$this->setWidth ($sender->getWidth());
				$this->setLeft  ($sender->getLeft());
				$this->setTop   ($sender->getTop());
				$this->setRight ($sender->getRight());
				$this->setBottom($sender->getBottom());
			}
		}	else
		if ($cnt == 5) {
			list($sender,$a1,$a2,$a3,$a4) = func_get_args();
			if (is_int($a1) && is_int($a2)
			&&  is_int($a3) && is_int($a4)) {
				echo "------>  "
			. get_parent_class($sender) . "\n";
				$this->setTop   ($a1);
				$this->setLeft  ($a2);
				$this->setRight ($a3);
				$this->setBottom($a4);
			}	else {
				// todo: error message !
			}
		}
	}
	
	// getter's:
	public function getWidth () { return $this->Width ; }
	public function getHeight() { return $this->Height; }
	
	public function getTop   () { return $this->Top;    }
	public function getLeft  () { return $this->Left;   }
	public function getRight () { return $this->Right;  }
	public function getBottom() { return $this->Bottom; }
	
	// setter's:
	public function setWidth ($a1) { $this->Width  = $a1; }
	public function setHeight($a1) { $this->Height = $a1; }
	
	public function setTop   ($a1) { $this->Top    = $a1; }
	public function setLeft  ($a1) { $this->Left   = $a1; }
	public function setRight ($a1) { $this->Right  = $a1; }
	public function setBottom($a1) { $this->Bottom = $a1; }
	
	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

// -------------------------------------------------------
// TMarginClass: the free standing border around obj.
// -------------------------------------------------------
class TMargin extends TRect
{
	public $ClassName = "TMargin";

	// ctor: constructor
	public function __construct() {
		$cnt = func_num_args();
		echo "TMargin\n";
		if ($cnt == 0) {
			parent::__construct($this); //new TRect(10,10,10,10));
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			//print_r($sender);
			if ($sender instanceof TRect) {
				parent::__construct($this);
				/*
				$sender->Top,
				$sender->Left,
				$sender->Right,
				$sender->Bottom);*/
			}
		}	else
		if ($cnt == 4) {
			list($a1,$a2,$a3,$a4) = func_get_args();
			if (is_int($a1) && is_int($a2)
			&&  is_int($a3) && is_int($a4)) {
				parent::__construct($a1,$a2,$a3,$a4);
			}
		}
	}
	
	// dtor: free memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

// -----------------------------------------------------------
// class TBorder: device screen border ...
// -----------------------------------------------------------
class TBorder extends TMargin
{
	public $ClassName = "TBorder";

	// ctor: constructor
	public function __construct() {
		$cnt = func_num_args();
		echo "TBorder\n";

		if ($cnt == 1) {
			list($sender) = func_get_args();
			echo "------>  "
			. get_parent_class($this) . "\n";
			//parent::__construct($this);
			$this->setParent($sender->getParent());
			
			//parent::__construct($sender);
			$this->setClassName  ("TBorder");
			$this->setClassID    ("qborder");
			$this->setClassHandle($sender->getClassHandle());
		}
	}
	
	// dtor: free memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

// -----------------------------------------------------------
// class: TDevice: base of TKeyboard, TScreen, TPrinter, ...
// -----------------------------------------------------------
class TDevice extends TObject
{
	public $BorderRect = null;
	public $VisualRect = null;

	// ctor: constructor
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($sender) = func_get_args();
			$this->setClassName   ("TDevice");
			$this->setClassID     ("qdevice");
			$this->setClassHandle ($sender->getClassHandle()+1);
			
			if ($sender instanceof TScreen) {
				$width  = "<script>document.write(screen.width);</script>";
				$height = "<script>document.write(screen.height);</script>";
				
				// default values:
				$this->BorderRect = new TMargin(10,10,10,10);
				$this->VisualRect = new TRect($this,0,0,$width,$height);
			}
			
			if (!($sender == $this)) {
				parent::__construct($this);
				print_r($sender);
			}
		}
	}

	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

class TAndroid extends TDevice { }
class TTablet  extends TDevice { }
class TScreen  extends TObject
{
	// ctor: constructor
	public function __construct() {
		$cnt    = func_num_args();
		if ($cnt == 0) {
			$this->setClassName("TScreen");
			$this->setParent("");
			$this->setClassID("qscreen");
			
			parent::__construct($this);
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			echo "- - -\n";
		}
		
		
		
		//if ($cnt == 0) { parent::__construct(null); } else
		//if ($cnt == 1) { parent::__construct($this);}

/*
		// screen in screen or background ?
		if ($cnt == 1) {
			list($sender) = func_get_args();
			if (!is_string($sender)) {
				if ($sender instanceof TBackground) {
					$this->Parent = $sender;
					$this->Background = $sender;
				}	else
				if ($sender instanceof TColor) {
					$this->Parent = $sender;
					$this->Background = new TBackground($sender);
					$this->Background->setColor($sender);
				}	else
				if ($sender instanceof TImage) {
					$this->Parent = $sender;
					$this->Background = new TBackground($sender);
					$this->Background->setImage($sender->FileName);
				}
			}	else {
				$this->Background = new TBackground($this);
				$this->Background->setImage($sender);
			}

			$this->Create($this);
		}	else
		if ($cnt == 3) {
			list($a1,$a2,$a3) = func_get_args();
			if (is_int($a1) && is_int($a2) && is_int($a3)) {
				$this->Background = new TBackground(new TColor($a1,$a2,$a3));
				$this->Create($this->Background);
			}
		}*/
	}

	// --------------------------------------------
	// fake constructor:
	// --------------------------------------------
	public function Create() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($sender) = func_get_args();
			$this->setTop (0);
			$this->setLeft(0);
			$this->setWidth ("<script>document.write(screen.width);</script>" );
			$this->setHeight("<script>document.write(screen.height);</script>");

			// get next control in list ...
			/*$num = 0;
			while (1) {
				$str = "qscreen" . $num++;
				if (!in_array($str, $this::$Controls)) {
					array_push($this::$Controls,$str);
					break;
				}
			}*/
			$num = 1;
			// emit html code ...
			echo ""
			. "<div id='qscreen" . $num
			. "' style='position:absolute;"
			. "margin:0;"
			. "bottom:0;width:100vw;height:100vh;'></div>";

			// set exec. stream for ready()
			$_SESSION['document_stream'] .= ""
			. "$('#qscreen"
			. $num
			. "').appendTo('#container');";
		}
	}

	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

class TPrinter extends TDevice
{
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 0) {
			parent::__construct($this);
		}
	}

	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

class TKeyboard extends TDevice
{
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 0) {
			parent::__construct($this);
		}
	}

	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

// -------------------------------------------------------
// class TScreen: use it, to get screen information's ...
// -------------------------------------------------------
class TScreen2 extends TRect
{
	public $Rect       = null;	// screen area size
	public $Background = null;	// image/color

	// --------------------------------------------
	// this is the real ctor, it call the fake ctor
	// --------------------------------------------
	public function __construct() {
	}

	// dtor: free used memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

// -------------------------------------------------------
// class: TControl: hold informations about controls ...
// -------------------------------------------------------
class TControl extends TObject
{
	public $ClassName  = "TControl"; // class name
	public $ParentDiv  = "";		 // name of the parent <DIV>
	public static $Controls = [];	 // visual controls list
	
	public function __construct() {
		parent::__construct(this);
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}

// -------------------------------------------------------
// class: TString: used for handling strings ...
// -------------------------------------------------------
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

// -------------------------------------------------------
// class: TString: used for handling strings ...
// -------------------------------------------------------
class TUrl {
	public $ClassTrait = "TUrlTrait";
	public $ClassName  = "TUrl";
	
	public $Parent = null;
	public $Text   = "";

	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 0) {
			$this->Parent = new TObject();
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

// -------------------------------------------------------
// class: TColor: hold color declarations for obj.
// -------------------------------------------------------
class TColor extends TObject
{
	public $ClassName  = 'TColor';
	
	public $ColorRed   = 1;
	public $ColorGreen = 2;
	public $ColorBlue  = 3;
	
	public $ColorAlpha = 1.0;
	public $ColorHtml  = '';
	
	public $ColorName  = 'rgb';
	public $Color      = null;

	// --------------------------------------------
	// this is the real ctor, it call the fake ctor
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		parent::__construct($this);
		if ($cnt == 3) {
			list($a1,$a2,$a3) = func_get_args();
			if (is_int($a1) && is_int($a2) && is_int($a3)) {
				$this->ColorRed   = $a1;
				$this->ColorGreen = $a2;
				$this->ColorBlue  = $a3;
			}
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			if ($sender instanceof TColor) {
				$this->Parent = $sender;
				
				$this->ColorRed   = $sender->ColorRed;
				$this->ColorGreen = $sender->ColorGreen;
				$this->ColorBlue  = $sender->ColorBlue;
				
				$this->ColorAlpha = $sender->ColorAlpha;
				$this->ColorName  = $sender->ColorName;
			}	else		
			if (is_string($sender)) {
				$this->ColorName = $sender;
				if (strpos($this->ColorName,'rgb')) {
					$this->ColorName = str_replace(' ', '' ,$obj->ColorName);
					list  ($this->ColorRed,$this->ColorGreen,$this->ColorBlue) =
					sscanf($this->ColorName,"rgb(%d,%d,%d)");
				}	else
				if (strpos($obj->ColorName,'#') !== false) {
					$this->ColorName = str_replace(' ', '' ,$obj->ColorName);
					list  ($this->ColorRed,$this->ColorGreen,$this->ColorBlue) =
					sscanf($this->ColorName,"#02%x%02x%02x");
					
					$this->ColorRed   = hexdec(substr($this->ColorName,1,2));
					$this->ColorGreen = hexdec(substr($this->ColorName,1,1));
					$this->ColorBlue  = hexdec(substr($this->ColorName,5,6));
				}
			}
		}	else
		if ($cnt == 0) {
			$this->ColorName  = "#000000";
			$this->ColorRed   = 0;
			$this->ColorGreen = 0;
			$this->ColorBlue  = 0;
			$this->ColorAlpha = 1.0;
		}
	}

	// dtor: free used memory ...
	public function __destruct() {
	}
}

// -------------------------------------------------------
// class: TImage: loads pictures/images into onj.
// -------------------------------------------------------
class TImage extends TObject
{
	public $ClassName  = 'TImage';
	
	public $Parent   = null;
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

// ---------------------------------------------
// class TBackground: Screen/Desktop/Window, ...
// ---------------------------------------------
class TBackground extends TObject
{
	public $ClassName  = 'TBackground';
	
	public $Rect   = null;	// screen area size
	public $Color  = null;
	public $Image  = null;
	
	public $ClassType = 0;	// det. color/image

	// --------------------------------------------
	// this is the real ctor, it call the fake ctor
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 0) {
			parent::__construct();
			$this->Parent = new TObject;
			$this->Number++;
			$this->ClassType = 0;
			$this->Color = new TColor(20,100,200);
			$this->setColor($this->Color);
		}	else
		if ($cnt == 1) {
			list($sender) = func_get_args();
			if ($sender instanceof TScreen) {
				/*if ($this->Parent == $sender)
				{
					$this->ClassType = $sender->Background->ClassType;
					if ($this->ClassType == 0) { $this->setColor($sender->Background->Color); } else
					if ($this->ClassType == 1) { $this->setImage($sender->Background->Image->FileName); }
				}*/
			}	else
			if ($sender instanceof TColor) {
				$this->Parent = new TObject;
				$this->Number++;
				$this->Color = $sender;
				$this->ClassType = 0;
				$this->setColor($this->Color);
			}	else
			if ($sender instanceof TImage) {
				$this->Parent = new TObject;
				$this->Number++;
				$this->Image = $sender;
				$this->ClassType = 1;
				$this->setImage($this->Image->FileName);
			}	else
			if (is_string($sender)) {
				$this->Image = new TImage($sender);
				$this->Number++;
				$this->ClassType = 1;
				$this->setImage($this->Image->FileName);
			}
		}	else
		if ($cnt == 2) {
			list($sender,$a1) = func_get_args();
			if ($sender instanceof TScreen) {
				$this->Parent = $sender;
				if ($a1 instanceof TColor) {
					$this->Color = $a1;
					$this->ClassType = 0;
					$this->setColor($this->Color);
				}	else
				if ($a1 instanceof TImage) {
					$this->Image = $a1;
					$this->ClassType = 1;
					$this->setImage($this->Image->FileName);
				}	else
				if (is_string($a1)) {
					$this->Image = new TImage($a1);
					$this->ClassType = 1;
					$this->setImage($this->Image->FileName);
				}
			}	else
			if ($sender instanceof TWindow) {
				// todo
			}
		}
	}
	
	// ----------------------------------------
	// set the color: RGBA of the background
	// on a associated div block ...
	// ----------------------------------------
	public function setColor() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($sender) = func_get_args();
			if ($sender instanceof TColor) {
				$a1 = $sender->ColorRed;
				$a2 = $sender->ColorGreen;
				$a3 = $sender->ColorBlue;
				$a4 = $sender->ColorAlpha;
				
				//if (is_hex($a1)) $a1 = HexDec($a1);
				//if (is_hex($a2)) $a2 = HexDec($a2);
				//if (is_hex($a3)) $a3 = HexDec($a3);
				//if (is_hex($a4)) $a4 = HexDec($a4);
				
				if ($this->Number == 0)
				$this->Number++;
				$str = "qscreen";
				
				if ($this->Parent instanceof TObject ) { $str = "qscreen" ; } else
				if ($this->Parent instanceof TScreen ) { $str = "qscreen" ; } else
				if ($this->Parent instanceof TWindow ) { $str = "qwindow" ; }

				$_SESSION['document_stream'] .= ""
				. "$('#"
				. $str . $this->Number
				. "').css({'background-color':'rgb("
				. $a1 . "," . $a2 . "," . $a3
				. ")'});";
			}
		}	else
		if ($cnt == 3) {
			list($a1,$a2,$a3) = func_get_args();
			
			//if (is_hex($a1)) $a1 = HexDec($a1);
			//if (is_hex($a2)) $a2 = HexDec($a2);
			//if (is_hex($a3)) $a3 = HexDec($a3);

			if ($this->Number == 0)
			$this->Number++;
			$str = "qscreen";
				
			if ($this->Parent instanceof TObject ) { $str = "qscreen" ; } else
			if ($this->Parent instanceof TScreen ) { $str = "qscreen" ; } else
			if ($this->Parent instanceof TWindow ) { $str = "qwindow" ; }

			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $str . $this->Number
			. "').css({'background-color':'rgb("
			. $a1 . ","
			. $a2 . ","
			. $a3 . ")'});\n";
		}	else
		if ($cnt == 4) {
			list($a1,$a2,$a3,$a4) = func_get_args();

			//if (is_hex($a1)) $a1 = HexDec($a1);
			//if (is_hex($a2)) $a2 = HexDec($a2);
			//if (is_hex($a3)) $a3 = HexDec($a3);
			//if (is_hex($a4)) $a4 = HexDec($a4);

			if ($this->Number == 0)
			$this->Number++;
			$str = "qscreen";
			
			if ($this->Parent instanceof TObject ) { $str = "qscreen" ; } else
			if ($this->Parent instanceof TScreen ) { $str = "qscreen" ; } else
			if ($this->Parent instanceof TWindow ) { $str = "qwindow" ; }

			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $str . $this->Number
			. "').css({'background-color':'rgb("
			. $a1 . "," . $a2 . "," . $a3
			. ")'});";
		}
	}

	public function setImage() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($a1) = func_get_args();
			if ($a1 instanceof TString) {
				$im = $a1->Text;
			}	else
			if ($a1 instanceof TImage) {
				$im = $a1->FileName;
			}
			if (is_string($a1)) {
				$im = $a1;
			}
			
			if (empty($this->Image))
				$this->Image = new TImage($im);
			
			$str = "qscreen";
			
			if ($this->Parent instanceof TObject ) { $str = "qscreen" ; } else
			if ($this->Parent instanceof TScreen ) { $str = "qscreen" ; } else
			if ($this->Parent instanceof TWindow ) { $str = "qwindow" ; }

			if ($this->Number == 0)
				$this->Number++;
			
			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $str . $this->Number
			. "').css({'background-image':'url("
			. $this->Image->FileName
			. ")'});\n";
		}
	}

	// dtor: free used memory ...
	public function __destruct() {
	}
}


// -------------------------------------------------------
// class TVLayout: represents a vertical layout
// -------------------------------------------------------
trait THLayoutTrait {
}
class THLayoutClass {
	public $ClassTrait = "THLayoutTrait";
	public $ClassName  = "THLayout";
	
	public $Widgets = [];		// objects in this layout
	public $Parent     = null;	// parent of layout
	public $Margins    = null;
	
	public function __construct() {
		$Margins = new TMarginClass();
	}
	
	public function addWidget($widget) {
		array_push($this->Widgets,$widget);
	}
	
	public function __destruct() {
	}
}
class THLayout extends THLayoutClass {
	// --------------------------------------------
	// this is the real ctor, it call the fake ctor
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($parent) = func_get_args();
			parent::__construct($parent);
		}
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}

// -------------------------------------------------------
// class TVLayout: represents a vertical layout
// -------------------------------------------------------
trait TVLayoutTrait {
	public function Create2_TVLayoutTrait($sender,$a1) {
		TVLayoutClass::$Number++;
		if ($a1 instanceof TWindow) {
			$sender->Parent       = $a1;
			$sender->Parent->rect = $a1->rect;
			$sender->Margins      = $a1->Margins;
		}
		echo ""
		. "<div id='vlayout"
		. TVLayoutClass::$Number
		. "' style='"
		. "width:100vw;height:100px;"
		. "'></div>";
	}
	// --------------------------------------------
	// this is the real ctor, it call the fake ctor
	// Create<N> function.
	// The first arg<0> always set the SENDER !
	// --------------------------------------------
	public function __ctor_TVLayoutTrait() {
		$cnt = func_num_args();
		if ($cnt == 2) {
			list($sender,$a1) = func_get_args();
			TVLayoutTrait::Create2_TVLayoutTrait($sender,$a1);
		}
	}
}
class TVLayoutClass {
	public $ClassTrait = "TVLayoutTrait";
	public $ClassName  = "TVLayout";
	
	public $Widgets = [];		// objects in this layout
	public static $Number = 0;	// obj. id
	
	public $Parent     = null;	// parent of layout
	public $Margins    = null;
	public $rect       = null;
	
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 2) {
			list($sender,$a1) = func_get_args();
			TVLayoutTrait::__ctor_TVLayoutTrait($sender,$a1);
		}
	}
	
	// ctor: free memory ...
	public function __destruct() {
		$this->Widgets = [];
		unset($this->Margins);
	}
}
class TVLayout extends TVLayoutClass {
	// --------------------------------------------
	// this is the real ctor, it call the fake ctor
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($a1) = func_get_args();
			parent::__construct($this,$a1);
		}
	}
	
	// ctor: free memory ...
	public function __destruct() {
		parent::__destruct();
	}
}

// -------------------------------------------------------
// class TPanWindow: represents a application window/panel
// -------------------------------------------------------
class TPanWindow extends TObject
{
	public $ClassName  = "TPanWindow";
	public $ClassLHS   = "";
	public $ClassRHS   = "";
	
	public $Layout = null;
	
	public $uiText = "";
	public $Number =  0;

	public $Background = null;
	public $rect       = null;	// window size
	
	protected $init_layout = 0;

	// --------------------------------------------
	// this is the real ctor, it call the fake ctor
	// --------------------------------------------
	public function __construct() {
		$cnt = func_num_args();
		$this->rect = new TRect();
		if ($cnt == 0) {
			$this->Parent = new TObject($this);
		}	else
		if ($cnt == 2) {
			list($wc,$sender) = func_get_args();
			$this->Parent = $sender;
			
			if ($wc instanceof TDesktopWindow) {
				$this->ClassLHS = "qdesktop";
				$this->ClassRHS = "qscreen";
				$this->uiText   = "qscreen";
			}	else
			if ($wc instanceof TTaskBar) {
				$this->ClassLHS = "qtaskbar";
				$this->ClassRHS = "qscreen";
				$this->uiText   = "qscreen";
			}	else
			if ($wc instanceof TButton) {
				$this->ClassLHS = "qbutton";
				//$this->uiText   = "----------------" . $sender->uiText;
			}	else
			if ($wc instanceof TWindow) {
				$this->ClassLHS = "qwindow";
				$this->uiText   = "window";
			} else
			if ($wc instanceof TPanel ) {
				$this->ClassLHS = "qpanel";
				$this->uiText   = "panel";
			} else
			if ($wc instanceof TScreen) {
				$this->ClassLHS = "qscreen";
				$this->uiText   = "screen";
			}
		}
	}
	
	public function EmitCode($sender)
	{			
		// check, if panel div exist's
		$num = 0;
		/*
		while (1) {
			$str = $this->ClassLHS . $num++;
			if (!in_array($str, $this::$Controls)) {
				$this->Number = $num;
				array_push($this::$Controls,$str);
				break;
			}
		}*/
			
		$_SESSION['document_stream'] .= ""
		. "$('#"
		. $this->ClassLHS . $num
		. "').appendTo($('#"
		. $sender->uiText
		. $sender->Number
		. "'));";

		echo ""
		. "<div class='easyui-" . $this->uiText
		. "' id='"              . $this->ClassLHS . $num
		. "' style='position:relative;overflow:auto;"
		. "width:100px;height:50px;'></div>";
			

			// check, if panel div exist's
/*			$num = 0;
			while (1) {
				$str = "wipa" . $num;
				if (!in_array($str, $this::$idArray)) {
					array_push($this::$idArray, $str);
					break;
				}
				$num++;
			}
			if (($num-1) < 1) {
				echo ""
				. "<div id=\"wipa" . ($num-1)
				. "\" class=\"easyui-window\" title=\"Basic Window\" data-options=\""
				. "inline:'true',iconCls:'icon-save'\" "
				. "style=\"width:500px;height:400px;padding:0px;"
				. "\"></div>";
				
				$_SESSION['document_stream'] .= ""
				//. "$('#wipa" . ($num-1) . "').appendTo($('#qdesktop1'));"
				. "$('#wipa" . ($num-1) . "').panel('hide');";
			}*/
	}
	
	// ------------------------------------------
	// get the PARENT of given argument.
	// not given - the object PARENT will return 
	// ------------------------------------------
	public function getParent() {
		return $this->Parent;
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
	
	// ---------------------------------------------
	// set the background of the TWindow.
	// given on parameter, it is a color, or image.
	// ---------------------------------------------
	public function setBackground() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($sender) = func_get_args();
			if ($sender instanceof TColor) {
				if (empty($this->Color))
					$this->Color = new TColor($sender); else
					$this->Color = $sender;

				$a1 = $sender->ColorRed;
				$a2 = $sender->ColorGreen;
				$a3 = $sender->ColorBlue;
				$a4 = $sender->ColorAlpha;
				
				//if (is_hex($a1)) $a1 = HexDec($a1);
				//if (is_hex($a2)) $a2 = HexDec($a2);
				//if (is_hex($a3)) $a3 = HexDec($a3);
				//if (is_hex($a4)) $a4 = HexDec($a3);
				
				$_SESSION['document_stream'] .= ""
				. "$('#"
				. $this->ClassLHS
				. $this->Number
				. "').css('background-color','rgb("
				. $a1 . "," . $a2 . "," . $a3
				. ")');";
			}	else
			if ($sender instanceof TImage) {
				if (empty($this->Image))
					$this->Image = $sender;
				$_SESSION['document_stream'] .= ""
				. "$('#"
				. $this->ClassLHS
				. $this->Number
				. "').css({'background-image':'url("
				. $sender->FileName
				. ")'});\n";
			}
		}
	}

	// ----------------------------
	// set panel background-color
	// ----------------------------
	public function setColor() {
		$cnt = func_num_args();
		if ($cnt == 1) {
			list($a1) = func_get_args();
			if (is_string($a1)) {
				$_SESSION['document_stream'] .= ""
				. "$('#"
				. $this->ClassLHS
				. $this->Number
				. "').css('background-color','" . $a1
				. "');";
			}
		}	else
		if ($cnt == 3) {
			list($a1,$a2,$a3) = func_get_args();
			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $this->ClassLHS
			. $this->Number
			. "').css('background-color','rgb("
			. $a1 . "," . $a2 . "," . $a3
			. ")');";
		}
	}

	// ----------------------------
	// set panel icon image
	// ----------------------------
	public function setImage($a1,$a2,$a3) {
		if (is_string($a1)) {
			$_SESSION['document_stream'] .= ""
			. "$('#"
			. $this->ClassLHS
			. $this->Number
			. "').css({'opacity':'1.0'})"
			.   ".append('<div style=\"background-image:url("
			. $a1 . ");width:"
			. $a2 . ";height:"
			. $a3 . ";opacity:1.0;z-index:1;"
			. "\"><div style=\""
			. "position:absolute;font-weight:bold;"
			. "left:3px;bottom:0;"
			. "\">dBase4Web</div></div>');";
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

// -------------------------------------------------------
// class TPanel: represents a application panel
// -------------------------------------------------------
class TPanel extends TPanWindow
{
	public $ClassName = "TPanel";
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);
		$this->uiText = $sender->uiText;
		parent::EmitCode($this);
	}
	public function __destruct() {
		parent::__destruct();
	}
}

// -------------------------------------------------------
// class TWindow: represents a application window
// -------------------------------------------------------
class TWindow extends TPanWindow
{
	public $ClassName = "TWindow";
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);
		$this->uiText = $sender->uiText;
		parent::EmitCode($this);
	}
	public function __destruct() {
		parent::__destruct();
	}
}

// -------------------------------------------------------
// class TDesktopWindow: represents a desktop panel
// -------------------------------------------------------
class TDesktopWindow extends TPanel {
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);
		$this->uiText = $sender->uiText;
		parent::EmitCode($this);
	}
	public function __destruct() {
		parent::__destruct();
	}
}

class TTaskBar extends TPanel {
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);
		$this->uiText = $sender->uiText;
		parent::EmitCode($this);
	}
	public function __destruct() {
		parent::__destruct();
	}
}

class TButton extends TPanel {
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);
		$this->uiText = $sender->uiText;
		parent::EmitCode($this);
	}
	public function __destruct() {
		parent::__destruct();
	}
}

// -------------------------------------------------------
// class TPanel: represents a application panel
// -------------------------------------------------------
class TDesktopIcon extends TPanWindow
{
	public $ClassName = "TDesktopIcon";
	public function __construct() {
		$cnt = func_num_args();
		list($sender) = func_get_args();
		parent::__construct($this,$sender);
	}
	public function __destruct() {
	}
}

// -------------------------------------
// construct a simple application ...
// -------------------------------------
//$my_device = new TDevice(new TAndroid());
//$my_screen  = new TScreen(new TColor(0,64,190));	// screen: 0

/*
$my_desktop = new TDesktopWindow($my_screen);		// the desktop (icons...)
$my_desktop->setHeight("calc(100vh - 36px)");
$my_desktop->setWidth ("100vw");
$my_desktop->setBackground(new TImage("/pub/bg.jpg"));

$my_taskbar = new TTaskBar($my_screen); 			// the taskbar: window
$my_taskbar->setHeight("36px");
$my_taskbar->setWidth("100vw");
$my_taskbar->setColor(110,64,160);	// window: color
$my_taskbar->setOpacity(1.0);

// start button
$my_startbtn = new TButton($my_taskbar);
$my_startbtn->setHeight("36px");
$my_startbtn->setBackgroundNormal ("/pub/desk/img/StartButtonNormal.png" );
$my_startbtn->setBackgroundClicked("/pub/desk/img/StartButtonClicked.png");
$my_startbtn->setBackgroundHover  ("/pub/desk/img/StartButtonHover.png"  ,"/pub/desk/img/StartButtonNormal.png");
//$my_startbtn->onClick(function() {
	//$my_startbar = new TPanel($my_desktop);
	//$my_startbar->setHeight("100px");
	//$my_startbar->setWidth("120px");
//});

/*
// dBase 4 web 1.0 ...
$my_app = new TWindow($my_desktop);
$my_app->setMoveable(true);
$my_app->setHeight("100px");
$my_app->setWidth("100px");
$my_app->setColor(0,100,200);
$my_app->setImage("/pub/desk/img/monster.png","94px","74px");
/*
$my_app->onDblClick(function() {
		$func_str = "";
		$func = array(
			function() { return $my_app->setTitle('dBase-4-Web'); },
			function() { return $my_app->setLayout('east',100);   },
			function() { return $my_app->show();                  }
		);
		for ($idx = 0; $idx < count($func); $idx++)
			 $func_str .= $func()[$idx];    return
		     $func_str ;
	}
);*/


// -------------------------------------
// create a screen desktop ...
// -------------------------------------
InitializeFrameWork();		// init stuff
echo "<pre>";
//$my_screen = new TScreen();
$my_device = new TDevice(new TScreen());

//print_r($my_screen);
//print_r($my_device);

// this section comes/goes from/to TApplication
echo "<body>"
. "<div id='container'></div>"
. "<script>"
. "$(document).ready(function(){" . $_SESSION['document_stream']
. "});"
. "</script>"
. "</body></html>";

// start test application
//MainEntryPoint();
?>
