<?php
// ------------------------------------------------------
// File    : src/TInitialize.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

require_once( "TObject.php" );
require_once( "TRect.php" );
require_once( "TMarginRect.php" );
require_once( "TPaddingRect.php" );
require_once( "TVisualRect.php" );
require_once( "TPainterScreen.php" );
require_once( "TColor.php" );
require_once( "TPaintDevice.php" );
require_once( "TDevice.php" );
require_once( "TScreen.php" );

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
	// -----------------------------------------------
	// initial variables ...
	// -----------------------------------------------
	$_SESSION['document_stream'] = "";
	$_SESSION['ClassRegister'  ] = array(); 	// default suported classes
	
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
// write body header ...
// -------------------------------------
function WriteBodyContent()
{
	echo ""
	. "<div id='container'></div>"
	. "<script>"
	. "$(document).ready(function(){"
	. $_SESSION['document_stream']
	. "});"
	. "</script>"
	. "</body></html>";
}

?>