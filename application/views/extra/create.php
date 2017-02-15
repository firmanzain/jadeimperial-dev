<div class="col-md-12">
	<h4>Halaman Input Jam Ekstra Karyawan</h4>
	<hr>
		<div class="row">
			<form action="" name="form1" id="form1" method="post">
					<div class="form-group col-md-6">
						<label>NIK</label><br>
						<input type="text" class="form-control" name="nik" id="nik" style="width: 90%; display: inline;" required/>
						<button class="btn btn-default" type="button" id="cari">...</button>
						<div class="label label-info" id="show" style="display: inline;" hidden></div>
					</div>
					<div class="form-group col-md-6">
						<label>Jenis Ekstra</label>
						<select class="form-control" name="jenis_ekstra" id="jenis_ekstra">
							<option value="1">Ekstra Kerja</option>
							<option value="2">Ekstra Lain</option>
						</select>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div id="lain">
								<div class="form-group col-md-12">
									<label>Nominal Ekstra</label>
									<input class="form-control" type="text" name="nominal_ekstra" id="nominal_ekstra" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
								</div>
							</div>
							<div id="kerja">
								<div class="form-group col-md-3">
									<label>Jam Mulai</label>
									<input class="form-control" type="text" name="jam1" id="jam1" data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
								</div>
								<div class="form-group col-md-3">
									<label>Jam Selesai</label>
									<input class="form-control" type="text" name="jam2" id="jam2" data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true"/>
								</div>
								<div class="form-group col-md-6" id="div_vakasi">
									<label>Vakasi</label>
									<select name="vakasi" id="vakasi" class="form-control">
										<option value="Tambah DP Libur">Tambah DP Libur</option>
										<option value="Dibayar">Dibayar</option>
									</select>
								</div>
								<div class="form-group col-md-6" id="uang" hidden>
									<label>Tarif Upah Per Jam</label>
									<input class="form-control" type="text" name="upah" id="upah" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group col-md-4">
						<label>HRD</label>
						<select name="hrd" class="form-control">
							<?php
								$hrd=$this->db->join('tab_jabatan b','b.id_jabatan = a.jabatan')->where('b.fungsionalitas','hrd')->select('a.nik,a.nama_ktp')->get('tab_karyawan a')->result();
								foreach ($hrd as $rs_hd) {
									echo "<option>$rs_hd->nama_ktp</option>";
								}
							?>							
						</select>
					</div>
					<div class="form-group col-md-4">
						<label>Kepala Derpatment</label>
						<select name="kepala_department" class="form-control">
							<?php
								$kepdep=$this->db->join('tab_jabatan b','b.id_jabatan = a.jabatan')->where('b.fungsionalitas','kepala department')->select('a.nik,a.nama_ktp')->get('tab_karyawan a')->result();
								foreach ($kepdep as $rs_kp) {
									echo "<option>$rs_kp->nama_ktp</option>";
								}
							?>							
						</select>
					</div>
					<div class="form-group col-md-4">
						<label>Tanggal Ekstra</label>
						<input type="text" name="tanggal_ekstra" value="<?=date('Y-m-d')?>" id="date-picker2" readonly class="form-control" />
					</div>
					<div class="form-group col-md-12">
						<label>Keterangan</label>
						<input type="text" name="keterangan" class="form-control" />
					</div>
					<div class="form-group col-md-12">
						<button type="submit" class="btn btn-primary" id="simpan" disabled>Simpan</button>
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
		 $('#vakasi').change(function(){
		 	var vee = $('#vakasi').val();
		 	if (vee == "Dibayar") {
		 		$('#uang').attr('hidden',false);
		 		$('#upah').attr('required',true);
		 		$('#div_vakasi').attr('class','form-group col-md-6');
		 	} else {
		 		$('#uang').attr('hidden',true);
		 		$('#div_vakasi').attr('class','form-group col-md-12');
		 		$('#upah').attr('required',false);
		 	}
		 });
	});
	$(function() {
	    $('#nik').keyup(function(){
	        var pm1=$('#nik').val();
	        $.ajax({
	                type: "POST",
	                url : "<?php echo base_url(); ?>IzinController/ajax_cari",
	                data : "nik="+pm1+"",
	                datatype : 'json',
	                success: function(msg){
				        $('#show').attr('hidden',false);
	                    $('#show').html(msg);
	                    if (msg != "Data Tidak Valid") {
					        $('#simpan').attr('disabled',false);
	                    } else {
					        $('#simpan').attr('disabled',true);
	                    }
	                }
	            });
	    });
	});
	$(function() {
	    $('#jenis_ekstra').change(function(){
	        var pm1=$('#jenis_ekstra').val();
	        if (pm1=='1') {
	        	$('#kerja').show();
	        	$('#lain').hide();
	        }else{
	        	$('#kerja').hide();
	        	$('#lain').show();
	        }
	    });
	});
$( document ).ready(function() {
	$('#jenis_ekstra').trigger("change");
});
</script>