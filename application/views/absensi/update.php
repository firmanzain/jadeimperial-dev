<h4>Update Data Absensi Karyawan</h4>
<hr>
<div class="row">
	<form action="" method="post" class="form-horizontal">
		<div class="form-group col-md-6">
			<label>NIK</label>
			<input type="text" class="form-control" maxlength="30" name="nik" value="<?=$data->nik?>" readonly/>
			<input type="hidden" class="form-control" name="url" value="<?=$this->session->userdata('link')?>"/>
			<input type="hidden" class="form-control" name="id" value="<?=$data->id?>"/>
		</div>
		<div class="form-group col-md-6">
			<label>Tanggal Absen</label>
			<input type="text" class="form-control" id="date-picker2" name="tanggal_kerja" value="<?=date('Y-m-d',strtotime($data->tgl_kerja))?>" readonly/>
		</div>
		<div class="form-group col-md-6">
			<label>Jam Masuk</label>
			<input class="form-control" type="text" name="jam_masuk" id="jam_masuk" data-mask="00:00:00" value="<?=date('H:i:s',strtotime($data->jam_masuk1))?>" placeholder="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-6">
			<label>Jam Keluar</label>
			<input class="form-control" type="text" name="jam_keluar" id="jam_keluar" data-mask="00:00:00" value="<?=date('H:i:s',strtotime($data->jam_keluar1))?>" placeholder="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-3">
			<label>Status Masuk</label>
			<select name="status_masuk" id="status_masuk" class="form-control">
				<option selected><?=$data->status_masuk?></option>
				<option>Masuk</option>
				<option>Masuk Tidak Lengkap</option>
				<option>Libur</option>
			</select>
		</div>
		<!--<div class="form-group col-md-3">
			<label>Durasi Keterlambatan</label>
			<input type="text" class="form-control" placeholder="Isikan jika karyawan status terlambat" value="<?=$data->terlambat?>" name="terlambat" id="terlambat" />
		</div>-->
		<div class="form-group col-md-9">
			<label>Keterangan Masuk</label>
			<input type="text" class="form-control" name="keterangan_masuk" value="<?=$data->keterangan_masuk?>" placeholder="On Time, Telat, Schedule Fail, Finger Fail atau lainnya" />
		</div>
		<div class="form-group col-md-3">
			<label>Status Keluar</label>
			<select name="status_keluar" id="status_keluar" class="form-control">
				<option selected><?=$data->status_keluar?></option>
				<option>Pulang</option>
				<option>Pulang Tidak Lengkap</option>
				<option>Libur</option>
			</select>
		</div>
		<div class="form-group col-md-9">
			<label>Keterangan Keluar</label>
			<input type="text" class="form-control" name="keterangan_keluar" value="<?=$data->keterangan_keluar?>" placeholder="Pulang, Pulang Cepat, Schedule Fail, Finger Fail atau lainnya" />
		</div>
		<div class="form-group col-md-6">
			<label>Jam Masuk 2</label>
			<input class="form-control" type="text" name="jam_masuk2" id="jam_masuk2" data-mask="00:00:00" value="<?=date('H:i:s',strtotime($data->jam_masuk2))?>" placeholder="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-6">
			<label>Jam Keluar 2</label>
			<input class="form-control" type="text" name="jam_keluar2" id="jam_keluar2" data-mask="00:00:00" value="<?=date('H:i:s',strtotime($data->jam_keluar2))?>" placeholder="00:00:00" data-mask-reverse="true" data-mask-maxlength="true" />
		</div>
		<div class="form-group col-md-3">
			<label>Status Masuk 2</label>
			<select name="status_masuk2" id="status_masuk2" class="form-control">
				<option selected><?=$data->status_masuk2?></option>
				<option>Masuk</option>
				<option>Masuk Tidak Lengkap</option>
				<option>Libur</option>
			</select>
		</div>
		<!--<div class="form-group col-md-3">
			<label>Durasi Keterlambatan 2</label>
			<input type="text" class="form-control" placeholder="Isikan jika karyawan status terlambat" value="<?=$data->terlambat2?>" name="terlambat" id="terlambat" />
		</div>-->
		<div class="form-group col-md-9">
			<label>Keterangan Masuk 2</label>
			<input type="text" class="form-control" name="keterangan_masuk2" value="<?=$data->keterangan_masuk2?>" placeholder="On Time, Telat, Schedule Fail, Finger Fail atau lainnya" />
		</div>
		<div class="form-group col-md-3">
			<label>Status Keluar 2</label>
			<select name="status_keluar2" id="status_keluar2" class="form-control">
				<option selected><?=$data->status_keluar2?></option>
				<option>Pulang</option>
				<option>Pulang Tidak Lengkap</option>
				<option>Libur</option>
			</select>
		</div>
		<div class="form-group col-md-9">
			<label>Keterangan Keluar 2</label>
			<input type="text" class="form-control" name="keterangan_keluar2" value="<?=$data->keterangan_keluar2?>" placeholder="Pulang, Pulang Cepat, Schedule Fail, Finger Fail atau lainnya" />
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