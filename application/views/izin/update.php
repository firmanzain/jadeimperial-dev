<div class="col-md-12">
	<h4>Halaman Update Perizinan Karyawan</h4>
	<hr>
		<div class="row">
		<?=$this->session->flashdata('pesan');?>
			<form action="" method="post" enctype="multipart/form-data">
					<div class="form-group col-md-12">
						<label>NIK</label><br>
						<input type="text" class="form-control" name="nik" id="nik" value="<?=$data->nik?>" style="width: 30%; display: inline;" required></input>
						<input type="hidden" name="id" value="<?=$data->id?>">
						<input type="hidden" name="potongan_lama" value="<?=$data->potong_dp?>">
						<button class="btn btn-default" type="button" id="cari" style="display: inline;">...</button>
						<div class="label label-default" style="display: inline;" hidden id="show"></div>
					</div>
					<div class="form-group col-md-6">
						<label>Jenis Izin</label>
						<select name="jenis" class="form-control" onchange="jq_jenis()" id="jenis" required>
							<option selected><?=$data->jenis_izin?></option>
							<option>Datang Pukul</option>
							<option>Pulang Pukul</option>
							<option>Tidak Dapat Masuk</option>
						</select>
					</div>
					<div class="form-group col-md-6" id="upload">
						<label id="lbl">xxx</label>
						<div id="detail"></div>
						<input type="hidden" name="lamp" value="<?=$data->lampiran?>">
					</div>
					<div class="form-group col-md-6" id="tgl0" hidden>
						<label>Tanggal</label>
						<div class="input-group date">
	                        <input type="text" name="tanggal0" value="<?=$data->tanggal_mulai?>" class="form-control" readonly>
	                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
	                    </div>
					</div>
					<div class="form-group col-md-6" id="tgl" hidden>
						<label>Mulai Tanggal</label>
						<div class="input-group date">
	                        <input type="text" name="tanggal1" value="<?=$data->tanggal_mulai?>" class="form-control" readonly>
	                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
	                    </div>
					</div>
					<div class="form-group col-md-6" id="tgl2" hidden>
						<label>Sampai</label>
						<div class="input-group date">
	                        <input type="text" name="tanggal2" value="<?=$data->tanggal_finish?>" class="form-control" readonly>
	                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
	                    </div>
					</div>
					<div class="form-group col-md-12" id="dp">
						<label>Potongan DP</label>
						<input name="potongan" class="form-control" value="<?=$data->potong_dp?>">
						<p class="help-block">Diisi angka jika desimal koma berupa titik(.)</p>
					</div>



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



					<div class="form-group col-md-12">
						<label>Alasan</label>
						<textarea name="alasan" class="form-control" rows="3" required><?=$data->alasan?></textarea>
					</div>
					<div class="form-group col-md-12">
						<label class="c-input c-checkbox">
							<?php 
								if ($data->id_potong==1) {
									$status = "checked";
								} else {
									$status = "";
								}
							?>
				            <input type="checkbox" name="cek" value="1" <?=$status?>> <span class="c-indicator c-indicator-warning"></span><span class="c-input-text"> Potong DP </span> 
				    	</label>
					</div>
					<div class="form-group col-md-12">
						<button type="submit" class="btn btn-primary" name="submit" id="simpan">Simpan</button>
						<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Cancel</button>
					</div>
			</form>
		</div>
</div>
<script src="<?=base_url()?>assets/scripts/jquery.min.js" type="text/javascript"></script>
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
jq_jenis();
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
	function jq_jenis() {
		var jns=$('#jenis').val();
		if (jns=='Datang Pukul') {
			$('#tgl0').attr('hidden',false);
			$('#tgl').attr('hidden',true);
			$('#tgl2').attr('hidden',true);
			$('#upload').attr('hidden',false);
			$('#dp').attr('hidden',false);
			$('#lbl').html("Datang Pukul");
			/*var pukul = document.createElement("input");
			pukul.type="time";
			pukul.name="pukul";
			pukul.id="pukul";*/
			pukul_value = "<?php echo @$data->pukul;?>";
			pukul = '<input id="pukul" class="form-control" type="time" name="pukul" data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true" maxlength="8" autocomplete="off" value="'+pukul_value+'">';
			$('#detail').html(pukul);
			/*document.getElementById('pukul').setAttribute('class','form-control');
			document.getElementById('pukul').setAttribute('data-mask','00:00:00');
			document.getElementById('pukul').setAttribute('data-mask-reverse',true);
			document.getElementById('pukul').setAttribute('data-mask-maxlength',true);
			pukul.focus();*/
		} else if (jns=='Pulang Pukul') {
			$('#tgl0').attr('hidden',false);
			$('#tgl').attr('hidden',true);
			$('#upload').attr('hidden',false);
			$('#tgl2').attr('hidden',true);
			$('#dp').attr('hidden',false);
			$('#lbl').html("Pulang Pukul");
			/*var pukul= document.createElement("input");
			pukul.type="text";
			pukul.name="pukul";
			pukul.id="pukul";*/
			pukul_value = "<?php echo @$data->pukul;?>";
			pukul = '<input id="pukul" class="form-control" type="time" name="pukul" data-mask="00:00:00" data-mask-reverse="true" data-mask-maxlength="true" maxlength="8" autocomplete="off" value="'+pukul_value+'">';
			$('#detail').html(pukul);
			/*document.getElementById('pukul').setAttribute('class','form-control');
			document.getElementById('pukul').setAttribute('data-mask','00:00:00');
			document.getElementById('pukul').setAttribute('data-mask-reverse',true);
			document.getElementById('pukul').setAttribute('data-mask-maxlength',true);
			pukul.focus();*/
		} else if (jns=='Tidak Dapat Masuk') {
			$('#tgl').attr('hidden',false);
			$('#tgl2').attr('hidden',false);
			$('#tgl').attr('required',true);
			$('#tgl2').attr('required',true);
			$('#upload').attr('hidden',false);
			$('#dp').attr('hidden',true);
			$('#lbl').html("Upload Lampiran Surat Izin");
			var pukul= document.createElement("input");
			pukul.type="file";
			pukul.name="lampiran";
			pukul.id="lampiran";
			pukul.placeholder="Lampirkan surat izin";
			$('#detail').html(pukul);
			document.getElementById('lampiran').setAttribute('class','form-control');
			lampiran.focus();
		}
	}
</script>
