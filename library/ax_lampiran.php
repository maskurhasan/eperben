<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/errormode.php";

//mengambil data desa
$postur = $_POST['id_SubKegiatan'];
$postur1 = $_POST['id_LampRealisasi'];
if(!empty($postur1)) {
  //mengambil data dari tombol edit isi permasalahan
  $qi = mysql_query('SELECT * FROM lamprealisasi WHERE id_LampRealisasi = "'.$postur1.'"');
  $ri = mysql_fetch_array($qi);
  //data id_subkegiatan dari table lamppermasalahan
  $q = mysql_query('SELECT * FROM subkegiatan WHERE id_SubKegiatan = "'.$ri['id_SubKegiatan'].'"');
  $r = mysql_fetch_array($q);
  //ganti tombol
  $nmtombol = "edit";
  $nmket = "Simpan";
  $chgtype = "text";
} else {
  //data ditampilkan dari table
  $q = mysql_query('SELECT * FROM subkegiatan WHERE id_SubKegiatan = "'.$postur.'"');
  $r = mysql_fetch_array($q);
  $nmtombol = "upload";
  $nmket = "Upload";
  $chgtype = "file";
}

echo '<div class="card">
                <div class="header">
                  <h4 class="title">Dokumentasi Kegiatan</h4>
                  <p class="category">Lampiran Realisasi Subkegiatan SKPD</p>
                </div>
              <div class="content" id="subkegiatan">';
              echo "<form method=post action='modul/act_modrealisasi.php?module=realisasi&act=addlamp' enctype='multipart/form-data'>";
                  echo '<div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Foto</label>
                        <input class="form-control" type="'.$chgtype.'" name="nm_LampRealisasi" id="nm_LampRealisasi" accept="image/*" value="'.$ri['nm_LampRealisasi'].'">
                      </div>        
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="Caption" placeholder="Keterangan" value="'.$ri['Caption'].'">
                        <input type="hidden" name="id_SubKegiatan" value="'.$r['id_SubKegiatan'].'">
                        <input type="hidden" name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                        <input type="hidden" name="id_LampRealisasi" value="'.$ri['id_LampRealisasi'].'">
                      </div>        
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-info btn-fill btn-sm form-control" name="'.$nmtombol.'" value="simpan"><i class="fa fa-upload"></i> Upload</button>
                      </div>        
                    </div>
                  </div>
                  </form>';
                $qc = mysql_query("SELECT * FROM lamprealisasi a, subkegiatan b 
                                WHERE b.id_SubKegiatan = '$r[id_SubKegiatan]' 
                                AND a.id_SubKegiatan = b.id_SubKegiatan 
                                ORDER BY a.id_LampRealisasi");
                $no=1;
                while($rt=mysql_fetch_array($qc)) {
                $id_sub = $rt['id_SubKegiatan'];
                $no%2 == 1? $row = "<hr><div class=row>" : $row = "";
                $no%2 == 0  ? $end = "</div>" : $end = "";
                echo '
                '.$row.'<form method=post action="modul/act_modrealisasi.php?module=realisasi&act=addlamp">
                  <div class="col-md-6">
                    <div class="media">
                      <div class="media-left">
                        <a href="../img/lampiran/'.$rt['nm_LampRealisasi'].'" target="_blank">
                          <img class="media-object" src="../img/lampiran/'.$rt['nm_LampRealisasi'].'" alt="..." height="100" width="100">
                        </a>
                      </div>
                      <div class="media-body">
                        <h5 class="media-heading">Lampiran '.$no++.'</h5>
                        '.$rt['Caption'].'<br>
                        <input type="hidden" name="id_LampRealisasi" value="'.$rt['id_LampRealisasi'].'">
                        <input type="hidden" name="nm_LampRealisasi" value="'.$rt['nm_LampRealisasi'].'">
                        <input type="hidden" name="id_DataKegiatan" value="'.$rt['id_DataKegiatan'].'">';
                        echo "<button class='btn btn-xs btn-info btn-fill' type='button' name='edit' value=$rt[id_LampRealisasi] id=id_LampRealisasi onClick='ax_edit_lampiran(this.value)'><i class='fa fa-pencil'></i></button>"; 
                        echo '<button class="btn btn-xs btn-danger btn-fill" type="submit" name="delete" value="hapus" onclick="return confirm(\'yakin akan Hapus data\');"><i class="fa fa-trash"></i></button>
                      </div>
                    </div>
                  </div>
                  </form>
                  
                '.$end.'';
                }
          echo '<div class="footer">
                  
                </div>
              </form>
              </div>
              </div>';


?>
<script type="text/javascript">
function ax_edit_lampiran(id_LampRealisasi)
{
  $.ajax({
    url: '../library/ax_lampiran.php',
    data: 'id_LampRealisasi='+id_LampRealisasi,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}


</script>