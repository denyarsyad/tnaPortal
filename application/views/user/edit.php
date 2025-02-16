<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">
				Edit Data User: <?= $username ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('user/update/' . $id_user) ?>" method="post">
				<div class="form-group">
					<label>Level</label>
					<?= form_dropdown('id_level', $dd_level, $id_level, ' id="id_level" class="form-control ' . (form_error('id_level') ? "is-invalid" : "") . ' "'); ?>
					<div class="invalid-feedback">
						<?= form_error('id_level'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('user') ?>'">Batal</button>
			</form>
		</div>
	</div>
</div>