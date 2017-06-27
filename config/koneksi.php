<?php
error_reporting(0);

$hostName	= "localhost";
$userName	= "root";
$passWord	= "";
$dataBase	= "eperben";
$appName  = "SPM Online La-KUMIS";//"E-Perbend Luwu Utara";

/*
$hostName	= "192.168.23.208:3306";
$userName	= "UserEperben";
$passWord	= "Kunci@Perben12";
$dataBase	= "masamban_eperben";
*/
mysql_connect($hostName,$userName,$passWord) or die('Koneksi Gagal');
mysql_select_db($dataBase) or die('Database tidak ditemukan');



?>
