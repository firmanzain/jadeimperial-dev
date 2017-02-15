<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
<title>HRD SYSTEM</title>
<meta name="description" content="Marino, Admin theme, Dashboard theme, AngularJS Theme">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="favicon.ico">
<!-- global stylesheets -->
<link rel="stylesheet" href="<?=base_url()?>assets/styles/bootstrap.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/1.0.0/css/flag-icon.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>assets/styles/main.css" />
</head>
<body data-layout="empty-view">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 main" id="main">
				<div class="login-page text-center">
    <h1>
		HRD Sistem Login 
    </h1>
    <h4>
		Masukkan username Dan Password Untuk Mengakses Sistem Ini
    </h4>
   <div class="alert alert-danger" role='alert' id="pesan" hidden>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>×</span><span class='sr-only'>Close</span>
        </button> 
        Username dan password tidak sesuai, silahkan coba kembali
    </div>
    <div class="row">
        <div class="col-xs-offset-2 col-xs-8 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4">

            <form name="form" novalidate class="form">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group floating-labels">
                            <label for="email">Email</label>
                            <input id="email" autocomplete="off" type="text" name="email">
                            <p class="error-block"></p>
                        </div>
                    </div>
                </div>
                <div class="row m-b-40">
                    <div class="col-xs-12">
                        <div class="form-group floating-labels">
                            <label for="password">Password</label>
                            <input id="password" autocomplete="off" type="password" name="password">
                            <p class="error-block">sadas</p>
                        </div>
                    </div>
                </div>

                <div class="row buttons">
                    <div class="col-xs-12 col-md-12">
                        <input type="button" id="login" class="btn btn-lg btn-info btn-block m-b-20" value="Login">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <p class="copyright text-sm">&copy; Copyright Webtocrat Motion <?=date('Y')?></p>
</div>
            </div>
        </div>
    </div>
    <!-- global scripts -->
<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.js"></script>
<script src="<?=base_url()?>assets/bower_components/tether/dist/js/tether.js"></script>
<script src="<?=base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="<?=base_url()?>assets/bower_components/PACE/pace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.0.0/lodash.min.js"></script>
<script src="<?=base_url()?>assets/scripts/components/jquery-fullscreen/jquery.fullscreen-min.js"></script>
<script src="<?=base_url()?>assets/bower_components/jquery-storage-api/jquery.storageapi.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/wow/dist/wow.min.js"></script>
<script src="<?=base_url()?>assets/scripts/functions.js"></script>
<script src="<?=base_url()?>assets/scripts/colors.js"></script>
<script src="<?=base_url()?>assets/scripts/left-sidebar.js"></script>
<script src="<?=base_url()?>assets/scripts/navbar.js"></script>
<script src="<?=base_url()?>assets/scripts/horizontal-navigation-1.js"></script>
<script src="<?=base_url()?>assets/scripts/horizontal-navigation-2.js"></script>
<script src="<?=base_url()?>assets/scripts/horizontal-navigation-3.js"></script>
<script src="<?=base_url()?>assets/scripts/main.js"></script>
<script src="<?=base_url()?>assets/scripts/components/floating-labels.js"></script>
<script src="<?=base_url()?>assets/scripts/pages-login.js"></script>
<script type="text/javascript">
$(function() {
    $('#login').click(function(){
        var pm1=$('#email').val();
        var pm2=$('#password').val();
        $.ajax({
                type: "POST",
                url : "<?php echo base_url(); ?>LoginController/go_login",
                data : "email="+pm1+"&password="+pm2+"",
                datatype : 'json',
                beforeSend: function(msg){$("#login").val('Loading...');},
                success: function(msg){
                    var data_cek = JSON.parse(''+msg+'' );
                    if (data_cek.hasil=='1') {
                        $("#login").val('Login Sukses');
                        window.location.assign("<?=base_url()?>Welcome");
                    }else{
                        $("#login").val('Login');
                        $("#pesan").attr('hidden',false);
                    }
                }
            });
    });
  });
$("#password").keyup(function (e) {
    if (e.keyCode == 13) {
        $('#login').click();
    }
});
$("#email").keyup(function (e) {
    if (e.keyCode == 13) {
        $('#password').focus();
    }
});
</script>
</body>
</html>

<!-- Localized -->