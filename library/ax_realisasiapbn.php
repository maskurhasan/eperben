<?php
include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_SubApbn'];
$q = mysql_query('SELECT * FROM subapbn WHERE id_SubApbn = "'.$postur.'"');
$r = mysql_fetch_array($q);
 echo "<div class='module'>
        <h2><span>Realisasi DAK Bulanan</span></h2>
        <div class=module-table-body>
        <form method=post action='modul/act_modrealisasiapbn.php?module=realisasiapbn&act=add'>
        <table id=myTable2 class=tablesorter>
        <thead><tr><th style=width:5%>#</th>
        <th style=width:5%>Bulan</th><th style=width:15%>APBN</th><th style=width:10%>PHLN</th>
        <th style=width:5%>% Fisik</th>
        <th style=width:20%>Aksi</th></tr></thead><tbody>";
        
  echo "<tr>
        <td></td>
        <td>Target</td>
        <td>$r[trg_Fisik]</td>
        <td>$r[trg_Keu2]</td>
        <td>$r[trg_Keu2]</td>
        <td></td>
        </tr>";

        $qa = mysql_query("SELECT SUM(rls_Fisik) AS jml_fisik, 
                                  SUM(rls_Keu2) AS jml_keu 
                              FROM realisasi WHERE id_SubKegiatan = '$r[id_SubKegiatan]'");
        $ra = mysql_fetch_array($qa);
  echo "<tr>
        <td></td>
        <td>Realisasi</td>
        <td>$ra[jml_fisik]</td>
        <td>$ra[jml_keu]</td>
        <td>$ra[jml_keu]</td>
        <td></td>
        </tr>";   
 
  echo "<tr>
        <td></td>
        <td><select name='id_Bulan'>
            <option value='0'>-Pilih Bulan-</option>";   
            //cari nilai tertinggi dari bulan yg telah direalisasikan
            $qx = mysql_query("SELECT MAX(id_Bulan) AS id_Bulan FROM realisasiapbn WHERE id_SubApbn = $r[id_SubApbn]");
            $rx = mysql_fetch_array($qx);

            for ($j=$rx['id_Bulan']+1;$j<=12;$j++)
            {
              echo "<option value=$j>$arrbln[$j]</option>";
            }               
  echo "</select></td>
          <td><input type='text' name=rls_Apbn></td>
          <td><input type=text name='rls_Phln'></td>
          <td><input type=text name='per_Fisik' size='4'></td>
          <td><input type=hidden name=id_SubApbn value='$r[id_SubApbn]'>
              <input type=hidden name=id_DataApbn value='$r[id_DataApbn]'>
              <button type='submit' name='simpanx' value='simpan'><i class='fa fa-save'></i> Simpan</button></td>
        </tr>";
        //$sql = mysql_query("SELECT * FROM datakegiatan a,subkegiatan b 
        //                    WHERE a.id_DataKegiatan = b.id_DataKegiatan AND a.id_Skpd = '$_SESSION[id_Skpd]' AND a.id_DataKegiatan = '$_GET[id]'");
        $qc = mysql_query("SELECT * FROM realisasiapbn WHERE id_SubApbn = '$r[id_SubApbn]' ORDER BY id_RealisasiApbn");
        while ($rw = mysql_fetch_array($qc)) {
        $id_Bulan = $rw[id_Bulan];
        echo "<tr><td>$rw[id_Bulan]</td>
              <td>$arrbln[$id_Bulan]</td>
              <td><input type='text' name='rls_Apbn$id_Bulan' value=$rw[rls_Apbn]></td>
              <td><input type='text' name='rls_Phln$id_Bulan' value=$rw[rls_Phln]></td>
              <td><input type='text' name='per_Fisik$id_Bulan' value=$rw[per_Fisik]  size='4'></td>
              <td class=align-center>
              <input type=hidden name='id_RealisasiApbn$id_Bulan' value=$rw[id_RealisasiApbn]>
              <button class='' type=submit name='simpan$id_Bulan' value='simpan'><i class='fa fa-pencil'></i> Edit</button>
              <button class='' type=submit name='delete$id_Bulan' value='hapus' onclick='return confirm(\'yakin akan menghapus..???\')'><i class='fa fa-trash'></i> Hapus</button>
              </td></tr>";
        }
        echo "</tbody></table></form></div></div>
            <div style='clear:both;'></div>
            </div>
            <div class=bottom-spacing></div>";

?>