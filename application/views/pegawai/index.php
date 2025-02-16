<script language="javascript" type="text/javascript">
	$(document).ready(function() {

		$("#id_departemen").change(function() {
			// Put an animated GIF image insight of content

			var data = {
				id_departemen: $("#id_departemen").val()
			};
			$.ajax({
				type: "POST",
				url: "<?= base_url() . 'Select/select_subdept' ?>",
				data: data,
				success: function(msg) {
					$('#div-order').html(msg);
				}
			});
		});

	});
</script>

<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

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
							<th>ID Pegawai</th>
							<th>Nama</th>
							<th>Email</th>
							<th>Telepon</th>
							<th>Jabatan</th>
							<th>Departemen</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($pegawai as $row) { ?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $row->nik ?></td>
								<td><?= $row->nama ?></td>
								<td><?= $row->email ?></td>
								<td><?= $row->telp ?></td>
								<td><?= $row->nama_jabatan ?></td>
								<td><?= $row->nama_dept ?><br/><?= $row->nama_bagian_dept ?></td>
								<td>
									<a href="<?= site_url('pegawai/edit/' . $row->nik) ?>" data-toggle="tooltip" title="Edit Pegawai" class="btn btn-primary btn-circle btn-sm mr-2"><i class="fa fa-edit"></i>
									</a>
									<a href="<?= site_url('pegawai/hapus/' . $row->nik) ?>" data-toggle="tooltip" title="Hapus Pegawai" class="btn btn-danger btn-circle btn-sm hapus"><i class="fas fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
			</div>
			<hr>
			<div class="alert alert-warning text-dark" role="alert">
				<h6 class="font-weight-bold">Informasi!</h6>
				<p class="mb-0" style="font-size: 14px;">
				Buat Akun Pegawai di <code>Master -> User</code>.
				</p>
			</div>
		</div>
	</div>
</div>

<div id="modal-fade" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="m-0 font-weight-bold text-gray-800">Tambah <?= $title; ?></h6>
			</div>
			<div class="modal-body">
				<form id="form-validation" action="<?= site_url('pegawai/tambah') ?>" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label>ID Pegawai</label>
						<small>(Tidak dapat diedit setelah disimpan)</small>
						<input class="form-control <?= (form_error('nik') ? "is-invalid" : "") ?>" name="nik" placeholder="User ID / NIP / NIK">
						<div class="invalid-feedback">
							<?= form_error('nik'); ?>
						</div>
					</div>

					<div class="form-group">
						<label>Nama</label>
						<input class="form-control <?= (form_error('nama') ? "is-invalid" : "") ?>" name="nama" placeholder="">
						<div class="invalid-feedback">
							<?= form_error('nama'); ?>
						</div>
					</div>

					<div class="form-group">
						<label>Email</label>
						<input class="form-control <?= (form_error('email') ? "is-invalid" : "") ?>" name="email" placeholder="">
						<div class="invalid-feedback">
							<?= form_error('email'); ?>
						</div>
					</div>

					<div class="form-group">
						<label>Telepon (WA)</label>
						<input class="form-control <?= (form_error('telp') ? "is-invalid" : "") ?>" name="telp" placeholder="">
						<div class="invalid-feedback">
							<?= form_error('telp'); ?>
						</div>
					</div>

					<div class="form-group">
						<label>Jabatan</label>
						<?= form_dropdown('id_jabatan', $dd_jabatan, set_value('id_jabatan'), ' class="form-control ' . (form_error('id_jabatan') ? "is-invalid" : "") . ' "'); ?>
						<div class="invalid-feedback">
							<?= form_error('id_jabatan'); ?>
						</div>
					</div>

					<div class="form-group">
						<label>Departemen</label>
						<?= form_dropdown('id_departemen', $dd_departemen, set_value('id_departemen'), ' id="id_departemen"  class="form-control ' . (form_error('id_departemen') ? "is-invalid" : "") . ' "'); ?>
						<div class="invalid-feedback">
							<?= form_error('id_departemen'); ?>
						</div>
					</div>

					<div class="form-group">
						<label>Sub Departemen</label>
						<div id="div-order">
							<?= form_dropdown('id_bagian_departemen', $dd_bagian_departemen, set_value('id_bagian_departemen'), ' class="form-control ' . (form_error('id_bagian_departemen') ? "is-invalid" : "") . ' "'); ?>
							<div class="invalid-feedback">
								<?= form_error('id_bagian_departemen'); ?>
							</div>
						</div>
					</div>

					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Tutup</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData) {
		Swal.fire(
			'Sukses!',
			'Pegawai Berhasil ' + flashData,
			'success'
		)
	}

	$('.hapus').on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Apa kamu yakin?',
			text: "Pegawai ini akan dihapus",
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
</script>