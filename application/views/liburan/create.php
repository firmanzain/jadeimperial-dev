<h4>Halaman Input Hari Libur</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-6">
			<label>Tanggal Mulai</label>
			<div class="input-group date" id="date-picker1">
                <input type="text" name="tanggal1" class="form-control">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
            </div>
		</div>
		<div class="form-group col-md-6">
			<label>Tanggal Selesai</label>
			<div class="input-group date" id="date-picker2">
                <input type="text" name="tanggal2" class="form-control">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
            </div>
		</div>
		<div class="form-group col-md-6">
			<label>Menambah DP</label>
			<select name="cuti" class="form-control" id="cuti">
				<option>Ya</option>
				<option>Tidak</option>
			</select>
		</div>
		<div class="form-group col-md-12">
			<label>Keterangan</label>
			<textarea name="keterangan" class="form-control" rows="3"></textarea>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>