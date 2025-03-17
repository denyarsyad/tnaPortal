<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion pt-2" id="accordionSidebar">
	<!--Menu Untuk Admin-->
	<?php if ($this->session->userdata('level') == "Admin") { ?>
		<!-- Nav Item - Dashboard -->
		<li class="nav-item <?= (uri_string() == 'dashboard' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<!-- Heading -->
		<div class="sidebar-heading pl-2">
			Ticket
		</div>

		<li class="nav-item <?= (uri_string() == 'ticket/list_approve' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= base_url('ticket/list_approve') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Tiket Baru</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'ticket/index' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= base_url('ticket/index') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Daftar Tiket</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'statistik' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('statistik') ?>">
				<i class="fas fa-fw fa-chart-bar"></i>
				<span>Laporan</span>
			</a>
		</li>

		<!-- Heading -->
		<div class="sidebar-heading pl-2">
			Office
		</div>

		<li class="nav-item <?= (uri_string() == 'departemen' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= base_url('departemen') ?>">
				<i class="fas fa-fw fa-building"></i>
				<span>Departemen</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'jabatan' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= base_url('jabatan') ?>">
				<i class="fas fa-fw fa-building"></i>
				<span>Jabatan</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'pegawai' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= base_url('pegawai') ?>">
				<i class="fas fa-fw fa-building"></i>
				<span>Pegawai</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'user' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= base_url('user') ?>">
				<i class="fas fa-fw fa-users"></i>
				<span>Users</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'informasi' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= base_url('informasi') ?>">
				<i class="fas fa-fw fa-newspaper"></i>
				<span>Informasi</span></a>
		</li>

		<!-- Heading -->
		<div class="sidebar-heading pl-2">
			Master
		</div>

		<!-- Nav Item - Pages Collapse Menu -->
		<li class="nav-item">
			<a class="nav-link <?= (uri_string() == 'user' || uri_string() == 'kategori' || uri_string() == 'subkategori' || uri_string() == 'prioritas' ? '' : 'collapsed'); ?>" href="#" data-toggle="collapse" href="<?= site_url('prioritas') ?>" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
				<i class="fas fa-fw fa-wrench"></i>
				<span>Master</span>
			</a>
			<div id="collapseSetting" class="collapse <?= (uri_string() == 'lokasi' || uri_string() == 'kategori' || uri_string() == 'subkategori' || uri_string() == 'prioritas' || uri_string() == 'backup' ? 'show' : ''); ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item <?= (uri_string() == 'lokasi' ? 'active' : ''); ?>" href="<?= base_url('lokasi') ?>">Lokasi</a>
					<a class="collapse-item <?= (uri_string() == 'kategori' ? 'active' : ''); ?>" href="<?= site_url('kategori') ?>">Kategori</a>
					<a class="collapse-item <?= (uri_string() == 'subkategori' ? 'active' : ''); ?>" href="<?= site_url('subkategori') ?>">Sub Kategori</a>
					<a class="collapse-item <?= (uri_string() == 'prioritas' ? 'active' : ''); ?>" href="<?= site_url('prioritas') ?>">Prioritas</a>
					<a class="collapse-item <?= (uri_string() == 'backup' ? 'active' : ''); ?>" href="<?= site_url('backup') ?>">Backup DB</a>
				</div>
			</div>
		</li>

		<li class="nav-item <?= (uri_string() == 'setting' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('setting') ?>">
				<i class="fas fa-fw fa-cog"></i>
				<span>Pengaturan</span>
			</a>
		</li>

		<!--Menu Untuk Teknisi-->
	<?php
	} else if ($this->session->userdata('level') == "Technician") { ?>
		<!-- Divider -->
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item <?= (uri_string() == 'dashboard' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'ticket_teknisi/index_approve' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('ticket_teknisi/index_approve') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Tiket Ditugaskan</span>
			</a>
		</li>

		<li class="nav-item <?= (uri_string() == 'ticket_teknisi/index_tugas' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('ticket_teknisi/index_tugas') ?>">
				<i class="fas fa-fw fa-tasks"></i>
				<span>Daftar Tugas</span>
			</a>
		</li>

		<!--Menu Untuk User-->
	<?php
	} else if ($this->session->userdata('level') == "User") { ?>
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item">
			<a href="<?= site_url('ticket_user/buat') ?>" class="nav-link">
				<div class="btn btn-success btn-lg shadow-sm btn-block">
					<i class="fas fa-plus text-white"></i>
					<span class="text">Buat Tiket</span>
				</div>
			</a>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item <?= (uri_string() == 'dashboard' ? 'active' : ''); ?>">
			<a class="nav-link " href="<?= site_url('dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'ticket_user' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('ticket_user') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Tiket Saya</span>
			</a>
		</li>
		<!-- Menu Untuk Spv Dept-->
	<?php 
	} else if ($this->session->userdata('level') == "SPV") { ?>
		<!-- Divider -->
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item <?= (uri_string() == 'dashboard' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'ticket_spv/index_tugas' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('ticket_spv/index_tugas') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Daftar Tiket</span>
			</a>
		</li>
	<?php } else if ($this->session->userdata('level') == "MGR") { ?>
		<!-- Divider -->
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item <?= (uri_string() == 'dashboard' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'ticket_mgr/list_tugas_mgr' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('ticket_mgr/list_tugas_mgr') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Daftar Tiket</span>
			</a>
		</li>
	<?php } else if ($this->session->userdata('level') == "SPVU") { ?>
		<!-- Divider -->
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item <?= (uri_string() == 'dashboard' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'ticket_spvu/list_tugas_spvu' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('ticket_spvu/list_tugas_spvu') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Daftar Tiket</span>
			</a>
		</li>
	<?php } else if ($this->session->userdata('level') == "SPVM") { ?>
		<!-- Divider -->
		<hr class="sidebar-divider my-0">
		<!-- Nav Item - Dashboard -->
		<li class="nav-item <?= (uri_string() == 'dashboard' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('dashboard') ?>">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Dashboard</span></a>
		</li>

		<li class="nav-item <?= (uri_string() == 'ticket_spvm/list_tugas_spvm' ? 'active' : ''); ?>">
			<a class="nav-link" href="<?= site_url('ticket_spvm/list_tugas_spvm') ?>">
				<i class="fas fa-fw fa-ticket-alt"></i>
				<span>Daftar Tiket</span>
			</a>
		</li>
	<?php }  ?>
</ul>