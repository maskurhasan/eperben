<?php
$hostName	= "localhost";
$userName	= "root";
$passWord	= "";
$dataBase	= "srfk_nl";

mysql_connect($hostName,$userName,$passWord) or die('Koneksi Gagal');
mysql_select_db($dataBase) or die('Database tidak ditemukan');
?>