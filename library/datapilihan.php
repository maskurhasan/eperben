<?php
include "koneksi.php";

//mengambil data desa
$postkec = $_POST[id_Kecamatan];
$sql1 = 'SELECT * FROM tbl_desa WHERE id_Kecamatan = "'.$postkec.'"';
$result1 = mysql_query($sql1);
while($dt = mysql_fetch_array($result1)) {
    echo '<option value="'.$dt[id_Desa].'">'.$dt[nm_Desa].'</option>';
}

?>