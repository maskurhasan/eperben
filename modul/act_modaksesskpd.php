<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

$nm_List = $_POST['nm_List'];
$Jenis = $_POST['Jenis'];
$Aktiv = $_POST['Aktiv'];

if ($act == "add" and $module == "aksesskpd") {
	if(isset($_POST['Simpan'])) {
			//exit("simpan");

			$id_User = $_POST['id_User'];
			$id_Skpd = $_POST['id_Skpd'];
			$TahunAnggaran = $_SESSION[thn_Login];
			$qw = mysql_query("DELETE FROM aksesskpd WHERE id_User = '$id_User'");
			if($qw) {
					for ($i=0 ; $i < count($id_Skpd);$i++) {
							$id_Skpdx = $id_Skpd[$i];
							$q = mysql_query("INSERT INTO aksesskpd (id_User,id_Skpd,TahunAnggaran) VALUES ('$id_User','$id_Skpdx','$TahunAnggaran')");
					}
					if ($q) {
						header('Location:../main.php?module=aksesskpd');
					} else {
						echo mysql_error();
						//header('Location:../main.php?module=aksesskpd');
					}
			} else {
				header('Location:../main.php?module=aksesskpd');
			}
		} else {
			echo "gagal";
		}

} elseif($act == "edit" and $module == "cklist"){
			if(isset($_POST[simpan])) {
				$id_Cklist = $_POST[id_Cklist];
        $qry = mysql_query("UPDATE cklist SET nm_List='$nm_List',
																							Jenis='$Jenis',
																							Aktiv='$Aktiv'
                                        WHERE id_Cklist = '$id_Cklist'");
        if ($qry)
            {
                header('location:../main.php?module=cklist');
            }
        else
            {
                echo mysql_error();
            }
			} else {
				header('location:../main.php?module=cklist');
			}
} elseif($act == "delete" and $module == "modul"){
      //jika user dihapus



}
