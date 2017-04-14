<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

$id_Spm = $_POST['id_Spm'];
$id_User = $_POST['id_User'];
$id_Skpd = $_POST['id_Skpd'];
$Jenis = $_POST['Jenis'];

if ($act == "add" and $module == "verifikasi") {

    if(isset($_POST[simpan])) {
        $qry = mysql_query("INSERT INTO verifikasi (id_Spm,
                                              id_User,
                                              tgl_Ver,
																						Create_at)
                                      VALUES ('$id_Spm',
                                            '$id_User',
                                            '$tgl_Ver',
																							now())");
        //if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
        //  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
        //}
        if ($qry)
            {
                //header('location:../main.php?module=verifikasi&act=add&id='.$id_Spm.'');
                header('location:../main.php?module=verifikasi');
            }
        else
            {
                echo mysql_error();
            }
      } else {
        echo "gagal";
      }
} elseif($act == "edit" and $module == "verifikasi"){

	$qry = mysql_query("UPDATE spm SET Jenis='$Jenis',
																			Nomor='$Nomor',
																			Tanggal='$Tanggal',
																			Anggaran='$Anggaran',
																			KepalaSkpd='$KepalaSkpd',
																			Bendahara='$Bendahara',
																			Keterangan='$Keterangan',
                                      StatusSpm = '$StatusSpm',
																			Update_at=now()
																		WHERE id_Spm = '$id_Spm'");
	//if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
	//  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
	//}
	if ($qry)
			{
					header('location:../main.php?module=spm');
			}
	else
			{
					echo mysql_error();
			}

} elseif($act == "ubahstatus" and $module == "verifikasi"){

      if(isset($_POST['simpan'])) {
        $StatusVer = $_POST['StatusVer'];
        $tgl_Ver = $_POST['tgl_Ver'];
        $id_Ver = $_POST['id_Ver'];

        $qry = mysql_query("UPDATE verifikasi SET StatusVer = '$StatusVer',
                                            tgl_Ver = '$tgl_Ver',
      																			Update_at=now()
      																		WHERE id_Ver = '$id_Ver'");
      	//if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
      	//  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
      	//}
      	if ($qry)
      			{
                if($StatusVer == 0) {
                  header('location:../main.php?module=verifikasi&act=add&id='.$id_Ver.'');
                } else {
                  header('location:../main.php?module=verifikasi');
                }
      			}
      	else
      			{
      					echo mysql_error();
      			}

      }



} elseif($act == "pengebud" and $module == "pengesahanbud"){
      if(isset($_POST['simpan'])) {
        if($_POST[StatusSp2d]==0) {
          $StatusPengbud = $_POST['StatusPengbud'];
          $tgl_Pengbud = $_POST['tgl_Pengbud'];
          $id_Ver = $_POST['id_Ver'];
          $qry = mysql_query("UPDATE verifikasi SET StatusPengbud = '$StatusPengbud',
                                              tgl_Pengbud = '$tgl_Pengbud',
        																			Update_at=now()
        																		WHERE id_Ver = '$id_Ver'");
        	//if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
        	//  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
        	//}
        	if ($qry)
        			{
                  if($StatusPengbud == '1') {
                    header('location:../main.php?module=pengesahanbud&act=add&id='.$id_Ver.'');
                  } else {
                    header('location:../main.php?module=pengesahanbud');
                  }
        			}
        	else
        			{
        					echo mysql_error();
        			}
        } else {
          //jika sudah Cetak SP2D tidak bisa diubah lagi
          echo "<script type=text/javascript>window.alert('Error : SP2D Sudah dicetak')
              				window.location.href='../main.php?module=pengesahanbud&act=add&id=$_POST[id_Ver]'</script>";
        }

      }



} elseif($act == "add" and $module == "sp2d"){
      if(isset($_POST['simpan'])) {
        if($_POST[StatusPengbud]==2) {
          //exit($_POST[StatusSp2d]);
          $StatusSp2d = $_POST['StatusSp2d'];
          $NomorSp2d = $_POST['NomorSp2d'];
          $tgl_Sp2d = $_POST['tgl_Sp2d'];
          $id_Ver = $_POST['id_Ver'];
          $qry = mysql_query("UPDATE verifikasi SET
                                              NomorSp2d = '$NomorSp2d',
                                              tgl_Sp2d = '$tgl_Sp2d',
                                              StatusSp2d = '$StatusSp2d',
                                              Update_at=now()
                                            WHERE id_Ver = '$id_Ver'");

          if ($qry)
              {
                  //if($StatusSp2d == '1') {
                  //  header('location:../main.php?module=sp2d&act=daftarspm');
                  //} else {
                    header('location:../main.php?module=sp2d');
                  //}
              }
          else
              {
                  echo mysql_error();
              }
        } else {
          //jika sudah Cetak SP2D tidak bisa diubah lagi
          echo "<script type=text/javascript>window.alert('Error : SP2D Sudah dicetak')
                      window.location.href='../main.php?module=sp2d&act=daftarspm</script>";
        }

      }



} elseif($act == "edit" and $module == "sp2d"){
      if(isset($_POST['simpan'])) {
        if($_POST[StatusSp2d]==1) {

          $StatusSp2d = $_POST['StatusSp2d'];
          $NomorSp2d = $_POST['NomorSp2d'];
          $tgl_Sp2d = $_POST['tgl_Sp2d'];
          $id_Ver = $_POST['id_Ver'];
          $qry = mysql_query("UPDATE verifikasi SET
                                              NomorSp2d = '$NomorSp2d',
                                              tgl_Sp2d = '$tgl_Sp2d',
                                              StatusSp2d = '$StatusSp2d',
                                              Update_at=now()
                                            WHERE id_Ver = '$id_Ver'");

          if ($qry)
              {
                  if($StatusSp2d == '1') {
                    header('location:../main.php?module=sp2d&act=daftarspm');
                  } else {
                    header('location:../main.php?module=sp2d');
                  }
              }
          else
              {
                  echo mysql_error();
              }
        } else {
          //jika sudah Cetak SP2D tidak bisa diubah lagi
          echo "<script type=text/javascript>window.alert('Error : SP2D Sudah Final')
                      window.location.href='../main.php?module=sp2d'</script>";
        }

      }



} elseif ($act == "hapusver" and $module == "verifikasi") {
  //periksa spm jika sdh ada rincian kegiatan 
  $q1 = mysql_query("SELECT id_Ver FROM verifikasi WHERE StatusVer = 1 AND id_Ver = '$_GET[id]'");
  $hit = mysql_num_rows($q1);
        if($hit <= 0) {            
            $qry = mysql_query("DELETE FROM verifikasi WHERE id_Ver = '$_GET[id]'");
            if ($qry)
                {
                    header('location:../main.php?module=verifikasi');
                }
            else
                {
                    echo mysql_error();
                }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Verifikasi SPM sudah Final')
                        window.location.href='../main.php?module=verifikasi'</script>";
        }

} elseif ($act == "lampver" and $module == "verifikasi") {
    //ini untuk mengisi table ketceklist
        if(isset($_POST[Simpan])) {
          $id_Cklist = $_POST[id_Cklist];
          $id_Ver = $_POST[id_Ver];
          $Isian =  $_POST[Isian];
          //jika sstatus verifikasi belum final
          if($_POST[StatusVer]==0) {
            $qw = mysql_query("DELETE FROM ketcklist WHERE id_Ver = '$id_Ver'");
            if($qw) {
                for ($i=0 ; $i < count($id_Cklist);$i++) {
                    $id_Cklistx = $id_Cklist[$i];
                    $Isianx = $Isian[$i];
                    $q = mysql_query("INSERT INTO ketcklist (id_Cklist,id_Ver,Isian) VALUES ('$id_Cklistx','$id_Ver','$Isianx')");
                }
                if ($q) {
                  header('Location:../main.php?module=verifikasi&act=add&id='.$id_Ver.'');
                } else {
                  echo mysql_error();
                }
            } else {
              echo "bkn_simpan";
            }
          }  else {
            //jika sudah final
            echo "<script type=text/javascript>window.alert('Error : Maaf Verifikasi SPM sudah Final')
                        window.location.href='../main.php?module=verifikasi&act=add&id=$id_Ver'</script>";   
          }
        } else { 
          echo "gagal"; 
        }
} elseif ($act == "hapuspengbud" and $module == "verifikasi") {
  //periksa spm jika sdh ada rincian kegiatan 
  $q1 = mysql_query("SELECT id_Ver FROM verifikasi 
                      WHERE StatusVer = 1 
                      AND StatusPengbud < 1
                      AND id_Ver = '$_GET[id]'");
  $hit = mysql_num_rows($q1);
        if($hit <= 0) {
            $qry = mysql_query("UPDATE verifikasi SET StatusPengbud = 0 WHERE id_Ver = '$_GET[id]'");
            if ($qry)
                {
                    header('location:../main.php?module=pengesahanbud');
                }
            else
                {
                    echo mysql_error();
                }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Verifikasi SPM sudah Final')
                        window.location.href='../main.php?module=pengesahanbud'</script>";
        }

}  elseif($act == "hapussp2d" and $module == "sp2d"){
//periksa spm jika sdh ada rincian kegiatan 
  $q1 = mysql_query("SELECT id_Ver FROM verifikasi 
                      WHERE StatusVer = 1 
                      AND StatusPengbud = 2
                      AND StatusSp2d = 1
                      AND id_Ver = '$_GET[id]'");
  $hit = mysql_num_rows($q1);
  
        if($hit == 1) {
            $qry = mysql_query("UPDATE verifikasi SET NomorSp2d='', StatusSp2d = 0 
                                                WHERE id_Ver = '$_GET[id]'");
            if ($qry)
                {
                    header('location:../main.php?module=sp2d');
                }
            else
                {
                    echo mysql_error();
                }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SP2D sudah Final')
                        window.location.href='../main.php?module=sp2d'</script>";
        }


}
