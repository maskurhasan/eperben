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
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                      <div class="input-group pull-right" style="width: 350px;">
                        <input type="text" name="table_search" class="form-control" placeholder="Search">
                        <div class="input-group-btn">
                          <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                          echo "<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=spm&act=add'\"><i class='fa fa-plus'></i> Tambah SPM</button>";
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
                        <th>Jenis</th><th>Anggaran</th><th>Status</th><th></th>
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
                      $no=1;
      				        while($dt = mysql_fetch_array($sql)) {
                        $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                        $jns = $dt['Jenis'];

                        $status = array(0=>'<span class="label label-warning arrowed-in">Draf</span>',1=>'<span class="label label-success arrowed">Final</span>',2=>'<span class="label label-danger">Ditolak</span>');
                        $sttver = $status[$dt[StatusSpm]];

                        echo "<tr>
                                <td>".$no++."</td>
                                <td>$dt[Nomor] </td>
                                <td>$dt[Tanggal]</td>
                                <td>$jns_spm[$jns]</td>
                                <td>".angkrp(totalspm($dt[id_Spm]))."</td>
                                <td>$sttver</td>
                                <td class=align-center><a href='?module=spm&act=edit&id=$dt[id_Spm]'><i class='fa fa-edit fa-lg'></i> Edit</a> ";
                                    echo "<a href='?module=spm&act=kegiatan&id=$dt[id_Spm]'><i class='fa fa-cog fa-lg'></i> Kegiatan</a>  ";
                                    echo "<a href='?module=spm&act=potongan&id=$dt[id_Spm]'><i class='fa fa-check fa-lg'></i> Potongan</a>  ";
                                    echo "<a href='modul/act_modspm.php?module=spm&act=hapusspm&id=$dt[id_Spm]' onclick=\"javascript: return confirm('Anda yakin hapus ?')\"><i class='fa fa-trash-o fa-lg'></i> Hapus</a>";

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
	case "add" :
		    echo '<form class="form-horizontal" role="form" method="post" action="modul/act_modspm.php?module=spm&act=add" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis SPM </label>
                    <div class="col-sm-10">';
                    $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                    echo "<select name='Jenis' class='col-xs-10 col-sm-5' id='form-field-1' required>
                            <option value=''>-Pilih Jenis SPM-</option>";
                          foreach ($jns_spm as $key => $value) {
                            echo "<option value=$key>$value</option>";
                          }
                    echo "</select>";
                    echo '</div>
                  </div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nomor SPM </label>
										<div class="col-sm-10">
											<input type="text" id="form-field-1" name="Nomor" placeholder="Nomor SPM" class="col-xs-10 col-sm-5" required/>
                      <label class="col-sm-2 control-label" for="form-field-1"> Tanggal</label>
                      <input type="text" id="form-field-1" name="Tanggal" placeholder="Tanggal" class="date-picker" data-date-format="yyyy-mm-dd" required/>
                    </div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Anggaran </label>
										<div class="col-sm-10">
											<input type="text" id="form-field-1" placeholder="Anggaran SPM" name="Anggaran" class="col-xs-10 col-sm-5" required/>
										</div>
									</div>
                  <!--
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis Kegiatan </label>
										<div class="col-sm-10">
											<input type="text" id="form-field-1" placeholder="Jenis Keg" name="JnsKegiatan" class="col-xs-10 col-sm-5"/>
										</div>
									</div>
                  -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Kepala SKPD </label>
                    <div class="col-sm-10">';
                    $qx = mysql_query("SELECT id,NamaTtd FROM ttdbukti WHERE Jabatan = 1 AND id_Skpd = '$_SESSION[id_Skpd]'");
                    echo "<select name='KepalaSkpd' class='col-xs-10 col-sm-5' id='form-field-1' required>
                            <option value=''>[Pilih]</option>";
                          while ($rx = mysql_fetch_array($qx)){
                            echo "<option value=$rx[id]>$rx[NamaTtd]</option>";
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
                            echo "<option value=$rx[id]>$rx[NamaTtd]</option>";
                          }
                    echo "</select>";
                    echo '</div>
                  </div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Keterangan </label>
										<div class="col-sm-10">
											<textarea id="form-field-1" placeholder="Keterangan" name="Keterangan" class="col-xs-10 col-sm-5" ></textarea>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload SPM </label>
										<div class="col-sm-10">
                      <input type="file" accept="image/*" name="fl_Spm" class="col-xs-10 col-sm-5" required>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload SPP 1 </label>
										<div class="col-sm-10">
                      <input type="file" accept="image/*" name="fl_Spp1" class="col-xs-10 col-sm-5" required>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload  SPP 2 </label>
										<div class="col-sm-10">
                      <input type="file" accept="image/*" name="fl_Spp2" class="col-xs-10 col-sm-5" required>
										</div>
									</div>
                  <div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Upload SPP 3 </label>
										<div class="col-sm-10">
                      <input type="file" accept="image/*" name="fl_Spp3" class="col-xs-10 col-sm-5" required>
										</div>
									</div>';
                  echo "<input type='hidden' name='id_Skpd' value='$_SESSION[id_Skpd]'>";
									echo '<div class="clearfix form-actions">
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

									<div class="hr hr-24"></div>
                  </form>
								';

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

      function totalspm($id_Spm)
      {
        $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                            WHERE c.id_Spm = '$id_Spm'");
        $r = mysql_fetch_array($sql);
        return $r[total];
      }
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
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Status SPM </label>
              <div class="col-sm-10">';
              $status = array(0=>'Draf',1=>'Final');
              echo "<select name='StatusSpm' class='col-xs-10 col-sm-5' id='form-field-1' required>
                      <option value=''>-Pilih Status-</option>";
                    foreach ($status as $key => $value) {
                      if($key == $r[StatusSpm]) {
                        echo "<option value='$key' selected>$value</option>";
                      } else {
                        echo "<option value=$key>$value</option>";
                      }
                    }
              echo "</select>";
              echo '</div>
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

            <div class="hr hr-24"></div>
            </form>

          ';
  break;
  case 'kegiatan':
      if($_SESSION['UserLevel']==1) {
        $sql = mysql_query("SELECT * FROM ttdbukti
                              WHERE id_Spm = '$_GET[id]'");
      } else {
        $sql = mysql_query("SELECT * FROM spm WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                      AND id_Spm= '$_GET[id]'");
      }
      $r = mysql_fetch_array($sql);
      echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                  <div class="row">
                    <div class="col-md-6">Daftar Kegiatan</div>
                    <div class="col-md-6">
                    <div class="input-group pull-right" style="width: 350px;">
                      <input type="text" name="table_search" class="form-control" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                        echo "<a href='?module=spm' class='btn btn-sm btn-danger btn-fill' role='button' id='id_Spm'><i class='fa fa-plus'></i> Kembali</a>";
                        //munculkan tombol jika spm masih draf
                        if($r[StatusSpm] == 0) {
                          echo "<button class='btn btn-sm btn-warning btn-fill' role='button' href='#modal-form' id='id_Spm' value='$r[id_Spm]' data-toggle='modal' id='id_Spm' onClick='md_pengbud(this.value)'><i class='fa fa-plus'></i> Tambah Kegiatan</button>";
                        } else {
                          echo "";
                        }
                      echo '</div>
                    </div>
                    </div>
                  </div>
                </div>
                <div class="content table-responsive">
                  <table id="tabledata" class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                    <tr>
                      <th></th><th>Kegiatan</th>
                      <th>Anggaran</th><th>Realisasi</th><th>Nilai SPM</th><th>Sisa</th><th></th>
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
                      $sql= mysql_query("SELECT b.*,d.nm_Kegiatan,c.Nilai,c.id_Rincspm,c.id_DataKegiatan AS jnsk FROM spm a,datakegiatan b,rincspm c,kegiatan d
                                          WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                                          AND a.id_Spm = c.id_Spm
                                          AND c.id_DataKegiatan = b.id_DataKegiatan
                                          AND b.id_Kegiatan = d.id_Kegiatan
                                          AND a.id_Spm = '$_GET[id]'");
                    }

                    $no=1;
                    while($dt = mysql_fetch_array($sql)) {
                      $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                      $jns = $dt['Jenis'];

                      $status = array(0=>'<span class="label label-warning arrowed-in">Draf</span>',1=>'<span class="label label-success arrowed">Final</span>',2=>'<span class="label label-danger">Ditolak</span>');
                      $sttver = $status[$dt[StatusSpm]];

                      echo "<tr>
                              <td>".$no++."</td>
                              <td>$dt[nm_Kegiatan]</td>
                              <td>".angkrp($dt[AnggKeg])."</td>
                              <td>".angkrp(realisasi($dt[jnsk]))."</td>
                              <td>".angkrp($dt[Nilai])."</td>
                              <td>$sttver</td>
                              <td class=align-center><button role='button' class='btn btn-minier btn-success' href='#modal-form-edit' id='id_Rincspm' value='$dt[id_Rincspm]' data-toggle='modal' onClick='md_editpengbud(this.value)'><i class='fa fa-edit fa-lg'></i> Edit</button> ";
                                  echo "<button href='#'  class='btn btn-minier btn-danger'><i class='fa fa-trash-o fa-lg'></i> Hapus</button>";

                              echo '</td>
                            </tr>';
                    }

                  echo '<tbody>';
                  //footer
                  echo '<tfoot>
                          <tr>
                            <td></td>
                            <td align="right"><strong>Jumlah Total...</strong></td>
                            <td>'.angkrp(totalangg($_GET[id])).'</td>
                            <td></td>
                            <td>'.angkrp(totalspm($_GET[id])).'</td>
                            <td>Rp. 100</td>
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
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                        echo "<a href='?module=spm' class='btn btn-sm btn-danger btn-fill' role='button' id='id_Spm'><i class='fa fa-undo'></i> Kembali</a>";
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
                  <table id="tabledata" class="table table-striped table-bordered table-hover table-responsive">
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
                                  echo "<button href='#'  class='btn btn-minier btn-danger'><i class='fa fa-trash-o fa-lg'></i> Hapus</button>";

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
          $('#id_ProsesSpm').html(response);
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

</script>
