<?php


//ARRAY************************************************************************************************
$arrhari = array('0' => 'Minggu',
       '1' => 'Senin',
       '2' => 'Selasa',
	   '3' => 'Rabu',
	   '4' => 'Kamis',
	   '5' => 'Jumat',
	   '6' => 'Sabtu'
	);


$arrbln = array(
       '1' => 'Januari',
       '2' => 'Pebruari',
	   '3' => 'Maret',
	   '4' => 'April',
	   '5' => 'Mei',
	   '6' => 'Juni',
	   '7' => 'Juli',
	   '8' => 'Agustus',
	   '9' => 'September',
	   '10' => 'Oktober',
	   '11' => 'Nopember',
	   '12' => 'Desember'
	);

$arrbln1 = array(
       '01' => 'Januari',
       '02' => 'Pebruari',
	   '03' => 'Maret',
	   '04' => 'April',
	   '05' => 'Mei',
	   '06' => 'Juni',
	   '07' => 'Juli',
	   '08' => 'Agustus',
	   '09' => 'September',
	   '10' => 'Oktober',
	   '11' => 'Nopember',
	   '12' => 'Desember'
	);

$arrbln2 = array(
       '1' => 'Jan',
       '2' => 'Peb',
	   '3' => 'Mar',
	   '4' => 'Apr',
	   '5' => 'Mei',
	   '6' => 'Jun',
	   '7' => 'Jul',
	   '8' => 'Agu',
	   '9' => 'Sep',
	   '10' => 'Okt',
	   '11' => 'Nop',
	   '12' => 'Des'
	);
$arrtriwulan = array(
		'1' =>'1',
		'2'=>'1',
		'3'=>'1',
		'4'=>'2',
		'5'=>'2',
		'6'=>'2',
		'7'=>'3',
		'8'=>'3',
		'9'=>'3',
		'10'=>'4',
		'11'=>'4',
		'12'=>'4');
//************************************************************************************************

//fungsi tahun
$tahun = date("Y");
$bulan = date("m");
$tanggal = date("d");
$hari = date("w");
$jam = date("H");
$menit = date("i");
$detik = date("s");
$today = "$tahun:$bulan:$tanggal $jam:$menit:$detik";
$today2 = "$tahun:$bulan:$tanggal";
$today3 = "$tahun$bulan$tanggal$jam$menit$detik";
$today4 = "$tanggal$bulan$tahun";

//*************************************************************************************************
//fungsi redirect
function xloc($str)
	{
	echo "<script>location.href='$str'</script>";
	header("Location:$str");
	}



//xtutup untuk menutup koneksi
function xtutup($str)
	{
	mysql_close($str);
	}

