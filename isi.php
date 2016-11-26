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
		}
    /*
    if ($_GET['module']=='home'){
		    include "modul/home.php";
		} elseif ($_GET['module']=='program') {
			include "modul/modprogram.php";
		} elseif ($_GET['module']=='kegiatan') {
			include "modul/modkegiatan.php";
		} elseif ($_GET['module']=='skpd') {
			include "modul/modskpd.php";
		}elseif ($_GET['module']=='user') {
			include "modul/moduser.php";
		}elseif ($_GET['module']=='modul') {
			include "modul/modmodul.php";
		}elseif ($_GET['module']=='aksesmodul') {
			include "modul/modaksesmodul.php";
		}elseif ($_GET['module']=='tahunanggaran') {
			include "modul/modtahunanggaran.php";
		}elseif ($_GET['module']=='datappk') {
			include "modul/moddatappk.php";
		}elseif ($_GET['module']=='datakegiatan') {
			include "modul/moddatakegiatan.php";
		}elseif ($_GET['module']=='subkegiatan') {
			include "modul/modsubkegiatan.php";
		}elseif ($_GET['module']=='realisasi') {
			include "modul/modrealisasi.php";
		}elseif ($_GET['module']=='statusfinal') {
			include "modul/modstatusfinal.php";
		}elseif ($_GET['module']=='datadak') {
			include "modul/moddatadak.php";
		} elseif ($_GET['module']=='realisasidak') {
			include "modul/modrealisasidak.php";
		} elseif ($_GET['module']=='dataapbn') {
			include "modul/moddataapbn.php";
		} elseif ($_GET['module']=='realisasiapbn') {
			include "modul/modrealisasiapbn.php";
		} elseif ($_GET['module']=='laporanrfk') {
			include "modul/modlaporanrfk.php";
		} elseif ($_GET['module']=='kegiatanfk') {
			include "modul/fk_moddatakegiatan.php";
		} elseif ($_GET['module']=='posting') {
			include "modul/modposting.php";
		} elseif ($_GET['module']=='realisasifk') {
			include "modul/fk_modrealisasi.php";
		} elseif ($_GET['module']=='report') {
			include "modul/modreport.php";
			//include "modul/modlaporan.php";
		} elseif ($_GET['module']=='realisasi2') {
			include "modul/modrealisasi2.php";
		} elseif ($_GET['module']=='autosubkeg') {
			include "modul/modautosubkeg.php";
		} elseif ($_GET['module']=='sumberdana') {
			include "modul/modsumberdana.php";
		}elseif ($_GET['module']=='setting') {
			include "modul/modsetting.php";
		}elseif ($_GET['module']=='master') {
			include "modul/modmaster.php";
		}elseif ($_GET['module']=='profkeg') {
			include "modul/modprofkeg.php";
		}else {
			echo "Modul tidak ditemukan";
		}
    */
	}

} //end tanpa akses


?>
