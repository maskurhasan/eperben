<?php
session_start();

include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_Spm'];
$sql= "SELECT a.*,b.nm_Skpd,d.nm_Lengkap,c.tgl_Ver,c.id_Ver
              FROM spm a, skpd b,verifikasi c, user d
                    WHERE a.id_Skpd = b.id_Skpd
                    AND a.id_Spm = c.id_Spm
                    AND c.id_User = d.id_User
                    AND c.StatusVer = 1
                    AND a.id_Spm = '$postur'";

$q = mysql_query($sql);
$dt = mysql_fetch_array($q);
$jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
$jns = $dt['Jenis'];



echo '
        <input type="hidden" name="id_Ver" value="'.$dt['id_Ver'].'">
        <input type="hidden" name="StatusPengbud" value="1">
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
              '.$dt['Anggaran'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> SKPD </div>
            <div class="profile-info-value">
              '.$dt['nm_Skpd'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Verifikasi oleh / Tanggal </div>
            <div class="profile-info-value">
              '.$dt['nm_Lengkap'].' / '.$dt['tgl_Ver'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Keterangan </div>
            <div class="profile-info-value">
              Isi Keterangan dari proses verifikasi oleh verifikator
            </div>
          </div>
        </div>





      ';


?>
