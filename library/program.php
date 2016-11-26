<?php
include "../config/koneksi.php";

//mengambil data desa
//ambil value dri data kd_Urusan + kd_BidUrusan
$terima = $_POST[id_BidUrusan];


//$postur1 = $_POST[kd_BidUrusan];
$sql1 = 'SELECT * FROM program WHERE id_BidUrusan = "'.$terima.'"';
$result1 = mysql_query($sql1);
	echo '<option>Pilih Program</option>';
while($dt = mysql_fetch_array($result1)) {
	$id_Program = substr($dt[id_Program],-2,2);
    echo "<option value=$dt[id_Program]>$id_Program  $dt[nm_Program]</option>";
}

?>