<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>HRD SYSTEM</title>
<meta name="description" content="Marino, Admin theme, Dashboard theme, AngularJS Theme">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?=base_url()?>/assets/favicon.ico">
<!-- global stylesheets -->
<!-- <link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" /> -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/1.0.0/css/flag-icon.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>/assets/styles/main.css" />

<script src="<?=base_url()?>/assets/jquery-3.1.0.min.js"></script>
<script src="<?=base_url()?>/assets/bower_components/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" />
<!-- SELECT2 -->
<link href="<?=base_url()?>assets/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/select2/dist/js/select2.min.js"></script>
<style type="text/css">
    table {
        white-space: nowrap;
    }
</style>

</head>
<body data-layout="empty-layout" data-palette="palette-0">
    <nav class="navbar navbar-fixed-top navbar-1">
    <ul class="nav navbar-nav pull-left toggle-layout">
        <li class="nav-item">

            <a class="nav-link" data-click="toggle-layout">
                <i class="zmdi zmdi-menu"></i> 
            </a>
        </li>
    </ul>
    <a class="navbar-brand" href="index.html">HRD Restoran</a> 
    <ul class="nav navbar-nav pull-left toggle-fullscreen-mode">
        <li class="nav-item">

            <a class="nav-link" data-click="toggle-fullscreen-mode">
                <i class="zmdi zmdi-fullscreen"></i> 
            </a>
        </li>
    </ul>
</nav>
        <div class="container-fluid">
        <div class="row">
            <div class="sidebar-placeholder"></div>
<div class="sidebar-outer-wrapper">
    <div class="sidebar-inner-wrapper">
        <div class="sidebar-1">
            <div class="profile" style="height: 100px;">
                <button data-click="toggle-sidebar" type="button" class="btn btn-white btn-outline no-border close-sidebar">
                    <i class="fa fa-close"></i> 
                </button>
                <div class="profile-image">
                    <img class="img-responsive" src="<?=base_url()?>assets/assets/faces/m1.png">
                </div>
                <!--<div class="social-media">
                    <button type="button" class="btn btn-facebook btn-circle m-r-5">
                        <i class="fa fa-facebook"></i> 
                    </button>
                    <button type="button" class="btn btn-twitter btn-circle m-r-5">
                        <i class="fa fa-twitter"></i> 
                    </button>
                    <button type="button" class="btn btn-google btn-circle m-r-5">
                        <i class="fa fa-google"></i> 
                    </button>
                </div>
                <div class="profile-title">Lucas smith</div>
                <div class="profile-subtitle">lucas.smith@gmail.com</div>
                
                <div class="profile-toggle">
                    <button data-click="toggle-profile" type="button" class="btn btn-white btn-outline no-border">
                        <i class="pull-right fa fa-caret-down icon-toggle-profile"></i> 
                    </button>
                </div>
                -->
            </div>
            <div class="sidebar-nav">
                <!--
                <div class="sidebar-section account-links">
                    <div class="section-title">Account</div>
                    <ul class="list-unstyled section-content">
                        <li>
                            <a class="sideline">
                                <i class="zmdi zmdi-account-circle md-icon pull-left"></i> 
                                <span class="title">Profile</span> 
                            </a>
                        </li>
                        <li>
                            <a class="sideline">
                                <i class="zmdi zmdi-settings md-icon pull-left"></i> 
                                <span class="title">Settings</span> 
                            </a>
                        </li>
                        <li>
                            <a class="sideline">
                                <i class="zmdi zmdi-favorite-outline md-icon pull-left"></i> 
                                <span class="title">Favorites</span> 
                            </a>
                        </li>
                        <li>
                            <a class="sideline">
                                <i class="zmdi zmdi-sign-in md-icon pull-left"></i> 
                                <span class="title">Logout</span> 
                            </a>
                        </li>
                    </ul>
                </div>
                -->
                <div class="sidebar-section">
                    <div class="section-title hidden">Navigation</div>
                    <ul class="l1 list-unstyled section-content">
                        <?php
                        $id_level=$this->session->userdata('id_level');
                        $main_menu=$this->db->join('mainmenu','mainmenu.idmenu=tab_akses_mainmenu.id_menu')
                                            ->where('tab_akses_mainmenu.id_level',$id_level)
                                            ->where('tab_akses_mainmenu.r','1')
                                            ->order_by('mainmenu.index_menu','asc')
                                            ->get('tab_akses_mainmenu')
                                            ->result();
                        foreach ($main_menu as $rs) {
                        ?>
                        <li>
                            <?php
                            $row=$this->db->where('mainmenu_idmenu',$rs->idmenu)->get('submenu')->num_rows();
                            if ($row>1) {
                                $sub_menu=$this->db->join('submenu','submenu.id_sub=tab_akses_submenu.id_sub_menu')
                                                   ->where('submenu.mainmenu_idmenu',$rs->idmenu)
                                                   ->where('tab_akses_submenu.id_level',$id_level)
                                                   ->where('tab_akses_submenu.r','1')
                                                   ->order_by('submenu.index_menu','asc')
                                                   ->get('tab_akses_submenu')
                                                   ->result();
                                ?>
                                <a class="sideline" data-id="<?=$rs->idmenu?>" data-click="toggle-section" href="<?=base_url().$rs->link_menu?>">
                                <i class="pull-right fa fa-caret-down icon-<?=$rs->idmenu?>"></i> 
                                <i class="<?=$rs->icon_class?>"></i> 
                                <span class="title"><?=$rs->nama_menu?></span> 
                                </a>
                                <?php
                                echo "<ul class='list-unstyled section-$rs->idmenu l2'>";
                                foreach ($sub_menu as $rsub) {
                                ?>
                                <li>
                                    <a class="sideline" href="<?=base_url().$rsub->link_sub?>">
                                        <span><?=$rsub->nama_sub?></span>
                                    </a>
                                </li>
                                <?php
                                }
                                echo "</ul>";
                            }else{
                            ?>
                            <a class="sideline" href="<?=base_url().$rs->link_menu?>">
                                <i class="<?=$rs->icon_class?>"></i> 
                                <span class="title"><?=$rs->nama_menu?></span> 
                            </a>
                        </li>
                        <?php
                        }
                        }
                        ?>
                        <?php
                            if ($id_level==1 OR $id_level==2 OR $id_level==4) { ?>
                        <li>
                            <!-- <a class="sideline" href="#" data-toggle="modal" data-target="#ModSaldoAwal"> -->
                            <!-- <a class="sideline" href="#" data-toggle="modal" data-target="#ModImportSaldo"> -->
                            <a class="sideline" href="#" data-toggle="modal" data-target="#ModImport">
                            <i class="zmdi zmdi-upload md-icon pull-left"></i> 
                            <span class="title">Import Data</span> 
                            </a>
                        </li>
                        <?php   
                            }
                        ?>
                        <li>
                            <a class="sideline" href="<?=base_url()?>logout">
                            <i class="zmdi zmdi-info-outline md-icon pull-left"></i> 
                            <span class="title">Logout</span> 
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row m-b-20">
                <div class="col-xs-12 main" id="main">
                    <?=$halaman?>
    				<div class="footer">
                        <div class="row">
                            <div class="col-xs-12">
                                <hr>
                                <a href="http://www.jasawebsurabaya.com" target="_blank">&copy; Copyright Webtocrat Motion <?=date('Y')?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- global scripts 


