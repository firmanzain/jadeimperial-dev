<h4>Halaman Update Master BPJS Karyawan</h4>
<hr>
<?php
// if ($data->id_bpjs == 1) {
// 	$hide1="hidden";
// 	$hide2="";
// } elseif ($data->id_bpjs == 2) {
// 	$hide1="";
// 	$hide2="hidden";
// }
?>
<div class="row">
	<div class="col-md-12">
	<form action="" method="post" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">BPJS</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="nama_bpjs" value="<?=$data->nama_bpjs?>" id="nama_bpjs" required/>
				<input type="hidden" class="form-control" name="id_bpjs" value="<?=$data->id_bpjs?>" id="id_bpjs" />
			</div>
			<label class="col-sm-2 control-label">Status BPJS</label>
			<div class="col-sm-4">
				<select class="form-control" name="status_bpjs" id="status_bpjs" required>
				  <option value="0" <?php echo ($data->status_bpjs == '0' ? 'selected="selected"' : '');?>> Tidak Aktif </option>
				  <option value="1" <?php echo ($data->status_bpjs == '1' ? 'selected="selected"' : '');?>> Aktif </option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Tanggal Potong</label>
			<div class="col-sm-4">
				<select class="form-control" name="tgl_bpjs" id="tgl_bpjs" required>
					<?php
						for ($i = 1; $i <= 31 ; $i++) { 
							echo '
							<option value="'.$i.'" '.($data->status_bpjs == $i ? 'selected="selected"' : '').'> '.$i.' </option>
							';
						}
					?>
					<option value="akhir" <?php echo ($data->status_bpjs == "akhir" ? 'selected="selected"' : '')?>> Akhir Bulan </option>
				</select>
			</div>
		</div>
		<hr>
		<div class="form-group">
			<label class="col-sm-12 control-label text-center">Potongan Potongan</label>
			<input type="hidden" class="form-control" id="jml_detail" name="jml_detail" value="<?=sizeof($datadetail)?>"/>
		</div>
		<hr>
		<div id="detailBPJS">
			<div id="detail1">
			<div class="form-group">
				<label class="col-sm-2 control-label">Potongan</label>
				<div class="col-sm-4">
					<input type="hidden" class="form-control" name="id_bpjs_detail[]" id="id_bpjs_detail1"/>
					<input type="text" class="form-control" name="nama_potongan[]" id="nama_potongan1" required/>
				</div>
				<label class="col-sm-2 control-label">Tujuan Potongan</label>
				<div class="col-sm-4">
					<select class="form-control" name="tujuan_potongan[]" id="tujuan_potongan1" required>
					  <option value="0"> Semua </option>
					  <option value="1"> Perusahaan </option>
					  <option value="2"> Karyawan </option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Nilai Potongan</label>
				<div class="col-sm-4">
					<div class="input-group">
						<input type="text" class="form-control" name="nilai_potongan[]" id="nilai_potongan1" required/>
						<div class="input-group-addon">%</div>
					</div>
					<p class="help-block">Jika desimal gunakan "." (titik) bukan "," (koma) </p>
				</div>
				<label class="col-sm-2 control-label">Status Potongan</label>
				<div class="col-sm-4">
					<select class="form-control" name="status_potongan[]" id="status_potongan1" required>
					  <option value="0"> Tidak Aktif </option>
					  <option value="1"> Aktif </option>
					</select>
				</div>
			</div>
			</div>
			<hr>
		</div>
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2 text-right">
				<button type="button" class="btn btn-primary" id="addDetail" onclick="window.addDetail()">Tambah Detail</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12 text-right">
				<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
				<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Cancel</button>
			</div>
		</div>
	</form>
	</div>
