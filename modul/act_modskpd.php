<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "skpd") {
        $id_Skpd = $_POST['id_Skpd'];
		    $nm_Skpd = $_POST['nm_Skpd'];
        $nm_Kepala = $_POST['nm_Kepala'];
        $id_Pangkat = $_POST['id_Pangkat'];
        $nip_Kepala = $_POST['nip_Kepala'];
        $id_Eselon = $_POST['id_Eselon'];
        $pagu_Dana = $_POST['pagu_Dana'];
        $visimisi = $_POST['visimisi'];
        $Bank = $_POST['Bank'];
        $NoRek = $_POST['NoRek'];
        $Npwp = $_POST['Npwp'];

        $qry = mysql_query("INSERT INTO skpd (nm_Skpd,
                                              nm_Kepala,
                                              id_Pangkat,
                                              nip_Kepala,
                                              id_Eselon,
                                              pagu_Dana,
                                              visimisi,
                                              Bank,
                                              NoRek,
                                              Npwp)
                                      VALUES ('$nm_Skpd',
                                              '$nm_Kepala',
                                              '$id_Pangkat',
                                              '$nip_Kepala',
                                              '$id_Eselon',
                                              '$pagu_Dana',
                                              '$visimisi',
                                              '$apbd',
                                              '$NoRek',
                                              '$Npwp')");
        if ($qry)
            {
                header('location:../main.php?module=skpd');
            }
        else
            {
                echo mysql_error();
            }
} elseif($act == "edit" and $module == "skpd"){
        $id_Skpd = $_POST['id_Skpd'];
        $nm_Skpd = $_POST['nm_Skpd'];
        $nm_Kepala = $_POST['nm_Kepala'];
        $id_Pangkat = $_POST['id_Pangkat'];
        $nip_Kepala = $_POST['nip_Kepala'];
        $id_Eselon = $_POST['id_Eselon'];
        $pagu_Dana = $_POST['pagu_Dana'];
        $visimisi = $_POST['visimisi'];
        $Bank = $_POST['Bank'];
        $NoRek = $_POST['NoRek'];
        $Npwp = $_POST['Npwp'];

        $qry = mysql_query("UPDATE skpd SET nm_Skpd='$nm_Skpd',
                                              nm_Kepala='$nm_Kepala',
                                              id_Pangkat='$id_Pangkat',
                                              nip_Kepala='$nip_Kepala',
                                              id_Eselon='$id_Eselon',
                                              pagu_Dana='$pagu_Dana',
                                              visimisi='$visimisi',
                                              Bank='$Bank',
                                              NoRek='$NoRek',
                                              Npwp='$Npwp'
                                        WHERE id_Skpd = '$id_Skpd'");
        if ($qry)
            {
                header('location:../main.php?module=skpd');
            }
        else
            {
                echo mysql_error();
            }

} elseif($act == "delete" and $module == "user"){
      //jika user dihapus



}
