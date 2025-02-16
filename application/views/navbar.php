<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm navbar-fixed-top">
	<!-- Brand -->
	<a class="navbar-brand d-flex align-items-center justify-content-center" href="<?= site_url('dashboard') ?>">
		<div class="navbar-brand-icon">
			<img width="35px" src="<?= base_url('assets/img/') . $this->settings->info['logo']; ?>">
		</div>
		<div class="navbar-brand-text mx-3 text-uppercase"><?= $this->settings->info['aplikasi']; ?></div>
	</a>

	<button class="btn rounded border-0 font-weight-bold text-dark" id="sidebarToggle"><i class="fas fa-bars fa-lg"></i></button>
	
	<ul class="navbar-nav ml-auto">
		<?php if ($this->session->userdata('level') == "Admin") : ?>
			<li class="nav-item dropdown no-arrow mx-1">
				<a class="nav-link dropdown-toggle text-dark" href="javascript:void(0)" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-fw fa-bell fa-lg"></i>
					<span id="show_jmlnew" class="mb-3"></span>
				</a>
				<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
					<h6 class="dropdown-header">
						Notifikasi
					</h6>
					<div id="show_data">

					</div>
				</div>
			</li>
		<?php endif; ?>

		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle text-dark" href="javascript:void(0)" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-fw fa-user mr-1"></i>
				<span class="mr-2 d-none d-lg-inline text-gray-700">
					<?= $this->session->userdata('nama'); ?>
				</span>
				<i class="fas fa-angle-down"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
				<a class="dropdown-item py-2" href="<?= site_url('user/profile') ?>">
					<i class="fas fa-id-card-alt fa-sm fa-fw mr-2 text-black-100"></i>
					Profil Saya
				</a>
				<a class="dropdown-item py-2" href="<?= site_url('user/password') ?>">
					<i class="fas fa-key fa-sm fa-fw mr-2 text-black-100"></i>
					Ganti Password
				</a>
				<a class="dropdown-item py-2" href="#modal-stok" data-toggle="modal">
					<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-black-100"></i>
					Logout
				</a>
			</div>
		</li>
	</ul>
</nav>