<?php
//session_start();

if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {

//include "../config/koneksi.php";
//include "../config/errormode.php";
//fungsi hitung jumlah total pada footer
function totalangg($id_Spm)
{
  $sql= mysql_query("SELECT SUM(b.AnggKeg) total FROM datakegiatan b,rincspm c
                      WHERE c.id_DataKegiatan = b.id_DataKegiatan
                      AND c.id_Spm = '$id_Spm'");
  $r = mysql_fetch_array($sql);
  return $r[total];
}
function totalspm($id_Spm)
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


  switch ($_GET['act']) {
    default:
        echo '<div class="col-md-12">
                <div class="card">
                  <div class="header">
                    <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">';
                          echo "<button class='btn btn-sm btn-primary btn-fill pull-right' name='tambahsubdak' onClick=\"window.location.href='?module=pengesahanbud&act=daftarspm'\"><i class='fa fa-plus-circle'></i> Tambah Pengesahan SPM</button>";
                        echo '</div>
                    </div>
                  </div>
                  <div class="content table-responsive">
                    <table id="myTable" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th></th><th>Nomor</th><th>Tanggal</th>
                        <th>Jenis</th><th>Nilai SPM</th><th>SKPD</th><th>Status Pengesahan</th><th></th>
                      </tr>
                      </thead>
                      <tbody>';

                      //data yang ditampilkan pada halaman user sesuai dengan role
                      if($_SESSION['UserLevel']==1) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd,c.StatusVer,c.StatusSp2d  FROM spm a, skpd b, verifikasi c
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Spm = c.id_Spm");
                      } elseif($_SESSION['UserLevel']==4) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd,d.nm_Lengkap,c.StatusPengbud,c.id_Ver,c.StatusSp2d FROM spm a, skpd b,verifikasi c, user d
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Spm = c.id_Spm
                                            AND c.id_User = d.id_User
                                            AND c.StatusVer = 1
                                            AND c.StatusPengbud <> 0 ");
                      } else {
                        $sql = "";
                      }
                      $no=1;
      				        while($dt = mysql_fetch_array($sql)) {
                        $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                        $status = array(1=>'<span class="label label-warning arrowed-in">Draf</span>',2=>'<span class="label label-success arrowed">Final</span>',3=>'<span class="label label-danger">Ditolak</span>');
                        $jns = $dt['Jenis'];
                        $sttver = $status[$dt[StatusPengbud]];
                        $dt[StatusSp2d] > 0 ? $ik = "<i class='fa fa-lock'></i>" : $ik = "";

                        echo "<tr>
                                <td>".$no++."</td>
                                <td>$ik $dt[Nomor]</td>
                                <td>$dt[Tanggal]</td>
                                <td>$jns_spm[$jns]</td>
                                <td>".angkrp($dt[Anggaran])."</td>
                                <td>$dt[nm_Skpd]</td>
                                <td>$sttver</td>
                                <td class=align-center>
                                  <a class='btn btn-primary btn-minier' href='?module=pengesahanbud&act=add&id=$dt[id_Ver]'><i class='fa fa-edit fa-lg'></i> Proses Pengesahan</a>
                                  <a class='btn btn-danger btn-minier' href='modul/act_modverifikasi.php?module=verifikasi&act=hapuspengbud&id=$dt[id_Ver]' onclick=\"javascript: return confirm('Anda yakin hapus ?')\"><i class='fa fa-trash fa-lg'></i> Hapus</a>";

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
  case 'daftarspm':
  echo '<div class="col-md-12">
          <div class="card">
            <div class="header">
              <div class="row">
                <div class="col-md-6">Daftar SPM Belum Disahkan</div>
                <div class="col-md-6">';
                  echo "<a href='?module=pengesahanbud' class='btn btn-sm btn-danger btn-fill pull-right' role='button' id='id_Spm'><i class='fa fa-reply'></i> Kembali</a>";
                echo '</div>
              </div>
            </div>
            <div class="content table-responsive">
              <table id="myTable" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                  <th></th><th>Nomor</th><th>Tanggal</th>
                  <th>Jenis</th><th>Nilai SPM</th><th>SKPD</th><th>Verifikator</th><th></th>
                </tr>
                </thead>
                <tbody>';

                //data yang ditampilkan pada halaman user sesuai dengan role
                if($_SESSION['UserLevel']==1) {
                  $sql= mysql_query("SELECT a.*,b.nm_Skpd,d.nm_Lengkap FROM spm a, skpd b,verifikasi c, user d
                                      WHERE a.id_Skpd = b.id_Skpd
                                      AND a.id_Spm = c.id_Spm
                                      AND c.id_User = d.id_User
                                      AND c.StatusVer = 1
                                      AND c.StatusPengbud = 0 ");
                } elseif ($_SESSION['UserLevel']==4) {
                  $sql= mysql_query("SELECT a.*,b.nm_Skpd,d.nm_Lengkap FROM spm a, skpd b,verifikasi c, user d
                                      WHERE a.id_Skpd = b.id_Skpd
                                      AND a.id_Spm = c.id_Spm
                                      AND c.id_User = d.id_User
                                      AND c.StatusVer = 1
                                      AND c.StatusPengbud = 0 ");
                } else {
                  echo "nn";
                }
                $no=1;
                while($dt = mysql_fetch_array($sql)) {
                  $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                  $jns = $dt['Jenis'];

                  echo "<tr>
                          <td>".$no++."</td>
                          <td>$dt[Nomor]</td>
                          <td>$dt[Tanggal]</td>
                          <td>$jns_spm[$jns]</td>
                          <td>$dt[Anggaran]</td>
                          <td>$dt[nm_Skpd]</td>
                          <td>$dt[nm_Lengkap]</td>
                          <td class=align-center><button role='button' href='#modal-form' value='$dt[id_Spm]' id='id_Spm' onClick='md_pengbud(this.value)' class='btn btn-success btn-sm' data-toggle='modal'> Proses Pengesahan </button>";
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

        //modal dari data spm yg diambil
        echo '<div id="modal-form" class="modal" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="smaller lighter blue no-margin">Pengesahan SPM</h4>
											</div>

											<div class="modal-body">
                      <div class="row">
                          <div class="col-xs-12 col-sm-12">
                          <form method=post action="modul/act_modverifikasi.php?module=pengesahanbud&act=pengebud">
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
								</div>

                ';


  break;

	case "add" :
        $sql= "SELECT a.*,b.nm_Skpd,c.*,d.nm_Lengkap FROM spm a, skpd b, verifikasi c,user d
                            WHERE a.id_Skpd = b.id_Skpd
                            AND a.StatusSpm = 1
                            AND a.id_Spm = c.id_Spm
                            AND c.id_User = d.id_User
                            AND c.id_Ver = '$_GET[id]'
                            AND c.StatusPengbud <> 0 ";
        $q = mysql_query($sql);
        $dt = mysql_fetch_array($q);

        $jns = $dt['Jenis'];
        $stt = $dt[StatusSpm];

        //putus jika status pengesahan == 0
        if($dt[StatusPengbud]==0) {
          exit("tutup");
        } else {
          echo "";
        }

		    echo '<div class="col-md-6">
        <div class="profile-user-info profile-user-info-striped">
          <div class="profile-info-row">
            <div class="profile-info-name"> Jenis SPM </div>
            <div class="profile-info-value">
              '.$jns_spm[$jns].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Nomor SPM</div>
            <div class="profile-info-value">
              '.$dt['Nomor'].',  Tanggal : '.tgl_indo($dt['Tanggal']).'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Nilai SPM </div>
            <div class="profile-info-value">
              '.angkrp($dt['Anggaran']).'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> SKPD </div>
            <div class="profile-info-value">
              '.$dt['nm_Skpd'].'
            </div>
          </div>
        </div>
        </div>';

        echo '<div class="col-md-6">
        <div class="profile-user-info profile-user-info-striped">
          <div class="profile-info-row">
            <div class="profile-info-name"> Peneliti oleh </div>
            <div class="profile-info-value">
              '.$dt[nm_Lengkap].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Tanggal</div>
            <div class="profile-info-value">
              '.tgl_indo($dt['tgl_Ver']).'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Catatan  </div>
            <div class="profile-info-value">
              '.$dt['InformasiVer'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Status BUD </div>
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
          													<a data-toggle="tab" href="#home4"><i class="ace-icon fa fa-list"></i> Data Program Kegiatan</a>
          												</li>

          												<li>
          													<a data-toggle="tab" href="#profile4"><i class="ace-icon fa fa-list"></i> Potongan SPM</a>
          												</li>

          												<li>
          													<a data-toggle="tab" href="#dropdown14"><i class="ace-icon fa fa-check"></i> Check-list Dokumen</a>
          												</li>

                                  <li>
          													<a data-toggle="tab" href="#status"><i class="ace-icon fa fa-refresh"></i> Ubah Status</a>
          												</li>
          											</ul>

          											<div class="tab-content">
          												<div id="home4" class="tab-pane in active">
          													<p></p>';
                                    echo '<table id="tabledata" class="table table-striped table-bordered table-hover table-responsive">
                                      <thead>
                                      <tr>
                                        <th></th><th>Kegiatan</th>
                                        <th>Anggaran</th><th>Nilai SPM </th>
                                      </tr>
                                      </thead>
                                      <tbody>';
                                      //data yang ditampilkan pada halaman user sesuai dengan role


                                      if($_SESSION['UserLevel']==1) {
                                        $sql1= mysql_query("SELECT a.*,b.nm_Skpd FROM spm a, skpd b
                                                            WHERE a.id_Skpd = b.id_Skpd");
                                      } else {
                                        $sql1= mysql_query("SELECT b.*,d.nm_Kegiatan,c.Nilai,c.id_Rincspm FROM spm a,datakegiatan b,rincspm c,kegiatan d
                                                            WHERE a.id_Spm = c.id_Spm
                                                            AND c.id_DataKegiatan = b.id_DataKegiatan
                                                            AND b.id_Kegiatan = d.id_Kegiatan
                                                            AND a.id_Spm = '$dt[id_Spm]'");

                                      }

                                      $no=1;
                                      while($dt1 = mysql_fetch_array($sql1)) {
                                        //$jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                                        //$jns = $dt['Jenis'];

                                        //$status = array(0=>'<span class="label label-warning arrowed-in">Draf</span>',1=>'<span class="label label-success arrowed">Final</span>',2=>'<span class="label label-danger">Ditolak</span>');
                                        //$sttver = $status[$dt[StatusSpm]];

                                        echo "<tr>
                                                <td>".$no++."</td>
                                                <td>$dt1[nm_Kegiatan]</td>
                                                <td>".angkrp($dt1[AnggKeg])."</td>
                                                <td>".angkrp($dt1[Nilai])."</td>
                                              </tr>";
                                      }

                                    echo '<tbody>';
                                    echo '<tfoot>
                                            <tr>
                                              <td></td>
                                              <td align="right"><strong>Jumlah Total...</strong></td>
                                              <td>'.angkrp(totalangg($dt[id_Spm])).'</td>
                                              <td>'.angkrp(totalspm($dt[id_Spm])).'</td>
                                            </tr>
                                          </tfoot>';
                                    echo '</table>';
          												echo '</div>
          												<div id="profile4" class="tab-pane">';

                                    echo '<table id="tabledata" class="table table-striped table-bordered">
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

                                      $sql2= mysql_query("SELECT * FROM spm a, potonganspm b
                                                            WHERE a.id_Spm = b.id_Spm
                                                            AND a.id_Spm = '$dt[id_Spm]'");


                                      $no=1;
                                      while($dt2 = mysql_fetch_array($sql2)) {

                                        $jsp = $jnspotongan[$dt2[JnsPotongan]];
                                        echo "<tr>
                                                <td>".$no++."</td>
                                                <td>$jsp</td>
                                                <td>".angkrp($dt2[NilaiPotongan])."</td>
                                                <td class=align-center><button role='button' class='btn btn-minier btn-success' href='#modal-form-editpotongan' id='id_PotonganSpm' value='$dt2[id_PotonganSpm]' data-toggle='modal' onClick='md_editpotongan(this.value)'><i class='fa fa-edit fa-lg'></i> Edit</button> ";
                                                    echo "<a  class='btn btn-minier btn-danger' href='modul/act_modspm.php?module=spm&act=delpotongan&id=$dt2[id_PotonganSpm]&idx=$_GET[id]' onclick=\"javascript: return confirm('Anda yakin hapus ?')\"><i class='fa fa-trash-o fa-lg'></i> Hapus</a>";
                                                echo '</td>
                                              </tr>';
                                      }

                                    echo '</tbody>';
                                    //footer
                                    echo '<tfoot>
                                            <tr>
                                              <td></td>
                                              <td align="right"><strong>Jumlah Total...</strong></td>
                                              <td>'.angkrp(totalpot($dt[id_Spm])).'</td>
                                              <td></td>
                                            </tr>
                                          </tfoot>';
                                    echo '</table>';
                                  echo '</div>

          												<div id="dropdown14" class="tab-pane">
                                    <p> Check-list Kelengkapan Dokumen Pengajuan SPM</p>
                                    <table class="table table-striped table-bordered">
                                      <thead>
                                      <tr>
                                        <th></th>
                                        <th><input type="checkbox"></th>
                                        <th>Jenis Dokumen</th>
                                        <th>File</th>
                                        <th>Catatan verifikasi</th>
                                      </tr>
                                        </thead>
                                        <tbody>';

                                      function ck_document($id_Cklist, $id_Spm,$aksi,$str) {
                                        $q = mysql_query("SELECT * FROM uploadberkas
                                                            WHERE id_Cklist = '$id_Cklist'
                                                            AND id_Spm = '$id_Spm'");
                                        $r = mysql_fetch_array($q);
                                        $hit = mysql_num_rows($q);
                                        if($str == "file") {
                                          if($hit > 0) {
                                            $ck = '<a href="media/'.$_SESSION[thn_Login].'/'.$r[fileupload].'" target="_blank" class="btn btn-success btn-minier"><i class="fa fa-files-o"></i> File Upload</a>';
                                          } else {
                                            $ck ="";
                                          }
                                        } elseif($str == "comment") {
                                          $ck = $r[Keterangan];
                                        } else {
                                          $ck = '<button type="submit" name="simpan" value="'.$r[id_Upload].'" class="btn btn-minier btn-primary"><i class="fa fa-save"></i> Simpan</button>';
                                        }
                                        return $ck;
                                      }

                                    //untuk daftar check list
                                    $q3 = mysql_query("SELECT * FROM cklist a
                                                      WHERE a.Jenis = '$dt[Jenis]'
                                                      AND a.Aktiv = 1");

                                    $no=1;

                                          while($r1=mysql_fetch_array($q3)) {
                                            echo '<tr>
                                              <td>'.$no++.'</td>
                                              <td><input type="checkbox"></td>
                                              <td>'.$r1[nm_List].'</td>
                                              <td>'.ck_document($r1[id_Cklist],$dt[id_Spm],$aksi,'file').'</td>
                                              <td>'.ck_document($r1[id_Cklist],$dt[id_Spm],$aksi,'comment').'</td>
                                            </tr>';
                                          }
                                    echo '</tbody></table>
                                  </div>

                                  <div id="status" class="tab-pane">';
                                    //ini untuk mengubah status dari spm yg diajukan
                                    echo '<form action="modul/act_modverifikasi.php?module=pengesahanbud&act=pengebud" method="post">';
                                          $dt[tgl_Pengbud] == "0000-00-00" ? $tglbud = "$_SESSION[thn_Login]-01-01" : $tglbud = $dt[tgl_Pengbud];
          													echo '<div class="form-horizontal">
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label" for="form-field-1"> Tgl Pengesahan </label>
                                              <div class="col-sm-10">
                                                <input type="text" id="form-field-1" name="tgl_Pengbud" value="'.$tglbud.'" placeholder="Tanggal" class="date-picker" data-date-format="yyyy-mm-dd" required/>
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label" for="form-field-1"> Informasi BUD </label>
                                              <div class="col-sm-5">
                                                <textarea class="form-control" name="InformasiBud">'.$dt[InformasiBud].'</textarea>
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label for="inputPassword3" class="col-sm-2 control-label">Status Pengesahan</label>
                                              <div class="col-sm-10">
                                                <input type="hidden" name="id_Ver" value="'.$dt[id_Ver].'">
                                                <input type="hidden" name="StatusPengbud" value="'.$dt[StatusPengbud].'">
                                                <input type="hidden" name="StatusSp2d" value="'.$dt[StatusSp2d].'">
                                                <select class="col-xs-10 col-sm-5" name="StatusPengbud" onchange="" required>';
                                                    $status = array(1 => 'Draf',2=>'Final / Sahkan',3=>'Ditolak' );
                                                    foreach ($status as $key => $value) {
                                                      if($key == $dt[StatusPengbud]) {
                                                        echo "<option value='$key' selected>$value</option>";
                                                      } else {
                                                        echo "<option value='$key'>$value</option>";
                                                      }
                                                    }

                                                echo '</select>
                                              </div>
                                            </div>
                                          </div>';
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
                                      <a href="?module=pengesahanbud" class="btn btn-success" >
                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                        Kembali
                                      </a>
                                    </div>
                                  </div>
                                  </form>
                                  </div>';

          												echo '</div>
          										</div>
          									</div>';




											echo '</div>
										</div>
									</div>';



	break;
  case 'edit':
      if($_SESSION['UserLevel']==1) {
        $sql = mysql_query("SELECT * FROM ttdbukti
                              WHERE id_Spm = '$_GET[id]'");
      } else {
        $sql = mysql_query("SELECT * FROM spm WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                      AND id_Spm= '$_GET[id]'");
      }
      $r = mysql_fetch_array($sql);
      echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modspm.php?module=spm&act=edit">
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
                <label class="col-sm-2 control-label" for="form-field-1"> Tanggal</label>
                <input type="text" id="form-field-1" name="Tanggal" placeholder="Tanggal" class="date-picker" data-date-format="yyyy-mm-dd"  value="'.$r[Tanggal].'" required/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Anggaran </label>
              <div class="col-sm-10">
                <input type="text" id="form-field-1" placeholder="Anggaran SPM" name="Anggaran" class="col-xs-10 col-sm-5" value="'.$r[Anggaran].'"  required/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis Kegiatan </label>
              <div class="col-sm-10">
                <input type="text" id="form-field-1" placeholder="Username" name="JnsKegiatan" class="col-xs-10 col-sm-5"/>
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
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload SPM </label>
              <div class="col-sm-10">
                <input type="file" accept="image/*" name="fl_Spm" class="col-xs-4 col-sm-4"><a class="btn btn-warning btn-xs" target="_blank" href="media/spm/'.$_SESSION[thn_Login].'/'.$r[fl_Spm].'"><i class="fa fa-image"> </i>Tampilkan</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload SPP 1 </label>
              <div class="col-sm-10">
                <input type="file" accept="image/*" name="fl_Spp1" class="col-xs-10 col-sm-4"><a class="btn btn-warning btn-xs" target="_blank" href="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp1].'"><i class="fa fa-image"> </i>Tampilkan</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload  SPP 2 </label>
              <div class="col-sm-10">
                <input type="file" accept="image/*" name="fl_Spp2" class="col-xs-10 col-sm-4"><a class="btn btn-warning btn-xs" target="_blank" href="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp2].'"><i class="fa fa-image"> </i>Tampilkan</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload SPP 3 </label>
              <div class="col-sm-10">
                <input type="file" accept="image/*" name="fl_Spp3" class="col-xs-10 col-sm-4"><a class="btn btn-warning btn-xs" target="_blank" href="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp3].'"><i class="fa fa-image"> </i>Tampilkan</a>
              </div>
            </div>';
            echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
            echo "<input type='hidden' name='id_Spm' value='$r[id_Spm]'>";
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#myTable').DataTable();
});
function md_pengbud(id_Spm)
{
  $.ajax({
        url: 'library/ax_pengesahanbud.php',
        data : 'id_Spm='+id_Spm,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_ProsesSpm').html(response);
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



  //kembali
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});

</script>
