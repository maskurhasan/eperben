<?php
include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_SubDak'];
$q = mysql_query('SELECT * FROM subdak WHERE id_SubDak = "'.$postur.'"');
$r = mysql_fetch_array($q);
 echo "<div class='module'>
        <h2><span>Realisasi DAK Bulanan</span></h2>
        <div class=module-table-body>
        <form method=post action='modul/act_modrealisasidak.php?module=realisasidak&act=add'>
        <table id=myTable2 class=tablesorter>
        <thead><tr><th style=width:5%>#</th>
        <th style=width:5%>Bulan</th><th style=width:15%>DAK</th><th style=width:10%>Pendamping</th>
        <th style=width:5%>% Fisik</th><th style=width:10%>RKPD</th><th style=width:10%>Teknis</th>
        <th style=width:20%>Aksi</th></tr></thead><tbody>";
        
  echo "<tr>
        <td></td>
        <td>Target</td>
        <td>$r[trg_Fisik]</td>
        <td>$r[trg_Keu2]</td>
        <td>$r[trg_Keu2]</td>
        <td></td>
        <td></td>
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
        <td></td>
        <td></td>
        </tr>";   
 
  echo "<tr>
        <td></td>
        <td><select name='id_Bulan'>
            <option value='0'>-Pilih Bulan-</option>";   
            //cari nilai tertinggi dari bulan yg telah direalisasikan
            $qx = mysql_query("SELECT MAX(id_Bulan) AS id_Bulan FROM realisasidak WHERE id_SubDak = $r[id_SubDak]");
            $rx = mysql_fetch_array($qx);

            for ($j=$rx['id_Bulan']+1;$j<=12;$j++)
            {
              echo "<option value=$j>$arrbln[$j]</option>";
            }               
  echo "</select></td>
          <td><input type='text' name=rls_Dak></td>
          <td><input type=text name='rls_Pendamping'></td>
          <td><input type=text name='per_Fisik' size='4'></td>
          <td><input type=checkbox name='SesuaiRkpd' value='1'></td>
          <td><input type=checkbox name='SesuaiTeknis' value='1'></td>
          <td><input type=hidden name=id_SubDak value='$r[id_SubDak]'>
              <input type=hidden name=id_DataDak value='$r[id_DataDak]'>
              <button type='submit' name='simpanx' value='simpan'><i class='fa fa-save'></i> Simpan</button></td>
        </tr>";
        //$sql = mysql_query("SELECT * FROM datakegiatan a,subkegiatan b 
        //                    WHERE a.id_DataKegiatan = b.id_DataKegiatan AND a.id_Skpd = '$_SESSION[id_Skpd]' AND a.id_DataKegiatan = '$_GET[id]'");
        $qc = mysql_query("SELECT * FROM realisasidak WHERE id_SubDak = '$r[id_SubDak]' ORDER BY id_RealisasiDak");
        while ($rw = mysql_fetch_array($qc)) {
        $id_Bulan = $rw[id_Bulan];
        echo "<tr><td>$rw[id_Bulan]</td>
              <td>$arrbln[$id_Bulan]</td>
              <td><input type='text' name='rls_Dak$id_Bulan' value=$rw[rls_Dak]></td>
              <td><input type='text' name='rls_Pendamping$id_Bulan' value=$rw[rls_Pendamping]></td>
              <td><input type='text' name='per_Fisik$id_Bulan' value=$rw[per_Fisik]  size='4'></td>
              <td><input type=checkbox name='SesuaiRkpd' value='1'></td>
              <td><input type=checkbox name='SesuaiTeknis' value='1'></td>
              <td class=align-center>
              <input type=hidden name='id_RealisasiDak$id_Bulan' value=$rw[id_RealisasiDak]>
              <button class='' type=submit name='simpan$id_Bulan' value='simpan'><i class='fa fa-pencil'></i> Edit</button>
              <button class='' type=submit name='delete$id_Bulan' value='hapus' onclick='return confirm(\'yakin akan menghapus..???\')'><i class='fa fa-trash'></i> Hapus</button>
              </td></tr>";
        }
        echo "</tbody></table></form></div></div>
            <div style='clear:both;'></div>
            </div>
            <div class=bottom-spacing></div>";

?>