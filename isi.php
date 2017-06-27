<?php
//session_start();
if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=login.html><b>LOGIN</b></a></center>";
} else {
include "config/koneksi.php";

	if($_SESSION['UserLevel'] == "1" OR $_SESSION[UserLevel] == '2' OR $_SESSION[UserLevel] == '3' OR $_SESSION[UserLevel] == '4' OR $_SESSION[UserLevel] == '5') {

    if ($_GET['module']=='home'){
		    include "modul/home.php";
		} elseif ($_GET['module']=='user') {
			include "modul/moduser.php";
		} elseif ($_GET['module']=='skpd') {
			include "modul/modskpd.php";
		} elseif ($_GET['module']=='spm') {
			include "modul/modspm.php";
		} elseif ($_GET['module']=='datakegiatan') {
			include "modul/moddatakegiatan.php";
		} elseif ($_GET['module']=='modul') {
			include "modul/modmodul.php";
		} elseif ($_GET['module']=='ttdbukti') {
			include "modul/modttdbukti.php";
		} elseif ($_GET['module']=='verifikasi') {
			include "modul/modverifikasi.php";
		} elseif ($_GET['module']=='pengesahanbud') {
			include "modul/modpengesahanbud.php";
		} elseif ($_GET['module']=='sp2d') {
			include "modul/modsp2d.php";
		} elseif ($_GET['module']=='laporanskpd') {
			include "modul/modreportskpd.php";
		} elseif ($_GET['module']=='cklist') {
			include "modul/modcklist.php";
		} elseif ($_GET['module']=='aksesskpd') {
			include "modul/modaksesskpd.php";
		} elseif ($_GET['module']=='datausaha') {
			include "modul/moddatausaha.php";
		} elseif ($_GET['module']=='berkas') {
			include "modul/modberkas.php";
		}
	}

} //end tanpa akses


?>
