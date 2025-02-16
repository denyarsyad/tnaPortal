<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?> #<?= $detail['id_ticket'] ?></h1>

	<div class="card shadow mb-4">
		<div class="card-body">
			<form method="post" action="<?= site_url('ticket/reject/' . $detail['id_ticket']) ?>" enctype="multipart/form-data">
				<div class="form-group">
					<label class="mb-1 font-weight-bold text-gray-800">Penerima</label>
					<input class="form-control" name="reciepent" readonly value="<?= $detail['email'] ?>">
				</div>

				<div class="form-group">
					<label class="mb-1 font-weight-bold text-gray-800">Subjek</label>
					<input class="form-control" name="subject" readonly value="<?= $detail['id_ticket'] ?>">
				</div>

				<div class="form-group">
					<h6 class="mb-2 font-weight-bold text-gray-800">Alasan</h6>
					<div class="alert alert-warning text-dark" role="alert">
						<p class="mb-0" style="font-size: 14px;">
							<i class="fas fa-exclamation-circle"></i> Masukkan alasan mengapa tiket ini ditolak.
						</p>
					</div>
					<textarea name="message" class="form-control <?= (form_error('message') ? "is-invalid" : "") ?>" rows="8" id="desk"></textarea>
					<div class="invalid-feedback">
						<?= form_error('message'); ?>
					</div>
				</div>

				<button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
				<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('ticket/list_approve') ?>'">Batal</button>
			</form>
		</div>
	</div>
</div>