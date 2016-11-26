<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";

//ambil value dri data kd_Urusan + kd_BidUrusan + kd_Program
$terima = $_POST[id_Rincspm];

function totalspm($id_Spm)
{
  $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                      WHERE c.id_Spm = '$id_Spm'");
  $r = mysql_fetch_array($sql);
  return $r[total];
}
function realisasikeg($id_DataKegiatan)
{
  $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                      WHERE c.id_DataKegiatan = '$id_DataKegiatan'");
  $r = mysql_fetch_array($sql);
  return $r[total];
}
function nilaitargetspp($id_Spm)
{
  $sql= mysql_query("SELECT Anggaran FROM spm
                      WHERE id_Spm = '$id_Spm'");
  $r = mysql_fetch_array($sql);
  return $r[Anggaran];
}
$sql11 = "SELECT a.AnggKeg,a.id_DataKegiatan FROM datakegiatan a
							WHERE a.TahunAnggaran = '$_SESSION[thn_Login]'
							AND a.id_Skpd = '$_SESSION[id_Skpd]'
							AND a.id_DataKegiatan = '$terima'";
$sql1= "SELECT b.AnggKeg,b.id_DataKegiatan,d.nm_Kegiatan,c.Nilai,c.id_Rincspm,c.id_Spm,e.nm_Program FROM datakegiatan b,rincspm c,kegiatan d,program e
							WHERE c.id_DataKegiatan = b.id_DataKegiatan
							AND b.id_Kegiatan = d.id_Kegiatan
							AND d.id_Program = e.id_Program
							AND c.id_Rincspm = '$terima'";
$result1 = mysql_query($sql1);
$r = mysql_fetch_array($result1);

echo '<div class="profile-user-info profile-user-info-striped" id="rincian">
			<div class="profile-info-row">
				<div class="profile-info-name"> Program </div>
				<div class="profile-info-value">
					'.$r[nm_Program].'
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Kegiatan </div>
				<div class="profile-info-value">
					'.$r[nm_Kegiatan].'
				</div>
			</div>
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
					<input type="text" name="Nilai" value="'.$r[Nilai].'">
					<input type="hidden" name="NilaiLama" value="'.$r[Nilai].'">
					<input type="hidden" name="id_Rincspm" value="'.$r[id_Rincspm].'">
					<input type="hidden" name="id_Spm" value="'.$r[id_Spm].'">
					<input type="hidden" name="AnggaranTarget" value="'.nilaitargetspp($r[id_Spm]).'">
					<input type="hidden" name="TotalSmntara" value="'.totalspm($r['id_Spm']).'">
				</div>
			</div>
			<div class="profile-info-row">
				<div class="profile-info-name"> Sisa </div>
				<div class="profile-info-value">
					<input type="text" value="" readonly>
				</div>
			</div>

		</div>'

?>
<script type="text/javascript">

</script>