<?php
include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_SubDak'];
$q = mysql_query('SELECT * FROM subdak WHERE id_SubDak = "'.$postur.'"');
$r = mysql_fetch_array($q);
 echo "<div class='module'>
        <h2><span>Data Lampiran Realisasi</span></h2>
        <div class=module-table-body>
        <form method=post action='modul/act_modrealisasidak.php?module=realisasidak&act=addlamp' enctype='multipart/form-data'>
        <table id=myTable2 class=tablesorter>
        <thead><tr><th style=width:5%>#</th>
        <th style=width:5%>Bulan</th><th style=width:15%>Foto</th><th style=width:10%>Keterangan</th><th style=width:20%>Aksi</th></tr></thead><tbody>";
                 
  echo "<tr>
        <td></td>
        <td><select name='id_Bulanlamp'>
            <option value='0'>-Pilih Bulan-</option>";   
            //cari nilai tertinggi dari bulan yg telah direalisasikan
            $qx = mysql_query("SELECT id_Bulan, id_RealisasiDak FROM realisasidak 
                                  WHERE id_SubDak = $r[id_SubDak]");
            
            while ($rx = mysql_fetch_array($qx)) {
              echo "<option value=$rx[id_RealisasiDak]>".$arrbln[$rx[id_Bulan]]."</option>";
            }
                        
  echo "</select></td>
          <td><input type='file' name='nm_LampRealisasiDak' id='nm_LampRealisasiDak' accept='image/*' value=></td>
          <td><input type=text name='Caption'></td>
          <td><input type=hidden name=id_SubDak value='$r[id_SubDak]'>
              <input type=hidden name=id_DataDak value='$r[id_DataDak]'>
              <button type='submit' name='upload' value='simpan'><i class='fa fa-save'></i> Upload</button></td>
        </tr>";
        
        $qc = mysql_query("SELECT * FROM lamprealisasidak a, realisasidak b 
                                WHERE b.id_SubDak = '$r[id_SubDak]' AND a.id_RealisasiDak = b.id_RealisasiDak ORDER BY a.id_RealisasiDak");
        while ($rw = mysql_fetch_array($qc)) {
        $id_Bulan = $rw[id_Bulan];
        echo "<tr><td>$rw[id_Bulan]</td>
              <td>$arrbln[$id_Bulan]</td>
              <td><a href='../image/dak/$rw[nm_LampRealisasiDak]' target='_blank'>$rw[nm_LampRealisasiDak]</a></td>
              <td>$rw[Caption]</td>
              <td class=align-center>
              <input type=hidden name='id_LampRealisasiDak$id_Bulan' value=$rw[id_LampRealisasiDak]>
              <input type=hidden name='nm_LampRealisasiDak$id_Bulan' value=$rw[nm_LampRealisasiDak]>
              <!--<button class='' type=submit name='simpan$id_Bulan' value='simpan'><i class='fa fa-pencil'></i> Edit</button>-->
              <button class='' type=submit name='delete$id_Bulan' value='hapus' onclick='return confirm(\'yakin akan menghapus..???\')'><i class='fa fa-trash'></i> Hapus</button>
              </td></tr>";
        }
        echo "</tbody></table></form></div></div>
            <div style='clear:both;'></div>
            </div>
            <div class=bottom-spacing></div>";

?>