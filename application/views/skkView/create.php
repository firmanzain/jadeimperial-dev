<div class="col-md-12">
<form action="" method="post">
	<?php
    echo form_open('SkkController/skkKaryawan/'.$hasil->nik);
    ?>
	  <h3>Resign Karyawan Bernama "<?= $hasil->nama_ktp; ?>"</h3><br>
	  <input type="hidden" name="nik" value="<?= $hasil->nik; ?>">
<div class="form-group">
	<button type="submit" style="margin-left:40%;margin-top:5%;width:20%;height:40%;" class="btn btn-primary" name="submit">Klik Untuk Resign Karyawan</button>
</div>
</form>