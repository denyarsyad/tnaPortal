<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-4">Daftar semua tiket yang sudah kamu submit.</p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status')?>"></div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>No Ticket</th>
							<th>Prioritas</th>
							<th>Tanggal</th>
							<th>Kategori</th>
							<th>Lokasi</th>
							<th>Subjek</th>
							<th>Last Update</th>
							<th>Teknisi</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($ticket as $row){?>
							<tr>
								<td><?= $no ?></td>
								<td><a href="<?= site_url('ticket_user/detail/'.$row->id_ticket)?>" class="font-weight-bold" title="Detail"><?= $row->id_ticket?></a></td>
								<?php if ($row->status == 0){?>
									<td style="text-align: center">Ditolak</td>
								<?php }else{?>
									<?php if($row->id_prioritas == 0) {?>
										<td style="text-align: center">Akan ditentukan</td>
									<?php } else { ?>
										<td class="font-weight-bold" style="color: <?= $row->warna?>; text-align: center"><?= $row->nama_prioritas?></td>
									<?php } ?>
								<?php }?>
								<td><?= $row->tanggal?></td>
								<td><?= $row->nama_kategori?> (<?= $row->nama_sub_kategori?>)</td>
								<td><?= $row->lokasi?></td>
								<td><?= $row->problem_summary?></td>
								<td><?= $row->last_update?></td>
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
								<?php } else if ($row->status == 1) {?>
									<td>
										<strong style="color: #946038;">Ticket Submited</strong>
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
			'Tiket Helpdesk anda berhasil ' + flashData,
			'success'
			)
	}
</script>