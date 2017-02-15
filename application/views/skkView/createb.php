<div class="col-md-12">
<form action="" method="post">
	<?php
    echo form_open('SkkController/skkbKaryawan/'.$hasil->nik);
    ?>
	  <h3>Pengajuan BPJS kesehatan "<?= $hasil->nama_ktp; ?>"</h3><br>
	  <input type="hidden" name="nik" value="<?= $hasil->nik; ?>">
<div class="form-group">
	<button type="submit" style="margin-left:35%;margin-top:5%;width:25%;height:40%;" class="btn btn-primary" name="submit">Ajukan BPJS Kesehatan Karyawan</button>
</div>
</form>