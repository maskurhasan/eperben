<?php
//session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "user") {
		    $nm_Lengkap = $_POST['nm_Lengkap'];
        $nip_Ppk = $_POST['nip_Ppk'];
        $id_Pangkat = $_POST['id_Pangkat'];
        $UserName = $_POST['UserName'];
        $PassWord = md5($_POST['PassWord']);
        $PassWord2 = $_POST['PassWord'];
        $UserLevel = $_POST['UserLevel'];
        $id_Skpd = $_POST['id_Skpd'];
        $Aktiv = $_POST['Aktiv'];
        $statusppk = $_POST['statusppk'];
        $id_Session = $PassWord;
        $qry = mysql_query("INSERT INTO user (nm_Lengkap,
                                              nip_Ppk,
                                              id_Pangkat,
                                              UserName,
                                              UserLevel,
                                              PassWord,
                                              PassWord2,
                                              id_Skpd,
                                              Aktiv,
                                              statusppk,
                                              id_Session)
                                      VALUES ('$nm_Lengkap',
                                                '$nip_Ppk',
                                                '$id_Pangkat',
                                                '$UserName',
                                                '$UserLevel',
                                                '$PassWord',
                                                '$PassWord2',
                                                '$id_Skpd',
                                                '$Aktiv',
                                                '$statusppk',
                                                '$id_Session')");
        //if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
        //  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
        //}
        if ($qry)
            {
                header('location:../main.php?module=user');
            }
        else
            {
                echo mysql_error();
            }
} elseif($act == "edit" and $module == "user"){
        $id_User = $_POST['id_User'];
        $nm_Lengkap = $_POST['nm_Lengkap'];
        $nip_Ppk = $_POST['nip_Ppk'];
        $id_Pangkat = $_POST['id_Pangkat'];
        $UserName = $_POST['UserName'];
        //ubah password
        if(!empty($_POST[PassWord])) {
          $PassWord = md5($_POST['PassWord']);
          $PassWord2 = $_POST['PassWord2'];
          $PassWordtp = "PassWord = '$PassWord', PassWord2 = '$PassWord2', ";
        } else {
            $PassWordtp = "";
        }
        $UserLevel = $_POST['UserLevel'];
        $id_Skpd = $_POST['id_Skpd'];
        $Aktiv = $_POST['Aktiv'];
        $statusppk = $_POST['statusppk'];
        $qry = mysql_query("UPDATE user SET nm_Lengkap='$nm_Lengkap',
                                              nip_Ppk = '$nip_Ppk',
                                              id_Pangkat='$id_Pangkat',
                                              UserName='$UserName',
                                              UserLevel='$UserLevel',
                                              $PassWordtp
                                              id_Skpd='$id_Skpd',
                                              Aktiv='$Aktiv',
                                              statusppk = '$statusppk'
                                        WHERE id_User = '$id_User'");
        if ($qry)
            {
                header('location:../main.php?module=user');
            }
        else
            {
                echo mysql_error();
            }

} elseif($act == "delete" and $module == "user"){
      //jika user dihapus



} elseif ($act == "akses" and $module == "user") {
        if(isset($_POST[Simpan])) {
          $id_Modul = $_POST[id_Modul];
          $id_User = $_POST[id_User];
          $qw = mysql_query("DELETE FROM aksesmodul WHERE id_User = '$id_User'");
          if($qw) {
              for ($i=0 ; $i < count($id_Modul);$i++) {
                  $id_Modulx = $id_Modul[$i];
                  $q = mysql_query("INSERT INTO aksesmodul (id_User, id_Modul) VALUES ('$id_User','$id_Modulx')");
              }
              if ($q) {
                header('Location:../main.php?module=user');
              } else {
                echo mysql_error();
              }
          }
        } else { echo "gagal"; }

}
