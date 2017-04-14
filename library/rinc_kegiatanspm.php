<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";

//ambil value dri data kd_Urusan + kd_BidUrusan + kd_Program
$terima = $_POST[id_Kegiatan];
/*
$qq = mysql_query("SELECT b.nm_Kegiatan FROM datakegiatan a, kegiatan b
														WHERE a.id_Kegiatan = b.id_Kegiatan
														AND a.TahunAnggaran = '$_SESSION[thn_Login]'
														AND a.id_Skpd = '$_SESSION[id_Skpd]'");
while ($rq = mysql_fetch_array($qq)) {
	echo '<option value="">'.$rq[nm_Kegiatan].'</option>';
}
*/
//$postur = $_POST[kd_Program];
$sql1 = "SELECT a.AnggKeg,a.id_DataKegiatan FROM datakegiatan a
							WHERE a.TahunAnggaran = '$_SESSION[thn_Login]'
							AND a.id_Skpd = '$_SESSION[id_Skpd]'
							AND a.id_DataKegiatan = '$terima'";
$result1 = mysql_query($sql1);
$r = mysql_fetch_array($result1);

function realisasikeg($id_DataKegiatan)
{
  $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                      WHERE c.id_DataKegiatan = '$id_DataKegiatan'");
  $r = mysql_fetch_array($sql);
  return $r[total];
}

echo '<div class="profile-user-info profile-user-info-striped" id="rincian">
			<div class="profile-info-row">
				<div class="profile-info-name"> Anggaran </div>
				<div class="profile-info-value">
					<input type="hidden" name="id_DataKegiatan" value="'.$r[id_DataKegiatan].'">
					<input type="text" id="anggaran" value="'.angkrp($r[AnggKeg]).'" readonly>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Realisasi </div>
				<div class="profile-info-value">
					<input type="text" value="'.angkrp(realisasikeg($r[id_DataKegiatan])).'" readonly>
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Jumlah SPM </div>
				<div class="profile-info-value">
					<input type="text" name="Nilai" value="">
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Sisa </div>
				<div class="profile-info-value">
					<input type="text" value="" readonly>
				</div>
			</div>

		</div>'

/*

//$postur = $_POST[kd_Program];
$sql1 = 'SELECT * FROM kegiatan WHERE id_Program = "'.$terima.'"';
$result1 = mysql_query($sql1);
	echo '<option>Pilih Kegiatan</option>';
while($dt = mysql_fetch_array($result1)) {
	$id_Kegiatan = substr($dt[id_Kegiatan],-2);
	echo "<option value=$dt[id_Kegiatan]>$id_Kegiatan $dt[nm_Kegiatan]</option>";
}
*/
?>
