<?php 
include "../config/koneksi.php";
include "../config/errormode.php";

//mengambil data desa
//ambil value dri data kd_Urusan + kd_BidUrusan
$terima = $_POST[id_BidUrusan];
$ambil = $_GET[module];

//$postur1 = $_POST[kd_BidUrusan];
$sql1 = 'SELECT * FROM skpd WHERE id_BidUrusan = '.$terima.'';
$no=1;
$result1 = mysql_query($sql1);
echo "<table class=table>
        <thead><tr><th>#</th>
        <th>Kode</th><th>Nama SKPD</th>
        <th>Aksi</th></tr></thead><tbody>";
$no=1;
while($dt = mysql_fetch_array($result1)) {
  $no % 2 === 0 ? $alt="alt" : $alt="";
	echo "<tr class=$alt><td>".$no++."</td>
          <td>$dt[id_Skpd]</td>
          <td>$dt[nm_Skpd]</td>
          <td class=align-center><a href='?module=statusfinal&act=add&id=$dt[id_Skpd]'><i class='fa fa-refresh fa-lg'></i> Status</a>
          		</td>
          </tr>";
} 
echo "</tbody></table></form>";

?>