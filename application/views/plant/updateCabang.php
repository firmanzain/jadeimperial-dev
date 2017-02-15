<h3>Update Data Plant</h3>
<div class="col-md-12">
<form action="" method="post">
    <?php
    echo form_open('PlantController/updateplant/'.$hasil->id_cabang);
    ?>
       <div class="form-group">
            <label>Id plant</label>
           <input type="text" name="id_plant" class="form-control" id="id_plant" value="<?=$hasil->id_cabang?>" readonly></input>
		   </div>
        <div class="form-group">
            <label>plant</label>
           <input type="text" name="plant" class="form-control" id="plant" value="<?=$hasil->cabang?>"></input>
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
            <label>Keterangan plant</label>
           <textarea name="keterangan_plant" class="form-control" id="keterangan_plant" value=""><?=$hasil->keterangan_cabang?></textarea>
		   </div>
      
<div class="form-group">
	<button type="submit" class="btn btn-primary" name="submit">Update</button>
  <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-warning">Batal</button>
</div>
        </form>
</div>