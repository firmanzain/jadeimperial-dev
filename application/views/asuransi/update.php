<h4>Halaman Update Master Asuransi</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-6">
			<label>Nama Asuransi</label>
			<input type="text" class="form-control" maxlength="30" name="asuransi" id="asuransi" value="<?=$data->asuransi?>"/>
			<input type="hidden" class="form-control" name="id" value="<?=$data->id?>" hidden/>
		</div>
		<div class="form-group col-md-6">
			<label>Vendor</label>
			<input type="text" class="form-control" maxlength="50" name="vendor" value="<?=$data->vendor?>" id="vendor"/>
		</div>

	<div class="form-group col-md-6">
        <label>Status</label>
        <select class="form-control" name="status">
          <option selected=""><?=$data->status?></option>
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