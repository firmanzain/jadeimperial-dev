<h4>Input Data Absensi Karyawan</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-3">
			<label>NIK</label>
			<input type="text" class="form-control" maxlength="30" name="nik" value="<?=$nik?>" readonly/>
			<input type="hidden" class="form-control" name="url" value="<?=$this->session->userdata('link')?>"/>
		</div>
		<div class="form-group col-md-3">
			<label>Tanggal Absen</label>
			<input type="text" class="form-control" id="date-picker2" name="tanggal_absen" value="<?=date('Y-m-d')?>" readonly/>
		</div>
		<div class="form-group col-md-3">
			<label>Jam Absen</label>
			<input class="form-control" type="text" name="jam_masuk" id="jam_masuk" data-mask="00:00:00" placeholder="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-3">
			<label>Jam Keluar</label>
			<input class="form-control" type="text" name="jam_keluar" id="jam_keluar" data-mask="00:00:00" placeholder="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-3">
			<label>Status</label>
			<select name="status" id="status" class="form-control">
				<option>On Time</option>
				<option>Terlambat</option>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label>Durasi Keterlambatan</label>
			<input type="text" class="form-control" placeholder="Isikan jika karyawan status terlambat" name="terlambat" id="terlambat" />
		</div>
		<div class="form-group col-md-6">
			<label>Keterangan</label>
			<input type="text" class="form-control" name="keterangan" placeholder="Masuk tidak lengkap atau lainnya" />
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Cancel</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$('#status').change(function() {
		var st=$('#status').val();

		if (st=='On Time') {
			$('#terlambat').attr('disabled',true);			
		}else{
			$('#terlambat').attr('disabled',false);			
			$('#terlambat').focus();
		}
	})
	$( document ).ready(function() {
		$('#status').trigger("change");
	});
</script>