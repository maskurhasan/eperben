<?php
//session_start();

if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {
//----------------------------------
//include "../config/koneksi.php";
include "config/pagination.php";

  switch ($_GET[act]) {
    default:
		     echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                  <h4 class="title">Daftar Rencana Kegiatan</h4>
                  <p class="category">Rencana Kegiatan SKPD</p>
                    <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                        <form class="" method=get action="'.$_SERVER['PHPSELF'].'">
                          <div class="input-group pull-right" style="width: 350px;">

                            <input name="module" type="hidden" value="datakegiatan">
                            <input name="t" type="hidden" value="nm">
                            <input type="text" name="q" class="form-control input-sm pull-right" placeholder="Cari" size="10">
                            <div class="input-group-btn">
                              <button type="submit" class="btn btn-sm btn-default btn-fill"><i class="fa fa-search"></i> Cari</button></form>';
							echo "<button type='button' class='btn btn-sm btn-primary btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=datakegiatan&act=add'\"><i class='fa fa-plus'></i> Tambah Kegiatan</button>";

                            echo '</div>
                          </div>
                    </div>
                    </div>
                </div><!-- /.box-header -->';

			echo '<div class="content table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                        <thead>
                          <tr><th>#</th>
							<th>Kode</th><th style=width:30%>Nama Kegiatan</th><th>Anggaran</th><th>PPK</th>
							<th>Aksi</th></tr>
                        </thead>
                        <tbody>';
            $page = 1;
            if (isset($_GET['page']) && !empty($_GET['page']))
                $page = (int)$_GET['page'];
            $q = $_GET['q'];
            $t = $_GET['t'];
            if($_GET['t'] == 'nm') {
              $nmkeg = "AND b.nm_Kegiatan LIKE '%$q%' ";
            } elseif($_GET['t']=='kode') {
              $kode = "AND a.id_Kegiatan = '$q' ";
            }

            $sql = "SELECT b.nm_Kegiatan,a.id_DataKegiatan,a.id_Kegiatan,a.AnggKeg
                                      FROM kegiatan b, datakegiatan a
                                      WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                                      AND a.id_Kegiatan = b.id_Kegiatan
                                      AND a.TahunAnggaran = '$_SESSION[thn_Login]'
                                      $nmkeg $kode ORDER BY a.id_DataKegiatan ASC";
            $dataTable = getTableData($sql, $page);
            //$query=mysql_query($sql);
            //$no = 1;
            //while($dt=mysql_fetch_array($query))
            foreach ($dataTable as $i => $dt)
            {
            $no = ($i + 1) + (($page - 1) * 10);
                  echo "<tr><td>".$no++."</td>
                          <td>$dt[id_Kegiatan]</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td align=left>".number_format($dt[AnggKeg])."</td>
						  <td>$dt[nm_Lengkap]</td>
                          <td class=align-center><!--<a href='?module=datakegiatan&act=edit&id=$dt[id_DataKegiatan]'><i class='fa fa-edit fa-lg'></i> Subkegiatan</a> -->
                              <a href='?module=datakegiatan&act=edit&id=$dt[id_DataKegiatan]'><i class='fa fa-edit fa-lg'></i> Edit</a> ";
                              echo '<a href="modul/act_moddatakegiatan.php?module=datakegiatan&act=delete&id='.$dt[id_DataKegiatan].'" onclick="return confirm(\'Yakin untuk menghapus data ini?\')"><i class="fa fa-trash-o fa-lg"></i> Hapus</a>';
                              echo "</td>
                          </tr>";
            }

			echo '</tbody></table>';
                  showPagination2($sql);
                echo '</div>
            </div>
            </div>';
    break;
    case "add":

		   echo '<div class="col-md-10">
            <div class="card">
              <div class="header">
                <h4 class="title">Tambah Kegiatan</h4>
                <p class="category">Kegiatan dari Program Kegiatan SKPD</p>
              </div>
              <div class="content">';

          echo "<form method=post action='modul/act_moddatakegiatan.php?module=datakegiatan&act=add'>
                <table>
				<tr>
				<td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }
                echo "</select></td>
				</tr>
				<tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
				</tr>
				<tr>
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select></td>
				</tr>
				<tr>
                <td>Kegiatan : </td><td><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option></select></td>
				</tr>
        <tr>
                <td>Anggaran : </td><td><input type=text name=AnggKeg placeholder=Anggaran></td>
        </tr>
				<tr>
                <td>Nama Kegiatan : </td><td><textarea rows='7' cols='90'class='input-short' name='nm_Kegiatan' id='nm_Kegiatan'></textarea></td>
				</tr>
				<tr>
                <td>PPK </td><td><select class='input-short'  name=id_Ppk placeholder=pilih PPK id=id_Urusan onchange=''>
                <option selected>Pilih</option>";
                $q=mysql_query("SELECT * FROM user a, pangkat b WHERE a.id_Pangkat = b.id_Pangkat
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]'
                                      AND a.UserLevel != 1
                                      AND a.statusppk = 1");
                while ($rx=mysql_fetch_array($q)) {
                  echo "<option value=$rx[id_User]>$rx[nm_Lengkap]</option>";
                }
                echo "</select></td>
				</tr>

				<tr>
                <td>
                <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                <input type=hidden name=TahunAnggaran value=$_SESSION[thn_Login] />
                </td>
				<td>
				<input class='submit-green' type='submit' name='simpan' value=Simpan />
                <input class='submit-gray' type='reset' value=Reset />
                <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                </td>
				</tr>
				</table>
                </form>";

			echo '</div>
				</div>
              </div>';


    break;
    case "edit":
          $sql = mysql_query("SELECT * FROM datakegiatan WHERE id_DataKegiatan = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          //parse id program k jd id
          $id_Urusan = substr($r[id_Kegiatan], 0,1);
          $id_BidUrusan = substr($r[id_Kegiatan], 0,3);
          $id_Program = substr($r[id_Kegiatan], 0,5);
          echo '<div class="col-md-10">
            <div class="card">
              <div class="header">
                <h4 class="title">Edit Kegiatan</h4>
                <p class="category">Kegiatan dari Program Kegiatan SKPD</p>
              </div>
              <div class="content">';
         echo "<form method=post action='modul/act_moddatakegiatan.php?module=datakegiatan&act=edit'>
                <table>
				<tr>
				<td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($rx=mysql_fetch_array($q)) {
                  if($rx[id_Urusan] == $id_Urusan) {
                    echo "<option value=$rx[id_Urusan] selected>$rx[id_Urusan] $rx[nm_Urusan]</option>";
                  } else {
                    echo "<option value=$rx[id_Urusan]>$rx[id_Urusan] $rx[nm_Urusan]</option>";
                  }
                }
                echo "</select></td>
				</tr>
				<tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='vw_tbl(this.value);'>
                <option value=#>Pilih Bid.Urusan</option>";
                $q=mysql_query("SELECT * FROM bidurusan WHERE id_Urusan = '$id_Urusan'");
                while ($rx=mysql_fetch_array($q)) {
                  $id_BidUrusan1 = substr($rx[id_BidUrusan],-2);
                  if($rx[id_BidUrusan] == $id_BidUrusan) {
                    echo "<option value=$rx[id_BidUrusan] selected>$id_BidUrusan1 $rx[nm_BidUrusan]</option>";
                  } else {
                    echo "<option value=$rx[id_BidUrusan]>$id_BidUrusan1 $rx[nm_BidUrusan]</option>";
                  }
                }
                echo "</select></td>
				</tr>
				<tr>
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange=''>
                <option value=#>Pilih Program</option>";
                $q=mysql_query("SELECT * FROM program WHERE id_BidUrusan = '$id_BidUrusan'");
                while ($rx=mysql_fetch_array($q)) {
                  $id_Program1 = substr($rx[id_Program],-2);
                  if($rx[id_Program] == $id_Program) {
                    echo "<option value=$rx[id_Program] selected>$id_Program1 $rx[nm_Program]</option>";
                  } else {
                    echo "<option value=$rx[id_Program]>$id_Program1 $rx[nm_Program]</option>";
                  }
                }
                echo "</select></td>
				</tr>
				<tr>
                <td>Kegiatan : </td><td><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option>";
                $q=mysql_query("SELECT * FROM kegiatan WHERE id_Program = '$id_Program'");
                while ($rx=mysql_fetch_array($q)) {
                  $kd_Kegiatan = substr($rx[id_Kegiatan],-2,2);
                  if($rx[id_Kegiatan] == $r[id_Kegiatan]) {
                    echo "<option value=$rx[id_Kegiatan] selected>$kd_Kegiatan $rx[nm_Kegiatan]</option>";
                  } else {
                    echo "<option value=$rx[id_Kegiatan]>$kd_Kegiatan $rx[nm_Kegiatan]</option>";
                  }
                }
                $q = mysql_query("SELECT * FROM kegiatan WHERE id_Kegiatan = '$r[id_Kegiatan]'");
                $rx = mysql_fetch_assoc($q);
                echo "</select></td>
				</tr>
         <tr>
                <td>Anggaran : </td><td><input type=text name=AnggKeg placeholder=Anggaran value=$r[AnggKeg]></td>
        </tr>
				<tr>
                <td>Nama Kegiatan : </td><td><textarea rows='7' cols='90'class='input-short' name='nm_Kegiatan' id='nm_Kegiatan'>$rx[nm_Kegiatan]</textarea></td>
				</tr>
				<tr>
                <td>PPK </td><td><select class='input-short'  name='id_Ppk' placeholder=pilih PPK id=id_Ppk required>
                <option value=''>Pilih</option>";
                $q=mysql_query("SELECT * FROM user a, pangkat b WHERE a.id_Pangkat = b.id_Pangkat
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]'
                                      AND a.UserLevel != 1
                                      AND a.statusppk = 1");
                while ($rx=mysql_fetch_array($q)) {
                  if($rx[id_User]==$r[id_Ppk]) {
                    echo "<option value=$rx[id_User] selected>$rx[nm_Lengkap]</option>";
                  } else {
                    echo "<option value=$rx[id_User]>$rx[nm_Lengkap]</option>";
                  }
                }
                echo "</select></td>
				</tr>
				<tr>
                <td>
                <input type=hidden name=id_Session value=$_SESSION[Sessid] />
                <input type=hidden name=id_DataKegiatan value=$r[id_DataKegiatan] />
                </td>
				<td>
				<input class='submit-green' type='submit' name='simpan' value=Simpan />
                <input class='submit-gray' type='reset' value=Reset />
                <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                </td>
				</tr>
				</table
                </form>";
				echo '</div>
				</div>
              </div>';


    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script type="text/javascript">

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


function vw_tbl(id_Program)
{
  $.ajax({
    url: '../library/vw_kegiatan.php',
    data: 'id_Program='+id_Program,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#vw_kegiatan').html(response);
        }
    });
}



  //kembali
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});
$("#myTable").tablesorter({widgets: ['zebra'],
  headers: {7: {sorter: true}}
})
.tablesorterPager({container: $("#pager")});
</script>
