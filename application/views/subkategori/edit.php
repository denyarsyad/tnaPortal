<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Data Sub Kategori: <?= $nama_sub_kategori ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('subkategori/update/' . $id_sub_kategori) ?>" method="post">
				<div class="form-group">
					<label>Nama Sub Kategori</label>
					<input class="form-control <?= (form_error('nama_sub_kategori') ? "is-invalid" : "") ?>" name="nama_sub_kategori" value="<?= $nama_sub_kategori ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('nama_sub_kategori'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Kategori</label>
					<?= form_dropdown('id_kategori', $dd_kategori, $id_kategori, 'class="form-control ' . (form_error('id_kategori') ? "is-invalid" : "") . ' "'); ?>
					<div class="invalid-feedback">
						<?= form_error('id_kategori'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('subkategori') ?>'">Batal</button>

			</form>
		</div>
	</div>
</div>