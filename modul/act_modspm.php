<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

$id_Spm = $_POST['id_Spm'];
$id_Skpd = $_POST['id_Skpd'];
$Jenis = $_POST['Jenis'];
$Nomor = $_POST['Nomor'];
$Tanggal = $_POST['Tanggal'];
$Anggaran = $_POST['Anggaran'];
$TahunAngg = $_SESSION['thn_Login'];
$KepalaSkpd = $_POST['KepalaSkpd'];
$Bendahara = $_POST['Bendahara'];
$Keterangan = $_POST['Keterangan'];
$StatusSpm = $_POST['StatusSpm'];

if ($act == "add" and $module == "spm") {


//file spm
$tahun = $_SESSION[thn_Login];
$gantinamaspm = $id_Skpd."_".acaknmfile()."_spm";
$gantinamaspp1 = $id_Skpd."_".acaknmfile()."_spp1";
$gantinamaspp2 = $id_Skpd."_".acaknmfile()."_spp2";
$gantinamaspp3 = $id_Skpd."_".acaknmfile()."_spp3";

$file = array('spm' => 'fl_Spm','spp1'=>'fl_Spp1','spp2'=>'fl_Spp2','spp3'=>'fl_Spp3');
foreach ($file as $key => $value) {
  //$uploadfile = $nm_file_upload.$key;
  $uploadfile = basename($_FILES[$value][name]);
  $extension = end(explode(".",$uploadfile));
  //$gantinama = $id_Skpd."_".acaknmfile()."_".$key;
  $gantinama = "$"."gantinama".$key;
  if($key == 'spm') {
    $namafolder = "../media/spm/$tahun/";
    $gantinama = $gantinamaspm;
    $nm_file_spm = $gantinamaspm.'.'.$extension;
  } elseif($key == 'spp1') {
    $namafolder = "../media/spp/$tahun/";
    $gantinama = $gantinamaspp1;
    $nm_file_spp1 = $gantinamaspp1.'.'.$extension;
  } elseif($key == 'spp2') {
    $namafolder = "../media/spp/$tahun/";
    $gantinama = $gantinamaspp2;
    $nm_file_spp2 = $gantinamaspp2.'.'.$extension;
  } else {
    $namafolder = "../media/spp/$tahun/";
    $gantinama = $gantinamaspp3;
    $nm_file_spp3 = $gantinamaspp3.'.'.$extension;
  }
  $pindah_foto = move_uploaded_file($_FILES[$value][tmp_name],$namafolder.$gantinama.'.'.$extension);
}

    if(isset($_POST[simpan])) {
        $qry = mysql_query("INSERT INTO spm (id_Skpd,
                                              Jenis,
                                              Nomor,
                                              Tanggal,
																							Anggaran,
                                              TahunAngg,
																							KepalaSkpd,
																							Bendahara,
																							Keterangan,
                                              fl_Spm,
                                              fl_Spp1,
                                              fl_Spp2,
                                              fl_Spp3,
																						Create_at)
                                      VALUES ('$id_Skpd',
															                '$Jenis',
															                '$Nomor',
															                '$Tanggal',
																							'$Anggaran',
                                              '$TahunAngg',
																							'$KepalaSkpd',
																							'$Bendahara',
																							'$Keterangan',
                                              '$nm_file_spm',
                                              '$nm_file_spp1',
                                              '$nm_file_spp2',
                                              '$nm_file_spp3',
																							now())");
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
      } else {
        echo "gagal";
      }
} elseif($act == "edit" and $module == "spm"){
  //status SPM bisa berubah jika nilai kegiatan lebih kecil sama dengan ANggaran
  //nilai total kegiatanspm
  if(isset($_POST[simpan])) {
    $TotalSmntara = $_POST[TotalSmntara];
    if($StatusSpm == 1 AND $TotalSmntara == $Anggaran) {
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
    } elseif($StatusSpm == 0) {
      $qry = mysql_query("UPDATE spm SET Jenis='$Jenis',
                                          Nomor='$Nomor',
                                          Tanggal='$Tanggal',
                                          Anggaran='$Anggaran',
                                          KepalaSkpd='$KepalaSkpd',
                                          Bendahara='$Bendahara',
                                          Keterangan='$Keterangan',
                                          StatusSpm = 0,
                                          Update_at=now()
                                        WHERE id_Spm = '$id_Spm'");
      if ($qry)
          {
              header('location:../main.php?module=spm');
          }
      else
          {
              echo mysql_error();
          }
    } else {
      echo "<script type=text/javascript>window.alert('Error : Maaf Anggaran Kegiatan Tidak sesuai Target SPP ".angkrp($Anggaran)."')
                  window.location.href='../main.php?module=spm&act=edit&id=$id_Spm'</script>";
    }
  } else {
    //gagal simpan
    header('location:../main.php?module=spm');
  }

} elseif($act == "datakegiatan" and $module == "spm"){
      $Nilai = $_POST[Nilai];
      $id_DataKegiatan = $_POST['id_DataKegiatan'];
      //data rincian spm
      if(isset($_POST[simpan])) {
        //periksa nilai kegiatan spm jika melebihi sisa anggaran
        $target = $_POST[AnggaranTarget];
        $TotalSmntara = $_POST[TotalSmntara];
        //Anggaran Kegiatan Sementara
        $AnggaranInput = $Nilai+$TotalSmntara;
        if($AnggaranInput <= $target){
          $q = mysql_query("SELECT id_DataKegiatan FROM rincspm WHERE id_Spm = '$id_Spm' AND id_DataKegiatan = '$id_DataKegiatan'");
          $hit = mysql_num_rows($q);
          if($hit < 1) {
            $qry = mysql_query("INSERT INTO rincspm (id_Spm,id_DataKegiatan,Nilai,Create_at)
                                      VALUES ('$id_Spm','$id_DataKegiatan','$Nilai',now())");

          	if ($qry)
          			{
          					header('location:../main.php?module=spm&act=kegiatan&id='.$id_Spm.'');
          			}
          	else
          			{
          					echo mysql_error();
          			}
          } else {
            //maaf kegiatan telah ada
            echo "<script type=text/javascript>window.alert('Error : Kegiatan SPM telah dipilih')
                				window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
          }
        } else {
          echo "<script type=text/javascript>window.alert('Error : Maaf Anggaran Kegiatan melebihi Target SPP ".angkrp($target)."')
                      window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }



} elseif ($act == "datakegiatanedit" and $module == "spm") {
      $Nilai = $_POST[Nilai];
      $id_DataKegiatan = $_POST['id_DataKegiatan'];
      $id_Rincspm = $_POST['id_Rincspm'];
      //data rincian spm
      //periksa nilai kegiatan spm jika melebihi sisa anggaran
      if(isset($_POST[simpan])) {
        if($_POST[StatusSpm]==0) {
            $target = $_POST[AnggaranTarget];
            $TotalSmntara = $_POST[TotalSmntara];
            $NilaiLama = $_POST[NilaiLama];
            $AnggaranInput = $Nilai+$TotalSmntara-$NilaiLama;
          if($AnggaranInput <= $target){
            $qry = mysql_query("UPDATE rincspm SET Nilai = '$Nilai' WHERE id_Rincspm = '$id_Rincspm'");

            if ($qry)
                {
                    header('location:../main.php?module=spm&act=kegiatan&id='.$id_Spm.'');
                }
            else
                {
                    echo mysql_error();
                }
          } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Anggaran Kegiatan melebihi Target SPP ".angkrp($target)."')
                        window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
          }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                				window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }

} elseif ($act == "potongan" and $module == "spm") {
      $JnsPotongan = $_POST[JnsPotongan];
      $NilaiPotongan = $_POST['NilaiPotongan'];
      $id_Rincspm = $_POST['id_Rincspm'];
      //data rincian spm
      //periksa nilai kegiatan spm jika melebihi sisa anggaran
      if(isset($_POST[simpan])) {
        if($_POST[StatusSpm]==0) {
            $target = $_POST[AnggaranTarget];
            $TotalSmntara = $_POST[TotalSmntara];
            $TotalPot = $_POST[TotalPot];
            $NilaiPotongan = $_POST[NilaiPotongan];
            $TotalPotongan = $NilaiPotongan+$TotalPot;

          if($TotalPotongan <= $TotalSmntara){
            $qry = mysql_query("INSERT INTO potonganspm (id_Spm,JnsPotongan,NilaiPotongan) VALUES ('$id_Spm','$JnsPotongan','$NilaiPotongan')");

            if ($qry)
                {
                    header('location:../main.php?module=spm&act=potongan&id='.$id_Spm.'');
                }
            else
                {
                    echo mysql_error();
                }
          } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Potongan SPM Kegiatan melebihi Target SPP ".angkrp($TotalSmntara)."')
                        window.location.href='../main.php?module=spm&act=potongan&id=$id_Spm'</script>";
          }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                				window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }

} elseif ($act == "editpotongan" and $module == "spm") {
      $JnsPotongan = $_POST['JnsPotongan'];
      $NilaiPotongan = $_POST['NilaiPotongan'];
      $id_Rincspm = $_POST['id_Rincspm'];
      $id_PotonganSpm = $_POST['id_PotonganSpm'];
      //periksa nilai kegiatan spm jika melebihi sisa anggaran
      if(isset($_POST[simpan])) {
        if($_POST[StatusSpm]==0) {
            $target = $_POST[AnggaranTarget];
            $TotalSmntara = $_POST[TotalSmntara];
            $TotalPot = $_POST[TotalPot];
            $NilaiPotongan = $_POST[NilaiPotongan];
            $TotalPotongan = $NilaiPotongan+$TotalPot;

          if($TotalPotongan <= $TotalSmntara) {
            $qry = mysql_query("UPDATE potonganspm SET JnsPotongan='$JnsPotongan',
                                                        NilaiPotongan='$NilaiPotongan'
                                                        WHERE id_PotonganSpm = '$id_PotonganSpm'");
            if ($qry)
                {
                    header('location:../main.php?module=spm&act=potongan&id='.$id_Spm.'');
                }
            else
                {
                    echo mysql_error();
                }
          } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Potongan SPM Kegiatan melebihi Target SPP ".angkrp($TotalSmntara)."')
                        window.location.href='../main.php?module=spm&act=potongan&id=$id_Spm'</script>";
          }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                				window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }

} elseif ($act == "hapusspm" and $module == "spm") {
  //periksa spm jika sdh ada rincian kegiatan 
  $q1 = mysql_query("SELECT id_Rincspm FROM rincspm WHERE id_Spm = '$_GET[id]'");
  $hit = mysql_num_rows($q1);
        if($hit <= 0) {
            $qry = mysql_query("DELETE FROM spm WHERE id_Spm = '$_GET[id]'");
            if ($qry)
                {
                    header('location:../main.php?module=spm');
                }
            else
                {
                    echo mysql_error();
                }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM tidak bisa dihapus, sudah ada Data kegiatan')
                        window.location.href='../main.php?module=spm'</script>";
        }


}
