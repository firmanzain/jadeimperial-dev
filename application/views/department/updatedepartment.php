    <h3>Update Data Department</h3>
<div class="col-md-12">
    <form action="" method="post">
        <?php
        echo form_open('DepartmentController/updatedepartment/'.$hasil->id_department);
        ?>
       <div class="form-group">
            <label>Id Department</label>
           <input type="text" name="id_department" class="form-control" id="id_department" value="<?=$hasil->id_department?>" readonly></input>
		   </div>
        <div class="form-group">
            <label>Department</label>
           <input type="text" name="department" class="form-control" id="department" value="<?=$hasil->department?>"></input>
		   </div>

       <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
          <option selected=""><?=$hasil->status?></option>
          <option>Aktif</option>
          <option>Non Aktif</option>
        </select>
      </div>

      
        <div class="form-group">
            <label>Keterangan Department</label>
           <textarea name="keterangan_department" class="form-control" id="keterangan_department" value=""><?=$hasil->keterangan_department?></textarea>
		   </div>
      
        <div class="form-group">
          <button type="submit" class="btn btn-primary" name="submit">Update</button>
          <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-warning">Batal</button>
        </div>
    </form>
</div>