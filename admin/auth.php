<?php
require_once '../config.php';
if (Session::issetSession('user')) {
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 10 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->

<head>
	<meta charset="utf-8" />
	<title>Login Page 5 | Keenthemes</title>
	<meta name="description" content="Login page example" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="canonical" href="https://keenthemes.com/metronic" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Custom Styles(used by this page)-->
	<link href="assets/css/pages/login/classic/login-5.css" rel="stylesheet" type="text/css" />
	<!--end::Page Custom Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
	<!--end::Layout Themes-->
	<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
	<!--jquery cdn-->
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
	<!--custom style-->
	<style>
		span.error {
			color: #ff482b !important;
		}
	</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-5 login-signin-on d-flex flex-row-fluid" id="kt_login">
			<div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url(assets/media/bg/bg-2.jpg);">
				<div class="login-form text-center text-white p-7 position-relative overflow-hidden">
					<!--begin::Login Header-->
					<div class="d-flex flex-center mb-15">
						<a href="#">
							<img src="assets/media/logos/logo-letter-13.png" class="max-h-75px" alt="" />
						</a>
					</div>
					<!--end::Login Header-->
					<!--begin::Login Sign in form-->
					<div class="login-signin">
						<div class="mb-20">
							<h3 class="opacity-40 font-weight-normal">Sign In To Admin</h3>
							<p class="opacity-40">Enter your details to login to your account:</p>
						</div>
						<form class="form" id="kt_login_signin_form">
							<div class="form-group">
								<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" value="<?= $_COOKIE['account'] ?? '' ?>" placeholder="Username or email" name="account" required />
								<span class="form-text text-muted error account"></span>
							</div>
							<div class="form-group">
								<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" value="<?= $_COOKIE['password'] ?? '' ?>" placeholder="Password" name="password" required />
								<span class="form-text text-muted error password"></span>
							</div>
							<div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8 opacity-60">
								<div class="checkbox-inline">
									<label class="checkbox checkbox-outline checkbox-white text-white m-0">
										<input type="checkbox" name="remember" <?= isset($_COOKIE['remember']) ? 'checked' : '' ?> />
										<span></span>Remember me</label>
								</div>
								<a href="javascript:;" id="kt_login_forgot" class="text-white font-weight-bold">Forget Password ?</a>
							</div>
							<div class="g-recaptcha" data-sitekey="<?=SITE_KEY?>"></div>
                			<span class="form-text text-muted error recaptcha" style="padding:0;border:none;"></span>
							<div class="form-group text-center mt-10">
								<button type="submit" id="kt_login_signin_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3">Sign In</button>
							</div>
						</form>
						<div class="mt-10">
							<span class="opacity-40 mr-4">Don't have an account yet?</span>
							<a href="javascript:;" id="kt_login_signup" class="text-white opacity-30 font-weight-normal">Sign Up</a>
						</div>
					</div>
					<!--end::Login Sign in form-->
				</div>
			</div>
		</div>
		<!--end::Login-->
	</div>
	<!--end::Main-->
	<script>
		var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
	</script>
	<!--begin::Global Config(global config for global JS scripts)-->
	<script>
		var KTAppSettings = {
			"breakpoints": {
				"sm": 576,
				"md": 768,
				"lg": 992,
				"xl": 1200,
				"xxl": 1400
			},
			"colors": {
				"theme": {
					"base": {
						"white": "#ffffff",
						"primary": "#3699FF",
						"secondary": "#E5EAEE",
						"success": "#1BC5BD",
						"info": "#8950FC",
						"warning": "#FFA800",
						"danger": "#F64E60",
						"light": "#E4E6EF",
						"dark": "#181C32"
					},
					"light": {
						"white": "#ffffff",
						"primary": "#E1F0FF",
						"secondary": "#EBEDF3",
						"success": "#C9F7F5",
						"info": "#EEE5FF",
						"warning": "#FFF4DE",
						"danger": "#FFE2E5",
						"light": "#F3F6F9",
						"dark": "#D6D6E0"
					},
					"inverse": {
						"white": "#ffffff",
						"primary": "#ffffff",
						"secondary": "#3F4254",
						"success": "#ffffff",
						"info": "#ffffff",
						"warning": "#ffffff",
						"danger": "#ffffff",
						"light": "#464E5F",
						"dark": "#ffffff"
					}
				},
				"gray": {
					"gray-100": "#F3F6F9",
					"gray-200": "#EBEDF3",
					"gray-300": "#E4E6EF",
					"gray-400": "#D1D3E0",
					"gray-500": "#B5B5C3",
					"gray-600": "#7E8299",
					"gray-700": "#5E6278",
					"gray-800": "#3F4254",
					"gray-900": "#181C32"
				}
			},
			"font-family": "Poppins"
		};
	</script>
	<!--end::Global Config-->
	<!--begin::Global Theme Bundle(used by all pages)-->
	<!--reCaptcha-->  
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!--reCatpcha end-->
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<!--end::Global Theme Bundle-->
	<!--begin::Page Scripts(used by this page)-->
	<!-- <script src="assets/js/pages/custom/login/login-general.js"></script> -->
	<script>
		$(document).ready(function() {
			$('#kt_login_signin_form').submit(function(e) {
				e.preventDefault()
				$this = $(this)
				$this.find('span.error').html('')
				$account = $this.find('input[name="account"]').val()
				$password = $this.find('input[name="password"]').val()
				$remember = $this.find('input[name="remember"]')
				$btnLogin = $this.find('#kt_login_signin_submit')
				$rememberVal = ''
				if ($remember.is(':checked')) {
					$rememberVal = 'yes'
				}
				$.ajax({
					url: '../API/auth.php',
					type: 'POST',
					dataType: 'json',
					data: {
						remember: $rememberVal,
						account: $account,
						password: $password,
						action: 'login',
						loginpage: 'admin',
						recaptcha: grecaptcha.getResponse()
					},
					beforeSend: function() {
						$btnLogin.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true)
					},
					success: function(data) {
						console.log(data)
						setTimeout(() => {
							if (data.status == 'success') {
								Swal.fire("Success!", "Login success", "success")
								$btnLogin.html('<i class="fas fa-check-circle"></i>')
								setTimeout(() => {
									window.location.href = 'index.php'
								}, 1000)
							} else {
								Swal.fire("Error!", "Login failed, try again!", "error")
								$.each(data.message, function(index, value) {
									$this.find('span.error.' + index).html(value)
								})
								grecaptcha.reset()
								$btnLogin.html('Sign In').prop('disabled', false)
							}
						}, 500)
					}
				})
			})
		})
	</script>
	<!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>