<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Data Departemen: <?= $departemen['nama_dept'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('departemen/update/' . $departemen['id_dept']) ?>" method="post">
				<div class="form-group">
					<label>Nama Departemen</label>
					<input class="form-control <?= (form_error('nama_dept') ? "is-invalid" : "") ?>" name="nama_dept" value="<?= $departemen['nama_dept'] ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('nama_dept'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('departemen') ?>'">Batal</button>

			</form>
		</div>
	</div>
</div>