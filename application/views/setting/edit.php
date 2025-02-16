<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Pengaturan: <?= $setting['variable_setting'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('setting/update/' . $setting['id']) ?>" method="post">
				<div class="form-group">
					<label>Value Setting</label>
					<input class="form-control <?= (form_error('value_setting') ? "is-invalid" : "") ?>" name="value_setting" value="<?= $setting['value_setting'] ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('value_setting'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('setting') ?>'">Batal</button>

			</form>
		</div>
	</div>
</div>