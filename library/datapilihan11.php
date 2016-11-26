<?php
include "koneksi.php";

 //cek jika nm_RincKeg sama 
	//$cek = mysql_query("SELECT tbl_rinckeg.nm_RincKeg FROM tbl_rinckeg WHERE id_KegSkpd = $id_KegSkpd");
	$row1 = "satu dua Tiga ";    //mysql_fetch_array($cek);
	$row2 = "satu dua tiga";
	//cek string input
	$pjg = strlen($row1);
	$ckstr = strncasecmp($row1,$row2,$pjg);
	
	echo $ckstr;

?>