<h4>Halaman Input Jam Kerja</h4>
<hr>
<?=$this->session->flashdata('pesan')?>
<div class="row">
	<form action="" method="post">
		<div class="form-group col-md-6">
            <label>Kode Jam</label>
            <input type="text" name="kode_jam" class="form-control">
        </div>
		<div class="form-group col-md-6">
            <label>Dispensasi Keterlambatan (Satuan Menit)</label>
            <input type="number" name="dispensasi" class="form-control">
        </div>
		<div class="form-group col-md-6">
			<label>Jam Mulai Pertama</label>
			<input class="form-control" type="text" name="jam_mulai" id="jam_mulai" placeholder="00:00:00"  data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true" required/>
		</div>
		<div class="form-group col-md-6">
			<label>Jam Selesai Pertama</label>
			<input class="form-control" type="text" name="jam_selesai" id="jam_selesai" placeholder="00:00:00"  data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-6">
			<label>Jam Mulai Kedua</label>
			<input class="form-control" type="text" name="jam_mulai2" id="jam_mulai2" placeholder="00:00:00"  data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-6">
			<label>Jam Selesai Kedua</label>
			<input class="form-control" type="text" name="jam_selesai2" id="jam_selesai2" placeholder="00:00:00"  data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
		</div>
		<div class="form-group col-md-6">
			<label>Keterangan</label>
			<input type="text" class="form-control" name="keterangan" id="keterangan" required/>
		</div>
		<div class="form-group col-md-6">
			<label>Departemen</label>
			<select name="departmen" class="form-control" onclick="getLain()" id="departmen">
				<option>All Departmen</option>
				<option>Khusus</option>
			</select>
			<div id="lain"></div>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Cancel</button>
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