</div>
<script type="text/javascript">
	$( document ).ready(function() {
		itemDetail = parseInt($("#jml_detail").val());
		if (itemDetail == 0) {
			itemDetail = 1;
		}
		for (var i = 2; i <= itemDetail; i++) {
			generateDetail(i);
		}
		setTimeout(function(){ $('select').select2('destroy'); }, 1100);
		setTimeout(function(){ getDataDetail(parseInt($("#id_bpjs").val())); }, 1200);
	});

	function generateDetail(idx) {
		$("#detailBPJS").append('\
		<div id="detail'+idx+'">\
		<div class="form-group">\
			<label class="col-sm-2 control-label">Potongan</label>\
			<div class="col-sm-4">\
				<input type="hidden" class="form-control" name="id_bpjs_detail[]" id="id_bpjs_detail'+idx+'"/>\
				<input type="text" class="form-control" name="nama_potongan[]" id="nama_potongan'+idx+'" required/>\
			</div>\
			<label class="col-sm-2 control-label">Tujuan Potongan</label>\
			<div class="col-sm-4">\
				<select class="form-control" name="tujuan_potongan[]" id="tujuan_potongan'+idx+'" required>\
				  <option value="0"> Semua </option>\
				  <option value="1"> Perusahaan </option>\
				  <option value="2"> Karyawan </option>\
				</select>\
			</div>\
		</div>\
		<div class="form-group">\
			<label class="col-sm-2 control-label">Nilai Potongan</label>\
			<div class="col-sm-4">\
				<div class="input-group">\
					<input type="text" class="form-control" name="nilai_potongan[]" id="nilai_potongan'+idx+'" required/>\
					<div class="input-group-addon">%</div>\
				</div>\
				<p class="help-block">Jika desimal gunakan "." (titik) bukan "," (koma) </p>\
			</div>\
			<label class="col-sm-2 control-label">Status Potongan</label>\
			<div class="col-sm-4">\
				<select class="form-control" name="status_potongan[]" id="status_potongan'+idx+'" required>\
				  <option value="0"> Tidak Aktif </option>\
				  <option value="1"> Aktif </option>\
				</select>\
			</div>\
		</div>\
		<div class="form-group">\
			<div class="col-sm-10 col-sm-offset-2 text-right">\
				<button type="button" class="btn btn-danger" id="removeDetail'+idx+'" onclick="window.removeDetail('+idx+')">Hapus Detail</button>\
			</div>\
		</div>\
		</div>\
		<hr>\
		'
		);
		// setTimeout(function(){ $('select').select2(); }, 500);
	}

	function addDetail() {
		itemDetail++;
		$("#jml_detail").val(itemDetail);
		generateDetail(itemDetail);
	}

    function removeDetail(idx) {
        var parent = document.getElementById("detailBPJS");
        for (var i = 1; i <= itemDetail; i++) {
          if (i >= idx && i < itemDetail) {
            var inp1 = document.getElementById("nama_potongan"+(i+1)).value;
            var inp2 = document.getElementById("tujuan_potongan"+(i+1)).value;
            var inp3 = document.getElementById("nilai_potongan"+(i+1)).value;
            var inp4 = document.getElementById("status_potongan"+(i+1)).value;

            document.getElementById("nama_potongan"+i).value = inp1;
            document.getElementById("tujuan_potongan"+i).value = inp2;
            document.getElementById("nilai_potongan"+i).value = inp3;
            document.getElementById("status_potongan"+i).value = inp4;
          };
        };
        for (var i = 1; i <= itemDetail; i++) {
          if (i==itemDetail) {
            var child = document.getElementById("detail"+i);
            parent.removeChild(child);
          };
        };
        itemDetail--;
		$("#jml_detail").val(itemDetail);
    }

    function getDataDetail(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>BpjsController/getDataDetail/',
          data : { id : id },
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
            	document.getElementById("id_bpjs_detail"+(i+1)).value = data.val[i].id_bpjs_detail;
            	document.getElementById("nama_potongan"+(i+1)).value = data.val[i].nama_potongan;
            	document.getElementById("nilai_potongan"+(i+1)).value = data.val[i].nilai_potongan;
            	if (data.val[i].tujuan_potongan == 0) {
            		document.getElementById("tujuan_potongan"+(i+1)).selectedIndex = "0";
            	} else if (data.val[i].tujuan_potongan == 1) {
            		document.getElementById("tujuan_potongan"+(i+1)).selectedIndex = "1";
            	} else if (data.val[i].tujuan_potongan == 2) {
            		document.getElementById("tujuan_potongan"+(i+1)).selectedIndex = "2";
            	}
            	if (data.val[i].status_potongan == 0) {
            		document.getElementById("status_potongan"+(i+1)).selectedIndex = "0";
            	} else if (data.val[i].status_potongan == 1) {
            		document.getElementById("status_potongan"+(i+1)).selectedIndex = "1";
            	}
            	if ((i+1) > 1) {
            		document.getElementById("removeDetail"+(i+1)).disabled = true;
            	}
            }
          }
        });
    }

</script>