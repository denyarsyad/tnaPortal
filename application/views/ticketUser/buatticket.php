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
	<p class="mb-3">Kirim dan simpulkan masalah Anda kepada team Teknisi.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Tiket</h6>
		</div>
		<div class="card-body">
			<form method="post" action="<?= site_url('ticket_user/submit') ?>" enctype="multipart/form-data">

				<input class="form-control" name="nama" value="<?= $profile['nama'] ?>" hidden>
				<input class="form-control" name="email" value="<?= $profile['email'] ?>" hidden>

				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Kategori <span class="text-danger small">*Required</span></label>
							<?= form_dropdown('id_kategori', $dd_kategori, set_value('id_kategori'), 'id="id_kategori" class="form-control ' . (form_error('id_kategori') ? "is-invalid" : "") . ' "'); ?>
							<div class="invalid-feedback">
								<?= form_error('id_kategori'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Sub Kategori <span class="text-danger small">*Required</span></label>
							<div id="div-order">
								<?= form_dropdown('id_sub_kategori', $dd_sub_kategori, set_value('id_sub_kategori'), ' class="form-control ' . (form_error('id_sub_kategori') ? "is-invalid" : "") . ' "'); ?>
								<div class="invalid-feedback">
									<?= form_error('id_sub_kategori'); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Lokasi <span class="text-danger small">*Required</span></label>
							<?= form_dropdown('id_lokasi', $dd_lokasi, set_value('id_lokasi'), ' class="form-control ' . (form_error('id_lokasi') ? "is-invalid" : "") . '" '); ?>
							<div class="invalid-feedback">
								<?= form_error('id_lokasi'); ?>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Subjek <span class="text-danger small">*Required</span></label>
					<input class="form-control <?= (form_error('problem_summary') ? "is-invalid" : "") ?>" name="problem_summary" placeholder="Judul" value="<?= set_value('problem_summary'); ?>">
					<div class="invalid-feedback">
						<?= form_error('problem_summary'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Deskripsi <span class="text-danger small">*Required</span></label>
					<textarea name="problem_detail" placeholder="" class="form-control <?= (form_error('problem_detail') ? "is-invalid" : "") ?>" rows="6"><?= set_value('problem_detail'); ?></textarea>
					<div class="invalid-feedback">
						<?= form_error('problem_detail'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold">Lampiran (Media) <span class="text-danger small">*Opsional</span></label> </br>
					<p class="small mb-3">Maksimal ukuran 25MB. Format file: gif, jpg, png, or pdf.</p>
					<input type="file" name="filefoto" size="20" class="<?= (form_error('filefoto') ? "is-invalid" : "") ?>">
					<div class="invalid-feedback">
						<?= form_error('filefoto'); ?>
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