<div id="ModSaldoAwal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Saldo Awal</h4>
      </div>
      <div class="modal-body" style="height:150px;">
        <form id="form-saldoawal">
            <label for="inputEmail3" class="col-sm-2 control-label">Bulan</label>
            <div class="col-sm-4">
                <select name="bulan" class="form-control">
                    <?php
                        $nama_bln= "bln January February March April May June July August September October November December";
                        $arr_bulan=explode(" ", $nama_bln); // mecah data array
                        $month_now = date('m');

                        for ($i=1; $i <=12 ; $i++) {
                            echo '<option value="'.$i.'">'.$arr_bulan[$i].'</option>';
                        }
                    ?>
                </select>
            </div>
            <label for="inputEmail3" class="col-sm-2 control-label">Export File</label>
            <div class="col-sm-4">
                <input type="file" class="form-control" id="myfile" name="myfile" placeholder="File Excel">
            </div>
            <br><br><br>
            <div class="col-sm-12 text-right">
                <button type="button" class="btn btn-primary" onclick="upload_saldo_awal();">Upload File</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!==================================================-->
<div id="ModImport" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Import Data</h4>
      </div>
      <div class="modal-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#bpjs" aria-controls="bpjs" role="tab" data-toggle="tab">GAJI BPJS</a>
                </li>
                <li role="presentation">
                    <a href="#gajikaryawan" aria-controls="gajikaryawan" role="tab" data-toggle="tab">GAJI KARYAWAN</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="bpjs">
                <br>
                    <form class="form-horizontal" id="importbpjs" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="bpjsfile" class="col-sm-2 control-label">File Excel</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" id="bpjsfile" name="bpjsfile" placeholder="File Excel">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                          <a href="<?php echo base_url();?>template_upload/template_gaji_bpjs.xlsx" download>
                            <button type="button" class="btn btn-success">Download File Template</button>
                          </a>
                          <button type="submit" class="btn btn-primary">Upload File</button>
                        </div>
                      </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade in" id="gajikaryawan">
                <br>
                    <form class="form-horizontal" id="importgajikaryawan" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="gajifile" class="col-sm-2 control-label">File Excel</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" id="gajifile" name="gajifile" placeholder="File Excel">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                          <a href="<?php echo base_url();?>template_upload/template_gaji_karyawan.xlsx" download>
                            <button type="button" class="btn btn-success">Download File Template</button>
                          </a>
                          <button type="submit" class="btn btn-primary">Upload File</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--==================================================-->
