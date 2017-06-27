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
                          echo "";
                        echo '</div>
                    </div>
                  </div>
                  <div class="content table-responsive">
                    <table id="myTable" class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                        <th></th><th>SPM</th><th>Tanggal</th>
                        <th>Jenis</th><th>Anggaran</th><th>SKPD</th><th>Status Pengesahan</th><th></th>
                      </tr>
                      </thead>
                      <tbody>';

                      //data yang ditampilkan pada halaman user sesuai dengan role
                      if($_SESSION['UserLevel']==1) {
                        $sql= mysql_query("SELECT a.*,b.nm_Skpd,c.id_Ver,c.StatusSp2d,c.NomorSp2d FROM spm a, skpd b,verifikasi c
                                     WHERE a.id_Skpd = b.id_Skpd
                                     AND a.id_Spm = c.id_Spm
                                     AND c.StatusVer = 1
                                     AND c.StatusPengbud = 2");
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
                                <td>$dt[nm_Skpd]</td>
                                <td>$sttver</td>
                                <td class=align-center>";
                                  echo "<a href='?module=berkas&act=view&id=$dt[id_Ver]'  class='btn btn-minier btn-success'>
                                      <i class='fa fa-files-o' ></i> View</a>";

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
  case 'view':
  echo '<div class="col-md-12">
          <div class="card">
            <div class="header">
              <div class="row">
                <div class="col-md-6">Daftar File SPM</div>
                <div class="col-md-6">';
                    echo "<a href='?module=berkas' class='btn btn-sm btn-danger btn-fill pull-right' role='button' id='id_Spm'><i class='fa fa-reply'></i> Kembali</a>";
                  echo '</div>
              </div>
            </div>
            <div class="content table-responsive">
                <div class="col-md-6">
                  <div class="widget-box">
                      <div class="widget-header">
                        <h4 class="smaller">
                          Lampiran SPM
                        </h4>
                      </div>

                      <div class="widget-body">
                        <div class="widget-main">
                        <table class="table table-striped table-bordered table-condensed">
                          <thead>
                          <tr>
                            <th></th>
                            <th>Jenis Dokumen</th>
                            <th>File</th>
                          </tr>
                            </thead>
                            <tbody>';
                            $sql= "SELECT a.*,b.nm_Skpd,c.* FROM spm a, skpd b, verifikasi c
                                                WHERE a.id_Skpd = b.id_Skpd
                                                AND a.StatusSpm = 1
                                                AND a.id_Spm = c.id_Spm
                                                AND c.id_Ver = '$_GET[id]'";
                            $q = mysql_query($sql);
                            $r = mysql_fetch_array($q);

                          function ck_document($id_Cklist, $id_Spm,$aksi,$str) {
                            $q = mysql_query("SELECT * FROM uploadberkas
                                                WHERE id_Cklist = '$id_Cklist'
                                                AND id_Spm = '$id_Spm'");
                            $r = mysql_fetch_array($q);
                            $hit = mysql_num_rows($q);
                            if($str == "file") {
                              if($hit > 0) {
                                $ck = '<a href="media/'.$_SESSION[thn_Login].'/'.$r[fileupload].'" target="_blank" class="btn btn-success btn-minier"><i class="fa fa-files-o"></i> File</a>';
                              } else {
                                $ck ="";
                              }
                            } elseif($str == "comment") {
                              $ck = '<input name="Keterangan" type="text" value="'.$r[Keterangan].'">';
                            } else {
                              $ck = '<button type="submit" name="simpan" value="'.$r[id_Upload].'" class="btn btn-minier btn-primary"><i class="fa fa-save"></i> Simpan</button>';
                            }
                            return $ck;
                          }

                        //untuk daftar check list
                        $q3 = mysql_query("SELECT * FROM cklist a
                                          WHERE a.Jenis = '$r[Jenis]'
                                          AND a.Aktiv = 1");

                        $no=1;

                              while($r1=mysql_fetch_array($q3)) {
                                echo '<tr>
                                  <td>'.$no++.'</td>
                                  <td>'.$r1[nm_List].'</td>
                                  <td>'.ck_document($r1[id_Cklist],$r[id_Spm],$aksi,'file').'</td>

                                </tr>
                                </form>';
                              }
                        echo '</tbody></table>
                        </div>
                      </div>
                    </div>
                  </div>
                <div class="col-md-6">
                  <div class="widget-box">
                      <div class="widget-header">
                        <h4 class="smaller">
                          Dokumen SPM
                        </h4>
                      </div>

                      <div class="widget-body">
                        <div class="widget-main">
                        <table class="table table-striped table-bordered table-condensed">
                          <thead>
                          <tr>
                            <th></th>
                            <th>Jenis Dokumen</th>
                            <th>File</th>
                          </tr>
                            </thead>
                            <tbody>';
                                echo '<tr>
                                  <td>1</td>
                                  <td>Surat Perintah Pencairan Dana (SP2D)</td>
                                  <td><a href="media/'.$_SESSION[thn_Login].'/sp2d/'.$r[fl_sp2d].'" target="_blank" class="btn btn-success btn-minier"><i class="fa fa-files-o"></i> File Upload</a></td>
                                </tr>';
                        echo '</tbody></table>
                        </div>
                      </div>
                    </div>
                  </div>
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
