<script language="javascript" type="text/javascript">
	$(document).ready(function() {

		$("#id_departemen").change(function() {
			// Put an animated GIF image insight of content

			var data = {
				id_departemen: $("#id_departemen").val()
			};
			$.ajax({
				type: "POST",
				url: "<?= base_url() . 'select/select_subdept' ?>",
				data: data,
				success: function(msg) {
					$('#div-order').html(msg);
				}
			});
		});

	});
</script>

<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">
				Edit Data Pegawai: <?= $nik ?>
			</h6>
		</div>

		<div class="card-body">
			<form action="<?= site_url('pegawai/update/' . $nik) ?>" method="post">

				<div class="form-group">
					<label>Nama</label>
					<input class="form-control <?= (form_error('nama') ? "is-invalid" : "") ?>" name="nama" value="<?= $nama ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('nama'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Email</label>
					<input class="form-control <?= (form_error('email') ? "is-invalid" : "") ?>" name="email" value="<?= $email ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('email'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Telepon (WA)</label>
					<input class="form-control <?= (form_error('telp') ? "is-invalid" : "") ?>" name="telp" value="<?= $telp ?>"></input>
					<div class="invalid-feedback">
						<?= form_error('telp'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Jabatan</label>
					<?= form_dropdown('id_jabatan', $dd_jabatan, $id_jabatan, 'class="form-control '.(form_error('id_jabatan') ? "is-invalid" : "").' "'); ?>
					<div class="invalid-feedback">
						<?= form_error('id_jabatan'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Departemen</label>
					<?= form_dropdown('id_departemen', $dd_departemen, $id_departemen, 'id="id_departemen" class="form-control ' . (form_error('id_departemen') ? "is-invalid" : "") . ' "'); ?>
					<div class="invalid-feedback">
						<?= form_error('id_departemen'); ?>
					</div>
				</div>

				<div class="form-group">
					<label>Sub Departemen</label>
					<div id="div-order">
						<?= form_dropdown('id_bagian_departemen', $dd_bagian_departemen, $id_bagian_departemen, ' class="form-control ' . (form_error('id_bagian_departemen') ? "is-invalid" : "") . ' "'); ?>
						<div class="invalid-feedback">
							<?= form_error('id_bagian_departemen'); ?>
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('pegawai') ?>'">Batal</button>

			</form>
		</div>
	</div>
</div>