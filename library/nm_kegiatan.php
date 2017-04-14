<?php
include "../config/koneksi.php";
include "../config/errormode.php";

//mengambil data desa
$postur = $_POST[id_Kegiatan];
$sql1 = 'SELECT * FROM kegiatan WHERE id_Kegiatan = "'.$postur.'"';
$result1 = mysql_query($sql1);
$row = mysql_fetch_array($result1);
	echo $row[nm_Kegiatan];
?>