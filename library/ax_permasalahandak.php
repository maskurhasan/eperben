<?php
include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_SubDak'];
$q = mysql_query('SELECT * FROM subdak WHERE id_SubDak = "'.$postur.'"');
$r = mysql_fetch_array($q);
echo $postur;
 echo "<div class='module'>
        <h2><span>Data Lampiran Realisasi</span></h2>
        <div class=module-table-body>
        <form method=post action='modul/act_modrealisasidak.php?module=realisasidak&act=masalah'>
        <table id=myTable2 class=tablesorter>
        <thead><tr><th style=width:5%>#</th>
        <th style=width:5%>Masalah</th><th style=width:15%>Foto</th><th style=width:10%>Solusi</th><th style=width:20%>Aksi</th></tr></thead><tbody>";
                 
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
          <td><textarea name='nm_PermasalahanDak'></textarea></td>
          <td><textarea name='nm_SolusiDak'></textarea></td>
          <td><input type=hidden name=id_SubDak value='$r[id_SubDak]'>
              <input type=hidden name=id_DataDak value='$r[id_DataDak]'>
              <button type='submit' name='masalah' value='simpan'><i class='fa fa-save'></i> Simpan</button></td>
        </tr>";
        
        $qc = mysql_query("SELECT * FROM lamppermasalahandak a, realisasidak b 
                                WHERE b.id_SubDak = '$r[id_SubDak]' AND a.id_RealisasiDak = b.id_RealisasiDak ORDER BY a.id_RealisasiDak");
        while ($rw = mysql_fetch_array($qc)) {
        $id_Bulan = $rw[id_Bulan];
        echo "<tr><td>$rw[id_Bulan]</td>
              <td>$arrbln[$id_Bulan]</td>
              <td>$rw[nm_PermasalahanDak]</a></td>
              <td>$rw[nm_SolusiDak]</td>
              <td class=align-center>
              <input type=hidden name='id_LampPermasalahanDak$id_Bulan' value=$rw[id_LampPermasalahanDak]>
              <!--<button class='' type=submit name='simpan$id_Bulan' value='simpan'><i class='fa fa-pencil'></i> Edit</button>-->
              <button class='' type=submit name='delete$id_Bulan' value='hapus' onclick='return confirm(\'yakin akan menghapus..???\')'><i class='fa fa-trash'></i> Hapus</button>
              </td></tr>";
        }
        echo "</tbody></table></form></div></div>
            <div style='clear:both;'></div>
            </div>
            <div class=bottom-spacing></div>";

?>