<div class="col-md-12">
		<h3>Master T3 Karyawan</h3>
		<hr>
    <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>T3Controller/aksi">
        <?php
           if($data==true){ // jika data diketemukan
              
              $no=1;
              
              foreach ($data as $tampil){
                $this->table->add_row('
                  <input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_t3.'>',// in array
                  $no,
                  $tampil->nama_ktp,
                  $tampil->jabatan,
                  $tampil->cabang,
                  $this->format->indo($tampil->tarif));
                  $no++;
              }

              $tabel=$this->table->generate();

              echo $tabel;
           }

           else 
           {
              echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
           }
        ?>
        <div class="panel-footer">
           <?=anchor('T3Controller/create','Tambah Data',['class' => 'btn btn-primary'])?>

            <button class="btn btn-default" name="tombol" value="edit"> Update Selected Data</button>
            
            <button class="btn btn-danger" name="tombol" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button>
        </form>
        </div>
</div>