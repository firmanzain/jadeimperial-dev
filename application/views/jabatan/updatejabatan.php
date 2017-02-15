<div class="col-md-12">
  <h4>Update Data Jabatan</h4>
  <hr>
  <?php
  echo form_open('JabatanController/updatejabatan/'.$hasil->id_jabatan);
  ?>
    <div class="row">
         <input type="hidden" name="id_jabatan" class="form-control" id="id_jabatan" value="<?=$hasil->id_jabatan?>" readonly></input>
        <div class="form-group col-md-6">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" id="jabatan" value="<?=$hasil->jabatan?>" required></input>
        </div>
        <div class="form-group col-md-6">
            <label>Fungsionalitas Sistem</label>
            <select name="fungsionalitas" class="form-control">
              <option selected><?=$hasil->fungsionalitas?></option>
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
          <option selected=""><?=$hasil->status?></option>
          <option>Aktif</option>
          <option>Non Aktif</option>
        </select>
      </div>
        <div class="form-group col-md-12">
            <label>Keterangan jabatan</label>
            <textarea name="keterangan_jabatan" class="form-control" id="keterangan_jabatan"><?=$hasil->keterangan_jabatan?></textarea>
        </div>
        <div class="form-group col-md-12">
          <button type="submit" class="btn btn-primary" name="submit">Update</button>
          <button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Batal</button>
        </div>
    </div>
  <?=form_close()?>
</div>