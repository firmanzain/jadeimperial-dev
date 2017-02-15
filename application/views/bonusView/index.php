<div class="col-md-12">
    <h3>Data Bonus Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
    <hr>
      <form class="form-horizontal" id="form-periode" method="POST">
          <div class="form-group row">
            <label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
              <div class="col-sm-4">
                <select class="form-control" name="bln">
                  <option value="<?=$bln?>"><?=$this->format->BulanIndo($bln)?></option>
                  <?php 
                  $arr_bln = "Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember";
                  // explode is used to explode string into array based on the delimiter
                  $bln1 = explode(",", $arr_bln);
                  for ($i=1; $i <=12 ; $i++) {
                    echo '<option value="'.$i.'">'.$bln1[$i-1].'</option>'; 
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-4">
                <select class="form-control" name="tahun">
                    <option value="<?=date("Y")?>" selected><?=date("Y")?></option>
                  <?php
                    for ($i=2050; $i >= 2000 ; $i--) { 
                      echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="col-sm-2 text-left">
                  <button type="submit" class="btn btn-primary">Filter</button>
              </div>
          </div>
      </form>
      <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>bonus/hapus">
      <div class="table-responsive" style="overflow: scroll;">
      
        <?php
        if($data==true){
            $no=1;

            foreach ($data as $tampil){
              // first execution
              $jml_karyawan=$this->db->where('cabang',$tampil->id_cabang)->get('tab_karyawan')->num_rows();
              if ($tampil->approved!="Belum") {
                $del = true;
              } else {
                $del = false;
              }

              // second execution
              $this->table->add_row($no,$tampil->nama_cabang,$jml_karyawan,$this->format->indo($tampil->omset),$this->format->indo($tampil->bruto),$this->format->indo(($tampil->bruto*$tampil->prosen_mpd)/100),$this->format->indo(($tampil->bruto*$tampil->prosen_lb)/100),$this->format->indo($tampil->bonus_prosen),$this->format->indo($tampil->bonus_nominal),$this->format->indo($tampil->bonus_pure),$this->format->indo($tampil->bonus_point),$this->format->indo($tampil->bonus_prorata),$tampil->approved,$tampil->keterangan,
                '<a href="'.base_url('bonus/'.$tampil->id_cabang.'/'.$bln.'/'.$thn.'/detail').'">
                <span class="label label-warning">Detail</span>
                </a><a href="'.base_url('bonus/'.$tampil->id_cabang.'/'.$bln.'/'.$thn.'/delete').'">
                <span class="label label-danger">Delete</span>
                </a>');

              // third execution
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

      </div>
      <div class="panel-footer">
       <?=anchor('bonus/add','Tambah Data',['class' => 'btn btn-primary'])?>
      </form>
    </div>
</div>