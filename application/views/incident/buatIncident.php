<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		$("#id_kategori").change(function() {
			var data = {
				id_kategori: $("#id_kategori").val()
			};
			$.ajax({
				type: "POST",
				url: "<?= site_url('select/select_sub') ?>",
				data: data,
				success: function(msg) {
					$('#div-order').html(msg);
				}
			});
		});

	});
</script>

<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-3">Kirim Data Incident.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Incident <?= $dd_dept ?></h6>
		</div>
		<div class="card-body">
			<form method="post" action="<?= site_url('incident/submit') ?>" enctype="multipart/form-data">

				<input class="form-control" name="nama" value="<?= $profile['nama'] ?>" hidden>
				<input class="form-control" name="email" value="<?= $profile['email'] ?>" hidden>

				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Target <span class="text-danger small">*Required</span></label>
							<?= form_dropdown('id_dept', $dd_dept, set_value('id_dept'), 'id="id_dept" class="form-control ' . (form_error('id_dept') ? "is-invalid" : "") . ' "'); ?>
							<div class="invalid-feedback">
								<?= form_error('id_dept'); ?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="mb-1 font-weight-bold">Problem <span class="text-danger small">*Required</span></label>
					<textarea name="problem" placeholder="" class="form-control <?= (form_error('problem') ? "is-invalid" : "") ?>" rows="6"><?= set_value('problem'); ?></textarea>
					<div class="invalid-feedback">
						<?= form_error('problem'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Lampiran (Media) <span class="text-info small">*Optional</span></label> </br>
					<p class="small mb-3">Maksimal ukuran 25MB. Format file: gif, jpg, png, or pdf.</p>
					<input type="file" name="path_photo" size="20" class="<?= (form_error('path_photo') ? "is-invalid" : "") ?>">
					<div class="invalid-feedback">
						<?= form_error('path_photo'); ?>
					</div>
					<div class="text-danger pt-1"><?= $error; ?></div>
				</div>

				<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> Submit</button>

			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData) {
		Swal.fire({
			icon: 'error',
			title: flashData,
			text: 'Something went wrong! file is more than 25MB or not supported format',
			footer: ''
		})
	}

	$('textarea').keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			var s = $(this).val();
			$(this).val(s + "\n");
		}
	});
</script>