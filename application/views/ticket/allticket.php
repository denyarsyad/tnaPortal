<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

	<!-- Datatable -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<div class="status-filter">
					<select id="status" class="form-control form-control-sm" style="display: inline;float: right;width: 200px;margin-left: 25px;">
						<option value="">Semua Status</option>
						<option value="Ticket Rejected">Ticket Rejected</option>
						<option value="Ticket Submited">Ticket Submited</option>
						<option value="Category Changed">Category Changed</option>
						<option value="Assigned to Technician">Assigned to Technician</option>
						<option value="On Process">On Process</option>
						<option value="Pending">Pending</option>
						<option value="Solve">Solve</option>
						<option value="Late Finished">Late Finished</option>
					</select>
				</div>
				<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>No Ticket</th>
							<th>Status</th>
							<th>Prioritas</th>
							<th>Tanggal</th>
							<th>Deadline</th>
							<th>Nama</th>
							<th>Kategori</th>
							<th>Lokasi</th>
							<th>Subjek</th>
							<th>Diperbarui</th>
							<th>Teknisi</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var save_method; //for save method string
	var table;
	$(document).ready(function() {
		table = $('#dataTable').DataTable({
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?= site_url('ticket/ticket_list') ?>",
				"type": "POST",
				"data": function(data) {
					data.status = $('#status').val();
					console.log(data.status);
				}
			},
			//Set column definition initialisation properties.
			"columnDefs": [{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			}, ],

		});

		$('#status').change(function() { //button filter event click
			table.ajax.reload(); //just reload table
		});

	});

	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax 
	}

	function save() {
		var url;

		url = "<?= site_url('ticket/ticket_save') ?>";

		// ajax adding data to database
		$.ajax({
			url: url,
			type: "POST",
			dataType: "JSON",
			success: function() {
				//if success close modal and reload ajax table
				reload_table();
				Swal.fire(
					'Good Job!',
					'Ticket berhasil',
					'success'
				)
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding data');
			}
		});
	}


	function delete_ticket(id) {
		Swal.fire({
			title: 'Apa anda yakin?',
			text: "Anda tidak akan dapat mengembalikan lagi!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Hapus!'
		}).then((result) => {
			if (result.isConfirmed) {
				// ajax delete data to database
				$.ajax({
					url: "<?= site_url('ticket/ticket_delete') ?>/" + id,
					type: "POST",
					dataType: "JSON",
					success: function(data) {
						//if success reload ajax table
						$('#modal_form').modal('hide');
						reload_table();
						Swal.fire(
							'Deleted!',
							'File Anda telah dihapus.',
							'success'
						);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error delete data');
					}
				});


			}
		})

	}
</script>