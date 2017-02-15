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
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
$(function() {
    $('#nik').keypress(function(e){
      if (e.which == 13) {
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
                  $("#sp_karyawan").attr('hidden',false);
                  $("#rsg").attr('disabled',false);
                  $("#nik_tab").html(tampil.nik);
                  $("#cabang").html(tampil.cabang);
                  $("#tanggal_masuk").html(tampil.tanggal_masuk);
                  $("#tanggal_resign").html(tampil.tanggal_resign);
                  $("#jabatan").html(tampil.jabatan);
                  $("#nama").html(tampil.nama_ktp);
                } else {
                  $("#flash").attr('hidden',false);
                  $("#flash").html('<div class="alert alert-warning">Data tidak ditemukan</div>')
                  $("#tabel_show").attr('hidden',true);
                  $("#sp_karyawan").attr('hidden',true);
                }
                }
            });
        return false;    //<---- Add this line
      }
    });
  });
</script>
<form action="" name="form1" id="form1" method="post">
    <div class="col-md-12">
    	<h4>Halaman Pemberian SP Karyawan</h4>
    	<hr>
    		<div class="row">
    					<div class="form-group col-md-12">
    						<input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK karyawan kemudian enter" style="display: inline; width: 80%;"/>
    						<input type="button" value="..." onclick="cariData()" class="btn btn-default" style="display: inline;" />
    						<input type="submit" value="Add SP" class="btn btn-info" id="rsg" disabled style="display: inline;" />
    					</div>
    		</div>
    </div>
    <div class="col-xs-12" id="show" hidden>
        <div id="flash"></div>
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
            <th>Tanggal Masuk</th>
            <td id="tanggal_masuk"></td>
            <th>Tanggal Resign</th>
            <td id="tanggal_resign"></td>
          </tr>
        </table>
        <div id="sp_karyawan" hidden>
          <div class="form-group col-md-4">
            <label>NO</label>
            <input type="text" name="no_sp" class="form-control" value="<?=$no_sp?>">
          </div>
          <div class="form-group col-md-4">
              <label>Tanggal Mulai SP</label>
              <div class="input-group date" id="date-picker1">
                  <input type="text" name="tanggal_sp" class="form-control" readonly value="<?=date('Y-m-d')?>" >
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
              </div>
          </div>
          <div class="form-group col-md-4">
              <label>Tanggal Selesai SP</label>
              <div class="input-group date" id="date-picker2">
                  <input type="text" name="tanggal_sp_selesai" class="form-control" readonly value="<?=date('Y-m-d')?>" >
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
              </div>
          </div>
        <div class="form-group col-md-4">
            <label>Jenis SP</label>
            <select name="jenis_sp" class="form-control">
              <option>SP1</option>
              <option>SP2</option>
              <option>SP3</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Sanksi</label>
            <input type="text" name="sanksi" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label>Terima Bonus</label><br>
            <label class="c-input c-checkbox">
                <input type="checkbox" name="terima_bonus" value="1">
                  <span class="c-indicator c-indicator-warning"></span>
                  <span class="c-input-text"> Tidak </span> 
            </label><br><br>
        </div>
        <div class="form-group col-md-4">
            <label>Pemeriksa</label>
            <select name="pemeriksa" class="form-control">
                <?php
                  foreach ($pemeriksa as $rs) {
                    echo "<option value='$rs->nik'>$rs->nama_ktp</option>";
                  }
                ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Pemohon</label>
            <select name="pemohon" class="form-control">
                <?php
                  foreach ($pemeriksa as $rs) {
                    echo "<option>$rs->nama_ktp</option>";
                  }
                ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Saksi</label>
            <select name="saksi" class="form-control">
                <?php
                  foreach ($pemeriksa as $rs) {
                    echo "<option>$rs->nama_ktp</option>";
                  }
                ?>
            </select>
        </div>

        <div class="form-group col-md-12">
          <label>Keterangan SP</label>
          <textarea name="keterangan" class="form-control" rows="4" requried></textarea>
        </div>


        </div>
    </div>
</form>