<?php
session_start();

if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION[UserLevel]=='1') {
//----------------------------------
include "../config/koneksi.php";
include "../config/errormode.php";

//include "modmaster.php";

  switch ($_GET[act]) {
    default:

      echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">';
                        if($_SESSION['UserLevel'] == 1) {
                          echo "<button class='btn btn-sm btn-primary btn-fill pull-right' name='tambahsubdak' onClick=\"window.location.href='?module=user&act=add'\"><i class='fa fa-plus-circle'></i> Tambah User</button>";
                        } else {
                          echo "";
                        }
                      echo '</div>
                  </div>
                </div>
                <div class="content table-responsive">
                  <table id="myTable" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                      <th></th><th>Nama Lengkap</th><th>Username</th>
                      <th>SKPD</th><th>Level</th><th>Status</th><th></th>
                    </tr>
                    </thead>
                    <tbody>';

                    //data yang ditampilkan pada halaman user sesuai dengan role
                    if($_SESSION['UserLevel']==1) {
                      //$sql = mysql_query("SELECT * FROM user a, skpd b WHERE a.id_Skpd = b.id_Skpd ");
                      $sql = mysql_query("SELECT * FROM user a
                                            LEFT JOIN skpd b
                                            ON a.id_Skpd = b.id_Skpd");
                                            //WHERE a.id_Skpd = b.id_Skpd");

                    } else {
                      $sql = mysql_query("SELECT * FROM user a
                                            LEFT JOIN skpd b
                                            ON a.id_Skpd = b.id_Skpd
                                            WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                                            AND a.UserLevel != 1
                                            AND a.id_User = '$_SESSION[id_User]'");

                    }
                    $no=1;
    				        while($dt = mysql_fetch_array($sql)) {
                      $Aktiv = $dt[Aktiv]==1 ? "Y" : "N";
                      $lvl = array(1=>'Admin',2=>'Operator SKPD',3=>'Verifikator',4=>'BUD',5=>'OP.SP2D');
                      $level = $dt['UserLevel'];

                      echo "<tr>
                              <td>".$no++."</td>
                              <td>$dt[nm_Lengkap]</td>
                              <td>$dt[UserName]</td>
                              <td>$dt[nm_Skpd]</td>
                              <td>$lvl[$level]</td>
                              <td>$Aktiv</td>
                              <td class=align-center><a class='btn btn-minier btn-primary' href='?module=user&act=edit&id=$dt[id_User]'><i class='fa fa-edit fa-lg'></i> Edit</a> ";
                              echo '</td>
                            </tr>';
                    }
                  echo '<tbody></table>
                </div>
              </div>
            </div>';
        //jika operator skpd


    break;
    case "add":
    //lempar jika hanya operator
    if($_SESSION[UserLevel]==3) {
       header('location:../main.php?module=user');
      //echo "MAAF ANDA BUKAN ADMIN";
    } else {
        if($_GET[error]==1) {
          echo '<div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Error!</strong>  Username yang diminta sudah ada.
              </div>';
        } else {
          echo "";
        }
    echo '<div class="col-md-8">
            <div class="card">
              <div class="content">';
              echo "<form class='form-horizontal' method=post action='modul/act_moduser.php?module=user&act=add'>";
                echo '
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Lengkap</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="nm_Lengkap" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">NIP</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="nip_Ppk" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Pangkat</label>
                    <div class="col-sm-10">
                      <select class="form-control" name=id_Pangkat  placeholder="Pangkat" id=id_Pangkat onchange="" required>';
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
                    <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                      <input class="form-control" type="text" name="UserName"  required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="PassWord" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Ulangi Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="PassWord2" required>
                    </div>
                  </div>';

                  echo '<div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Level</label>
                    <div class="col-sm-10">
                      <select class="form-control" name=UserLevel  placeholder="pilih Level" id=id_BidUrusan onchange="" required>
                        <option value="">Pilih Level</option>';
                        if($_SESSION['UserLevel']==1) {
                          $lvl = array(1=>'Admin',2=>'Operator SKPD',3=>'Verifikator',4=>'BUD',5=>'OP.SP2D');
                          foreach ($lvl as $key => $value) {
                            echo "<option value=$key>$key $value</option>";
                          }
                        } else {
                          echo '<option value="3" selected>3 Operator SKPD</option>';
                        }
                      echo '</select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Bidang Urusan</label>
                    <div class="col-sm-10">';
                    if($_SESSION['UserLevel']==1) {
                      $disabled = "";
                    } else {
                      $disabled = "disabled";
                    }
                      echo '<select class="form-control" name=id_BidUrusan placeholder=pilih id=id_BidUrusan onchange=\'pilih_Skpd(this.value);\' required '.$disabled.'>
                      <option selected>Pilih Urusan</option>';
                      $q=mysql_query("SELECT * FROM bidurusan");
                      while ($rx=mysql_fetch_array($q)) {
                        $id_BidUrusan1 = substr($rx[id_BidUrusan],-2);
                        echo "<option value=$rx[id_BidUrusan]>$id_BidUrusan1 $rx[nm_BidUrusan]</option>";
                      }
                      echo '</select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">SKPD</label>
                    <div class="col-sm-10">';
                    if($_SESSION['UserLevel']==1) {
                      echo '<select class="form-control" name=id_Skpd  placeholder=pilih Skpd id=id_Skpd required>
                      <option selected>Pilih Skpd</option>';
                    } else {
                      $q=mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
                      while ($rx=mysql_fetch_array($q)) {
                          echo "<select class=form-control name=id_Skpd  placeholder=pilih Skpd id=id_Skpd required>
                          <option value=$rx[id_Skpd] selected>$rx[nm_Skpd]</option>";
                      }
                    }
                      echo '</select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Aktiv</label>
                    <div class="col-sm-10">
                      <label><input type=radio name=Aktiv value=1 checked=checked  required/> Y</label>
                      <label><input type=radio name=Aktiv value=0  required/> N</label>
                    </div>
                  </div>';

                echo '<hr>
                <div class="box">
                  <div class="col-sm-2"></div>
                  <input class="btn btn-primary btn-fill" type="submit" name="simpan" value=Simpan />
                  <input class="btn btn-info" type="reset" value=Reset />
  				        <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
                </div><!-- /.box-footer -->
              </form>
              </div>
              </div>
            </div>';
        }

    break;
    case "edit":
          //bedakan jika diedit dari admin dengan user sendiri
          if($_SESSION[UserLevel]==1) {
            $sql = mysql_query("SELECT * FROM user WHERE id_User = '$_GET[id]'");
          } else {
            $sql = mysql_query("SELECT * FROM user WHERE id_User = '$_SESSION[id_User]'");
          }
          $r = mysql_fetch_array($sql);
        //ini pesan error
        if($_GET[error]==1) {
          echo '<div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Error!</strong>  Username yang diminta sudah ada.
              </div>';
        } else {
          echo "";
        }

        echo '<div class="col-md-8">
                  <div class="card">
                    <div class="content">';
                    echo "<form class='form-horizontal' method=post action='modul/act_moduser.php?module=user&act=edit'>";
                      echo '<div class="box-body">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Nama Lengkap</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="text" name="nm_Lengkap" value="'.$r['nm_Lengkap'].'" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">NIP</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="text" name="nip_Ppk" value="'.$r['nip_Ppk'].'" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Pangkat</label>
                          <div class="col-sm-10">
                            <select class="form-control" name=id_Pangkat  placeholder="Pangkat" id=id_Pangkat onchange=""  required>';
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
                          <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                          <div class="col-sm-10">
                            <input class="form-control" type="text" name="UserName" value="'.$r['UserName'].'" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="PassWord">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Ulangi Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="PassWord2">
                            <input type="hidden" class="form-control" name="UserLevel" value="'.$r[UserLevel].'">
                          </div>
                        </div>';
                //hanya untuk level admn
                if($_SESSION[UserLevel]==1) {
                        echo '<div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Level</label>
                          <div class="col-sm-10">
                            <select class="form-control" name=UserLevel  placeholder="pilih Level" id=id_BidUrusan onchange="" required>
                            <option value=#>Pilih Level</option>';
                            //$r['UserLevel'] == 1 ? $selected1="selected" : $selected2="selected";
                            $lvl = array(1=>'Admin',2=>'Operator SKPD',3=>'Verifikator',4=>'BUD',5=>'OP.SP2D');
                            foreach ($lvl as $key => $value) {
                              if($key == $r[UserLevel]) {
                                echo "<option value=$key selected>$key $value</option>";
                              } else {
                                echo "<option value=$key>$key $value</option>";
                              }
                            }

                            echo '</select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Bidang Urusan</label>
                          <div class="col-sm-10">';
                            if($_SESSION['UserLevel']==1) {
                              $disabled = "";
                            } else {
                              $disabled = "disabled";
                            }
                            echo '<select class="form-control" name=id_BidUrusan placeholder=pilih id=id_BidUrusan onchange=\'pilih_Skpd(this.value);\' required '.$disabled.'>
                            <option selected>Pilih Urusan</option>';
                            $q=mysql_query("SELECT * FROM bidurusan");
                            while ($rx=mysql_fetch_array($q)) {
                              $id_BidUrusan1 = substr($rx[id_BidUrusan],-2);
                              $id_BidUrusan2 = substr($r[id_Skpd],0,3);
                              if($rx[id_BidUrusan]==$id_BidUrusan2) {
                                echo "<option value=$rx[id_BidUrusan] selected> $id_BidUrusan1 $rx[nm_BidUrusan]</option>";
                              }else{
                                echo "<option value=$rx[id_BidUrusan]>$id_BidUrusan1 $rx[nm_BidUrusan]</option>";
                              }
                            }
                            echo '</select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">SKPD</label>
                          <div class="col-sm-10">
                            <select class="form-control" name=id_Skpd  placeholder=pilih Skpd id=id_Skpd required>';
                            if($_SESSION['UserLevel']==1) {
                              $q=mysql_query("SELECT * FROM skpd");
                            } else {
                              $q=mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
                            }
                              echo '<option value=#>Pilih SKPD</option>';
                              //$q=mysql_query("SELECT * FROM skpd");
                              while ($rx=mysql_fetch_array($q)) {
                                if($rx[id_Skpd]==$r[id_Skpd]) {
                                  echo "<option value=$rx[id_Skpd] selected>$rx[nm_Skpd]</option>";
                                }else{
                                  echo "<option value=$rx[id_Skpd]> $rx[nm_Skpd]</option>";
                                }
                              }
                            echo '</select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputPassword3" class="col-sm-2 control-label">Aktiv</label>
                          <div class="col-sm-10">';
                          $r[Aktiv] == 1 ? $checked1="checked" : $checked2="checked";
                            echo "<label><input type=radio name=Aktiv value=1 $checked1  required/> Y</label>
                            <label><input type=radio name=Aktiv value=0 $checked2  required/> N</label>";
                          echo '</div>
                        </div>
                      <hr>';
                      } else{
                        echo "<input type='hidden' name='Aktiv' value='1'>";
                      }
                      echo '<div class="box">
                        <div class="col-sm-2"></div>
                        <input type=hidden name=usernameawal value="'.$r['UserName'].'" />
                        <input type=hidden name=id_User value="'.$r['id_User'].'" />
                        <input type=hidden name=id_Skpd value="'.$r['id_Skpd'].'" />
                        <input class="btn btn-primary" type="submit" name="simpan" value=Simpan />
                        <input class="btn btn-info" type="reset" value=Reset />
                        <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
                      </div><!-- /.box-footer -->
                    </form>

                    </div>
                    </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- row-->';
    break;
    case "akses" :
          function ck_aksesmodul($id_Modul,$id_User,$Level) {
              $qrr = mysql_query("SELECT * FROM aksesmodul WHERE id_Modul = '$id_Modul' AND id_User = '$id_User'");
              $rqrr = mysql_fetch_array($qrr);
              $hit = mysql_num_rows($qrr);

              $checked = $hit == 1 ? "checked='checked'" : '';
              $type = $Level == 1 ? "class=checkbox1" : "class=checkbox2";
              //$ck = '<input type="checkbox" '.$type.' name="id_Modul[]" value="'.$id_Modul.'" '.$checked.'>';
              $ck = '<input type="checkbox" '.$type.' name="id_Modul[]" value="'.$id_Modul.'" $checked>';
              return $ck;
          }

      //cari data user yg sedang diedit
          $sql = "SELECT UserLevel FROM user WHERE id_User = '$_GET[id]'";
          $q=mysql_query($sql);
          $r=mysql_fetch_array($q);

      echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                  <h4 class="title">Daftar User</h4>
                  <p class="category">Akun dan Hak Akses Modul</p>
                </div><!-- /.box-header -->
                <div class="content">';
                echo "<form method=post action='modul/act_moduser.php?module=user&act=akses'>";
                      echo '<table class="table table-bordered">
                        <tr>
                        <th style=width:5%>#</th>
                        <th style=width:20%>Nama Modul</th><th style=width:25%>Link</th><th style=width:10%>Status</th>
                        <th style=width:15%>Level</th><th style=width:10%>Aksi</th>
                        </tr>';

                        if($r[UserLevel]==2) {
                          $sql = mysql_query("SELECT * FROM modul WHERE AktivModul='Y' AND UserLevel=2");
                        }elseif($r[UserLevel]==2){
                          $sql = mysql_query("SELECT * FROM modul WHERE AktivModul='Y' AND UserLevel=2 OR UserLevel=3");
                        }else{
                          $sql = mysql_query("SELECT * FROM modul WHERE AktivModul='Y'");
                        }
        				        $no=1;
                        while($dt = mysql_fetch_array($sql)) {
                          $akses = ck_aksesmodul($dt[id_Modul],$_GET[id],$dt[UserLevel]);
        					        $no % 2 === 0 ? $alt="alt" : $alt="";
                          $lvl = array(1=>'Admin',2=>'Operator SKPD',3=>'Verifikator',4=>'BUD',5=>'OP.SP2D');
                          $Level = $dt[UserLevel];
                          echo "<tr><td>".$no++."</td>
                                  <td>$dt[nm_Modul]</td>
                                  <td>$dt[LinkModul]</td>
                                  <td>$dt[AktivModul]</td>
                                  <td>$lvl[$Level]</td>
                                  <td class=align-center>$akses</td>
                                  </tr>";
                        }
                      echo '</table>

                    <input type=checkbox id=selecctall> Pilih Semua Operator<br />';
                     echo "<input type=hidden name=id_User value=$_GET[id]>
                     <input class='submit-green' type='submit' name='Simpan' value=Simpan />
                     <input class='submit-gray' type='reset' value=Reset />
                     <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>";
                  echo '</div>
                </div>
              </div>';
              echo "</form>";
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

$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });

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
function pilih_Skpd(id_BidUrusan)
{
  $.ajax({
        url: 'library/skpd.php',
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
