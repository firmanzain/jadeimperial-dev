<h4>Data jadwal kerja</h4>
<hr>
<?=$this->session->flashdata('pesan');?>
<div class="panel panel-default">
    <div class="panel-body">
          <form name="form_data" method="post" id="form_data" action="<?=base_url()?>jadwal/hapus">
            <div class="table-responsive" id="show">
              <?php
                 if($data==true){
                  $no=1;
                  foreach ($data as $tampil){
                  $this->table->add_row(/*'<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>',*/$no,$tampil->kode_jam,$tampil->jam_start.' - '.$tampil->jam_finish,$tampil->jam_start2.' - '.$tampil->jam_finish2,$tampil->keterangan,$tampil->departmen,$tampil->dispensasi.' Menit',$tampil->lama.' Jam',anchor('jadwal/'.$tampil->id.'/edit','<span class="label label-warning">Edit</span>'));
                  $no++;
                  }
                  $tabel=$this->table->generate();
                  echo $tabel;
                 }else {
                    echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
                 }
              ?>
            </div>
    </div>
    <div class="panel-footer">
        <?=anchor('jadwal/add','Tambah Data',['class' => 'btn btn-primary'])?>
        <!--<button class="btn btn-info" type="button" id="impor" onclick="importData()">Import Data</button>-->
        <!--<button class="btn btn-danger delete" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button> -->
    </form>
  </div>
</div>
<script type="text/javascript">
  function importData() {
  sUrl="<?=base_url()?>jadwal/import"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
};
</script>