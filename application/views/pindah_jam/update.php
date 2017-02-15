<div class="col-md-12">
	<h4>Update Proses Pindah Jam Kerja Karyawan</h4>
	<hr>
		<div class="row">
			<form action="" method="post">
					<div class="form-group col-md-12">
						<label>NIK</label><br>
						<input type="text" class="form-control" name="nik" id="nik" value="<?=$data->nik?>" style="width: 30%; display: inline;" readonly/>
						<button class="btn btn-default" type="button" id="cari">...</button>
						<div class="label label-info" id="show" style="display: inline;" hidden></div>
					</div>
					<div class="form-group col-md-4">
						<label>Jam Awal</label>
						<input type="text" name="jam_asal" class="form-control" id="jam_asal" value="<?=$data->kode_jam_asal?>" readonly>
						<input type="hidden" name="id" class="form-control" id="id" value="<?=$data->id?>" readonly>
					</div>
					<div class="form-group col-md-4">
						<label>Kode Jam Ganti</label>
						<select name="jam_ganti" class="form-control">
							<option selected><?=$data->kode_jam_pindah?></option>
							<?php
								foreach ($jenis as $rs) {
									echo "<option value='$rs->kode_jam'>$rs->kode_jam</option>";
								}
							?>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label>Pindah Untuk Tanggal</label>
						<div class="input-group date" id="date-picker5">
	                        <input type="text" name="tanggal" value="<?=$data->tanggal_pindah?>" class="form-control">
	                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
	                    </div>
					</div>
					<div class="form-group col-md-12">
						<label>Keterangan</label>
						<textarea name="keterangan" class="form-control" rows="3"><?=$data->keterangan?></textarea>
					</div>
					<div class="form-group col-md-12">
						<button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
						<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Cancel</button>
					</div>
			</form>
		</div>
</div>
<?php
	function ambil_nama(){
	   $nama='';
	  $sql_nama=mysql_query("select * from tab_karyawan");
	  while($data_nama=mysql_fetch_array($sql_nama)){
	  $nama.='"'.stripslashes($data_nama['nik']).'",';
	  }
	  return(strrev(substr(strrev($nama),1)));
	}
?>
<script src="<?=base_url()?>assets/scripts/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    var DaftarNama = [<?php echo ambil_nama();?> ];
    $( "#nik" ).autocomplete({
      source: DaftarNama
    });
  });
	$(function() {
		 $('#cari').click(function(){
		 	sUrl="<?=base_url()?>resign/popup/karyawan"; features = 'toolbar=no, left=350,top=100, ' + 
			  'directories=no, status=no, menubar=no, ' + 
			  'scrollbars=no, resizable=no';
			  window.open(sUrl,"winChild",features);
		 });
	});
	$(function() {
	    $('#nik').keyup(function(){
	        var pm1=$('#nik').val();
	        $.ajax({
	                type: "POST",
	                url : "<?php echo base_url(); ?>PindahJamController/ajax_cari",
	                data : "nik="+pm1+"",
	                datatype : 'json',
	                success: function(msg){
				        $('#show').attr('hidden',false);
	                    if (msg != "Data Penjadwalan Kosong, Silahkan Cek Data Schedule Karyawan") {
					        $('#simpan').attr('disabled',false);
		                    var tampil = JSON.parse(''+msg+'' );
		                    $('#show').html("Data Valid : Nama Karyawan "+tampil.nama_ktp+"");
					        document.getElementById("jam_asal").value = tampil.kode_jam;
	                    } else {
					        document.getElementById("jam_asal").value = "";
					        $('#simpan').attr('disabled',true);
	                    }
	                }
	            });
	    });
	  });	
</script>