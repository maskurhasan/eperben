<?php
include "config/koneksi.php";
//include "../config/errormode.php";

function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$UserName = anti_injection($_POST['UserName']);
$PassWord  = anti_injection(md5($_POST['PassWord']));
$thn_Login  = anti_injection($_POST['thn_Login']);

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($UserName) OR !ctype_alnum($PassWord) OR !ctype_alnum($thn_Login)){
  //echo "Sekarang loginnya tidak bisa di injeksi lho.";
  header('location:login.html');
}
else {
$login=mysql_query("SELECT * FROM user WHERE username='$UserName' AND password='$PassWord' AND Aktiv=1");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  //include "timeout.php";
	/*
  $_SESSION['KCFINDER']=array();
  $_SESSION['KCFINDER']['disabled'] = false;
  $_SESSION['KCFINDER']['uploadURL'] = "../tinymcpuk/gambar";
  $_SESSION['KCFINDER']['uploadDir'] = "";
	*/
  $_SESSION['is_login'] = 'yes';
  $_SESSION['id_User'] = $r['id_User'];
  $_SESSION['UserName'] = $r['UserName'];
  $_SESSION['PassWord'] = $r['PassWord'];
  $_SESSION['nm_Lengkap'] = $r['nm_Lengkap'];
  $_SESSION['UserLevel'] = $r['UserLevel'];
  $_SESSION['thn_Login'] = $thn_Login;
  $_SESSION['Sessid'] = $r['id_Session'];
  $_SESSION['id_Skpd'] = $r['id_Skpd'];
  $_SESSION['Aktiv']  = $r['Aktiv'];

  // session timeout
  $_SESSION[login] = 1;
  header('location:main.php?module=home');
}
else{
   header('location:login.html');
}
}
?>
