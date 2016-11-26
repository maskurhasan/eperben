<?php
session_start();

if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {

include "../config/koneksi.php";
include "../config/errormode.php";

include "modmaster.php";

  switch ($_GET['act']) {
    default:
          //----------------------------------
        //tentukan urusan skpd
        $q1 = mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");

        if($_SESSION['UserLevel']==1) {
         echo '<div class="col-md-6">
                    <div class="card">
                      <div class="content">';
                      echo "<form class='form-horizontal' method=post action='modul/act_moduser.php?module=user&act=add'>";
                        echo '<div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Urusan</label>
                            <div class="col-sm-10">';
                            echo "<select class='form-control' name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                                  <option selected>Pilih Urusan</option>";
                                  $q=mysql_query("SELECT * FROM urusan");
                                  while ($r=mysql_fetch_array($q)) {
                                    echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                                  }
                            echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">SKPD</label>
                            <div class="col-sm-10">';
                              echo "<select class='form-control' name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='vw_tbl(this.value);'>
                                <option value=#>Pilih Bid.Urusan</option></select>";
                              echo '</select>
                            </div>
                          </div>
                      </form>
                      </div>
                      </div>
                  </div>
              <div class="col-md-12" id="vw_skpd">
              </div>';
        } else {
          $q1 = mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
          $no=1;
          $result1 = mysql_query($sql1);

                      echo '<div class="col-md-8">
                        <div class="card">
                          <div class="header">
                            <p class="category">Data Profil SKPD</p>
                          </div>
                          <div class="content table-responsive">
                            <table class="table table-hover">
                              <thead>
                              <tr>
                                <th>Nama SKPD</th><th>APBD</th><th>DAK</th><th>APBN</th>
                              <th>Aksi</th></tr>
                              </thead>
                              <tbody>';

                            $no=1;
                            while($dt = mysql_fetch_array($q1)) {
                                echo "<tr>
                                        <td>$dt[nm_Skpd]</td>
                                        <td>".number_format($dt[apbd])."</td>
                                        <td>".number_format($dt[dak])."</td>
                                        <td>".number_format($dt[apbn])."</td>
                                        <td class=align-center><a href='?module=skpd&act=edit&id=$dt[id_Skpd]'><i class='fa fa-edit fa-lg'></i> Edit</a>
                                            </td>
                                        </tr>";
                              }
                            echo '<tbody></table>
                        </div>
                      </div>
                      </div>';
        }

    break;
    case "edit":
          if($_SESSION['UserLevel']==1) {
            $sql = mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_GET[id]'");
          } else {
            $sql = mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");

          }
          $r = mysql_fetch_array($sql);
          //parse id program k jd id
          $id_Urusan = substr($r[id_Program], 0,1);
          $id_BidUrusan = substr($r[id_Program], 0,3);


echo '<div class="col-md-8">
            <div class="card">
              <div class="content">';
              echo "<form method=post class='form-horizontal' action='modul/act_modskpd.php?module=skpd&act=edit'>";
                echo '<div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Kode SKPD</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="kd_Program" value="'.$r[id_Skpd].'">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Nama SKPD</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="nm_Skpd" value="'.$r[nm_Skpd].'">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Nama Pimpinan</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="nm_Kepala" value="'.$r[nm_Kepala].'">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Pangkat</label>
                    <div class="col-sm-10">';
                      echo "<select class='form-control' name=id_Pangkat  placeholder=Pangkat id=id_Pangkat onchange=''>";
                        $q=mysql_query("SELECT * FROM pangkat");
                        while ($rx=mysql_fetch_array($q)) {
                          if($rx[id_Pangkat] == $r[id_Pangkat]) {
                            echo "<option value='$rx[id_Pangkat]' selected>$rx[nm_Pangkat]</option>";
                          } else {
                            echo "<option value='$rx[id_Pangkat]'>$rx[nm_Pangkat]</option>";
                          }
                        }
                      echo '</select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">NIP</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="nip_Kepala" value="'.$r[nip_Kepala].'">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Eselon</label>
                    <div class="col-sm-10">';
                      echo "<select class='form-control' name='id_Eselon'  placeholder=Eselon id=id_Eselon onchange=''>";
                          $q=mysql_query("SELECT * FROM eselon");
                          while ($rx=mysql_fetch_array($q)) {
                            if($rx[id_Eselon] == $r[id_Eselon]) {
                              echo "<option value='$rx[id_Eselon]' selected>$rx[nm_Eselon]</option>";
                            } else {
                              echo "<option value='$rx[id_Eselon]'>$rx[nm_Eselon]</option>";
                            }
                          }
                      echo '</select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Visi dan Misi</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="visimisi" value="'.$r[visimisi].'">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">APBD</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="apbd" value="'.$r[apbd].'" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">DAK</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="dak" value="'.$r[dak].'" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">APBN</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="apbn" value="'.$r[apbn].'" />
                      <input type=hidden name=id_Skpd value="'.$r[id_Skpd].'">
                    </div>
                  </div>
                  <hr>
                <div class="box">
                  <input class="btn btn-primary btn-fill pull-right" type="submit" name="simpan" value=Simpan />
                  <input class="btn btn-info" type="reset" value=Reset />
                  <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
                </div><!-- /.box-footer -->
              </form>
              </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- row-->';


    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session
?>
<script type="text/javascript">

function pilih_Urusan(id_Urusan)
{
  $.ajax({
        url: 'library/bidangurusan.php',
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
    url: 'library/vw_skpd.php',
    data: 'id_BidUrusan='+id_BidUrusan,
    type: "post",
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#vw_skpd').html(response);
    }
    });
}



  //kembali
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});

</script>
