<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="container-fluid">
    <h1 class="h3 mb-3 text-gray-800 font-weight-bold"><?= $title; ?></h1>

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('status') ?>"></div>

    <div class="card">

        <div class="card-body">
            <button class="btn btn-primary p-2 mb-4" onclick="save()"><i class="fa fa-plus"></i> Tambah Baru</button>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>File Path</th>
                                    <th>Tanggal</th>
                                    <th class="width-sm"></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<script type="text/javascript">
    var save_method; //for save method string
    var table;
    $(document).ready(function() {
        table = $('#table').DataTable({
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= site_url('backup/backup_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
            }, ],
        });
    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    function save() {
        var url;

        url = "<?= site_url('backup/backup_save') ?>";

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
                    'Backup Database berhasil',
                    'success'
                )
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding data');
            }
        });
    }


    function delete_backup(id) {
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
                    url: "<?= site_url('backup/backup_delete') ?>/" + id,
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