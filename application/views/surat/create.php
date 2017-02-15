<h4>Halaman Buat Surat</h4>
<hr>
<div class="row">
	<form action="" method="post" onsubmit="cetakData(this.nomor.value)">
		<div class="form-group col-md-6">
			<label>Jenis Surat</label>
			<input type="text" class="form-control" name="jenis" id="jenis"/>
			<input type="hidden" class="form-control" name="nomor" id="nomor" value="<?=$nomor->id_surat+1?>" />
		</div>
		<div class="form-group col-md-6">
			<label>NO Surat</label>
			<input type="text" class="form-control" name="no_surat" id="no_surat"/>
		</div>
		<div class="form-group col-md-6">
			<label>Perihal</label>
			<input type="text" class="form-control" name="perihal" id="perihal"/>
		</div>
		<div class="form-group col-md-6">
			<label>Lampiran</label>
			<input type="text" class="form-control" name="lampiran" id="lampiran"/>
		</div>
		<div class="form-group col-md-6">
			<label>Kepada</label>
			<input type="text" class="form-control" name="kepada" id="kepada"/>
		</div>
		<div class="form-group col-md-6">
			<label>Pengirim</label>
			<select name="nik" class="form-control">
			<?php
                foreach ($hrd as $rs) {
                  echo "<option value='$rs->nik'>$rs->nama_ktp</option>";
                }
            ?>
			</select>
		</div>
		<div class="form-group col-md-12">
			<label>Isi</label>
			<textarea name="isi" class="ckeditor"></textarea>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>
<script>
function cetakData(id) {
  sUrl="<?=base_url()?>surat/"+id+"/print"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>