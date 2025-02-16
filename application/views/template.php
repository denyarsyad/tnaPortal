<!--
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
-->
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="IT Helpdesk <?= $this->settings->info['perusahaan']; ?>">
	<meta name="author" content="<?= $this->config->item('site_company'); ?>">
	<title><?= $title ?> | <?= $this->settings->info['aplikasi']; ?> <?= $this->settings->info['perusahaan']; ?></title>
	<link rel="icon" type="image/png" href="<?= base_url('assets/img/') . $this->settings->info['logo']; ?>">

	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Fontawesome -->
	<link href="<?= base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<!-- SB Admin 2 -->
	<link href="<?= base_url() ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
	<!-- Custom Styles -->
	<link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet">
	<!-- Timeline -->
	<link href="<?= base_url() ?>assets/css/timeline.css" rel="stylesheet">
	<!-- Datatables -->
	<link href="<?= base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
	<!-- Fancybox -->
	<link href="<?= base_url() ?>assets/vendor/fancybox/jquery.fancybox.min.css" rel="stylesheet" />
	<!-- jQuery -->
	<script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
	<!-- Sweetalert2 -->
	<script src="<?= base_url() ?>assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
	<!-- Select2 -->
	<link href="<?= base_url() ?>assets/vendor/select2/select2.min.css" rel="stylesheet" />
	<script src="<?= base_url() ?>assets/vendor/select2/select2.min.js"></script>
	<!-- jQuery UI -->
	<link href="<?= base_url() ?>assets/vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet">

	<script>
		$(document).ready(function() {
			$('.select2').select2();
		});
	</script>

	<style type="text/css">
		.signature-pad {
			border: 1px solid #ccc;
			border-radius: 5px;
			width: 100%;
			height: 200px;
		}
		.signature-result {
			width: 100%;
			height: 200px;
		}
	</style>
</head>

<body id="page-top">
	<!-- Page Wrapper -->
	<div id="wrapper">
		<?php
		$this->load->view($sidebar);
		?>
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<?php
				$this->load->view($navbar);
				?>

				<section class="mt-4">
					<?php
					$this->load->view($body);
					?>
				</section>
			</div>
		</div>
	</div>

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="modal-stok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<?= form_open('login/logout'); ?>
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						Are you sure want to log out?
					</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Choose "Log out" button if yes.
				</div>
				<div class="modal-footer" id="ModalFooter">
					<button class="btn btn-primary" type="button" data-dismiss="modal">
						Cancel
					</button>
					<button class="btn btn-danger" type="submit">
						Log Out
					</button>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>

	<!-- Bootstrap -->
	<script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Easing -->
	<script src="<?= base_url() ?>assets/vendor/jquery-easing/jquery.easing.js"></script>
	<!-- SB Admin 2-->
	<script src="<?= base_url() ?>assets/js/sb-admin-2.min.js"></script>
	<!-- Chart.js -->
	<script src="<?= base_url() ?>assets/vendor/chart.js/Chart.min.js"></script>
	<!-- Datatable -->
	<script src="<?= base_url() ?>assets/vendor/datatables/jquery.dataTables.js"></script>
	<script src="<?= base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>
	<script src="<?= base_url() ?>assets/js/demo/datatables-demo.js"></script>
	<!-- Fancybox -->
	<script src="<?= base_url() ?>assets/vendor/fancybox/jquery.fancybox.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?= base_url() ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?= base_url() ?>assets/vendor/signature-pad/signature_pad.min.js"></script>
	<script src="<?= base_url() ?>assets/vendor/signature-pad/signature-pad.js"></script>

	<?php if ($this->session->userdata('level') == "Admin") : ?>
		<script>
			$(document).ready(function() {
				get_jmlnew(); //call function show all product
				get_datanew();

				//function show 
				function get_jmlnew() {
					$.ajax({
						type: 'GET',
						url: '<?= site_url('dashboard/notifikasi') ?>',
						async: false,
						dataType: 'json',
						success: function(data) {
							var html = '';
							if (data.jml_new > 0) {
								html += '<span class="badge badge-danger badge-counter">' + data.jml_new + '+</span>'
							};
							$('#show_jmlnew').html(html);
						}

					});
				}

				//function show 
				function get_datanew() {
					$.ajax({
						type: 'GET',
						url: '<?= site_url('dashboard/notifikasi') ?>',
						async: false,
						dataType: 'json',
						success: function(data) {
							var html = '';
							var i;
							for (i = 0; i < data.ticket.length; i++) {
								html += '<a class="dropdown-item" href="<?= base_url('ticket/detail_approve/'); ?>' + data.ticket[i].id_ticket + '">' +
									'<div class="text-gray-600">' + data.ticket[i].tanggal + '</div>' +
									'<span class="font-weight-bold">No. Tiket: ' + data.ticket[i].id_ticket + ', dari: ' + data.ticket[i].nama + '</span>' +
									'</a>';
							}
							html += '<a class="dropdown-item text-center" href="<?= base_url('ticket/list_approve'); ?>">Lihat Tiket Baru Lainnya</a>';
							$('#show_data').html(html);
						}

					});
				}

			});
		</script>
	<?php endif; ?>

	<script>
		$(document).ready(function() {
			$('.select2').select2();
		});

		/* $(document).ready(function() {
			$("#oke").click(function() {
				var id = $("#mod").text();

				var data = 'id=' + id;

				$.ajax({
					url: "<? //= base_url(); 
							?><? //= $link; 
								?>",
					type: "POST",
					data: data,
					dataType: 'html',
					cache: false,
					success: function(data) {
						location.reload();
					}
				});

			});
		}); */
	</script>

	<script>
		$(function() {
			$("#datepicker").datepicker({
				dateFormat: 'yy-mm-dd'
			});
		});
	</script>
	<script>
		$(function() {
			$("#datepicker2").datepicker({
				dateFormat: 'yy-mm-dd'
			});
		});
	</script>

	<script>
		<?php
		if (isset($modal_show)) {
			echo $modal_show;
		}
		?>
	</script>
</body>

</html>