<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-3"><?= $desc; ?></p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status')?>"></div>
	<div class="flash-data1" data-flashdata="<?= $this->session->flashdata('status1')?>"></div>

	<!-- Datatable -->
	<div class="row">
		<div class="col-xl-12 col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header font-weight-bold text-primary">
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>No</th>
									<th>No Ticket</th>
									<th>Tanggal</th>
									<th>Nama</th>
									<th>Sub Kategori</th>
									<th>Due date</th>
									<th>Lokasi</th>
									<th>Prioritas</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($tugas as $row) { ?>
									<tr>
										<td><?= $no ?></td>
										<td><a href="<?= site_url('ticket_spv/detail_approve/'.$row->id_ticket)?>" title="Detail Tiket <?= $row->id_ticket; ?>" class="font-weight-bold"><?= $row->id_ticket ?></a></td>
										<td><?= $row->tanggal ?></td>
										<td><?= $row->nama ?></td>
										<td><?= $row->nama_sub_kategori ?></td>
										<td><?= $row->due_date ?></td>
										<td><?= $row->lokasi ?></td>
										<?php if ($row->id_prioritas == 0) { ?>
											<td>Not set yet</td>
										<?php } else { ?>
											<td style="color: <?= $row->warna ?>"><?= $row->nama_prioritas ?></td>
										<?php } ?>
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
										<?php } else if ($row->status == 8) { ?>
											<td>
												<strong style="color: #36454F;">Approved Supervisor</strong>
											</td>
										<?php } else if ($row->status == 9) { ?>
											<td>
												<strong style="color:rgb(11, 167, 57);">Assign by Manager</strong>
											</td>
										<?php } else if ($row->status == 10) { ?>
											<td>
												<strong style="color:rgb(106, 3, 99);">Ticket Returned</strong>
											</td>
										<?php } else if ($row->status == 11) { ?>
											<td>
												<strong style="color:rgb(6, 71, 23);">Approved Manager</strong>
											</td>
										<?php } ?>
									</tr>
								<?php $no++;
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData){
		Swal.fire(
			'Sukses!',
			'Progress Tiket Berhasil ' + flashData,
			'success'
			)
	}

	const flashData1 = $('.flash-data1').data('flashdata');
	if (flashData1){
		Swal.fire(
			'Sukses!',
			'Tiket Berhasil Diperbarui. '+flashData1,
			'success'
			)
	}
</script>