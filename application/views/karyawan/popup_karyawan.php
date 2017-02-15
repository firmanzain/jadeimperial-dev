<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
<title>Marino</title>
<meta name="description" content="Marino, Admin theme, Dashboard theme, AngularJS Theme">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?=base_url()?>/assets/favicon.ico">
<!-- global stylesheets -->
<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/1.0.0/css/flag-icon.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>/assets/styles/main.css" />
</head>
<body data-layout="empty-layout" data-palette="palette-0">
<div class="col-md-12">
    <h3>Ambil Data Karyawan</h3>
    <hr>
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
      $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->jenis_kelamin,$tampil->jabatan,$tampil->cabang,'<button type="button" class="label label-info" onclick="ambilData('.$tampil->nik.')">Ambil Data</button>');
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
</div>
</body>
<script type="text/javascript">
function ambilData(nik){
opener.document.form1.nik.value = nik;
window.opener.focus();
window.close();
}
</script>
<script src="<?=base_url()?>/assets/bower_components/jquery/dist/jquery.js"></script>
<script src="<?=base_url()?>/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="<?=base_url()?>/assets/bower_components/jquery-storage-api/jquery.storageapi.min.js"></script>
<script src="<?=base_url()?>/assets/bower_components/wow/dist/wow.min.js"></script>
<script src="<?=base_url()?>/assets/scripts/functions.js"></script>
<script src="<?=base_url()?>/assets/scripts/colors.js"></script>
<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/scripts/tables-datatable.js"></script>
</html>