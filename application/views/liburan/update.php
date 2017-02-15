<h4>Halaman Update Libur Kerja</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<input type="hidden" name="id" value="<?=$data->id?>"></input>
		<div class="form-group col-md-6">
			<label>Tanggal Mulai</label>
			<div class="input-group date" id="date-picker1">
                <input type="text" name="tanggal1" value="<?=$data->tanggal_mulai?>" class="form-control">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
            </div>
		</div>
		<div class="form-group col-md-6">
			<label>Tanggal Selesai</label>
			<div class="input-group date" id="date-picker2">
                <input type="text" name="tanggal2" value="<?=$data->tanggal_selesai?>" class="form-control">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
            </div>
		</div>
		<div class="form-group col-md-6">
			<label>Menambah Cuti</label>
			<select name="cuti" id="cuti" class="form-control">
				<option selected><?=$data->cuti_khusus?></option>
				<option>Ya</option>
				<option>Tidak</option>
			</select>
		</div>
		<div class="form-group col-md-12">
			<label>Keterangan</label>
			<textarea name="keterangan" class="form-control" rows="4"><?=$data->keterangan?></textarea>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Update</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>