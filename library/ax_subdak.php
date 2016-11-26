<?php
include "../config/koneksi.php";

//mengambil data desa
$postur = $_POST[id_SubDak];
$q = mysql_query('SELECT * FROM subdak WHERE id_SubDak = "'.$postur.'"');
$r = mysql_fetch_array($q);
echo "<form method=post action='modul/act_moddatadak.php?module=datadak&act=editsubdak' id=form_edit>
                <label>Nama Kegiatan : </label><input type=text class='input-medium' name='nm_SubDak' placeholder='Nama Kegiatan' value='$r[nm_SubDak]'>&nbsp;<input type='checkbox' name='d' id='group1'> Fisik
                <label>Volume : </label><input type=text class='input-short' name='Volume' placeholder='Volume' value='$r[Volume]'>
                <label>Satuan : </label><input type=text class='input-short' name='Paket' placeholder='Paket' value='$r[Paket]'>
                <label>Jumlah Penerima Manfaat : </label><input type=text class='input-medium' name='JpManfaat' placeholder='Penerima Manfaat' value='$r[JpManfaat]'>
                <label>Anggaran DAK : </label><input type=text class='input-short' name='anggDak' placeholder='Anggaran DAK' value='$r[anggDak]'>
                <label>Anggaran Pendamping : </label><input type=text class='input-short' name='anggPendamping' placeholder='Anggaran Pendamping' value='$r[anggPendamping]'>
                <label>Total (DAK+Pendamping) : </label><input type=text class='input-short' name='Total' placeholder='total'>
                <label>Swakelola : </label><input type=text class='input-short' name='pl_Swakelola' placeholder='Swakelola' value='$r[pl_Swakelola]'>
                <label>Kontrak : </label><input type=text class='input-short' name='pl_Kontrak' placeholder='Kontrak' value='$r[pl_Kontrak]'>
                   
                <fieldset>
                <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                <input type=hidden name='id_SubDak' value=$r[id_SubDak] />
                <input type=hidden name=TahunAnggaran value=$_SESSION[thn_Login] />
                <input type=hidden name='id_Session' value=$_SESSION[Sessid] />
                <input type=hidden name=id_DataDak value='$r[id_DataDak]'>
                <button class='' type='submit' name='simpan'><i class='fa fa-save'></i> Simpan</button> 
                <input class='' type='reset' value=Reset />
                <button class='' type='submit' name=delete><i class='fa fa-trash'></i> Hapus</button>
                </fieldset>
                </form>
                <div class=bottom-spacing>
                </div>";

?>
<script type="text/javascript">
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


</script>