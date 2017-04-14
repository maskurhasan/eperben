<?php 
include "../config/koneksi.php";

//mengambil data desa
//ambil value dri data kd_Urusan + kd_BidUrusan
$terima = $_POST[id_Program];

//$postur1 = $_POST[kd_BidUrusan];
$sql1 = 'SELECT * FROM kegiatan WHERE id_Program = "'.$terima.'"';
$no=1;
$result1 = mysql_query($sql1);
echo "<div class=module>
        <h2><span>Daftar Kegiatan</span></h2>
        <div class=module-table-body>
        <form action=''>
        <table class=tabel width=700px>
        <thead><tr><th style=width:5%>#</th>
        <th>Kode</th><th>Nama kegiatan</th>
        <th>Aksi</th></tr></thead><tbody>";
		$no=1;
while($dt = mysql_fetch_array($result1)) {
	$no % 2 === 0 ? $alt="alt" : $alt="";
	echo "<tr class=$alt><td>".$no++."</td>
          <td>$dt[id_Kegiatan]</td>
          <td>$dt[nm_Kegiatan]</td>
          <td class=align-center><a href='?module=kegiatan&act=edit&id=$dt[id_Kegiatan]'><i class='fa fa-edit fa-lg'></i> Edit</a>
          		<a href='?module=kegiatan&act=delete'><i class='fa fa-trash-o fa-lg'></i> Hapus</a></td>
          </tr>";
} 
echo "</tbody></table></form></div></div>";

?>
<script type="text/javascript">
$("#myTable").tablesorter({widgets: ['zebra'],
	headers: {6: {sorter: true}}
})
.tablesorterPager({container: $("#pager")});  

$('#example').dataTable(); 
</script>