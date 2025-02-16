<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold">Dashboard</h1>

	<div class="row">
		<!--Need Approve-->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card bg-light text-dark shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">Tiket Baru</div>
							<div class="h3 mb-0 font-weight-bold"><?= $jml_new ?></div>
							<h4 class="small font-weight-bold">&nbsp;<span></span></h4>
						</div>
						<div class="col-auto">
							<i class="fas fa-clipboard-list fa-2x text-success"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--Semua Tiket-->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card bg-light text-dark shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">Semua Tiket</div>
							<div class="h3 mb-0 font-weight-bold"><?= $jml_ticket ?></div>
							<h4 class="small font-weight-bold">Ditolak: <span><?= $jml_reject ?></span></h4>
						</div>
						<div class="col-auto">
							<i class="fas fa-ticket-alt fa-2x text-primary"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--Process-->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card bg-light text-dark shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">On Process</div>
							<div class="h3 mb-0 font-weight-bold"><?= $jml_process ?></div>
							<h4 class="small font-weight-bold">On Hold: <span><?= $jml_pending ?></span></h4>
						</div>
						<div class="col-auto">
							<i class="fas fa-circle-notch fa-2x text-warning"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--Done-->
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card bg-light text-dark shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">Selesai</div>
							<div class="h3 mb-0 font-weight-bold"><?= $jml_done ?></div>
							<h4 class="small font-weight-bold">&nbsp;<span></span></h4>
						</div>
						<div class="col-auto">
							<i class="fas fa-check-circle fa-2x text-secondary"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-12 col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header font-weight-bold text-primary">
					Tiket Baru (<?= $jml_new ?>)
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
									<th>Prioritas</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($ticket as $row) { ?>
									<tr>
										<td><?= $no ?></td>
										<td><a href="<?= site_url('ticket/detail_approve/'.$row->id_ticket)?>" title="Detail Tiket <?= $row->id_ticket; ?>" class="font-weight-bold"><?= $row->id_ticket ?></a></td>
										<td><?= $row->tanggal ?></td>
										<td><?= $row->nama ?></td>
										<td><?= $row->nama_sub_kategori ?></td>
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

	<div class="row">
		<div class="col-xl-12 col-lg-12">
			<div class="card shadow mb-4">
				<!-- Card Header - Dropdown -->
				<div class="card-header font-weight-bold text-primary">
					Teknisi
				</div>
				<!-- Card Body -->
				<div class="card-body">
					<ul>
						<?php $no = 0;
						foreach ($teknisi as $row) : $no++; ?>
							<i class="fas fa-fw fa-user text-black-100"></i>
							<B class="chat-img pull-left">
								<?= $row->nama; ?>
							</B>
							<div class="chat-body clearfix">
								<?php if ($row->total == null) {
									echo "Ticket Ditugaskan: 0";
								} else {
									echo "Ticket Ditugaskan: $row->total";
								} ?>
								<p></p>
							</div>
							<hr>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<div class="card shadow mb-4">
				<div class="card-header font-weight-bold text-primary">
					Tiket
						(<script type="text/javascript">
							var year = new Date();
							document.write(year.getFullYear());
						</script>)
				</div>
				<!-- Card Body -->
				<div class="card-body">
					<div class="chart-area">
						<canvas id="myAreaChart"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="card shadow mb-4">
				<div class="card-header font-weight-bold text-primary">
					Berdasarkan Prioritas
						(<script type="text/javascript">
							var year = new Date();
							document.write(year.getFullYear());
						</script>)
				</div>
				<!-- Card Body -->
				<div class="card-body">
					<div class="chart-area">
						<canvas id="myPieChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<div class="card shadow mb-4">
				<div class="card-header font-weight-bold text-primary">
					Berdasarkan Sub Kategori
						(<script type="text/javascript">
							var year = new Date();
							document.write(year.getFullYear());
						</script>)
				</div>
				<!-- Card Body -->
				<div class="card-body">
					<div class="chart-area">
						<canvas id="myBarChart"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="card shadow mb-4">
				<div class="card-header font-weight-bold text-primary">
					Berdasarkan Status
						(<script type="text/javascript">
							var year = new Date();
							document.write(year.getFullYear());
						</script>)
				</div>
				<!-- Card Body -->
				<div class="card-body">
					<div class="chart-area">
						<canvas id="myPieChart2"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
//Inisialisasi nilai variabel awal
$subkat 	= "";
$jumlah		= null;

$prioritas 	= "";
$BGprioritas 	= "";
$jprioritas 	= null;

$bulan 		= "";
$Jbulan		= null;

$Tstat     = "";
$BGstat   = "";
$Jstat    = null;

foreach ($lbl_subkat as $data) {
	$sub = $data->nama_sub_kategori;
	$subkat .= "'$sub'" . ", ";
	$jum = $data->total;
	$jumlah .= "$jum" . ", ";
}

foreach ($lbl_prioritas as $data) {
	$id = $data->id_prioritas;
	if ($id == 0) {
		$knds = "Not set yet";
	} else {
		$knds = $data->nama_prioritas;
	}
	$prioritas .= "'$knds'" . ", ";
	$bg = $data->warna;
	$BGprioritas .= "'$bg'" . ", ";
	$jumk = $data->jumprioritas;
	$jprioritas .= "$jumk" . ", ";
}

foreach ($lbl_perbulan as $data) {
	$bul = $data->bulan;
	$bulan .= "'$bul'" . ", ";
	$Jumb = $data->jumbulan;
	$Jbulan .= "$Jumb" . ", ";
}

foreach ($lbl_status as $data) {
	if ($data->status == 0) {
		$stat = "Ticket Rejected";
		$bg = "#F36F13";
	} else if ($data->status == 1) {
		$stat = "Ticket Submited";
		$bg = "#946038";
	} else if ($data->status == 2) {
		$stat = "Category Changed";
		$bg = "#FFB701";
	} else if ($data->status == 3) {
		$stat = "Assigned to Technician";
		$bg = "#A2B969";
	} else if ($data->status == 4) {
		$stat = "On Process";
		$bg = "#0D95BC";
	} else if ($data->status == 5) {
		$stat = "Pending";
		$bg = "#023047";
	} else if ($data->status == 6) {
		$stat = "Solve";
		$bg = "#2E6095";
	} else if ($data->status == 7) {
		$stat = "Late Finished";
		$bg = "#C13018";
	}
	$Tstat  .= "'$stat'" . ", ";
	$BGstat .= "'$bg'" . ", ";
	$jstat   = $data->jumstat;
	$Jstat  .= "$jstat" . ", ";
}
?>

<script type="text/javascript">
	window.onload = function() {
		var Bar = document.getElementById("myBarChart");
		var chart = new Chart(Bar, {
			type: 'horizontalBar',
			data: {
				labels: [<?= $subkat; ?>],
				datasets: [{
					label: 'Total Ticket',
					backgroundColor: "#FC8500",
					hoverBackgroundColor: "#FC8500",
					borderColor: "#4e73df",
					data: [<?= $jumlah; ?>]
				}]
			},
			options: {
				maintainAspectRatio: false,
				tooltips: {
					displayColors: false
				},
				layout: {
					padding: {
						left: 10,
						right: 25,
						top: 25,
						bottom: 0
					}
				},
				scales: {
					xAxes: [{
						ticks: {
							beginAtZero: true,
						}
					}],
					yAxes: [{
						gridLines: {
							display: false,
							drawBorder: false
						},
						maxBarThickness: 25,
					}]
				},
				legend: {
					display: false
				}
			}
		});

		var Line = document.getElementById("myAreaChart");
		var myLineChart = new Chart(Line, {
			type: 'line',
			data: {
				labels: [<?= $bulan; ?>],
				datasets: [{
					label: 'Total Ticket',
					lineTension: 0.3,
					backgroundColor: "transparent",
					borderColor: "#209EEB",
					pointRadius: 3,
					pointBackgroundColor: "#209EEB",
					pointBorderColor: "#209EEB",
					pointHoverRadius: 3,
					pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
					pointHoverBorderColor: "rgba(78, 115, 223, 1)",
					pointHitRadius: 10,
					pointBorderWidth: 2,
					data: [<?= $Jbulan; ?>]
				}],
			},
			options: {
				maintainAspectRatio: false,
				tooltips: {
					displayColors: false
				},
				layout: {
					padding: {
						left: 10,
						right: 25,
						top: 25,
						bottom: 0
					}
				},
				scales: {
					xAxes: [{
						gridLines: {
							display: false,
							drawBorder: false,
						},
						maxBarThickness: 25,
					}],
					yAxes: [{
						ticks: {
							beginAtZero: true,
						}
					}]
				},
				legend: {
					display: false
				}
			}
		});

		var Pie = document.getElementById("myPieChart");
		var myPieChart = new Chart(Pie, {
			type: 'doughnut',
			data: {
				labels: [<?= $prioritas; ?>],
				datasets: [{
					data: [<?= $jprioritas; ?>],
					backgroundColor: [<?= $BGprioritas; ?>],
					hoverBackgroundColor: [<?= $BGprioritas; ?>],
					hoverBorderColor: "rgba(234, 236, 244, 1)",
				}],
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					position: 'right'
				},
				tooltips: {
					borderWidth: 1,
					xPadding: 15,
					yPadding: 15,
					caretPadding: 10,
				},
			},
		});

		var Pie = document.getElementById("myPieChart2");
		var myPieChart = new Chart(Pie, {
			type: 'doughnut',
			data: {
				labels: [<?= $Tstat ?>],
				datasets: [{
					data: [<?= $Jstat; ?>],
					backgroundColor: [<?= $BGstat; ?>],
					hoverBackgroundColor: [<?= $BGstat; ?>],
					hoverBorderColor: "rgba(234, 236, 244, 1)",
				}],
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					position: 'right'
				},
				tooltips: {
					borderWidth: 1,
					xPadding: 15,
					yPadding: 15,
					caretPadding: 10,
				},
			},
		});
	}
</script>