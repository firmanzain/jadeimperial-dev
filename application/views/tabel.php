<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<title>HRD SYSTEM</title>
<meta name="description" content="Marino, Admin theme, Dashboard theme, AngularJS Theme">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="favicon.ico">
<!-- global stylesheets -->
<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />
<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/1.0.0/css/flag-icon.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>/assets/styles/main.css" />
</head>
<body data-layout="empty-layout" data-palette="palette-0">
    <form id="bootstrap-validator-form" role="form" novalidate>
            <fieldset class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" placeholder="Enter your username" required data-error="Please enter a valid username">
                <div class="help-block with-errors"></div>
            </fieldset>

            <fieldset class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="Enter your email" data-error="Please enter a valid email" required>
                <div class="help-block with-errors"></div>
            </fieldset>

            <fieldset class="form-group">
                <label>Password</label>
                <input type="password" data-minlength="6" class="form-control" id="password" placeholder="Password" required data-error="Your password should have at least 6 characters">
                <div class="help-block with-errors"></div>
            </fieldset>

            <fieldset class="form-group">
                <label>Confirm password</label>
                <input type="password" class="form-control" id="confirm-password" data-match="#password" data-match-error="Please confirm your password correctly" placeholder="Password" required>
                <div class="help-block with-errors"></div>
            </fieldset>

            <fieldset class="form-group">
                <label class="c-input c-radio">
                    <input id="radio1" name="radio" type="radio" required>
                    <span class="c-indicator c-indicator-success"></span>
                    Option A
                </label>
                <label class="c-input c-radio">
                    <input id="radio2" name="radio" type="radio" required>
                    <span class="c-indicator c-indicator-success"></span>
                    Option B
                </label>
            </fieldset>

            <fieldset class="form-group">
                <label class="c-input c-checkbox">
                    <input type="checkbox" id="terms" data-error="You should really check this" required>
                    <span class="c-indicator c-indicator-warning"></span>
                    Check this
                </label>
                <div class="help-block with-errors"></div>
            </fieldset>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    <!-- global scripts -->
<script src="<?=base_url()?>/assets/bower_components/jquery/dist/jquery.js"></script>
<script src="<?=base_url()?>/assets/bower_components/tether/dist/js/tether.js"></script>
<script src="<?=base_url()?>/assets/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="<?=base_url()?>/assets/bower_components/PACE/pace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.0.0/lodash.min.js"></script>
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
    <script src="<?=base_url()?>/assets/bower_components/bootstrap-validator/dist/validator.min.js"></script>
    <script src="<?=base_url()?>/assets/scripts/components/floating-labels.js"></script>
    <script src="<?=base_url()?>/assets/scripts/forms-validation.js"></script>
</body>
</html>

<!-- Localized -->