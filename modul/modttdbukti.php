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
                          echo "<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=ttdbukti&act=add'\"><i class='fa fa-plus'></i> Tambah User</button>";
                        echo '</div>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="content table-responsive">
                    <table id="tabledata" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th>Nama</th><th>NIP</th>
                        <th>Jabatan</th><th></th>
                      </tr>
                      </thead>
                      <tbody>';

                      //data yang ditampilkan pada halaman user sesuai dengan role
                      if($_SESSION['UserLevel']==1) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM ttdbukti a, skpd b
                                            WHERE a.id_Skpd = b.id_Skpd");
                      } else {
                        $sql= mysql_query("SELECT * FROM ttdbukti
                                            WHERE id_Skpd = '$_SESSION[id_Skpd]'");
                      }
                      $no=1;
      				        while($dt = mysql_fetch_array($sql)) {
                        $jns_jabatan = array(1=>'Kepala SKPD',2=>'Pejabat Penatausahaan Keuangan (PPK)',3=>'Bendahara',4=>'Pejabat Pelaksana Teknis Kegiatan (PPTK)');

                        $jbt = $dt['Jabatan'];

                        echo "<tr>
                                <td>$dt[NamaTtd]</td>
                                <td>$dt[Nip]</td>
                                <td>$jns_jabatan[$jbt]</td>
                                <td class=align-center><a href='?module=ttdbukti&act=edit&id=$dt[id]'><i class='fa fa-edit fa-lg'></i> Edit</a> ";
                                    echo "<a href='#'><i class='fa fa-tasks fa-trash-o'></i> Hapus</a>";

                                echo '</td>
                              </tr>';
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
    case "edit":
          if($_SESSION['UserLevel']==1) {
            $sql = mysql_query("SELECT * FROM ttdbukti
                                  WHERE id = '$_GET[id]'");
          } else {
            $sql = mysql_query("SELECT * FROM ttdbukti WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                          AND id= '$_GET[id]'");
          }
          $r = mysql_fetch_array($sql);

          echo '<form class="form-horizontal" method="post" role="form" action="modul/act_modttdbukti.php?module=ttdbukti&act=edit">
                    <div class="form-group">
                      <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama </label>
                      <div class="col-sm-10">
                        <input type="text" id="form-field-1" name="NamaTtd" placeholder="Nama" class="col-xs-10 col-sm-5" value="'.$r[NamaTtd].'" required/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> NIP </label>
                      <div class="col-sm-10">
                        <input type="text" id="form-field-1" placeholder="NIP" name="Nip" class="col-xs-10 col-sm-5" value="'.$r[Nip].'"  required/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pangkat </label>
                      <div class="col-sm-10">';
                      $qx = mysql_query("SELECT * FROM pangkat");
                      echo "<select name='id_Pangkat' class='col-xs-10 col-sm-5' id='form-field-1' required>
                              <option value=''>-Pilih Pangkat-</option>";
                            while ($rx = mysql_fetch_array($qx)){
                              if($rx[id_Pangkat]==$r[id_Pangkat]) {
                                echo "<option value=$rx[id_Pangkat] selected>$rx[nm_Pangkat]</option>";
                              } else {
                                echo "<option value=$rx[id_Pangkat]>$rx[nm_Pangkat]</option>";
                              }
                            }
                      echo "</select>";
                      echo '</div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jabatan </label>
                      <div class="col-sm-10">';
                      $jns_jabatan = array(1=>'Kepala SKPD',2=>'Pejabat Penatausahaan Keuangan (PPK)',3=>'Bendahara',4=>'Pejabat Pelaksana Teknis Kegiatan (PPTK)');
                      echo "<select name='Jabatan' class='col-xs-10 col-sm-5' id='form-field-1'  required>
                              <option value=''>-Pilih Jabatan-</option>";
                            foreach ($jns_jabatan as $key => $value) {
                              if($key == $r[Jabatan]) {
                                echo "<option value=$key selected>$value</option>";
                              } else {
                                echo "<option value=$key>$value</option>";
                              }
                            }
                      echo "</select>";
                      echo '</div>
                    </div>';
                    //cari value id_Skpd
                    if($_SESSION['UserLevel']==1) {
                      echo '<div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> SKPD </label>
                        <div class="col-sm-10">';
                        $qx = mysql_query("SELECT * FROM skpd");
                        echo "<select name='id_Skpd' class='col-xs-10 col-sm-5' id='form-field-1' required>
                                <option value=''>-Pilih SKPD-</option>";
                              while ($rx = mysql_fetch_array($qx)){
                                if($rx[id_Skpd] == $r[id_Skpd]) {
                                  echo "<option value=$rx[id_Skpd] selected>$rx[nm_Skpd]</option>";
                                } else {
                                  echo "<option value=$rx[id_Skpd]>$rx[nm_Skpd]</option>";
                                }
                              }
                        echo "</select>";
                        echo '</div>
                      </div>';
                    } else {
                      echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
                    }
                    echo "<input type='hidden' name='id' value='$r[id]'>";
                    echo '<div class="clearfix form-actions">
                      <div class="col-md-offset-3 col-md-9">
                        <button class="btn btn-info" type="submit">
                          <i class="ace-icon fa fa-check bigger-110"></i>
                          Simpan
                        </button>

                        &nbsp; &nbsp; &nbsp;
                        <button class="btn" type="reset">
                          <i class="ace-icon fa fa-undo bigger-110"></i>
                          Reset
                        </button>
                      </div>
                    </div>

                    <div class="hr hr-24"></div>
                    </form>';



  break;
	case "add" :
		    echo '<form class="form-horizontal" method="post" role="form" action="modul/act_modttdbukti.php?module=ttdbukti&act=add">
                  <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama </label>
                    <div class="col-sm-10">
                      <input type="text" id="form-field-1" name="NamaTtd" placeholder="Nama" class="col-xs-10 col-sm-5"  required/>
                    </div>
                  </div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> NIP </label>
										<div class="col-sm-10">
											<input type="text" id="form-field-1" placeholder="NIP" name="Nip" class="col-xs-10 col-sm-5"  required/>
										</div>
									</div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pangkat </label>
                    <div class="col-sm-10">';
                    $q = mysql_query("SELECT * FROM pangkat");
                    echo "<select name='id_Pangkat' class='col-xs-10 col-sm-5' id='form-field-1' required>
                            <option value=''>-Pilih Pangkat-</option>";
                          while ($r = mysql_fetch_array($q)){
                            echo "<option value=$r[id_Pangkat]>$r[nm_Pangkat]</option>";
                          }
                    echo "</select>";
                    echo '</div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jabatan </label>
                    <div class="col-sm-10">';
                    $jns_jabatan = array(1=>'Kepala SKPD',2=>'Pejabat Penatausahaan Keuangan (PPK)',3=>'Bendahara',4=>'Pejabat Pelaksana Teknis Kegiatan (PPTK)');
                    echo "<select name='Jabatan' class='col-xs-10 col-sm-5' id='form-field-1' required>
                            <option value=''>-Pilih Jabatan-</option>";
                          foreach ($jns_jabatan as $key => $value) {
                            echo "<option value=$key>$value</option>";
                          }
                    echo "</select>";
                    echo '</div>
                  </div>';
                  //cari value id_Skpd
                  if($_SESSION['UserLevel']==1) {
                    echo '<div class="form-group">
                      <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> SKPD </label>
                      <div class="col-sm-10">';
                      $q = mysql_query("SELECT * FROM skpd");
                      echo "<select name='id_Pangkat' class='col-xs-10 col-sm-5' id='form-field-1' required>
                              <option value=''>-Pilih SKPD-</option>";
                            while ($r = mysql_fetch_array($q)){
                              echo "<option value=$r[id_Skpd]>$r[nm_Skpd]</option>";
                            }
                      echo "</select>";
                      echo '</div>
                    </div>';
                  } else {
                    echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
                  }
									echo '<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												Simpan
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												Reset
											</button>
										</div>
									</div>

									<div class="hr hr-24"></div>
                  </form>

								';

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
