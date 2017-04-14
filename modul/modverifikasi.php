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
                          echo "<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=verifikasi&act=daftarspm'\"><i class='fa fa-plus'></i> Tambah Verifikasi SPM</button>";
                        echo '</div>
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="content table-responsive">
                    <table id="tabledata" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th></th><th>Nomor</th><th>Tanggal</th>
                        <th>Jenis</th><th>SKPD</th><th>Anggaran</th><th>Status Verifikasi</th><th></th>
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
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd,c.StatusVer,c.StatusPengbud  FROM spm a, skpd b, verifikasi c
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Spm = c.id_Spm
                                            AND a.TahunAngg = '$_SESSION[thn_Login]'");
                      } elseif($_SESSION['UserLevel']==3) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd,c.StatusVer,c.id_Ver,b.nm_Skpd,c.StatusPengbud FROM spm a, skpd b, verifikasi c
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Spm = c.id_Spm
                                            AND c.id_User = '$_SESSION[id_User]'
                                            AND a.TahunAngg = '$_SESSION[thn_Login]'");
                      } else {
                        $sql = "";
                      }
                      $no=1;
      				        while($dt = mysql_fetch_array($sql)) {
                        $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                        $status = array(0=>'<span class="label label-warning arrowed-in">Draf</span>',1=>'<span class="label label-success arrowed">Final</span>',2=>'<span class="label label-danger">Ditolak</span>');
                        $jns = $dt['Jenis'];
                        $sttver = $status[$dt[StatusVer]];
                        $dt[StatusPengbud] > 0 ? $ik = "<i class='fa fa-lock'></i>" : $ik = "";
                        echo "<tr>
                                <td>".$no++."</td>
                                <td>$ik $dt[Nomor]</td>
                                <td>$dt[Tanggal]</td>
                                <td>$jns_spm[$jns]</td>
                                <td>$dt[nm_Skpd]</td>
                                <td>".angkrp(totalspm($dt[id_Spm]))."</td>
                                <td>$sttver</td>
                                <td class=align-center>
                                  <a class='btn btn-primary btn-minier' href='?module=verifikasi&act=add&id=$dt[id_Ver]'><i class='fa fa-edit fa-lg'></i> Proses</a>
                                  <a class='btn btn-danger btn-minier' href='modul/act_modverifikasi.php?module=verifikasi&act=hapusver&id=$dt[id_Ver]' onclick=\"javascript: return confirm('Anda yakin hapus ?')\"><i class='fa fa-trash fa-lg'></i> Hapus</a>";

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
                <div class="col-md-6">Daftar SPM Belum Verifikasi</div>
                <div class="col-md-6">
                <div class="input-group pull-right" style="width: 350px;">
                  <input type="text" name="table_search" class="form-control" placeholder="Search">
                  <div class="input-group-btn">
                    <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                    echo "<a href='?module=verifikasi' class='btn btn-sm btn-danger btn-fill' role='button' id='id_Spm'><i class='fa fa-plus'></i> Kembali</a>";
                  echo '</div>
                </div>
                </div>
              </div>
            </div>
            <div class="content table-responsive">';

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
                                      AND a.StatusSpm = 1
                                      AND a.id_Spm NOT IN (SELECT id_Spm FROM verifikasi");
                } else {
                  $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM spm a, skpd b
                                      WHERE a.id_Skpd = b.id_Skpd
                                      AND a.StatusSpm = 1
                                      AND a.id_Spm NOT IN (SELECT id_Spm FROM verifikasi)");
                }
                $hit = mysql_num_rows($sql);
                //tampilkan jika 0
                if($hit <= 0) {
                  echo "<div class='well'>
                          SPM Belum Tersedia <a href='?module=verifikasi' class='btn btn-success btn-sm' >
                          <i class='ace-icon fa fa-undo bigger-110'></i>Kembali</a></div>";
                } else {
                  echo '<table id="tabledata" class="table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <th></th><th>Nomor</th><th>Tanggal</th>
                    <th>Jenis</th><th>Anggaran</th><th>SKPD</th><th></th>
                  </tr>
                  </thead>
                  <tbody>';

                  $no=1;
                  while($dt = mysql_fetch_array($sql)) {
                    $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                    $jns = $dt['Jenis'];

                    echo "<tr>
                            <td>".$no++."</td>
                            <td>$dt[Nomor]</td>
                            <td>$dt[Tanggal]</td>
                            <td>$jns_spm[$jns]</td>
                            <td>".angkrp(totalspm($dt[id_Spm]))."</td>
                            <td>$dt[nm_Skpd]</td>
                            <td class=align-center><button role='button' href='#modal-form' value='$dt[id_Spm]' id='id_Spm' onClick='md_verspm(this.value)' class='btn btn-success btn-sm' data-toggle='modal'> Proses Verifikasi </button>";
                            echo '</td>
                          </tr>';
                  }
                echo '<tbody></table>';
              }
            echo '<div class="footer">
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
												<h4 class="smaller lighter blue no-margin">Verifikasi Data SPM</h4>
											</div>

											<div class="modal-body">
                      <div class="row">
                          <div class="col-xs-12 col-sm-12">
                          <form method=post action="modul/act_modverifikasi.php?module=verifikasi&act=add">
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


  break;
	case "add" :
        $sql= "SELECT a.*,b.nm_Skpd,c.* FROM spm a, skpd b, verifikasi c
                            WHERE a.id_Skpd = b.id_Skpd
                            AND a.StatusSpm = 1
                            AND a.id_Spm = c.id_Spm
                            AND c.id_User = '$_SESSION[id_User]'
                            AND c.id_Ver = '$_GET[id]'";
        $q = mysql_query($sql);
        $dt = mysql_fetch_array($q);
        $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
        $jns = $dt['Jenis'];


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
              '.$dt['Nomor'].'  Tanggal '.$dt['Tanggal'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Anggaran </div>
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
            <div class="profile-info-name"> Jenis SPM </div>
            <div class="profile-info-value">
              '.$jns_spm[$jns].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Nomor</div>
            <div class="profile-info-value">
              '.$dt['Nomor'].'  Tanggal '.$dt['Tanggal'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Anggaran </div>
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

        echo '<p>&nbsp;</p>';

        //mulai tab
        echo '<div class="col-sm-12 widget-container-col">
										<div class="widget-box transparent">
											<div class="widget-header">
												<h4 class="widget-title lighter">Transparent Box</h4>

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
          													<a data-toggle="tab" href="#profile4"><i class="ace-icon fa fa-folder"></i> Lampiran Bukti</a>
          												</li>

          												<li>
          													<a data-toggle="tab" href="#dropdown14"><i class="ace-icon fa fa-check"></i> Check-list Kelengkapan</a>
          												</li>

                                  <li>
          													<a data-toggle="tab" href="#status"><i class="ace-icon fa fa-refresh"></i> Ubah Status</a>
          												</li>
          											</ul>

          											<div class="tab-content">
          												<div id="home4" class="tab-pane in active">
          													';
                                    //rincian kegiatan spm
                                    echo '
                                    <table id="tabledata" class="table table-striped table-bordered table-hover table-responsive">
                                      <thead>
                                      <tr>
                                        <th></th><th>Kegiatan</th>
                                        <th>Anggaran</th><th>Nilai SPM</th>
                                      </tr>
                                      </thead>
                                      <tbody>';
                                      //data yang ditampilkan pada halaman user sesuai dengan role
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

                                      if($_SESSION['UserLevel']==1) {
                                        $sql= mysql_query("SELECT a.*,b.nm_Skpd FROM spm a, skpd b
                                                            WHERE a.id_Skpd = b.id_Skpd");
                                      } else {
                                        $sql= mysql_query("SELECT b.*,d.nm_Kegiatan,c.Nilai,c.id_Rincspm FROM spm a,datakegiatan b,rincspm c,kegiatan d
                                                            WHERE a.id_Spm = c.id_Spm
                                                            AND c.id_DataKegiatan = b.id_DataKegiatan
                                                            AND b.id_Kegiatan = d.id_Kegiatan
                                                            AND a.id_Spm = '$dt[id_Spm]'");
                                      }

                                      $no=1;
                                      while($dt = mysql_fetch_array($sql)) {
                                        //$jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                                        //$jns = $dt['Jenis'];

                                        //$status = array(0=>'<span class="label label-warning arrowed-in">Draf</span>',1=>'<span class="label label-success arrowed">Final</span>',2=>'<span class="label label-danger">Ditolak</span>');
                                        //$sttver = $status[$dt[StatusSpm]];

                                        echo "<tr>
                                                <td>".$no++."</td>
                                                <td>$dt[nm_Kegiatan]</td>
                                                <td>".angkrp($dt[AnggKeg])."</td>
                                                <td>".angkrp($dt[Nilai])."</td>
                                              </tr>";
                                      }

                                    echo '<tbody>';
                                    echo '<tfoot>
                                            <tr>
                                              <td></td>
                                              <td align="right"><strong>Jumlah Total...</strong></td>
                                              <td>'.angkrp(totalangg($_GET[id])).'</td>
                                              <td>'.angkrp(totalspm($_GET[id])).'</td>
                                            </tr>
                                          </tfoot>';
                                    echo '</table>';

                                  echo '</div>

          												<div id="profile4" class="tab-pane">
          													<p>Lampiran Bukti SPM / SPP</p>
                                          <ul class="ace-thumbnails clearfix">';
                        										$q = mysql_query("SELECT a.fl_Spm,a.fl_Spp1,a.fl_Spp2,a.fl_Spp3 FROM spm a, verifikasi b
                                                              WHERE a.id_Spm = b.id_Spm
                                                              AND b.id_Ver = '$_GET[id]'");
                                            $r = mysql_fetch_array($q);
                                            echo '<li>
                        											<a href="media/spm/'.$_SESSION[thn_Login].'/'.$r[fl_Spm].'" data-rel="colorbox" target="_blank">
                        												<img width="150" height="150" alt="150x150" src="media/spm/'.$_SESSION[thn_Login].'/'.$r[fl_Spm].'" />
                        												<div class="text">
                        													<div class="inner bottom">SPM</div>
                        												</div>
                        											</a>
                        										</li>

                                            <li>
                                              <a href="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp1].'" data-rel="colorbox" target="_blank">
                                                <img width="150" height="150" alt="150x150" src="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp1].'" />
                                                <div class="text">
                                                  <div class="inner bottom">SPP-1</div>
                                                </div>
                                              </a>
                                            </li>

                                            <li>
                                              <a href="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp2].'" data-rel="colorbox" target="_blank">
                                                <img width="150" height="150" alt="150x150" src="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp2].'" />
                                                <div class="text">
                                                  <div class="inner bottom">SPP-2</div>
                                                </div>
                                              </a>
                                            </li>

                                            <li>
                                              <a href="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp3].'" data-rel="colorbox" target="_blank">
                                                <img width="150" height="150" alt="150x150" src="media/spp/'.$_SESSION[thn_Login].'/'.$r[fl_Spp3].'" />
                                                <div class="text">
                                                  <div class="inner bottom">SPP-3</div>
                                                </div>
                                              </a>
                                            </li>

                        									</ul>';

                                  echo '</div>

          												<div id="dropdown14" class="tab-pane">
                                      <form action="modul/act_modverifikasi.php?module=verifikasi&act=lampver" method="post">
                                        <p> Check-list Kelengkapan Dokumen Pengajuan SPM </p>';

                                        //tampilkan data dari table verifikasi
                                        $q1 = mysql_query("SELECT a.Jenis,b.id_Ver,b.StatusVer FROM spm a, verifikasi b
                                                            WHERE b.id_Ver = '$_GET[id]'
                                                            AND a.id_Spm = b.id_Spm ");
                                        $r1 = mysql_fetch_array($q1);

              													//untuk daftar check list
                                        $q = mysql_query("SELECT a.*,b.Isian FROM cklist a
                                                          LEFT JOIN ketcklist b
                                                          ON a.id_Cklist = b.id_Cklist
                                                          AND b.id_Ver = '$r1[id_Ver]'
                                                          WHERE a.Jenis = '$r1[Jenis]'");

                                        $no=1;
                                        echo '<table class="table table-condensed">';
                                              while($r=mysql_fetch_array($q)) {
                                                echo "<input type=hidden name='id_Cklist[]' value='$r[id_Cklist]'>";
                                                echo '<tr>
                                                  <td>'.$no++.'</td><td><input type="checkbox" checked></td><td>'.$r[nm_List].'</td><td><input name="Isian[]" type="text" value="'.$r[Isian].'"></td>
                                                </tr>';
                                              }
                                        echo '</table>
                                      <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                          <input type="hidden" name="id_Ver" value="'.$_GET[id].'">
                                          <input type="hidden" name="StatusVer" value="'.$r1[StatusVer].'">
                                          <button class="btn btn-primary" type="submit" name="Simpan">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Simpan
                                          </button>
                                          &nbsp; &nbsp; &nbsp;
                                          <button class="btn" type="reset">
                                            <i class="ace-icon fa fa-refresh bigger-110"></i>
                                            Reset
                                          </button>

                                          &nbsp; &nbsp; &nbsp;
                                          <a href="?module=verifikasi" class="btn btn-success" >
                                            <i class="ace-icon fa fa-undo bigger-110"></i>
                                            Kembali
                                          </a>
                                        </div>
                                      </div>
                                    </form>
                                  </div>

                                  <div id="status" class="tab-pane">';
                                    //ini untuk mengubah status dari spm yg diajukan
                                    echo '<form action="modul/act_modverifikasi.php?module=verifikasi&act=ubahstatus" method="post">';
                                          $qq = mysql_query("SELECT * FROM verifikasi WHERE id_Ver = '$_GET[id]'");
                                          $rq = mysql_fetch_array($qq);
                                          //default tanggal verifikasi
                                          $rq[tgl_Ver] == "0000-00-00" ? $tglver = "$_SESSION[thn_Login]-01-01" : $tglver = $rq[tgl_Ver];

          													echo '<div class="form-horizontal">
                                            <div class="form-group">
                                              <label class="col-sm-2 control-label" for="form-field-1"> Tgl Verifikasi </label>
                                              <div class="col-sm-10">
                                                <input type="text" id="form-field-1" name="tgl_Ver" value="'.$tglver.'" placeholder="Tanggal" class="date-picker" data-date-format="yyyy-mm-dd" required/>
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <label for="inputPassword3" class="col-sm-2 control-label">Status Verifikasi</label>
                                              <div class="col-sm-10">
                                                <input type="hidden" name="id_Ver" value="'.$rq[id_Ver].'">
                                                <select class="col-xs-10 col-sm-5" name="StatusVer" onchange="" required>';
                                                    $status = array(0 => 'Draf',1=>'Final',2=>'Ditolak' );
                                                    foreach ($status as $key => $value) {
                                                      if($key == $rq[StatusVer]) {
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
                                      <a href="?module=verifikasi" class="btn btn-success" >
                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                        Kembali
                                      </a>
                                    </div>
                                  </div>
                                  </form>
                                  </div>

          										</div>
          									</div>';

                            echo '
                            <!--
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
                                <a href="?module=verifikasi" class="btn btn-success" >
                                  <i class="ace-icon fa fa-undo bigger-110"></i>
                                  Kembali
                                </a>
          										</div>
          									</div>
                            </form>
                            -->';




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
<script type="text/javascript">

function md_verspm(id_Spm)
{
  $.ajax({
        url: 'library/ax_verifikasispm.php',
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
