<?php
include "../config/koneksi.php";

//mengambil data desa
$postur = $_POST[id_SubApbn];
$q = mysql_query('SELECT * FROM subapbn WHERE id_SubApbn = "'.$postur.'"');
$r = mysql_fetch_array($q);
echo "<form method=post action='modul/act_moddataapbn.php?module=dataapbn&act=editsubapbn' id='form_tambah'>
                <label>Nama Kegiatan : </label><input type=text class='input-medium' name='nm_SubApbn' placeholder='Nama Kegiatan' value='$r[nm_SubApbn]'>
                <label>Jenis APBN: </label><select name='id_JnsApbn' class='input-short'><option>Jenis</option>";
                $qx = mysql_query("SELECT * FROM jnsapbn");
                while ($rx=mysql_fetch_array($qx)) {
                    if($rx[id_JnsApbn]==$r[id_JnsApbn]) {
                        echo "<option value=$rx[id_JnsApbn] selected>$rx[nm_JnsApbn] - $rx[KetJnsApbn]</option>";
                    } else {
                        echo "<option value=$rx[id_JnsApbn]>$rx[nm_JnsApbn] - $rx[KetJnsApbn]</option>";
                    }
                }
          echo "</select><label>Anggaran APBN : </label><input type=text class='input-short' name='anggApbn' placeholder='Anggaran APBN' value='$r[anggApbn]'>
                <label>Anggaran PHLN : </label><input type=text class='input-short' name='anggPhln' placeholder='Anggaran PHLN' value='$r[anggPhln]'>
                <label>Total (APBN+PHLN) : </label><input type=text class='input-short' name='Total' placeholder='total'>
                <label>Swakelola : </label><input type=text class='input-short' name='pl_Swakelola' placeholder='Swakelola' value='$r[pl_Swakelola]'>
                <label>Kontrak : </label><input type=text class='input-short' name='pl_Kontrak' placeholder='Kontrak' value='$r[pl_Kontrak]'>
                   
                <fieldset>
                <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                <input type=hidden name=TahunAnggaran value=$_SESSION[thn_Login] />
                <input type=hidden name='id_Session' value=$_SESSION[Sessid] />
                <input type=hidden name=id_DataApbn value=$r[id_DataApbn] />
                <input type=hidden name=id_SubApbn value=$r[id_SubApbn] />
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