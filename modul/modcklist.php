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
                    <div class="col-md-6">
                    <div class="input-group pull-right" style="width: 350px;">
                      <input type="text" name="table_search" class="form-control" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                        echo "<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' id='tomboltambahsub' onClick=\"window.location.href='?module=cklist&act=add'\"><i class='fa fa-plus'></i> Tambah CekList</button>";
                      echo '</div>
                    </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="content table-responsive">
                  <table class="table table-hover table-bordered table-striped">
                    <thead>
                      <th></th>
                      <th>Nama List</th>
                      <th width=10%>Jenis</th>
                      <th width=20%>Aksi</th></tr>
                    </thead>
                    <tbody>';

                  $sql = mysql_query("SELECT * FROM cklist");
                  $no=1;
                $jns = array(1=>'SPP-UP',2=>'SPP-GU',3=>'SPP-TU',4=>'SPP-LS',5=>'SPP-LS Gaji');
                while($dt = mysql_fetch_array($sql)) {
                  $Level = $dt[Jenis];
                  echo "<tr><td>".$no++."</td>
                          <td>$dt[nm_List]</td>
                          <td>$jns[$Level]</td>
                          <td class=align-center><a class='btn btn-minier btn-success' href='?module=cklist&act=edit&id=$dt[id_Cklist]'><i class='fa fa-edit fa-lg'></i> Edit</a>
                              <a class='btn btn-minier btn-danger' href='#'><i class='fa fa-trash-o fa-lg'></i> Hapus</a></td>
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
          echo "<form class='form-horizontal' method=post action='modul/act_modcklist.php?module=cklist&act=add'>";
            echo '<div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nama List</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="nm_List" required>'.$r['nm_List'].'</textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Jenis</label>
                <div class="col-sm-10">
                  <select class="form-control" name="Jenis">
                    <option value="">Pilih Jenis</option>';
                    $jns = array(1=>'SPP-UP',2=>'SPP-GU',3=>'SPP-TU',4=>'SPP-LS',5=>'SPP-LS Gaji');
                    foreach ($jns as $key => $value) {
                      if ($key == $r[Jenis]) {
                        echo "<option value='$key' selected>$value</option>";
                      } else {
                        echo "<option value='$key'>$value</option>";
                      }
                    }

                echo '</select></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Aktiv</label>
                <div class="col-sm-10">';

                echo "<input type=radio name='Aktiv' value='1' checked /> Y</label>
                      <label><input type=radio name='Aktiv' value='0' /> N</label>";
                echo "<input type='hidden' name='id_Cklist' value=$r[id_Cklistl] />";
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
    case "edit":
          $sql = mysql_query("SELECT * FROM cklist WHERE id_Cklist = '$_GET[id]'");
          $r = mysql_fetch_array($sql);

        echo '<div class="col-md-8">
            <div class="card">
              <div class="content">';
              echo "<form class='form-horizontal' method=post action='modul/act_modcklist.php?module=cklist&act=edit'>";
                echo '<div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Nama List</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="nm_List">'.$r['nm_List'].'</textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Jenis</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="Jenis">
                        <option value="">Pilih Jenis</option>';
                        $jns = array(1=>'SPP-UP',2=>'SPP-GU',3=>'SPP-TU',4=>'SPP-LS',5=>'SPP-LS Gaji');
                        foreach ($jns as $key => $value) {
                          if ($key == $r[Jenis]) {
                            echo "<option value='$key' selected>$value</option>";
                          } else {
                            echo "<option value='$key'>$value</option>";
                          }
                        }

                    echo '</select></div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Aktiv</label>
                    <div class="col-sm-10">';
                    $r[Aktiv] == "1" ? $checked1="checked" : $checked2="checked";
                    echo "<input type=radio name='Aktiv' value='1' $checked1 /> Y</label>
                          <label><input type=radio name='Aktiv' value='0' $checked2 /> N</label>";
                    echo '</div>
                  </div>
                  <hr>
                  <input type="hidden" name="id_Cklist" value="'.$r[id_Cklist].'" />
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
<script type="text/javascript">

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
$("#myTable").tablesorter({widgets: ['zebra'],
  headers: {7: {sorter: true}}
})
.tablesorterPager({container: $("#pager")});
</script>
