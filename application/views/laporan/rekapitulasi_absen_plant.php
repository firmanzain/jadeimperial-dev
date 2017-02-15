    
<div class="col-sm-12">
  <h4>Rekapitulasi Absensi Karyawan <?=$cabang?></h4>
    <hr>
      <?=$this->session->flashdata('pesan');?>
          <form method="post" action="<?=base_url('Laporan/ex_absensi_plant')?>" target="new">
            <!--<input type="hidden" name="bln" value="<?=$bln?>">
            <input type="hidden" name="thn" value="<?=$thn?>">-->
            <input type="hidden" name="cabang" value="<?=$cabang_id?>">
            <div class="table-responsive" style="overflow:scroll;">
            <?php
                $this->table->set_heading(array('No','NIK','Nama Employee','Jabatan','Departemen','Tindakan'));
                $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                  'thead_open'=>'<thead>',
                  'thead_close'=> '</thead>',
                  'tbody_open'=> '<tbody>',
                  'tbody_close'=> '</tbody>',
                );
                $this->table->set_template($tmp);

                $no=1;
                foreach ($data as $tampil) {
                  //$this->table->add_row($no,$tampil->field1,$tampil->field2,$tampil->field3,$tampil->field4,anchor('cetak/'.$bln.'/'.$thn.'/'.$cabang.'/'.$tampil->field1.'/detail-absensi-karyawan','<span class="label label-warning">Lihat Detail</span>'));
                  $this->table->add_row($no,$tampil->field1,$tampil->field2,$tampil->field3,$tampil->field4,anchor('cetak/'.$cabang.'/'.$tampil->field1.'/detail-absensi-karyawan','<span class="label label-warning">Lihat Detail</span>'));
                  $no++;
                }
                $tabel=$this->table->generate();
                echo $tabel;
            ?>
      </div>
      <div class="form-group">
        <button onclick="window.history.go(-1); return false;" class="btn btn-warning" type="button">Kembali</button>
        <button type="submit" class="btn btn-success">Export Excel</button>
      </div>
          </form>
    </div>
<script type="text/javascript">
</script>

