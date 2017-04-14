<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

$nm_List = $_POST['nm_List'];
$Jenis = $_POST['Jenis'];
$Aktiv = $_POST['Aktiv'];

if ($act == "add" and $module == "cklist") {
			if(isset($_POST[simpan])) {
        $qry = mysql_query("INSERT INTO cklist (nm_List,
                                              Jenis,
                                              Aktiv)
                                      VALUES ('$nm_List',
                                              '$Jenis',
                                              '$Aktiv')");
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
