<?php
include "../config/koneksi.php";

//mengambil data desa
$postur = $_POST[id_SubKegiatan];
$q = mysql_query('SELECT * FROM subkegiatan WHERE id_SubKegiatan = "'.$postur.'"');
$r = mysql_fetch_array($q);

//cek jika fisik
$r[JnsSubKeg]=='f' ? $cekk = "checked" : "";
echo "<form method=post id=frm_tambah action=".htmlspecialchars('modul/act_modsubkegiatan.php?module=subkegiatan&act=edit').">
                <table width='100%' id='table_form'>
                <tr><td>Nama Rincian </td><td><input type=text class='input-medium required' name='nm_SubKegiatan' placeholder='Nama Rincian' value='$r[nm_SubKegiatan]'>&nbsp;<input type='checkbox' name='JnsSubKeg' id='group1' value='f' $cekk> Fisik</td></tr>
                <tr><td>Nilai PAGU </td><td><input type=text class='input-short digits' name='nl_Pagu' placeholder='Nilai PAGU' value='$r[nl_Pagu]'></td></tr>
                <tr><td>Nilai Fisik </td><td><input type=text class='input-short digits' name='nl_Fisik' placeholder='Nilai Fisik' value='$r[nl_Fisik]'> </td></tr>
                <tr><td>Nilai Kontrak </td><td><input type=text class='input-short digits' name='nl_Kontrak' placeholder='Nilai Kontrak' value='$r[nl_Kontrak]'></td></tr>
                <tr><td>Volume </td><td><input type=text class='input-short required' name='jml_Volume' placeholder='Volume' value='$r[jml_Volume]'></td></tr>
                <tr><td>Sumber Dana </td><td><select class='input-medium required'  name=id_SbDana placeholder='pilih Sumber' onchange=''>
                <option selected>Sumber Dana</option>";
                  $qx=mysql_query("SELECT * FROM sumberdana");
                  while ($rx=mysql_fetch_array($qx)) {
                  	if($rx[id_SbDana]==$r[id_SbDana]) {
                    	echo "<option value=$rx[id_SbDana] selected>$rx[id_SbDana] $rx[nm_SbDana]</option>";
                	}else{
                    	echo "<option value=$rx[id_SbDana]>$rx[id_SbDana] $rx[nm_SbDana]</option>";
                	}
                  }         
                  echo "</select></td></tr>
                <tr><td>Alamat Lokasi </td><td><input type=text class='input-medium required' name='AlamatLokasi' placeholder='Alamat' value='$r[AlamatLokasi]'></td></tr>
                <tr><td>Kecamatan</td><td><select class=input-short  name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);'>
                <option selected>Kecamatan</option>";
                  $qx=mysql_query("SELECT * FROM kecamatan");
                  while ($rx=mysql_fetch_array($qx)) {
                  	$idkec = substr($r[id_Desa], 0,7);
                  	if($rx[id_Kecamatan]==$idkec) {
                    	echo "<option value=$rx[id_Kecamatan] selected>$rx[nm_Kecamatan]</option>";
                    }else{
                    	echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  }         
                  echo "</select>&nbsp;Desa :<select class=input-short  name=id_Desa placeholder=Desa id=id_Desa onchange=''>";
                  $qx=mysql_query("SELECT * FROM desa");
                  while ($rx=mysql_fetch_array($qx)) {
                  	if($rx[id_Desa]==$r[id_Desa]) {
                    	echo "<option value=$rx[id_Desa] selected>$rx[nm_Desa]</option>";
                    }else{
                    	echo "<option value=$rx[id_Desa]>$rx[nm_Desa]</option>";
                    }
                  } 

                  echo "</select></td></tr>";
                //$r[Pelaksana] = 'Swakelola' ? $cek = 'Checkhed' : $cek = 
                 if($r[Pelaksana] == "Swakelola") {
                 	$cek = "checked";
                  $isicek = "";
                 }else {
                 	$cek = "";
                 	$cek1 = "checked";
                 	$isicek = $r[Pelaksana];
                 }
                echo "<tr><td>Pelaksana </td><td><input type='text' class='input-short required' name='pelaksana2' id='pelaksana2' value='$r[Pelaksana]'></td></tr>
                <tr><td>Konsultan </td><td>Perencana : <input type=text class='input-short' name='konsPerencana' placeholder='Kons. Perencana' value='$r[konsPerencana]'> Pengawas : <input type=text class='input-short' name='konsPengawas' placeholder='Kons. Pengawas' value='$r[konsPengawas]'></td></tr>
                <tr><td>Nomor Kontrak </td><td><input type=text class='input-short' name='no_Kontrak' placeholder='Nomor Kontrak' value='$r[no_Kontrak]'></td></tr>
                <tr><td>Waktu Pekerjaan</td><td>Mulai : <input type=text class='input-short' name='tgl_Mulai' placeholder='tgl Mulai' value='$r[tgl_Mulai]'> Tanggal Selesai : <input type=text class='input-short' name='tgl_Selesai' placeholder='tgl selesai' value='$r[tgl_Selesai]'></td></tr>
                <tr><td>Target Fisik</td><td><input type=text class='input-short required' name='trg_Fisik' placeholder='Fisik' value='$r[trg_Fisik]'></td></tr>
                <tr><td>Target Keuangan </td><td>
                <input type=text class='input-short digits' name='trg_Keu1' placeholder='Triwulan I' value='$r[trg_Keu1]'>
                <input type=text class='input-short digits' name='trg_Keu2' placeholder='Triwulan II' value='$r[trg_Keu2]'></td></tr>
                <tr><td>&nbsp;</td><td>
                <input type=text class='input-short digits' name='trg_Keu3' placeholder='Triwulan III' value='$r[trg_Keu3]'>
                <input type=text class='input-short digits' name='trg_Keu4' placeholder='Triwulan IV' value='$r[trg_Keu4]'>
                <input type=checkbox id='bagirata' name='bagirata' value='bagirata'> Bagi Rata</td></tr>
                <tr><td>&nbsp;</td><td>
                <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                <input type=hidden name=id_SubKegiatan value=$r[id_SubKegiatan] />
                <input type=hidden name=TahunAnggaran value=$_SESSION[thn_Login] />
                <input type='hidden' name='id_DataKegiatan' value='$r[id_DataKegiatan]' />
                <button type='submit' name='simpan'><i class='fa fa-save'></i> Simpan</button> 
                <button type='reset'><i class='fa fa-refresh'></i> Reset</button>";
          echo '<button type="submit" name="delete" onclick="return confirm(\'Yakin Hapus data ini?\')"><i class="fa fa-trash"></i> Hapus</button>';
          echo "</td></tr>
                </table>
                </form>
                <div class=bottom-spacing>
                </div>";

?>
<script type="text/javascript">

$('#frm_tambah').validate();
//disable jika swakelola

$(function() {
  enable_cb();
  $("#group1").click(enable_cb);
});

function enable_cb() {
  if (this.checked) {
    $("input.group1").removeAttr("disabled");
  } else {
    $("input.group1").attr("disabled", true);
  }
}

//$("#bulanan").hide();
$(function() {
  pertriwulan();
  $("#triwulan").click(pertriwulan);
});
function pertriwulan() {
  if (this.checked) {
    $("#bulanan").show();
  } else {
    $("#bulanan").hide();
  }
}

</script>