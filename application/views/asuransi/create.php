<h4>Halaman Input Master Asuransi</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-6">
			<label>Nama Asuransi</label>
			<input type="text" class="form-control" maxlength="30" name="asuransi" id="asuransi"/>
		</div>
		<div class="form-group col-md-6">
			<label>Vendor</label>
			<input type="text" class="form-control" maxlength="50" name="vendor" id="vendor"/>
		</div>

		<div class="form-group col-md-6">
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