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

if($act =="pre" and $module == "spm") {
          $id = $_POST[id];
          //echo $id;
          //exit("dd");
          $qry = mysql_query("INSERT INTO spm (id_Spm,
                                            id_Skpd,
                                            Create_at)
                                      VALUES ('$id',
                                              '$_SESSION[id_Skpd]',
                                              now())");
        if ($qry)
            {
                header('location:../main.php?module=spm&act=add&id='.$id.'');
            }
        else
            {
                echo mysql_error();
            }
  //exit();
} elseif ($act == "add" and $module == "spm") {
/*
//file spm
$tahun = $_SESSION[thn_Login];
$gantinamaspm = $id_Skpd."_".acaknmfile()."_spm";
$gantinamaspp1 = $id_Skpd."_".acaknmfile()."_spp1";
$gantinamaspp2 = $id_Skpd."_".acaknmfile()."_spp2";
$gantinamaspp3 = $id_Skpd."_".acaknmfile()."_spp3";
$gantinamadoclain = $id_Skpd."_".acaknmfile()."_lain";

$file = array('spm' => 'fl_Spm','spp1'=>'fl_Spp1','spp2'=>'fl_Spp2','spp3'=>'fl_Spp3','lain'=>'fl_lain');
foreach ($file as $key => $value) {
  //$uploadfile = $nm_file_upload.$key;
    $uploadfile = basename($_FILES[$value][name]);
    $extension = end(explode(".",$uploadfile));
    //$gantinama = "$"."gantinama".$key;
    if($key == 'spm') {
      $namafolder = "../media/spm/$tahun/";
      $gantinama = $gantinamaspm;
      if($_FILES[fl_Spm][name]=="") {
        $nm_file_spm = $_POST[al_spm];
      } else {
        $nm_file_spm = $gantinamaspm.'.'.$extension;
      }
    } elseif($key == 'spp1') {
      $namafolder = "../media/spp/$tahun/";
      $gantinama = $gantinamaspp1;
      if($_FILES[fl_Spp1][name]=="") {
        $nm_file_spp1 = $_POST[al_spp1];
      } else {
        $nm_file_spp1 = $gantinamaspp1.'.'.$extension;
      }
    } elseif($key == 'spp2') {
      $namafolder = "../media/spp/$tahun/";
      $gantinama = $gantinamaspp2;
      if($_FILES[fl_Spp2][name]=="") {
        $nm_file_spp2 = $_POST[al_spp2];
      } else {
        $nm_file_spp2 = $gantinamaspp2.'.'.$extension;
      }
    } elseif($key == 'spp3'){
      $namafolder = "../media/spp/$tahun/";
      $gantinama = $gantinamaspp3;
      if($_FILES[fl_Spp3][name]=="") {
        $nm_file_spp3 = $_POST[al_spp3];
      } else {
        $nm_file_spp3 = $gantinamaspp3.'.'.$extension;
      }
    } else {
      $namafolder = "../media/lain/$tahun/";
      $gantinama = $gantinamadoclain;
      if($_FILES[fl_lain][name]=="") {
        $nm_file_lain = $_POST[al_lain];
      } else {
        $nm_file_lain = $gantinamadoclain.'.'.$extension;
      }
    }
    $pindah_foto = move_uploaded_file($_FILES[$value][tmp_name],$namafolder.$gantinama.'.'.$extension);
}
*/
    if(isset($_POST[simpan])) {
      $TotalSmntara = $_POST[TotalSmntara];
      if($StatusSpm == 1 AND $TotalSmntara == $Anggaran) {

        $qry = mysql_query("UPDATE spm SET Jenis='$Jenis',
                                              Nomor='$Nomor',
                                              Tanggal='$Tanggal',
                                              Anggaran='$Anggaran',
                                              TahunAngg='$TahunAngg',
                                              KepalaSkpd='$KepalaSkpd',
                                              Bendahara='$Bendahara',
                                              Keterangan='$Keterangan',
                                              StatusSpm = 1,
                                              Create_at=now()
                                      WHERE id_Spm ='$_POST[id_Spm]'");

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
                                              TahunAngg='$TahunAngg',
                                              KepalaSkpd='$KepalaSkpd',
                                              Bendahara='$Bendahara',
                                              Keterangan='$Keterangan',
                                              StatusSpm = 0,
                                              Create_at=now()
                                      WHERE id_Spm ='$_POST[id_Spm]'");

        //if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
        //  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
        //}
        if ($qry)
            {
                header('location:../main.php?module=spm&act=add&id='.$_POST[id_Spm].'');
            }
        else
            {
                echo mysql_error();
            }

      } else {
      echo "<script type=text/javascript>window.alert('Error : Maaf Anggaran Kegiatan Tidak sesuai Target SPP ".angkrp($Anggaran)."')
                  window.location.href='../main.php?module=spm&act=add&id=$_POST[id_Spm]'</script>";
    }
  } else {
    //gagal simpan
    header('location:../main.php?module=spm');
  }
} elseif($act == "edit" and $module == "spm"){
  //status SPM bisa berubah jika nilai kegiatan lebih kecil sama dengan ANggaran
  //nilai total kegiatanspm
  //file spm
  $tahun = $_SESSION[thn_Login];
  $gantinamaspm = $id_Skpd."_".acaknmfile()."_spm";
  $gantinamaspp1 = $id_Skpd."_".acaknmfile()."_spp1";
  $gantinamaspp2 = $id_Skpd."_".acaknmfile()."_spp2";
  $gantinamaspp3 = $id_Skpd."_".acaknmfile()."_spp3";
  $gantinamadoclain = $id_Skpd."_".acaknmfile()."_lain";

  $file = array('spm' => 'fl_Spm','spp1'=>'fl_Spp1','spp2'=>'fl_Spp2','spp3'=>'fl_Spp3','doclain'=>'fl_lain');
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
    } elseif($key == 'spp3') {
      $namafolder = "../media/spp/$tahun/";
      $gantinama = $gantinamaspp3;
      $nm_file_spp3 = $gantinamaspp3.'.'.$extension;
    } else {
      $namafolder = "../media/lain/$tahun/";
      $gantinama = $gantinamadoclain;
      $nm_file_spp3 = $gantinamaspp3.'.'.$extension;
    }
    $pindah_foto = move_uploaded_file($_FILES[$value][tmp_name],$namafolder.$gantinama.'.'.$extension);
  }

  if(isset($_POST[simpan])) {
    $TotalSmntara = $_POST[TotalSmntara];
    if($StatusSpm == 1 AND $TotalSmntara == $Anggaran) {
    	       $qry = mysql_query("UPDATE spm SET Jenis='$Jenis',
                                              Nomor='$Nomor',
                                              Tanggal='$Tanggal',
                                              Anggaran='$Anggaran',
                                              TahunAngg='$TahunAngg',
                                              KepalaSkpd='$KepalaSkpd',
                                              Bendahara='$Bendahara',
                                              Keterangan='$Keterangan',
                                              StatusSpm = 1,
                                              Create_at=now()
                                      WHERE id_Spm ='$id_Spm'");

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
                                              TahunAngg='$TahunAngg',
                                              KepalaSkpd='$KepalaSkpd',
                                              Bendahara='$Bendahara',
                                              Keterangan='$Keterangan',
                                              StatusSpm = 0,
                                              Create_at=now()
                                      WHERE id_Spm ='$id_Spm'");

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
          					header('location:../main.php?module=spm&act=add&id='.$id_Spm.'');
          			}
          	else
          			{
          					echo mysql_error();
          			}
          } else {
            //maaf kegiatan telah ada
            echo "<script type=text/javascript>window.alert('Error : Kegiatan SPM telah dipilih')
                				window.location.href='../main.php?module=spm&act=add&id=$id_Spm'</script>";
          }
        } else {
          echo "<script type=text/javascript>window.alert('Error : Maaf Anggaran Kegiatan melebihi Target SPP ".angkrp($target)."')
                      window.location.href='../main.php?module=spm&act=add&id=$id_Spm'</script>";
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
                    header('location:../main.php?module=spm&act=add&id='.$id_Spm.'');
                }
            else
                {
                    echo mysql_error();
                }
          } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Anggaran Kegiatan melebihi Target SPP ".angkrp($target)."')
                        window.location.href='../main.php?module=spm&act=add&id=$id_Spm'</script>";
          }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                				window.location.href='../main.php?module=spm&act=add&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }

} elseif ($act == "datakegiatandel" and $module == "spm") {
      $Nilai = $_POST[Nilai];
      $id_DataKegiatan = $_POST['id_DataKegiatan'];
      $id_Rincspm = $_GET['id'];
      //data rincian spm
      //periksa nilai kegiatan spm jika melebihi sisa anggaran
      $q = mysql_query("SELECT id_Spm,StatusSpm FROM spm WHERE id_Spm = '$_GET[idx]'");
      $r = mysql_fetch_array($q);
      if(isset($_GET[act])) {
        if($r[StatusSpm]==0) {
            $target = $_POST[AnggaranTarget];
            $TotalSmntara = $_POST[TotalSmntara];
            $NilaiLama = $_POST[NilaiLama];
            $AnggaranInput = $Nilai+$TotalSmntara-$NilaiLama;

            $qry = mysql_query("DELETE FROM rincspm  WHERE id_Rincspm = '$id_Rincspm'");

            if ($qry)
                {
                    header('location:../main.php?module=spm&act=kegiatan&id='.$_GET[idx].'');
                }
            else
                {
                    echo mysql_error();
                }

        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                        window.location.href='../main.php?module=spm&act=kegiatan&id=$_GET[idx]'</script>";
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
                    header('location:../main.php?module=spm&act=add&id='.$id_Spm.'');
                }
            else
                {
                    echo mysql_error();
                }
          } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Potongan SPM Kegiatan melebihi Target SPP ".angkrp($TotalSmntara)."')
                        window.location.href='../main.php?module=spm&act=add&id=$id_Spm'</script>";
          }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                				window.location.href='../main.php?module=spm&act=add&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }
} elseif ($act == "delpotongan" and $module == "spm") {
      $JnsPotongan = $_POST['JnsPotongan'];
      $NilaiPotongan = $_POST['NilaiPotongan'];
      $id_Rincspm = $_POST['id_Rincspm'];
      $id_PotonganSpm = $_GET['id'];
      $q = mysql_query("SELECT id_Spm,StatusSpm FROM spm WHERE id_Spm = '$_GET[idx]'");
      $r = mysql_fetch_array($q);
      //periksa nilai kegiatan spm jika melebihi sisa anggaran
      if(isset($_GET[act])) {
        if($r[StatusSpm]==0) {
            $target = $_POST[AnggaranTarget];
            $TotalSmntara = $_POST[TotalSmntara];
            $TotalPot = $_POST[TotalPot];
            $NilaiPotongan = $_POST[NilaiPotongan];
            $TotalPotongan = $NilaiPotongan+$TotalPot;

            $qry = mysql_query("DELETE FROM potonganspm WHERE id_PotonganSpm = '$id_PotonganSpm'");
            if ($qry)
                {
                    header('location:../main.php?module=spm&act=add&id='.$_GET[idx].'');
                }
            else
                {
                    echo mysql_error();
                }

        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                        window.location.href='../main.php?module=spm&act=add&id=$_GET[idx]'</script>";
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


} elseif($act == "upload" and $module == "spm"){
      //data rincian spm
        $id_Cklist = $_POST[id_Cklist];
        $Keterangan = $_POST[Keterangan];

      	$nm_file = basename($_FILES['fileupload']['name']);
      	$extension = end(explode(".", $nm_file));
      	$gantinama = $id_Skpd."_".acaknmfile()."_".$_SESSION[thn_Login].".".$extension;
      	$nm_folder = "../media/$_SESSION[thn_Login]/"; //nama folder simpan gambar

      	$pindah_foto = move_uploaded_file($_FILES['fileupload']['tmp_name'], $nm_folder.$gantinama);
      	if(isset($_POST[simpanupload]) AND !empty($nm_file)) {
          		$qsy = mysql_query("INSERT INTO uploadberkas (id_Cklist,id_Spm, Keterangan, fileupload, Create_at)
          										VALUES ('$id_Cklist','$id_Spm', '$Keterangan', '$gantinama', now())");
          		if($qsy) {
          			header('Location:../main.php?module=spm&act=add&id='.$id_Spm.'');
          		} else {
          			echo mysql_error();
          		}
        } else {
          //header('Location:../main.php?module=spm&act=add&id='.$id_Spm.'');
          echo "gagalupload";
        }

} elseif($act == "hapus" and $module == "spm"){
        $xx = $_POST[namafile];
        echo $xx;
        exit("hapus");
      //data rincian spm
        $id_Cklist = $_POST[id_Cklist];
        $Keterangan = $_POST[Keterangan];

      	$nm_file = basename($_FILES['fileupload']['name']);
      	$extension = end(explode(".", $nm_file));
      	$gantinama = $id_Skpd."_".acaknmfile()."_".$_SESSION[thn_Login].".".$extension;
      	$nm_folder = "../media/$_SESSION[thn_Login]/"; //nama folder simpan gambar

      	$pindah_foto = move_uploaded_file($_FILES['fileupload']['tmp_name'], $nm_folder.$gantinama);
      	if(isset($_POST[simpanupload]) AND !empty($nm_file)) {
          		$qh = mysql_query("DELETE FROM uploadberkas WHERE id_Upload='$_GET[id]'");
              if($qh) {
                chdir('../../'.$nm_folder);
                $hapusfile = unlink($nm_file);
                if($hapusfile == "1") {
                  header('Location:../../fo/?module=permohonan&act=main&id='.$rd[id_Register].'');
                } else {
                  header('Location:../../fo/?module=permohonan&act=main&id='.$rd[id_Register].'');
                }
              }
        } else {
          //header('Location:../main.php?module=spm&act=add&id='.$id_Spm.'');
          echo "gagalupload";
        }
        //ini contoh delete
        $qd = mysql_query("SELECT * FROM co_syaratdokumen WHERE id_SyaratDokumen = $_GET[id]");
      	$rd = mysql_fetch_array($qd);
      	$nm_file = end(explode("/", $rd['nm_FileSyarat']));
      	$path = explode("/",$rd['nm_FileSyarat']);
      	$nm_folder = $path[0].'/'.$path[1];
      	if(!empty($_GET[id])) {
      		$qh = mysql_query("DELETE FROM co_syaratdokumen WHERE id_SyaratDokumen = $_GET[id]");
      		if($qh) {
      			chdir('../../'.$nm_folder);
      			$hapusfile = unlink($nm_file);
      			if($hapusfile == "1") {
      				header('Location:../../fo/?module=permohonan&act=main&id='.$rd[id_Register].'');
      			} else {
      				//echo "Gagal dihapus";
      				header('Location:../../fo/?module=permohonan&act=main&id='.$rd[id_Register].'');
      			}
      		}
      	}

} elseif($act=="status" AND $module=="spm") {
  if(isset($_POST[simpan])) {
    $TotalSmntara = $_POST[TotalSmntara];
    if($StatusSpm == 1 AND $TotalSmntara == $Anggaran) {

      $qry = mysql_query("UPDATE spm SET StatusSpm = 1,
                                              Create_at=now()
                                      WHERE id_Spm ='$id_Spm'");

      if ($qry)
          {
              header('location:../main.php?module=spm');
          }
      else
          {
              echo mysql_error();
          }
    } elseif($StatusSpm == 0) {
      $qry = mysql_query("UPDATE spm SET StatusSpm = 0,
                                       Create_at=now()
                               WHERE id_Spm ='$id_Spm'");
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
    echo "gagal simpan status";
  }
}
