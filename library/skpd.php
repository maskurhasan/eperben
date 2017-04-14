<?php
include "../config/koneksi.php";

//mengambil data desa
$postur = $_POST[id_BidUrusan];
$sql1 = 'SELECT * FROM skpd WHERE id_BidUrusan = '.$postur.'';
$result1 = mysql_query($sql1);
	echo '<option value="0">Pilih SKPD</option>';
while($dt = mysql_fetch_array($result1)) {
    echo "<option value=$dt[id_Skpd]>$dt[nm_Skpd]</option>";
}

?>