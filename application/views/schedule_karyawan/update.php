<h4>Halaman Update Jam Kerja # <?=$data->nik?></h4>
<hr>
<?php
?>
<div class="row">
	<form id="formdata" method="post">
		<div class="form-group col-md-6">
            <label>Kode Jam</label>
            <select class="form-control" name="kode_jam">
            <option slected><?=$data->kode_jam?></option>
            <?php
            	foreach ($jam_kerja as $rs) {
            		echo "<option>$rs->kode_jam</option>";
            	}
            ?>
            </select>
        </div>
        <input type="hidden" name="nik" value="<?=$data->nik?>" class="form-control">
        <input type="hidden" name="id" value="<?=$data->id?>" class="form-control">
		<div class="form-group col-md-6">
			<label>Tanggal</label>
			<div class="input-group date" id="date-picker1" >
                <input type="text" name="tanggal" value="<?=$data->tanggal?>" class="form-control" required>
                <span class="input-group-addon"><i class="fa fa-th"></i></span>
            </div>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-primary" id="proses" name="submit">Update</button>
			<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Cancel</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$('#formdata').on('submit',function(e) {
		e.preventDefault();
		var str = $( "#formdata" ).serialize();
	        $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>ScheduleKaryawanController/Update",
            data :str,
        	beforeSend: function(msg){$('#proses').text('Please wait...');},
            success: function(msg){
                if (msg==1) {
                	window.location='<?=base_url()."shedule-karyawan/$data->nik/detail"?>';
                } else {
                	$('#proses').text('Update');
                }
            }
        });
	});
</script>