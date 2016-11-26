<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "modul") {
		    $nm_Modul = $_POST['nm_Modul'];
        $LinkModul = $_POST['LinkModul'];
        $UserLevel = $_POST['UserLevel'];
        $AktivModul = $_POST['AktivModul'];

        $qry = mysql_query("INSERT INTO modul (nm_Modul,
                                              LinkModul,
                                              AktivModul,
                                              UserLevel)
                                      VALUES ('$nm_Modul',
                                              '$LinkModul',
                                              '$AktivModul',
                                              '$UserLevel')");
        if ($qry)
            {
                header('location:../main.php?module=modul');
            }
        else
            {
                echo mysql_error();
            }
} elseif($act == "edit" and $module == "modul"){
        $id_Modul = $_POST['id_Modul'];
        $nm_Modul = $_POST['nm_Modul'];
        $LinkModul = $_POST['LinkModul'];
        $UserLevel = $_POST['UserLevel'];
        $AktivModul = $_POST['AktivModul'];
        $qry = mysql_query("UPDATE modul SET nm_Modul='$nm_Modul',
                                              LinkModul='$LinkModul',
                                              AktivModul='$AktivModul',
                                              UserLevel='$UserLevel'
                                        WHERE id_Modul = '$id_Modul'");
        if ($qry)
            {
                header('location:../main.php?module=modul');
            }
        else
            {
                echo mysql_error();
            }

} elseif($act == "delete" and $module == "modul"){
      //jika user dihapus



}
