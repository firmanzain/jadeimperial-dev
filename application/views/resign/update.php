<h4>Halaman Update Resign karyawan</h4>
<div class="row">
	<form action="" method="post">
		<input type="hidden" name="id" value="<?=$data->id?>"></input>
		<div class="form-group col-md-6">
			<label>NIK</label>
			<input type="text" name="nik" class="form-control" id="nik" value="<?=$data->nik?>" readonly/>
		</div>
		<div class="form-group col-md-6">
          <label>HRD</label>
          <select name="nik_hrd" class="form-control">
            <?php
            	$d_hrd=$this->db->where('nik',$data->nik_hrd)->get('tab_karyawan')->row();
            	echo "<option selected value='$d_hrd->nik'>$d_hrd->nama_ktp</option>";
                foreach ($hrd as $rs) {
                  echo "<option value='$rs->nik'>$rs->nama_ktp</option>";
                }
            ?>
          </select>
        </div>
		<div class="form-group col-md-12">
			<label>Tanggal Resign</label>
			<input type="date" name="tanggal_resign" id="tanggal_resign" class="form-control" value="<?=date("Y-m-d",strtotime($data->tanggal))?>"></input>
		</div>
		<div class="form-group col-md-12">
			<label>Keterangan</label>
			<textarea name="keterangan" class="form-control" rows="3"><?=$data->keterangan?></textarea>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Update</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>