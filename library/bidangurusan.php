<?php
include "../config/koneksi.php";

//mengambil data desa
$postur = $_POST[id_Urusan];
$sql1 = 'SELECT * FROM bidurusan WHERE id_Urusan = "'.$postur.'"';
$result1 = mysql_query($sql1);
	echo '<option value="0">Pilih Bid.Urusan</option>';
while($dt = mysql_fetch_array($result1)) {
	$id_BidUrusan1 = substr($dt[id_BidUrusan],-2);
    echo "<option value=$dt[id_BidUrusan]>$id_BidUrusan1 $dt[nm_BidUrusan]</option>";
}

?>