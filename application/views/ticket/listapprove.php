<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?> (<?= $jml_new; ?>)</h1>
	<p><?= $desc; ?></p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>No Ticket</th>
							<th>Tanggal</th>
							<th>Kategori</th>
							<th>Nama</th>
							<th>Lokasi</th>
							<th>Subjek</th>
							<th>Status</th>
							<th width="60">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($approve as $row) { ?>
							<tr>
								<td><?= $no ?></td>
								<td><a href="<?= site_url('ticket/detail_approve/' . $row->id_ticket) ?>" title="Detail Ticket <?= $row->id_ticket ?>" class="font-weight-bold"><?= $row->id_ticket ?></a></td>
								<td><?= $row->tanggal ?></td>
								<td><?= $row->nama_kategori ?> (<?= $row->nama_sub_kategori ?>)</td>
								<td><?= $row->nama ?></td>
								<td><?= $row->lokasi ?></td>
								<td><?= $row->problem_summary ?></td>
								<?php if ($row->status == 0) { ?>
									<td>
										<strong style="color: #F36F13;">Ticket Rejected</strong>
									</td>
								<?php } else if ($row->status == 1) { ?>
									<td>
										<strong style="color: #946038;">Ticket Submited</strong>
									</td>
								<?php } else if ($row->status == 2) { ?>
									<td>
										<strong style="color: #FFB701;">Category Changed</strong>
									</td>
								<?php } else if ($row->status == 3) { ?>
									<td>
										<strong style="color: #A2B969;">Assigned to Technician</strong>
									</td>
								<?php } else if ($row->status == 4) { ?>
									<td>
										<strong style="color: #0D95BC;">On Process</strong>
									</td>
								<?php } else if ($row->status == 5) { ?>
									<td>
										<strong style="color: #023047;">Pending</strong>
									</td>
								<?php } else if ($row->status == 6) { ?>
									<td>
										<strong style="color: #2E6095;">Solve</strong>
									</td>
								<?php } else if ($row->status == 7) { ?>
									<td>
										<strong style="color: #C13018;">Late Finished</strong>
									</td>
								<?php } ?>
								<td>
									<?php if ($row->status == 0) { ?>
										No Action
									<?php } else if ($row->status == 1) { ?>
										<!-- <a href="<?//= site_url('ticket/detail_approve/' . $row->id_ticket) ?>" class="btn btn-primary btn-circle btn-sm" title="Detail">
											<i class="fas fa-search"></i>
										</a> -->
										<a href="<?= site_url('ticket/set_prioritas/' . $row->id_ticket) ?>" class="btn btn-success btn-circle btn-sm aprove" title="Approve">
											<i class="fas fa-check"></i>
										</a>
										<a href="<?= site_url('ticket/detail_reject/' . $row->id_ticket) ?>" class="btn btn-danger btn-circle btn-sm reject" title="Reject">
											<i class="fas fa-times"></i>
										</a>
									<?php } else if ($row->status == 2) { ?>
										<a href="<?= site_url('ticket/detail_approve/' . $row->id_ticket) ?>" class="btn btn-primary btn-circle btn-sm" title="Detail">
											<i class="fas fa-search"></i>
										</a>
										<a href="<?= site_url('ticket/detail_pilih_teknisi/' . $row->id_ticket) ?>" class="btn btn-warning text-dark btn-circle btn-sm" title="Assign Technician">
											<i class="fas fa-wrench"></i>
										</a>
									<?php } ?>
								</td>
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
			</div>
			<hr>
			<div class="alert alert-warning text-dark" role="alert">
				<h6 class="font-weight-bold">Informasi!</h6>
				<p class="mb-0" style="font-size: 14px;">
				&bull; Untuk Approve Pilih <i class="fas fa-check-circle text-success"></i> lalu klik Terima untuk memilih Prioritas dan menugaskan Teknisi.<br/>
					&bull; Untuk Reject Pilih <i class="fas fa-times-circle text-danger"></i> lalu klik Tolak untuk mengarahkan ke form Alasan Tolak Tiket.
				</p>
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