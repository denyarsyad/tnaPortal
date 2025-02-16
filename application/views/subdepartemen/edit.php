<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-gray-800">
				Edit Data Sub Departemen: <?= $nama_bagian_dept ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('subdepartemen/update/' . $id_bagian_dept) ?>" method="post">

				<div class="form-group">
					<label>Nama Sub Departemen</label>
					<input class="form-control <?= (form_error('nama_bagian_dept') ? "is-invalid" : "") ?>" name="nama_bagian_dept" value="<?= $nama_bagian_dept ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('nama_bagian_dept'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Department</label>
					<?= form_dropdown('id_departemen', $dd_departemen, $id_departemen, 'class="form-control ' . (form_error('id_departemen') ? "is-invalid" : "") . ' " '); ?>
					<div class="invalid-feedback">
						<?= form_error('id_departemen'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('subdepartemen') ?>'">Batal</button>
			</form>
		</div>
	</div>
</div>