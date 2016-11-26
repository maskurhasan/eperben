<?php
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/fungsi_indotgl.php";
include "../config/errormode.php";


$postur = $_POST['id_SubKegiatan'];
$postur1 = $_POST['id_LampPermasalahan'];
if(!empty($postur1)) {
  //mengambil data dari tombol edit isi permasalahan
  $qi = mysql_query('SELECT * FROM lamppermasalahan WHERE id_LampPermasalahan = "'.$postur1.'"');
  $ri = mysql_fetch_array($qi);
  //data id_subkegiatan dari table lamppermasalahan
  $q = mysql_query('SELECT * FROM subkegiatan WHERE id_SubKegiatan = "'.$ri['id_SubKegiatan'].'"');
  $r = mysql_fetch_array($q);
  //ganti tombol
  $nmtombol = "edit";
} else {
  //data ditampilkan dari table
  $q = mysql_query('SELECT * FROM subkegiatan WHERE id_SubKegiatan = "'.$postur.'"');
  $r = mysql_fetch_array($q);
  $nmtombol = "masalah";
}
echo '<div class="card">
                <div class="header">
                  <h4 class="title">Permasalahan Kegiatan</h4>
                  <p class="category">Lampiran Realisasi Subkegiatan SKPD</p>
                </div>
              <div class="content" id="subkegiatan">';
              echo "<form method=post action='modul/act_modrealisasi.php?module=realisasi&act=masalah'>";
                  echo '<div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tanggal</label>
                        <input class="form-control" type="date" name="Tanggal" class="form-control" value="'.$ri['Tanggal'].'" placeholder="Tanggal">
                      </div>        
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Permasalahan</label>
                        <textarea class="form-control" name="nm_Permasalahan">'.$ri['nm_Permasalahan'].'</textarea>
                      </div>        
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Solusi</label><br />
                        <textarea class="form-control" name="nm_Solusi">'.$ri['nm_Solusi'].'</textarea>
                        <p>
                          <button type="submit" class="btn btn-info btn-fill btn-sm form-control pull-right" name="'.$nmtombol.'" value="simpan"><i class="fa fa-save"></i> Simpan</button>
                          <input type="hidden" name="id_SubKegiatan" value="'.$r['id_SubKegiatan'].'">
                          <input type="hidden" name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                          <input type="hidden" name="id_LampPermasalahan" value="'.$ri['id_LampPermasalahan'].'">
                          </p>
                      </div>        
                    </div>
                  </div>
                  </form>
                  <form method=post action="modul/act_modrealisasi.php?module=realisasi&act=masalah">
                   <input type="hidden" name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                  <div class="row">
                    <div class="col-md-4">
                      
                    </div>
                  </div>';
                $qc = mysql_query("SELECT * FROM lamppermasalahan a, subkegiatan b 
                                WHERE b.id_SubKegiatan = '$r[id_SubKegiatan]' 
                                AND a.id_SubKegiatan = b.id_SubKegiatan 
                                ORDER BY a.Tanggal DESC");
                $no=1;
                echo "<hr>";
                while($rt=mysql_fetch_array($qc)) {
                $id_sub = $rt['id_SubKegiatan'];
                echo '
                <div class="row">
                  <div class="col-md-12">
                    <div class="typo-line">
                      <p class="category">'.$rt['nm_Permasalahan'].'</p>
                    </div>
                    <div class="typo-line">      
                        <blockquote> 
                          <p class="category">'.$rt['nm_Solusi'].'<br>';
                          echo "<button class='btn btn-xs btn-info btn-fill' type='button' name='edit' value=$rt[id_LampPermasalahan] id=id_lamppermasalahan onClick='ax_edit_permasalahan(this.value)'><i class='fa fa-pencil'></i></button>"; 
                          echo '<button class="btn btn-xs btn-danger btn-fill" type="submit" name="delete" value="'.$rt['id_LampPermasalahan'].'" onclick="return confirm(\'yakin akan Hapus data\');"><i class="fa fa-trash"></i></button></p>
                          <small>'.tgl_indo($rt['Tanggal']).'</small>
                        </blockquote>
                    </div>
                    <hr>
                  </div>
                </div>';
                }
                echo '<div class="footer">
                  
                </div>
              </form>
              </div>
              </div>';


?>
<script type="text/javascript">
function ax_edit_permasalahan(id_LampPermasalahan)
{
  $.ajax({
    url: '../library/ax_permasalahan.php',
    data: 'id_LampPermasalahan='+id_LampPermasalahan,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}


</script>