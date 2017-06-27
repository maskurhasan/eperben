<?php
session_start();

if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {

//include "../config/koneksi.php";
//include "../config/errormode.php";



  switch ($_GET['act']) {
    default:
        echo '<div class="col-md-12">
                <div class="card">
                  <div class="header">
                    <div class="row">
                      <div class="col-md-6">';

                      //tombol tambah dari submit form...
                      //cari ID akun
                        $query = mysql_query("SELECT MAX(id_Spm) AS maxID
                                                  FROM spm");
                        $data = mysql_fetch_array($query);
                        $idMax = $data['maxID'];
                        $noUrut = (int) substr($idMax, 1,5);
                        $noUrut++;
                        $newID = sprintf("%05s",$noUrut);
                        //$id_Spm = $newID;
                        $id_Spm = $idMax + 1;

                      echo "<form method='post' action='modul/act_modspm.php?module=spm&act=pre'>
                            <input type='hidden' value='$id_Spm' name='id'>
                          <button class='btn btn-sm btn-primary btn-fill' name='tbh_spm' type='submit' onclick=\"javascript: return confirm('Tambah SPM ?')\"><i class='fa fa-plus'></i> Tambah SPM</button>
                          </form>";

                      //echo "<button class='btn btn-sm btn-warning btn-fill' name='tbh_spm' type='submit' onClick=\"window.location.href='?module=spm&act=add'\"><i class='fa fa-plus'></i> Tambah SPM</button>";

                      echo '</div>
                      <div class="col-md-6">
                      <div class="input-group pull-right" style="width: 350px;">
                        <div class="input-group-btn">
                          ';

                        echo '</div>
                      </div>

                    </div>
                  </div>
                  <div class="content table-responsive">
                    <table id="myTable" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr class="info">
                        <th>ID</th><th>Nomor</th><th>Tanggal</th>
                        <th>Jenis</th><th>Nilai SPM</th><th>Status</th><th></th>
                      </tr>
                      </thead>
                      <tbody>';
                      function totalspm($id_Spm)
                      {
                        $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                                            WHERE c.id_Spm = '$id_Spm'");
                        $r = mysql_fetch_array($sql);
                        return $r[total];
                      }
                      //data yang ditampilkan pada halaman user sesuai dengan role
                      if($_SESSION['UserLevel']==1) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM spm a, skpd b
                                            WHERE a.id_Skpd = b.id_Skpd
                                            ORDER BY a.Tanggal ASC ");
                      } else {
                        $sql= mysql_query("SELECT * FROM spm
                                            WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                            ORDER BY Tanggal DESC");

                      }
                      function cek_status($id_Spm,$str) {
                        $sql = "SELECT b.* FROM spm a, verifikasi b
                                  WHERE a.id_Spm = b.id_Spm
                                  AND a.id_Spm = '$id_Spm'";
                        $q = mysql_query($sql);
                        $r = mysql_fetch_array($q);
                        if($str = "verfinal") {
                          $r[StatusVer] == 1 ? $sv = '<a href="#" style="color:#866de8" data-rel="tooltip" title="Terverifikasi BPKAD"><i class="fa fa-check-circle bigger-160"></i></a>' : $sv = '<a href="#" style="color:#ff0000" data-rel="tooltip" title="Belum diproses oleh BPKAD"><i class="fa fa-minus-circle bigger-160"></i></a>';
                        } elseif($str == "bud") {
                          $r[StatusPengbud] == 2 ? $sv = '<a href="#" style="color:#866de8" data-rel="tooltip" title="Terverifikasi BUD"><i class="fa fa-check-circle bigger-160"></i></a>' :
                                               $sv = '<a href="#" style="color:#ff0000" data-rel="tooltip" title="Belum diproses oleh BUD"><i class="fa fa-minus-circle bigger-160"></i></a>';
                        } else {
                          $sv = "";
                        }
                        return $sv;
                      }
                      function cek_pengbud($id_Spm,$str) {
                        $sql = "SELECT b.* FROM spm a, verifikasi b
                                  WHERE a.id_Spm = b.id_Spm
                                  AND a.id_Spm = '$id_Spm'";
                        $q = mysql_query($sql);
                        $r = mysql_fetch_array($q);

                          $r[StatusPengbud] == 2 ? $sv = '<a href="#" style="color:#866de8" data-rel="tooltip" title="Terverifikasi BUD"><i class="fa fa-check-circle bigger-160"></i></a>' :
                                               $sv = '<a href="#" style="color:#ff0000" data-rel="tooltip" title="Belum diproses oleh BUD"><i class="fa fa-minus-circle bigger-160"></i></a>';

                        return $sv;
                      }
                      $no=1;
      				        while($dt = mysql_fetch_array($sql)) {
                        $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                        $jns = $dt['Jenis'];

                        //$status = array(0=>'<span class="label label-warning arrowed-in">Draf</span>',1=>'<span class="label label-success arrowed">Final</span>',2=>'<span class="label label-danger">Ditolak</span>');
                        $status = array(0=>'<a href="#" style="color:#1cbd19" data-rel="tooltip" title="Status SPM Draf"><i class="fa fa-exclamation-circle bigger-160"></i></a>',
                                        1=>'<a href="#" style="color:#1cbd19" data-rel="tooltip" title="Status SPM Final"><i class="fa fa-check-circle bigger-160"></i></a>',
                                        2=>'<i class="fa fa-ban bigger-160" style="color:#ff0000"></i>');
                        $sttver = $status[$dt[StatusSpm]];
                        $dt[ck_verifikasi] == 1 ? $ik = '<a href="#" style="color:#866de8" data-rel="tooltip" title="Proses Verifikasi BPKAD"><i class="fa fa-check-circle bigger-160"></i></a>' : $ik = '<a href="#" style="color:#ff0000" data-rel="tooltip" title="Belum diproses oleh BPKAD"><i class="fa fa-minus-circle bigger-160"></i></a>';
                        //tombol modal tampilkan kegiatan skpd
                        //href='#modal-form' value='$dt[id_PotonganSpm]' data-toggle='modal' onClick='md_editpotongan(this.value)'
                        $tbl = "<button class='btn btn-primary btn-white btn-minier' id='id_Spm' href='#modal-form'
                                value='$dt[id_Spm]' data-toggle='modal' onClick='vw_kegspm(this.value)'>
                                <i class='fa fa-desktop'></i> Tampilkan</button>";
                        echo "<tr>
                                <td>$dt[id_Spm]</td>
                                <td>$dt[Nomor] </td>
                                <td>$dt[Tanggal]</td>
                                <td>$jns_spm[$jns]</td>
                                <td>".angkrp(totalspm($dt[id_Spm]))." $tbl </td>
                                <td>$sttver $ik ".cek_status($dt[id_Spm],"verfinal")." ".cek_pengbud($dt[id_Spm],"bud")."</td>
                                <td class=align-center><a class='btn btn-minier btn-primary' href='?module=spm&act=add&id=$dt[id_Spm]'><i class='fa fa-edit fa-lg'></i> Edit</a> ";
                                    echo "<a class='btn btn-minier btn-danger' href='modul/act_modspm.php?module=spm&act=hapusspm&id=$dt[id_Spm]' onclick=\"javascript: return confirm('Anda yakin hapus ?')\"><i class='fa fa-trash-o fa-lg'></i> Hapus</a>";

                                echo '</td>
                              </tr>';
                      }
                    echo '<tbody></table>

                </div>
              </div>';

              echo '<div id="modal-form" class="modal" tabindex="-1">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="smaller lighter blue no-margin">Data Kegiatan SPM</h4>
                            </div>

                            <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                <form method=post action="modul/act_modspm.php?module=spm&act=potongan">
                                    <div id="vw_kegspm"></div>

                                    </div>
                                  </div>
                                  </div>

                                  <div class="modal-footer">
                                  <button class="btn btn-sm btn-danger" data-dismiss="modal">
                                    <i class="ace-icon fa fa-times"></i>
                                    Tutup
                                  </button>
                                  </form>

                          </div>
                        </div>
                      </div>';

  break;
  case 'add':
      if($_SESSION['UserLevel']==1) {
        $sql = mysql_query("SELECT * FROM ttdbukti
                              WHERE id_Spm = '$_GET[id]'");
      } else {
        $sqlxx = mysql_query("SELECT * FROM spm WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                      AND id_Spm= '$_GET[id]'");
        $sql = "SELECT * FROM spm a, skpd b
                          LEFT JOIN ttdbukti c
                          ON b.id_Skpd = c.id_Skpd
                          WHERE a.id_Skpd = b.id_Skpd
                          AND b.id_Skpd = '$_SESSION[id_Skpd]'
                          AND a.id_Spm= '$_GET[id]'";
        $q = mysql_query($sql);
      }
      $r = mysql_fetch_array($q);

      function totalspm($id_Spm)
      {
        $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                            WHERE c.id_Spm = '$id_Spm'");
        $r = mysql_fetch_array($sql);
        return $r[total];
      }
      //jika tanggal belum ditentukan gunankan default tahun LOGIN
      $r[Tanggal] == "0000-00-00" ? $tglspm = "$_SESSION[thn_Login]-01-01" : $tglspm = $r[Tanggal];
      //jangan munculkan tombol view document jika belum diinput
      $ckfile = array('spm' => $r[fl_Spm],'spp1' => $r[fl_Spp1],'spp2' => $r[fl_Spp2],'spp3' => $r[fl_Spp3]);
      //$jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU');
      $jns = $r[Jenis];
      //$status = array(0=>'Draf',1=>'Final');
      $stt = $r[StatusSpm];

echo '<div class="col-md-6">
<div class="profile-user-info profile-user-info-striped">
  <div class="profile-info-row">
    <div class="profile-info-name">SKPD </div>
    <div class="profile-info-value">
      '.$r[nm_Skpd].'
    </div>
  </div>
  <div class="profile-info-row">
    <div class="profile-info-name"> Pimpinan</div>
    <div class="profile-info-value">
      '.$r['nm_Kepala'].'
    </div>
  </div>
  <div class="profile-info-row">
    <div class="profile-info-name"> Nilai SPM </div>
    <div class="profile-info-value">
      '.angkrp($r['Anggaran']).'
    </div>
  </div>
</div>
</div>';

echo '<div class="col-md-6">
<div class="profile-user-info profile-user-info-striped">
  <div class="profile-info-row">
    <div class="profile-info-name"> Jenis SPM </div>
    <div class="profile-info-value">
      '.$jns_spm[$jns].'
    </div>
  </div>
  <div class="profile-info-row">
    <div class="profile-info-name"> Nomor</div>
    <div class="profile-info-value">
      '.$r['Nomor'].'  Tanggal '.$r['Tanggal'].'
    </div>
  </div>
  <div class="profile-info-row">
    <div class="profile-info-name"> Status SPM </div>
    <div class="profile-info-value">
      '.$status[$stt].'
    </div>
  </div>
</div>
</div>';

echo '<p>&nbsp;</p>';

//mulai tab
echo '<div class="col-sm-12 widget-container-col">
            <div class="widget-box transparent">
              <div class="widget-header">
                <h4 class="widget-title lighter">Rincian SPM</h4>

                <div class="widget-toolbar no-border">
                  <a href="#" data-action="settings">
                    <i class="ace-icon fa fa-cog"></i>
                  </a>

                  <a href="#" data-action="reload">
                    <i class="ace-icon fa fa-refresh"></i>
                  </a>

                  <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                  </a>

                  <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                  </a>
                </div>
              </div>

              <div class="widget-body">';
              //start tab
              echo '<!--<div class="col-sm-12">-->
                      <div class="tabbable">
                        <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                          <li class="active">
                            <a data-toggle="tab" href="#home4"><i class="ace-icon fa fa-list"></i> Rincian</a>
                          </li>';
                          //tampilkan jika spp yang dipilih adalah SPP LS pengadaan barang dan jasa
                          if($r[Jenis]==3) {
                            echo '<li>
                              <a data-toggle="tab" href="#kontrak"><i class="ace-icon fa fa-list"></i> Data Kontrak</a>
                            </li>';
                          } else {
                            echo "";
                          }
                          echo '<li>
                            <a data-toggle="tab" href="#home5"><i class="ace-icon fa fa-list"></i> Program & Kegiatan</a>
                          </li>
                          <li>
                            <a data-toggle="tab" href="#profile4"><i class="ace-icon fa fa-folder"></i> Potongan SPM</a>
                          </li>

                          <li>
                            <a data-toggle="tab" href="#dropdown14"><i class="ace-icon fa fa-check"></i> Upload Berkas</a>
                          </li>

                          <li>
                            <a data-toggle="tab" href="#status"><i class="ace-icon fa fa-refresh"></i> Ubah Status</a>
                          </li>
                        </ul>

                        <div class="tab-content">
                          <div id="home4" class="tab-pane in active">';

                          echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modspm.php?module=spm&act=add" enctype="multipart/form-data">
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis SPM </label>
                                  <div class="col-sm-10">';
                                  $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                                  echo "<select name='Jenis' class='col-xs-10 col-sm-5' id='form-field-1' required>
                                          <option value=''>-Pilih Jenis SPM-</option>";
                                        foreach ($jns_spm as $key => $value) {
                                          if($key == $r[Jenis]) {
                                            echo "<option value='$key' selected>$value</option>";
                                          } else {
                                            echo "<option value=$key>$value</option>";
                                          }
                                        }
                                  echo "</select>";
                                  echo '</div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nomor SPM </label>
                                  <div class="col-sm-10">
                                    <input type="text" id="form-field-1" name="Nomor" placeholder="Nomor SPM" class="col-xs-10 col-sm-5" value="'.$r[Nomor].'" required/>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tanggal SPM </label>
                                  <div class="col-sm-10">
                                    <input type="text" id="form-field-1" name="Tanggal" placeholder="Tanggal" class="date-picker" data-date-format="yyyy-mm-dd"  value="'.$tglspm.'" required/>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nilai SPM </label>
                                  <div class="col-sm-10">
                                    <input type="text" id="form-field-1" placeholder="Anggaran SPM" name="Anggaran" class="col-xs-10 col-sm-5" value="'.$r[Anggaran].'"  required/>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kepala SKPD </label>
                                  <div class="col-sm-10">';
                                  $qx = mysql_query("SELECT id,NamaTtd FROM ttdbukti WHERE Jabatan = 1 AND id_Skpd = '$_SESSION[id_Skpd]'");
                                  echo "<select name='KepalaSkpd' class='col-xs-10 col-sm-5' id='form-field-1' required>
                                          <option value=''>[Pilih]</option>";
                                        while ($rx = mysql_fetch_array($qx)){
                                          if($rx[id] == $r[KepalaSkpd]) {
                                            echo "<option value='$rx[id]' selected>$rx[NamaTtd]</option>";
                                          } else {
                                            echo "<option value=$rx[id]>$rx[NamaTtd]</option>";
                                          }
                                        }
                                  echo "</select>";
                                  echo '</div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Bendahara </label>
                                  <div class="col-sm-10">';
                                  $qx = mysql_query("SELECT id,NamaTtd FROM ttdbukti WHERE Jabatan = 3 AND id_Skpd = '$_SESSION[id_Skpd]'");
                                  echo "<select name='Bendahara' class='col-xs-10 col-sm-5' id='form-field-1' required>
                                          <option value=''>[Pilih]</option>";
                                          while ($rx = mysql_fetch_array($qx)){
                                            if($rx[id] == $r[Bendahara]) {
                                              echo "<option value='$rx[id]' selected>$rx[NamaTtd]</option>";
                                            } else {
                                              echo "<option value=$rx[id]>$rx[NamaTtd]</option>";
                                            }
                                          }
                                  echo "</select>";
                                  echo '</div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Keterangan </label>
                                  <div class="col-sm-10">
                                    <textarea id="form-field-1" placeholder="Keterangan" name="Keterangan" class="col-xs-10 col-sm-5" >'.$r[Keterangan].'</textarea>
                                  </div>
                                </div>';
                                  echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
                                  echo "<input type='hidden' name='id_Spm' value='$r[id_Spm]'>";
                                  echo '<input type="hidden" name="TotalSmntara" value="'.totalspm($r['id_Spm']).'">';
                                  echo '<div class="clearfix form-actions">
                                    <div class="col-md-offset-3 col-md-9">
                                      <button class="btn btn-info" type="submit" name="simpan">
                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                        Simpan
                                      </button>
                                      &nbsp; &nbsp; &nbsp;
                                            <button class="btn" type="reset">
                                              <i class="ace-icon fa fa-refresh bigger-110"></i>
                                              Reset
                                            </button>

                                            &nbsp; &nbsp; &nbsp;
                                            <a href="?module=spm" class="btn btn-success" >
                                              <i class="ace-icon fa fa-undo bigger-110"></i>
                                              Kembali
                                            </a>
                                    </div>
                                  </div>

                              </form>';

                          echo '</div>';

                          //tab untuk form data kontrak JIKA spm adalah SPM_LS pengadaan barang dan jasa
                          echo '<div id="kontrak" class="tab-pane">';
                          $sql3 = "SELECT * FROM datakontrak WHERE id_Spm = '$r[id_Spm]'";
                          $q3 = mysql_query($sql3);
                          $r3 = mysql_fetch_array($q3);
                          $hit = mysql_num_rows($q3);
                          if($hit <= 0) {
                            $ak = "add";
                          } else {
                            $ak = "edit";
                          }

                          echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modspm.php?module=spm&act=kontrak">
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Perusahaan </label>
                                  <div class="col-sm-10">';
                                  $sql4 = "SELECT id_Usaha,nm_Usaha FROM datausaha";
                                  $q4 = mysql_query($sql4);
                                  echo "<select name='id_Usaha' class='col-xs-10 col-sm-5' id='form-field-1' required>
                                          <option value=''>-Pilih Perusahaan-</option>";
                                        while ($r4 = mysql_fetch_array($q4)) {
                                          if($r4[id_Usaha] == $r3[id_Usaha]) {
                                            echo "<option value='$r4[id_Usaha]' selected>$r4[nm_Usaha]</option>";
                                          } else {
                                            echo "<option value='$r4[id_Usaha]'>$r4[nm_Usaha]</option>";
                                          }
                                        }
                                  echo "</select>";
                                  echo '</div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nomor Rekening</label>
                                  <div class="col-sm-10">
                                    <input type="text" id="form-field-1" name="Nomor" placeholder="Nomor SPM" class="col-xs-10 col-sm-5" value="BANK - Nomor Rekening" required/>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Nomor Kontrak</label>
                                  <div class="col-sm-4">
                                    <input type="text" id="form-field-1" name="NomorKontrak" placeholder="Nomor Kontrak" value="'.$r3[NomorKontrak].'" required/>
                                  </div>
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Tanggal</label>
                                  <div class="col-sm-2">
                                    <input type="text" id="form-field-1" name="tgl_Kontrak" placeholder="Tanggal" class="date-picker" data-date-format="yyyy-mm-dd"  value="'.$r3[tgl_Kontrak].'" required/>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nilai Kontrak</label>
                                  <div class="col-sm-10">
                                    <input type="text" id="form-field-1" name="NilaiKontrak" placeholder="Nomor SPM" class="col-xs-10 col-sm-5" value="'.$r3[NilaiKontrak].'" required/>
                                  </div>
                                </div>';
                                  echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
                                  echo "<input type='hidden' name='id_Spm' value='$r[id_Spm]'>";
                                  echo "<input type='hidden' name='id_Kontrak' value='$r3[id_Kontrak]'>";
                                  echo "<input type='hidden' name='ak' value='$ak'>";
                                  echo '<input type="hidden" name="TotalSmntara" value="'.totalspm($r['id_Spm']).'">';
                                  echo '<div class="clearfix form-actions">
                                    <div class="col-md-offset-3 col-md-9">
                                      <button class="btn btn-info" type="submit" name="simpan">
                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                        Simpan
                                      </button>
                                      &nbsp; &nbsp; &nbsp;
                                            <button class="btn" type="reset">
                                              <i class="ace-icon fa fa-refresh bigger-110"></i>
                                              Reset
                                            </button>

                                            &nbsp; &nbsp; &nbsp;
                                            <a href="?module=spm" class="btn btn-success" >
                                              <i class="ace-icon fa fa-undo bigger-110"></i>
                                              Kembali
                                            </a>
                                    </div>
                                  </div>

                              </form>';

                          echo '</div>';

                          echo '<div id="home5" class="tab-pane">';
                            //rincian kegiatan spm
                            if($r[StatusSpm] == 0) {
                              echo "<p><button class='btn btn-sm btn-warning btn-fill' role='button' href='#modal-form' id='id_Spm' value='$r[id_Spm]' data-toggle='modal' id='id_Spm' onClick='md_pengbud(this.value)'><i class='fa fa-plus'></i> Tambah Kegiatan</button></p>";
                            } else {
                              echo "";
                            }

                            echo '
                            <table class="table table-striped table-bordered table-responsive">
                              <thead>
                              <tr>
                                <th></th><th>Kegiatan</th>
                                <th>Anggaran</th><th>Realisasi</th><th>Nilai SPM</th><th></th>
                              </tr>
                              </thead>
                              <tbody>';

                              function totalangg($id_Spm)
                              {
                                $sql= mysql_query("SELECT SUM(b.AnggKeg) total FROM datakegiatan b,rincspm c
                                                    WHERE c.id_DataKegiatan = b.id_DataKegiatan
                                                    AND c.id_Spm = '$id_Spm'");
                                $r = mysql_fetch_array($sql);
                                return $r[total];
                              }
                              function totalspm1($id_Spm)
                              {
                                $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                                                    WHERE c.id_Spm = '$id_Spm'");
                                $r = mysql_fetch_array($sql);
                                return $r[total];
                              }
                              function realisasi($id_DataKegiatan)
                              {
                                $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                                                    WHERE c.id_DataKegiatan = '$id_DataKegiatan'");
                                $r = mysql_fetch_array($sql);
                                return $r[total];
                              }
                              function totalrealisasi($id_Spm)
                              {
                                $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                                                    WHERE c.id_Spm = '$id_Spm'");
                                $r = mysql_fetch_array($sql);
                                return $r[total];
                              }

                              if($_SESSION['UserLevel']==1) {
                                $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM spm a, skpd b
                                                    WHERE a.id_Skpd = b.id_Skpd");
                              } else {
                                $sql= mysql_query("SELECT b.*,d.nm_Kegiatan,c.Nilai,c.id_Rincspm,c.id_DataKegiatan AS jnsk FROM spm a,datakegiatan b,rincspm c,kegiatan d
                                                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                                                    AND a.id_Spm = c.id_Spm
                                                    AND c.id_DataKegiatan = b.id_DataKegiatan
                                                    AND b.id_Kegiatan = d.id_Kegiatan
                                                    AND a.id_Spm = '$_GET[id]'");
                              }

                              $no=1;
                              while($dt = mysql_fetch_array($sql)) {
                                        echo "<tr>
                                              <td>".$no++."</td>
                                              <td>$dt[nm_Kegiatan]</td>
                                              <td>".angkrp($dt[AnggKeg])."</td>
                                              <td>".angkrp(realisasi($dt[jnsk]))."</td>
                                              <td>".angkrp($dt[Nilai])."</td>
                                              <td class=align-center><button role='button' class='btn btn-minier btn-success' href='#modal-form-edit' id='id_Rincspm' value='$dt[id_Rincspm]' data-toggle='modal' onClick='md_editpengbud(this.value)'><i class='fa fa-edit fa-lg'></i> Edit</button> ";
                                                  echo "<a  class='btn btn-minier btn-danger' href='modul/act_modspm.php?module=spm&act=datakegiatandel&id=$dt[id_Rincspm]&idx=$_GET[id]' onclick=\"javascript: return confirm('Anda yakin hapus ?')\"><i class='fa fa-trash-o fa-lg'></i> Hapus</a>";
                                              echo '</td>
                                            </tr>';
                              }


                            echo '</tbody>';
                            echo '<tfoot>
                                    <tr>
                                      <td></td>
                                      <td align="right"><strong>Jumlah Total...</strong></td>
                                      <td>'.angkrp(totalangg($_GET[id])).'</td>
                                      <td></td>
                                      <td>'.angkrp(totalspm($_GET[id])).'</td>
                                      <td></td>
                                      <td></td>
                                    </tr>
                                  </tfoot>';
                            echo '</table>';


                          echo '</div>';

                          echo '<div id="profile4" class="tab-pane">';

                          if($r[StatusSpm] == 0) {
                            echo "<p><button class='btn btn-sm btn-warning btn-fill' role='button' href='#modal-form-potongan' id='id_Spm' value='$r[id_Spm]' data-toggle='modal' id='id_Spm' onClick='md_potongan(this.value)'><i class='fa fa-plus'></i> Tambah Potongan</button></p>";
                          } else {
                            echo "";
                          }
                          echo '<table id="tabledata" class="table table-striped table-bordered table-condensed">
                            <thead>
                            <tr>
                              <th></th><th>Jenis Potongan</th>
                              <th>Nilai</th><th></th>
                            </tr>
                            </thead>
                            <tbody>';



                            //data yang ditampilkan pada halaman user sesuai dengan role
                            function totalpot($id_Spm)
                            {
                              $sql= mysql_query("SELECT SUM(NilaiPotongan) AS total FROM potonganspm
                                                  WHERE id_Spm = '$id_Spm'");
                              $r = mysql_fetch_array($sql);
                              return $r[total];
                            }

                            $sql= mysql_query("SELECT * FROM spm a, potonganspm b
                                                  WHERE a.id_Spm = b.id_Spm
                                                  AND a.id_Spm = '$_GET[id]'");


                            $no=1;
                            while($dt = mysql_fetch_array($sql)) {
                              $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                              $jnspotongan = array(1 => 'PPN 10%',2=>'PPH 21',3=>'PPH 22',4=>'PPH Gaji',5=>'IWP',6=>'TAPERUM',7=>'ASKES' );
                              $jsp = $jnspotongan[$dt[JnsPotongan]];
                              echo "<tr>
                                      <td>".$no++."</td>
                                      <td>$jsp</td>
                                      <td>".angkrp($dt[NilaiPotongan])."</td>
                                      <td class=align-center><button role='button' class='btn btn-minier btn-success' href='#modal-form-editpotongan' id='id_PotonganSpm' value='$dt[id_PotonganSpm]' data-toggle='modal' onClick='md_editpotongan(this.value)'><i class='fa fa-edit fa-lg'></i> Edit</button> ";
                                          echo "<a  class='btn btn-minier btn-danger' href='modul/act_modspm.php?module=spm&act=delpotongan&id=$dt[id_PotonganSpm]&idx=$_GET[id]' onclick=\"javascript: return confirm('Anda yakin hapus ?')\"><i class='fa fa-trash-o fa-lg'></i> Hapus</a>";
                                      echo '</td>
                                    </tr>';
                            }

                          echo '</tbody>';
                          //footer
                          echo '<tfoot>
                                  <tr>
                                    <td></td>
                                    <td align="right"><strong>Jumlah Total...</strong></td>
                                    <td>'.angkrp(totalpot($_GET[id])).'</td>
                                    <td></td>
                                  </tr>
                                </tfoot>';
                          echo '</table>';

                          echo '</div>

                          <div id="dropdown14" class="tab-pane">
                                <p> Upload Dokumen Pengajuan SPM </p>';
                                //untuk daftar check list
                                //fungsi isi Keterangan dan tampilan nama File
                                function ck_document($id_Cklist, $id_Spm,$aksi,$str) {
                                	$q = mysql_query("SELECT * FROM uploadberkas
                                                      WHERE id_Cklist = '$id_Cklist'
                                                      AND id_Spm = '$id_Spm'");
                                	$r = mysql_fetch_array($q);
                                	$hit = mysql_num_rows($q);
                                	if($hit <= 0) {
                                		if($str == 'Cek') {
                                			$ck = '<input type="checkbox" name="checkbox">';
                                		} elseif ($str == 'File') {
                                			$ck = '<input type="file" name="fileupload" id="fileupload" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*" value="" required>';
                                		} elseif ($str == 'Button') {
                                			$ck = '<button type="submit" name="simpanupload" class="btn btn-minier btn-primary"><i class="fa fa-upload"></i> Upload</button>';
                                		} else {
                                      $ck = $r[Keterangan];
                                    }
                                	} else {
                                    if($str == 'Cek') {
                                			$ck = '<input type="checkbox" name="checkbox">';
                                		} elseif ($str == 'File') {
                                      $ck = '<a href="media/'.$_SESSION[thn_Login].'/'.$r[fileupload].'" target="_blank" class="btn btn-success btn-minier"><i class="fa fa-files-o"></i> File Upload</a>';
                                		} elseif ($str == 'Button') {
                                      $ck = '<a href="modul/act_modspm.php?module=spm&act=hapus&id='.$r[id_Upload].'" onclick="return confirm(\'Yakin untuk menghapus data ini?\')" class="btn btn-minier btn-danger"><i class="fa fa-trash-o"></i> Delete</a>';
                                    } else {
                                      $ck = $r[Keterangan]."<input type='hidden' name='namafile' value='$r[fileupload]'>";
                                      $ckxx = '<input type="text" name="namafile" value="'.$r[fileupload].'">';
                                    }
                                	}
                                	return $ck;
                                }
                                $q1 = mysql_query("SELECT * FROM cklist
                                                  WHERE Jenis = '$r[Jenis]'
                                                  AND Aktiv =1");

                                $no=1;
                                echo '<table class="table table-condensed table-striped table-bordered">
                                      <thead>
                                        <tr>
                                          <th></th>
                                          <th width=50%>Jenis Dokumen</th>
                                          <th width=15%>File</th>
                                          <th></th>
                                          <th width=20%>Catatan Verifikasi</th>
                                        </tr>
                                      </thead>
                                      <tbody>';
                                      while($r1=mysql_fetch_array($q1)) {
                                        //form upload dokumen pdf dan img
                                        echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modspm.php?module=spm&act=upload" enctype="multipart/form-data">';
                                        echo "<input type=hidden name='id_Cklist' value='$r1[id_Cklist]'>";
                                        echo "<input type=hidden name='id_Skpd' value='$_SESSION[id_Skpd]'>";
                                        echo "<input type=hidden name='id_Spm' value='$r[id_Spm]'>";
                                        echo "<input type=hidden name='ck_verifikasi' value='$r[ck_verifikasi]'>";
                                        echo '<tr>
                                          <td>'.$no++.'</td>
                                          <td>'.$r1[nm_List].'</td>
                                          <td>'.ck_document($r1[id_Cklist],$r[id_Spm],"aksi","File").'</td>
                                          <td>'.ck_document($r1[id_Cklist],$r[id_Spm],"aksi","Button").'</td>
                                          <td>'.ck_document($r1[id_Cklist],$r[id_Spm],"aksi","ket").'</td>
                                        </tr>';
                                        echo "</form>";
                                      }
                                echo '</tbody></table>
                          </div>

                          <div id="status" class="tab-pane">';
                            //ini untuk mengubah status dari spm yg diajukan
                            echo '<form action="modul/act_modspm.php?module=spm&act=status" method="post">';
                            echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
                            echo "<input type='hidden' name='id_Spm' value='$r[id_Spm]'>";
                            echo "<input type='hidden' name='Anggaran' value='$r[Anggaran]'>";
                            echo "<input type='hidden' name='ck_verifikasi' value='$r[ck_verifikasi]'>";
                            echo '<input type="hidden" name="TotalSmntara" value="'.totalspm($r['id_Spm']).'">';

                            echo '<div class="form-horizontal">

                                    <div class="form-group">
                                      <label for="inputPassword3" class="col-sm-2 control-label">Status SPM </label>
                                      <div class="col-sm-10">';
                                      $status = array(0=>'Draf',1=>'Final');
                                      echo "<select name='StatusSpm' class='col-xs-10 col-sm-5' id='form-field-1' required>";
                                            foreach ($status as $key => $value) {
                                              if($key == $r[StatusSpm]) {
                                                echo "<option value='$key' selected>$value</option>";
                                              } else {
                                                echo "<option value=$key>$value</option>";
                                              }
                                            }
                                      echo "</select>
                                      </div>
                                    </div>
                                  </div>";

                          echo '
                          <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                              <button class="btn btn-primary" type="submit" name="simpan">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Simpan
                              </button>
                              &nbsp; &nbsp; &nbsp;
                              <button class="btn" type="reset">
                                <i class="ace-icon fa fa-refresh bigger-110"></i>
                                Reset
                              </button>

                              &nbsp; &nbsp; &nbsp;
                              <a href="?module=spm" class="btn btn-success" >
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                Kembali
                              </a>
                            </div>
                          </div>
                          </form>
                          </div>

                      </div>
                    </div>';


              echo '</div>
            </div>
          </div>';

          //-------modal kegiatan ----------

          echo '<div id="modal-form" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="smaller lighter blue no-margin">Anggaran Kegiatan SPM</h4>
                        </div>

                        <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                            <form method=post action="modul/act_modspm.php?module=spm&act=datakegiatan">
                                <div id="id_ProsesSpm"></div>

                                </div>
                              </div>
                              </div>

                              <div class="modal-footer">
                              <button class="btn btn-sm" data-dismiss="modal">
                                <i class="ace-icon fa fa-times"></i>
                                Cancel
                              </button>

                              <button type="submit" name="simpan" class="btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-check"></i>
                                Proses
                              </button>
                              </div></form>

                      </div>
                    </div>
                  </div>';

          echo '<div id="modal-form-edit" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="smaller lighter blue no-margin">Edit Anggaran Kegiatan SPM </h4>
                        </div>

                        <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                            <form method=post action="modul/act_modspm.php?module=spm&act=datakegiatanedit">
                                <div id="id_EditProsesSpm"></div>

                                </div>
                              </div>
                              </div>

                              <div class="modal-footer">
                              <button class="btn btn-sm" data-dismiss="modal">
                                <i class="ace-icon fa fa-times"></i>
                                Cancel
                              </button>
                              <input type="hidden" name="StatusSpm" value="'.$r[StatusSpm].'">
                              <button type="submit" name="simpan" class="btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-check"></i>
                                Proses
                              </button>
                              </div></form>

                      </div>
                    </div>
                  </div>';

  //batas modal kegiatn ----------------

  //modal potongan
  echo '<div id="modal-form-potongan" class="modal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="smaller lighter blue no-margin">Potongan SPM</h4>
                </div>

                <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                    <form method=post action="modul/act_modspm.php?module=spm&act=potongan">
                        <div id="id_Potongan"></div>

                        </div>
                      </div>
                      </div>

                      <div class="modal-footer">
                      <button class="btn btn-sm" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Cancel
                      </button>

                      <button type="submit" name="simpan" class="btn btn-sm btn-primary">
                        <i class="ace-icon fa fa-save"></i>
                        Simpan
                      </button>
                      </div></form>

              </div>
            </div>
          </div>';

          echo '<div id="modal-form-editpotongan" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="smaller lighter blue no-margin">Edit Potongan SPM </h4>
                        </div>

                        <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                            <form method=post action="modul/act_modspm.php?module=spm&act=editpotongan">
                                <div id="editpotonganspm"></div>

                                </div>
                              </div>
                              </div>

                              <div class="modal-footer">
                              <button class="btn btn-sm" data-dismiss="modal">
                                <i class="ace-icon fa fa-times"></i>
                                Cancel
                              </button>
                              <input type="hidden" name="StatusSpm" value="'.$r[StatusSpm].'">
                              <button type="submit" name="simpan" class="btn btn-sm btn-primary">
                                <i class="ace-icon fa fa-save"></i>
                                Simpan
                              </button>
                              </div></form>

                      </div>
                    </div>
                  </div>';

  break;
  case 'potongan':
      if($_SESSION['UserLevel']==1) {
        $sql = mysql_query("SELECT * FROM ttdbukti
                              WHERE id_Spm = '$_GET[id]'");
      } else {
        $sql = mysql_query("SELECT * FROM spm WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                      AND id_Spm= '$_GET[id]'");
      }
      $r = mysql_fetch_array($sql);
      echo '<div class="col-md-8">
              <div class="card">
                <div class="header">
                  <div class="row">
                    <div class="col-md-6">Daftar Potongan SPM</div>
                    <div class="col-md-6">
                    <div class="input-group pull-right" style="width: 350px;">
                      <input type="text" name="table_search" class="form-control" placeholder="Search">
                      <div class="input-group-btn">';
                        echo "<button class='btn btn-sm btn-danger btn-fill' role='button' id='id_Spm' onclick=\"javascript:window.close()\"><i class='fa fa-close'></i> Tutup</button>";
                        //munculkan tombol jika spm masih draf
                        if($r[StatusSpm] == 0) {
                          echo "<button class='btn btn-sm btn-warning btn-fill' role='button' href='#modal-form' id='id_Spm' value='$r[id_Spm]' data-toggle='modal' id='id_Spm' onClick='md_potongan(this.value)'><i class='fa fa-plus'></i> Tambah Potongan</button>";
                        } else {
                          echo "";
                        }
                      echo '</div>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="content table-responsive">
                  <table id="tabledata" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                      <th></th><th>Jenis Potongan</th>
                      <th>Nilai</th><th></th>
                    </tr>
                    </thead>
                    <tbody>';



                    //data yang ditampilkan pada halaman user sesuai dengan role
                    function totalpot($id_Spm)
                    {
                      $sql= mysql_query("SELECT SUM(NilaiPotongan) AS total FROM potonganspm
                                          WHERE id_Spm = '$id_Spm'");
                      $r = mysql_fetch_array($sql);
                      return $r[total];
                    }

                    $sql= mysql_query("SELECT * FROM spm a, potonganspm b
                                          WHERE a.id_Spm = b.id_Spm
                                          AND a.id_Spm = '$_GET[id]'");


                    $no=1;
                    while($dt = mysql_fetch_array($sql)) {
                      $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                      $jnspotongan = array(1 => 'PPN 10%',2=>'PPH 21',3=>'PPH 22',4=>'PPH Gaji',5=>'IWP',6=>'TAPERUM',7=>'ASKES' );
                      $jsp = $jnspotongan[$dt[JnsPotongan]];
                      echo "<tr>
                              <td>".$no++."</td>
                              <td>$jsp</td>
                              <td>".angkrp($dt[NilaiPotongan])."</td>
                              <td class=align-center><button role='button' class='btn btn-minier btn-success' href='#modal-form-edit' id='id_PotonganSpm' value='$dt[id_PotonganSpm]' data-toggle='modal' onClick='md_editpotongan(this.value)'><i class='fa fa-edit fa-lg'></i> Edit</button> ";
                                  echo "<a  class='btn btn-minier btn-danger' href='modul/act_modspm.php?module=spm&act=delpotongan&id=$dt[id_PotonganSpm]&idx=$_GET[id]' onclick=\"javascript: return confirm('Anda yakin hapus ?')\"><i class='fa fa-trash-o fa-lg'></i> Hapus</a>";
                              echo '</td>
                            </tr>';
                    }

                  echo '<tbody>';
                  //footer
                  echo '<tfoot>
                          <tr>
                            <td></td>
                            <td align="right"><strong>Jumlah Total...</strong></td>
                            <td>'.angkrp(totalpot($_GET[id])).'</td>
                            <td></td>
                          </tr>
                        </tfoot>';
                  echo '</table>

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

            echo '<div id="modal-form" class="modal" tabindex="-1">
    									<div class="modal-dialog">
    										<div class="modal-content">
    											<div class="modal-header">
    												<button type="button" class="close" data-dismiss="modal">&times;</button>
    												<h4 class="smaller lighter blue no-margin">Potongan SPM</h4>
    											</div>

    											<div class="modal-body">
                          <div class="row">
                              <div class="col-xs-12 col-sm-12">
                              <form method=post action="modul/act_modspm.php?module=spm&act=potongan">
                                  <div id="id_ProsesSpm"></div>

                                  </div>
                                </div>
                                </div>

                                <div class="modal-footer">
                                <button class="btn btn-sm" data-dismiss="modal">
                                  <i class="ace-icon fa fa-times"></i>
                                  Cancel
                                </button>

                                <button type="submit" name="simpan" class="btn btn-sm btn-primary">
                                  <i class="ace-icon fa fa-save"></i>
                                  Simpan
                                </button>
                                </div></form>

    										</div>
    									</div>
    								</div>';

                    echo '<div id="modal-form-edit" class="modal" tabindex="-1">
            									<div class="modal-dialog">
            										<div class="modal-content">
            											<div class="modal-header">
            												<button type="button" class="close" data-dismiss="modal">&times;</button>
            												<h4 class="smaller lighter blue no-margin">Edit Potongan SPM </h4>
            											</div>

            											<div class="modal-body">
                                  <div class="row">
                                      <div class="col-xs-12 col-sm-12">
                                      <form method=post action="modul/act_modspm.php?module=spm&act=editpotongan">
                                          <div id="editpotonganspm"></div>

                                          </div>
                                        </div>
                                        </div>

                                        <div class="modal-footer">
                                        <button class="btn btn-sm" data-dismiss="modal">
                                          <i class="ace-icon fa fa-times"></i>
                                          Cancel
                                        </button>
                                        <input type="hidden" name="StatusSpm" value="'.$r[StatusSpm].'">
                                        <button type="submit" name="simpan" class="btn btn-sm btn-primary">
                                          <i class="ace-icon fa fa-save"></i>
                                          Simpan
                                        </button>
                                        </div></form>

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
function md_pengbud(id_Spm)
{
  $.ajax({
        url: 'library/ax_kegiatanspm.php',
        data : 'id_Spm='+id_Spm,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_ProsesSpm').html(response);
        }
    });
}

function md_editpengbud(id_Rincspm)
{
  $.ajax({
        url: 'library/rinc_kegiatanspmedit.php',
        data : 'id_Rincspm='+id_Rincspm,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_EditProsesSpm').html(response);
        }
    });
}

function md_potongan(id_Spm)
{
  $.ajax({
        url: 'library/ax_potonganspm.php',
        data : 'id_Spm='+id_Spm,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_Potongan').html(response);
        }
    });
}
function md_editpotongan(id_PotonganSpm)
{
  $.ajax({
        url: 'library/ax_editpotonganspm.php',
        data : 'id_PotonganSpm='+id_PotonganSpm,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#editpotonganspm').html(response);
        }
    });
}


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

function vw_kegspm(id_Spm)
{
  $.ajax({
    url: 'library/vw_kegspm.php',
    data: 'id_Spm='+id_Spm,
    type: "post",
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#vw_kegspm').html(response);
    }
    });
}

//kembali
$(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});



    $(".hapus").click(function () {
        var jawab = confirm("Press a button!");
        if (jawab === true) {
//            kita set hapus false untuk mencegah duplicate request
            var hapus = false;
            if (!hapus) {
                hapus = true;
                $.post('act_modspm.php', {id: $(this).attr('data-id')},
                function (data) {
                    alert(data);
                });
                hapus = false;
            }
        } else {
            return false;
        }
    });

//validasi file type dan size
$('#simpan').click( function() {
    //check whether browser fully supports all File API
    if (window.File && window.FileReader && window.FileList && window.Blob)
    {
        //get the file size and file type from file input field
        var fsize = $('#fl_Spm')[0].files[0].size;
        var ftype = $('#fl_Spm')[0].files[0].type;
        var fname = $('#fl_Spm')[0].files[0].name;

       switch(ftype)
        {
            case 'image/png':
            case 'image/gif':
            case 'image/jpeg':
            case 'image/pjpeg':
                alert("Acceptable image file!");
                break;
            default:
                alert('Unsupported File!');
        }

    }else{
        alert("Please upgrade your browser, because your current browser lacks some new features we need!");
    }
});

//popup upload file
function popup(url) {
  popupWindow = window.open(url,'popUpWindow','height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
}
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
