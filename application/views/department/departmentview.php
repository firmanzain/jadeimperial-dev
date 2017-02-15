    <h3>Tambah Data Department</h3>
<div class="col-md-12">
<form action="" method="post">
    <div class="form-group">
	<label>Department</label>
	<input type="text" class="form-control" name="department" id="department"></input>
</div>


<div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
          <option>Aktif</option>
          <option>Non Aktif</option>
        </select>
</div>

<div class="form-group">
	<label>Keterangan Department</label>
	<textarea name="keterangan_department" class="form-control" rows="4"></textarea>
</div>


   <div class="form-group">
	<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
	<button type="button" onclick="window.history.go(-1); return false;" class="btn btn-warning">Batal</button>
</div>
</form>
</div>
