<?php
session_start();

include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_Spm'];

$sql= "SELECT a.*,b.nm_Skpd FROM spm a, skpd b
                    WHERE a.id_Skpd = b.id_Skpd
                    AND a.StatusSpm = 0
                    AND a.id_Spm = '$postur'";
$q = mysql_query($sql);
$dt = mysql_fetch_array($q);
$jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
$jns = $dt['Jenis'];

//cek kode data kegiatan yg sebelum nya telah dimasukkan
function totalspm($id_Spm)
{
  $sql= mysql_query("SELECT SUM(c.Nilai) total FROM rincspm c
                      WHERE c.id_Spm = '$id_Spm'");
  $r = mysql_fetch_array($sql);
  return $r[total];
}

echo '
        <input type="hidden" name="id_Spm" value="'.$dt['id_Spm'].'">
        <input type="hidden" name="id_User" value="'.$_SESSION['id_User'].'">
        <input type="hidden" name="AnggaranTarget" value="'.$dt['Anggaran'].'">
        <input type="hidden" name="TotalSmntara" value="'.totalspm($dt['id_Spm']).'">
        <div class="profile-user-info profile-user-info-striped">
          <div class="profile-info-row">
            <div class="profile-info-name"> Urusan </div>
            <div class="profile-info-value">';
            echo "<select class=input-short  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
              <option selected>Pilih Urusan</option>";
              $q=mysql_query("SELECT * FROM urusan");
              while ($r=mysql_fetch_array($q)) {
                echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
              }
              echo '</select>
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Bid. Urusan </div>
            <div class="profile-info-value">';
              echo "<select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
              <option value=#>Pilih Bid.Urusan</option></select>";
            echo '</div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Program </div>
            <div class="profile-info-value">';
              echo "<select class='col-xs-10 col-sm-10' name=id_Program  placeholder=pilih Program id=id_Program onchange='pilih_Program(this.value);'>
                <option value=#>Pilih Program</option></select>";
            echo '</div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Kegiatan</div>
            <div class="profile-info-value">
              <select name="" id="id_Kegiatan" onchange="rinc_keg(this.value)" class="col-xs-10 col-sm-10">
                <option value="">Pilih Kegiatan</option>';
              echo '</select>
            </div>
          </div>
        </div>
      <div id="rincian"></div>

      ';


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
        url: 'library/program.php',
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
        url: 'library/kegiatanspm.php',
        data : 'id_Program='+id_Program,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Kegiatan').html(response);
        }
    });
}

function rinc_keg(id_Kegiatan)
{
  $.ajax({
        url: 'library/rinc_kegiatanspm.php',
        data : 'id_Kegiatan='+id_Kegiatan,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
            $('#rincian').html(response);
        }
    });
}



function pilih_Kegiatan(id_Kegiatan)
{
  $.ajax({
        url: 'library/nm_kegiatan.php',
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
    url: 'library/vw_kegiatan.php',
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

</script>
