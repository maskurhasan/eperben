<?php
session_start();

include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_Ver'];
$sql= "SELECT a.*,c.StatusSp2d,c.NomorSp2d,c.tgl_Sp2d,c.StatusPengbud,b.nm_Skpd,d.nm_Lengkap,c.tgl_Ver,c.id_Ver
              FROM spm a, skpd b,verifikasi c, user d
                    WHERE a.id_Skpd = b.id_Skpd
                    AND a.id_Spm = c.id_Spm
                    AND c.id_User = d.id_User
                    AND c.StatusVer = 1
                    AND c.StatusPengbud = 2
                    AND c.id_Ver = '$postur'";

$q = mysql_query($sql);
$dt = mysql_fetch_array($q);
$jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
$jns = $dt['Jenis'];



echo '
        <input type="hidden" name="id_Ver" value="'.$dt['id_Ver'].'">
        <input type="hidden" name="StatusPengbud" value="'.$dt['StatusPengbud'].'">
        <input type="hidden" name="id_Spm" value="'.$dt['id_Spm'].'">
        <input type="hidden" name="id_User" value="'.$_SESSION['id_User'].'">
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
          <div class="profile-info-row">
            <div class="profile-info-name"> Diverifikasi oleh / Tanggal </div>
            <div class="profile-info-value">
              '.$dt['nm_Lengkap'].' / '.$dt['tgl_Ver'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Keterangan </div>
            <div class="profile-info-value">
              '.$dt['Keterangan'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Nomor SP2D </div>
            <div class="profile-info-value">
              <input type="text" name="NomorSp2d" value="'.$dt['NomorSp2d'].'" required>
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Tanggal </div>
            <div class="profile-info-value">
              <input type="date" name="tgl_Sp2d" value="'.$dt['tgl_Sp2d'].'"  class="date-picker" data-date-format="yyyy-mm-dd" required>
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Status </div>
            <div class="profile-info-value">
              <select class="col-xs-10 col-sm-5" name="StatusSp2d" onchange="" required>';
                $status = array(1 => 'Draf',2=>'Final / Cetak');
                foreach ($status as $key => $value) {
                  if($key == $dt[StatusSp2d]) {
                    echo "<option value='$key' selected>$value</option>";
                  } else {
                    echo "<option value='$key'>$value</option>";
                  }
                }

              echo '</select>
            </div>
          </div>
        </div>





      ';


?>
