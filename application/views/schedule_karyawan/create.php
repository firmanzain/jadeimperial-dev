<h4>Halaman Input Schedule Karyawan</h4>
<hr>
<?=$this->session->flashdata('pesan')?>
<form class="form-inline" name="form1" id="formdata" method="post">
	<div class="row">
		<div class="form-group col-md-6">
	        <label>NIK</label><br>
	        <input type="number" name="nik" id="nik" class="form-control" style="display: inline; width: 90%;" required>
	        <button class="btn btn-default" id="cari" type="button" style="display: inline;">...</button>
	    </div>
		<div class="form-group col-md-12" style="margin-top: 10px;">
	        <div class="form-group m-r-20">
	            <label class="m-r-10">Bulan</label>
	            <select class="form-control" name="bulan" required>
	              	<?php
						for ($i=1; $i <=12 ; $i++) { 
							echo "<option value='$i'>".$this->format->BulanIndo($i)."</option>";
						}
	              	?>
	            </select>
	        </div>
	        <div class="form-group m-r-20">
	            <label class="m-r-10">Tahun</label>
	            <select class="form-control" name="tahun" required>
	          		<option selected><?=date("Y")?></option>
	              	<?php
	              		for ($i=2050; $i >= 2000 ; $i--) { 
	           			echo "<option>$i</option>";
	              		}
	              	?>
	            </select>
	        </div>
	        <button class="btn btn-info" type="submit" id="proses">Tampilkan</button>
	        <button class="btn btn-warning" type="button" onclick="window.history.go(-1); return false;" id="proses">Cancel</button>
		</div>
	</div>
</form>
<form id="form_akses" method="post">
<div class="row" style="margin-top: 20px;">
	<span class="col-md-12">
		<h4 id="karyawan"></h4>
	</span>
	<div class="col-md-6" id="data_form">
	
	</div>
	<div id="tombol"></div>
</div>	
</form>
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
			  'scrollbars=yes, resizable=no';
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
	                    if (msg != "Data Tidak Valid") {
					        $('#simpan').attr('disabled',false);
	                    } else {
					        $('#simpan').attr('disabled',true);
	                    }
	                }
	            });
	    });
	});
	$('#formdata').on('submit',function(e) {
		e.preventDefault();
		var str = $( "#formdata" ).serialize();
	        $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>ScheduleKaryawanController/show_tanggal",
            data :str,
        	beforeSend: function(msg){$('#proses').text('Please wait...');},
            success: function(msg){
                var js_msg=JSON.parse(''+msg+'');
                $('#karyawan').show(500);
				$('#data_form').show(500);
				$('#tombol').show(500);
                $('#data_form').html(js_msg.tabel);
                $('#karyawan').html(js_msg.karyawan);
                $('#tombol').html(js_msg.tombol);
                $('#proses').text('Tampilkan');
            }
        });
	});
		
	aksiClose();
	function saveData() {
		var str = $( "#form_akses" ).serialize();
        $.ajax({
                type: "POST",
                url : "<?php echo base_url(); ?>ScheduleKaryawanController/save",
                data :str,
            	beforeSend: function(msg){$('#simpan').text('Please wait...');},
                success: function(msg){
                	if (msg==1) {
                		window.location.assign("<?=base_url()?>shedule-karyawan");
                	}
                }
            });
	}
	function aksiClose() {
		$('#karyawan').hide(500);
		$('#data_form').hide(500);
		$('#tombol').hide(500);
	}
</script>
