<h3>Tambah Data Plant</h3>
<div class="col-md-12">
<form action="" method="post">
    <div class="form-group">
	<label>Plant</label>
	<input type="text" class="form-control" name="plant" id="plant"></input>
</div>
<div class="form-group">
	<label>Status</label>
	<select class="form-control" name="status">
		<option>Aktif</option>
		<option>Non Aktif</option>
	</select>
</div>
<div class="form-group">
	<label>Keterangan Plant</label>
	<textarea name="keterangan_plant" class="form-control" rows="4"></textarea>
</div>
   <div class="form-group">
	<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
	<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Batal</button>
</div>
</form>
</div>