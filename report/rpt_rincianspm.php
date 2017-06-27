<?php
session_start();
if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
  include "../config/koneksi.php";
  include "../config/fungsi.php";
  include "../assets/css/printer.css";

  //filter
  if(empty($_GET[StatusSpm])) {
    $filt1 = "";
  } else {
    $filt1 = "AND StatusSpm = '$_GET[StatusSpm]'";
  }
?>
<html>
<head>
<style type="text/css">
.style4 {font-size: 10; }
.style7 {	font-size: 10;
	color: #265180;
	font-family: Georgia, "Times New Roman", Times, serif;
}
</style>
<script language="javascript" type="text/javascript">
window.print();
</script>
<title>Laporan</title>
</head>
<body>
  <?php
  $qskpd = mysql_query("SELECT a.nm_Skpd,b.Nomor
                        FROM skpd a,spm b
                        WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                        AND a.id_Skpd = b.id_Skpd");
  $rskpd = mysql_fetch_array($qskpd);
  				echo "<div id=print>
  				<div align=center>
  				<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0>
  				<tr align=center><td>LAPORAN RINCIAN SPM</td></tr>
  				<tr align=center><td>".strtoupper($rskpd[nm_Skpd])."</td></tr>
  				<tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr>
          <tr align=center><td>Nomor SPM : $rskpd[Nomor]</td></tr></table></div>";
              echo "<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>
                  <thead>
                  <tr align=center>
                    <th>No</th>
                    <th>Program / Kegiatan</th>
                    <th>Anggaran</th>
                    <th>Nilai SPM</th>
                    <th>Keterangan</th>
                  </tr>
                  </thead>
                  <tbody>";
                  $sql= mysql_query("SELECT c.nm_Kegiatan,b.AnggKeg,a.Nilai FROM rincspm a,datakegiatan b, kegiatan c
                                      WHERE a.id_DataKegiatan = b.id_DataKegiatan
                                      AND b.id_Kegiatan = c.id_Kegiatan
                                      AND a.id_Spm = '$_GET[id]'");
                  $no = 1;
                  while($r = mysql_fetch_array($sql)) {
                    echo "<tr>
                      <td>".$no++."</td>
                      <td>$r[nm_Kegiatan]</td>
                      <td>".angkrp($r[AnggKeg])."</td>
                      <td>".angkrp($r[Nilai])."</td>
                      <td></td>
                    </tr>";
                  }
                  echo "</tbody>
                </table>";


?>


</body>

<?php
}
?>
