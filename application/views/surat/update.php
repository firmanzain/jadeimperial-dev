<h4>Halaman Update Surat</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<input type="hidden" name="id" value="<?=$data->id_surat?>">
		<div class="form-group col-md-6">
			<label>Jenis Surat</label>
			<input type="text" class="form-control" value="<?=$data->jenis_surat?>" name="jenis" id="jenis"/>
		</div>
		<div class="form-group col-md-6">
			<label>NO Surat</label>
			<input type="text" class="form-control" name="no_surat" value="<?=$data->no_surat?>" id="no_surat"/>
		</div>
		<div class="form-group col-md-6">
			<label>Perihal</label>
			<input type="text" class="form-control" name="perihal" value="<?=$data->perihal?>" id="perihal"/>
		</div>
		<div class="form-group col-md-6">
			<label>Lampiran</label>
			<input type="text" class="form-control" name="lampiran" value="<?=$data->lampiran?>" id="lampiran"/>
		</div>
		<div class="form-group col-md-6">
			<label>Kepada</label>
			<input type="text" class="form-control" name="kepada" value="<?=$data->kepada?>" id="kepada"/>
		</div>
		<div class="form-group col-md-6">
			<label>Pengirim</label>
			<select name="nik" class="form-control">
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
			<label>Isi</label>
			<textarea name="isi" class="ckeditor"><?=$data->isi?></textarea>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>