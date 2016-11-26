<?php
include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_DataKegiatan'];
$q = mysql_query('SELECT *,(trg_Keu1+trg_Keu2+trg_Keu3+trg_Keu4) AS target 
                  FROM subkegiatan WHERE id_SubKegiatan = "'.$postur.'"');
$r = mysql_fetch_array($q);
 echo "<div class='module'>
        <h2><span>Data Realisasi Bulanan</span></h2>
        <div class=module-table-body>
        <form method=post action='modul/act_modrealisasi.php?module=realisasi&act=add'>
        <table class=tabel width=700px>
        <thead><tr>
        <th style=width:5%>Bulan</th><th style=width:15%>Fisik</th><th style=width:10%>Keuangan</th></tr></thead><tbody>";
        
  echo "<tr>
        <td>Target</td>
        <td></td>
        <td>".number_format($r['target'])."</td>
        </tr>";

        //$qa = mysql_query("SELECT SUM(rls_Fisik) AS jml_fisik, 
        //                          SUM(rls_Keu2) AS jml_keu 
        //                      FROM realisasi WHERE id_SubKegiatan = '$r[id_SubKegiatan]'");
        //$ra = mysql_fetch_array($qa);

        $sql1 = "SELECT a.id_Kegiatan,MAX(MONTH(Tanggal)) bulan,SUM(c.NilaiBelanja) AS NilaiRealisasi
            FROM datakegiatan a, realisasi2 c 
            WHERE a.id_Kegiatan = c.id_Kegiatan
            AND a.id_DataKegiatan = '$postur'";
        $r1 = mysql_fetch_array(mysql_query($sql1));
        function bulanan($id_Bulan,$id_DataKegiatan) {
            $sql1 = "SELECT MONTH(c.Tanggal) AS bulan,SUM(c.NilaiBelanja) AS NilaiRealisasi
                      FROM datakegiatan a, realisasi2 c 
                      WHERE a.id_Kegiatan = c.id_Kegiatan
                      AND a.id_DataKegiatan = '$id_DataKegiatan' 
                      GROUP BY bulan
                      HAVING bulan = '$id_Bulan'";
            $r1 = mysql_fetch_array(mysql_query($sql1));
            return number_format($r1['NilaiRealisasi']);

        }
  echo "<tr class=alt>
        <td>Realisasi</td>
        <td>$ra[rls_Fisik]</td>
        <td>".number_format($r1['NilaiRealisasi'])."</td>
        </tr>";
    for ($j=1;$j<=$r1['bulan'];$j++)
        {
          $j % 2 === 0 ? $alt="alt" : $alt="";
            echo "<tr class=$alt>
              <td>$arrbln[$j]</td>
              <td></td>
              <td>".bulanan($j,$postur)."</td>
            </tr>";
        }           
 /*
  echo "<tr>
        <td></td>
        <td><select name='id_Bulan'>
            <option value=''>-Pilih Bulan-</option>";   
            //cari nilai tertinggi dari bulan yg telah direalisasikan
            

            for ($j=$rx['id_Bulan']+1;$j<=12;$j++)
            {
              echo "<option value=$j>$arrbln[$j]</option>";
            }
            //dapatkan nilai u mengisi field realisasi
            $qq = mysql_query("SELECT * 
                                FROM realisasi 
                                WHERE id_Bulan = '$rx[id_Bulan]' 
                                AND id_SubKegiatan = '$r[id_SubKegiatan]'");
            $rq = mysql_fetch_assoc($qq);               
  echo "</select></td>
          <td><input type='text' name=rls_Fisik value=$rq[rls_Fisik]></td>
          <td><input type=text name='rls_Keu2' value=$rq[rls_Keu2]></td>
          <td><input type=hidden name=id_SubKegiatan value='$r[id_SubKegiatan]'>
              <input type=hidden name=id_DataKegiatan value='$r[id_DataKegiatan]'>
              <button type='submit' name='simpanx' value='simpan'><i class='fa fa-save'></i> Simpan</button></td>
        </tr>";
    */
        //$sql = mysql_query("SELECT * FROM datakegiatan a,subkegiatan b 
        //                    WHERE a.id_DataKegiatan = b.id_DataKegiatan AND a.id_Skpd = '$_SESSION[id_Skpd]' AND a.id_DataKegiatan = '$_GET[id]'");
        $qc = mysql_query("SELECT * FROM realisasi WHERE id_SubKegiatan = '$r[id_SubKegiatan]' ORDER BY id_Realisasi");
        $no=1;
		while ($rw = mysql_fetch_array($qc)) {
        $id_Bulan = $rw[id_Bulan];
		$id_Bulan % 2 === 0 ? $alt="alt" : $alt="";
        echo "<tr class=$alt><td>$rw[id_Bulan]</td>
              <td>$arrbln[$id_Bulan]</td>
              <td><input type='text' name='rls_Fisik$id_Bulan' value=$rw[rls_Fisik]></td>
              <td><input type='text' name='rls_Keu2$id_Bulan' value=$rw[rls_Keu2]></td>
              <td class=align-center>
              <input type=hidden name='id_Realisasi$id_Bulan' value=$rw[id_Realisasi]>
              <button class='' type=submit name='simpan$id_Bulan' value='simpan'><i class='fa fa-pencil'></i> Edit</button> ";
        echo '<button type="submit" name="delete'.$id_Bulan.'" value="hapus" onclick="return confirm(\'yakin akan Hapus data ini\');"><i class="fa fa-trash"></i> Hapus</button>
              </td></tr>';
        }
        echo "</tbody></table></form></div></div>
            <div style='clear:both;'></div>
            </div>
            <div class=bottom-spacing></div>";

?>