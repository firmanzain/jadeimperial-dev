<h4>Data jadwal liburan kerja</h4>
<hr>
<?=$this->session->flashdata('pesan');?>
<div class="panel panel-default">
    <div class="panel-body">
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>liburan/hapus">
          <?php
               if($data==true){
                $no=1;
                foreach ($data as $tampil){

                    $tanggal_input1 = $tampil->entry_date;
                    $tanggal_input2 = substr($tanggal_input1, 0, 10);

                $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id.'>',$no,$this->format->TanggalIndo($tampil->tanggal_mulai).' s/d '.$this->format->TanggalIndo($tampil->tanggal_selesai),$this->format->hari($tampil->tanggal_mulai).' s/d '.$this->format->hari($tampil->tanggal_selesai),$tampil->keterangan,$tampil->cuti_khusus,$tampil->lama.' hari',$tanggal_input2,anchor('liburan/'.$tampil->id.'/edit','<span class="label label-warning">Edit</span>'));
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
         <?=anchor('liburan/add','Tambah Data',['class' => 'btn btn-primary'])?>
          <!--<button class="btn btn-info" type="button" onClick="importData()">Import Data</button>-->
          <button class="btn btn-danger" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button>
          <button type="button" class="btn btn-primary" value="Generate DP" data-toggle="modal" data-target="#myModal">Generate DP</button>
        </form>
    </div>
</div>

      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <!--<h4 class="modal-title" id="myModalLabel"><span>Add New</span> Data Anggota</h4>-->
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="form-generate">
                <div class="form-group">
                  <div class="col-sm-6">
                    <select name="bulan" class="form-control">
                      <?php
                        $nama_bln= "bln January February March April May June July August September October November December";

                        $arr_bulan=explode(" ", $nama_bln); // mecah data array

                        for ($i=1; $i <=12 ; $i++) { 
                          echo '<option value="'.$i.'">'.$arr_bulan[$i].'</option>';
                        }
                              ?>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <select class="form-control" name="tahun">
                      <option value="<?=date("Y")?>" selected><?=date("Y")?></option>
                      <?php
                        for ($i=2050; $i >= 2000 ; $i--) { 
                          echo '<option value="'.$i.'">'.$i.'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div><br><br>
                <div class="form-group">
                  <div class="col-sm-12 text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="gen_dp();">Generate DP</button>
                  </div>
                </div>
              </form><br><br>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal -->

<script>
//not used
function importData() {
  sUrl="<?=base_url()?>liburan/import"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}

function gen_dp() {
  $.ajax({
    type : "POST",
    url  : '<?php echo base_url();?>LiburController/generate_dp/',
    data : $("#form-generate").serialize(),
    dataType : "json",
    success:function(data){
      if(data.status=="200"){
        alert("Data tergenerate.");
      }
    }
  });
}

</script>