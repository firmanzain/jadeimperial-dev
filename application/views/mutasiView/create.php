<form name="form1" id="form1" method="post">
    <div class="col-md-12">
    	<h4>Halaman Mutasi Karyawan</h4>
    	<hr>
		<div class="row">
			<div class="form-group col-md-12">
				<input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK karyawan kemudian enter" style="display: inline; width: 80%;"/>
				<input type="button" value="..." onclick="cariData()" class="btn btn-default" style="display: inline;" />
				<input type="submit" value="Add" class="btn btn-info" id="add" disabled style="display: inline;" />
			</div>
		</div>
    </div>
    <div class="col-xs-12" id="show" hidden>
        <div id="flash"></div>
        	<input type="hidden" name="jabatan1" id="jabatan1">
        	<input type="hidden" name="department1" id="department1">
        	<input type="hidden" name="cabang1" id="cabang1">
	        <table class="table table-hover" id="tabel_show">
	          <tr>
	            <th width="15%">NIK</th>
	            <td id="nik_tab" width="30%"></td>
	            <th width="15%">PLANT</th>
	            <td id="cabang"></td>
	          </tr>
	          <tr>
	            <th>Nama</th>
	            <td id="nama"></td>
	            <th>Jabatan</th>
	            <td id="jabatan"></td>
	          </tr>
	          <tr>
	            <th>Status Kerja</th>
	            <td id="st"></td>
	            <th>Department</th>
	            <td id="dp"></td>
	          </tr>
	        </table>
        <div id="isi">
	        <div class="form-group col-md-4" id="keterangan">
	         	<label>Tanggal Berlaku</label>
		        <div class="input-group date" id="date-picker2">
                    <input type="text" name="tanggal_per" class="form-control" required>
                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                </div>
	        </div>
	        <div class="form-group col-md-4" id="keterangan">
	          <label>Plant Baru</label>
	          <select id="cabang2" name="cabang2" class="form-control" required>
	          	<?php
	          		foreach ($cabang as $rs_cab) {
	          			echo "<option value='$rs_cab->id_cabang'>$rs_cab->cabang</option>";
	          		}
	          	?>
	          </select>
	        </div>
	        <div class="form-group col-md-4" id="keterangan">
	          <label>Department Baru</label>
	          <select id="department" name="department2" class="form-control" required>
	          	<?php
	          		foreach ($departmen as $rs_dept) {
	          			echo "<option value='$rs_dept->id_department'>$rs_dept->department</option>";
	          		}
	          	?>
	          </select>
	        </div>
	        <div class="col-md-12">
	        	<div class="row">
	        		<div class="form-group col-md-4" id="keterangan">
			          <label>Jabatan Baru</label>
			          <select id="jabatan" name="jabatan2" class="form-control" required>
			          	<?php
			          		foreach ($jabatan as $rs_jab) {
			          			echo "<option value='$rs_jab->id_jabatan'>$rs_jab->jabatan</option>";
			          		}
			          	?>
			          </select>
			        </div>
	        		<div class="form-group col-md-4" id="keterangan">
			        	<label>HRD</label>
			        	<select name="hrd" class="form-control" required>
			            <?php
			                foreach ($hrd as $rs) {
			                  echo "<option>$rs->nama_ktp</option>";
			                }
			            ?>
			        	</select>
			        </div>
			        <div class="form-group col-md-4" id="keterangan">
			        	<label>Manager</label>
			        	<select name="manager" class="form-control" required>
			            <?php
			                foreach ($hrd as $rs) {
			                  echo "<option>$rs->nama_ktp</option>";
			                }
			            ?>
			        	</select>
			        </div>
	        	</div>
	        </div>
        </div>
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
<script>
  $(function() {
    var DaftarNama = [<?php echo ambil_nama();?> ];
    $( "#nik" ).autocomplete({
      source: DaftarNama
    });
  });
function cariData() {
  sUrl="<?=base_url()?>resign/popup/karyawan"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=yes, resizable=no';
  window.open(sUrl,"winChild",features);
}
$(function() {
    $('#nik').keyup(function(e){
        var pm1=$('#nik').val();
        $("#show").attr('hidden',false);
        $.ajax({
                type: "POST",
                url : "<?php echo base_url(); ?>ResignController/ajax_cari",
                data : "nik="+pm1+"",
                datatype : 'json',
                beforeSend: function(msg){$("#flash").html('<h4>Please wait...</h4>');},
                success: function(msg){
                if (msg != 'kosong') {
                  $("#flash").attr('hidden',true);
                  var tampil = JSON.parse(''+msg+'' );
                  $("#tabel_show").attr('hidden',false);
                  $("#isi").attr('hidden',false);
                  $("#add").attr('disabled',false);
                  $("#nik_tab").html(tampil.nik);
                  $("#cabang").html(tampil.cabang);
                  $("#st").html(tampil.status_kerja);
                  $("#jabatan1").val(tampil.jabatan);
                  $("#department1").val(tampil.department);
                  $("#cabang1").val(tampil.cabang);
                  $("#dp").html(tampil.department);
                  $("#jabatan").html(tampil.jabatan);
                  $("#nama").html(tampil.nama_ktp);
                } else {
                  $("#flash").attr('hidden',false);
                  $("#flash").html('<div class="alert alert-warning">Data tidak ditemukan</div>')
                  $("#tabel_show").attr('hidden',true);
                  $("#isi").attr('hidden',true);
                }
                }
            });
        return false;    //<---- Add this line
    });
  });
$('#form1').on('submit',function(e) {
		e.preventDefault();
		var str = $( "#form1" ).serialize();
	        $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>MutasiController/create",
            data :str,
        	beforeSend: function(msg){$('#add').text('Please wait...');},
            success: function(msg){
                if (msg==1) {
            		window.location.assign("<?=base_url()?>MutasiController");
            	} else {
            		alert("Gagal input data, cek data resign karyawan");
            		$('#add').val('Add');
            	}
            }
        });
	});
</script>