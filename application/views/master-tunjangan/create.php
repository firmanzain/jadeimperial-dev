<h4>Halaman Input Master Tunjangan</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-4">
			<label>Nama Tunjangan</label>
			<input type="text" class="form-control" name="tunjangan" id="tunjangan"/>
		</div>

		<div class="form-group col-md-4">
			<label>Status Tunjangan</label>
			<select name="status" class="form-control">
				<option>Tahunan</option>
				<option>Bulanan</option>
				<option>Harian</option>
			</select>
		</div>

		<div class="form-group col-md-4">
	        <label>Status</label>
	        <select class="form-control" name="status_tunjangan">
	          <option>Aktif</option>
	          <option>Non Aktif</option>
	        </select>
		</div>

		<div class="form-group col-md-4"> 
			<label>Tanggal Bagi</label>
			<div class="input-group date" id="date-picker2">
                <input type="text" name="tanggal" class="form-control">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
            </div>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>