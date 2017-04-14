<?php
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/errormode.php";

//mengambil data desa
$postur = $_POST['id_SubKegiatan'];
$q = mysql_query('SELECT *,(trg_Keu1+trg_Keu2+trg_Keu3+trg_Keu4) AS target
                  FROM subkegiatan WHERE id_SubKegiatan = "'.$postur.'"');
$r = mysql_fetch_array($q);

 echo '<div class="card">
                <div class="header">
                  <h4 class="title">Target Kegiatan</h4>
                  <p class="category">Data Realisasi Subkegiatan SKPD</p>
                </div>
              <div class="content">';
              echo '<div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        <p class="text-primary">BULAN</p>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <p class="text-primary">TARGET FISIK</p>
                    </div>
                    <!--
                    <div class="col-sm-2">
                      <p class="text-primary">REALISASI FISIK</p>
                    </div>
                    -->
                    <div class="col-sm-2">
                     <p class="text-primary">TARGET KEUANGAN</p>
                    </div>
                    <!--
                    <div class="col-sm-2">
                      <p class="text-primary">REALISASI KEUANGAN</p>
                    </div>
                    -->
                    <div class="col-sm-2">
                    </div>
                  </div><hr>';
                  //echo "<form method=post action='modul/act_modrealisasi.php?module=realisasi&act=addx'>";
              echo "<form method=post action='modul/act_modrealisasi.php?module=realisasi&act=add'>";
              $qc = mysql_query("SELECT * FROM realisasi WHERE id_SubKegiatan = '$postur' ORDER BY id_Bulan");

                for ($i=1; $i <=12 ; $i++) {
                  $rc = mysql_fetch_array($qc);
                  echo '<div class="row">
                    <div class="col-sm-2">
                      <div class="form-group">
                        '.$arrbln[$i].'
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="text" class="form-control" name="trg_Fisik[]" placeholder="Target Fisik '.$i.'">
                      </div>
                    </div>
                    <!--
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="text" class="form-control" name="rls_Fisik[]" placeholder="Realisasi Fisik '.$i.'" value="'.$rc['rls_Fisik'].'">
                      </div>
                    </div>
                    -->
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="number" class="form-control" name="trg_Keu[]" placeholder="Target Keuangan" value="'.$rc['trg_Keu'].'">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <!--<input type="number" class="form-control" name="rls_Keu2[]" placeholder="Realisasi Keuangan" value="'.$rc['rls_Keu2'].'">-->
                        <input type="hidden" name="bulan[]" value="'.$i.'">
                        <input type=hidden name="id_SubKegiatan" value="'.$r['id_SubKegiatan'].'">
                        <input type=hidden name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                        <input type=hidden name="id_Realisasi[]" value="'.$r['id_Realisasi'].'">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <!--<input class="btn btn-primary btn-fill pull-right" type="submit" name="simpanx" value=Simpan />-->
                      </div>
                    </div>
                  </div>';
                }
                $qz = mysql_query("SELECT id_SubKegiatan FROM realisasi WHERE id_SubKegiatan = '$r[id_SubKegiatan]'");
                $hit = mysql_num_rows($qz);
                if($hit == 0) {}
                $hit == 0 ? $tmb_simpan = "simpanx" : $tmb_simpan = "editx";
                echo '<hr>
                <div class="footer">
                  <input class="btn btn-primary btn-fill pull-right" type="submit" name="'.$tmb_simpan.'" value=Simpan />
                  <input class="btn btn-info" type="reset" value=Reset />
                  <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
                </div>
              </form>
              </div>
              </div>';


/*
  echo "<form method=post action='modul/act_modrealisasi.php?module=realisasi&act=add'>
        <table class='tabel' width=700px>
        <thead><tr><th style=width:5%>#</th>
        <th style=width:5%>Bulan</th><th style=width:15%>Fisik</th><th style=width:10%>Keuangan</th><th style=width:20%>Aksi</th></tr></thead><tbody>";

  echo "<tr>
        <td></td>
        <td>Target</td>
        <td>$r[trg_Fisik]</td>
        <td>".number_format($r['target'])."</td>
        <td></td>
        </tr>";

        //$qa = mysql_query("SELECT SUM(rls_Fisik) AS jml_fisik,
        //                          SUM(rls_Keu2) AS jml_keu
        //                      FROM realisasi WHERE id_SubKegiatan = '$r[id_SubKegiatan]'");
        //$ra = mysql_fetch_array($qa);

        $qx = mysql_query("SELECT MAX(id_Bulan) AS id_Bulan,rls_Fisik,MAX(rls_Keu2) AS keu
                            FROM realisasi
                            WHERE id_SubKegiatan = $r[id_SubKegiatan]");
        $rx = mysql_fetch_array($qx);
  echo "<tr>
        <td></td>
        <td>Realisasi</td>
        <td>$ra[rls_Fisik]</td>
        <td>".number_format($rx['keu'])."</td>
        <td></td>
        </tr>";
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
          <td><input type='form-control' name=rls_Fisik value=$rq[rls_Fisik]></td>
          <td><input type='form-control' name='rls_Keu2' value=$rq[rls_Keu2]></td>
          <td><input type=hidden name=id_SubKegiatan value='$r[id_SubKegiatan]'>
              <input type=hidden name=id_DataKegiatan value='$r[id_DataKegiatan]'>
              <button type='submit' name='simpanx' value='simpan'><i class='fa fa-save'></i> Simpan</button></td>
        </tr>";
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
        echo "</tbody></table></form>";
*/
?>
