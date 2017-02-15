<div class="col-md-12">
	<h4>Proses Pindah Jam Kerja Karyawan</h4>
	<hr>
	<div class="row">
		<form name="form1" id="form1" method="post">
      <div class="col-xs-12" style="margin-bottom: 20px;">
            <div class="col-sm-12">
                <div id="form-filter">
                    <!--<form class="form-inline" name="formPrint" method="post" action="">-->
                        <div class="form-group m-r-20">
                            <label class="m-r-10">Bulan</label>

                            <select class="form-control" name="bln">
                              <?php 
                                $arr_bln = "Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember";
                                // explode is used to explode string into array based on the delimiter
                                $bln1 = explode(",", $arr_bln);
                                for ($i=1; $i <=12 ; $i++) {
                                  echo '<option value="'.$i.'">'.$bln1[$i-1].'</option>'; 
                                }
                              ?>
                            </select>


                            <label class="m-r-10">Tahun</label>
                            <select class="form-control" name="tahun">
                                <option value="<?=date("Y")?>" selected><?=date("Y")?></option>
                              <?php
                                for ($i=2050; $i >= 2000 ; $i--) { 
                                  echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                              ?>
                            </select>
                            <br>
                            <!--<button class="btn btn-primary" id="ft-data">View Data</button>-->
							<label>NIK</label><br>
							<input type="text" class="form-control" name="nik" id="nik" style="width: 30%; display: inline;" placeholder="Masukkan NIK Karyawan" required/>
							<button class="btn btn-default" type="button" id="cari">...</button>
							<button class="btn btn-danger" type="submit" id="tampil">Tampilkan</button>
							<div class="label label-info" id="show" style="display: inline;" hidden></div>
                        </div>
                    <!--</form>-->
                </div> <!--/#form-filter-->
            </div> <!--/.col-sm-11-->
        </div> <!--/.col-xs-12-->
			<!--<div class="form-group col-md-12">
				<label>NIK</label><br>
				<input type="text" class="form-control" name="nik" id="nik" style="width: 30%; display: inline;" placeholder="Masukkan NIK Karyawan" required/>
				<button class="btn btn-default" type="button" id="cari">...</button>
				<button class="btn btn-danger" type="submit" id="tampil">Tampilkan</button>
				<div class="label label-info" id="show" style="display: inline;" hidden></div>
			</div>-->
		</form>
	</div>
	<div id="metu">
		<form id="form_akses" method="post">
			<div class="row" style="margin-top: 20px;">
				<span class="col-md-12">
					<h4 id="karyawan"></h4>
				</span>
				<div class="col-md-10" id="data_form">
				
				</div>
				<div id="tombol"></div>
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
	$('#form1').on('submit',function(e) {
		e.preventDefault();
		var str = $( "#form1" ).serialize();
	        $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>PindahJamController/show_data",
            data :str,
        	beforeSend: function(msg){$('#tampil').text('Please wait...');},
            success: function(msg){
                if (msg!=0) {
                	var js_msg=JSON.parse(''+msg+'');
	                $('#metu').slideDown("slow" );
	                $('#data_form').html(js_msg.tabel);
	                $('#karyawan').html(js_msg.karyawan);
	                $('#tombol').html(js_msg.tombol);
	                $('#tampil').text('Tampilkan');
                }else{
	                $('#metu').slideDown("slow" );
	                $('#data_form').html("<div class='alert alert-danger'>Data Tidak Ditemukan</div>");
	                $('#tampil').text('Tampilkan');
                }
            }
        });
	});
	aksiClose();
	function saveData() {
		var str = $( "#form_akses" ).serialize();
        $.ajax({
                type: "POST",
                url : "<?php echo base_url(); ?>PindahJamController/save",
                data :str,
            	beforeSend: function(msg){$('#simpan').text('Please wait...');},
                success: function(msg){
                	if (msg==1) {
                		 window.location.assign("<?=base_url()?>pindah_jam");
                	} else {
                		alert("Terdapat duplicat data");
                		$('#simpan').text('Simpan');
                	}
                }
            });
	}
	function aksiClose() {
	    $('#metu').slideUp("slow" );
	}	
</script>