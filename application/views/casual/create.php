<script src="<?=base_url()?>assets/scripts/jquery.min.js" type="text/javascript"></script>
<?php
function ambil_nama(){
  $nama='';
  $sql_nama=mysql_query("select * from tab_karyawan a join tab_kontrak_kerja b on b.nik=a.nik where b.status_kerja like '%casual%' ");
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
  sUrl="<?=base_url()?>casualekstra/popup/karyawan"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=yes, resizable=no';
  window.open(sUrl,"winChild",features);
}
$(function() {
    $('#nik').keypress(function(e){
      if (e.which == 13) {
        var pm1=$('#nik').val();
        $("#show").attr('hidden',false);
        $.ajax({
                type: "POST",
                url : "<?php echo base_url(); ?>CasualEkstra/ajax_cari",
                data : "nik="+pm1+"",
                datatype : 'json',
                beforeSend: function(msg){$("#flash").html('<h4>Please wait...</h4>');},
                success: function(msg){
                if (msg != 'kosong') {
                  $("#flash").attr('hidden',true);
                  var tampil = JSON.parse(''+msg+'' );
                  $("#tabel_show").attr('hidden',false);
                  $("#isi").attr('hidden',false);
                  $("#rsg").attr('disabled',false);
                  $("#nik_tab").html(tampil.nik);
                  $("#cabang").html(tampil.cabang);
                  $("#tanggal_masuk").html(tampil.tanggal_masuk);
                  $("#tanggal_resign").html(tampil.tanggal_resign);
                  $("#jabatan").html(tampil.jabatan);
                  $("#status").html(tampil.status_kerja);
                  $("#dep").html(tampil.department);
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
      }
    });
  });
</script>
<form action="" name="form1" id="form1" method="post">
    <div class="col-md-12">
      <h4>Halaman Input Casual Karyawan</h4>
      <hr>
        <div class="row">
              <div class="form-group col-md-12">
                <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK karyawan kemudian enter" style="display: inline; width: 80%;"/>
                <input type="button" value="..." onclick="cariData()" class="btn btn-default" style="display: inline;" />
                <input type="submit" value="Add Ekstra" class="btn btn-info" id="rsg" disabled style="display: inline;" />
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
        </table>
        <div id="isi">
          <div class="form-group col-md-3" id="keterangan">
              <label>Jenis Ekstra</label>
              <select name="jns_ekstra" class="form-control">
                <option value="1">Jam</option>
                <option value="2">Hari</option>
              </select>
          </div>
          <div class="form-group col-md-3" id="keterangan">
              <label>Jumlah Ekstra</label>
              <input type="text" name="jml" class="form-control" max="15" />
          </div>
          <div class="form-group col-md-3" id="keterangan">
              <label>Kepala Department</label>
              <select name="kepala_department" class="form-control">
                <?php
                  $manager=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')->get('tab_karyawan a')->result();
                  foreach ($manager as $rt) {
                    echo "<option>$rt->nama_ktp</option>";
                  }
                ?>
              </select>
          </div>
          <div class="form-group col-md-3" id="keterangan">
              <label>HRD</label>
              <select name="hrd" class="form-control">
                <?php
                  $hrd=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')->where('b.fungsionalitas','HRD')->get('tab_karyawan a')->result();
                  foreach ($hrd as $rt) {
                    echo "<option>$rt->nama_ktp</option>";
                  }
                ?>
              </select>
          </div>
          <div class="form-group col-md-6">
            <label>Tanggal Ekstra</label>
            <input type="text" name="tgl_ekstra" value="<?=date('Y-m-d')?>" id="date-picker2" readonly class="form-control" />
          </div>
          <div class="form-group col-md-6" id="keterangan">
            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan ekstra casual" />
          </div>
        </div>
    </div>
</form>
