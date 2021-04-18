<?php
// ------------------------------------------------------
// File    : /pub/test.php
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// ------------------------------------------------------
// web-pages must be always start by session !
// -----------------------------------------------
session_start();

$dirsep = DIRECTORY_SEPARATOR;
$_SESSION['dir_sep']  = $dirsep;

// RewriteRule "^/pub/(.*)" "-" [E=HTTP_DOCDIR_HEADER:${APACHE_DSL}]
if (!isset($_SERVER['REDIRECT_HTTP_DOCDIR_HEADER']))
	$_SESSION['doc_root'] = $_SERVER['HTTP_DOCDIR_HEADER']; else
	$_SESSION['doc_root'] = $_SERVER['REDIRECT_HTTP_DOCDIR_HEADER'];
	$_SESSION['doc_root'] = str_replace(array('/'),$dirsep,$_SESSION['doc_root']);

require_once( $_SESSION['doc_root']
	. $dirsep . "tools"
	. $dirsep . "php"
	. $dirsep . "misc.php" );
require_once( $_SESSION['doc_root']
	. $dirsep . "tools"
	. $dirsep . "php"
	. $dirsep . "head.php" );
				  
if (isset($_REQUEST['bw_username'])
&&  isset($_REQUEST['bw_password'])
&&  isset($_GET['id']))
{
	if ($_GET['id'] == 'NOTFOUND') {
		echo '<script type="text/javascript">window.location = ' .
			 '"/pub/indexaaaa.php?' .
		 	 '?bw_username=' . $uhash   .
		 	 '&bw_userpass=' . $phash   . '"></script>';
	}

	$param  = base64_encode(bin2hex(random_bytes(32)));

	$rqusr = $_REQUEST['bw_username'];
	$rqpwd = $_REQUEST['bw_password'];
	
	$uhash = md5($rqusr);
	$phash = md5($rqpwd);
	
	// ----------------------------------
	// double check: user + pass ...
	// ----------------------------------
	if (crypt($rqusr,$uhash) == $uhash) {
		if (crypt($rqpwd,$phash) == $phash) {
			// todo: check user database

			// data ok, redirect ...
			// Note: we can't use "header()" here, because they are already written !			
			$_SESSION['pass_ok'] = true;
			echo '<script type="text/javascript">window.location = ' .
			'"/pub/desk/index3.php?'    .
			'?bw_username=' . $uhash   .
			'&bw_userpass=' . $phash   . '"></script>';
			die(); exit;
		}	else {
			header('Location: /pub');
			die(); exit;
		}
	}	else {
		header('Location: /pub');
		die(); exit;
	}
}	else {
	$_SESSION['pass_ok'] = false;
}

	// Apache config: time based office time ...
	if (!isset($_SERVER['HTTP_OFFICE_HEADER']))
		$office = $_SERVER['REDIRECT_HTTP_OFFICE_HEADER']; else
		$office = $_SERVER['HTTP_OFFICE_HEADER'];
		$status = 0;

	if (strcmp($office,"0") == 0)
	$status = 0; else
	$status = 1;

	echo "<body>";

	if (!isset($_REQUEST['bw_username'])) {
	echo <<<EOL1
	<a name="index"></a>
	<div class="intro">
		<div class="header">
			<div class="mmenu1" ank="index">
				Start
			</div>
			<div class="mmenu1">
				Login
			</div>
			<div class="mmenu1">
				Services
			</div>
			<div class="mmenu1" ank="impress">
				Kontakt
			</div>
			<div class="mmenu1" ank="impress">
				Impressum
			</div>
		</div>
		<div class="logo3-fit">
EOL1;
		echo '<img ';
		echo base64_src_png('pub/images/logo3.png');
		echo ' alt="logo" />';
		
		echo <<<EOL01
		</div>
		<div class="balken">
			<center>
				"Bildung für Alle", ist Unsere Mission.<br>
				Jeder Erfolg, bringt auch ein wenig Hoffnung...
			</center>
		</div>
EOL01;
		if ($status == 0) {
		echo <<<EOL2
		<div class="outofficetime">
			<center>
			<table border="0">
				<tr>
				<td width="25%"></td>
				<td width="50%">
					<center>
					Wir haben geschlossen !!!<br>
					Unsere &Ouml;ffnungszeiten:
					<p>Mon - Fri : 07:00 bis 18:00 Uhr
					</p>
					</center>
				</td>
				<td width="25%"></td>
				</tr>
			</table>
			</center>
		</div>
EOL2;
		}
		echo <<<EOL3
		<div>
		<hr>
		<table>
			<tr>
				<td>
					<script>
						var data = window.atob('PGRpdiBjbGFzcz0iaW1wbGlua3MiPgo8YnI+PGJ'  +
						'yPjxoMT48YSBuYW1lPSJpbXByZXNzIj5JbXByZXNzdW08L2E+PC9oMT48cD5Bb'  +
						'mdhYmVuIGdlbcOkw58gwqcgNSBUTUc8L3A+PHA+SmVucyBLYWxsdXA8YnI+SW0g' +
						'RW50ZW5iYWQgMjxicj45OTgyMCBCZWhyaW5nZW4gPGJyPjwvcD48cD48c3Ryb25' +
						'nPlZlcnRyZXRlbiBkdXJjaDogPC9zdHJvbmc+PGJyPkplbnMgS2FsbHVwPGJyPj' +
						'wvcD48L2Rpdj4=');
						data = decode_utf8(data);
						document.write(data);
					</script>
				</td>
EOL3;
		//if ($status == 0)
		{  // todo
			$link = '/pub/desk/index11.php';
			if ($_SESSION['pass_ok'] == true) {
				$link = '/pub/desk/indexlll000.php' .
						'?username=' . $uhash .
						'&userpass=' . $phash ;
			}
			echo "<td>";
			echo "<form method='post' action='" . $link . "'>";
			echo <<<EOL4
					<table>
						<tr>
							<td colspan="2">Gebens Sie Bitte Ihre Zugangsdaten ein:</td>
						</tr>
						<tr>
							<td><b>Kundennummer:</b></td>
							<td><input type="text" name="bw_username" value="" id="bw_username"></td>
						</tr>
						<tr>
							<td><b>Passwort:</b></td>
							<td><input type="password" name="bw_password" value="" id="bw_password"></td>
						</tr>
						<tr>
							<td><input type="submit" value="Login" name="bw_login"></td>
						</tr>
					</table>
				</form>
				</td>
			</tr>
		</table>
		</div>
		<div></div>
		<div><p>&nbsp;</p></div>
EOL4;
		}
?>		<div class='impressum'>
		<script>
		var data = window.atob('PGJyPjxicj4KCQkJPHA+PHN0cm9uZz5Lb250Y'  +
		'Wt0Ojwvc3Ryb25nPiA8YnI+CgkJCQlUZWxlZm9uOiAwMTUyMzE3MTA1ODAtM'  +
		'Dxicj4KCQkJCUUtTWFpbDogPGEgaHJlZj0nbWFpbHRvOmthbGx1cC5qZW5zQH' +
		'dlYi5kZSc+a2FsbHVwLmplbnNAd2ViLmRlPC9hPjwvYnI+CgkJCTwvcD4KCQk' +
		'JPHA+CgkJCQk8c3Ryb25nPkhhZnR1bmdzYXVzc2NobHVzczo8L3N0cm9uZz48' +
		'YnI+PGJyPgoJCQkJPHN0cm9uZz5IYWZ0dW5nIGbDvHIgSW5oYWx0ZTwvc3Ryb' +
		'25nPjxicj48YnI+CgkJCQlEaWUgSW5oYWx0ZSB1bnNlcmVyIFNlaXRlbiB3dX' +
		'JkZW4gbWl0IGdyw7bDn3RlciBTb3JnZmFsdCBlcnN0ZWxsdC4KCQkJCUbDvHI' +
		'gZGllIFJpY2h0aWdrZWl0LCBWb2xsc3TDpG5kaWdrZWl0IHVuZCBBa3R1YWxp' +
		'dMOkdCBkZXIgSW5oYWx0ZQoJCQkJa8O2bm5lbiB3aXIgamVkb2NoIGtlaW5lI' +
		'Edld8OkaHIgw7xiZXJuZWhtZW4uCgkJCQlBbHMgRGllbnN0ZWFuYmlldGVyIH' +
		'NpbmQgd2lyIGdlbcOkw58gwqcgNyBBYnMuMSBUTUcgZsO8ciBlaWdlbmUgSW5' +
		'oYWx0ZQoJCQkJYXVmIGRpZXNlbiBTZWl0ZW4gbmFjaCBkZW4gYWxsZ2VtZWlu' +
		'ZW4gR2VzZXR6ZW4gdmVyYW50d29ydGxpY2guCgkJCQlOYWNoIMKnwqcgOCBia' +
		'XMgMTAgVE1HIHNpbmQgd2lyIGFscyBEaWVuc3RlYW5iaWV0ZXIgamVkb2NoIG' +
		'5pY2h0CgkJCQl2ZXJwZmxpY2h0ZXQsIMO8YmVybWl0dGVsdGUgb2RlciBnZXN' +
		'wZWljaGVydGUgZnJlbWRlIEluZm9ybWF0aW9uZW4KCQkJCXp1IMO8YmVyd2Fj' +
		'aGVuIG9kZXIgbmFjaCBVbXN0w6RuZGVuIHp1IGZvcnNjaGVuLCBkaWUgYXVmI' +
		'GVpbmUgcmVjaHRzd2lkcmlnZQoJCQkJVMOkdGlna2VpdCBoaW53ZWlzZW4uIF' +
		'ZlcnBmbGljaHR1bmdlbiB6dXIgRW50ZmVybnVuZyBvZGVyIFNwZXJydW5nIGR' +
		'lciBOdXR6dW5nCgkJCQl2b24gSW5mb3JtYXRpb25lbiBuYWNoIGRlbiBhbGxn' +
		'ZW1laW5lbiBHZXNldHplbiBibGVpYmVuIGhpZXJ2b24gdW5iZXLDvGhydC4KC' +
		'QkJCUVpbmUgZGllc2JlesO8Z2xpY2hlIEhhZnR1bmcgaXN0IGplZG9jaCBlcn' +
		'N0IGFiIGRlbSBaZWl0cHVua3QgZGVyIEtlbm50bmlzCgkJCQllaW5lciBrb25' +
		'rcmV0ZW4gUmVjaHRzdmVybGV0enVuZyBtw7ZnbGljaC4gQmVpIEJla2FubnR3' +
		'ZXJkZW4gdm9uIGVudHNwcmVjaGVuZGVuCgkJCQlSZWNodHN2ZXJsZXR6dW5nZ' +
		'W4gd2VyZGVuIHdpciBkaWVzZSBJbmhhbHRlIHVtZ2VoZW5kIGVudGZlcm5lbi' +
		'48YnI+PGJyPgoJCQkJPHN0cm9uZz5IYWZ0dW5nIGbDvHIgTGlua3M8L3N0cm9' +
		'uZz48YnI+PGJyPgoJCQkJVW5zZXIgQW5nZWJvdCBlbnRow6RsdCBMaW5rcyB6' +
		'dSBleHRlcm5lbiBXZWJzZWl0ZW4gRHJpdHRlciwgYXVmIGRlcmVuIEluaGFsd' +
		'GUgd2lyCgkJCQlrZWluZW4gRWluZmx1c3MgaGFiZW4uIERlc2hhbGIga8O2bm' +
		'5lbiB3aXIgZsO8ciBkaWVzZSBmcmVtZGVuIEluaGFsdGUgYXVjaCBrZWluZQo' +
		'JCQkJR2V3w6RociDDvGJlcm5laG1lbi4gRsO8ciBkaWUgSW5oYWx0ZSBkZXIg' +
		'dmVybGlua3RlbiBTZWl0ZW4gaXN0IHN0ZXRzIGRlciBqZXdlaWxpZ2UKCQkJC' +
		'UFuYmlldGVyIG9kZXIgQmV0cmVpYmVyIGRlciBTZWl0ZW4gdmVyYW50d29ydG' +
		'xpY2guIERpZSB2ZXJsaW5rdGVuIFNlaXRlbiB3dXJkZW4KCQkJCXp1bSBaZWl' +
		'0cHVua3QgZGVyIFZlcmxpbmt1bmcgYXVmIG3DtmdsaWNoZSBSZWNodHN2ZXJz' +
		'dMO2w59lIMO8YmVycHLDvGZ0LiBSZWNodHN3aWRyaWdlCgkJCQlJbmhhbHRlI' +
		'HdhcmVuIHp1bSBaZWl0cHVua3QgZGVyIFZlcmxpbmt1bmcgbmljaHQgZXJrZW' +
		'5uYmFyLiBFaW5lIHBlcm1hbmVudGUKCQkJCWluaGFsdGxpY2hlIEtvbnRyb2x' +
		'sZSBkZXIgdmVybGlua3RlbiBTZWl0ZW4gaXN0IGplZG9jaCBvaG5lIGtvbmty' +
		'ZXRlIEFuaGFsdHNwdW5rdGUKCQkJCWVpbmVyIFJlY2h0c3ZlcmxldHp1bmcgb' +
		'mljaHQgenVtdXRiYXIuIEJlaSBCZWthbm50d2VyZGVuIHZvbiBSZWNodHN2ZX' +
		'JsZXR6dW5nZW4KCQkJCXdlcmRlbiB3aXIgZGVyYXJ0aWdlIExpbmtzIHVtZ2V' +
		'oZW5kIGVudGZlcm5lbi48YnI+PGJyPgoJCQkJPHN0cm9uZz5VcmhlYmVycmVj' +
		'aHQ8L3N0cm9uZz48YnI+PGJyPgoJCQkJRGllIGR1cmNoIGRpZSBTZWl0ZW5iZ' +
		'XRyZWliZXIgZXJzdGVsbHRlbiBJbmhhbHRlIHVuZCBXZXJrZSBhdWYgZGllc2' +
		'VuIFNlaXRlbgoJCQkJdW50ZXJsaWVnZW4gZGVtIGRldXRzY2hlbiBVcmhlYmV' +
		'ycmVjaHQuIERpZSBWZXJ2aWVsZsOkbHRpZ3VuZywgQmVhcmJlaXR1bmcsCgkJ' +
		'CQlWZXJicmVpdHVuZyB1bmQgamVkZSBBcnQgZGVyIFZlcndlcnR1bmcgYXXDn' +
		'2VyaGFsYiBkZXIgR3JlbnplbiBkZXMgVXJoZWJlcnJlY2h0ZXMKCQkJCWJlZM' +
		'O8cmZlbiBkZXIgc2NocmlmdGxpY2hlbiBadXN0aW1tdW5nIGRlcyBqZXdlaWx' +
		'pZ2VuIEF1dG9ycyBiencuIEVyc3RlbGxlcnMuCgkJCQlEb3dubG9hZHMgdW5k' +
		'IEtvcGllbiBkaWVzZXIgU2VpdGUgc2luZCBudXIgZsO8ciBkZW4gcHJpdmF0Z' +
		'W4sIG5pY2h0IGtvbW1lcnppZWxsZW4KCQkJCUdlYnJhdWNoIGdlc3RhdHRldC' +
		'4gU293ZWl0IGRpZSBJbmhhbHRlIGF1ZiBkaWVzZXIgU2VpdGUgbmljaHQgdm9' +
		'tIEJldHJlaWJlcgoJCQkJZXJzdGVsbHQgd3VyZGVuLCB3ZXJkZW4gZGllIFVy' +
		'aGViZXJyZWNodGUgRHJpdHRlciBiZWFjaHRldC4gSW5zYmVzb25kZXJlIHdlc' +
		'mRlbgoJCQkJSW5oYWx0ZSBEcml0dGVyIGFscyBzb2xjaGUgZ2VrZW5uemVpY2' +
		'huZXQuIFNvbGx0ZW4gU2llIHRyb3R6ZGVtIGF1ZiBlaW5lCgkJCQlVcmhlYmV' +
		'ycmVjaHRzdmVybGV0enVuZyBhdWZtZXJrc2FtIHdlcmRlbiwgYml0dGVuIHdp' +
		'ciB1bSBlaW5lbiBlbnRzcHJlY2hlbmRlbgoJCQkJSGlud2Vpcy4gQmVpIEJla' +
		'2FubnR3ZXJkZW4gdm9uIFJlY2h0c3ZlcmxldHp1bmdlbiB3ZXJkZW4gd2lyIG' +
		'RlcmFydGlnZSBJbmhhbHRlCgkJCQl1bWdlaGVuZCBlbnRmZXJuZW4uPGJyPjx' +
		'icj4KCQkJCTxzdHJvbmc+RGF0ZW5zY2h1dHo8L3N0cm9uZz48YnI+PGJyPgoJ' +
		'CQkJRGllIE51dHp1bmcgdW5zZXJlciBXZWJzZWl0ZSBpc3QgaW4gZGVyIFJlZ' +
		'2VsIG9obmUgQW5nYWJlIHBlcnNvbmVuYmV6b2dlbmVyCgkJCQlEYXRlbiBtw7' +
		'ZnbGljaC4gU293ZWl0IGF1ZiB1bnNlcmVuIFNlaXRlbiBwZXJzb25lbmJlem9' +
		'nZW5lIERhdGVuIChiZWlzcGllbHN3ZWlzZQoJCQkJTmFtZSwgQW5zY2hyaWZ0' +
		'IG9kZXIgZU1haWwtQWRyZXNzZW4pIGVyaG9iZW4gd2VyZGVuLCBlcmZvbGd0I' +
		'GRpZXMsIHNvd2VpdAoJCQkJbcO2Z2xpY2gsIHN0ZXRzIGF1ZiBmcmVpd2lsbG' +
		'lnZXIgQmFzaXMuIERpZXNlIERhdGVuIHdlcmRlbiBvaG5lIElocmUgYXVzZHL' +
		'DvGNrbGljaGUKCQkJCVp1c3RpbW11bmcgbmljaHQgYW4gRHJpdHRlIHdlaXRl' +
		'cmdlZ2ViZW4uIDxicj4KCQkJCVdpciB3ZWlzZW4gZGFyYXVmIGhpbiwgZGFzc' +
		'yBkaWUgRGF0ZW7DvGJlcnRyYWd1bmcgaW0gSW50ZXJuZXQKCQkJCSh6LkIuIG' +
		'JlaSBkZXIgS29tbXVuaWthdGlvbiBwZXIgRS1NYWlsKSBTaWNoZXJoZWl0c2z' +
		'DvGNrZW4gYXVmd2Vpc2VuIGthbm4uIEVpbgoJCQkJbMO8Y2tlbmxvc2VyIFNj' +
		'aHV0eiBkZXIgRGF0ZW4gdm9yIGRlbSBadWdyaWZmIGR1cmNoIERyaXR0ZSBpc' +
		'3QgbmljaHQgbcO2Z2xpY2guIDxicj4KCQkJCURlciBOdXR6dW5nIHZvbiBpbS' +
		'BSYWhtZW4gZGVyIEltcHJlc3N1bXNwZmxpY2h0IHZlcsO2ZmZlbnRsaWNodGV' +
		'uIEtvbnRha3RkYXRlbgoJCQkJZHVyY2ggRHJpdHRlIHp1ciDDnGJlcnNlbmR1' +
		'bmcgdm9uIG5pY2h0IGF1c2Ryw7xja2xpY2ggYW5nZWZvcmRlcnRlciBXZXJid' +
		'W5nIHVuZAoJCQkJSW5mb3JtYXRpb25zbWF0ZXJpYWxpZW4gd2lyZCBoaWVybW' +
		'l0IGF1c2Ryw7xja2xpY2ggd2lkZXJzcHJvY2hlbi4gRGllIEJldHJlaWJlcgo' +
		'JCQkJZGVyIFNlaXRlbiBiZWhhbHRlbiBzaWNoIGF1c2Ryw7xja2xpY2ggcmVj' +
		'aHRsaWNoZSBTY2hyaXR0ZSBpbSBGYWxsZSBkZXIgdW52ZXJsYW5ndGVuCgkJC' +
		'Vp1c2VuZHVuZyB2b24gV2VyYmVpbmZvcm1hdGlvbmVuLCBldHdhIGR1cmNoIF' +
		'NwYW0tTWFpbHMsIHZvci48YnI+CjwvcD48YnI+CkltcHJlc3N1bSB2b20gPGE' +
		'gaHJlZj0iaHR0cHM6Ly93d3cua2FuemxlaS1oYXNzZWxiYWNoLmRlL3N0YW5k' +
		'b3J0ZS9ib25uLyI+S2FuemxlaSBIYXNzZWxiYWNoLCBCb25uPC9hPgo8aHI+');
		data = decode_utf8(data);
		document.write(data);
		</script>
		</div>
		<div class="copyright">
			<p>&nbsp;</p>
			<p>
			KALLUP . NET  -  non-profit | (c) 2021</p>
		</div>
	</div>
<?php
	}
	else {
		echo '<script type="text/javascript">window.location = ' .
			'"/pub/desk/index0001.php?' .
			'?bw_username=' . $uhash   .
			'&bw_userpass=' . $phash   . '"></script></script>';
		die(); exit;
	}
?>
</body>
</html>