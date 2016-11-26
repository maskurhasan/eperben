<?php
session_start();

if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {
//----------------------------------

  switch ($_GET[act]) {
    default:

          echo '<div class="col-md-4">
              <div class="card">
                <div class="header">
                  <h4 class="title">Menu Laporan</h4>
                  <p class="category"></p>
                </div>
              <div class="content">';
         echo "<p><button class='btn btn-md btn-info btn-fill btn-block' type=button id=id_Cetak value='register' onClick='ax_form_cetak(this.value)'><i class='pe-7s-note2'></i> Register SPM</button></p>
                <p><button class='btn btn-md btn-info btn-fill btn-block' type=button id=id_Cetak value='realisasi' onClick='ax_form_cetak(this.value)'><i class='pe-7s-note2'></i> Realisasi Anggaran</button></p>
                <p><button class='btn btn-md btn-info btn-fill btn-block' type=button id=id_Cetak value='kartukendali' onClick='ax_form_cetak(this.value)'><i class='pe-7s-note2'></i> Kartu Kendali Kegiatan</button></p>
				        <p><button class='btn btn-md btn-info btn-fill btn-block' type=button id=id_Cetak value='rfkmodel2' onClick='ax_form_cetak(this.value)'><i class='pe-7s-note2'></i> Realisasi Fisik & Keuangan Model 2</button></p>
				<!--
                  <p><button class='btn btn-md btn-primary btn-fill btn-block' type=button id=id_Cetak value='rfkviareaslisasi2' onClick='ax_form_cetak(this.value)'><i class='fa fa-page'></i> Realisasi Fisik & Keuangan V2</button></p>
                  <p><button class='btn btn-md btn-warning btn-fill btn-block' type=button id=id_Cetak value='perkeg' onClick='ax_form_cetak(this.value)'><i class='fa fa-page'></i> Perkembangan Kegiatan</button></p>
                  <p><button class='btn btn-md btn-warning btn-fill btn-block' type=button id=id_Cetak value='ringkasan' onClick='ax_form_cetak(this.value)'><i class='fa fa-page'></i> Ringkasan Anggaran</button></p>
                  <p><button class='btn btn-md btn-danger btn-fill btn-block' type=button id=id_Cetak value='profilkeg' onClick='ax_form_cetak(this.value)'><i class='fa fa-page'></i> Profil Kegiatan</button></p>
                  <p><button class='btn btn-md btn-success btn-fill btn-block' type=button id=id_Cetak value='peta' onClick='ax_form_cetak(this.value)'><i class='fa fa-page'></i> Peta Kegiatan</button></p>
                  <p><button class='btn btn-md btn-success btn-fill btn-block' type=button id=id_Cetak value='chart' onClick='ax_form_cetak(this.value)'><i class='fa fa-chart'></i> Chart</button></p>
        -->";

              echo '</div><div class="footer">
              </div>
            </div>
            </div>';



          echo '<div class="col-md-8" id="cetak">';
          echo "</div>";
          echo '<div class="row">
                  <div class="col-md-10" id="view">

                  </div>
                </div>';


    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script type="text/javascript">
function pilih_kecamatan(id_Kecamatan)
{
  $.ajax({
    url: '../library/desa.php',
    data : 'id_Kecamatan='+id_Kecamatan,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Desa').html(response);
        }
    });
}

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

function ax_form_cetak(id_Cetak)
{
  $.ajax({
    url: 'library/ax_formcetak.php',
    data: 'id_Cetak='+id_Cetak,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#cetak').html(response);
        }
    });
}

function ax_peta(id_Cetak)
{
  $.ajax({
    url: '../library/ax_peta.php',
    data: 'id_Cetak='+id_Cetak,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#cetak').html(response);
        }
    });
}

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

//kembali
$(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});

</script>
