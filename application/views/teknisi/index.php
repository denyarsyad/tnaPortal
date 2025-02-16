<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="block-section">
		<?php 
		if($this->session->flashdata('status') != "") {
			echo '<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Success!</strong> Data Disimpan
			</div>';
		}
		?>

		<?php 
		if($this->session->flashdata('status_del') != "") {
			echo '<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Success!</strong> Data Dihapus
			</div>';
		}
		?>

	</div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Data <?= $title; ?></h6><hr>
			<a href="#modal-fade" title="Tambah <?= $title; ?>" class="btn btn-primary" data-toggle="modal">
				<i class="fa fa-plus"></i> Tambah <?= $title; ?>
			</a>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>ID Number</th>
							<th>Nama</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($teknisi as $row){?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $row->nik?></td>
								<td><?= $row->nama?></td>
								<td>
									<a href="<?= site_url('teknisi/hapus/'.$row->id_teknisi) ?>" onclick="return confirm('Yakin akan menghapus?')" data-toggle="tooltip" title="Hapus <?= $title; ?>" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i>
									</a>
								</td>
							</tr>
						<?php $no++;}?>
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
			<h6 class="m-0 font-weight-bold text-primary">Tambah Teknisi</h6>
		</div>
			<div class="modal-body">
				<form id="form-validation" action="<?= site_url('teknisi/tambah') ?>" method="POST" enctype="multipart/form-data">

					<div class="form-group">
						<label>Pegawai</label>
						<?= form_dropdown('id_pegawai', $dd_pegawai, set_value('id_pegawai'), ' id="id_pegawai" required class="form-control"'); ?>
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="password" placeholder="Input here..." required>
					</div>

					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-danger" class="close" data-dismiss="modal">Tutup</button>	
				</form>
			</div>
		</div>
	</div>
</div>