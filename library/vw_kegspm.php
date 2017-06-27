<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_Spm'];

$sql= "SELECT b.*,d.nm_Kegiatan,c.Nilai,c.id_Rincspm,c.id_DataKegiatan AS jnsk FROM spm a,datakegiatan b,rincspm c,kegiatan d
                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                    AND a.id_Spm = c.id_Spm
                    AND c.id_DataKegiatan = b.id_DataKegiatan
                    AND b.id_Kegiatan = d.id_Kegiatan
                    AND a.id_Spm = '$postur'";
$q = mysql_query($sql);
$hit = mysql_num_rows($q);
function totalspm($id_Spm)
{
  $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                      WHERE c.id_Spm = '$id_Spm'");
  $r = mysql_fetch_array($sql);
  return $r[total];
}
function totalangg($id_Spm)
{
  $sql= mysql_query("SELECT SUM(b.AnggKeg) total FROM datakegiatan b,rincspm c
                      WHERE c.id_DataKegiatan = b.id_DataKegiatan
                      AND c.id_Spm = '$id_Spm'");
  $r = mysql_fetch_array($sql);
  return $r[total];
}

IF($hit < 1) {
  echo '<div class="alert alert-danger">
    <strong>Warning!</strong> Belum ada kegiatan pada SPM ini.
  </div>';
} ELSE {
echo '
<table class="table table-striped table-bordered table-responsive">
  <thead>
  <tr>
    <th></th><th>Kegiatan</th>
    <th>Anggaran</th><th>Nilai SPM</th>
  </tr>
  </thead>
  <tbody>';
$no = 1;
while($dt = mysql_fetch_array($q)) {
          echo "<tr>
                <td>".$no++."</td>
                <td>$dt[nm_Kegiatan]</td>
                <td>".angkrp($dt[AnggKeg])."</td>
                <td>".angkrp($dt[Nilai])."</td>
              </tr>";
}
echo '</tbody>';
echo '<tfoot>
        <tr>
          <td></td>
          <td align="right"><strong>Jumlah Total...</strong></td>
          <td>'.angkrp(totalangg($postur)).'</td>
          <td>'.angkrp(totalspm($postur)).'</td>
        </tr>
      </tfoot>';
echo '</table>';
}
?>
