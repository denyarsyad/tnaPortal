<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold">Tiket Baru #<?= $detail['id_ticket'] ?></h1>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Detail Tiket</a>
		</li>
		<li class="nav-item" role="presentation">
			<a class="nav-link" id="lacak-tab" data-toggle="tab" href="#lacak" role="tab" aria-controls="lacak" aria-selected="false">Sistem Lacak</a>
		</li>
		<li class="nav-item" role="presentation">
			<a class="nav-link" id="proses-tab" data-toggle="tab" href="#proses" role="tab" aria-controls="proses" aria-selected="false"><?= " Diproses oleh " . $detail['nama_teknisi'] ?></a>
		</li>
	</ul>
	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			<div class="card shadow mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<h5 class="mb-3 font-weight-bold text-dark">
								Ticket Information
							</h5>
							<div class="card">
								<div class="card-header font-weight-bold">
									Aksi:
									<?php if ($detail['status'] == 0) { ?>
										No Action
									<?php } else if ($detail['status'] == 1) { ?>
										<!-- <a href="<?//= site_url('ticket/detail_approve/' . $detail['id_ticket']) ?>" class="btn btn-primary" title="Detail">
											<i class="fas fa-search"></i>
										</a> -->
										<a href="<?= site_url('ticket/set_prioritas/' . $detail['id_ticket']) ?>" class="btn btn-success aprove" title="Approve">
											<i class="fas fa-check"></i> Terima
										</a>
										<a href="<?= site_url('ticket/detail_reject/' . $detail['id_ticket']) ?>" class="btn btn-danger reject" title="Reject">
											<i class="fas fa-times"></i> Tolak
										</a>
									<?php } else if ($detail['status'] == 2) { ?>
										<a href="<?= site_url('ticket/detail_approve/' . $detail['id_ticket']) ?>" class="btn btn-primary" title="Detail">
											<i class="fas fa-search"></i> Detail
										</a>
										<!-- <a href="<?//= site_url('ticket/detail_pilih_teknisi/' . $detail['id_ticket']) ?>" class="btn btn-warning text-dark" title="Assign Technician">
											<i class="fas fa-wrench"></i>
										</a> -->
									<?php } ?>
								</div>
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
									<h6 class="m-0 text-primary">Telepon</h6>
									<div class="font-weight-bold">
										<?= $detail['telp'] ?><br>
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
							<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>
							<div class="accordion mb-3" id="accordionReply">
								<div class="card">
									<div class="card-header" id="headingOne">
										<h2 class="mb-0">
											<button class="btn btn-link btn-block text-left font-weight-bold" type="button" aria-expanded="true" aria-controls="collapseOne" disabled>
												<i class="fas fa-pencil-alt"></i> Reply
											</button>
										</h2>
									</div>

									<div id="collapseOne" class="collapse <?= (form_error('message') ? "show" : "") ?>" aria-labelledby="headingOne" data-parent="#accordionReply">
										<div class="card-body">

										</div>
									</div>
								</div>
							</div>

							<!-- Message dari tabel ticket_message -->
							<?php
							foreach ($message as $row) { ?>
								<div class="card <?= ($row->level != 'User' ? "border-primary" : "") ?> mb-3">
									<div class="card-header <?= ($row->level != 'User' ? "border-primary" : "") ?>">
										<i class="fas fa-fw fa-user <?= ($row->level != 'User' ? "text-primary" : "") ?>"></i> <span class="font-weight-bold text-dark"><?= $row->nama ?></span><br />
										<span><?= $row->level ?></span>
										<span class="float-right"><?= $row->tanggal ?></span>
									</div>
									<div class="card-body">
										<p class="card-text <?= ($row->level != 'User' ? "text-primary" : "") ?>"><?= nl2br($row->message); ?></p>
										<?php if ($row->filefoto != '') : ?>
											<a data-fancybox="gallery" href="<?= base_url('uploads/' . $row->filefoto) ?>">
												<img src="<?= base_url('uploads/' . $row->filefoto) ?>" style="width:100%;max-width:300px">
											</a>
										<?php endif; ?>
									</div>
								</div>
							<?php } ?>

							<!-- Subjek dan Deskripsi dari User -->
							<div class="card">
								<div class="card-header">
									<i class="fas fa-fw fa-user"></i> <span class="font-weight-bold text-dark"><?= $detail['nama'] ?></span><br />
									User
									<span class="float-right"><?= $detail['tanggal'] ?></span>
								</div>
								<div class="card-body">
									<h5 class="card-title"><?= $detail['problem_summary'] ?></h5>
									<p class="card-text"><?= nl2br($detail['problem_detail']) ?></p>
								</div>
							</div>
							<!-- -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="lacak" role="tabpanel" aria-labelledby="lacak-tab">
			<div class="card shadow-sm border-0 mb-4">
				<div class="card-body">
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
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="proses" role="tabpanel" aria-labelledby="proses-tab">
			<div class="card shadow-sm border-0 mb-4">
				<div class="card-body">
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

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData) {
		Swal.fire(
			'Sukses!',
			'Ticket Telah ' + flashData,
			'success'
		)
	}

	$('.aprove').on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Apa kamu yakin?',
			text: "Tiket ini akan diterima (Approve)",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Terima'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	});

	$('.reject').on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Apa kamu yakin?',
			text: "Tiket ini akan ditolak",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Tolak'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	});
</script>