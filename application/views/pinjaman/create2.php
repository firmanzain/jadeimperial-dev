<script src="<?=base_url()?>assets/scripts/jquery.min.js" type="text/javascript"></script>
<?php
function ambil_nama(){
  $nama='';
  $sql_nama=mysql_query("select * from tab_karyawan inner join tab_pinjaman on tab_pinjaman.nik=tab_karyawan.nik");
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
  sUrl="<?=base_url()?>Pinjaman/popup_karyawan2"; features = 'toolbar=no, left=350,top=100, ' + 
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
                url : "<?php echo base_url(); ?>Pinjaman/ajax_cari2",
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
                  $("#jabatan").html(tampil.jabatan);
                  $("#status").html(tampil.status_kerja);
                  $("#dep").html(tampil.department);
                  $("#nama").html(tampil.nama_ktp);
                  $("#pinjaman").html(toRp(tampil.jml_pinjam));
                  $("#sisa").html(toRp(tampil.sisa_pinjam));
                } else {
                  $("#flash").attr('hidden',false);
                  $("#flash").html('<div class="alert alert-warning">Data tidak ditemukan</div>')
                  $("#tabel_show").attr('hidden',true);
                  $("#isi").attr('hidden',true);
                }
                }
            });
        return false;    //<---- Add this line
      }
    });
  });
function toRp(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    //return 'Rp. ' + rev2.split('').reverse().join('') + ',00';
    return 'Rp. ' + rev2.split('').reverse().join('');
}
</script>
<form action="" name="form1" id="form1" method="post">
    <div class="col-md-12">
    	<h4>Halaman Input Pembayaran Pinjaman Karyawan</h4>
    	<hr>
    		<div class="row">
    					<div class="form-group col-md-12">
    						<input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK karyawan kemudian enter" style="display: inline; width: 80%;"/>
    						<input type="button" value="..." onclick="cariData()" class="btn btn-default" style="display: inline;" />
    						<input type="submit" value="Add Pembayaran" class="btn btn-info" id="add" disabled style="display: inline;" />
    					</div>
    		</div>
    </div>
    <div class="col-xs-12" id="show" hidden>
        <div id="flash"></div>
        <table class="table table-hover" id="tabel_show">
          <tr>
            <th width="15%">NIK</th>
            <td id="nik_tab" width="30%"></td>
            <th width="15%">Cabang</th>
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
            <td id="status"></td>
            <th>Department</th>
            <td id="dep"></td>
          </tr>
          <tr>
            <th>Pinjaman</th>
            <td id="pinjaman"></td>
            <th>Sisa Pinjaman</th>
            <td id="sisa"></td>
          </tr>
        </table>
        <div id="isi">
          <div class="form-group col-md-6" id="keterangan">
              <label>Jumlah Bayar</label>
              <input class="form-control" type="text" name="jml_bayar" id="jml_bayar" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
          </div>
          <div class="form-group col-md-6" id="keterangan">
              <label>Tanggal Bayar</label>
              <input type="text" name="tgl_bayar" id="date-picker2" value="<?=date('Y-m-d')?>" class="form-control" readonly/>
          </div>
          <div class="form-group col-md-12" id="keterangan">
              <label>Keterangan</label>
              <textarea class="form-control" rows="2" name="keterangan"></textarea>
          </div>
          <div class="form-group col-md-6" id="keterangan">
              <label>Manager</label>
              <select name="manager" class="form-control">
                <?php
                  foreach ($manager as $rt) {
                    echo "<option>$rt->nama_ktp</option>";
                  }
                ?>
              </select>
          </div>
          <div class="form-group col-md-6" id="keterangan">
              <label>HRD</label>
              <select name="hrd" class="form-control">
                <?php
                  foreach ($hrd as $rt) {
                    echo "<option>$rt->nama_ktp</option>";
                  }
                ?>
              </select>
          </div>
        </div>
    </div>
</form>
