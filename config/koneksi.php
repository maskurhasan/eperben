<?php
error_reporting(0);
$hostName	= "localhost";
$userName	= "root";
$passWord	= "";
$dataBase	= "eperben";

mysql_connect($hostName,$userName,$passWord) or die('Koneksi Gagal');
mysql_select_db($dataBase) or die('Database tidak ditemukan');



?>
