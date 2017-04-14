<?php
include "../config/koneksi.php";

//ambil value dri data kd_Urusan + kd_BidUrusan + kd_Program
$terima = $_POST[id_Program];


//$postur = $_POST[kd_Program];
$sql1 = 'SELECT * FROM kegiatan WHERE id_Program = "'.$terima.'"';
$result1 = mysql_query($sql1);
	echo '<option>Pilih Kegiatan</option>';
while($dt = mysql_fetch_array($result1)) {
	$id_Kegiatan = substr($dt[id_Kegiatan],-2);
	echo "<option value=$dt[id_Kegiatan]>$id_Kegiatan $dt[nm_Kegiatan]</option>";
}

?>