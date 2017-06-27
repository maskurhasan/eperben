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
                      <div class="col-md-6">';
                          echo "<button class='btn btn-sm btn-primary btn-fill pull-right' name='tambahsubdak' onClick=\"window.location.href='?module=sp2d&act=daftarspm'\"><i class='fa fa-plus-circle'></i> Tambah SP2D</button>";
                        echo '</div>
                    </div>
                  </div>
                  <div class="content table-responsive">
                    <table id="myTable" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th></th><th>SPM</th><th>Tanggal</th>
                        <th>Jenis</th><th>Anggaran</th><th>SP2D</th><th>SKPD</th><th>Status Pengesahan</th><th></th>
                      </tr>
                      </thead>
                      <tbody>';

                      //data yang ditampilkan pada halaman user sesuai dengan role
                      if($_SESSION['UserLevel']==1) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd,c.StatusVer  FROM spm a, skpd b, verifikasi c
                                            WHERE a.id_Skpd = b.id_Skpd
                                            AND a.id_Spm = c.id_Spm");
                      } elseif($_SESSION['UserLevel']==5) {
                         $sql= mysql_query("SELECT a.*,b.nm_Skpd,d.nm_Lengkap,c.id_Ver,c.StatusSp2d,c.NomorSp2d FROM spm a, skpd b,verifikasi c, user d
                                      WHERE a.id_Skpd = b.id_Skpd
                                      AND a.id_Spm = c.id_Spm
                                      AND c.id_User = d.id_User
                                      AND c.StatusVer = 1
                                      AND c.StatusPengbud = 2
                                      AND c.StatusSp2d <> 0");
                      } else {
                        $sql = "";
                      }
                      $no=1;
      				        while($dt = mysql_fetch_array($sql)) {
                        $jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
                        $status = array(1=>'<span class="label label-warning arrowed-in">Draf</span>',2=>'<span class="label label-success arrowed">Final</span>',3=>'<span class="label label-danger">Ditolak</span>');
                        $jns = $dt['Jenis'];
                        $sttver = $status[$dt[StatusSp2d]];

                        echo "<tr>
                                <td>".$no++."</td>
                                <td>$dt[Nomor]</td>
                                <td>$dt[Tanggal]</td>
                                <td>$jns_spm[$jns]</td>
                                <td>".angkrp($dt[Anggaran])."</td>
                                <td>$dt[NomorSp2d]</td>
                                <td>$dt[nm_Skpd]</td>
                                <td>$sttver</td>
                                <td class=align-center><button role='button' href='#modal-form' value='$dt[id_Ver]' id='id_Ver' onClick='md_vwsp2d(this.value)' class='btn btn-success btn-minier' data-toggle='modal'><i class='fa fa-edit fa-lg'></i>  Edit </button> <br>";
                                  echo "<a href='modul/act_modverifikasi.php?module=sp2d&act=hapussp2d&id=$dt[id_Ver]'  class='btn btn-minier btn-danger' onclick=\"javascript: return confirm('Anda yakin hapus ?')\">
                                      <i class='fa fa-trash-o fa-lg' ></i> Hapus</a>";
                                  echo "<a href='?module=sp2d&act=upload&id=$dt[id_Ver]'  class='btn btn-minier btn-primary'>
                                      <i class='fa fa-files-o' ></i> Upload SP2D</a>";

                                echo '</td>
                              </tr>';
                      }
                    echo '<tbody></table>


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
                                <form method=post action="modul/act_modverifikasi.php?module=sp2d&act=add">
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
  case 'daftarspm':
  echo '<div class="col-md-12">
          <div class="card">
            <div class="header">
              <div class="row">
                <div class="col-md-6">Daftar SPM Disahkan</div>
                <div class="col-md-6">';
                    echo "<a href='?module=sp2d' class='btn btn-sm btn-danger btn-fill pull-right' role='button' id='id_Spm'><i class='fa fa-reply'></i> Kembali</a>";
                  echo '</div>
              </div>
            </div>
            <div class="content table-responsive">
              <table id="myTable" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                  <th></th><th>Nomor</th><th>Tanggal</th>
                  <th>Jenis</th><th>Anggaran</th><th>SKPD</th><th>Verifikator</th><th></th>
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
                                      AND c.StatusPengbud = 1 ");
                } elseif ($_SESSION['UserLevel']==5) {
                  $sql= mysql_query("SELECT a.*,b.nm_Skpd,d.nm_Lengkap,c.id_Ver FROM spm a, skpd b,verifikasi c, user d
                                      WHERE a.id_Skpd = b.id_Skpd
                                      AND a.id_Spm = c.id_Spm
                                      AND c.id_User = d.id_User
                                      AND c.StatusVer = 1
                                      AND c.StatusPengbud = 2
                                      AND c.StatusSp2d = 0");
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
                          <td class=align-center>
                              <button role='button' href='#modal-form' value='$dt[id_Ver]' id='id_Ver' onClick='md_vwsp2d(this.value)' class='btn btn-success btn-sm' data-toggle='modal'> Proses Cetak SP2D </button>";
                              echo "";
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
                          <form method=post action="modul/act_modverifikasi.php?module=sp2d&act=add">
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
	case 'upload':
  $sql = "SELECT * FROM verifikasi WHERE id_Ver = $_GET[id]";
  $q = mysql_query($sql);
  $r = mysql_fetch_array($q);
	  echo '<div class="content table-responsive">
        <div class="col-md-8">
          <div class="widget-box">
              <div class="widget-header">
                <h4 class="smaller">
                  Upload SP2D
                </h4>
              </div>
              <div class="widget-body">
                <div class="widget-main">';
                if(empty($r[fl_sp2d])) {
                  echo '<form method="post" action="modul/act_modverifikasi.php?module=sp2d&act=uploadsp2d" class="form-horizontal" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">SP2D :</label>
                        <div class="col-sm-6">
                          <input type="file" accept="image/*" name="fl_sp2d" value="" required/>
                        </div>
                        <div class="col-sm-2">
                          <button type="submit" name="simpanupload" class="btn btn-minier btn-primary"><i class="fa fa-upload"></i> Upload</button>
                          <input type="hidden" name="StatusSp2d" value="'.$r[StatusSp2d].'">
                          <input type="hidden" name="id_Skpd" value="'.$_SESSION[id_Skpd].'">
                          <input type="hidden" name="id_Ver" value="'.$r[id_Ver].'">
                        </div>
                      </div>
                  </form>';
                } else {
                  echo 'Dokumen SP2D : <a href="media/'.$_SESSION[thn_Login].'/sp2d/'.$r[fl_sp2d].'" target="_blank" class="btn btn-success btn-minier"><i class="fa fa-files-o"></i> File Upload</a>';
                }
                echo '</div>
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

function md_vwsp2d(id_Ver)
{
  $.ajax({
        url: 'library/ax_vwcetaksp2d.php',
        data : 'id_Ver='+id_Ver,
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
