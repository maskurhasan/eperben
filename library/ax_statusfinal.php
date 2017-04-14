<?php
include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_Status'];
$q = mysql_query('SELECT * FROM statusfinal a, skpd b WHERE a.id_Skpd = b.id_Skpd AND a.id_Status = "'.$postur.'"');
$r = mysql_fetch_array($q);



echo "<form method=post action='modul/act_modstatusfinal.php?module=statusfinal&act=edit'>


      </form>";


?>
