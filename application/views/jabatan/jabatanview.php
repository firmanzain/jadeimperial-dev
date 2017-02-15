<h4>Tambah Data Jabatan</h4>
<hr>
<div class="col-md-12">
	<form action="" method="post">
    	<div class="form-group col-md-6">
			<label>Jabatan</label>
			<input type="text" class="form-control" name="jabatan" id="jabatan" required></input>
		</div>
    	<div class="form-group col-md-6">
    		<label>Fungsionalitas Sistem</label>
    		<select name="fungsionalitas" class="form-control">
    			<option>Kosong</option>
    			<option>Administrator</option>
    			<option>Manager</option>
              	<option>Kepala Department</option>
    			<option>HRD</option>
    		</select>
		</div>
		<div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
          <option>Aktif</option>
          <option>Non Aktif</option>
        </select>
      </div>
		<div class="form-group">
			<label>Keterangan jabatan</label>
			<textarea name="keterangan_jabatan" class="form-control"></textarea>
		</div>
	   	<div class="form-group">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Batal</button>
		</div>
	</form>
</div>