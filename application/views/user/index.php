<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>
	<div class="flash-data1" data-flashdata="<?= $this->session->flashdata('status1') ?>"></div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<a href="#modal-fade" title="Tambah <?= $title; ?>" class="btn btn-primary mb-4" data-toggle="modal">
				<i class="fa fa-plus"></i> Tambah <?= $title; ?>
			</a>
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>Username</th>
							<th>Nama</th>
							<th>Departemen</th>
							<th>Sub Departemen</th>
							<th>Level</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($user as $row) { ?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $row->nik ?></td>
								<td><?= $row->nama ?></td>
								<td><?= $row->nama_dept ?></td>
								<td><?= $row->nama_bagian_dept ?></td>
								<td><strong><?= $row->level ?></strong></td>
								<td>
									<a href="<?= site_url('user/edit/' . $row->id_user) ?>" data-toggle="tooltip" title="Edit User" class="btn btn-primary btn-circle btn-sm"><i class="fa fa-edit"></i>
									</a>
									<a href="<?= site_url('user/resetpassword/' . $row->id_user) ?>" data-toggle="tooltip" title="Reset Password" class="btn btn-warning text-dark btn-circle btn-sm reset"><i class="fa fa-lock"></i>
									</a>
									<a href="<?= site_url('user/hapus/' . $row->id_user) ?>" data-toggle="tooltip" title="Hapus User" class="btn btn-danger btn-circle btn-sm hapus"><i class="fas fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="modal-fade" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="m-0 font-weight-bold text-primary">Tambah <?= $title; ?></h6>
			</div>
			<div class="modal-body">
				<form id="form-validation" action="<?= site_url('user/tambah') ?>" method="POST">

					<div class="form-group">
						<label>Pegawai</label>
						<?= form_dropdown('id_pegawai', $dd_pegawai, set_value('id_pegawai'), ' id="id_pegawai" class="form-control select2' . (form_error('id_pegawai') ? "is-invalid" : "") . ' " style="width: 100% !important;"'); ?>
						<div class="invalid-feedback">
							<?= form_error('id_pegawai'); ?>
						</div>
					</div>

					<div class="form-group">
						<label>Level</label>
						<?= form_dropdown('id_level', $dd_level, set_value('id_level'), ' id="id_level" class="form-control ' . (form_error('id_level') ? "is-invalid" : "") . ' "'); ?>
						<div class="invalid-feedback">
							<?= form_error('id_level'); ?>
						</div>
					</div>

					<div class="form-group">
						<div id="div-order"></div>
					</div>

					<div class="alert alert-warning text-dark" role="alert">
						<h6 class="font-weight-bold">Informasi!</h6>
						<ul class="pl-3" style="font-size: 14px;">
							<li>Password default adalah 12345678</li>
							<li>Pegawai diwajibkan mengganti password setelah username dan password diberikan</li>
						</ul>
					</div>

					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Tutup</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		$("#id_pegawai").change(function() {
			// Put an animated GIF image insight of content	 		
			var data = {
				id_pegawai: $("#id_pegawai").val()
			};
			$.ajax({
				type: "POST",
				url: "<?= site_url('select/select_email') ?>",
				data: data,
				success: function(msg) {
					$('#div-order').html(msg);
				}
			});
		});

	});
</script>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData) {
		Swal.fire(
			'Sukses!',
			'User Akun Berhasil ' + flashData,
			'success'
		)
	}

	const flashData1 = $('.flash-data1').data('flashdata');
	if (flashData1) {
		Swal.fire(
			'Sukses!',
			flashData1,
			'success'
		)
	}

	$('.hapus').on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Apa anda yakin?',
			text: "User Akun akan dihapus",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Delete'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	});

	$('.reset').on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Reset Password?',
			text: "Password User akun ini akan direset",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Reset'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	});
</script>