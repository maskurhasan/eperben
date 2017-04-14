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

            echo '<div class="card">
                <div class="content table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                      <th></th><th>Nama SKPD</th><th>APBD</th><th>DAK</th><th>APBN</th>
                    <th></th></tr>
                    </thead>
                    <tbody>';

                  $no=1;
                  while($dt = mysql_fetch_array($result1)) {
                      echo "<tr>
                              <td>".$no++."</td>
                              <td>$dt[nm_Skpd]</td>
                              <td>".number_format($dt[apbd])."</td>
                              <td>".number_format($dt[dak])."</td>
                              <td>".number_format($dt[apbn])."</td>
                              <td class=align-center><a href='?module=skpd&act=edit&id=$dt[id_Skpd]'><i class='fa fa-edit fa-lg'></i> Edit</a>
                                  </td>
                              </tr>";
                    }
                  echo '<tbody></table>
              </div>
            </div>';

/*

echo "<div class=module>
        <h2><span>Data SKPD</span></h2>
        <table width='700px' cellspacing=0 cellpadding=0>
		<tr><td><input type=text size='20'><button type='submit' value=''><i class='fa fa-search'></i> C a r i</button></td>
		<td></td><td align='right'></td></tr>
		</table>
        <table class=tabel width=700px>
        <thead><tr><th>#</th>
        <th>Kode</th><th>Nama SKPD</th><th>APBD</th><th>DAK</th><th>APBN</th>
        <th>Aksi</th></tr></thead><tbody>";
	$no=1;
while($dt = mysql_fetch_array($result1)) {
	$no % 2 === 0 ? $alt="alt" : $alt="";
	echo "<tr class=$alt><td>".$no++."</td>
          <td>$dt[id_Skpd]</td>
          <td>$dt[nm_Skpd]</td>
          <td>".number_format($dt[apbd])."</td>
          <td>".number_format($dt[dak])."</td>
          <td>".number_format($dt[apbn])."</td>
          <td class=align-center><a href='?module=skpd&act=edit&id=$dt[id_Skpd]'><i class='fa fa-edit fa-lg'></i> Edit</a>
          		<a href='#'><i class='fa fa-trash-o fa-lg'></i> Hapus</a></td>
          </tr>";
}
echo "</tbody></table></form></div></div>";
*/
?>
