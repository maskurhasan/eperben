<?php
session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET[module],$_SESSION[Sessid]);
if($cek==1 OR $_SESSION[UserLevel]=='1') {
//----------------------------------
include "../config/koneksi.php";
include "../config/errormode.php";

include "modmaster.php";
  switch ($_GET[act]) {
    default:

        echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">';
                        echo "<button class='btn btn-sm btn-primary btn-fill pull-right' name='tambahsubdak' id='tomboltambahsub' onClick=\"window.location.href='?module=modul&act=add'\"><i class='fa fa-plus-circle'></i> Tambah Modul</button>";
                      echo '</div>
                  </div>
                </div><!-- /.box-header -->
                <div class="content table-responsive">
                  <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <th>#</th>
                        <th>Nama Modul</th><th>Link</th><th>Status</th>
                        <th>Level</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>';

                     $sql = mysql_query("SELECT * FROM modul");
                  $no=1;
                  while($dt = mysql_fetch_array($sql)) {

                  $lvl = array(1=>'Admin',2=>'Operator SKPD',3=>'Verifikator',4=>'BUD',5=>'OP.SP2D');
                  $Level = $dt[UserLevel];
                  echo "<tr><td>".$no++."</td>
                          <td>$dt[nm_Modul]</td>
                          <td>$dt[LinkModul]</td>
                          <td>$dt[AktivModul]</td>
                          <td>$lvl[$Level]</td>
                          <td class=align-center><a href='?module=modul&act=edit&id=$dt[id_Modul]'><i class='fa fa-edit fa-lg'></i> Edit</a>
                              <a href='#'><i class='fa fa-trash-o fa-lg'></i> Hapus</a></td>
                          </tr>";
                }
                  echo '<tbody></table>

                <div class="footer">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul>
                </div>
                </div>
              </div>
            </div>';

    break;
    case "add":

      echo '<div class="col-md-8">
            <div class="card">
              <div class="content">';
              echo "<form class='form-horizontal' method=post action='modul/act_modmodul.php?module=modul&act=add'>";
                echo '<div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Modul</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="nm_Modul">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Link Modul</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="LinkModul">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Level</label>
                    <div class="col-sm-10">
                      <select class="form-control" name=UserLevel  placeholder="pilih Level" id="id_BidUrusan">
                        <option value="">Pilih Level</option>';
                        $lvl = array(1=>'Admin',2=>'Operator SKPD',3=>'Verifikator',4=>'BUD',5=>'OP.SP2D');
                        foreach ($lvl as $key => $value) {
                            echo "<option value=$key>$key $value</option>";
                        }
                    echo '</div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Aktiv</label>
                    <div class="col-sm-10">
                      <input type=radio name=AktivModul value=Y checked=checked /> Y</label>
                      <input type=radio name=AktivModul value=N /> N</label>
                    </div>
                  </div>

                  <input class="btn btn-primary btn-fill pull-right" type="submit" name="simpan" value="Simpan" />
                  <input class="btn btn-info btn-fill" type="reset" value="Reset" />
                  <button class="btn btn-info btn-fill" type="reset" onClick="\'window.history.back()\'"><i class="fa fa-arrow-left"></i> Kembali</button>
              </div>
              </form>
              </div>
              </div>
              </div>';

    break;
    case "edit":
          $sql = mysql_query("SELECT * FROM modul WHERE id_Modul = '$_GET[id]'");
          $r = mysql_fetch_array($sql);



        echo '<div class="col-md-8">
            <div class="card">
              <div class="header">
              </div>
              <div class="content">';
              echo "<form method=post class='form-horizontal' action='modul/act_modmodul.php?module=modul&act=edit'>";
                echo '<div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Modul</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="nm_Modul" value="'.$r['nm_Modul'].'">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Link Modul</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="LinkModul"  value="'.$r['LinkModul'].'">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Level</label>
                    <div class="col-sm-10">
                      <select class="form-control" name=UserLevel  placeholder="pilih Level" id="id_BidUrusan">
                        <option value="">Pilih Level</option>';
                        $lvl = array(1=>'Admin',2=>'Operator SKPD',3=>'Verifikator',4=>'BUD',5=>'OP.SP2D');
                        foreach ($lvl as $key => $value) {
                          if ($key == $r[UserLevel]) {
                            echo "<option value='$key' selected>$value</option>";
                          }
                            echo "<option value='$key'>$value</option>";
                        }

                    echo '</div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Aktiv</label>
                    <div class="col-sm-10">';
                    $r[AktivModul] == "Y" ? $checked1="checked" : $checked2="checked";
                    echo "<input type=radio name=AktivModul value=Y $checked1 /> Y</label>
                          <label><input type=radio name=AktivModul value=N $checked2 /> N</label>";
                    echo "<input type='hidden' name='id_Modul' value=$r[id_Modul] />";
                    echo '</div>
                  </div>
                  <hr>
                  <input class="btn btn-primary btn-fill pull-right" type="submit" name="simpan" value="Simpan" />
                  <input class="btn btn-info btn-fill" type="reset" value="Reset" />
                  <button class="btn btn-info btn-fill" type="reset" onClick="\'window.history.back()\'"><i class="fa fa-arrow-left"></i> Kembali</button>
              </div>
              </form>
              </div>
              </div>
              </div>';

    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#myTable').DataTable();
});

function pilih_Urusan(id_Urusan)
{
  $.ajax({
        url: '../library/bidangurusan.php',
        data : 'id_Urusan='+id_Urusan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_BidUrusan').html(response);
        }
    });
}

function pilih_BidUrusan(id_BidUrusan)
{
  $.ajax({
        url: '../library/program.php',
        data : 'id_BidUrusan='+id_BidUrusan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Program').html(response);
        }
    });
}

function pilih_Program(id_Program)
{
  $.ajax({
        url: '../library/kegiatan.php',
        data : 'id_Program='+id_Program,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Kegiatan').html(response);
        }
    });
}



function pilih_Kegiatan(id_Kegiatan)
{
  $.ajax({
        url: '../library/nm_kegiatan.php',
        data : 'id_Kegiatan='+id_Kegiatan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#nm_Kegiatan').html(response);
        }
    });
}

function vw_tbl(id_BidUrusan)
{
  $.ajax({
    url: '../library/vw_skpd.php',
    data: 'id_BidUrusan='+id_BidUrusan,
    type: "post",
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#vw_skpd').html(response);
    }
    });
}
function pilih_Skpd(id_BidUrusan)
{
  $.ajax({
        url: '../library/skpd.php',
        data : 'id_BidUrusan='+id_BidUrusan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Skpd').html(response);
        }
    });
}
  //kembali
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});

</script>
