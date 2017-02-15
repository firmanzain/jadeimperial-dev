<h4>Master BPJS Karyawan</h4>
<hr>
<?=$this->session->flashdata('pesan');?>
<div class="panel panel-default">
    <div class="panel-body">

        <div class="table-responsive">
          <?php
               if($data==true){
                $no=1;
                foreach ($data as $tampil){
                // if ($tampil->jkk==0) $jkk="";else $jkk=$tampil->jkk.'%';
                // if ($tampil->jht_1==0) $jht1=""; else $jht1=$tampil->jht_1.'%';
                // if ($tampil->jht_2==0) $jht2=""; else $jht2=$tampil->jht_2.'%';
                // if ($tampil->jkm==0) $jkm=""; else $jkm=$tampil->jkm.'%';
                // if ($tampil->jpk_1==0) $jpk1=""; else $jpk1=$tampil->jpk_1.'%';
                // if ($tampil->jpk_2==0) $jpk2=""; else $jpk2=$tampil->jpk_2.'%';
                // if ($tampil->potongan2==0) $p2=""; else $p2=$tampil->potongan2.'%';
                // if ($tampil->potongan1==0) $p1=""; else $p1=$tampil->potongan1.'%';
                if ($tampil->status_bpjs == 1) {
                  $status_bpjs = 'Aktif';
                } else {
                  $status_bpjs = 'Tidak Aktif';
                }

                $this->table->add_row($no,$tampil->nama_bpjs,$status_bpjs,anchor('bpjs/'.$tampil->id_bpjs.'/edit','<span class="label label-warning">Edit</span>'));
                $no++;
                }
                $tabel=$this->table->generate();
                echo $tabel;
               }else {
                  echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
               }
          ?>
          </div>
          <div class="form-group">
              <?=anchor('bpjs/add','Tambah Data',['class' => 'btn btn-primary'])?>
          </div>
    </div>
</div>
<script>
function importData() {
  sUrl="<?=base_url()?>bpjs/import"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>