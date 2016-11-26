<?php
session_start();
include "../config/koneksi.php";

//ambil value dri data kd_Urusan + kd_BidUrusan + kd_Program
$terima = $_POST[id_Program];

/*
$qq = mysql_query("SELECT b.nm_Kegiatan FROM datakegiatan a, kegiatan b
														WHERE a.id_Kegiatan = b.id_Kegiatan
														AND a.TahunAnggaran = '$_SESSION[thn_Login]'
														AND a.id_Skpd = '$_SESSION[id_Skpd]'");
while ($rq = mysql_fetch_array($qq)) {
	echo '<option value="">'.$rq[nm_Kegiatan].'</option>';
}
*/
//$postur = $_POST[kd_Program];
$sql1 = "SELECT b.nm_Kegiatan,b.id_Kegiatan,a.id_DataKegiatan FROM datakegiatan a, kegiatan b
														WHERE a.id_Kegiatan = b.id_Kegiatan
														AND a.TahunAnggaran = '$_SESSION[thn_Login]'
														AND a.id_Skpd = '$_SESSION[id_Skpd]'
														AND b.id_Program = '$terima'";
$result1 = mysql_query($sql1);
	echo '<option>Pilih Kegiatan </option>';
while($dt = mysql_fetch_array($result1)) {
	$id_Kegiatan = substr($dt[id_Kegiatan],-2);
	echo "<option value=$dt[id_DataKegiatan]>$id_Kegiatan $dt[nm_Kegiatan]</option>";
}

/*

//$postur = $_POST[kd_Program];
$sql1 = 'SELECT * FROM kegiatan WHERE id_Program = "'.$terima.'"';
$result1 = mysql_query($sql1);
	echo '<option>Pilih Kegiatan</option>';
while($dt = mysql_fetch_array($result1)) {
	$id_Kegiatan = substr($dt[id_Kegiatan],-2);
	echo "<option value=$dt[id_Kegiatan]>$id_Kegiatan $dt[nm_Kegiatan]</option>";
}
*/
?>