<!--==================================================-->
<div id="ModImportSaldo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body" style="height:150px;">
        <form id="form-import">
            <label for="inputEmail3" class="col-sm-2 control-label">Export File</label>
            <div class="col-sm-4">
                <input type="file" class="form-control" id="myfile" name="myfile" placeholder="File Excel">
            </div>
            <br><br><br>
            <div class="col-sm-12 text-right">
                <button type="button" class="btn btn-primary" onclick="upload_saldo_awal();">Upload File</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--==================================================-->


<script src="<?=base_url()?>/assets/bower_components/tether/dist/js/tether.js"></script>
<!-- <script src="<?=base_url()?>/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<script src="<?=base_url()?>/assets/bower_components/PACE/pace.js"></script>
<script src="<?=base_url()?>/assets/scripts/lodash.min.js"></script>
<script src="<?=base_url()?>/assets/scripts/components/jquery-fullscreen/jquery.fullscreen-min.js"></script>
<script src="<?=base_url()?>/assets/bower_components/jquery-storage-api/jquery.storageapi.min.js"></script>
<script src="<?=base_url()?>/assets/bower_components/wow/dist/wow.min.js"></script>
<script src="<?=base_url()?>/assets/scripts/functions.js"></script>
<script src="<?=base_url()?>/assets/scripts/colors.js"></script>
<script src="<?=base_url()?>/assets/scripts/left-sidebar.js"></script>
<script src="<?=base_url()?>/assets/scripts/navbar.js"></script>
<script src="<?=base_url()?>/assets/scripts/horizontal-navigation-1.js"></script>
<script src="<?=base_url()?>/assets/scripts/horizontal-navigation-2.js"></script>
<script src="<?=base_url()?>/assets/scripts/horizontal-navigation-3.js"></script>
<script src="<?=base_url()?>/assets/scripts/main.js"></script>
<script src="<?=base_url()?>/assets/bower_components/notifyjs/dist/notify.js"></script>
<script src="<?=base_url()?>assets/scripts/topojson.min.js"></script>
<script src="<?=base_url()?>assets/scripts/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/scripts/tables-datatable.js"></script>
<script src="<?=base_url()?>assets/bower_components/bootstrap-validator/dist/validator.min.js"></script>
<script src="<?=base_url()?>assets/scripts/components/floating-labels.js"></script>
<script src="<?=base_url()?>assets/scripts/forms-validation.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/scripts/pilihan.js"></script>
<script src="<?=base_url()?>assets/scripts/jquery-ui.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/styles/jquery-ui.css">
<script src="<?=base_url()?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
<script src="<?=base_url()?>assets/scripts/forms-pickers.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/jmask/jquery.mask.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/numberformat/jquery.number.min.js"></script>

<script type="text/javascript">
    setTimeout(function(){ $('select').select2(); }, 1000);

    function upload_saldo_awal() {
        var formData = new FormData($('#form-saldoawal')[0]);
        //var formData = new FormData($('#form-import')[0]);
        $.each($("input[type='file']")[0].files, function(i, file) {
            formData.append('file', file);
        });

        $.ajax({
            //url: '<?php echo base_url();?>Mycustom_controller/export_file',
            url: '<?php echo base_url();?>Mycustom_controller/export_saldo_awal',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                if (data.status=='200') {
                    alert("Saldo Awal DP Cuti Berhasil Diimport.");
                }
            }
        }); 
    }

    $("#importbpjs").submit(function(event){
        var formData = new FormData($('#importbpjs')[0]);
        $.each($("input[type='file']")[0].files, function(i, file) {
            formData.append('file', file);
        });
        $.ajax({
            type : "POST",
            url: '<?php echo base_url();?>Mycustom_controller/import_gaji_bpjs',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success:function(data){
              if(data.status == "200"){
                alert("Gaji BPJS berhasil diimport.");
              }
            }
        });
        return false;
    });

    $("#importgajikaryawan").submit(function(event){
        var formData = new FormData($('#importgajikaryawan')[0]);
        $.each($("input[type='file']")[0].files, function(i, file) {
            formData.append('file', file);
        });
        $.ajax({
            type : "POST",
            url: '<?php echo base_url();?>Mycustom_controller/import_gaji_karyawan',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success:function(data){
              if(data.status == "200"){
                alert("Gaji Karyawan berhasil diimport.");
              }
            }
        });
        return false;
    });
</script>

</body>
</html>

<!-- Localized -->
