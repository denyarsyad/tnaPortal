<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-3"><?= $desc; ?></p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>
	<div class="flash-data1" data-flashdata="<?= $this->session->flashdata('status1') ?>"></div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>No Tiket</th>
							<th>Prioritas</th>
							<th>Tanggal</th>
							<th>Deadline</th>
							<th>Nama</th>
							<th>Kategori</th>
							<th>Lokasi</th>
							<th>Subjek</th>
							<th width="60">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($approve as $row) { ?>
							<tr>
								<td><?= $no ?></td>
								<td><a href="<?= site_url('ticket_teknisi/detail_approve/' . $row->id_ticket) ?>" class="font-weight-bold" title="Detail"><?= $row->id_ticket ?></a></td>
								<td class="font-weight-bold" style="color: <?= $row->warna ?>; text-align: center"><?= $row->nama_prioritas ?></td>
								<td><?= $row->tanggal ?></td>
								<td><?= $row->deadline ?></td>
								<td><?= $row->nama ?></td>
								<td><?= $row->nama_kategori ?> (<?= $row->nama_sub_kategori ?>)</td>
								<td><?= $row->lokasi ?></td>
								<td><?= $row->problem_summary ?></td>
								<td>
									<?php if ($row->status == 3) { ?>
										<a href="<?= site_url('ticket_teknisi/approve/' . $row->id_ticket) ?>" class="btn btn-success btn-circle btn-sm process" title="Process Now">
											<i class="fas fa-check"></i>
										</a>
										<a href="<?= site_url('ticket_teknisi/pending/' . $row->id_ticket) ?>" class="btn btn-warning text-dark btn-circle btn-sm pending" title="Pending">
											<i class="fas fa-clock"></i>
										</a>
									<?php } else if ($row->status == 5) { ?>
										<a href="<?= site_url('ticket_teknisi/approve/' . $row->id_ticket) ?>" class="btn btn-success btn-circle btn-sm process" title="Process Now">
											<i class="fas fa-check"></i>
										</a>
									<?php } ?>
								</td>
							</tr>
						<?php $no++;
						} ?>
					</tbody>
				</table>
			</div>
			<br />
			<div class="alert alert-warning text-dark" role="alert">
				<h6 class="font-weight-bold">Informasi!</h6>
				<p class="mb-0" style="font-size: 14px;">
					Silahkan ke menu <code>Dashboard -> Daftar Tugas</code> untuk update progress tiket.
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
			'Tiket dalam status ' + flashData,
			'success'
		)
	}

	const flashData1 = $('.flash-data1').data('flashdata');
	if (flashData1) {
		Swal.fire(
			'Sukses!',
			'Tiket dalam status ' + flashData1,
			'success'
		)
	}

	$('.process').on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Apa kamu yakin?',
			text: "Tiket ini akan diproses",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Process'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	});

	$('.pending').on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');

		Swal.fire({
			title: 'Apa kamu yakin?',
			text: "Tiket ini akan dipending",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Pending'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	});
</script>