<?php
//session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "ttdbukti") {
		    $NamaTtd = $_POST['NamaTtd'];
        $Nip = $_POST['Nip'];
        $id_Pangkat = $_POST['id_Pangkat'];
        $Jabatan = $_POST['Jabatan'];
				$id_Skpd = $_POST['id_Skpd'];

        $qry = mysql_query("INSERT INTO ttdbukti (NamaTtd,
                                              Nip,
                                              id_Pangkat,
                                              Jabatan,
																							id_Skpd)
                                      VALUES ('$NamaTtd',
															                '$Nip',
															                '$id_Pangkat',
															                '$Jabatan',
																							'$id_Skpd')");
        //if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
        //  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
        //}
        if ($qry)
            {
                header('location:../main.php?module=ttdbukti');
            }
        else
            {
                echo mysql_error();
            }
} elseif($act == "edit" and $module == "ttdbukti"){
	$id = $_POST['id'];
	$NamaTtd = $_POST['NamaTtd'];
	$Nip = $_POST['Nip'];
	$id_Pangkat = $_POST['id_Pangkat'];
	$Jabatan = $_POST['Jabatan'];
	$id_Skpd = $_POST['id_Skpd'];

	$qry = mysql_query("UPDATE ttdbukti SET  NamaTtd =  '$NamaTtd',
																				Nip = '$Nip',
																				id_Pangkat = '$id_Pangkat',
																				Jabatan = '$Jabatan',
																				id_Skpd = '$id_Skpd'
																				WHERE id = '$id'");
	//if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
	//  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
	//}
	if ($qry)
			{
					header('location:../main.php?module=ttdbukti');
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
