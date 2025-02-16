<script type="text/javascript">
	$(document).ready(function() {
		$("#id_tahun").change(function() {
			// Put an animated GIF image insight of content	 		
			var data = {
				id_tahun: $("#id_tahun").val()
			};
			$.ajax({
				type: "POST",
				url: "<?= site_url('select/select_tahun') ?>",
				data: data,
				success: function(msg) {
					$('#div-order').html(msg);
				}
			});
		});
	});
</script>

<div class="container-fluid">
	<div class="mb-4">
		<h1 class="h3 mb-0 text-gray-800 font-weight-bold mb-3"><?= $title; ?></h1>
		<a href="#modal-xlsx" class="btn btn-light shadow-sm mr-2" data-toggle="modal">
			<i class="fas fa-download fa-sm text-success"></i> Generate Laporan Excel
		</a>
		<a href="#modal-pdf" class="btn btn-light shadow-sm" data-toggle="modal">
			<i class="fas fa-file-pdf fa-sm text-danger"></i> Generate Laporan PDF
		</a>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header font-weight-bold text-primary">
			Total Tiket
		</div>
		<div class="card-body">
			<div class="chart-area">
				<canvas id="myAreaChart"></canvas>
			</div>
		</div>
	</div>

	<h4 class="mb-3 font-weight-bold text-gray-800">Laporan per Tahun</h4>
	<?= form_dropdown('id_tahun', $dd_tahun, set_value('id_tahun'), 'id="id_tahun" class="form-control mb-3"'); ?>

	<div id="div-order"></div>

</div>

<div id="modal-xlsx" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="m-0 font-weight-bold text-gray-800">Laporan Excel</h5>
			</div>
			<div class="modal-body">
				<form id="form-validation" action="<?= site_url('statistik/report') ?>" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label>Dari Tanggal</label>
						<input class="form-control" name="tgl1" id="datepicker" placeholder="Pilih Tanggal" autocomplete="off" required>
					</div>

					<div class="form-group">
						<label>Sampai Tanggal</label>
						<input class="form-control" name="tgl2" id="datepicker2" placeholder="Pilih Tanggal" autocomplete="off" required>
					</div>
					<button type="submit" class="btn btn-primary" formtarget="_blank">Download</button>
					<button type="button" class="btn btn-danger" class="close" data-dismiss="modal">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="modal-pdf" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="m-0 font-weight-bold text-gray-800">Laporan PDF</h5>
			</div>
			<div class="modal-body">
				<form id="form-validation" action="<?= site_url('statistik/reportPdf') ?>" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label>Dari Tanggal</label>
						<input type="date" class="form-control" name="tgl1" placeholder="Pilih Tanggal" autocomplete="off" required>
					</div>

					<div class="form-group">
						<label>Sampai Tanggal</label>
						<input type="date" class="form-control" name="tgl2" placeholder="Pilih Tanggal" autocomplete="off" required>
					</div>
					<button type="submit" class="btn btn-primary" formtarget="_blank">Download PDF</button>
					<button type="button" class="btn btn-danger" class="close" data-dismiss="modal">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
$tahun 		= "";
$JTahun		= null;

foreach ($stat_tahun as $data) {
	$thn = $data->tahun;
	$tahun .= "'$thn'" . ", ";
	$jlmthn = $data->jumtahun;
	$JTahun .= "$jlmthn" . ", ";
}
?>


<script type="text/javascript">
	window.onload = function(){
		var Line = document.getElementById("myAreaChart");
		var myLineChart = new Chart(Line, {
			type: 'line',
			data: {
				labels: [<?= $tahun; ?>],
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
					data: [<?= $JTahun; ?>]
				}],
			},
			options:{
				maintainAspectRatio: false,
				tooltips: {
					displayColors : false
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
							beginAtZero:true,
						}
					}]
				},
				legend: {
					display: false
				}
			}
		});
	}
</script>