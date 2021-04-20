<?php
// ------------------------------------------------------
// File    : src/TInitialize.php
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

function invoke_workfiles()
{
	$workfiles = array(
		"TAndroid",
		"TApplication",
		"TBackground",
		"TButton",
		"TColor",
		"TControl",
		"TDesktopIcon",
		"TDesktopWindow",
		"TDevice",
		"TException",
		"TImage",
		"TLocales",
		"TMarginRect",
		"TObject",
		"TPaddingRect",
		"TPaintDevice",
		"TPainterScreen",
		"TPrinter",
		"TRect",
		"TScreen",
		"TString",
		"TTablet",
		"TTaskBar",
		"TUrl",
		"TUtils",
		"TVisualRect",
		"TWidget",
		"TWindow"
	);

	// invoke file's ...
	echo "<script>\n";
	$reqn = "required file: ";
	
	spl_autoload_extensions('.php,.inc');
	foreach ($workfiles as $workfile)
	{
		$file = file_build_path( __DIR__ , "..", "src", $workfile . ".php");
		if (file_exists($file)) {
			spl_autoload($file);
			echo ""
			. "console.info('"
			. $reqn
			. $file
			. " load ok.');\n";
		}	else {
			echo ""
			. "console.error('"
			. $reqn
			. $file
			. " not found.');";
		}
	}
	echo "</script>";
}

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
	
	invoke_workfiles();
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