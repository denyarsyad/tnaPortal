<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>
	<div class="flash-data1" data-flashdata="<?= $this->session->flashdata('status1') ?>"></div>

	<div class="card card-body">
		<form action="<?= site_url('user/updatepass') ?>" method="post">
			<div class="form-group">
				<label>Password Lama</label>
				<input type="password" name="password_lama" class="form-control <?= (form_error('password_lama') ? "is-invalid" : "") ?>">
				<div class="invalid-feedback">
					<?= form_error('password_lama'); ?>
				</div>
			</div>

			<div class="form-group">
				<label>Password Baru</label>
				<input type="password" name="password" class="form-control <?= (form_error('password') ? "is-invalid" : "") ?>">
				<div class="invalid-feedback">
					<?= form_error('password'); ?>
				</div>
			</div>

			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" name="password2" class="form-control <?= (form_error('password2') ? "is-invalid" : "") ?>">
				<div class="invalid-feedback">
					<?= form_error('password2'); ?>
				</div>
			</div>

			<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
			<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('dashboard') ?>'">Batal</button>
		</form>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	const flashData1 = $('.flash-data1').data('flashdata');
	if (flashData) {
		Swal.fire(
			'Success!',
			'Password Berhasil ' + flashData,
			'success'
		)
	}
	if (flashData1) {
		Swal.fire({
			icon: 'error',
			title: 'Error',
			text: flashData1,
			footer: ''
		})
	}
</script>