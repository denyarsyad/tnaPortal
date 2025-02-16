<script type="text/javascript" language="javascript">
	$(document).ready(function() {
		$('#id_kategori').attr('disabled', true);
		$('#id_sub_kategori').attr('disabled', true);
		$('#diagnos').on('keyup', function() {
			if ($(this).val().length > 0) {
				$('#id_kategori').attr('disabled', false);
				$('#id_sub_kategori').attr('disabled', false);
			} else {
				$('#id_kategori').attr('disabled', true);
				$('#id_sub_kategori').attr('disabled', true);
			}
		});
	});
</script>
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
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?> #<?= $detail['id_ticket'] ?></h1>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>
	<div class="flash-data1" data-flashdata="<?= $this->session->flashdata('status1') ?>"></div>

	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ganti Kategori</a>
		</li>
		<li class="nav-item" role="presentation">
			<a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="false">Detail Tiket</a>
		</li>
	</ul>

	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			<div class="card shadow mb-4">
				<div class="card-body">
					<h5 class="mb-3 font-weight-bold text-primary">
						Form Ganti Kategori
					</h5>
					<h6 class="m-0 font-weight-bold text-primary">Kategori saat ini</h6>
					<div class="font-weight-bold">
						<?= $detail['nama_kategori'] . " (" . $detail['nama_sub_kategori'] . ")" ?><br>
					</div>
					<hr>
					<form method="post" action="<?= site_url('ticket_teknisi/change/' . $detail['id_ticket']) ?>" enctype="multipart/form-data">
						<div class="form-group">
							<h6 class="mb-2 font-weight-bold text-primary">Diagnosa anda <span class="text-danger small">*Required</span></h6>
							<textarea name="diagnos" class="form-control <?= (form_error('diagnos') ? "is-invalid" : "") ?>" rows="6" id="diagnos"><?= set_value('diagnos'); ?></textarea>
							<div class="invalid-feedback">
								<?= form_error('diagnos'); ?>
							</div>
						</div>
						<hr>
						<h6 class="mb-2 font-weight-bold text-primary">Kategori <span class="text-danger small">*Required</span></h6>
						<p class="mb-2 small text-muted">*Tulis Diagnosa anda sebelum memilih Kategori baru.</p>
						<div class="form-group">
							<?= form_dropdown('id_kategori', $dd_kategori, set_value('id_kategori'), 'id="id_kategori" class="form-control ' . (form_error('id_kategori') ? "is-invalid" : "") . '"'); ?>
							<div class="invalid-feedback">
								<?= form_error('id_kategori'); ?>
							</div>
						</div>
						<hr>
						<h6 class="mb-2 font-weight-bold text-primary">Sub Kategori <span class="text-danger small">*Required</span></h6>
						<div class="form-group">
							<div id="div-order">
								<?= form_dropdown('id_sub_kategori', $dd_sub_kategori, set_value('id_sub_kategori'), 'id="id_sub_kategori" class="form-control ' . (form_error('id_sub_kategori') ? "is-invalid" : "") . '"'); ?>
								<div class="invalid-feedback">
									<?= form_error('id_kategori'); ?>
								</div>
							</div>

						</div>
						<hr>
						<div class="form-group mb-4">
							<h6 class="m-0 font-weight-bold text-primary">Lampiran (Media) <span class="text-danger small">*Required</span></h6>
							<p class="small text-muted mb-2">Maks. Size 25 MB. Format file: gif, jpg, png, or pdf.</p>
							<input type="file" name="filediagnosa" class="<?= (form_error('filediagnosa') ? "is-invalid" : "") ?>">
							<div class="invalid-feedback">
								<?= form_error('filediagnosa'); ?>
							</div>
						</div>

						<button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim</button>
						<button type="button" class="btn btn-danger" onclick="window.location='<?= site_url('ticket_teknisi/detail_update/' . $detail['id_ticket']) ?>'">Batal</button>
					</form>
				</div>
			</div>

		</div>
		<div class="tab-pane fade" id="detail" role="tabpanel" aria-labelledby="detail-tab">
			<div class="card shadow mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<h5 class="mb-3 font-weight-bold text-dark">
								Ticket Information
							</h5>
							<div class="card">
								<div class="card-body">
									<h6 class="m-0 text-primary">Pemohon</h6>
									<div class="font-weight-bold">
										<?= $detail['nama'] ?><br>
									</div>
									<hr>
									<h6 class="m-0 text-primary">Email</h6>
									<div class="font-weight-bold">
										<?= $detail['email'] ?><br>
									</div>
									<hr>
									<h6 class="m-0 text-primary">Departemen</h6>
									<div class="font-weight-bold">
										<?= $detail['nama_dept'] . " (" . $detail['nama_bagian_dept'] . ")" ?><br>
									</div>
									<hr>
									<h6 class="m-0 text-primary">Tanggal</h6>
									<div class="font-weight-bold">
										<?= $detail['tanggal'] ?><br>
									</div>
									<hr>
									<h6 class="m-0 text-primary">Lokasi</h6>
									<div class="font-weight-bold">
										<?= $detail['lokasi'] ?><br>
									</div>
									<hr>
									<h6 class="m-0 text-primary">Kategori</h6>
									<div class="font-weight-bold">
										<?= $detail['nama_kategori'] . " (" . $detail['nama_sub_kategori'] . ")" ?><br>
									</div>
									<hr>
									<h6 class="m-0 text-primary">Prioritas</h6>
									<div class="font-weight-bold">
										<?php if ($detail['id_prioritas'] == 0) { ?>
											Will be determined
										<?php } else { ?>
											<div style="color: <?= $detail['warna'] ?>">
												<i class="fas fa-exclamation-triangle"></i>
												<?= $detail['nama_prioritas'] ?> - <?= $detail['waktu_respon'] ?> Day
											</div>
										<?php } ?>
									</div>
									<hr>
									<h6 class="m-0text-primary">Progress <span class="float-right text-primary"><?= $detail['progress'] ?>%</span></h6>
									<div class="progress mb-4">
										<div class="progress-bar" role="progressbar" style="width: <?= $detail['progress'] ?>%" aria-valuenow="<?= $detail['progress'] ?>" aria-valuemin="0" aria-valuemax="100">
										</div>
									</div>
								</div>
							</div>

							<br />

							<h6 class="mb-2 font-weight-bold text-primary">Attachment</h6>
							<?php if (pathinfo($detail['filefoto'], PATHINFO_EXTENSION) == 'pdf') { ?>
								<a href="<?= base_url('uploads/' . $detail['filefoto']) ?>" class="btn btn-light btn-icon-split">
									<span class="icon text-gray-600">
										<i class="fas fa-file-pdf"></i>
									</span>
									<span class="text"><?= $detail['filefoto'] ?></span>
								</a>
							<?php } else { ?>
								<a data-fancybox="gallery" href="<?= base_url('uploads/' . $detail['filefoto']) ?>">
									<img src="<?= base_url('uploads/' . $detail['filefoto']) ?>" style="width:100%;max-width:300px">
								</a><br>
								Click image to zoom <i class="fas fa-search-plus"></i>
							<?php } ?>
						</div>
						<div class="col-md-8">
							<h5 class="mb-3 font-weight-bold text-dark">Sistem Pelacakan</h5>
							<?php $no = 1;
							foreach ($tracking as $row) { ?>
								<?php if ($no == 1) {
									$no++;
									$bgstatus = 'status-delivered';
								} else {
									$bgstatus = 'status-expired';
								} ?>
								<div class="tracking-item">
									<div class="tracking-icon status-intransit <?= $bgstatus; ?>" data-icon="circle">

									</div>
									<div class="tracking-date">
										<div class="font-weight-bold"><?= $row->tanggal ?></div>
									</div>
									<div class="tracking-content">
										<div class="font-weight-bold text-primary"><?= $row->status ?></div>
										<h4 class="small font-weight-bold">Oleh: <?= $row->nama ?></h4>
										<?php if ($row->filefoto != "") { ?>
											<?php if (pathinfo($row->filefoto, PATHINFO_EXTENSION) == 'pdf') { ?>
												<p><?= nl2br($row->deskripsi) ?></p>
												<a href="<?= base_url('files/teknisi/' . $row->filefoto) ?>" class="btn btn-light btn-icon-split">
													<span class="icon text-gray-600">
														<i class="fas fa-file-pdf"></i>
													</span>
													<span class="text"><?= $row->filefoto ?></span>
												</a>
											<?php } else { ?>
												<p><?= nl2br($row->deskripsi) ?></p>
												<a data-fancybox="gallery" href="<?= base_url('files/teknisi/' . $row->filefoto) ?>">
													<img src="<?= base_url('files/teknisi/' . $row->filefoto) ?>" style="width:100%;max-width:300px">
												</a><br>
												Click to zoom <i class="fas fa-search-plus"></i>
											<?php } ?>
										<?php } else {
											echo nl2br($row->deskripsi);
										} ?>
										<?php if ($row->signature != "") { ?>
											<hr />
											<p>Tanda Tangan</p>
											<img src="<?= base_url('files/teknisi/signature/' . $row->signature) ?>" style="width:100%;max-width:150px">
										<?php } ?>
									</div>
								</div>
							<?php $no++;
							} ?>

							<hr />

							<h5 class="mb-3 font-weight-bold text-dark"><?= " Diproses Oleh " . $detail['nama_teknisi'] ?></h5>
							<h6 class="font-weight-bold text-primary">Progress <span class="float-right text-primary"><?= $detail['progress'] ?>%</span></h6>
							<div class="progress mb-4">
								<div class="progress-bar" role="progressbar" style="width: <?= $detail['progress'] ?>%" aria-valuenow="<?= $detail['progress'] ?>" aria-valuemin="0" aria-valuemax="100">
								</div>
							</div>
							<hr>
							<h6 class="m-0 font-weight-bold text-primary">Tanggal Deadline</h6>
							<div class="font-weight-bold">
								<?php if ($detail['deadline'] == "0000-00-00 00:00:00") {
									echo "Belum diset";
								} else { ?>
									<?= $detail['deadline']; ?>
								<?php } ?><br>
							</div>
							<hr>
							<h6 class="m-0 font-weight-bold text-primary">Tanggal Proses</h6>
							<div class="font-weight-bold">
								<?php if ($detail['tanggal_proses'] == "0000-00-00 00:00:00") {
									echo "Belum dimulai";
								} else { ?>
									<?= $detail['tanggal_proses']; ?>
								<?php } ?><br>
							</div>
							<hr>
							<h6 class="m-0 font-weight-bold text-primary">Tanggal Selesai (Solved)</h6>
							<div class="font-weight-bold">
								<?php if ($detail['tanggal_solved'] == "0000-00-00 00:00:00") {
									echo "Belum selesai";
								} else { ?>
									<?= $detail['tanggal_solved']; ?>
								<?php } ?><br>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData) {
		Swal.fire({
			icon: 'error',
			title: 'Error',
			text: flashData,
			footer: ''
		})
	}

	const flashData1 = $('.flash-data1').data('flashdata');
	if (flashData1) {
		Swal.fire({
			icon: 'warning',
			title: 'Warning',
			text: flashData1,
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