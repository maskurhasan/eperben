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
  $qskpd = mysql_query("SELECT nm_Skpd FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
  $rskpd = mysql_fetch_array($qskpd);
  				echo "<div id=print>
  				<div align=center>
  				<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0>
  				<tr align=center><td>LAPORAN REALISASI POTONGAN SPM</td></tr>
  				<tr align=center><td>".strtoupper($rskpd[nm_Skpd])."</td></tr>
  				<tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr></table></div>";
            echo "<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>
                <thead>
                <tr align=center>
                  <th rowspan=2>No</th>
                  <th rowspan=2>Nomor SPM</th>
                  <th rowspan=2>Tgl. SPM</th>
                  <th rowspan=2>Jenis</th>
                  <th rowspan=2>Uraian</th>
                  <th rowspan=2>Nilai SPM</th>
                  <th colspan=7>Potongan</th>
                </tr>
                <tr>
                  <th>PPn 10%</th>
                  <th>PPh 21</th>
                  <th>PPh 22</th>
                  <th>PPh Gaji</th>
                  <th>IWP</th>
                  <th>Taperum</th>
                  <th>Askes</th>
                </tr>
                </thead>
                <tbody>";
                function hitpotongan($JnsPotongan,$id_Spm) {
                  $q = mysql_query("SELECT SUM(NilaiPotongan) AS jmlpotongan
                                    FROM potonganspm
                                    WHERE id_Spm = '$id_Spm'
                                    AND JnsPotongan = '$JnsPotongan'");
                  $r = mysql_fetch_array($q);
                  $r[jmlpotongan] <= 0 ? $t = "-" : $t = $r[jmlpotongan];
                  return $t;
                }
                function totalpot($JnsPotongan) {
                  $q = mysql_query("SELECT SUM(a.NilaiPotongan) AS jmlpotongan
                                    FROM potonganspm a,spm b
                                    WHERE a.JnsPotongan = '$JnsPotongan'
                                    AND a.id_Spm = b.id_Spm
                                    AND b.id_Skpd = '$_SESSION[id_Skpd]'
                                    AND b.TahunAngg = '$_SESSION[thn_Login]'");
                  $r = mysql_fetch_array($q);
                  $r[jmlpotongan] <= 0 ? $t = "-" : $t = $r[jmlpotongan];
                  return $t;
                }
                $sql= mysql_query("SELECT a.*,b.Tanggal,b.Nomor,b.Keterangan,b.Anggaran,b.Jenis,b.id_Spm as idspm
                                    FROM verifikasi a, spm b
                                    WHERE b.id_Skpd = '$_SESSION[id_Skpd]'
                                    GROUP BY b.id_Spm");
                $no = 1;
                $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                $jnspotongan = array(1 => 'PPN 10%',2=>'PPH 21',3=>'PPH 22',4=>'PPH Gaji',5=>'IWP',6=>'TAPERUM',7=>'ASKES' );

                while($r = mysql_fetch_array($sql)) {
                  echo "<tr>
                    <td>".$no++."</td>
                    <td>".$r[Nomor]."</td>
                    <td>".tgl_indo($r[Tanggal])."</td>
                    <td>".$jns_spm[$r[Jenis]]."</td>
                    <td>$r[Keterangan]</td>
                    <td>".angkrp($r[Anggaran])."</td>
                    <td>".angkrp(hitpotongan(1,$r[idspm]))."</td>
                    <td>".angkrp(hitpotongan(2,$r[idspm]))."</td>
                    <td>".angkrp(hitpotongan(3,$r[idspm]))."</td>
                    <td>".angkrp(hitpotongan(4,$r[idspm]))."</td>
                    <td>".angkrp(hitpotongan(5,$r[idspm]))."</td>
                    <td>".angkrp(hitpotongan(6,$r[idspm]))."</td>
                    <td>".angkrp(hitpotongan(7,$r[idspm]))."</td>
                  </tr>";
                }
                echo "</tbody>
                <tfoot>
                <tr>
                  <td></td>
                  <td colspan='4'>JUMLAH...</td>
                  <td></td>
                  <td>".angkrp(totalpot(1))."</td>
                  <td>".angkrp(totalpot(2))."</td>
                  <td>".angkrp(totalpot(3))."</td>
                  <td>".angkrp(totalpot(4))."</td>
                  <td>".angkrp(totalpot(5))."</td>
                  <td>".angkrp(totalpot(6))."</td>
                  <td>".angkrp(totalpot(7))."</td>
                </tr>
                </tfoot>
              </table>";

?>


</body>

<?php
}
?>
