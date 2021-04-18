<?php
// ------------------------------------------------------
// File    : /tools/php/misc.php
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// ------------------------------------------------------

// clear anonymus functions:
unset($get_link_key);
unset($get_link_value);
unset($expandDirectoriesMatrix);
unset($output_loadFile);
unset($base64_a_img_link);
unset($base__file);
unset($base64_img_href);
unset($base64_css_href);
unset($base64_url_jpg);
unset($base64_src_png);
unset($base64_src);
unset($getUserLanguage);
unset($get_header_language);
unset($getOS);

unset($toolclass);

class MiscToolsClass
{
	// ---------------------------------------------
	// search for NAME, and give the key back ...
	// ---------------------------------------------
	public function get_link_key ($array, $name) {
		foreach ($array as $key => $value) {
			if (strcmp($value,$name) == 0) {
				return $key;
				break;
			}
		}
		return "notfound";
	}
	// ---------------------------------------------
	// search for NAME, and give back the value ...
	// ---------------------------------------------
	public function get_link_value ($array, $name) {
		foreach ($array as $key => $value) {
			if (strcmp($key,$name) == 0) {
				return $value;
				break;
			}
		}
		return "notfound";
	}
	public function mySha512($str, $salt, $iterations) {
        for ($x=0; $x<$iterations; $x++) {
            $str = hash('sha512', $str . $salt);
        }
        return $str;
    }
	public function expandDirectoriesMatrix ($base_dir, $level = 0) {
		foreach(scandir($base_dir) as $file) {
			if ($file == '.' || $file == '..') continue;
			$dir = $base_dir."/".$file;
			$tmp = ltrim($dir,$_SERVER['DOCUMENT_ROOT']);
			$tmp = ltrim($tmp,"intern/4430");
			$tmp = ltrim($tmp,"/\\");
			if (is_dir($dir)) {
				$_SESSION['dir_array']["'" .
				bin2hex(random_bytes(32))  . "'"] = $tmp;
				$this->expandDirectoriesMatrix($dir, $level +1);
			}	else if (is_file($dir)) {
				$_SESSION['dir_array']["'" .
				bin2hex(random_bytes(32))  . "'"] = $tmp;
			}
		}
	}
	public function output_loadFile ($file) {
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			exit;
		}
		else {
			echo "not foundser";
		}
	}
	// --------------------------------------------------
	// create: <a href='$link'><img src='$image'/></a>
	// --------------------------------------------------
	public function base64_a_img_link ($link, $image) {
		$file = $_SESSION['dir_array'][$this->get_link_key($_SESSION['dir_array'],$image)];
		$file = $_SESSION['doc_root'] . "/" . $file;
		$link = base64_encode($link);
		$result = "<a href='" . $link . "' class='hlink' onclick='clickLink(this); return false;'><img src='data:image/png;base64,";
		$result = $result . base64_encode(file_get_contents($file));
		$result = $result . "'/></a>";
		return $result;
	}
	public function base__file ($image) {
		$file = $_SESSION['dir_array'][$this->get_link_key($_SESSION['dir_array'],$image)];
		$file = $_SESSION['doc_root'] . "/" . $file;
		return $file;
	}
	public function base64_img_href ($image) {
		try {
			$result = "href='data:image/png;base64,";
			$file   = str_replace("/","\\",$this->base__file($image));
			$result = $result . base64_encode(file_get_contents($file)) . "'";
			return $result;
		}
		catch (Exception $e) { }
	}
	public function base64_css_href ($image) {
		try {
			$result = "href='data:text/css;base64,";
			$file   = str_replace("/","\\",$this->base__file($image));
			$result = $result . base64_encode(file_get_contents($file)) . "'";
			return $result;
		}
		catch (Exception $e) { }
	}
	public function base64_url_jpg ($image) {
		try {
			$result = "url('data:image/jpg;base64,";
			$file   = str_replace("/","\\",$this->base__file($image));
			$result = $result . base64_encode(file_get_contents($file)) . "')";
			return $result;
		}
		catch (Exception $e) { }
	}
	public function base64_src_png ($image) {
		try {
			$result = "src='data:image/png;base64,";
			$file   = str_replace("/","\\",$this->base__file($image));
			$result = $result . base64_encode(file_get_contents($file)) . "'";
			return $result;
		}
		catch (Exception $e) { }
	}
	public function base64_src ($image) {
		try {
			$result = "href='data:text/plain;base64,";
			$file   = str_replace("/","\\",$this->base__file($image));
			$result = $result . base64_encode(file_get_contents($file)) . "'";
			return $result;
		}
		catch (Exception $e) { }
	}
	public function getUserLanguage () {
		$langs = array();

		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			// break up string into pieces (languages and q factors)
			preg_match_all(
				'/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i',
				$_SERVER['HTTP_ACCEPT_LANGUAGE'],
				$lang_parse
			);

			if (count($lang_parse[1])) {
				// create a list like 'en' => 0.8
				$langs = array_combine($lang_parse[1], $lang_parse[4]);

				// set default to 1 for any without q factor
				foreach ($langs as $lang => $val) {
					if ($val === '') {
						$langs[$lang] = 1;
					}
				}
				// sort list based on value
				arsort($langs, SORT_NUMERIC);
			}
		}
		//extract most important (first)
		reset($langs);
		$lang = key($langs);

		//if complex language simplify it
		if (stristr($lang, '-')) {
			list($lang) = explode('-', $lang);
		}

		return $lang;
	}
	public function get_header_language () {
		$langs = array();
		$site_lang = "";

		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			// break up string into pieces (languages and q factors)
			preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i',
			$_SERVER['HTTP_ACCEPT_LANGUAGE'],
			$lang_parse);

			if (count($lang_parse[1])) {
				// create a list like "en" => 0.8
				$langs = array_combine($lang_parse[1], $lang_parse[4]);
				
				// set default to 1 for any without q factor
				foreach ($langs as $lang => $val) {
					if ($val === '') $langs[$lang] = 1;
				}

				// sort list based on value	
				arsort($langs, SORT_NUMERIC);
			}
		}
		// look through sorted list and use first one that matches our languages
		foreach ($langs as $lang => $val) {
			if (strpos($lang, 'de') === 0) {
				$site_lang = $lang;
			}	else if (strpos($lang, 'en') === 0) {
				$site_lang = $lang;
			} 
		}
		return $site_lang;
	}
	public function getOS () { 
		if(isset($_SERVER['HTTP_USER_AGENT'])) {
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
		}
		$os_array     = array(
			'windows nt 10'                              	=>  'Windows 10',
			'windows nt 6.3'                             	=>  'Windows 8.1',
			'windows nt 6.2'                             	=>  'Windows 8',
			'windows nt 6.1|windows nt 7.0'              	=>  'Windows 7',
			'windows nt 6.0'                             	=>  'Windows Vista',
			'windows nt 5.2'                             	=>  'Windows Server 2003/XP x64',
			'windows nt 5.1'                             	=>  'Windows XP',
			'windows xp'                                 	=>  'Windows XP',
			'windows nt 5.0|windows nt5.1|windows 2000'  	=>  'Windows 2000',
			'windows me'                                 	=>  'Windows ME',
			'windows nt 4.0|winnt4.0'                    	=>  'Windows NT',
			'windows ce'                                 	=>  'Windows CE',
			'windows 98|win98'                           	=>  'Windows 98',
			'windows 95|win95'                           	=>  'Windows 95',
			'win16'                                      	=>  'Windows 3.11',
			'mac os x 10.1[^0-9]'                        	=>  'Mac OS X Puma',
			'macintosh|mac os x'                         	=>  'Mac OS X',
			'mac_powerpc'                                	=>  'Mac OS 9',
			'linux'                                      	=>  'Linux',
			'ubuntu'                                     	=>  'Linux - Ubuntu',
			'iphone'                                     	=>  'iPhone',
			'ipod'                                       	=>  'iPod',
			'ipad'                                       	=>  'iPad',
			'android'                                    	=>  'Android',
			'blackberry'                                 	=>  'BlackBerry',
			'webos'                                     	=>  'Mobile',

			'(media center pc).([0-9]{1,2}\.[0-9]{1,2})'	=>	'Windows Media Center',
			'(win)([0-9]{1,2}\.[0-9x]{1,2})'				=>	'Windows',
			'(win)([0-9]{2})'								=>	'Windows',
			'(windows)([0-9x]{2})'							=>	'Windows',

			'Win 9x 4.90'									=>	'Windows ME',
			'(windows)([0-9]{1,2}\.[0-9]{1,2})' 			=>	'Windows',
			'win32' 										=>	'Windows',
			'(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})'	=>	'Java',
			'(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}'		=>	'Solaris',
			'dos x86'										=>	'DOS',
			'Mac OS X'										=>	'Mac OS X',
			'Mac_PowerPC'									=>	'Macintosh PowerPC',
			'(mac|Macintosh)'								=>	'Mac OS',
			'(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'			=>	'SunOS',
			'(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'			=>	'BeOS',
			'(risc os)([0-9]{1,2}\.[0-9]{1,2})' 			=>	'RISC OS',
			'unix'											=>	'Unix',
			'os/2'											=>	'OS/2',
			'freebsd'										=>	'FreeBSD',
			'openbsd'										=>	'OpenBSD',
			'netbsd'										=>	'NetBSD',
			'irix'											=>	'IRIX',
			'plan9' 										=>	'Plan9',
			'osf'											=>	'OSF',
			'aix'											=>	'AIX',
			'GNU Hurd'										=>	'GNU Hurd',
			'(fedora)'										=>	'Linux - Fedora',
			'(kubuntu)' 									=>	'Linux - Kubuntu',
			'(ubuntu)'										=>	'Linux - Ubuntu',
			'(debian)'										=>	'Linux - Debian',
			'(CentOS)'										=>	'Linux - CentOS',
			
			'(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)' =>	'Linux - Mandriva',
			'(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)' 	=>	'Linux - SUSE',
			
			'(Dropline)'									=>	'Linux - Slackware (Dropline GNOME)',
			'(ASPLinux)'									=>	'Linux - ASPLinux',
			'(Red Hat)' 									=>	'Linux - Red Hat',
			
			'(linux)'										=>	'Linux',
			'(amigaos)([0-9]{1,2}\.[0-9]{1,2})' 			=>	'AmigaOS',
			'amiga-aweb'									=>	'AmigaOS',
			'amiga' 										=>	'Amiga',
			'AvantGo'										=>	'PalmOS',
			'(webtv)/([0-9]{1,2}\.[0-9]{1,2})'				=>	'WebTV',
			'Dreamcast' 									=>	'Dreamcast OS',
			
			'GetRight'										=>	'Windows',
			'go!zilla'										=>	'Windows',
			'gozilla'										=>	'Windows',
			'gulliver'										=>	'Windows',
			'ia archiver'									=>	'Windows',
			'NetPositive'									=>	'Windows',
			'mass downloader'								=>	'Windows',
			'microsoft'										=>	'Windows',
			'offline explorer'								=>	'Windows',
			'teleport'										=>	'Windows',
			'web downloader'								=>	'Windows',
			'webcapture'									=>	'Windows',
			'webcollage'									=>	'Windows',
			'webcopier'										=>	'Windows',
			'webstripper'									=>	'Windows',
			'webzip'										=>	'Windows',
			'wget'											=>	'Windows',
			'Java'											=>	'Unknown',
			'flashget'										=>	'Windows',
			'MS FrontPage'									=>	'Windows',
			'(msproxy)/([0-9]{1,2}.[0-9]{1,2})' 			=>	'Windows',
			'(msie)([0-9]{1,2}.[0-9]{1,2})' 				=>	'Windows',
			'libwww-perl'									=>	'Unix',
			'UP.Browser'									=>	'Windows CE',
			'NetAnts'										=>	'Windows'
		);
		$arch_regex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
		$arch = preg_match($arch_regex, $user_agent) ? '64' : '32';
		foreach ($os_array as $regex => $value) {
			if (preg_match('{\b('.$regex.')\b}i', $user_agent)) {
				return $value.' x'.$arch;
			}
		}
		return 'Unknown';
	}
}
$toolclass = new MiscToolsClass;

?>