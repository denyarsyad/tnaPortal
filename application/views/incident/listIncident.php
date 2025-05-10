<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-4">Daftar semua Incident yang sudah kamu submit.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status')?>"></div>

	<!-- Button Input -->
	<a href="<?= site_url('incident/buat') ?>" class="nav-link"  style="padding-left: 0px;">
		<div class="btn btn-success btn-lg shadow-sm btn-left">
			<i class="fas fa-plus text-white" style="font-size: 15px"></i>
			<span class="text" style="font-size: 15px">Input Incident</span>
		</div>
	</a>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>No Incident</th>
							<th>Tanggal</th>
							<th>Target Dept</th>
							<th>Problem</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($ticket as $row){?>
							<tr>
								<td><?= $no ?></td>
								<td><a href="<?= site_url('incident/detail/'.$row->id_incident)?>" class="font-weight-bold" title="Detail"><?= $row->id_incident?></a></td>
								<td><?= $row->date_incident?></td>
								<td><?= $row->nama_dept?></td>
								<td><?= $row->problem?></td>
								<td style="text-align: center">
								    <?php if($row->status == 0) {
								    	echo "Ditolak";
								    } else {
								    	if($row->teknisi == null){
								    		echo "Akan ditentukan";
								    	} else {
								    		echo "$row->nama_teknisi";
								    	}
								    } ?>
								</td>
								<?php if ($row->status == 0) {?>
									<td>
										<strong style="color: #F36F13;">Ticket Rejected</strong>
									</td>
								<?php } else if ($row->status == "R") {?>
									<td>
										<strong style="color:rgb(19, 133, 8);">Incident Submited</strong>
									</td>
								<?php } else if ($row->status == 2) {?>
									<td>
										<strong style="color: #FFB701;">Category Changed</strong>
									</td>
								<?php } else if ($row->status == 3) {?>
									<td>
										<strong style="color: #A2B969;">Assigned to Technician</strong>
									</td>
								<?php } else if ($row->status == 4) {?>
									<td>
										<strong style="color: #0D95BC;">On Process</strong>
									</td>
								<?php } else if ($row->status == 5) {?>
									<td>
										<strong style="color: #023047;">Pending</strong>
									</td>
								<?php } else if ($row->status == 6) {?>
									<td>
										<strong style="color: #2E6095;">Solve</strong>
									</td>
								<?php } else if ($row->status == 7) {?>
									<td>
										<strong style="color: #C13018;">Late Finished</strong>
									</td>
								<?php } else if ($row->status == 8) { ?>
									<td>
										<strong style="color: #36454F;">Approved Supervisor</strong>
									</td>
								<?php } ?>
								<td>
									<a href="<?= site_url('ticket_user/detail/'.$row->id_ticket)?>" class="btn btn-primary btn-circle btn-sm" title="Detail">
										<i class="fas fa-search"></i>
									</a>
								</td>
							</tr>
						<?php $no++;}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	const flashData = $('.flash-data').data('flashdata');
	if (flashData){
		Swal.fire(
			'Sukses!',
			'Work Order's Maintenance anda berhasil ' + flashData,
			'success'
			)
	}
</script>