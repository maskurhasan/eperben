<?php
session_start();
if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {

//----------------------------------
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/fungsi_indotgl.php";
include "../assets/css/printer.css";
include "../config/errormode.php";
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
function rlsbulan($id_Bulan,$id_DataKegiatan){
    $q = mysql_query("SELECT SUM(a.rls_Keu2) keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND b.id_DataKegiatan = '$id_DataKegiatan' 
                        AND a.id_Bulan = '$id_Bulan'");
    $r = mysql_fetch_array($q);
    $bln_lalu = $id_Bulan - 1;
    return $r['keu'];
}
function rlsbulanlalu($id_Bulan,$id_DataKegiatan){
    $bln_lalu = $id_Bulan - 1;
    $q = mysql_query("SELECT SUM(a.rls_Keu2) keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND b.id_DataKegiatan = '$id_DataKegiatan' 
                        AND a.id_Bulan = '$bln_lalu'");
    $r = mysql_fetch_array($q);
    return $r['keu'];
}
function maxbulan($id_DataKegiatan){
    $q = mysql_query("SELECT MAX(a.id_Bulan) AS bulan
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND b.id_DataKegiatan = '$id_DataKegiatan'");
    $r = mysql_fetch_array($q);
    //$bln_lalu = $id_Bulan - 1;
    return $r['bulan'];
}
function totalkeg($id_Bulan,$id_DataKegiatan){
    $q = mysql_query("SELECT SUM(a.rls_Keu2) AS keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND b.id_DataKegiatan = '$id_DataKegiatan' 
                        AND a.id_Bulan = '$id_Bulan'");
    $r = mysql_fetch_array($q);
    //$bln_lalu = $id_Bulan - 1;
    return $r['keu'];
}
$qskpd = mysql_query("SELECT nm_Skpd FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
$rskpd = mysql_fetch_array($qskpd);
echo "<div id=print>
				<div align=center>
				<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0>
				<tr align=center><td>LAPORAN PERKEMBANGAN PROGRAM / KEGIATAN</td></tr>
				<tr align=center><td>".strtoupper($rskpd[nm_Skpd])."</td></tr>
				<tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr></table></div>	
	            <table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>  <tr>
    <td rowspan=2>No</td>
    <td rowspan=2>Program / Kegiatan</td>
    <td rowspan=2>Anggaran</td>
    <td colspan=12>Realisasi</td>
    <td rowspan=2>Total</td>
    <td rowspan=2>%</td>
  </tr>
  <tr>
    <td>Jan</td>
    <td>Feb</td>
    <td>Mar</td>
    <td>Apr</td>
    <td>Mei</td>
    <td>Jul</td>
    <td>Jun</td>
    <td>Ags</td>
    <td>Sep</td>
    <td>Okt</td>
    <td>Nop</td>
    <td>Des</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>";
    $q = mysql_query("SELECT *,b.id_Program,a.id_Skpd,a.TahunAnggaran  
                        FROM datakegiatan a, kegiatan b 
                        WHERE a.id_Kegiatan = b.id_Kegiatan 
                        AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                        AND a.TahunAnggaran = '$_SESSION[thn_Login]' 
                        GROUP BY b.id_Program");
    while($r=mysql_fetch_array($q)) {
            $q1 = mysql_query("SELECT nm_Program, id_Program  
                                      FROM program 
                                      WHERE id_Program = '$r[id_Program]'");
            $r1=mysql_fetch_array($q1);
        echo "<tr>
            <td>&nbsp;</td>
            <td><strong>$r1[nm_Program]</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>";
        $q2 = mysql_query("SELECT a.nm_Kegiatan, b.id_DataKegiatan,b.AnggKeg 
                FROM kegiatan a, datakegiatan b 
                WHERE a.id_Kegiatan = b.id_Kegiatan 
                AND b.id_Skpd = '$r[id_Skpd]' 
                AND b.TahunAnggaran = '$r[TahunAnggaran]' 
                AND a.id_Program = '$r1[id_Program]'");
        while ($r2=mysql_fetch_array($q2)) {
            
            echo "<tr>
                    <td>&nbsp;</td>
                    <td>$r2[nm_Kegiatan]</td>
                    <td>".number_format($r2[AnggKeg])."</td>";
                    for ($i=1; $i <= 12; $i++) { 
                        //cari 0 jika bulan 2
                        $bulanlalu = rlsbulanlalu($i,$r2['id_DataKegiatan']);
                        $bulanini = rlsbulan($i,$r2['id_DataKegiatan']);
                        //echo "<td>".number_format(rlsbulanlalu(3,$r2['id_DataKegiatan']))."</td>";
                        $hasil = $bulanini - $bulanlalu;
                        if($hasil < 0) {
                            $t = 0;
                        } else {
                            $t = $hasil;
                        }
                        echo "<td>".number_format($t)."</td>";
                        //echo "<td>".number_format(1000000-1000000)."</td>";
                    }
                    $total = totalkeg(maxbulan($r2['id_DataKegiatan']),$r2['id_DataKegiatan']);
                    $persen = ($total / $r2['AnggKeg']) * 100;
                echo "<td>".number_format($total)."</td>
                    <td>".round($persen,2)."</td>
                  </tr>";
        }
    }

echo "</table>
</body>";

}
?>