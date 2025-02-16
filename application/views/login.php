<!--
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
-->
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="IT Helpdesk <?= $this->settings->info['perusahaan']; ?>">
	<meta name="author" content="<?= $this->config->item('site_company'); ?>">
	<title><?= $this->settings->info['aplikasi']; ?> <?= $this->settings->info['perusahaan']; ?></title>
	
	<!-- Custom fonts for this template-->
	<link href="<?= base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="<?= base_url() ?>assets/css/sb-admin-2.css" rel="stylesheet">
	<link rel="icon" type="image/png" href="<?= base_url('assets/img/') . $this->settings->info['logo']; ?>">
	<!-- Related styles of various icon packs and plugins -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins.css">
	<!-- Modernizr (browser feature detection library) -->
	<script src="<?= base_url() ?>assets/js/vendor/modernizr-3.3.1.min.js"></script>
</head>

<body class="bg-primary" style="background: url('<?= base_url('assets/img/') . $this->settings->info['background']; ?>') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-5">
				<div class="card o-hidden border-0 shadow-lg" style="margin: auto; margin-top: 15%">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg">
								<div class="p-3 m-3">
									<div>
										<h2 class="h5 font-weight-bold text-center text-dark"><?= $this->settings->info['perusahaan']; ?></h2>
										<h1 class="h2 font-weight-bold text-center push-top-bottom animation-slideDown" style="color: black">
											<img src="<?= base_url('assets/img/') . $this->settings->info['logo']; ?>" width="50">
											<?= $this->settings->info['aplikasi']; ?>
										</h1>
										<br />

										<?php if ($this->session->flashdata('status')) : ?>
											<div class="alert alert-danger alert-dismissable">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												<strong>Error!</strong> Username atau Password <?= $this->session->flashdata('status'); ?>
											</div>
										<?php endif; ?>

										<?php if ($this->session->flashdata('status1')) : ?>
											<div class="alert alert-info alert-dismissable">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												Sesi Anda telah <strong><?= $this->session->flashdata('status1'); ?></strong>! Silahkan login terlebih dahulu!
											</div>
										<?php endif; ?>

										<form action="<?= site_url('login/loginProses') ?>" method="post">
											<div class="form-group">
												<input type="text" name="username" class="form-control form-control-lg <?= (form_error('username') ? "is-invalid" : "") ?>" placeholder="Username/Email/Telepon" autofocus>
												<div class="invalid-feedback">
													<?= form_error('username'); ?>
												</div>
											</div>

											<div class="form-group">
												<input type="password" name="password" class="form-control form-control-lg <?= (form_error('password') ? "is-invalid" : "") ?>" id="password" placeholder="Password">
												<div class="invalid-feedback">
													<?= form_error('password'); ?>
												</div>
											</div>

											<div class="form-group">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" id="checkbox" onclick="myPassword()">
													<label for="checkbox">
														Lihat password
													</label>
												</div>
											</div>

											<button type="submit" class="btn btn-primary btn-lg btn-user btn-block">Login</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<p class="text-center text-white mt-3 small">
					&copy; 2022-<?= date('Y'); ?> <?= $this->config->item('site_company'); ?>. Software <?= $this->config->item('site_name'); ?> <?= $this->config->item('site_version'); ?>.<br />All rights reserved
				</p>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function myPassword() {
			var x = document.getElementById("password");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
		}
	</script>
</body>

</html>