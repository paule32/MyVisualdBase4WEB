<?php
// -----------------------------------------------
// web-pages must be always start by session !
// -----------------------------------------------
session_start();

$_SESSION['doc_intern'] = "\\..\\..\\..\\intern\\4430\\";
require_once( __DIR__ . $_SESSION['doc_intern'] . "tools\\php\\head.php" );
?>
<body>
<?php /*base64_a_img_link("https://www.google.de","pub/favicon.png");*/ ?>
<?php
	$office = $_SERVER['HTTP_OFFICE_HEADER'];
	$status = 0;
	//var_dump($_SESSION['dir_array']);
	if (strcmp($office,"0") == 0)
	$status = 0; else
	$status = 1;
?>
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
			<img <?php base64_src_png('pub/images/logo3.png');?> alt="logo"></img>
		</div>
		<div class="balken">
			<center>
				"Bildung für Alle", ist Unsere Mission.<br>
				Jeder Erfolg, bringt auch ein wenig Hoffnung...
			</center>
		</div>
		<?php
		if ($status == 0) {
		$text = <<<SEnde
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
SEnde;
		echo $text; 
		}
		?>
		<hr>
		<table>
			<tr>
				<td width="200" align="top">
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
				<td>
					<form method="post" action="/edu/index/index.php">
						<table>
							<tr>
								<td colspan="2">Geben Sie Bitte Ihre Zugangsdaten ein:</td>
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
			<tr>
				<td colspan="3">
				<div class='impressum'>
				<p><br><p><br></p></p>
				<script>
					var data = window.atob(
					'PHN0cm9uZz5IYWZ0dW5nc2F1c3NjaGx1c3M6PC9zdHJvbmc+PGJyPjxicj4KPHN0' +
					'cm9uZz5IYWZ0dW5nIGbDvHIgSW5oYWx0ZTwvc3Ryb25nPjxicj48YnI+CkRpZSBJ' +
					'bmhhbHRlIHVuc2VyZXIgU2VpdGVuIHd1cmRlbiBtaXQgZ3LDtsOfdGVyIFNvcmdm' +
					'YWx0IGVyc3RlbGx0LgpGw7xyIGRpZSBSaWNodGlna2VpdCwgVm9sbHN0w6RuZGln' +
					'a2VpdCB1bmQgQWt0dWFsaXTDpHQgZGVyIEluaGFsdGUKa8O2bm5lbiB3aXIgamVk' +
					'b2NoIGtlaW5lIEdld8OkaHIgw7xiZXJuZWhtZW4uCkFscyBEaWVuc3RlYW5iaWV0' +
					'ZXIgc2luZCB3aXIgZ2Vtw6TDnyDCpyA3IEFicy4xIFRNRyBmw7xyIGVpZ2VuZSBJ' +
					'bmhhbHRlCmF1ZiBkaWVzZW4gU2VpdGVuIG5hY2ggZGVuIGFsbGdlbWVpbmVuIEdl' +
					'c2V0emVuIHZlcmFudHdvcnRsaWNoLgpOYWNoIMKnwqcgOCBiaXMgMTAgVE1HIHNp' +
					'bmQgd2lyIGFscyBEaWVuc3RlYW5iaWV0ZXIgamVkb2NoIG5pY2h0CnZlcnBmbGlj' +
					'aHRldCwgw7xiZXJtaXR0ZWx0ZSBvZGVyIGdlc3BlaWNoZXJ0ZSBmcmVtZGUgSW5m' +
					'b3JtYXRpb25lbgp6dSDDvGJlcndhY2hlbiBvZGVyIG5hY2ggVW1zdMOkbmRlbiB6' +
					'dSBmb3JzY2hlbiwgZGllIGF1ZiBlaW5lIHJlY2h0c3dpZHJpZ2UKVMOkdGlna2Vp' +
					'dCBoaW53ZWlzZW4uIFZlcnBmbGljaHR1bmdlbiB6dXIgRW50ZmVybnVuZyBvZGVy' +
					'IFNwZXJydW5nIGRlciBOdXR6dW5nCnZvbiBJbmZvcm1hdGlvbmVuIG5hY2ggZGVu' +
					'IGFsbGdlbWVpbmVuIEdlc2V0emVuIGJsZWliZW4gaGllcnZvbiB1bmJlcsO8aHJ0' +
					'LgpFaW5lIGRpZXNiZXrDvGdsaWNoZSBIYWZ0dW5nIGlzdCBqZWRvY2ggZXJzdCBh' +
					'YiBkZW0gWmVpdHB1bmt0IGRlciBLZW5udG5pcwplaW5lciBrb25rcmV0ZW4gUmVj' +
					'aHRzdmVybGV0enVuZyBtw7ZnbGljaC4gQmVpIEJla2FubnR3ZXJkZW4gdm9uIGVu' +
					'dHNwcmVjaGVuZGVuClJlY2h0c3ZlcmxldHp1bmdlbiB3ZXJkZW4gd2lyIGRpZXNl' +
					'IEluaGFsdGUgdW1nZWhlbmQgZW50ZmVybmVuLjxicj48YnI+CjxzdHJvbmc+SGFm' +
					'dHVuZyBmw7xyIExpbmtzPC9zdHJvbmc+PGJyPjxicj4KVW5zZXIgQW5nZWJvdCBl' +
					'bnRow6RsdCBMaW5rcyB6dSBleHRlcm5lbiBXZWJzZWl0ZW4gRHJpdHRlciwgYXVm' +
					'IGRlcmVuIEluaGFsdGUgd2lyCmtlaW5lbiBFaW5mbHVzcyBoYWJlbi4gRGVzaGFs' +
					'YiBrw7ZubmVuIHdpciBmw7xyIGRpZXNlIGZyZW1kZW4gSW5oYWx0ZSBhdWNoIGtl' +
					'aW5lCkdld8OkaHIgw7xiZXJuZWhtZW4uIEbDvHIgZGllIEluaGFsdGUgZGVyIHZl' +
					'cmxpbmt0ZW4gU2VpdGVuIGlzdCBzdGV0cyBkZXIgamV3ZWlsaWdlCkFuYmlldGVy' +
					'IG9kZXIgQmV0cmVpYmVyIGRlciBTZWl0ZW4gdmVyYW50d29ydGxpY2guIERpZSB2' +
					'ZXJsaW5rdGVuIFNlaXRlbiB3dXJkZW4KenVtIFplaXRwdW5rdCBkZXIgVmVybGlu' +
					'a3VuZyBhdWYgbcO2Z2xpY2hlIFJlY2h0c3ZlcnN0w7bDn2Ugw7xiZXJwcsO8ZnQu' +
					'IFJlY2h0c3dpZHJpZ2UKSW5oYWx0ZSB3YXJlbiB6dW0gWmVpdHB1bmt0IGRlciBW' +
					'ZXJsaW5rdW5nIG5pY2h0IGVya2VubmJhci4gRWluZSBwZXJtYW5lbnRlCmluaGFs' +
					'dGxpY2hlIEtvbnRyb2xsZSBkZXIgdmVybGlua3RlbiBTZWl0ZW4gaXN0IGplZG9j' +
					'aCBvaG5lIGtvbmtyZXRlIEFuaGFsdHNwdW5rdGUKZWluZXIgUmVjaHRzdmVybGV0' +
					'enVuZyBuaWNodCB6dW11dGJhci4gQmVpIEJla2FubnR3ZXJkZW4gdm9uIFJlY2h0' +
					'c3ZlcmxldHp1bmdlbgp3ZXJkZW4gd2lyIGRlcmFydGlnZSBMaW5rcyB1bWdlaGVu' +
					'ZCBlbnRmZXJuZW4uPGJyPjxicj4KPHN0cm9uZz5VcmhlYmVycmVjaHQ8L3N0cm9u' +
					'Zz48YnI+PGJyPgpEaWUgZHVyY2ggZGllIFNlaXRlbmJldHJlaWJlciBlcnN0ZWxs' +
					'dGVuIEluaGFsdGUgdW5kIFdlcmtlIGF1ZiBkaWVzZW4gU2VpdGVuCnVudGVybGll' +
					'Z2VuIGRlbSBkZXV0c2NoZW4gVXJoZWJlcnJlY2h0LiBEaWUgVmVydmllbGbDpGx0' +
					'aWd1bmcsIEJlYXJiZWl0dW5nLApWZXJicmVpdHVuZyB1bmQgamVkZSBBcnQgZGVy' +
					'IFZlcndlcnR1bmcgYXXDn2VyaGFsYiBkZXIgR3JlbnplbiBkZXMgVXJoZWJlcnJl' +
					'Y2h0ZXMKYmVkw7xyZmVuIGRlciBzY2hyaWZ0bGljaGVuIFp1c3RpbW11bmcgZGVz' +
					'IGpld2VpbGlnZW4gQXV0b3JzIGJ6dy4gRXJzdGVsbGVycy4KRG93bmxvYWRzIHVu' +
					'ZCBLb3BpZW4gZGllc2VyIFNlaXRlIHNpbmQgbnVyIGbDvHIgZGVuIHByaXZhdGVu' +
					'LCBuaWNodCBrb21tZXJ6aWVsbGVuCkdlYnJhdWNoIGdlc3RhdHRldC4gU293ZWl0' +
					'IGRpZSBJbmhhbHRlIGF1ZiBkaWVzZXIgU2VpdGUgbmljaHQgdm9tIEJldHJlaWJl' +
					'cgplcnN0ZWxsdCB3dXJkZW4sIHdlcmRlbiBkaWUgVXJoZWJlcnJlY2h0ZSBEcml0' +
					'dGVyIGJlYWNodGV0LiBJbnNiZXNvbmRlcmUgd2VyZGVuCkluaGFsdGUgRHJpdHRl' +
					'ciBhbHMgc29sY2hlIGdla2VubnplaWNobmV0LiBTb2xsdGVuIFNpZSB0cm90emRl' +
					'bSBhdWYgZWluZQpVcmhlYmVycmVjaHRzdmVybGV0enVuZyBhdWZtZXJrc2FtIHdl' +
					'cmRlbiwgYml0dGVuIHdpciB1bSBlaW5lbiBlbnRzcHJlY2hlbmRlbgpIaW53ZWlz' +
					'LiBCZWkgQmVrYW5udHdlcmRlbiB2b24gUmVjaHRzdmVybGV0enVuZ2VuIHdlcmRl' +
					'biB3aXIgZGVyYXJ0aWdlIEluaGFsdGUKdW1nZWhlbmQgZW50ZmVybmVuLjxicj48' +
					'YnI+CjxzdHJvbmc+RGF0ZW5zY2h1dHo8L3N0cm9uZz48YnI+PGJyPgpEaWUgTnV0' +
					'enVuZyB1bnNlcmVyIFdlYnNlaXRlIGlzdCBpbiBkZXIgUmVnZWwgb2huZSBBbmdh' +
					'YmUgcGVyc29uZW5iZXpvZ2VuZXIKRGF0ZW4gbcO2Z2xpY2guIFNvd2VpdCBhdWYg' +
					'dW5zZXJlbiBTZWl0ZW4gcGVyc29uZW5iZXpvZ2VuZSBEYXRlbiAoYmVpc3BpZWxz' +
					'd2Vpc2UKTmFtZSwgQW5zY2hyaWZ0IG9kZXIgZU1haWwtQWRyZXNzZW4pIGVyaG9i' +
					'ZW4gd2VyZGVuLCBlcmZvbGd0IGRpZXMsIHNvd2VpdAptw7ZnbGljaCwgc3RldHMg' +
					'YXVmIGZyZWl3aWxsaWdlciBCYXNpcy4gRGllc2UgRGF0ZW4gd2VyZGVuIG9obmUg' +
					'SWhyZSBhdXNkcsO8Y2tsaWNoZQpadXN0aW1tdW5nIG5pY2h0IGFuIERyaXR0ZSB3' +
					'ZWl0ZXJnZWdlYmVuLiA8YnI+CldpciB3ZWlzZW4gZGFyYXVmIGhpbiwgZGFzcyBk' +
					'aWUgRGF0ZW7DvGJlcnRyYWd1bmcgaW0gSW50ZXJuZXQKKHouQi4gYmVpIGRlciBL' +
					'b21tdW5pa2F0aW9uIHBlciBFLU1haWwpIFNpY2hlcmhlaXRzbMO8Y2tlbiBhdWZ3' +
					'ZWlzZW4ga2Fubi4gRWluCmzDvGNrZW5sb3NlciBTY2h1dHogZGVyIERhdGVuIHZv' +
					'ciBkZW0gWnVncmlmZiBkdXJjaCBEcml0dGUgaXN0IG5pY2h0IG3DtmdsaWNoLiA8' +
					'YnI+CkRlciBOdXR6dW5nIHZvbiBpbSBSYWhtZW4gZGVyIEltcHJlc3N1bXNwZmxp' +
					'Y2h0IHZlcsO2ZmZlbnRsaWNodGVuIEtvbnRha3RkYXRlbgpkdXJjaCBEcml0dGUg' +
					'enVyIMOcYmVyc2VuZHVuZyB2b24gbmljaHQgYXVzZHLDvGNrbGljaCBhbmdlZm9y' +
					'ZGVydGVyIFdlcmJ1bmcgdW5kCkluZm9ybWF0aW9uc21hdGVyaWFsaWVuIHdpcmQg' +
					'aGllcm1pdCBhdXNkcsO8Y2tsaWNoIHdpZGVyc3Byb2NoZW4uIERpZSBCZXRyZWli' +
					'ZXIKZGVyIFNlaXRlbiBiZWhhbHRlbiBzaWNoIGF1c2Ryw7xja2xpY2ggcmVjaHRs' +
					'aWNoZSBTY2hyaXR0ZSBpbSBGYWxsZSBkZXIgdW52ZXJsYW5ndGVuClp1c2VuZHVu' +
					'ZyB2b24gV2VyYmVpbmZvcm1hdGlvbmVuLCBldHdhIGR1cmNoIFNwYW0tTWFpbHMs' +
					'IHZvci48YnI+CjwvcD48YnI+CkltcHJlc3N1bSB2b20gPGEgaHJlZj0iaHR0cHM6' +
					'Ly93d3cua2FuemxlaS1oYXNzZWxiYWNoLmRlL3N0YW5kb3J0ZS9ib25uLyI+S2Fu' +
					'emxlaSBIYXNzZWxiYWNoLCBCb25uPC9hPg==');
					data = decode_utf8(data);
					document.write(data);
				</script>
				</div>
				</td>
			</tr>
		</table>
		<hr>		
		<div class="copyright">
			<p>&nbsp;</p>
			<p>
			KALLUP . NET  -  non-profit | (c) 2021</p>
		</div>
	</div>
</body>
</html>
<?php
// at end of session:
//session_destroy();
?>
