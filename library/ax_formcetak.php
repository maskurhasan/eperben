<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/errormode.php";

//mengambil data desa
$postur = $_POST['id_Cetak'];

echo '<div class="card">
        <div class="header">
          <h4 class="title">Pilih Detail Laporan</h4>
          <p class="category"></p>
        </div>
        <div class="content"><hr>';
switch ($postur) {
    case 'register':
      echo "
              <form method=get class='form-horizontal' action='report/registerspm.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>SKPD</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=skpd placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Pilih SKPD</option>";
                    if($_SESSION[UserLevel]==1) {
                      $qx=mysql_query("SELECT * FROM skpd");
                    } else {
                      $qx=mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
                    }
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Skpd]>$rx[nm_Skpd]</option>";
                    }
                  echo "</select>
                </div>
              </div>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Jenis Laporan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=jnslap>
                    <option selected>Pilih Jenis Laporan</option>";
                    $jnslap = array('1' => 'Register SPM' , '2'=>'Register SP2D');
                    foreach ($jnslap as $key => $value) {
                      echo "<option value=$key>$value</option>";
                    }
                  echo "</select>
                </div>
              </div>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Status</label>
                <div class='col-sm-10'>";
                    $status = array(0=>'Draf',1=>'Final');
                  echo "<select name='StatusSpm' class='col-xs-10 col-sm-5' id='form-field-1'>
                      <option value=''>-Pilih Status-</option>";
                    foreach ($status as $key => $value) {
                        echo "<option value=$key>$value</option>";
                    }
                  echo "</select>
                </div>
              </div>";
              echo '<hr>
              <div>
                  <br>

              </div>';
              echo '<div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                      <button class="btn btn-info" type="submit" name="cetak">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Cetak
                      </button>

                      <button class="btn btn-info" type="" name="Excel">
                        <i class="ace-icon fa fa-file-excel-o bigger-110"></i>
                        Excel
                      </button>

                      <button class="btn btn-info" type="submit" name="cetak">
                        <i class="ace-icon fa fa-file-pdf-o bigger-110"></i>
                        PDF
                      </button>
                      <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                      </button>
                    </div>
                  </div>';
            echo '</form>';
  break;
	case 'realisasi':
      echo "<form method=get class='form-horizontal' action='report/rpt_realisasikeg.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>SKPD</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=skpd placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Pilih SKPD</option>";
                    if($_SESSION[UserLevel]==1) {
                      $qx=mysql_query("SELECT * FROM skpd");
                    } else {
                      $qx=mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
                    }
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Skpd]>$rx[nm_Skpd]</option>";
                    }
                  echo "</select>
                </div>
              </div>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Jenis Laporan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=jnslap>
                    <option selected>Pilih Jenis Laporan</option>";
                    $jnslap = array('1' => 'Realisasi Anggaran APBD' , '2'=>'Realisasi ...');
                    foreach ($jnslap as $key => $value) {
                      echo "<option value=$key>$value</option>";
                    }
                  echo "</select>
                </div>
              </div>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Status</label>
                <div class='col-sm-10'>";
                    $status = array(0=>'Draf',1=>'Final');
                  echo "<select name='StatusSpm' class='col-xs-10 col-sm-5' id='form-field-1'>
                      <option value=''>-Pilih Status-</option>";
                    foreach ($status as $key => $value) {
                        echo "<option value=$key>$value</option>";
                    }
                  echo "</select>
                </div>
              </div>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Bulan</label>
                <div class='col-sm-10'>";
                    $status = array(0=>'Draf',1=>'Final');
                  echo "<select name='bulan' class='col-xs-10 col-sm-5' id='form-field-1'>
                      <option value=''>-Pilih Bulan-</option>";
                    for ($i=1; $i <= 12; $i++) { 
                        echo "<option value=$i>$arrbln[$i]</option>";
                    }
                    
                  echo "</select>
                </div>
              </div>";
              echo '<hr>
              <div>
                  <br>

              </div>';
              echo '<div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                      <button class="btn btn-info" type="submit" name="cetak">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Cetak
                      </button>

                      <button class="btn btn-info" type="" name="Excel">
                        <i class="ace-icon fa fa-file-excel-o bigger-110"></i>
                        Excel
                      </button>

                      <button class="btn btn-info" type="submit" name="cetak">
                        <i class="ace-icon fa fa-file-pdf-o bigger-110"></i>
                        PDF
                      </button>
                      <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                      </button>
                    </div>
                  </div>';
            echo '</form>';    
  break;
  case 'kartukendali':
      echo "<form method=get class='form-horizontal' action='report/rpt_kartukendali.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>SKPD</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=skpd placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Pilih SKPD</option>";
                    if($_SESSION[UserLevel]==1) {
                      $qx=mysql_query("SELECT * FROM skpd");
                    } else {
                      $qx=mysql_query("SELECT * FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
                    }
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Skpd]>$rx[nm_Skpd]</option>";
                    }
                  echo "</select>
                </div>
              </div>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Jenis Laporan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=jnslap>
                    <option selected>Pilih Jenis Laporan</option>";
                    $jnslap = array('1' => 'Realisasi Anggaran APBD' , '2'=>'Realisasi ...');
                    foreach ($jnslap as $key => $value) {
                      echo "<option value=$key>$value</option>";
                    }
                  echo "</select>
                </div>
              </div>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Status</label>
                <div class='col-sm-10'>";
                    $status = array(0=>'Draf',1=>'Final');
                  echo "<select name='StatusSpm' class='col-xs-10 col-sm-5' id='form-field-1'>
                      <option value=''>-Pilih Status-</option>";
                    foreach ($status as $key => $value) {
                        echo "<option value=$key>$value</option>";
                    }
                  echo "</select>
                </div>
              </div>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Bulan</label>
                <div class='col-sm-10'>";
                    $status = array(0=>'Draf',1=>'Final');
                  echo "<select name='bulan' class='col-xs-10 col-sm-5' id='form-field-1'>
                      <option value=''>-Pilih Bulan-</option>";
                    for ($i=1; $i <= 12; $i++) { 
                        echo "<option value=$i>$arrbln[$i]</option>";
                    }
                    
                  echo "</select>
                </div>
              </div>";
              echo '<hr>
              <div>
                  <br>

              </div>';
              echo '<div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                      <button class="btn btn-info" type="submit" name="cetak">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Cetak
                      </button>

                      <button class="btn btn-info" type="" name="Excel">
                        <i class="ace-icon fa fa-file-excel-o bigger-110"></i>
                        Excel
                      </button>

                      <button class="btn btn-info" type="submit" name="cetak">
                        <i class="ace-icon fa fa-file-pdf-o bigger-110"></i>
                        PDF
                      </button>
                      <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                      </button>
                    </div>
                  </div>';
            echo '</form>';    
  break;
  case 'rfkviareaslisasi2':
        echo "<form method=get action='report/rfkviarealisasi2.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Kecamatan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Kecamatan</option>";
                    $qx=mysql_query("SELECT * FROM kecamatan");
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  echo "</select>
                </div>
                <label class='col-sm-2 control-label'>Desa</label>
                <div class='col-sm-4'>
                  <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select>
                </div>
              </div>";
              echo '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=bulan>
                    <option value=0>Pilih Bulan</option>";
                    foreach ($arrbln as $key => $value) {
                      echo "<option value=$key>$key $value</option>";
                    }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">PPK</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=id_Ppk>
                    <option value=0>Pilih PPK</option>";
                    $q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE UserLevel = '$_SESSION[UserLevel]'
                                      AND id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
                    while ($r=mysql_fetch_array($q)) {
                      echo "<option value=$r[id_User]>$r[nm_Lengkap]</option>";
                    }
                  echo '</select>
                </div>
              </div>
              <div class="footer">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-primary btn-fill" type="submit" name="view" value=view />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
            </form>';
    break;
    case 'perkeg':
        echo "<form method=get action='report/rpt_perkeg.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Kecamatan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Kecamatan</option>";
                    $qx=mysql_query("SELECT * FROM kecamatan");
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  echo "</select>
                </div>
                <label class='col-sm-2 control-label'>Desa</label>
                <div class='col-sm-4'>
                  <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select>
                </div>
              </div>";
              echo '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=bulan>
                    <option value=0>Pilih Bulan</option>";
                    foreach ($arrbln as $key => $value) {
                      echo "<option value=$key>$key $value</option>";
                    }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">PPK</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=id_Ppk>
                    <option value=0>Pilih PPK</option>";
                    $q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE UserLevel = '$_SESSION[UserLevel]'
                                      AND id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
                    while ($r=mysql_fetch_array($q)) {
                      echo "<option value=$r[id_User]>$r[nm_Lengkap]</option>";
                    }
                  echo '</select>
                </div>
              </div>
              <div class="footer">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-primary btn-fill" type="submit" name="view" value=view />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
            </form>';
     break;
    case 'profilkeg':
        echo "<form class='form-horizontal' method=post id=frm_tambah action=".htmlspecialchars('modul/act_modsubkegiatan.php?module=subkegiatan&act=add').">
              <div class=form-group>
                <label class='col-sm-2 control-label'>Kecamatan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Kecamatan</option>";
                    $qx=mysql_query("SELECT * FROM kecamatan");
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  echo "</select>
                </div>
                <label class='col-sm-2 control-label'>Desa</label>
                <div class='col-sm-4'>
                  <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select>
                </div>
              </div>";
              echo '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=bulan>
                    <option value=0>Pilih Bulan</option>";
                    foreach ($arrbln as $key => $value) {
                      echo "<option value=$key>$key $value</option>";
                    }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">PPK</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=id_Ppk>
                    <option value=0>Pilih PPK</option>";
                    $q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE UserLevel = '$_SESSION[UserLevel]'
                                      AND id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
                    while ($r=mysql_fetch_array($q)) {
                      echo "<option value=$r[id_User]>$r[nm_Lengkap]</option>";
                    }
                  echo '</select>
                </div>
              </div>
              <div class="footer">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-primary btn-fill" type="submit" name="view" value=view />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
            </form>';
     break;
    case 'peta':
        echo '<iframe src="https://www.google.com/maps/d/embed?mid=zxNMsvBDrM3w.kIxx4ejWeDRU" width="640" height="480"></iframe>';
        /*
        echo "<form class='form-horizontal' method=post id=frm_tambah action=".htmlspecialchars('modul/act_modsubkegiatan.php?module=subkegiatan&act=add').">
              <div class=form-group>
                <label class='col-sm-2 control-label'>Kecamatan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Kecamatan</option>";
                    $qx=mysql_query("SELECT * FROM kecamatan");
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  echo "</select>
                </div>
                <label class='col-sm-2 control-label'>Desa</label>
                <div class='col-sm-4'>
                  <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select>
                </div>
              </div>";
              echo '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=bulan>
                    <option value=0>Pilih Bulan</option>";
                    foreach ($arrbln as $key => $value) {
                      echo "<option value=$key>$key $value</option>";
                    }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">PPK</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=id_Ppk>
                    <option value=0>Pilih PPK</option>";
                    $q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE UserLevel = '$_SESSION[UserLevel]'
                                      AND id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
                    while ($r=mysql_fetch_array($q)) {
                      echo "<option value=$r[id_User]>$r[nm_Lengkap]</option>";
                    }
                  echo '</select>
                </div>
              </div>
              <div class="footer">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-primary btn-fill" type="submit" name="view" value=view />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
            </form>';
          */
     break;
     case 'chart':
        include "../system/report/chartmodel.php";
        /*
        echo "<form method=get action='report/chartmodel.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Kecamatan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Kecamatan</option>";
                    $qx=mysql_query("SELECT * FROM kecamatan");
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  echo "</select>
                </div>
                <label class='col-sm-2 control-label'>Desa</label>
                <div class='col-sm-4'>
                  <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select>
                </div>
              </div>";
              echo '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=bulan>
                    <option value=0>Pilih Bulan</option>";
                    foreach ($arrbln as $key => $value) {
                      echo "<option value=$key>$key $value</option>";
                    }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">PPK</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=id_Ppk>
                    <option value=0>Pilih PPK</option>";
                    $q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE UserLevel = '$_SESSION[UserLevel]'
                                      AND id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
                    while ($r=mysql_fetch_array($q)) {
                      echo "<option value=$r[id_User]>$r[nm_Lengkap]</option>";
                    }
                  echo '</select>
                </div>
              </div><hr>
              <div class="footer">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-primary btn-fill" type="button" name="view" id="id_Cetak" value=view  onClick="ax_form_view(this.value)"/>
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
            </form>';
        */
     break;
     case 'ringkasan':
        $qc = mysql_query("SELECT a.apbd,a.apbn,a.dak,SUM(b.AnggKeg) AS Anggaran
                    FROM skpd a, datakegiatan b
                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                    AND b.TahunAnggaran = '$_SESSION[thn_Login]'
                    AND a.id_Skpd = b.id_Skpd");
        $rc = mysql_fetch_array($qc);

        $qd = mysql_query("SELECT SUM(c.nl_Pagu) AS AnggaranSub
                    FROM skpd a,datakegiatan b,subkegiatan c
                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                    AND b.TahunAnggaran = '$_SESSION[thn_Login]'
                    AND a.id_Skpd = b.id_Skpd
                    AND b.id_DataKegiatan = c.id_DataKegiatan");
        $rd = mysql_fetch_array($qd);
        echo "<h3>Dinas Pekerjaan Umum</h3>";
        echo "<table class='table table-bordered' width=700px>
                <thead><tr><th rowspan=2></th><th rowspan=2>Anggaran</th><th colspan=2>Target</th><th colspan=2>Realisasi</th></tr>
                <tr>
                  <th>Fisik</th><th>Keuangan</th>
                  <th>Fisik</th><th>Keuangan</th></tr></thead>
                <tbody>
                <tr><td>APBD</td><td>".number_format($rc[apbd])."</td><td>".number_format($rc[Anggaran])."</td><td>".number_format($rd[AnggaranSub])."</td><td>xxx</td><td>Selisih</td></tr>
                <tr><td>DAK</td><td>".number_format($rc[dak])."</td><td>xxx</td><td>xxx</td><td>xxx</td><td>Selisih</td></tr>
                <tr><td>APBN</td><td>".number_format($rc[apbn])."</td><td>xxx</td><td>xxx</td><td>xxx</td><td>Selisih</td></tr>
                </tbody>
                </table>";
        echo "<div class='row'>
          <div class='col-sm-6'>
            <div id='chartActivity' class='ct-chart'></div>

              <div class='footer'>
                <div class='legend'>
                  <i class='fa fa-circle text-info'></i> Tesla Model S
                  <i class='fa fa-circle text-danger'></i> BMW 5 Series
                </div>
                <hr>
                <div class='stats'>
                  <i class='fa fa-check'></i> Data information certified
                </div>
              </div>
          </div>
        </div>";

        echo '<form>
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label>Company (disabled)</label>
                <input type="text" class="form-control" disabled placeholder="Company" value="Creative Code Inc.">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" placeholder="Username" value="michael23">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" placeholder="Email">
              </div>
            </div>
          </div>
        </form>';
     break;

   default:
              echo "<form class='form-horizontal' method=post action='modul/act_moduser.php?module=user&act=add'>";
                        echo '<div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Urusan</label>
                            <div class="col-sm-4">';
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
                            <label for="inputPassword3" class="col-sm-2 control-label">Bidang</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                                <option value=#>Pilih Bid.Urusan</option></select>";
                              echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Program</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=id_Program id=id_Program onchange='pilih_program(this.value);'>
                                <option value=#>Pilih Program</option></select>";
                              echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Kegiatan</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=id_Kegiatan id=nm_Kegiatan onchange='pilih_Kegiatan(this.value);'>
                                <option value=#>Pilih Kegiatan</option></select>";
                              echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                            <div class="col-sm-4">';
                              echo "<select class=form-control name=bulan>
                              <option value=0>Pilih Bulan</option>";
                              foreach ($arrbln as $key => $value) {
                                echo "<option value=$key>$key $value</option>";
                              }
                            echo '</select>
                            </div>
                          </div>
                      </form>
                <div class="footer">
                  <input class="btn btn-primary btn-fill pull-right" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
              </form>';
     break;
}
echo '</div>
      </div>
      <div class="row">
        <div class="col-md-10" id="view">
        </div>
      </div>';

?>
<script type="text/javascript">
function ax_form_view(id_View)
{
  $.ajax({
    url: '../library/ax_formcetak.php',
    data: 'id_Cetak='+id_Cetak,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#view').html(response);
        }
    });
}

</script>
