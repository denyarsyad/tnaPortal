<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Data Informasi: <?= $informasi['subject'] ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('informasi/update/' . $informasi['id_informasi']) ?>" method="post">
				<div class="form-group">
					<label>Subyek</label>
					<input class="form-control <?= (form_error('subject') ? "is-invalid" : "") ?>" name="subject" value="<?=$informasi['subject'] ?>">
					<div class="invalid-feedback">
						<?= form_error('subject'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Informasi</label>
					<textarea class="form-control <?= (form_error('pesan') ? "is-invalid" : "") ?>" name="pesan" rows="3"><?=$informasi['pesan'] ?></textarea>
					<div class="invalid-feedback">
						<?= form_error('pesan'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('informasi') ?>'">Batal</button>
			</form>
		</div>
	</div>
</div>