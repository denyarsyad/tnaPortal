<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Data Jabatan: <?= $jabatan['nama_jabatan'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('jabatan/update/' . $jabatan['id_jabatan']) ?>" method="post">
				<div class="form-group">
					<label>Nama Jabatan</label>
					<input class="form-control <?= (form_error('nama_jabatan') ? "is-invalid" : "") ?>" name="nama_jabatan" value="<?= $jabatan['nama_jabatan'] ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('nama_jabatan'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('jabatan') ?>'">Batal</button>
			</form>
		</div>
	</div>
</div>