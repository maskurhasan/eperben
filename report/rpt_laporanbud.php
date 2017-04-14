<?php
session_start();
if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
  include "../config/koneksi.php";
  include "../config/fungsi.php";
  include "../config/fungsi_indotgl.php";
  include "../assets/css/printer.css";

  //filter
  if(empty($_GET[id])) {
    $filt1 = "";
  } else {
    $filt1 = "AND a.id_User = '$_GET[id]'";
  }
  if(empty($_GET[skpd])) {
    $filt2 = "";
  } else {
    $filt2 = "AND b.id_Skpd = '$_GET[skpd]'";
  }
  if(empty($_GET[Jenis])) {
    $filt3 = "";
  } else {
    $filt3 = "AND b.id_Jenis = '$_GET[Jenis]'";
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
  $qskpd = mysql_query("SELECT a.nm_Skpd
                        FROM skpd a
                        WHERE a.id_Skpd = '$_GET[skpd]'");
  $rskpd = mysql_fetch_array($qskpd);
  				echo "<div id=print>
  				<div align=center>
  				<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0>
  				<tr align=center><td>LAPORAN PENGESAHAN SP2D</td></tr>
  				<tr align=center><td></td></tr>
  				<tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr></table></div>";
              echo "<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>
                  <thead>
                  <tr align=center>
                    <th>No</th>
                    <th>Nomor SPM</th>
                    <th>Tgl SPM</th>
                    <th>Jenis SPM</th>
                    <th>Uraian</th>
                    <th>Verifikator</th>
                    <th>Tgl Verifikasi</th>
                    <th>Nomor SP2D</th>
                    <th>Tgl SP2D</th>
                    <th>SKPD</th>
                  </tr>
                  </thead>
                  <tbody>";
                  if($_SESSION[UserLevel]==1) {
                    $sql= mysql_query("SELECT a.*,b.Keterangan,b.Anggaran,b.Jenis,b.id_Spm as idspm,b.Nomor,b.Tanggal,c.nm_Lengkap
                                      FROM verifikasi a, spm b,user c
                                      WHERE a.id_Spm = b.id_Spm
                                      AND c.id_User = a.id_User
                                      GROUP BY b.id_Spm");
                  } else {
                    $sql= mysql_query("SELECT a.*,b.Keterangan,b.Anggaran,b.Jenis,b.id_Spm as idspm,
                                              b.Nomor,b.Tanggal,c.nm_Lengkap,d.nm_Skpd
                                      FROM verifikasi a, spm b,user c,skpd d
                                      WHERE a.id_Spm = b.id_Spm
                                      AND c.id_User = a.id_User
                                      AND b.id_Skpd = d.id_Skpd
                                      $filt1 $filt2 $filt3
                                      GROUP BY b.id_Spm");
                  }
                  $no = 1;
                  $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                  while($r = mysql_fetch_array($sql)) {
                    echo "<tr>
                      <td>".$no++."</td>
                      <td>$r[Nomor]</td>
                      <td>".$r[Tanggal]."</td>
                      <td>".$jns_spm[$r[Jenis]]."</td>
                      <td>$r[Keterangan]</td>
                      <td>$r[nm_Lengkap]</td>
                      <td>$r[tgl_Ver]</td>
                      <td>$r[NomorSp2d]</td>
                      <td>$r[tgl_Sp2d]</td>
                      <td>$r[nm_Skpd]</td>
                    </tr>";
                  }
                  echo "</tbody>
                </table>";
?>


</body>

<?php
}
?>
