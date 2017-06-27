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
include "../config/fungsi.php";

  switch ($_GET[act]) {
    default:

        echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">';
                        echo "<button class='btn btn-sm btn-primary btn-fill pull-right' name='tambahsubdak' id='tomboltambahsub' onClick=\"window.location.href='?module=datausaha&act=add'\"><i class='fa fa-plus-circle'></i> Tambah Perusahaan</button>";
                      echo '</div>
                  </div>
                </div><!-- /.box-header -->
                <div class="content table-responsive">
                  <table id="myTable" class="table table-hover table-bordered table-striped">
                    <thead>
                      <th></th>
                      <th>Nama Usaha</th>
                      <th width=20%>Pimpinan</th>
                      <th width=20%>Aksi</th></tr>
                    </thead>
                    <tbody>';

                  $sql = mysql_query("SELECT * FROM datausaha");
                  $no=1;

                while($dt = mysql_fetch_array($sql)) {
                  $Level = $dt[Jenis];
                  echo "<tr><td>".$no++."</td>
                          <td>$dt[nm_Usaha]</td>
                          <td>$dt[Pimpinan]</td>
                          <td class=align-center><a class='btn btn-minier btn-success' href='?module=datausaha&act=edit&id=$dt[id_Usaha]'><i class='fa fa-edit fa-lg'></i> Edit</a>
                              <a class='btn btn-minier btn-danger' href='modul/act_moddatausaha.php?act=delete&module=datausaha&id=$dt[id_Usaha]' onclick=\"javascript: return confirm('Anda yakin hapus ?')\"><i class='fa fa-trash-o fa-lg'></i> Hapus</a></td>
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
          echo "<form class='form-horizontal' method=post action='modul/act_moddatausaha.php?module=datausaha&act=add'>";
            echo '<div class="box-body">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nama Usaha</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="nm_Usaha" required value="'.$r['nm_Usaha'].'">
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Alamat Lengkap</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="AlamatLengkap" required value="'.$r['AlamatLengkap'].'">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="form-field-1">Kabupaten</label>
                <div class="col-sm-3">
                    <select class="form-control" name="id_Provinsi" id="id_Provinsi1" onchange="pilih_provinsi1(this.value);">
                  <option value="">Pilih Provinsi</option>';
                $qp = mysql_query("SELECT * FROM ref_provinsi WHERE id_Provinsi = 73");
                $id_Provinsi = substr($r[id_Desa], 0, 2);
                while ($rp = mysql_fetch_array($qp)) {
                      if($rp[id_Provinsi] == $id_Provinsi) {
                        echo '<option value="'.$rp[id_Provinsi].'" selected>'.$rp[nm_Provinsi].'</option>';
                      } else {
                        echo '<option value="'.$rp[id_Provinsi].'">'.$rp[nm_Provinsi].'</option>';
                      }
                    }
                echo '</select>
                </div>
                <div class="col-sm-3">
                  <select class="form-control" name="id_KabKota" id="id_KabKota1" onchange="pilih_kabkota1(this.value);">
                    <option value="">Luwu Utara</option>';

                    $qp = mysql_query("SELECT * FROM ref_kabkota WHERE id_KabKota='$id_Provinsi'");
                    $id_KabKota = substr($r[id_Desa], 0, 4);
                    while ($rp = mysql_fetch_array($qp)) {
                      if($rp[id_KabKota] == $id_KabKota) {
                        echo '<option value="'.$rp[id_KabKota].'" selected>'.$rp[nm_KabKota].'</option>';
                      } else {
                        echo '<option value="'.$rp[id_KabKota].'">'.$rp[nm_KabKota].'</option>';
                      }
                    }

                  echo '</select>
                </div>
                <div class="col-sm-3">
                  <select class="form-control" name="id_Kecamatan" id="id_Kecamatan1" onchange="pilih_kecamatan1(this.value);">
                    <option value="">Kecamatan</option>';
                    $qp = mysql_query("SELECT * FROM ref_kecamatan WHERE id_KabKota = 7322");
                    $id_Kecamatan = substr($r[id_Desa], 0, 7);
                    while ($rp = mysql_fetch_array($qp)) {
                      if($rp[id_Kecamatan] == $id_Kecamatan) {
                        echo '<option value="'.$rp[id_Kecamatan].'" selected>'.$rp[nm_Kecamatan].'</option>';
                      } else {
                        echo '<option value="'.$rp[id_Kecamatan].'">'.$rp[nm_Kecamatan].'</option>';
                      }
                    }
                  echo '</select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="form-field-1">Desa</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_Desa" id="id_Desa1">
                    <option value="">Desa</option>';
                    $qp = mysql_query("SELECT * FROM ref_desa WHERE id_Kecamatan = '$id_Kecamatan'");
                    while ($rp = mysql_fetch_array($qp)) {
                      if($rp[id_Desa] == $r[id_Desa]) {
                        echo '<option value="'.$rp[id_Desa].'" selected>'.$rp[nm_Desa].'</option>';
                      } else {
                        echo '<option value="'.$rp[id_Desa].'">'.$rp[nm_Desa].'</option>';
                      }
                    }
                  echo '</select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Pimpinan</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="Pimpinan" required value="'.$r['Pimpinan'].'">
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">Jabatan</label>
                <div class="col-sm-5">
                  <input class="form-control" type="text" name="Jabatan" value="'.$r[Jabatan].'">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Rek. Bank</label>
                <div class="col-sm-4">';
                  echo "<select class='form-control' name='Bank' onchange=''>";

                      foreach ($arrBank as $key => $value) {
                        if($key == $r[Bank]) {
                          echo "<option value='$key' selected>$value</option>";
                        } else {
                          echo "<option value='$key'>$value</option>";
                        }
                      }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">No. Rek</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" name="NoRek" value="'.$r[NoRek].'">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">NPWP</label>
                <div class="col-sm-10">
                  <input class="form-control" type="text" name="Npwp" value="'.$r[Npwp].'">
                </div>
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
          $sql = mysql_query("SELECT * FROM datausaha WHERE id_Usaha = '$_GET[id]'");
          $r = mysql_fetch_array($sql);


              echo '<div class="col-md-8">
                  <div class="card">
                    <div class="content">';
                    echo "<form class='form-horizontal' method=post action='modul/act_moddatausaha.php?module=datausaha&act=edit'>";
                      echo '<div class="box-body">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Nama Usaha</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="nm_Usaha" required value="'.$r['nm_Usaha'].'">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Alamat Lengkap</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="AlamatLengkap" required value="'.$r['AlamatLengkap'].'">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="form-field-1">Kabupaten</label>
                          <div class="col-sm-3">
                              <select class="form-control" name="id_Provinsi" id="id_Provinsi1" onchange="pilih_provinsi1(this.value);">
                            <option value="">Pilih Provinsi</option>';
                          $qp = mysql_query("SELECT * FROM ref_provinsi WHERE id_Provinsi = 73");
                          $id_Provinsi = substr($r[id_Desa], 0, 2);
                          while ($rp = mysql_fetch_array($qp)) {
                                if($rp[id_Provinsi] == $id_Provinsi) {
                                  echo '<option value="'.$rp[id_Provinsi].'" selected>'.$rp[nm_Provinsi].'</option>';
                                } else {
                                  echo '<option value="'.$rp[id_Provinsi].'">'.$rp[nm_Provinsi].'</option>';
                                }
                              }
                          echo '</select>
                          </div>
                          <div class="col-sm-3">
                            <select class="form-control" name="id_KabKota" id="id_KabKota1" onchange="pilih_kabkota1(this.value);">
                              <option value="">Luwu Utara</option>';

                              $qp = mysql_query("SELECT * FROM ref_kabkota WHERE id_KabKota='$id_Provinsi'");
                              $id_KabKota = substr($r[id_Desa], 0, 4);
                              while ($rp = mysql_fetch_array($qp)) {
                                if($rp[id_KabKota] == $id_KabKota) {
                                  echo '<option value="'.$rp[id_KabKota].'" selected>'.$rp[nm_KabKota].'</option>';
                                } else {
                                  echo '<option value="'.$rp[id_KabKota].'">'.$rp[nm_KabKota].'</option>';
                                }
                              }

                            echo '</select>
                          </div>
                          <div class="col-sm-3">
                            <select class="form-control" name="id_Kecamatan" id="id_Kecamatan1" onchange="pilih_kecamatan1(this.value);">
                              <option value="">Kecamatan</option>';
                              $qp = mysql_query("SELECT * FROM ref_kecamatan WHERE id_KabKota = 7322");
                              $id_Kecamatan = substr($r[id_Desa], 0, 7);
                              while ($rp = mysql_fetch_array($qp)) {
                                if($rp[id_Kecamatan] == $id_Kecamatan) {
                                  echo '<option value="'.$rp[id_Kecamatan].'" selected>'.$rp[nm_Kecamatan].'</option>';
                                } else {
                                  echo '<option value="'.$rp[id_Kecamatan].'">'.$rp[nm_Kecamatan].'</option>';
                                }
                              }
                            echo '</select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="form-field-1">Desa</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="id_Desa" id="id_Desa1">
                              <option value="">Desa</option>';
                              $qp = mysql_query("SELECT * FROM ref_desa WHERE id_Kecamatan = '$id_Kecamatan'");
                              while ($rp = mysql_fetch_array($qp)) {
                                if($rp[id_Desa] == $r[id_Desa]) {
                                  echo '<option value="'.$rp[id_Desa].'" selected>'.$rp[nm_Desa].'</option>';
                                } else {
                                  echo '<option value="'.$rp[id_Desa].'">'.$rp[nm_Desa].'</option>';
                                }
                              }
                            echo '</select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Pimpinan</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" name="Pimpinan" required value="'.$r['Pimpinan'].'">
                          </div>
                          <label for="inputPassword3" class="col-sm-2 control-label">Jabatan</label>
                          <div class="col-sm-5">
                            <input class="form-control" type="text" name="Jabatan" value="'.$r[Jabatan].'">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Rek. Bank</label>
                          <div class="col-sm-4">';
                            echo "<select class='form-control' name='Bank' onchange=''>";

                                foreach ($arrBank as $key => $value) {
                                  if($key == $r[Bank]) {
                                    echo "<option value='$key' selected>$value</option>";
                                  } else {
                                    echo "<option value='$key'>$value</option>";
                                  }
                                }
                            echo '</select>
                          </div>
                          <label for="inputPassword3" class="col-sm-2 control-label">No. Rek</label>
                          <div class="col-sm-4">
                            <input class="form-control" type="text" name="NoRek" value="'.$r[NoRek].'">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">NPWP</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="text" name="Npwp" value="'.$r[Npwp].'">
                          </div>
                        </div>
                        <hr>
                        <input type="hidden" name="id_Usaha" value="'.$r[id_Usaha].'">
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
$("#myTable").tablesorter({widgets: ['zebra'],
  headers: {7: {sorter: true}}
})
.tablesorterPager({container: $("#pager")});
</script>
