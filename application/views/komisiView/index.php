<div class="col-md-12">
    <h4>Data Komisi Karyawan <br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
    <hr>
        <form class="form-horizontal" id="form-periode" method="POST">
            <div class="form-group row">
              <label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
                <div class="col-sm-4">
              <div class="input-daterange input-group" id="date-picker1">
                  <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo $tgl1;?>" />
                  <span class="input-group-addon">s/d</span>
                  <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo $tgl2;?>" />
              </div>
                </div>
                <div class="col-sm-6 text-left">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
    <?=$this->session->flashdata('pesan');?>
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>komisi/hapus">
        <?php
            if($data==true){
                $no=1;

                foreach ($data as $tampil){
                    $this->table->add_row('
                        <input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_komisi.'>',
                        $no,
                        $tampil->nik,
                        $tampil->nama_ktp,
                        $tampil->jabatan,
                        $tampil->cabang,
                        $this->format->indo($tampil->omset),
                        $this->format->indo($tampil->komisi),
                        // $this->format->BulanIndo(date('m',strtotime('-1 month',strtotime($tampil->bulan)))));
                        $this->format->BulanIndo(date('m',strtotime($tampil->bulan))));

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
        <div class="form-group">
        <?=anchor('komisi/add','Add Komisi',['class' => 'btn btn-primary'])?>
        <button class="btn btn-danger" value="Hapus" name="tombol" onClick="return warning();">Hapus Data</button>
        </div>
      </form>
</div>