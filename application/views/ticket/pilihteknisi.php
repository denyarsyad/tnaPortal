<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('status')?>"></div>
	<div class="flash-data1" data-flashdata="<?= $this->session->flashdata('status1')?>"></div>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-header font-weight-bold text-primary">
			Daftar Tiket
		</div>
		<div class="card-body">
			Klik <code>No Ticket</code> untuk memilih Teknisi.<hr>
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>No Ticket</th>
							<th>Prioritas</th>
							<th>Tanggal</th>
							<th>Deadline</th>
							<th>Nama</th>
							<th>Sub Kategori</th>
							<th>Lokasi</th>
							<th>Subjek</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; foreach ($pilihteknisi as $row){?>
							<tr>
								<td><?= $no ?></td>
								<td>
									<a href="<?= site_url('ticket/detail_pilih_teknisi/'.$row->id_ticket) ?>" title="Klik Teknisi"><?= $row->id_ticket?></a>
								</td>
								<td class="font-weight-bold" style="color: <?= $row->warna?>; text-align: center"><?= $row->nama_prioritas?></td>
								<td><?= $row->tanggal?></td>
								<td><?= $row->deadline?></td>
								<td><?= $row->nama?></td>
								<td><?= $row->nama_sub_kategori?></td>
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
			'Tiket Berhasil ' + flashData + 'ke Teknisi',
			'success'
			)
	}

	const flashData1 = $('.flash-data1').data('flashdata');
	if (flashData1){
		Swal.fire(
			'Success!',
			'Tiket Telah Ditugaskan ke Teknisi. '+flashData1,
			'success'
			)
	}
</script>