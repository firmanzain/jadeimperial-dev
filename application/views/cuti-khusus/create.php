<h4>Halaman Input Master Cuti Khusus</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-12">
			<label>Keterangan</label>
			<input type="text" class="form-control" maxlength="100" name="keterangan" id="keterangan"></input>
		</div>
		<div class="form-group col-md-12">
			<label>Maksimal Lama Cuti (Satuan Hari)</label>
			<input type="number" class="form-control" name="lama" id="lama"></input>
		</div>


		<div class="form-group col-md-12">
		        <label>Status</label>
		        <select class="form-control" name="status">
		          <option>Aktif</option>
		          <option>Non Aktif</option>
		        </select>
		</div>


		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>