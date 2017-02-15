<h4>Master Cuti Khusus</h4>
<hr>
<?=$this->session->flashdata('pesan');?>
<div class="panel panel-default">
    <div class="panel-body">
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>cuti-khusus/hapus">
          <?php
               if($data==true){
                $no=1;
                foreach ($data as $tampil){

                $tanggal_input1 = $tampil->entry_date;
                $tanggal_input2 = substr($tanggal_input1, 0, 10);


                $this->table->add_row(/*'<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>',*/$no,$tampil->keterangan,$tampil->maximal_lama.' Hari', $tanggal_input2,$tampil->status,anchor('cuti-khusus/'.$tampil->id.'/edit','<span class="label label-warning">Edit</span>'));
                $no++;
                }
                $tabel=$this->table->generate();
                echo $tabel;
               }else {
                  echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
               }
          ?>
    </div>
    <div class="panel-footer">
         <?=anchor('cuti-khusus/add','Tambah Data',['class' => 'btn btn-primary'])?>
        <!--<button class="btn btn-info" type="button" onClick="importData()">Import Data</button>-->
         <!--<button class="btn btn-danger delete" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button> -->
         </form>
    </div>
</div>
<script>
function importData() {
  sUrl="<?=base_url()?>cuti-khusus/import"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>