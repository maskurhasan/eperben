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
  $qskpd = mysql_query("SELECT nm_Skpd FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
  $rskpd = mysql_fetch_array($qskpd);
  				echo "<div id=print>
  				<div align=center>
  				<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0>
  				<tr align=center><td>REGISTER SURAT PERINTAH MEMBAYAR (SPM)</td></tr>
  				<tr align=center><td>".strtoupper($rskpd[nm_Skpd])."</td></tr>
  				<tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr></table></div>

  	            <table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>
                  <thead>
                  <tr align=center>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nomor SPM</th>
                    <th>Uraian</th>
                    <th>Nilai SPM</th>
                  </tr>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nomor SPM</th>
                    <th>Uraian</th>
                    <th>Nilai SPM</th>
                  </tr>
                  </thead>
                  <tbody>";
                  echo "<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  </tbody>
                  </table>";

?>


</body>

<?php
}
?>
