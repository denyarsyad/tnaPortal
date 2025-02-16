<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Data Prioritas: <?= $prioritas['nama_prioritas'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('prioritas/update/' . $prioritas['id_prioritas']) ?>" method="post">
				<div class="form-group">
					<label>Nama Prioritas</label>
					<input class="form-control <?= (form_error('nama_prioritas') ? "is-invalid" : "") ?>" name="nama_prioritas" value="<?= $prioritas['nama_prioritas'] ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('nama_prioritas'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Waktu Resolusi <code>*(Day)</code></label>
					<input class="form-control <?= (form_error('waktu_respon') ? "is-invalid" : "") ?>" name="waktu_respon" value="<?= $prioritas['waktu_respon'] ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('waktu_respon'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Color</label>
					<input type="color" class="form-control <?= (form_error('warna') ? "is-invalid" : "") ?>" name="warna" value="<?= $prioritas['warna'] ?>">
					<div class="invalid-feedback">
						<?= form_error('warna'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('prioritas') ?>'">Batal</button>

			</form>
		</div>
	</div>
</div>