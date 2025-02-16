<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800 font-weight-bold"><?= $title; ?></h1>
	<p class="mb-3"><?= $desc; ?></p>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status')?>"></div>
	<div class="flash-data1" data-flashdata="<?= $this->session->flashdata('status1')?>"></div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>No Tiket</th>
							<th>Aksi</th>
							<th>Progress</th>
							<th>Prioritas</th>
							<th>Tanggal</th>
							<th>Deadline</th>
							<th>Selesai</th>
							<th>Nama</th>
							<th>Kategori</th>
							<th>Lokasi</th>
							<th>Subjek</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($tugas as $row){?>
							<tr>
								<td><?= $no ?></td>
								<td><a href="<?= site_url('ticket_teknisi/detail_update/'.$row->id_ticket)?>" class="font-weight-bold" title="Update Progress"><?= $row->id_ticket?></a></td>
								<td>
									<?php if($row->status==4)
						        	{?>
						        		<a href="<?= site_url('ticket_teknisi/detail_update/'.$row->id_ticket)?>" class="btn btn-primary btn-circle btn-sm" title="Update Progress">
						        			<i class="fas fa-wrench"></i>
						        		</a>
						        	<?php } else {
						        		echo "<strong style=\"color: #2E6095;\">Selesai</strong>";
						        	}?>
								</td>
								<td><?= $row->progress?>%</td>
								<td class="font-weight-bold" style="color: <?= $row->warna?>; text-align: center"><?= $row->nama_prioritas?></td>
								<td><?= $row->tanggal?></td>
								<td><?= $row->deadline?></td>
								<td>
								    <?php if($row->tanggal_solved == "0000-00-00 00:00:00"){
								        echo "Not solve yet";
								    }else{
								        echo "$row->tanggal_solved";
								    } ?>
								</td>
								<td><?= $row->nama?></td>
								<td><?= $row->nama_kategori?> (<?= $row->nama_sub_kategori?>)</td>
								<td><?= $row->lokasi?></td>
								<td><?= $row->problem_summary?></td>
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