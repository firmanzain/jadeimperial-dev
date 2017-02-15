<div class="col-md-12">
	<h4>Halaman Cuti Karyawan</h4>
	<hr>
		<div class="row">
			<form name="form1" id="form1" action="" method="post">
					<div class="form-group col-md-12">
						<label>NIK</label><br>
						<input type="text" class="form-control" name="nik" id="nik" style="width: 30%; display: inline;" required/>
						<button class="btn btn-default" type="button" id="cari">...</button>
						<div class="label label-info" id="show" style="display: inline;" hidden></div>
					</div>
					<div class="form-group col-md-3">
						<label>Mulai Tanggal</label>
						<div class="input-group date" id="date-picker1">
		                        <input type="text" name="tanggal1" class="form-control" required>
		                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
		                    </div>
					</div>
					<div class="form-group col-md-3">
						<label>Sampai</label>
						<div class="input-group date" id="date-picker2">
	                        <input type="text" name="tanggal2" class="form-control" required>
	                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
	                    </div>
					</div>
					<div id="ct">
						<label>Cuti Khusus</label>
						<select name="cuti" class="form-control" onchange="cutiData()" id="cuti" required>
							<option>Ya</option>
							<option>Tidak</option>
						</select>
					</div>
					<div class="form-group col-md-3" id="ktr">
						<label>Keterangan Cuti Khusus</label>
						<select name="cuti_khusus" class="form-control">
							<option value="">---</option>
							<?php
								$cuti_khusus=$this->db->get('tab_cuti_khusus')->result();
								foreach ($cuti_khusus as $rs) {
									if ($rs->status=="Aktif") {
										echo "<option value='$rs->id'>$rs->keterangan</option>";
									}
								}
							?>
						</select>
					</div>
					<div class="col-md-12">
						<div class="row">


					<div class="form-group col-md-4">
						<label>Kepala Bagian</label>
						<select name="kabag" class="form-control" required>
							<?php
								$kabag=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')
												->where('b.fungsionalitas','Kepala Department')
												->get('tab_karyawan a')
												->result();
								foreach ($kabag as $rs_kabag) {
									echo '<option val="'.$rs_kabag->nama_ktp.'">'.$rs_kabag->nama_ktp.'</option>';
								}
							?>
						</select>
					</div>


					<div class="form-group col-md-4">
						<label>HRD</label>
						<select name="hrd" class="form-control" required>
							<?php
								$hrd=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')
												->where('b.fungsionalitas','HRD')
												->get('tab_karyawan a')
												->result();
								foreach ($hrd as $rs_hrd) {
									echo '<option value="'.$rs_hrd->nama_ktp.'">'.$rs_hrd->nama_ktp.'</option>';
								}
							?>
						</select>
					</div>


					<div class="form-group col-md-4">
						<label>Manager</label>
						<select name="manager" class="form-control" required>
							<?php
								$hrd=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')
												->where('b.fungsionalitas','Kepala Department')
												->get('tab_karyawan a')
												->result();
								foreach ($hrd as $rs_hrd) {
									echo '<option value="'.$rs_hrd->nama_ktp.'">'.$rs_hrd->nama_ktp.'</option>';
								}
							?>
						</select>
					</div>

							
						</div>
					</div>
					<div class="form-group col-md-12">
						<label>Keterangan</label>
						<textarea name="keterangan" class="form-control"></textarea>
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
<script type="text/javascript">
cutiData();
function cutiData(){
	var dt=$("#cuti").val();
	if (dt=="Ya") {
		$("#ct").attr("class","form-group col-md-3");
		$("#ktr").attr("hidden",false);
	} else {
		$("#ct").attr("class","form-group col-md-6");
		$("#ktr").attr("hidden",true);
	}
}
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
</script>
