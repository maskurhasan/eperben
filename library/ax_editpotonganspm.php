<?php
session_start();

include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_PotonganSpm'];

$sql= "SELECT a.*,b.* FROM spm a, potonganspm b
                    WHERE a.id_Spm = b.id_Spm
                    AND a.StatusSpm = 0
                    AND b.id_PotonganSpm = '$postur'";
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
function totalpot($id_Spm)
{
  $sql= mysql_query("SELECT SUM(NilaiPotongan) AS total FROM potonganspm
                      WHERE id_Spm = '$id_Spm'");
  $r = mysql_fetch_array($sql);
  return $r[total];
}
echo '<input type="hidden" name="id_Spm" value="'.$dt['id_Spm'].'">
        <input type="hidden" name="id_User" value="'.$_SESSION['id_User'].'">
        <input type="hidden" name="TotalSmntara" value="'.totalspm($dt['id_Spm']).'">
        <input type="hidden" name="TotalPot" value="'.totalpot($dt['id_Spm']).'">
        <input type="hidden" name="id_PotonganSpm" value="'.$dt['id_PotonganSpm'].'">
        <div class="profile-user-info profile-user-info-striped">
          <div class="profile-info-row">
            <div class="profile-info-name"> Nomor dan Tgl SPM</div>
            <div class="profile-info-value">';
          echo 'Nomor : '.$dt[Nomor].' / Tanggal : '.$dt[Tanggal].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Anggaran SPM </div>
            <div class="profile-info-value">';
            echo ''.angkrp(totalspm($dt['id_Spm'])).'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Jenis Potongan </div>
            <div class="profile-info-value">';
            echo "<select class=input-short  name=JnsPotongan required>
              <option selected>Pilih Potongan</option>";
              $jnspotongan = array(1 => 'PPN 10%',2=>'PPH 21',3=>'PPH 22',4=>'PPH Gaji',5=>'IWP',6=>'TAPERUM',7=>'ASKES' );
              foreach ($jnspotongan as $key => $value) {
                if($dt[JnsPotongan] == $key) {
                  echo "<option value=$key selected>$key $value</option>";
                } else {
                  echo "<option value=$key>$key $value</option>";
                }
              }
              echo '</select>
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Nilai </div>
            <div class="profile-info-value">
              <input type="text" name="NilaiPotongan" value="'.$dt[NilaiPotongan].'" required>';
            echo '</div>
          </div>';
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
