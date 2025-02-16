<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Pengaturan: <?= $setting['variable_setting'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('setting/upload_file/' . $setting['id']) ?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Upload New Image</label>
					<br />
					<img src="<?= base_url('assets/img/') . $setting['value_setting']; ?>" width="150"><br /><br />
					<input type="file" name="value_setting" class="<?= (form_error('value_setting') ? "is-invalid" : "") ?>"><br />
					<div class="invalid-feedback">
						<?= form_error('value_setting'); ?>
					</div>
					<div class="text-danger pt-1"><?= $error; ?></div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('setting') ?>'">Batal</button>

			</form>
		</div>
	</div>
</div>