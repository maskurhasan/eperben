<?php
session_start();

include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_Spm'];
$sql= "SELECT a.*,b.nm_Skpd FROM spm a, skpd b
                    WHERE a.id_Skpd = b.id_Skpd
                    AND a.StatusSpm = 1
                    AND a.id_Spm = '$postur'";
$q = mysql_query($sql);
$dt = mysql_fetch_array($q);
$jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
$jns = $dt['Jenis'];



echo '
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
        </div>





      ';


?>
