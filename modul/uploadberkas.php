<?php
include '../config/koneksi.php';
?>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta charset="utf-8" />
  <title>Upload Berkas</title>

  <meta name="description" content="User login page" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

  <!-- bootstrap & fontawesome -->
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/font-awesome/4.2.0/css/font-awesome.min.css" />
  <!-- text fonts -->
  <link rel="stylesheet" href="../assets/fonts/fonts.googleapis.com.css" />
  <!-- ace styles -->
  <link rel="stylesheet" href="../assets/css/ace.min.css" />

  <link rel="stylesheet" href="../assets/css/ace-rtl.min.css" />
</head>
<body>
  <div class="row">
  <div class="col-md-12">
  <div class="panel panel-default">
  <div class="panel-heading">Alur Izin</div>
  <div class="panel-body">
  <table class="table table-bordered table-condensed">
    <tr>
      <th></th>
      <th>Jenis Berkas</th>
      <th></th>
      <th></th>
    </tr>
  <?php
  $q = mysql_query("SELECT * FROM cklist");
  $no = 1;
  while ($r = mysql_fetch_array($q)) {
    echo '<tr>
      <td>'.$no++.'</td>
      <td>'.$r[nm_List].'</td>
      <td><input type="file"></td>
      <td><input class="btn btn-xs btn-primary" type="button" value="Upload"></td>
    </tr>';
  }
  ?>
  </table>
</div>
</div>
</div>
</div>

</body>
</html>