function hal_man($link,$first,$prev,$next,$end,$count)
{

    echo '<table alignment="">
        <tr>
            <td align=right>| <a href="?page='.$link.'&hal='.$first.'">Awal</a> | <a href="?page='.$link.'&hal='.$prev.'">Sebelumnya</a> |
            <a href="?page='.$link.'&hal='.$next.'">Selanjutnya</a> | <a href="?page='.$link.'&hal='.$end.'">Akhir</a> |
            '.$count.' data</td>
        </tr>
    </table>';

}


	function tgl_indo($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan = getBulan2(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;
	}

        function getTahun($tgl){
            $tahun = substr($tgl,0,4);

            return $tahun;
        }

	function getBulan($bln){
				switch ($bln){
					case 1:
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			}

       function getBulan2($bln){
				switch ($bln){
					case 1:
						return "Jan";
						break;
					case 2:
						return "Feb";
						break;
					case 3:
						return "Mar";
						break;
					case 4:
						return "Apr";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agus";
						break;
					case 9:
						return "Sept";
						break;
					case 10:
						return "Okt";
						break;
					case 11:
						return "Nov";
						break;
					case 12:
						return "Des";
						break;
				}
			}
     function getMonth($table="", $date_column=""){

	if ($table=="") {
		$table = "transaksibeli";	$date_column = "tglTransaksiBeli";
	};
         $query = mysql_query("select distinct(month($date_column)) as bulan from $table
                group by bulan
                order by bulan desc") or die(mysql_error());
         return $query;
     }

     function getYear(){
         $query = mysql_query("select distinct(year(tglTransaksiBeli)) as tahun from transaksibeli
                group by tahun
                order by tahun desc") or die(mysql_error());
         return $query;
     }

     function getBulanku($bln){
        switch ($bln){
            case 1:
                return "Jan";
		break;
            case 2:
		return "Feb";
		break;
            case 3:
		return "Mar";
		break;
            case 4:
		return "Apr";
		break;
            case 5:
		return "Mei";
		break;
            case 6:
		return "Juni";
		break;
            case 7:
		return "Juli";
		break;
            case 8:
		return "Agus";
		break;
            case 9:
		return "Sept";
		break;
            case 10:
		return "Okt";
		break;
            case 11:
		return "Nov";
		break;
            case 12:
		return "Des";
                break;
        }
    }

    function tgl_standar($tgl) {
    	$pecah = explode("-", $tgl);
    	$hasil = $pecah[2]."/".$pecah[1]."/".$pecah[0];
    	return $hasil;
    }



function frm_angka($str) {
	$str = number_format($str,"",",",".");
	return $str;
}

function frm_desimal($str) {
	$str = round($str,2);
	return $str;
}

//pencacah bilangan duit
function xduit($str)
	{
	//bernilai 3 digit
	if (strlen($str) == 3)
		{
		$nil1 = substr($str,-3);
		echo "Rp. $nil1,00";
		}

	//bernilai 4 digit
	else if (strlen($str) == 4)
		{
		$nil1 = substr($str,0,1);
		$nil2 = substr($str,-3);
		echo "Rp. $nil1.$nil2,00";
		}


	//jika ada 5 digit
	else if (strlen($str) == 5)
		{
		$nil1 = substr($str,0,2);
		$nil2 = substr($str,-3);
		echo "Rp. $nil1.$nil2,00";
		}

	//jika ada 6 digit
	else if (strlen($str) == 6)
		{
		$nil1 = substr($str,0,3);
		$nil2 = substr($str,-3);
		echo "Rp. $nil1.$nil2,00";
		}

	//jika ada 7 digit
	else if (strlen($str) == 7)
		{
		$nil1 = substr($str,0,1);
		$nil2 = substr($str,1,3);
		$nil3 = substr($str,-3);
		echo "Rp. $nil1.$nil2.$nil3,00";
		}

	//jika ada 8 digit
	else if (strlen($str) == 8)
		{
		$nil1 = substr($str,0,2);
		$nil2 = substr($str,2,3);
		$nil3 = substr($str,-3);
		echo "Rp. $nil1.$nil2.$nil3,00";
		}

	//jika ada 9 digit
	else if (strlen($harga) == 9)
		{
		$nil1 = substr($str,0,3);
		$nil2 = substr($str,3,3);
		$nil3 = substr($str,-3);
		echo "Rp. $nil1.$nil2.$nil3,00";
		}
	}



//pencacah bilangan duit
function xduit2($str)
	{
	//bernilai 3 digit
	if (strlen($str) == 3)
		{
		$nil1 = substr($str,-3);
		$nillx = "Rp. $nil1,00";
		return $nillx;
		}

	//bernilai 4 digit
	else if (strlen($str) == 4)
		{
		$nil1 = substr($str,0,1);
		$nil2 = substr($str,-3);
		$nillx = "Rp. $nil1.$nil2,00";
		return $nillx;
		}


	//jika ada 5 digit
	else if (strlen($str) == 5)
		{
		$nil1 = substr($str,0,2);
		$nil2 = substr($str,-3);
		$nillx = "Rp. $nil1.$nil2,00";
		return $nillx;
		}

	//jika ada 6 digit
	else if (strlen($str) == 6)
		{
		$nil1 = substr($str,0,3);
		$nil2 = substr($str,-3);
		$nillx = "Rp. $nil1.$nil2,00";
		return $nillx;
		}

	//jika ada 7 digit
	else if (strlen($str) == 7)
		{
		$nil1 = substr($str,0,1);
		$nil2 = substr($str,1,3);
		$nil3 = substr($str,-3);
		$nillx = "Rp. $nil1.$nil2.$nil3,00";
		return $nillx;
		}

	//jika ada 8 digit
	else if (strlen($str) == 8)
		{
		$nil1 = substr($str,0,2);
		$nil2 = substr($str,2,3);
		$nil3 = substr($str,-3);
		$nillx = "Rp. $nil1.$nil2.$nil3,00";
		return $nillx;
		}

	//jika ada 9 digit
	else if (strlen($str) == 9)
		{
		$nil1 = substr($str,0,3);
		$nil2 = substr($str,3,3);
		$nil3 = substr($str,-3);
		$nillx = "Rp. $nil1.$nil2.$nil3,00";
		return $nillx;
		}
    //jika ada 10 digit
  	else if (strlen($str) == 10)
  		{
  		$nil1 = substr($str,0,3);
  		$nil2 = substr($str,7,3);
      $nil3 = substr($str,3,3);
  		$nil4 = substr($str,-3);
  		$nillx = "Rp. $nil1.$nil2.$nil3.$nil4,00";
  		return $nillx;
  		}
	}

function format_angka($angka){
	$str = number_format($angka,2,",",".");
	return $str;
}
function angkrp($angka){
	$str = number_format($angka,2,",",".");
  $hs = "Rp. $str";
  return $hs;
}

function acaknmfile() {
	$karakter= 'abcdef1234567890';
	$string = '';
	for ($i = 0; $i < 9; $i++) {
		$pos = rand(0, strlen($karakter)-1);
		$string .= $karakter{$pos};
	}
	return $string;
}

//bank
$arrBank = array('002' => "BANK BRI",'126'=>"BANK SUL-SEL",'008'=>"BANK MANDIRI",'009'=>"BANK BNI",'011'=>"BANK DANAMON",'014'=>'BANK BCA');
//jns spm
$jns_spm = array(1=>'SPM-UP',2=>'SPM-GU',3=>'SPM-LS',4=>'SPM-LS Gaji & Tunjangan',5=>'SPM-TU' );
//jenis potongan
$jnspotongan = array(1 => 'PPN 10%',2=>'PPH 21',3=>'PPH 22',4=>'PPH Gaji',5=>'IWP',6=>'TAPERUM',7=>'ASKES' );

$status = array(0=>'Draf',1=>'Final');
?>
