<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Data Lokasi: <?= $lokasi['lokasi'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('lokasi/update/' . $lokasi['id_lokasi']) ?>" method="post">
				<div class="form-group">
					<label>Nama Lokasi</label>
					<input class="form-control <?= (form_error('lokasi') ? "is-invalid" : "") ?>" name="lokasi" value="<?= $lokasi['lokasi'] ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('lokasi'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('lokasi') ?>'">Batal</button>

			</form>
		</div>
	</div>
</div>