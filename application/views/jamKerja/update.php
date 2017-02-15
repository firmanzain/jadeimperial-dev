<h4>Halaman Update Jam Kerja</h4>
<hr>
<div class="row">
	<form action="" method="post">
		<input type="hidden" name="id" value="<?=$data->id?>"/>
		<div class="form-group col-md-6">
            <label>Kode Jam</label>
            <input type="text" name="kode_jam" value="<?=$data->kode_jam?>" class="form-control">
        </div>
		<div class="form-group col-md-6">
            <label>Dispensasi Keterlambatan (Satuan Menit)</label>
            <input type="number" name="dispensasi" value="<?=$data->dispensasi?>" class="form-control" required>
        </div>
		<div class="form-group col-md-6">
			<label>Jam Mulai Pertama</label>
			<input class="form-control" type="text" name="jam_mulai" id="jam_mulai" value="<?=$data->jam_start?>" placeholder="00:00:00"  data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-6">
			<label>Jam Selesai Pertama</label>
			<input class="form-control" type="text" name="jam_selesai" id="jam_selesai" value="<?=$data->jam_finish?>" placeholder="00:00:00"  data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-6">
			<label>Jam Mulai Kedua</label>
			<input class="form-control" type="text" name="jam_mulai2" id="jam_mulai2" value="<?=$data->jam_start2?>" placeholder="00:00:00"  data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-6">
			<label>Jam Selesai Kedua</label>
			<input class="form-control" type="text" name="jam_selesai2" id="jam_selesai2" value="<?=$data->jam_finish2?>" placeholder="00:00:00"  data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-6">
			<label>Keterangan</label>
			<input type="text" class="form-control" name="keterangan" id="keterangan" value="<?=$data->keterangan?>" required/>
		</div>
		<div class="form-group col-md-6">
			<label>Departemen</label>
			<select name="departmen" class="form-control" id="departmen" required>
				<option selected><?=$data->departmen?></option>
				<option>All Departmen</option>
				<option>Khusus</option>
			</select>
			<div id="lain"></div>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Update</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;" name="submit">Cancel</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	function getLain() {
		var data=$('#departmen').val();
		if (data=='Khusus') {
			$('#departmen').prop('disabled',true);
			$('#departmen').prop('hidden',true);
			var jns= document.createElement("input");
			jns.type="text";
			jns.name="departmen";
			jns.id="js";
			$('#lain').html(jns);
			document.getElementById('js').setAttribute('class','form-control col-md-6');
			jns.focus();
		}
	}
</script>