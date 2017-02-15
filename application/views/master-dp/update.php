<div class="col-md-12">
	<h4>Halaman Update Master DP Karyawan</h4>
	<hr>
		<div class="row">
			<form action="" method="post">
					<input type="hidden" name="id" value="<?=$data->id?>">
					<input type="hidden" name="saldo_cutiLama" value="<?=$data->saldo_cuti?>">
					<input type="hidden" name="saldo_dpLama" value="<?=$data->saldo_dp?>">
					<div class="form-group col-md-12">
						<label>NIK</label><br>
						<input type="text" class="form-control" name="nik" id="nik" value="<?=$data->nik?>" style="width: 30%; display: inline;" required/>
						<button class="btn btn-default" type="button" id="cari">...</button>
						<div class="label label-info" id="show" style="display: inline;" hidden></div>
					</div>
					<div class="form-group col-md-6">
						<label>Bulan</label>
						<select name="bulan" class="form-control">
							<option selected><?=date('F',strtotime($data->bulan))?></option>
							<?php
								$nama_bln= "bln January February March April May June July August September October November December";
								$arr_bulan=explode(" ", $nama_bln);
								for ($i=1; $i <=12 ; $i++) { 
									echo "<option>$arr_bulan[$i]</option>";
								}
			              	?>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label>Tahun</label>
						<select class="form-control" name="tahun">
			              		<option selected><?=$data->tahun?></option>
				              	<?php
				              		for ($i=2050; $i >= 2000 ; $i--) { 
				              			echo "<option>$i</option>";
				              		}
				              	?>
			            </select>
					</div>
					<div class="form-group col-md-6">
						<label>Jumlah DP Bulanan</label>
						<input type="number" name="saldo_dp" value="<?=$data->saldo_dp?>" class="form-control">
					</div>
					<div class="form-group col-md-6">
						<label>Jumlah Cuti Tahunan</label>
						<input type="number" value="<?=$data->saldo_cuti?>" name="saldo_cuti" class="form-control">
					</div>
					<div class="form-group col-md-6">
						<label>Keterangan</label>
						<input type="text" name="keterangan" value="<?=$data->keterangan?>" class="form-control">
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
cutiData();
function cutiData(){
	var dt=$("#cuti").val();
	if (dt=="Ya") {
		$("#ct").attr("class","form-group col-md-6");
		$("#ktr").attr("hidden",false);
	} else {
		$("#ct").attr("class","form-group col-md-12");
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
