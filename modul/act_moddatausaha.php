<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

$id_Usaha = $_POST['id_Usaha'];
$nm_Usaha	= $_POST['nm_Usaha'];
$AlamatLengkap = $_POST['AlamatLengkap'];
$id_Desa = $_POST['id_Desa'];
$Pimpinan = $_POST['Pimpinan'];
$Jabatan = $_POST['Jabatan'];
$Bank = $_POST['Bank'];
$NoRek = $_POST['NoRek'];
$Npwp = $_POST['Npwp'];



if ($act == "add" and $module == "datausaha") {
	if(isset($_POST['simpan'])) {
			$sql = "INSERT INTO datausaha (nm_Usaha,AlamatLengkap,id_Desa,Pimpinan,Jabatan,Bank,NoRek,Npwp)
											VALUES ('$nm_Usaha','$AlamatLengkap','$id_Desa','$Pimpinan','$Jabatan','$Bank','$NoRek','$Npwp')";
			$q = mysql_query($sql);
					if ($q) {
						header('Location:../main.php?module=datausaha');
					} else {
						echo mysql_error();
						//header('Location:../main.php?module=aksesskpd');
					}
		} else {
			echo "gagal";
		}

} elseif($act == "edit" and $module == "datausaha"){
			if(isset($_POST[simpan])) {

        $qry = mysql_query("UPDATE datausaha SET nm_Usaha='$nm_Usaha',AlamatLengkap='$AlamatLengkap',id_Desa='$id_Desa',
																				Pimpinan='$Pimpinan',Jabatan='$Jabatan',Bank='$Bank',NoRek='$NoRek',Npwp='$Npwp'
                                        WHERE id_Usaha = '$id_Usaha'");
        if ($qry)
            {
                header('location:../main.php?module=datausaha');
            }
        else
            {
                echo mysql_error();
            }
			} else {
				header('location:../main.php?module=cklist');
			}
} elseif($act == "delete" and $module == "datausaha"){
			//$sql = "SELECT id_Usaha FROM datausaha "
      if(isset($_GET[id]) AND isset($_GET[act])) {
				$sql = "DELETE FROM datausaha WHERE id_Usaha = '$_GET[id]'";
				$q = mysql_query($sql);
				if($q) {
					header('location:../main.php?module=datausaha');
				} else {
					echo mysql_error();
				}
			} else {
				echo "gagal hapus";
			}



}
