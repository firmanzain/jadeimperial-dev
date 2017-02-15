<h4>Halaman Update Level User</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-12">
			<label>Deskripsi Level User</label>
			<input type="hidden" name="kode" value="<?=$data->kode?>">
			<input type="text" name="deskripsi" class="form-control" value="<?=$data->deskripsi?>" maxlength="50" placeholder="Admin; Super Admin; dll...">
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>