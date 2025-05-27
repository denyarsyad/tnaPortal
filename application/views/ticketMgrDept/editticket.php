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
	<p class="mb-3">Perbaiki dan kirim ulang masalah Anda kepada team Maintenance.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Work Order's</h6>
		</div>
		<div class="card-body">
			<form method="post" action="<?= site_url('ticket_mgrd/update') ?>" enctype="multipart/form-data">

				<input class="form-control" name="nama" value="<?= $profile['nama'] ?>" hidden>
				<input class="form-control" name="email" value="<?= $profile['email'] ?>" hidden>

				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Kategori<span class="text-danger small">*Required</span></label>
							<?= form_dropdown('id_kategori', $dd_kategori, set_value('id_kategori', $detail['id_kategori']), 'id="id_kategori" class="form-control ' . (form_error('id_kategori') ? "is-invalid" : "") . ' "'); ?>
							<div class="invalid-feedback">
								<?= form_error('id_kategori'); ?>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Sub Kategori <?= $detail['id_sub_kategori'] ?><span class="text-danger small">*Required</span></label>
							<div id="div-order">
								<?= form_dropdown('id_sub_kategori', $dd_sub_kategori, set_value('id_sub_kategori', $detail['id_sub_kategori']), ' class="form-control ' . (form_error('id_sub_kategori') ? "is-invalid" : "") . ' "'); ?>
								<div class="invalid-feedback">
									<?= form_error('id_sub_kategori'); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label class="mb-1 font-weight-bold">Lokasi <span class="text-danger small">*Required</span></label>
							<?= form_dropdown('id_lokasi', $dd_lokasi, set_value('id_lokasi', $detail['id_lokasi']), ' class="form-control ' . (form_error('id_lokasi') ? "is-invalid" : "") . '" '); ?>
							<div class="invalid-feedback">
								<?= form_error('id_lokasi'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-5" style="padding-left: 0px;">
					<label class="mb-1 font-weight-bold">Due date <span class="text-danger small">*Required</span></label>
					<input class="form-control <?= (form_error('due_date') ? "is-invalid" : "") ?>" name="due_date" placeholder="Due date" value="<?= set_value('due_date', $detail['due_date']) ?>">
					<p class="small mb-6">contoh : 1 jam/1hari/ '0' jika tidak ada target pengerjaan</p>
					<div class="invalid-feedback">
						<?= form_error('due_date'); ?>	
					</div>
				</div>
				<div class="form-group">
					<label class="mb-1 font-weight-bold">Subjek <span class="text-danger small">*Required</span></label>
					<input class="form-control <?= (form_error('problem_summary') ? "is-invalid" : "") ?>" name="problem_summary" placeholder="Judul" value="<?= set_value('problem_summary', $detail['problem_summary']); ?>">
					<div class="invalid-feedback">
						<?= form_error('problem_summary'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="mb-1 font-weight-bold">Deskripsi <span class="text-danger small">*Required</span></label>
					<textarea name="problem_detail" placeholder="" class="form-control <?= (form_error('problem_detail') ? "is-invalid" : "") ?>" rows="6"><?= set_value('problem_detail', $detail['problem_detail']); ?></textarea>
					<div class="invalid-feedback">
						<?= form_error('problem_detail'); ?>
					</div>
				</div>

				<div class="form-group">
					<!-- <label class="mb-1 font-weight-bold">Lampiran (Media) <span class="text-danger small">*Opsional</span></label> </br>
					<p class="small mb-3">Maksimal ukuran 25MB. Format file: gif, jpg, png, or pdf.</p>
					<input type="file" name="filefoto" size="20" class="<?= (form_error('filefoto') ? "is-invalid" : "") ?>">
					<div class="invalid-feedback">
						<?= form_error('filefoto'); ?>
					</div>
					<div class="text-danger pt-1"><?= $error; ?></div> -->

					<!-- start lampiran -->
					<?php if (!empty($detail['filefoto'])): ?>
						<div class="mt-3">
							<label class="font-weight-bold">Lampiran sebelumnya:</label><br>
							<?php
							$ext = pathinfo($detail['filefoto'], PATHINFO_EXTENSION);
							$file_url = base_url('uploads/' . $detail['filefoto']); // Sesuaikan path foldernya
							if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])):
							?>
								<a data-fancybox="gallery" href="<?= $file_url ?>">
									<img src="<?= $file_url ?>" alt="Attachment" style="max-width: 300px; border: 1px solid #ccc;">
								</a><br>
								<small>Klik gambar untuk memperbesar</small>
							<?php elseif (strtolower($ext) == 'pdf'): ?>
								<a href="<?= $file_url ?>" target="_blank" class="btn btn-light btn-sm mt-2">
									<i class="fas fa-file-pdf"></i> Lihat File PDF
								</a>
							<?php else: ?>
								<p class="text-muted">File tidak bisa ditampilkan.</p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<!-- end lampiran -->

				</div>

				<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-check"></i> Update</button>

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