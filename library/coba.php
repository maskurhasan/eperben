<?php include 'koneksi.php'; ?>
<html>
<head>
<title>Script pilihan Kota otomatis dengan Jquery AJAX</title>
<link rel="stylesheet" href="../dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="../assets/css/chosen.css" />
<script type="text/javascript" src="../dist/js/jquery-1.10.2.min.js"></script>

</head>
<body>
<div class="container">
<form method="post">
Nama<br/>
<input type="text" name="nama" size="50"/><br/><br/>
Negara<br/>
<input type="text" name="nama" size="50"/><br/><br/>
Kecamatan<br/>
<select  name="id_Kecamatan"  onclick="pilih_kecamatan(this.value);">
	<option value="#">Pilih Provinsi</option>
	<?php
	$sql = "SELECT * FROM tbl_kecamatan";
	$query = mysql_query($sql);
	while ($row = mysql_fetch_array($query)) {
		echo '<option value="'.$row[id_Kecamatan].'">'.$row[nm_Kecamatan].'</option>';
	}

	?>
</select>
<br/><br/>
Desa<br/>
<select  name="id_Desa" id="id_Desax">
	<option value="#">Pilih Desa</option>
<select>
</form>


<form method="post">
Urusan<br/>
<select  name="id_Urusan"  onchange="pilih_Urusan(this.value);">
	<option value="#">Pilih Urusan</option>
	<?php
	$sql = "SELECT * FROM tbl_urusan";
	$query = mysql_query($sql);
	while ($row = mysql_fetch_array($query)) {
		echo '<option value="'.$row[id_Urusan].'">'.$row[nm_Urusan].'</option>';
	}

	?>
</select>
<br/><br/>
Bidang Urusan<br/>
<select  name="id_BidUrusan" id="id_BidUrusan" onchange="pilih_BidUrusan(this.value);">
	<option value="#">Pilih Bid Urusan</option>
</select>
<br/>

Program<br/>
<select  name="id_Program" id="id_Program" onchange="pilih_Program(this.value);">
	<option value="#">Pilih Program</option>
<select>
<br />
Kegiatan<br/>
<select name="id_Kegiatan" id="id_Kegiatan" onchange="">
	<option value="#">Pilih Kegiatan</option>
<select>
</form>
</div>

<script src="../assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
$(function() {
                //pilihan data dengan select
                $(".chzn-select").chosen();
				});
</script>
<script type="text/javascript">
function pilih_kecamatan(id_Kecamatan)
{
	$.ajax({
        url: 'desa.php',
        data : 'id_Kecamatan='+id_Kecamatan,
		type: "post", 
        dataType: "html",
		timeout: 10000,
        success: function(response){
			$('#id_Desax').html(response);
        }
    });
}


function pilih_Urusan(id_Urusan)
{
	$.ajax({
        url: 'bidangurusan.php',
        data : 'id_Urusan='+id_Urusan,
		type: "post", 
        dataType: "html",
		timeout: 10000,
        success: function(response){
			$('#id_BidUrusan').html(response);
        }
    });
}

function pilih_BidUrusan(id_BidUrusan)
{
	$.ajax({
        url: 'program.php',
        data : 'id_BidUrusan='+id_BidUrusan,
		type: "post", 
        dataType: "html",
		timeout: 10000,
        success: function(response){
			$('#id_Program').html(response);
        }
    });
}

function pilih_Program(id_Program)
{
	$.ajax({
        url: 'kegiatan.php',
        data : 'id_Program='+id_Program,
		type: "post", 
        dataType: "html",
		timeout: 10000,
        success: function(response){
			$('#id_Kegiatan').html(response);
        }
    });
}

</script>
<body>
</html>