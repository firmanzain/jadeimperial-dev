<h4>Halaman Update Master Cuti Khusus</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<input type="hidden" name="id" value="<?=$data->id?>"/>
		<div class="form-group col-md-12">
			<label>Keterangan</label>
			<input type="text" class="form-control" maxlength="100" name="keterangan" value="<?=$data->keterangan?>" id="keterangan"/>
		</div>
		<div class="form-group col-md-12">
			<label>Maksimal Lama Cuti (Satuan Hari)</label>
			<input type="number" class="form-control" name="lama" id="lama" value="<?=$data->maximal_lama?>"/>
		</div>

	  <div class="form-group col-md-12">
        <label>Status</label>
        <select class="form-control" name="status">
          <option selected=""><?=$data->status?></option>
          <option>Aktif</option>
          <option>Non Aktif</option>
        </select>
      </div>


		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Update</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>